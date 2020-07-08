<?php

include 'vendor/autoload.php';

$_REQUEST['test1'] = 'one';
$_REQUEST['test2'] = 'two';
$_SERVER['REQUEST_URI'] = '/page';

$request = new Irekk\Controller\Request;
$response = new Irekk\Controller\Response;
$router = new Irekk\Controller\Router;

$router->get('/', function($request, $response) {
    $response->send("It works!");
});
$router->get('/', function($request, $response) {
    $response->send("It works! It really does!");
});
$router->get('/page', function($request, $response) {
    $response->send("hello ");
    $response->send("world\r\n");
    $ts = microtime(1);
    $response->send("$ts\r\n");
    $response->then(function($previous, $promise) {
        // you will not see this as this callback is being added to 
        // promise that is being currently resolved
        $promise->send("I'm busy\r\n");
    });
    $response->then(function($previous, $promise) {
        print "THE END\r\n";
    });
});
$router->dispatch($request->build(), $response);
$response->resolve();
