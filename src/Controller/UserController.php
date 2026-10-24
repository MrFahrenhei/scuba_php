<?php

namespace ScubaPHP\Controller;

use ScubaPHP\Mail\Mailer;
use ScubaPHP\Repository\UserRepository;
use ScubaPHP\Security\Crypt;
use ScubaPHP\Validation\RegisterValidator;
use ScubaPHP\View;

class UserController
{
    public function __construct(
        private View $view,
        private UserRepository $users,
        private RegisterValidator $registerValidator,
        private Mailer $mailer,
        private Crypt $crypt,
        private string $appUrl,
    ) {
    }

    public function register(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && count($_POST) > 0) {
            $user = $_POST['person'];
            $errors = $this->registerValidator->validate($user);

            if (count($errors) > 0) {
                $this->view->render('register', [
                    'name' => htmlspecialchars($user['name'] ?? ''),
                    'email' => htmlspecialchars($user['email'] ?? ''),
                    'error_email' => $errors['email'] ?? '',
                    'error_password' => $errors['password'] ?? '',
                ]);
                return;
            }

            $user = [
                'name' => trim($user['name']),
                'email' => trim($user['email']),
                'password' => password_hash($user['password'], PASSWORD_DEFAULT),
                'mail_validation' => false,
            ];
            $this->users->create($user);
            $this->sendValidationMail($user);

            header('Location: /?page=login&from=register');
            exit;
        }
        $this->view->render('register');
    }

    public function login(): void
    {
        $data = [];

        if (($_GET['from'] ?? '') === 'register') {
            $data['success'] = 'Cadastro realizado! Confirme seu e-mail antes de entrar.';
        }

        $this->view->render('login', $data);
    }

    public function mailValidation(): void
    {
        $email = $this->crypt->decrypt($_GET['token'] ?? '');

        if ($email === false) {
            $this->view->render('login', ['error_email' => 'Link de validação inválido.']);
            return;
        }

        // Teste: no próximo desafio a flag mail_validation será atualizada aqui.
        $this->view->render('login', [
            'success' => 'Teste: token válido para ' . htmlspecialchars($email) . '.',
        ]);
    }

    public function notFound(): void
    {
        http_response_code(404);
        $this->view->render('not_found');
    }

    private function sendValidationMail(array $user): void
    {
        $link = $this->appUrl . '/?page=mail-validation&token=' . $this->crypt->encrypt($user['email']);

        $this->mailer->send(
            $user['email'],
            'Confirme seu email no ScubaPHP',
            $this->view->fetch('mail_validation', [
                'name' => htmlspecialchars($user['name']),
                'link' => htmlspecialchars($link),
            ]),
        );
    }
}
