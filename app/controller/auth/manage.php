<?php

namespace controller\auth;

class manage {
    
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

            $this->sendResponse($request, $response, "auth/manage.phtml", [
                "users" => $users
            ]);

        } elseif ($request->isDelete()) {

            $data = $request->getParsedBody();
            $id = filter_var(@$data['id'], FILTER_SANITIZE_STRING);

            if ($request->getAttribute('csrf_status') === false) {

                $this->container->logger->addInfo("CSRF failed for userManage");
                $this->sendResponse($request, $response, "auth/manage.phtml", [
                    "error" => [["Communication error!", "Please try again"]]
                ], "auth/manage.phtml");

            } else if (is_string($id) && strlen($id) > 0) {
                
                if ($users[$id] == 'admin') {
                    $this->redirectWithMessage($response, 'manageUsers', "error", ["Removal failed!", "Cannot remove the Admin account"]);
                } else {

                    $this->container->db->delete("users", ["id" => $id]);

                    $this->redirectWithMessage($response, 'manageUsers', "status", ["Removal successfull!", "User " . $users[$id]. " was removed!"]);
                }
            } else {
                $this->redirectWithMessage($response, 'manageUsers', "error", ["Removal failed!", "No user specified"]);
            }
        }
        return $response;
    }
}