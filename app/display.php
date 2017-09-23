<?php

namespace hades\app;

class display {
    function __construct(\hades\routes\router $router) {

        $this->route = $router->getRoute();
    }

    function loadFile() {
        $fnc = explode("@", $this->route[0]);
        $name = "\\hades\\app\\controller\\" . $fnc[0];
        $call = new $name;
        return $call->{$fnc[1]}($this->route[1]);
    }
    
    function parse($file) : string {
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