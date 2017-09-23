<?php

namespace hades\app\controller;

class HomeController {

    function dashboard() {
        return "app/dashboard";
    }

    function login () {
        return "auth/login";
    }
}