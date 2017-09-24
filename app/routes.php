<?php

final class routes {

    function __construct(\Slim\App $app) {

        $app->group('/hades', function() {
            
            $this->get('/api/{token}[/{name}]', \controller\api::class)->add(\middleware\token::class);

            $this->get('/', \controller\home::class . ':dashboard')->add(\middleware\auth::class)->setName('dashboard');
            
            $this->map(['GET', 'POST'], '/login', \controller\auth\login::class)->setName('login');
            $this->group('/user', function() {
/*
                $this->post('/logout', \controller\auth::class . ':logout')->setName('logout');
                $this->map(['GET', 'PUT'], '/register', \controller\auth::class . ':register')->setName('register');
                $this->map(['GET', 'DELETE'], '/manage', \controller\auth::class . ':manage')->setName('manage');
*/
            })->add(\middleware\auth::class);

        });

    }

}
