<?php

namespace hades\app\controller;

use \hades\app\middleware\auth;
use \hades\database\db;

class HomeController {

    function dashboard() {
        if (auth::auth()) {
            $db = new db();
            $GLOBALS["PENDING"] = $db->select("pc", ["name", "uid"], ["approved" => false]);
            $GLOBALS["APPROVED"] = $db->select("pc", "*", ["approved" => true]);
            $GLOBALS["GROUPS"] = $db->select("categories", "*");
            $GLOBALS["ASSOC"] = [];
            foreach ($GLOBALS["GROUPS"] as $line) {
                $GLOBALS["ASSOC"][$line['id']] = $line['name'];
            }
            unset($db);
            return "app/dashboard";
        } else {
            return [""];
        }
    }

    function login () {
        return "auth/login";
    }
}