<?php

/**
 * Hades - Universal config delivery manager
 *
 * @package  Hades
 * @author   Keombre <keombre@gmail.com>
 */

define('HADES_START', microtime(true));

// Prepare routing

$app = require_once __DIR__.'/../bootstrap/app.php';

// Start the application

var_dump($_SERVER["REQUEST_URI"]);

class base extends \hades\base {
    
}