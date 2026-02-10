<?php

namespace App\Helpers;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class MailHelper
{
    public static function send($to, $subject, $view, $data = [])
    {
        $mail = new PHPMailer(true);

        try {
            // Server settings
            $mail->isSMTP();
            $mail->Host = 'ecovera.id';
            $mail->SMTPAuth = true;
            $mail->AuthType = 'LOGIN';
            $mail->Username = 'no-reply@ecovera.id';
            $mail->Password = 'sims100%';
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            // Recipients
            $mail->setFrom('no-reply@ecovera.id', 'Ecovera');
            $mail->addAddress($to);

            // Content
            $html = view($view, $data)->render();
            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body = $html;

            $mail->send();
            return true;
        } catch (Exception $e) {
            // Log error if needed
            \Log::error("Message could not be sent. Mailer Error: {$mail->ErrorInfo}");
            return false;
        }
    }
}
