<?php

function do_register()
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && count($_POST) > 0) {
        $user = $_POST['person'];
        $errors = validate_register($user);

        if (count($errors) > 0) {
            render_view('register', [
                'name' => htmlspecialchars($user['name'] ?? ''),
                'email' => htmlspecialchars($user['email'] ?? ''),
                'error_email' => $errors['email'] ?? '',
                'error_password' => $errors['password'] ?? '',
            ]);
            return;
        }

        crud_create([
            'name' => trim($user['name']),
            'email' => trim($user['email']),
            'password' => password_hash($user['password'], PASSWORD_DEFAULT),
        ]);

        header('Location: /?page=login');
        exit;
    }
    render_view('register');
}

function do_login()
{
    render_view('login');
}

function do_not_found()
{
    http_response_code(404);
    render_view('not_found');
}
