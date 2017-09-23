<?php

namespace hades\app\controller;

use \hades\app\middleware\auth;

class UserController {

    function manage() {
        if (auth::auth()) {
            return "app/";
        } else {
            return [""];
        }
    }
}