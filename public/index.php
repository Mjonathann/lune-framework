<?php 
require '../vendor/autoload.php';
use Lune\Router;
use Lune\HttpNotFoundException;
use Lune\Request;
use Lune\Route;
use Lune\Server;

$router = new Router();

$router->get('/test', function () {
    return "GET OK";
});

$router->post('/test', function () {
    return "POST OK";
});

$router->put('/test', function () {
    return "PUT OK";
});

$router->patch('/test', function () {
    return "PATCH OK";
} );

$router->delete('/test', function () {
    return "DELETE OK";
});

try {
    $method = $_SERVER['REQUEST_METHOD'];
    $uri = $_SERVER['REQUEST_URI'];

    $route = $router->resolve(new Request(new Server()));
    $action = $route->action();
    print($action()); 
} catch (HttpNotFoundException $e) {
    print("not found");
    http_response_code(404);
}


