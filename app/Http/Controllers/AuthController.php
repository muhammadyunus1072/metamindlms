<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use PDO;

class AuthController extends Controller
{
    public function login()
    {
        $user = Auth::user();

        if ($user) {
            if ($user->role == User::ADMIN) {
                return redirect()->route('admin.dashboard.index');
            } else if ($user->role == User::MEMBER) {
                return redirect()->route('member.dashboard.index');
            }
        }

        return view('auth.login');
    }

    public function do_login(Request $request)
    {

        if (request()->ajax()) {
            try {
                $email = $request->email;
                $password = $request->password;

                DB::beginTransaction();

                $results_data = User::where("email", "=", $email)->first();

                if ($results_data) {

                    if (Hash::check($password, $results_data->password)) {

                        if (!$results_data->deleted_at) {

                            if ($results_data->is_actived) {

                                $data = [
                                    'email' => $email,
                                    'password' => $password,
                                ];

                                Auth::attempt($data);

                                if (Auth::check()) {
                                    return response()->json([
                                        "code" => 200,
                                        "response" => [
                                            'type' => 'success',
                                            'title' => 'Login Berhasil!',
                                            'message' => 'Kamu akan segera dialihkan ke halaman utama',
                                        ],
                                    ]);
                                }
                            } else {
                                return response()->json([
                                    "code" => -1,
                                    "response" => [
                                        'type' => 'error',
                                        'title' => 'Login gagal!',
                                        'message' => 'Akun anda dinonaktifkan',
                                    ],
                                ]);
                            }
                        } else {
                            return response()->json([
                                "code" => -1,
                                "response" => [
                                    'type' => 'error',
                                    'title' => 'Login gagal!',
                                    'message' => 'Akun tidak dapat diakses',
                                ],
                            ]);
                        }
                    }
                }

                return response()->json([
                    "code" => -1,
                    "response" => [
                        'type' => 'error',
                        'title' => 'Login gagal!',
                        'message' => 'Email atau password salah.',
                    ],
                ]);
            } catch (Exception $e) {

                DB::rollBack();
                return response()->json([
                    "code" => -1,
                    "response" => [
                        'type' => 'error',
                        'title' => 'Login gagal!',
                        'message' => 'Email atau password salah.',
                    ],
                ]);
            }
        }

        return response()->json([
            "code" => -1,
            "response" => [
                'type' => 'error',
                'title' => 'Login gagal!',
                'message' => 'Email atau password salah.',
            ],
        ]);
    }

    public function register(Request $request)
    {
        $user = Auth::user();

        if ($user) {
            if ($user->role == User::ADMIN) {
                return redirect()->route('admin.dashboard.index');
            } else if ($user->role == User::MEMBER) {
                return redirect()->route('member.dashboard.index');
            }
        }

        return view('auth.register');
    }

    public function do_register(Request $request)
    {
        try {
            $email = $request->email;
            $name = $request->name;
            $phone = $request->phone;
            $birth_place = $request->birth_place;
            $birth_date = $request->birth_date;
            $gender = $request->gender;
            $religion = $request->religion;
            $company_name = $request->company_name;
            $password = $request->password;
            $retype_password = $request->retype_password;

            if (empty($email)) {
                return response()->json([
                    "code" => -1,
                    "response" => [
                        'type' => 'error',
                        'title' => 'Registrasi Gagal',
                        'message' => 'Email Belum Diisi',
                    ],
                ]);
            }
            if (empty($name)) {
                return response()->json([
                    "code" => -1,
                    "response" => [
                        'type' => 'error',
                        'title' => 'Registrasi Gagal',
                        'message' => 'Nama Belum Diisi',
                    ],
                ]);
            }
            if (empty($phone)) {
                return response()->json([
                    "code" => -1,
                    "response" => [
                        'type' => 'error',
                        'title' => 'Registrasi Gagal',
                        'message' => 'Nomor HP Belum Diisi',
                    ],
                ]);
            }
            if (empty($birth_place)) {
                return response()->json([
                    "code" => -1,
                    "response" => [
                        'type' => 'error',
                        'title' => 'Registrasi Gagal',
                        'message' => 'Tempat Lahir Belum Diisi',
                    ],
                ]);
            }
            if (empty($birth_date)) {
                return response()->json([
                    "code" => -1,
                    "response" => [
                        'type' => 'error',
                        'title' => 'Registrasi Gagal',
                        'message' => 'Tanggal Lahir Belum Diisi',
                    ],
                ]);
            }
            if (empty($gender)) {
                return response()->json([
                    "code" => -1,
                    "response" => [
                        'type' => 'error',
                        'title' => 'Registrasi Gagal',
                        'message' => 'Jenis Kelamin Belum Dipilih',
                    ],
                ]);
            }
            if (empty($religion)) {
                return response()->json([
                    "code" => -1,
                    "response" => [
                        'type' => 'error',
                        'title' => 'Registrasi Gagal',
                        'message' => 'Agama Belum Dipilih',
                    ],
                ]);
            }
            if (empty($password)) {
                return response()->json([
                    "code" => -1,
                    "response" => [
                        'type' => 'error',
                        'title' => 'Registrasi Gagal',
                        'message' => 'Password Belum Diisi',
                    ],
                ]);
            }
            if ($retype_password != $password) {
                return response()->json([
                    "code" => -1,
                    "response" => [
                        'type' => 'error',
                        'title' => 'Registrasi Gagal',
                        'message' => 'Ketik Ulang Password Tidak Sama',
                    ],
                ]);
            }

            $user = User::create([
                'email' => $email,
                'name' => $name,
                'role' => User::ROLE_MEMBER,
                'password' => Hash::make($password),
                'phone' => $phone,
                'birth_place' => $birth_place,
                'birth_date' => $birth_date,
                'gender' => $gender,
                'religion' => $religion,
                'company_name' => $company_name,
            ]);

            if ($user) {
                Auth::loginUsingId($user->id);
                return response()->json([
                    "code" => 200,
                    "response" => [
                        'type' => 'success',
                        'title' => 'Registrasi Berhasil',
                        'message' => 'Kamu akan segera dialihkan ke halaman utama',
                    ],
                ]);
            }

            return response()->json([
                "code" => -1,
                "response" => [
                    'type' => 'error',
                    'title' => 'Registrasi Gagal',
                    'message' => 'Registrasi Gagal',
                ],
            ]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                "code" => -1,
                "response" => [
                    'type' => 'error',
                    'title' => 'Login gagal!',
                    'message' => 'Terjadi Kesalahan Pada Sistem',
                ],
            ]);
        }
    }


    public function logout()
    {
        Auth::logout();
        return redirect('');
    }
}
