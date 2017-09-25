<?php

namespace middleware;

class token {
    
    private const sleep = 0;

    public function __invoke($request, $response, $next) {
        
        $routeInfo = $request->getAttribute('routeInfo');
        $token = strtoupper($routeInfo[2]['token']);

        sleep(self::sleep);
        if (!preg_match('/([^0-9A-F])|(^.{65,}$)/', $token)) {
            
            $routeInfo[2]['token'] = $token;
            $request = $request->withAttribute('routeInfo', $routeInfo);

            return $next($request, $response);
        } else {
            return $response->withJson(["result" => "invalid request"], 400);
        }
        
    }
}