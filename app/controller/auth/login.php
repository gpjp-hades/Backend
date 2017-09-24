<?php

namespace controller\auth;

class login {
    
    protected $container;

    function __construct(\Slim\Container $container) {
        $this->container = $container;
    }

    function sendResponse($request, &$response, $args = []) {
        $nameKey = $this->container->csrf->getTokenNameKey();
        $valueKey = $this->container->csrf->getTokenValueKey();
        $name = $request->getAttribute($nameKey);
        $value = $request->getAttribute($valueKey);

        $args = array_merge($args, [
            "csrf" => [
                "nameKey"  => $nameKey,
                "name"     => $name,
                "valueKey" => $valueKey,
                "value"    => $value
            ]
        ]);

        $response = $this->container->view->render($response, "auth/login.phtml", $args);
    }

    function __invoke($request, $response) {
        if ($request->isGet()) {

            $this->sendResponse($request, $response);

        } elseif ($request->isPost()) {

            $data = $request->getParsedBody();

            $name = filter_var(@$data['name'], FILTER_SANITIZE_STRING);
            $pass = filter_var(@$data['pass'], FILTER_SANITIZE_STRING);
            
            if ($this->container->auth->login($name, $pass)) {
                return $response->withRedirect($this->container->router->pathFor('dashboard'), 301);
            } else {
                $this->sendResponse($request, $response, [
                    "error" => "Login failed"
                ]);
            }
        }

        return $response;
    }
}