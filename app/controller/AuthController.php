<?php

namespace hades\app\controller;

use \hades\app\middleware\auth;

class AuthController {

    function __construct() {
        $this->auth = new auth();
    }

    function login ($params) {
        $post = $params['post'];
        if (
            is_string(@$post['uname']) &&
            is_string(@$post['passw']) &&
            @$post['type'] == "login"
        ) {
            if ($this->auth->login($post['uname'], $post['passw'])) {
                return [""];
            }
        }
    }
}