<?php
namespace App\Http\Controllers\Web;

use App\Core\View;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class HomeController
{
    public function __construct(private array $app) {}

    public function index(Request $request): Response
    {
        $view = new View($this->app['twig']);
        return $view->render('home.twig', [
            'appName' => $this->app['env']['APP_NAME'] ?? 'OneTwoSeven',
            'env'     => ucfirst($this->app['env']['APP_ENV'] ?? 'local'),
            'ver'    => $this->app['env']['APP_VERSION'] ?? 'na',
            'phpver'  => PHP_VERSION,
            'server'  => $_SERVER['SERVER_SOFTWARE'] ?? '',
        ]);
    }
}