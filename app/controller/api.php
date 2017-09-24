<?php

namespace controller;

final class api {
    
    protected $container;
    private const sleep = 0;

    function __construct(\Slim\Container $container) {
        $this->container = $container;
    }

    function __invoke($request, $response, $args) {
        
        if (!$this->container->db->has("systems", ["uid" => $args['token']])) {

            $name = $this->escapeName(@$args['name']);
            $this->container->db->insert("systems", [
                "uid" => $args['token'],
                "name" => $name ? $name : null,
                "lastActive" => time()
            ]);

            $this->container->logger->addInfo("Api call - new:pending");
            return $response->withJson(["result" => "request pending"]);
        } else if ($this->container->db->has("systems", ["uid" => $args['token'], "approved" => false])) {

            $this->container->logger->addInfo("Api call - known:pending");
            return $response->withJson(["result" => "request pending"]);
        } else {

            $config = $this->container->db->get("systems", 
                ["[>]categories" => ["category" => "id"]], 
                "categories.config",
                ["pc.uid" => $this->token]
            );
            $this->container->logger->addInfo("Api call - known:config");
            return $response->withJson(["result" => "approved", "config" => $config['config']]);
        }
    }

    function escapeName($name) {
        return preg_replace('/[^\x20-\x7E]/','', $name);
    }
}