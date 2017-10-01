<?php

final class routes {

    function __construct(\Slim\App $app) {

        $app->group('/hades', function() {
            $this->group('', function() {
                
                $this->get('/', \controller\home::class)->setName('dashboard');
                
                $this->map(['GET', 'PUT', 'DELETE'], '/approve/{id}', \controller\info\approve::class)->setName('approve');
                $this->map(['GET', 'PUT', 'DELETE'], '/system/{id}', \controller\info\system::class)->add(\middleware\info\system::class)->setName('system');
                $this->map(['GET', 'PUT', 'DELETE'], '/group/{id}', \controller\info\group::class)->setName('group');
                
                $this->group('/user', function() {
    
                    $this->post('/logout', \controller\auth\logout::class)->setName('logout');
    
                    $this->map(['GET', 'PUT'], '/register', \controller\auth\register::class)->setName('register');
                    $this->map(['GET', 'PUT'], '/changepass', \controller\auth\changePassword::class)->setName('changePassword');
    
                    $this->map(['GET', 'DELETE'], '/manage', \controller\auth\manage::class)->setName('manageUsers');
    
                })->add(\middleware\auth::class);
            })->add(\middleware\auth::class);
            
            $this->map(['GET', 'POST'], '/login', \controller\auth\login::class)->setName('login');
            $this->get('/api/{tok}[/{name}]', \controller\api::class)->add(\middleware\token::class);
            
        });

    }

}
