<?php

namespace controller\info;

class group {
    
    use \controller\sendResponse;
    
    protected $container;

    function __construct(\Slim\Container $container) {
        $this->container = $container;
    }

    function dashboard($request, $response, $args) {
        $pending    = $this->container->db->select("systems", ["name", "uid"], ["approved" => false]);
        $approved   = $this->container->db->select("systems", "*", ["approved" => true]);
        $categories = $this->container->db->select("categories", "*");

        $response = $this->sendResponse($request, $response, "dashboard.phtml", [
            "pending"    => $pending,
            "approved"   => $approved,
            "categories" => $categories
        ]);
        return $response;
    }
}