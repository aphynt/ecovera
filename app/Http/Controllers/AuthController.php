<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Postmark\PostmarkClient;
use PHPMailer\PHPMailer\PHPMailer;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;

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

            $user = Auth::user();

            // Redirect based on user role
            if ($user->role === 'admin') {
                return redirect()->intended('/admin/dashboard');
            } else {
                // For buyer and seller, redirect to home
                return redirect()->intended('/');
            }
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
        $mail->Host = 'ecovera.id';
        $mail->SMTPAuth = true;
        $mail->AuthType = 'LOGIN';
        $mail->Username = 'no-reply@ecovera.id';
        $mail->Password = 'sims100%';
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

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

    public function registerProcess(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'nim' => 'required',
            'instansi' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
        ], [
            'name.required' => 'Nama wajib diisi.',
            'nim.required' => 'NIM wajib diisi.',
            'instansi.required' => 'Instansi wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah terdaftar.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 8 karakter.',
        ]);

        $token = Str::random(64);

        $user = User::create([
            'name' => $request->name,
            'nim' => $request->nim,
            'instansi' => $request->instansi,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'buyer', // Default role for registration
            'is_active' => false,
            'verification_token' => $token,
        ]);

        Mail::send('auth.emails.verify-email', [
            'name' => $user->name,
            'verificationLink' => route('verify.email', $token)
        ], function ($message) use ($user) {
            $message->to($user->email);
            $message->subject('Verifikasi Email Anda');
        });

        return redirect()->route('email.sent')->with('email', $request->email);
    }

    public function emailSent()
    {
        return view('auth.verify-email');
    }

    public function verifyEmail($token)
    {
        $user = User::where('verification_token', $token)->first();

        if (!$user) {
            return redirect()->route('login')->with('info', 'Token verifikasi tidak valid atau sudah digunakan.');
        }

        $user->email_verified_at = now();
        $user->is_active = true;
        // Keep verification_token null after successful verification
        $user->verification_token = null;
        $user->save();

        return redirect()->route('login')->with('success', 'Email berhasil diverifikasi. Silakan login.');
    }
    public function resendVerification(Request $request)
    {
        $email = $request->email ?? session('email');

        if (!$email) {
            return redirect()->route('login')->with('info', 'Sesi kadaluarsa. Silakan login ulang atau daftar kembali.');
        }

        $user = User::where('email', $email)->first();

        if (!$user) {
            return back()->with('error', 'Email tidak ditemukan.');
        }

        if ($user->hasVerifiedEmail()) {
            return redirect()->route('login')->with('info', 'Email Anda sudah diverifikasi. Silakan login.');
        }

        $token = $user->verification_token;

        // If for some reason token is null but not verified (shouldn't happen given logic), regenerate
        if (!$token) {
            $token = Str::random(64);
            $user->verification_token = $token;
            $user->save();
        }

        Mail::send('auth.emails.verify-email', [
            'name' => $user->name,
            'verificationLink' => route('verify.email', $token)
        ], function ($message) use ($user) {
            $message->to($user->email);
            $message->subject('Verifikasi Email Anda');
        });

        return back()->with('message', 'Link verifikasi baru telah dikirim ke email Anda.')->with('email', $email);
    }
}
