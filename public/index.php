<?php

/**
 * Hades - Universal config delivery manager
 *
 * @package  Hades
 * @author   Keombre <keombre@gmail.com>
 */

define('HADES_START', microtime(true));

// Start the application

$app = require_once __DIR__.'/../bootstrap/app.php';

// Display output

echo $app;