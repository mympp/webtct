<?php
require '../../../common.inc.php';
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require '/vendor/autoload.php';
require '/controller/IndexController.php';
require '/controller/ProductController.php';
require '../../../include/tcdb.class.php';
require 'config/config.php';

$app = new \Slim\App;

$app->get('/','\IndexController:index');
$app->get('/index.html','\IndexController:index');
$app->get('/plist.html','\ProductController:plist');
$app->get('/plist-{typeid}.html','\ProductController:type');
$app->post('/plist.html','\ProductController:keyword');
$app->get('/product-{itemid}.html','\ProductController:product');

$app->run();

?>