<?php

final class routes {
    function __construct(\Slim\App $app) {
        $app->group('/hades', function() {
            $this->get('/', \controller\home::class . ':dashboard')->add(\middleware\auth::class)->setName('dashboard');
            $this->get('/api/{token}[/{name}]', \controller\api::class)->add(\middleware\token::class);
        });
    }
}
