<?php
use Dotenv\Dotenv;
use Illuminate\Database\Capsule\Manager as Capsule;
use Twig\Environment as TwigEnv;
use Twig\Loader\FilesystemLoader;

require __DIR__ . '/../vendor/autoload.php';

// Env
$dotenv = Dotenv::createImmutable(dirname(__DIR__));
$dotenv->safeLoad();

// DB (Eloquent)
$capsule = new Capsule;
$capsule->addConnection([
    'driver'    => 'mysql',
    'host'      => $_ENV['DB_HOST'] ?? '127.0.0.1',
    'port'      => $_ENV['DB_PORT'] ?? '3306',
    'database'  => $_ENV['DB_DATABASE'] ?? 'onetwoseven',
    'username'  => $_ENV['DB_USERNAME'] ?? 'root',
    'password'  => $_ENV['DB_PASSWORD'] ?? '',
    'charset'   => 'utf8mb4',
    'collation' => 'utf8mb4_unicode_ci',
    'prefix'    => '',
]);
$capsule->setAsGlobal();
$capsule->bootEloquent();

// Twig
$twig = new TwigEnv(
    new FilesystemLoader(dirname(__DIR__).'/app/Views'),
    [
        'cache' => false, // enable later: dirname(__DIR__).'/storage/cache/twig'
        'debug' => ($_ENV['APP_DEBUG'] ?? 'false') === 'true',
    ]
);

return [
    'env'   => $_ENV,
    'db'    => $capsule,
    'twig'  => $twig,
];