<?php
namespace App\Core;

use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

final class View
{
    public function __construct(private Environment $twig) {}
    public function render(string $template, array $data = [], int $status = 200): Response
    {
        $html = $this->twig->render($template, $data);
        return new Response($html, $status, ['Content-Type'=>'text/html; charset=UTF-8']);
    }
}