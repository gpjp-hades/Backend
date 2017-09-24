<?php

/**
 * 
 * BootStrap
 *
 * Let's get us rolling!
 * 
 * @package  Hades
 * @author   Keombre <keombre@gmail.com>
 */

namespace hades\bootstrap;

putenv("ROOT=/hades/public/");

require __DIR__."/autoload.php";
new autoload();

$router = new \hades\routes\router();
$display = new \hades\app\display($router);

$html = $display->html();

return $html;