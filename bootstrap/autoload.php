<?php

/**
 * 
 * Autoload
 *
 * Autoloading classes, so we don't have to care about include and require
 * 
 * @package  Hades
 * @author   Keombre <keombre@gmail.com>
 */

namespace hades\bootstrap;

final class autoload {
    
    /**
     *
     * Register basic autoloader
     *
     * @param string $path = __DIR__ a basepath for autoloader to find classes
     * @throws stack trace if error is encountered
     */
    function __construct(string $path = __DIR__) {
        \spl_autoload_register([$this, "autoload"], true);
    }
    
    /**
     *
     * Autoloader using namespaces as folder structure
     *
     * if class was not found, throw error with stack trace
     *
     * @param string $class - requested class to be loaded
     * @return bool
     */
    private final function autoload(string $class) : bool {

        $path = __DIR__."/../".\str_replace("hades/", "", \str_replace("\\", "/", $class));

        //check if we have the class
        if (\is_file($path . ".php")) {

            require $path . ".php";
            return true;

        } else {
            $trace = \debug_backtrace();
            
            //why can't php have oop arrays :(
            \array_shift($trace);
    
            throw new \Exception($this->parseStackTrace($trace));
            return false;
        }
    }

    /**
     *
     * Parse stack trace, can be overloaded
     *
     * @param array $stackTrace - call trace from debug_backtrace()
     * @return string will get HTML escaped
     */
    function parseStackTrace(array $stackTrace) : string {
        
        //convert array to string
        return print_r($stackTrace, true);
    }
    
}