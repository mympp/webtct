<?php
/**
 * Created by PhpStorm.
 * User: wusiyuan
 * Date: 16/8/30
 * Time: 下午3:35
 */

// include our OAuth2 Server object
require_once __DIR__.'/server.php';
$server->handleTokenRequest(OAuth2\Request::createFromGlobals())->send();