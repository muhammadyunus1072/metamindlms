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

        if($user){
            if($user->role == User::ADMIN){
                return redirect()->route('admin.dashboard.index');
            }
            else if($user->role == User::MEMBER){
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

    public function logout()
    {
        Auth::logout();
        return redirect('');
    }
}
