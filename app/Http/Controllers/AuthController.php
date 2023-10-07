<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

class AuthController extends Controller
{
    // LOGIN
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
                        if ($results_data->role == User::ROLE_MEMBER && $results_data->email_verified_at == null) {
                            return response()->json([
                                "code" => 201,
                                "response" => [
                                    'type' => 'success',
                                    'title' => 'Verifikasi Email',
                                    'message' => 'Verifikasi Email',
                                ],
                            ]);
                        }

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

    // REGISTER
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
            DB::beginTransaction();
            $validator = Validator::make($request->all(), [
                'captcha' => 'required|captcha'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    "code" => -1,
                    "response" => [
                        'type' => 'error',
                        'title' => 'Registrasi Gagal',
                        'message' => 'Captcha Tidak Sesuai',
                    ],
                ]);
            }

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

            $checkEmail = User::where('email', '=', $email)->first();
            if (!empty($checkEmail)) {
                return response()->json([
                    "code" => -1,
                    "response" => [
                        'type' => 'error',
                        'title' => 'Registrasi Gagal',
                        'message' => 'Email Sudah Terdaftar. Silahkan Gunakan Email Lain atau Lakukan Reset Password',
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

            if (!$user) {
                DB::rollBack();
                return response()->json([
                    "code" => -1,
                    "response" => [
                        'type' => 'error',
                        'title' => 'Registrasi Gagal',
                        'message' => 'Registrasi Gagal',
                    ],
                ]);
            }

            event(new Registered($user));
            DB::commit();
            return response()->json([
                "code" => 200,
                "response" => [
                    'type' => 'success',
                    'title' => 'Registrasi Berhasil',
                    'message' => 'Silahkan Periksa Email Anda Untuk Melakukan Verifikasi',
                ],
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e);
        }
    }

    // EMAIL VERIFICATION
    public function email_verification(Request $request)
    {
        $user = Auth::user();

        if ($user) {
            if ($user->role == User::ADMIN) {
                return redirect()->route('admin.dashboard.index');
            } else if ($user->role == User::MEMBER) {
                return redirect()->route('member.dashboard.index');
            }
        }

        return view('auth.email-verification', ['email' => $request->email]);
    }

    public function email_verification_store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'captcha' => 'required|captcha'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    "code" => -1,
                    "response" => [
                        'type' => 'error',
                        'title' => 'Verifikasi Email',
                        'message' => 'Captcha Tidak Sesuai',
                    ],
                ]);
            }

            $email = $request->email;

            if (empty($email)) {
                return response()->json([
                    "code" => -1,
                    "response" => [
                        'type' => 'error',
                        'title' => 'Verifikasi Email',
                        'message' => 'Email Belum Diisi',
                    ],
                ]);
            }
            $user = User::where('email', '=', $email)->first();
            if (empty($user)) {
                return response()->json([
                    "code" => -1,
                    "response" => [
                        'type' => 'error',
                        'title' => 'Verifikasi Email',
                        'message' => 'Email Belum Terdaftar. Silahkan Lakukan Pendaftaran',
                    ],
                ]);
            }
            if ($user->email_verified_at) {
                return response()->json([
                    "code" => 200,
                    "response" => [
                        'type' => 'success',
                        'title' => 'Verifikasi Email',
                        'message' => 'Email Anda Sudah Diverifikasi. Silahkan Coba Masuk Kembali',
                    ],
                ]);
            }

            $user->sendEmailVerificationNotification();
            return response()->json([
                "code" => 201,
                "response" => [
                    'type' => 'success',
                    'title' => 'Verifikasi Email',
                    'message' => 'Email Verifikasi Berhasil Dikirim. Silahkan Periksa Email Anda',
                ],
            ]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                "code" => -1,
                "response" => [
                    'type' => 'error',
                    'title' => 'Verifikasi Email',
                    'message' => 'Terjadi Kesalahan Pada Sistem',
                ],
            ]);
        }
    }

    public function email_verification_verify(Request $request)
    {
        $user = User::find($request->id);
        if (!hash_equals(sha1($user->getEmailForVerification()), (string) $request->hash)) {
            return redirect()->route('login.index');
        }

        $user->email_verified_at = Carbon::now();
        $user->save();

        Auth::loginUsingId($user->id);

        if ($user->role == User::ADMIN) {
            return redirect()->route('admin.dashboard.index');
        } else if ($user->role == User::MEMBER) {
            return redirect()->route('member.dashboard.index');
        }
    }

    // LOGOUT
    public function logout()
    {
        Auth::logout();
        return redirect('');
    }

    // CAPTCHA
    public function reload_captcha()
    {
        return response()->json(['captcha' => captcha_img()]);
    }

    // FORGOT PASSWORD
    public function forgot_password(Request $request)
    {
        return view('auth.forgot-password');
    }

    public function forgot_password_store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'captcha' => 'required|captcha'
        ]);

        if ($validator->fails()) {
            return response()->json([
                "code" => -1,
                "response" => [
                    'type' => 'error',
                    'title' => 'Lupa Password',
                    'message' => 'Captcha Tidak Sesuai',
                ],
            ]);
        }

        if (empty($request->email)) {
            return response()->json([
                "code" => -1,
                "response" => [
                    'type' => 'error',
                    'title' => 'Lupa Password',
                    'message' => 'Email Belum Diisi',
                ],
            ]);
        }

        $checkEmail = User::where('email', '=', $request->email)->first();
        if (empty($checkEmail)) {
            return response()->json([
                "code" => -1,
                "response" => [
                    'type' => 'error',
                    'title' => 'Lupa Password',
                    'message' => 'Email Belum Terdaftar. Silahkan Lakukan Pendaftaran',
                ],
            ]);
        }

        $status = Password::sendResetLink($request->only('email'));

        if ($status === Password::RESET_LINK_SENT) {
            return response()->json([
                "code" => 200,
                "response" => [
                    'type' => 'success',
                    'title' => 'Lupa Password',
                    'message' => 'Email Reset Password Berhasil Dikirim, Silahkan Periksa Email Anda.',
                ],
            ]);
        } else {
            response()->json([
                "code" => -1,
                "response" => [
                    'type' => 'error',
                    'title' => 'Lupa Password',
                    'message' => 'Email Reset Password Gagal Dikirim',
                ],
            ]);
        }
    }

    // RESET PASSWORD
    public function reset_password(Request $request)
    {
        $user = Auth::user();

        if ($user) {
            if ($user->role == User::ADMIN) {
                return redirect()->route('admin.dashboard.index');
            } else if ($user->role == User::MEMBER) {
                return redirect()->route('member.dashboard.index');
            }
        }

        return view('auth.reset-password', ['token' => $request->token]);
    }

    public function reset_password_store(Request $request)
    {
        $token = $request->token;
        $email = $request->email;
        $password = $request->password;
        $password_confirmation = $request->password_confirmation;

        if (empty($token)) {
            return response()->json([
                "code" => -1,
                "response" => [
                    'type' => 'error',
                    'title' => 'Reset Password',
                    'message' => 'Token Tidak Valid',
                ],
            ]);
        }
        if (empty($email)) {
            return response()->json([
                "code" => -1,
                "response" => [
                    'type' => 'error',
                    'title' => 'Reset Password',
                    'message' => 'Email Belum Diisi',
                ],
            ]);
        }
        if (empty($password)) {
            return response()->json([
                "code" => -1,
                "response" => [
                    'type' => 'error',
                    'title' => 'Reset Password',
                    'message' => 'Password Belum Diisi',
                ],
            ]);
        }
        if ($password_confirmation != $password) {
            return response()->json([
                "code" => -1,
                "response" => [
                    'type' => 'error',
                    'title' => 'Reset Password',
                    'message' => 'Ketik Ulang Password Tidak Sama',
                ],
            ]);
        }

        $user = User::where('email', '=', $request->email)->first();
        if (empty($user)) {
            return response()->json([
                "code" => -1,
                "response" => [
                    'type' => 'error',
                    'title' => 'Reset Password',
                    'message' => 'Email Belum Terdaftar. Silahkan Lakukan Pendaftaran',
                ],
            ]);
        }

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ]);

                $user->email_verified_at = Carbon::now();
                $user->save();

                Auth::loginUsingId($user->id);

                event(new PasswordReset($user));
            }
        );


        if ($status === Password::PASSWORD_RESET) {
            return response()->json([
                "code" => 200,
                "response" => [
                    'type' => 'success',
                    'title' => 'Reset Password',
                    'message' => 'Reset Password Berhasil',
                ],
            ]);
        } else {
            response()->json([
                "code" => -1,
                "response" => [
                    'type' => 'error',
                    'title' => 'Reset Password',
                    'message' => 'Reset Password Gagal',
                ],
            ]);
        }
    }
}
