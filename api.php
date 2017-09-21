<?php

namespace app;

class api {
    function __construct() {
        require_once "app/db.php";
        
        $this->db = new db();

        if (!$this->valid_token()) {
            //sleep(5);
            exit('{"error": "invalid request"}');
        }

        $this->token = strtoupper($_GET['token']);

        if (!$this->db->has("pc", ["uid" => $this->token])) {
            $name = preg_replace('/[^\x20-\x7E]/','', @$_GET['name']);

            $this->db->insert("pc", ["uid" => $this->token, "name" => $name, "lastActive" => time()]);
            //sleep(5);
            exit('{"success": "request pending"}');
        } else if ($this->db->has("pc", ["uid" => $this->token, "approved" => false])) {
            //sleep(5);
            exit('{"success": "request pending"}');
        } else {
            $config = $this->db->get("pc", ["[>]categories" => ["category" => "id"]], ["categories.config"], ["pc.uid" => $this->token]);
            exit(json_encode(["success" => "approved", "config" => $config['config']]));
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
}

new api();