<?php
include "vendor/autoload.php";
include "config.php";

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$config['displayErrorDetails'] = true;

$app = new \Slim\App(["settings" => $config]);
$container = $app->getContainer();

$container['db'] = function () {
    $connection = new Models\Connection(...CONNECTION_CREDENTIALS);
    return $connection;
};

$app->get('/',function(Request $request, Response $response){
    return $response->withJson(["Hello" => "World"]);
});

$app->get('/users/{id}',function(Request $request, Response $response,$args) {
    if(\Helpers\Authenticator::authenticate()) {
        $users = new \Controllers\UsersController($this->db);
        $users->getById($args['id']);
        return $response->withJson($users->getModel()->getResult());
    } else {
        return $response->withStatus(401)->withJson(array("ERROR" => "USARIO/CONTRASEÑA INVALIDOS"));
    }
});
$app->run();