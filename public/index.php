<?php
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

$app = require __DIR__ . '/../bootstrap/app.php';

$request = Request::createFromGlobals();

$dispatcher = FastRoute\simpleDispatcher(function(FastRoute\RouteCollector $r) {
    // API v1
    $r->addGroup('/api/v1', function(FastRoute\RouteCollector $r) {
        $r->addRoute('GET', '/health', [\App\Http\Controllers\Api\HealthController::class, 'show']);
        // add more API routes here e.g. /devices, /ips ...
    });

    // Web
    $r->addRoute('GET', '/', [\App\Http\Controllers\Web\HomeController::class, 'index']);
});

$routeInfo = $dispatcher->dispatch($request->getMethod(), $request->getPathInfo());
switch ($routeInfo[0]) {
    case FastRoute\Dispatcher::NOT_FOUND:
        (new JsonResponse(['error' => 'Not Found'], 404))->send();
        break;

    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        (new JsonResponse(['error' => 'Method Not Allowed'], 405))->send();
        break;

    case FastRoute\Dispatcher::FOUND:
        [$class, $method] = $routeInfo[1];
        $vars = $routeInfo[2] ?? [];

        if (!class_exists($class)) {
            (new JsonResponse(['error'=>'Controller not found'], 500))->send();
            break;
        }

        $controller = new $class($app);
        $response = $controller->$method($request, $vars);

        if ($response instanceof Response) {
            $response->send();
        } else {
            // Fallback: send JSON
            (new JsonResponse($response))->send();
        }
        break;
}