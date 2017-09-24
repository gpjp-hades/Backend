<?php

final class routes {
    function __construct(\Slim\App $app) {
        $app->group('/slim', function() {
            $this->get('/tickets', \controller\tickets::class . ':hello')->add(\middleware\example::class);
            
            $this->get('/api/{token}[/{name}]', \controller\api::class . ':token')->add(\middleware\token::class);
        });
    }
}