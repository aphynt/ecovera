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
            'email'    => 'required|email',
            'password' => 'required|min:6',
        ], [
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 6 karakter.',
        ]);

        if (Auth::attempt([
            'email' => $request->email,
            'password' => $request->password,
            'is_active' => true,
        ])) {
            $request->session()->regenerate();

            $user = Auth::user();

            // Redirect based on user role
            if ($user->role === 'admin' || $user->role === 'seller') {
                return redirect()->intended('/admin/dashboard');
            } else {
                // For buyer, redirect to home
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
        $mail->Host       = 'ecovera.id';
        $mail->SMTPAuth   = true;
        $mail->AuthType   = 'LOGIN';
        $mail->Username   = 'no-reply@ecovera.id';
        $mail->Password   = 'sims100%';
        $mail->SMTPSecure = 'tls';
        $mail->Port       = 587;

        $html = view('auth.emails.forgot-password', [
            'name'      => $user->name,
            'resetLink' => $resetLink
        ])->render();

        $mail->setFrom('no-reply@ecovera.id', 'Ecovera');
        $mail->addAddress($request->email);
        $mail->isHTML(true);
        $mail->Subject = 'Reset Password';
        $mail->Body    = $html;
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
            'email'    => 'required|email|exists:users,email',
            'password' => 'required|min:8|confirmed',
            'token'    => 'required',
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
