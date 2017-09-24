<?php

require '../vendor/autoload.php';

use Psr\Http\Message\RequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

$config['displayErrorDetails'] = true;
$config['db']['type']   = "sqlite";
$config['db']['file'] = "../database/database.db";

$app = new \Slim\App(["settings" => $config]);
$container = $app->getContainer();

//remove trailing slash
$app->add(function (Request $request, Response $response, callable $next) {
    $uri = $request->getUri();
    $path = $uri->getPath();
    if ($path != '/' && substr($path, -1) == '/') {
        $uri = $uri->withPath(substr($path, 0, -1));
        
        if($request->getMethod() == 'GET') {
            return $response->withRedirect((string)$uri, 301);
        }
        else {
            return $next($request->withUri($uri), $response);
        }
    }

    return $next($request, $response);
});

$container['view'] = new \Slim\Views\PhpRenderer("../templates/");

$container['logger'] = function($c) {
    $logger = new \Monolog\Logger('my_logger');
    $file_handler = new \Monolog\Handler\StreamHandler("../logs/app.log");
    $logger->pushHandler($file_handler);
    return $logger;
};

$container['db'] = function ($c) {
    $db = $c['settings']['db'];
    $medoo = new \Medoo\Medoo([
        'database_type' => $db['type'],
        'database_file' => $db['file']
    ]);
    return $medoo;
};

$container['seed'] = function ($c) {
    $seed = new \database\seed($c);
    return $seed;
};

$container->seed->update();

return $app;