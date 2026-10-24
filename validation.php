<?php
function validate_register($data)
{
    $errors = [];

    $email = trim($data['email'] ?? '');
    $password = $data['password'] ?? '';
    $confirmation = $data['password-confirm'] ?? '';

    if (crud_find_by_email($email) !== false) {
        $errors['email'] = 'Este email já está cadastrado.';
    }

    if (strlen($password) <= 10) {
        $errors['password'] = 'A senha deve ter mais de 10 caracteres.';
    } elseif ($password !== $confirmation) {
        $errors['password'] = 'As senhas não conferem.';
    }

    return $errors;
}