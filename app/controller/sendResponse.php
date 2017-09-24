<?php

namespace controller;

trait sendResponse {

    function sendResponse($request, &$response, $page, $args = []) {
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
        ], $this->container->flash->getMessages());

        $response = $this->container->view->render($response, $page, $args);
    }
}