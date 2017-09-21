<?php

namespace app;

class auth {
    function __construct() {
        session_start();
        require_once "app/db.php";

        $this->db = new db();
    }

    function login($uname, $passw) {
        if ($hash = $this->db->get("users", "passw", ["uname" => $uname])) {
            if (password_verify($passw, $hash)) {
                do {
                    $token = bin2hex(\openssl_random_pseudo_bytes(4));
                } while ($this->db->has("users", ["token" => $token]));
                
                $_SESSION['token'] = $token;
                $this->db->update("users", ["token" => $token], ["uname" => $uname]);
                return true;
            }
            return false;
        }
        return false;
    }

    function logout() {
        if (!$this->logged())
            return false;
        
        $this->db->update("users", ["token" => null], ["token" => $_SESSION['token']]);
        unset($_SESSION['token']);
        return true;
    }

    function register($uname, $passw) {
        if ($this->db->has("users", ["uname" => $uname]))
            return false;
        
        if (strlen($uname) > 20 || strlen($passw) > 20)
            return false;
        
        if (preg_match('/[^\x20-\x7f]/', $uname))
            return false;
        
        $hash = \password_hash($passw, \PASSWORD_DEFAULT);

        $this->db->insert("users", ["uname" => $uname, "passw" => $hash]);
        return true;
    }

    function logged() {
        if ($this->hasToken() && $this->db->has("users", ["token" => $_SESSION['token']]))
            return true;
        return false;
    }

    function hasToken() {
        if (is_string(@$_SESSION['token']) && strlen(@$_SESSION['token']) == 8)
            return true;
        return false;
    }

    function chagePassw($passw) {
        if (!$this->logged())
            return false;
        
        $this->db->update("users", ["passw" => password_hash($passw, PASSWORD_DEFAULT)], ["token" => $_SESSION['token']]);
        return true;
    }

    function checkPassword($passw) {
        if (!$this->logged())
            return false;
        
        return password_verify($passw, $this->db->get("users", "passw", ["token" => $_SESSION['token']]));
    }
}