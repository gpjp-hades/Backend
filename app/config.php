<?php

class config {
    
    protected $container;
    protected $db;
    
    function __construct(\Slim\Container $container) {
        $this->container = $container;
        $this->db = $this->container->db;
    }

    function get($name) {
        if ($this->db->has("config", ["conf_key" => $name])) {
            return $this->db->get("config", "conf_value", ["conf_key" => $name]);
        }
        return false;
    }

    function getBool($name) {
        return strtolower($this->get($name)) == "true" ? true : false;
    }

    function set($name, $val) {
        if ($this->db->has("config", ["conf_key" => $name])) {
            return $this->db->update("config", ["conf_value" => $val], ["conf_key" => $name]);
        } else {
            return $this->db->insert("config", ["conf_key" => $name, "conf_value" => $val]);
        }
    }

    function delete($name) {
        if ($this->db->has("config", ["conf_key" => $name])) {
            return $this->db->delete("config", ["conf_key" => $name]);
        }
    }
}
