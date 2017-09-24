<?php

namespace controller\info;

class system {
    
    use \controller\sendResponse;
    
    protected $container;

    function __construct(\Slim\Container $container) {
        $this->container = $container;
    }

    function __invoke($request, $response, $args) {
        /*
        $db = new app\db();
        if (@$_POST['type'] == 'system' && is_string($_POST['id'])) {
            $config = [];
            if ($db->has("pc", ["id" => $_POST['id'], "approved" => false])) {
                if (!is_string(@$_POST['name']) || !strlen($_POST['name'])) {
                    $error = "Name required";
                } else {
                    $config = ["approved" => true];
                }
            }
            
            if (is_string(@$_POST['wiki'])) {
                $config["wikilink"] = $_POST['wiki'];
            }
            if (is_string(@$_POST['name'])) {
                if (preg_match('/[^\x20-\x7f]/', $_POST['name'])) {
                    $error = "Use only ASCII in name";
                } else {
                    $config["name"] = $_POST['name'];
                }
            }
            if (is_string(@$_POST['group']) && !is_string(@$error)) {
                if ($db->has("categories", ["id" => $_POST['group']]) && $db->has("pc", ["id" => $_POST['id']])) {
                    $db->update("pc", ["category" => $_POST['group']], ["id" => $_POST['id']]);
                    $status = "Config updated";
                }
            }
            if (count($config) && $db->has("pc", ["id" => $_POST['id']]) && !is_string(@$error)) {
                $db->update("pc", $config, ["id" => $_POST['id']]);
                $status = "Config updated";
            }
        }
        if (isset($_GET['delete'])) {
            if ($db->has("pc", ["uid" => $_GET['info']])) {
                $db->delete("pc", ["uid" => $_GET['info']]);
                $status = "PC removed";
            } else {
                $error = "PC not found";
            }
        }*/


        if ($request->isGet()) {

            $info = $this->container->db->get("systems", "*", ["AND" => ["id" => $args['id'], "approved" => true]]);

            if (!$info) {
                $this->redirectWithMessage($response, 'dashboard', "error", ["System not found!", ""]);
            } else {
                $groups = $this->container->db->get("categories", ["id", "name"]);

                $response = $this->sendResponse($request, $response, "info/system.phtml", [
                    "info"    => $info,
                    "groups"   => $groups
                ]);
            }

        } else if ($request->isPut()) {
            
        } else if ($request->isDelete()) {
            
            if ($this->container->db->has("systems", ["AND" => ["id" => $args['id'], "approved" => true]])) {
                $this->container->db->delete("systems", ["id" => $_GET['info']]);
                
                $this->redirectWithMessage($response, 'dashboard', "success", ["System removed!", ""]);
            } else {
                $this->redirectWithMessage($response, 'dashboard', "error", ["System not found!", ""]);
            }
        }

        return $response;
    }
}