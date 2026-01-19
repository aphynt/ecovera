<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class MailerController extends Controller {

    // =============== [ Email ] ===================
    public function email() {
        return view("email");
    }


    // ========== [ Compose Email ] ================
    public function sendResetLink(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        $token = Str::random(64);

        DB::table('password_resets')->updateOrInsert(
            ['email' => $request->email],
            [
                'token' => hash('sha256', $token),
                'created_at' => now(),
            ]
        );

        $resetLink = url('/reset-password/'.$token.'?email='.$request->email);

        // === KIRIM EMAIL ===
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
            'name'      => 'Pengguna',
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


}
