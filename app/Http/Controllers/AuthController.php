<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Postmark\PostmarkClient;
use PHPMailer\PHPMailer\PHPMailer;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    //
    public function login()
    {
        return view('auth.login');
    }

    public function loginProcess(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ], [
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 6 karakter.',
        ]);

        if (
            Auth::attempt([
                'email' => $request->email,
                'password' => $request->password,
                'is_active' => true,
            ])
        ) {
            $request->session()->regenerate();
            return redirect()->intended('/');
        }

        return back()->with('info', 'Email, password salah, atau akun belum aktif.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }

    public function register()
    {
        return view('auth.register');
    }

    public function registerProcess(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'nim' => 'required|string|max:50',
            'instansi' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'role' => 'required|in:buyer,seller',
        ], [
            'name.required' => 'Nama wajib diisi.',
            'nim.required' => 'NIM wajib diisi.',
            'instansi.required' => 'Instansi wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.unique' => 'Email sudah terdaftar.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'role.required' => 'Role wajib dipilih.',
            'role.in' => 'Role tidak valid.',
        ]);

        $user = User::create([
            'uuid' => Str::uuid(),
            'name' => $request->name,
            'nim' => $request->nim,
            'instansi' => $request->instansi,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'is_active' => false,
        ]);

        // event(new Registered($user));

        // Auth::login($user);

        return redirect('/login')->with('info', 'Registrasi berhasil. Akun Anda menunggu persetujuan admin.');
    }

    public function verifyEmailPrompt()
    {
        return view('auth.verify-email');
    }

    public function verifyEmailHandler(EmailVerificationRequest $request)
    {
        $request->fulfill();

        return redirect('/dashboard')->with('success', 'Email berhasil diverifikasi!');
    }

    public function verifyEmailResend(Request $request)
    {
        $request->user()->sendEmailVerificationNotification();

        return back()->with('message', 'Link verifikasi telah dikirim ulang!');
    }

    public function forgotPassword()
    {
        return view('auth.forgot-password');
    }

    public function sendResetLink(Request $request)
    {
        $request->validate(
            [
                'email' => 'required|email|exists:users,email',
            ],
            [
                'email.exists' => 'Email tidak ditemukan'
            ]
        );

        $token = Str::random(64);

        DB::table('password_resets')->updateOrInsert(
            ['email' => $request->email],
            [
                'token' => hash('sha256', $token),
                'created_at' => now(),
            ]
        );

        $user = User::where('email', $request->email)->first();

        $resetLink = url('/reset-password/' . $token . '?email=' . $request->email);

        $mail = new PHPMailer(true);

        $mail->isSMTP();
        $mail->Host = env('MAIL_HOST', 'mx.emailarray.com');
        $mail->SMTPAuth = true;
        $mail->AuthType = 'LOGIN';
        $mail->Username = env('MAIL_USERNAME', 'no-reply@ecovera.id');
        $mail->Password = env('MAIL_PASSWORD');
        $mail->SMTPSecure = 'tls';
        $mail->Port = env('MAIL_PORT', 587);

        $html = view('auth.emails.forgot-password', [
            'name' => $user->name,
            'resetLink' => $resetLink
        ])->render();

        $mail->setFrom('no-reply@ecovera.id', 'Ecovera');
        $mail->addAddress($request->email);
        $mail->isHTML(true);
        $mail->Subject = 'Reset Password';
        $mail->Body = $html;
        $mail->send();

        return back()->with('success', 'Link reset password telah dikirim.');
    }

    public function resetPassword($token)
    {
        return view('auth.reset-password', compact('token'));
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required|min:8|confirmed',
            'token' => 'required',
        ]);

        $record = DB::table('password_resets')
            ->where('email', $request->email)
            ->where('token', hash('sha256', $request->token))
            ->first();

        if (!$record) {

            return back()->withErrors(['info' => 'Token tidak valid atau sudah kadaluarsa']);
        }

        User::where('email', $request->email)
            ->update(['password' => Hash::make($request->password)]);

        DB::table('password_resets')->where('email', $request->email)->delete();

        return redirect('/login')->with('success', 'Password berhasil diubah.');
    }
}
