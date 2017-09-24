<?php

namespace controller;

final class api {
    
    protected $container;
    private const sleep = 0;

    function __construct(\Slim\Container $container) {
        $this->container = $container;
    }

    function token($request, $response, $args) {
        $this->container->logger->addInfo("Api call");
        
        return $response->withJson(["result" => "success"]);
    }
    /*

    private function register() {
        if (!$this->valid_token()) {
            sleep(self::sleep);
            return $response->withJson(["result" => "invalid request"], 400);
        }
    }

    private function valid_token() {
        if (!preg_match('/([^0-9A-F])|(^.{65,}$)/', $this->token))
            return true;
        return false;
    }
/*
    if (!$this->valid_token()) {
        //sleep(5);
        exit('{"result": "invalid request"}');
    }

    $this->token = strtoupper($_GET['token']);

    if (!$this->db->has("pc", ["uid" => $this->token])) {
        $name = preg_replace('/[^\x20-\x7E]/','', @$_GET['name']);

        $this->db->insert("pc", ["uid" => $this->token, "name" => $name, "lastActive" => time()]);
        //sleep(5);
        exit('{"result": "request pending"}');
    } else if ($this->db->has("pc", ["uid" => $this->token, "approved" => false])) {
        //sleep(5);
        exit('{"result": "request pending"}');
    } else {
        $config = $this->db->get("pc", ["[>]categories" => ["category" => "id"]], ["categories.config"], ["pc.uid" => $this->token]);
        exit(json_encode(["result" => "approved", "config" => $config['config']]));
    }
    
}

function valid_token() {
    if (
        is_string(@$_GET['token']) &&
        strlen($_GET['token']) == 64 &&
        !preg_match('/[^\x20-\x7f]/', $_GET['token'])
    )
        return true;
    return false;
}
*/
}