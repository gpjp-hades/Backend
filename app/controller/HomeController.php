<?php

namespace hades\app\controller;

class HomeController {

    function index () {
        return "basic";
    }

    function login () {
        return "auth/login";
    }
}