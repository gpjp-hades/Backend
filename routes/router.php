<?php

namespace hades\routes;

class router {

    private $route;

    function __construct() {

        $method = $_SERVER['REQUEST_METHOD'];
        $uri = $_SERVER["REQUEST_URI"];
        $this->request = explode("/", str_replace("/hades/public/", "", $uri));
        
        switch ($method) {
            case 'PUT':
                $this->put();
                break;
            case 'POST':
                $this->post();
                break;
            case 'GET':
                $this->get();
                break;
            case 'HEAD':
                $this->head();
                break;
            case 'DELETE':
                $this->delete();
                break;
            case 'OPTIONS':
                $this->options();
                break;
            default:
                $this->error();
                break;
        }
    }

    function getRoute() {
        return $this->route;
    }

    private function get() {
        switch($this->request[0]) {
            case "":
                $this->route = ["HomeController@index", []];
                break;
            case "api":
                if (isset($this->request[1])) {
                    $args = ["token" => $this->request[1]];
                    if (isset($this->request[2])) {
                        $args["name"] = $this->request[2];
                    }
                    $this->route = ["ApiController@register", $args];
                } else {
                    $this->error();
                }
                break;
            default:
                $this->error();
                break;
        }
    }

    private function error() {
        $this->route = ["ErrorController@_404", []];
    }
}
