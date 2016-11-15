<?php
include "vendor/autoload.php";
include "config.php";

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use Models\Connection as Connection;
use Helpers\Authenticator as Authenticator;

$config['displayErrorDetails'] = true;

$app = new \Slim\App(["settings" => $config]);
$container = $app->getContainer();

$container['db'] = function () {
    return new Connection(...CONNECTION_CREDENTIALS);
};

$app->get('/',function(Request $request, Response $response){
    return $response->withJson(["Hello" => "World"]);
});

$app->get('/users/{id}',function(Request $request, Response $response,$args) {
    if(Authenticator::authenticate()) {
        return $response->withJson(array("OK"=>"Ok"));
    } else {
        return $response->withStatus(401)->withJson(array("ERROR" => "USARIO/CONTRASEÑA INVALIDOS"));
    }
});

//Lista de Referencia Obtener Todo
$app->get('/ReferenceList/get/all', function(Request $request, Response $response){
    if(Authenticator::authenticate()) {
        $referenceList = new \Controllers\ReferenceListController(new Connection(...CONNECTION_CREDENTIALS));
        return $response->write(json_encode($referenceList->getAll()));
        //return $response->withJson(array("OK"=>"Ok"));
    } else {
        return $response->withStatus(401)->withJson(array("ERROR" => "USARIO/CONTRASEÑA INVALIDOS"));
    }
});


$app->run();