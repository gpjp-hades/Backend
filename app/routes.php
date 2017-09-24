<?php

final class routes {

    function __construct(\Slim\App $app) {

        $app->group('/hades', function() {
            
            //api
            $this->get('/api/{token}[/{name}]', \controller\api::class)->add(\middleware\token::class);

            //dashboard
            $this->get('/', \controller\home::class . ':dashboard')->add(\middleware\auth::class)->setName('dashboard');
            
            //auth
            $this->map(['GET', 'POST'], '/login', \controller\auth\login::class)->setName('login');
            $this->group('/user', function() {

                //logout
                $this->post('/logout', \controller\auth\logout::class)->setName('logout');

                $this->map(['GET', 'PUT'], '/register', \controller\auth\register::class)->setName('register');
                $this->map(['GET', 'PUT'], '/changepass', \controller\auth\changePassword::class)->setName('changePassword');

                $this->map(['GET', 'DELETE'], '/manage', \controller\auth\manage::class)->setName('manageUsers');

            })->add(\middleware\auth::class);

        });

    }

}
