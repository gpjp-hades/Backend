<?php

namespace hades\app\controller;

final class ApiController {

    private const sleep = 0;

    private $token;

    function __construct() {
        $this->db = new \hades\database\db();
    }
    
    function register($params) {

        $this->token = strtoupper($params['token']);

        if (!$this->valid_token()) {
            sleep($this::sleep);
            return '{"result": "invalid request"}';
        }
        
        if (!$this->db->has("pc", ["uid" => $this->token])) {
            $name = preg_replace('/[^\x20-\x7E]/','', @$params['name']);
            sleep($this::sleep);

            $this->db->insert("pc", ["uid" => $this->token, "name" => $name, "lastActive" => time()]);

            return '{"result": "request pending"}';
        } else if ($this->db->has("pc", ["uid" => $this->token, "approved" => false])) {
            
            sleep($this::sleep);
            $this->db->update("pc", ["lastActive" => time()], ["uid" => $this->token]);
            return '{"result": "request pending"}';

        } else {
            $config = $this->db->get("pc", ["[>]categories" => ["category" => "id"]], ["categories.config"], ["pc.uid" => $this->token]);
            $this->db->update("pc", ["lastActive" => time()], ["uid" => $this->token]);

            return json_encode(["result" => "approved", "config" => $config['config']]);
        }
    }

    private function valid_token() {
        if (!preg_match('/([^0-9A-F])|(^.{65,}$)/', $this->token))
            return true;
        return false;
    }
}