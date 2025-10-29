<?php
use Symfony\Component\HttpFoundation\JsonResponse;

$app = require __DIR__ . '/../bootstrap/app.php';

$response = new JsonResponse([
    'app' => 'OneTwoSeven',
    'status' => 'ok',
    'time' => time(),
]);
$response->send();