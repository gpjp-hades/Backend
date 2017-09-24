<?php

namespace controller\auth;

class changePassword {
    
    use \controller\sendResponse;

    protected $container;

    function __construct(\Slim\Container $container) {
        $this->container = $container;
    }

    function __invoke($request, $response) {

        if ($request->isGet()) {

            $this->sendResponse($request, $response, "auth/change.phtml");

        } elseif ($request->isPut()) {

            $data = $request->getParsedBody();
            $old = filter_var(@$data['old'], FILTER_SANITIZE_STRING);
            $pass = filter_var(@$data['pass'], FILTER_SANITIZE_STRING);
            $pass2 = filter_var(@$data['pass2'], FILTER_SANITIZE_STRING);

            if ($request->getAttribute('csrf_status') === false) {

                $this->container->logger->addInfo("CSRF failed for userManage");
                $this->sendResponse($request, $response, "auth/change.phtml", [
                    "error" => [["Communication error!", "Please try again"]]
                ]);

            } else if (!$this->container->auth->checkPassword($old)) {
                $this->container->flash->addMessage("error", [
                    "Error!", "Wrong current password!"
                ]);

                $response = $response->withRedirect($this->container->router->pathFor('changePassword'), 301);
            } else if (
                is_string($old) && strlen($old) > 0 &&
                is_string($pass) && strlen($pass) > 0 &&
                $pass === $pass2
            ) {
                
                $this->container->auth->changePass($pass);
                
                $this->container->flash->addMessage("status", [
                    "Success!", "Password changed successfully"
                ]);

                $response = $response->withRedirect($this->container->router->pathFor('dashboard'), 301);
                
            } else {
                $this->container->flash->addMessage("error", [
                    "Error!", "Passwords don't match!"
                ]);

                $response = $response->withRedirect($this->container->router->pathFor('changePassword'), 301);
            }
        }
        return $response;
    }
}