<?php

namespace controller\info;

class approve {
    
    use \controller\sendResponse;
    
    protected $container;

    function __construct(\Slim\Container $container) {
        $this->container = $container;
    }

    function __invoke($request, $response, $args) {

        if ($request->isGet()) {

            $info = $this->container->db->get("systems", "*", ["AND" => ["id" => $args['id'], "approved" => false]]);

            if (!$info) {
                $this->redirectWithMessage($response, 'dashboard', "error", ["System not found!", ""]);
            } else {
                $groups = $this->container->db->select("categories", ["id", "name"]);

                $response = $this->sendResponse($request, $response, "info/approve.phtml", [
                    "info"    => $info,
                    "groups"   => $groups
                ]);
            }

        } else if ($request->isPut()) {

            $data = $request->getParsedBody();
            
            $name = filter_var(@$data['name'], FILTER_SANITIZE_STRING);
            $group = filter_var(@$data['group'], FILTER_SANITIZE_STRING);
            $wiki = filter_var(@$data['wiki'], FILTER_SANITIZE_STRING);

            if (
                !(is_string($name) &&
                strlen($name)) ||
                preg_match('/[^\x20-\x7f]/', $name)
            ) {
                $this->redirectWithMessage($response, "approve", "error", ["Name is missing!", "Use only ASCII"], ["id" => $args["id"]]);

            } else if (
                !is_string($group) ||
                !$this->container->db->has("categories", ["id" => $group])
            ) {

                $this->redirectWithMessage($response, "approve", "error", ["Group not found!", ""], ["id" => $args["id"]]);
            } else {
                $this->container->db->update("systems", [
                    "name" => $name,
                    "category" => $group,
                    "wikilink" => $wiki,
                    "approved" => true,
                    "lastActive" => time()
                ], ["id" => $args['id']]);

                $this->redirectWithMessage($response, "dashboard", "status", ["System approved!", ""]);
            }
        } else if ($request->isDelete()) {
            
            if ($this->container->db->has("systems", ["AND" => ["id" => $args['id'], "approved" => false]])) {
                $this->container->db->delete("systems", ["id" => $args['id']]);

                $this->redirectWithMessage($response, 'dashboard', "status", ["Request denied!", ""]);
            } else {
                $this->redirectWithMessage($response, 'dashboard', "error", ["System not found!", ""]);
            }
        }

        return $response;
    }
}