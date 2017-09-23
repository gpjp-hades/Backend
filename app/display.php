<?php

namespace hades\app;

class display {
    function __construct(\hades\routes\router $router) {

        $this->route = $router->getRoute();
    }

    function loadFile($route = null) {
        if (is_null($route)) {
            $fnc = explode("@", $this->route[0]);
        } else {
            $fnc = explode("@", $route[0]);
        }
        $name = "\\hades\\app\\controller\\" . $fnc[0];
        $call = new $name;

        if (is_null($route)) {
            return $call->{$fnc[1]}($this->route[1]);
        } else {
            return $call->{$fnc[1]}($route[1]);
        }
    }
    
    function parse($file) : string {
        if (is_array($file)) {
            if (count($file) == 1) {
                header("Location: /hades/public/" . $file[0]);
            } else {
                $file = $this->loadFile($file);
            }
        }
        if (is_file(__DIR__."/../template/" . $file . ".php")) {
            ob_start();
                require_once __DIR__."/../template/" . $file . ".php";
            $ret = ob_get_contents();
            ob_end_clean();
            return $ret;
        } else {
            return $file;
        }
    }

    function html() : string {
        $file = $this->loadFile();
        $text = $this->parse($file);
        return $text;
    }
}