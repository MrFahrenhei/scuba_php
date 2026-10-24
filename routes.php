<?php

use ScubaPHP\Controller\UserController;
use ScubaPHP\Mail\Mailer;
use ScubaPHP\Repository\UserRepository;
use ScubaPHP\Security\Crypt;
use ScubaPHP\Validation\RegisterValidator;
use ScubaPHP\View;

$users = new UserRepository(DATA_LOCATION);
$controller = new UserController(
    new View(VIEW_FOLDER),
    $users,
    new RegisterValidator($users),
    new Mailer(MAIL_HOST, MAIL_PORT, MAIL_ENCRYPTION, MAIL_USERNAME, MAIL_PASSWORD, MAIL_FROM, MAIL_FROM_NAME),
    new Crypt(APP_KEY),
    APP_URL,
);

$page = $_GET['page'] ?? 'login';

switch ($page) {
    case 'login':
        $controller->login();
        break;
    case 'register':
        $controller->register();
        break;
    case 'mail-validation':
        $controller->mailValidation();
        break;
    default:
        $controller->notFound();
        break;
}
