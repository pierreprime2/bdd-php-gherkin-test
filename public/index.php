<?php

declare(strict_types=1);

use App\Http\Controllers\CartController;
use Illuminate\Container\Container;
use Illuminate\Events\Dispatcher;
use Illuminate\Http\Request;
use Illuminate\Routing\Router;

require __DIR__ . '/../vendor/autoload.php';

session_start();

// Container + router Laravel (illuminate/*)
$container = new Container();
$events = new Dispatcher($container);
$router = new Router($events, $container);

// Routes
$router->get('/cart', [CartController::class, 'show']);
$router->post('/cart/items', [CartController::class, 'addItem']);
$router->delete('/cart', [CartController::class, 'clear']);

// Dispatch
$request  = Request::capture();
$response = $router->dispatch($request);
$response->send();
