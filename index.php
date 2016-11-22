<?php
include "vendor/autoload.php";
include "config.php";

use Helpers\Authenticator as Authenticator;
use Helpers\Logger as Logger;
use Models\Connection as Connection;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Controllers\ReferenceListController as ReferenceList;
use Controllers\MunicipioController as Municipio;
use Controllers\DepartamentoController as Departamento;
use Controllers\CIE10Controller as CIE10;
use Controllers\AreaController as Area;
use Controllers\IpsController as Ips;
use Controllers\UserTypeController as UserType;

/** Instanciacion de la APP $app */
$app = new \Slim\App(CONFIG);

/** Contenedor de Custom Classes*/
$container = $app->getContainer();

/** Database */
$container['db'] = function () {
    return new Connection(...CONNECTION_CREDENTIALS);
};

/** UserName */
$container['userName'] = function () {
    return $_SERVER['PHP_AUTH_USER'];
};

/** Password */
$container['password'] = function () {
    return $_SERVER['PHP_AUTH_PW'];
};

//TODO OTROS MENSAJES DE ERROR
/** Error 500 */
$container['errorHandler'] = function ($c) {
    return function ($request, $response, $exception) use ($c) {
        $c['logger']->addCritical($request->getUri(),array("ERROR" => $exception));
        if($c->get('settings')['displayErrorDetails']) {
            return $c['response']->withStatus(500)
                ->withJson(array("ERROR" => $exception));
        } else {
            return $c['response']->withStatus(500)
                ->withJson(array("ERROR" => $exception->getMessage()));
        }
    };
};

/** Error 400 */
$container['notFoundHandler'] = function ($c) {
    return function ($request, $response) use ($c) {
        $c['logger']->addError($request->getUri(),array("ERROR"=>ERROR_404));
        return $c['response']->withStatus(404)
            ->withJson(ERROR_404);
    };
};

/** Logger */
$container['logger'] = function ($c) {
    $logger = new Logger($c['userName']);
    return $logger->getInstance();
};
/**
 *************
 * MIDDLEWARE *
 * ***********
 **/

/** Autenticacion */
$app->add(function (Request $request, Response $response, $next){
    if(Authenticator::authenticate()) {
        return $next($request, $response);
    } else {
        $this->logger->addError(ERROR_AUTH,array("userName"=>$this->userName,"password"=>$this->password));
        return $response->withStatus(401)->withJson(ERROR_AUTH);
    }
});

/**
 *************
 * SERVICIOS *
 * ***********
 **/

/** Lista de Referencia */
$app->group('/ReferenceList/get', function(){
    $this->get('/all',function (Request $request, Response $response){
        $referenceList = new ReferenceList($this->db);
        return $response->withJson($referenceList->getAll()->values());
    });
    $this->get('/updates/{lastSyncDate}', function(Request $request, Response $response, $args){
        $lastSyncDate = $args['lastSyncDate'];
        $referenceList = new ReferenceList($this->db);
        return $response->withJson($referenceList->getUpdates($lastSyncDate)->values());
    });
});

/** Municipios */
$app->group('/Municipios/get', function () {
    $this->get('/all', function (Request $request, Response $response) {
        $municipios = new Municipio($this->db);
        return $response->withJson($municipios->getAll()->values());
    });
    $this->get('/updates/{lastSyncDate}', function (Request $request, Response $response, $args) {
        $lastSyncDate = $args['lastSyncDate'];
        $municipios = new Municipio($this->db);
        return $response->withJson($municipios->getUpdates($lastSyncDate)->values());
    });
});

/** Departamentos */
$app->group('/Departamentos/get', function () {
    $this->get('/Departamentos/get/all', function (Request $request, Response $response) {
        $departamentos = new Departamento($this->db);
        return $response->withJson($departamentos->getAll()->values());
    });
    $this->get('/Departamentos/get/updates/{lastSyncDate}', function (Request $request, Response $response, $args) {
        $lastSyncDate = $args['lastSyncDate'];
        $departamentos = new Departamento($this->db);
        return $response->withJson($departamentos->getUpdates($lastSyncDate)->values());
    });
});

/** CIE10 */
$app->get('/CIE10/get/all', function (Request $request, Response $response) {
    $cie10 = new CIE10($this->db);
    return $response->withJson($cie10->getAll()->values());
});

/** Tipos de Usuario */
$app->get('/UserType/get/all', function(Request $request, Response $response){
    $tiposUsuario = new UserType($this->db);
    return $response->withJson($tiposUsuario->getAll()->values());
});

/** Areas */
$app->group('/Areas/get', function () {
    $this->get('/Areas/get/all', function (Request $request, Response $response) {
        $areas = new Area($this->db);
        return $response->withJson($areas->getAll()->values());
    });
    $this->get('/Areas/get/updates/{lastSyncDate}', function (Request $request, Response $response, $args) {
        $lastSyncDate = $args['lastSyncDate'];
        $areas = new Area($this->db);
        return $response->withJson($areas->getUpdates($lastSyncDate)->values());
    });
});

/** Ips */
$app->group('/Ips/get', function () {
    $this->get('/all', function (Request $request, Response $response) {
        $ips = new Ips($this->db);
        return $response->withJson($ips->getAll()->values());
    });
    $this->get('/updates/{lastSyncDate}', function (Request $request, Response $response, $args) {
        $lastSyncDate = $args['lastSyncDate'];
        $ips = new Ips($this->db);
        return $response->withJson($ips->getUpdates($lastSyncDate)->values());
    });
});

/** Pruebas */
$app->get('/test', function(Request $request, Response $response) {
    $customArray = new \Helpers\CustomArray();
    $customArray["UNO"] = ["DOS"=>"TRES"];
    $customArray["CUATRO"] = ["CINCO","SEIS"];
    $this->logger->addInfo($request->getUri(),array('response' => $customArray));
    return $response->withJson($customArray);
});

$app->run();