<?php

namespace hades\app\controller;

class HomeController {
    function index () {
        return "basic";
    }

    function show($params) {
        return print_r($params, true);
    }
}