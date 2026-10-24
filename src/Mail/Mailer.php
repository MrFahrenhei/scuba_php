<?php

namespace ScubaPHP\Mail;

use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

class Mailer
{
    public function __construct(
        private string $host,
        private int $port,
        private string $encryption,
        private string $username,
        private string $password,
        private string $from,
        private string $fromName,
    ) {
    }

    public function send(string $to, string $subject, string $body): bool
    {
        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host = $this->host;
            $mail->Port = $this->port;
            $mail->SMTPAuth = $this->username !== '';
            $mail->Username = $this->username;
            $mail->Password = $this->password;
            $mail->SMTPSecure = $this->encryption;
            $mail->SMTPAutoTLS = $this->encryption !== '';
            $mail->CharSet = PHPMailer::CHARSET_UTF8;

            $mail->setFrom($this->from, $this->fromName);
            $mail->addAddress($to);
            $mail->isHTML();
            $mail->Subject = $subject;
            $mail->Body = $body;

            return $mail->send();
        } catch (Exception $e) {
            error_log('Falha ao enviar email: ' . $mail->ErrorInfo);
            return false;
        }
    }
}
