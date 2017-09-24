<?php

namespace controller\auth;

class register {
    
    use \controller\sendResponse;

    protected $container;

    function __construct(\Slim\Container $container) {
        $this->container = $container;
    }

    function __invoke($request, $response) {

        if ($request->isGet()) {

            $this->sendResponse($request, $response, "auth/register.phtml");

        } elseif ($request->isPut()) {

            $data = $request->getParsedBody();
            $name = filter_var(@$data['name'], FILTER_SANITIZE_STRING);
            $pass = filter_var(@$data['pass'], FILTER_SANITIZE_STRING);
            $pass2 = filter_var(@$data['pass2'], FILTER_SANITIZE_STRING);

            if ($request->getAttribute('csrf_status') === false) {

                $this->container->logger->addInfo("CSRF failed for userManage");
                $this->sendResponse($request, $response, "auth/register.phtml", [
                    "error" => [["Communication error!", "Please try again"]]
                ]);

            } else if ($this->container->db->has("users", ["name" => $name])) {
                $this->container->flash->addMessage("error", [
                    "Error!", "Username alredy taken!"
                ]);

                $response = $response->withRedirect($this->container->router->pathFor('register'), 301);
            } else if (
                is_string($name) && strlen($name) > 0 &&
                is_string($pass) && strlen($pass) > 0 &&
                $pass === $pass2
            ) {
                
                if ($this->container->auth->register($name, $pass)) {
                    
                    $this->container->flash->addMessage("status", [
                        "Success!", "User " . $users[$id]. " was created!"
                    ]);

                    $response = $response->withRedirect($this->container->router->pathFor('dashboard'), 301);
                } else {
                    $this->sendResponse($request, $response, "auth/register.phtml", [
                        "error" => [["Error!", "Use only ASCII in UnserName & keep it short!"]]
                    ]);
                }
            } else {
                $this->container->flash->addMessage("error", [
                    "Error!", "Passwords don't match!"
                ]);

                $response = $response->withRedirect($this->container->router->pathFor('register'), 301);
            }
        }
        return $response;
    }
}