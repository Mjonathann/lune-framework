<?php 
use Lune\Router ;
use Lune\HttpNotFoundException;

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

    $action = $router->resolve($uri, $method);
    print($action());
} catch (HttpNotFoundException $e) {
    print("not found");
    http_response_code(404);
}


