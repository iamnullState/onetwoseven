<?php
use Dotenv\Dotenv;
use Illuminate\Database\Capsule\Manager as Capsule;

require __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv::createImmutable(dirname(__DIR__));
$dotenv->safeLoad();

$capsule = new Capsule;
$capsule->addConnection([
    'driver' => 'mysql',
    'host' => $_ENV['DB_HOST'] ?? '127.0.0.1',
    'database' => $_ENV['DB_DATABASE'] ?? 'onetwoseven',
    'username' => $_ENV['DB_USERNAME'] ?? 'root',
    'password' => $_ENV['DB_PASSWORD'] ?? '',
    'charset' => 'utf8mb4',
    'collation' => 'utf8mb4_unicode_ci',
]);
$capsule->setAsGlobal();
$capsule->bootEloquent();

return ['db' => $capsule];