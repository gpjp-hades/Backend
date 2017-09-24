<?php

namespace controller;

class home {
    
    protected $container;

    function __construct(\Slim\Container $container) {
        $this->container = $container;
    }

    function dashboard($request, $response, $args) {
        //$this->container->logger->addInfo("Ticket list");
        
        $response = $this->container->view->render($response, "dashboard.phtml");
        return $response;
    }
}