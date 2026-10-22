<?php

$page = $_GET['page'] ?? 'login';

switch ($page) {
    case 'login':
        do_login();
        break;
    case 'register':
        do_register();
        break;
    default:
        do_not_found();
        break;
}