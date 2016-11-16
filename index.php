<?php
include "vendor/autoload.php";
include "config.php";

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use Models\Connection as Connection;
use Helpers\Authenticator as Authenticator;
use Controllers\ReferenceListController as ReferenceList;

/** Configuracion de Errores detallados */
$config['displayErrorDetails'] = true;

/** Instanciacion de la APP $app */
$app = new \Slim\App(["settings" => $config]);

/** Contenedor de Custom Classes*/
$container = $app->getContainer();

/** Database */
$container['db'] = function () {
    return new Connection(...CONNECTION_CREDENTIALS);
};

/** Error 500 */
$container['errorHandler'] = function ($c) {
  return function ($request, $response, $exception) use ($c) {
      return $c['response']->withStatus(500)
          ->write("ERROR\n")
          ->write($exception);
  };
};

/** Error 400 */
$container['notFoundHandler'] = function ($c) {
    return function ($request, $response) use ($c) {
        return $c['response']->withStatus(404)
            ->write(ERROR_404);
    };
};

//TODO OTROS MENSAJES DE ERROR

/** Lista de Referencia Todos los Registros */
$app->get('/ReferenceList/get/all', function(Request $request, Response $response){
    if(Authenticator::authenticate()) {
        $referenceList = new ReferenceList(new Connection(...CONNECTION_CREDENTIALS));
        return $response->withJson($referenceList->getAll());
    } else {
        return $response->withStatus(401)->withJson(ERROR_AUTH);
    }
});

/** Lista de Referencia Registros Actualizados*/
$app->get('/ReferenceList/get/updates/{lastSyncDate}', function(Request $request, Response $response, $args){
    $lastSyncDate = $args['lastSyncDate'];
    if(Authenticator::authenticate()) {
        $referenceList = new ReferenceList(new Connection(...CONNECTION_CREDENTIALS));
        return $response->withJson($referenceList->getUpdates($lastSyncDate));
    } else {
        return $response->withStatus(401)->withJson(ERROR_AUTH);
    }
});

/** Pruebas */
$app->get('/test', function(Request $request, Response $response) {
    $customArray = new \Helpers\CustomArray();
    $customArray["UNO"] = ["DOS"=>"TRES"];
    $customArray[] = "DOS";
    return $response->withJson($customArray->values());
});


$app->run();