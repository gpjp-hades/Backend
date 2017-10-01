<?php

namespace controller;

final class api {
    
    protected $container;
    protected $token;

    function __construct(\Slim\Container $container) {
        $this->container = $container;
    }

    function __invoke($request, $response) {
        
        $this->token = $request->getAttribute("token");
        $this->name  = $request->getAttribute("name");
        
        if (!$this->container->db->has("systems", ["uid" => $this->token])) {

            $this->container->db->insert("systems", [
                "uid" => $this->token,
                "name" => $this->name,
                "lastActive" => time()
            ]);

            $this->container->logger->addInfo("Api call - new:pending");
            return $response->withJson(["result" => "request pending"]);
        } else if ($this->container->db->has("systems", ["uid" => $this->token, "approved" => false])) {

            $this->container->db->update("systems", ["lastActive" => time()], ["uid" => $this->token]);
            $this->container->logger->addInfo("Api call - known:pending");
            return $response->withJson(["result" => "request pending"]);
        } else {

            $config = $this->container->db->get("systems", 
                ["[>]categories" => ["category" => "id"]], 
                "categories.config",
                ["systems.uid" => $this->token]
            );

            $this->container->db->update("systems", ["lastActive" => time()], ["uid" => $this->token]);
            $this->container->logger->addInfo("Api call - known:config");
            return $response->withJson(["result" => "approved", "config" => $config]);
        }
    }

}
