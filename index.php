<?php
include __DIR__ . '/vendor/autoload.php';

use MeuMicroframework\Http\Controllers\MigrationController;
use MeuMicroframework\Http\Controllers\ExampleController;
use MeuMicroframework\Http\Controllers\ProductCategoryController;
use MeuMicroframework\Http\Middleware\AuthorizationMiddleware;
use MeuMicroframework\Router;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad();

$router = new Router();
$router
    ->on('get', '/migrate', [MigrationController::class, "run"], AuthorizationMiddleware::class)
    ->on('get', '/example', [ExampleController::class, "index"])
    ->on('get', '/example/{id}', [ExampleController::class, "show"]);
echo $router->run($router->method(), $router->uri());

exit();
