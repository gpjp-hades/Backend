<?php

namespace middleware;

class token {
    
    private const sleep = 0;

    public function __invoke($request, $response, $next) {
        
        $args = $request->getAttribute('routeInfo')[2];
        $token = $args['token'];

        sleep(self::sleep);
        if (!preg_match('/([^0-9A-F])|(^.{65,}$)/', $token)) {
            return $next($request, $response);
        } else {
            return $response->withJson(["result" => "invalid request"], 400);
        }
        
    }
}