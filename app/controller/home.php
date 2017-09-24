<?php

namespace controller;

class home {
    
    protected $container;

    function __construct(\Slim\Container $container) {
        $this->container = $container;
    }

    function dashboard($request, $response, $args) {
        $pending    = $this->container->db->select("systems", ["name", "uid"], ["approved" => false]);
        $approved   = $this->container->db->select("systems", "*", ["approved" => true]);
        $categories = $this->container->db->select("categories", "*");

        $response = $this->container->view->render($response, "dashboard.phtml", [
            "pending"    => $pending,
            "approved"   => $approved,
            "categories" => $categories
        ]);
        return $response;
    }
}