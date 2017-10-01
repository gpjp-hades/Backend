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
    
                if (
                    !(is_string($name) &&
                    strlen($name)) ||
                    preg_match('/[^\x20-\x7f]/', $name)
                ) {
                    $this->redirectWithMessage($response, "group", "error", ["Name is missing!", "Use only ASCII"], ["id" => $args["id"]]);
    
                } else if (
                    $this->container->db->has("categories", ["name" => $name])
                ) {
    
                    $this->redirectWithMessage($response, "group", "error", ["Group name alredy in use!", "Choose a different one."], ["id" => $args["id"]]);
                } else {
                    $this->container->db->insert("categories", [
                        "name" => $name,
                        "config" => $config
                    ]);
    
                    $this->redirectWithMessage($response, "dashboard", "status", ["Group created!", ""]);
                }
            } else {
                if (!$this->container->db->has("categories", ["id" => $args['id']])) {

                    $this->redirectWithMessage($response, "dashboard", "error", ["Group not found!", ""]);
                } else {

                    $this->container->db->update("categories", [
                        "config" => $config
                    ], ["id" => $args['id']]);

                    $this->redirectWithMessage($response, "dashboard", "status", ["Group updated!", ""]);
                }
            }
        } else if ($request->isDelete()) {
            
            if ($args['id'] === 0) {
                $this->redirectWithMessage($response, "dashboard", "error", ["Cannot remove Default group", ""]);
            } else if (!$this->container->db->has("categories", ["id" => $args['id']])) {
                $this->redirectWithMessage($response, "dashboard", "error", ["Group not found!", ""]);
            } else {
                $this->container->db->delete("categories", ["id" => $args['id']]);

                $this->redirectWithMessage($response, "dashboard", "status", ["Group removed!", ""]);
            }
        }
        return $response;
    }
}