<?php

namespace controller;

class tickets {
    
    protected $container;

    function __construct(\Slim\Container $container) {
        $this->container = $container;
    }

    function hello($request, $response) {
        $this->container->logger->addInfo("Ticket list");
        $tickets = ["a" => "b"];
        $response = $this->container->view->render($response, "tickets.phtml", ["tickets" => $tickets]);
        return $response;
    }
}