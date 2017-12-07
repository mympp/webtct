<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

define('BaseRoot', __DIR__);

require './vendor/autoload.php';


$configuration = [
    'settings' => [
        'displayErrorDetails' => false,
        'addContentLengthHeader' => false,
    ],
];
$c = new \Slim\Container($configuration);
$app = new \Slim\App($c);

//$app = new \Slim\App;

$app->get('/','\source\page\IndexPage:index');
$app->get('/plist.html' , '\source\page\ProductPage:plist');
$app->get('/plist-{typeid}.html' , '\source\page\ProductPage:plist');
$app->get('/product-{itemid}.html' ,'\source\page\ProductPage:product');
$app->get('/test.html' , '\source\page\IndexPage:test');

$app->run();

?>