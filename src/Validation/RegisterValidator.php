<?php

namespace ScubaPHP\Validation;

use ScubaPHP\Repository\UserRepository;

class RegisterValidator
{
    public function __construct(private UserRepository $users)
    {
    }

    public function validate(array $data): array
    {
        $errors = [];

        $email = trim($data['email'] ?? '');
        $password = $data['password'] ?? '';
        $confirmation = $data['password-confirm'] ?? '';

        if ($this->users->findByEmail($email) !== false) {
            $errors['email'] = 'Este email já está cadastrado.';
        }

        if (strlen($password) <= 10) {
            $errors['password'] = 'A senha deve ter mais de 10 caracteres.';
        } elseif ($password !== $confirmation) {
            $errors['password'] = 'As senhas não conferem.';
        }

        return $errors;
    }
}
