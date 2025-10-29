<?php
namespace App\Http\Controllers\Api;

use Symfony\Component\HttpFoundation\JsonResponse;

final class HealthController
{
    public function __construct(private array $app) {}

    public function show(): JsonResponse
    {
        $appEnv   = $this->app['env']['APP_ENV'] ?? 'local';
        $appName  = $this->app['env']['APP_NAME'] ?? 'OneTwoSeven';
        $appVer   = $this->app['env']['APP_VERSION'] ?? 'na';

        $db = [
            'status'      => 'down',
            'latency_ms'  => null,
            'driver'      => 'mysql',
            'host'        => $this->app['env']['DB_HOST'] ?? 'unknown',
            'database'    => $this->app['env']['DB_DATABASE'] ?? 'unknown',
            'server_info' => null,
        ];

        $httpStatus = 200;

        try {
            $start = microtime(true);
            $this->app['db']->getConnection()->select('SELECT 1');
            $db['latency_ms'] = round((microtime(true) - $start) * 1000, 2);
            $verRow = $this->app['db']->getConnection()->select('SELECT VERSION() AS v');
            $db['server_info'] = $verRow[0]->v ?? null;
            $db['status'] = 'up';
        } catch (\Throwable $e) {
            $httpStatus = 503;
            if (($this->app['env']['APP_DEBUG'] ?? 'false') === 'true') {
                $db['error'] = $e->getMessage();
            }
        }

        return new JsonResponse([
            'app'    => $appName,
            'version'=> $appVer,
            'env'    => $appEnv,
            'php'    => PHP_VERSION,
            'status' => ($db['status'] === 'up') ? 'ok' : 'degraded',
            'db'     => $db,
            'time'   => time(),
        ], $httpStatus);
    }
}