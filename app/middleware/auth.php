<?php

namespace middleware;

class auth {

    public function __invoke($request, $response, $next) {
        return $next($request, $response);
    }
}