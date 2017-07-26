<?php
/**
 * Created by PhpStorm.
 * User: wusiyuan
 * Date: 16/8/30
 * Time: 下午4:51
 */

$dsn      = 'mysql:host=188.188.1.218;port=53306;dbname=tctedata2';
$username = 'root';
$password = 'tece218';
// error reporting (this is a demo, after all!)
ini_set('display_errors',1);error_reporting(E_ALL);

require 'vendor/autoload.php';

//引入天成自定义的pdo处理程序
require 'tecenet/Storage/tcPdo.php';

// $dsn is the Data Source Name for your database, for exmaple "mysql:dbname=my_oauth2_db;host=localhost"
//$storage = new OAuth2\Storage\Pdo(array('dsn' => $dsn, 'username' => $username, 'password' => $password));
$storage = new tcPdo(array('dsn' => $dsn, 'username' => $username, 'password' => $password),array('user_table' => 'tc_member'));

// Pass a storage object or array of storage objects to the OAuth2 server class
$server = new OAuth2\Server($storage);

// Add the "Client Credentials" grant type (it is the simplest of the grant types)
$server->addGrantType(new OAuth2\GrantType\ClientCredentials($storage));

// Add the "Authorization Code" grant type (this is where the oauth magic happens)
$server->addGrantType(new OAuth2\GrantType\AuthorizationCode($storage));

//增加password模式的验证
$server->addGrantType(new OAuth2\GrantType\UserCredentials($storage));
