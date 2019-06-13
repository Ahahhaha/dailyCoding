<?php

$urlAddress = explode("/", $_SERVER['REQUEST_URI']);

$action = $controller = "";

if (!empty($urlAddress)) {
    $controller = $urlAddress[1] ?? '';
    $action = $urlAddress[2] ?? '';
}

if (is_file(__ROOT__ . DIRECTORY_SEPARATOR . "{$controller}.php")) {
    require __ROOT__ . DIRECTORY_SEPARATOR . "{$controller}.php";
}