<?php
define('SLASH',DIRECTORY_SEPARATOR);
define('VIEW_FOLDER',__DIR__.SLASH.'view'.SLASH);
define('DATA_LOCATION',__DIR__.SLASH.'data'.SLASH.'users.json');

// Dados sensíveis ficam no .env (fora do git), nunca no código-fonte.
$env = file_exists(__DIR__.SLASH.'.env') ? parse_ini_file(__DIR__.SLASH.'.env') : [];
$env = array_merge($env, getenv());

define('APP_URL', $env['APP_URL'] ?? 'http://localhost:4242');
define('APP_KEY', $env['APP_KEY'] ?? '');

define('MAIL_HOST', $env['MAIL_HOST'] ?? 'smtp.gmail.com');
define('MAIL_PORT', (int) ($env['MAIL_PORT'] ?? 587));
// tls (porta 587), ssl (porta 465) ou vazio para servidores locais de teste
define('MAIL_ENCRYPTION', $env['MAIL_ENCRYPTION'] ?? 'tls');
define('MAIL_USERNAME', $env['MAIL_USERNAME'] ?? '');
define('MAIL_PASSWORD', $env['MAIL_PASSWORD'] ?? '');
define('MAIL_FROM', $env['MAIL_FROM'] ?? MAIL_USERNAME);
define('MAIL_FROM_NAME', $env['MAIL_FROM_NAME'] ?? 'ScubaPHP');
