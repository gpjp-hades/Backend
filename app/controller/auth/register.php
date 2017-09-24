<?php

namespace controller\auth;

class register {
    
    use \controller\sendResponse;

    protected $container;

    function __construct(\Slim\Container $container) {
        $this->container = $container;
    }

    function __invoke($request, $response) {
        
        $users = [];
        foreach ($this->container->db->select("users", ["id", "name"]) as $user) {
            $users[$user['id']] = $user['name'];
        }

        if ($request->isGet()) {

            $this->sendResponse($request, $response, [
                "users" => $users
            ] + $this->container->flash->getMessages());

        } elseif ($request->isDelete()) {

            $data = $request->getParsedBody();
            $id = filter_var(@$data['id'], FILTER_SANITIZE_STRING);

            if ($request->getAttribute('csrf_status') === false) {

                $this->container->logger->addInfo("CSRF failed for userManage");
                $this->sendResponse($request, $response, [
                    "error" => [["Communication error!", "Please try again"]]
                ]);

            } else if (is_string($id) && strlen($id) > 0) {
                
                if ($users[$id] == 'admin') {
                    $this->sendResponse($request, $response, [
                        "users" => $users,
                        "error" => [["Removal failed!", "Cannot remove the Admin account"]]
                    ]);
                } else {

                    $this->container->db->delete("users", ["id" => $id]);

                    $this->container->flash->addMessage("status", ["Removal successfull!", "User " . $users[$id]. " was removed!"]);
                    return $response->withRedirect($this->container->router->pathFor('manageUsers'), 301);
                }
            } else {
                $this->sendResponse($request, $response, [
                    "users" => $users,
                    "error" => [["Removal failed!", "No user specified"]]
                ]);
            }
        }
        return $response;
    }
}