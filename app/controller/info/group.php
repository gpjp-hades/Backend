<?php

namespace controller\info;

class group {
    
    use \traits\sendResponse;
    
    protected $container;

    function __construct(\Slim\Container $container) {
        $this->container = $container;
    }

    function __invoke($request, $response, $args) {

        if ($request->isGet()) {

            if ($args['id'] == "new") {
                
                $info = [
                    "id" => "new",
                    "config" => "",
                    "name" => "Create Group"
                ];

                $response = $this->sendResponse($request, $response, "info/group.phtml", ["info" => $info]);
            } else {
                $info = $this->container->db->get("categories", "*", ["id" => $args['id']]);
                
                if (!$info) {
                    $this->redirectWithMessage($response, 'dashboard', "error", ["Group not found!", ""]);
                } else {
                    $response = $this->sendResponse($request, $response, "info/group.phtml", [
                        "info"    => $info,
                    ]);
                }
            }

        } else if ($request->isPut()) {

            $data = $request->getParsedBody();

            $config = filter_var(@$data['config'], FILTER_SANITIZE_STRING);
            
            if ($args['id'] == "new") {

                $name = filter_var(@$data['name'], FILTER_SANITIZE_STRING);

                $this->container->db->insert("categories", [
                    "name" => $name,
                    "config" => $config
                ]);

                $this->redirectWithMessage($response, "dashboard", "status", ["Group created!", ""]);
            } else {

                $this->container->db->update("categories", [
                    "config" => $config
                ], ["id" => $args['id']]);

                $this->redirectWithMessage($response, "dashboard", "status", ["Group updated!", ""]);
            }
        } else if ($request->isDelete()) {
            
            $this->container->db->delete("categories", ["id" => $args['id']]);

            $this->redirectWithMessage($response, "dashboard", "status", ["Group removed!", ""]);
        }
        return $response;
    }
}