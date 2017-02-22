<?php
include "vendor/autoload.php";
include "src/config.php";

use SIGRI_HC\Helpers\Authenticator as Authenticator;
use SIGRI_HC\Helpers\Logger as Logger;
use SIGRI_HC\Models\Connection as Connection;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use SIGRI_HC\Controllers\ReferenceListController as ReferenceList;
use SIGRI_HC\Controllers\MunicipioController as Municipio;
use SIGRI_HC\Controllers\DepartamentoController as Departamento;
use SIGRI_HC\Controllers\CIE10Controller as CIE10;
use SIGRI_HC\Controllers\AreaController as Area;
use SIGRI_HC\Controllers\IpsController as Ips;
use SIGRI_HC\Controllers\UserTypeController as UserType;
use SIGRI_HC\Controllers\NewsTypeController as NewsType;
use SIGRI_HC\Controllers\NewsListController as NewsList;
use SIGRI_HC\Controllers\PECGuideController as PECGuide;
use SIGRI_HC\Controllers\PECObjetiveController as PECObjetive;
use SIGRI_HC\Controllers\PECProcessController  as PECProcess;
use SIGRI_HC\Controllers\PECScheduleController  as PECSchedule;
use SIGRI_HC\Controllers\PECTopicController  as PECTopic;
use SIGRI_HC\Controllers\ScheduleController as Schedule;
use SIGRI_HC\Controllers\MedicineController as Medicine;
use SIGRI_HC\Controllers\LaboratoryController as Laboratory;
use SIGRI_HC\Controllers\ModuleController as Module;
use SIGRI_HC\Controllers\QuestionController as Question;
use SIGRI_HC\Controllers\HcMedicaController as HcMedica;
use SIGRI_HC\Controllers\PersonController as Person;
use SIGRI_HC\Controllers\UserController as User;
use SIGRI_HC\Controllers\ProcedureController as Procedure;

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
/** Error Conn */
$container['errorHandler'] = function ($c) {
    return function ($request, $response, $exception) use ($c) {
        $c['logger']->addCritical($request->getUri(),array("ERROR" => $exception));
        if($_SERVER['SERVER_ADDR'] == '127.0.0.1') {
            return $c['response']->withStatus(500)
                ->withJson($exception);
        } else {
            return $c['response']->withStatus(500)
                ->withJson(ERROR_500);
        }
    };
};

/** Error 400 */
$container['notFoundHandler'] = function ($c) {
    return function ($request, $response) use ($c) {
        $c['logger']->addError($request->getUri(),ERROR_404);
        return $c['response']->withStatus(404)
            ->withJson(ERROR_404);
    };
};

/** Error 500 */
$container['phpErrorHandler'] = function($c) {
    return function ($request, $response, $exception) use ($c) {
        $c['logger']->addCritical($request->getUri(),array("ERROR" => $exception));
        if($_SERVER['SERVER_ADDR'] == '127.0.0.1') {
            return $c['response']->withStatus(500)
                ->withJson($exception);
        } else {
            return $c['response']->withStatus(500)
                ->withJson(ERROR_500);
        }
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

/**
 * @apiDefine user Cualquier Usuario
 * Requiere User y Password validos definidos en Header
 */
/**
 * @apiDefine specific_user Usuario Especifico
 * Requiere User y Password validos definidos en Header.
 * Tenga en cuenta que se entregaran unicamente los registros relacionados con el usuario que realiza la peticion
 */
/**
 * @apiDefine admin Permisos Elevados
 * Requiere User y Password validos, de tipo admin o superior, definidos en Header
 */
//TODO MiddleWare de Authenticacion aun no soporta tipos de usuario o perfiles de acceso

/** Autenticacion */
$app->add(function (Request $request, Response $response, $next){
    if(Authenticator::authenticate()) {
        return $next($request, $response);
    } else {
        $this->logger->addError(ERROR_AUTH,array("userName"=>$this->userName,"password"=>$this->password));
        return $response->withStatus(401)->withJson(ERROR_AUTH);
    }
});

/** Date -SyncDate-
 * @notImplemented
 */
//TODO implementar este Mw cuando me respondan en Github
$dateMw = function ($request, $response, $next) {
    $lastSyncDate = $request->getAttribute('routeInfo')[2]['lastSyncDate'];
    $date = new \DateTime();
    $date->setTimeStamp(strtotime($lastSyncDate));
    return $next($request, $response,[],$date);
};

/** Content Type */
$app->add(function(Request $request, Response $response, $next){
    $contentType = 'application/json';
    if(($request->isPost() || $request->isPut()) && $request->getContentType() !== $contentType) {
        return $next($request->withHeader('Content-Type',$contentType),$response);
    }
    return $next($request,$response);
});

/**
 ***********************
 * SERVICIOS GENERICOS *
 ***********************
 **/

$app->group('/ListasReferencia', function(){
    /**
     * @api {GET} /ListasReferencia/:date
     * @apiGroup Listas Referencia
     * @apiDescription Retorna Todos los registros de Lista de Referencia, si se provee :date se filtraran los resultados modificados a partir de :date
     * @apiPermission user
     * @apiSampleRequest off
     *
     * @apiHeader {String} Authorization Clave Unica de Acceso RFC2045-MIME (Base64).
     * @apiHeaderExample {Json} Ejemplo Header:
     * {"Authorization":"Basic cHJ1ZWJhOjM0MDVlMmY1ODYxOTNiMjQ0MDRkODlmMzZjNDdmYmU3"}
     *
     * @apiParam {Date} [date] Fecha de Ultima Sincronizacion de Registros formato <strong>UNIX TIMESTAMP</strong> o <strong>yyyy-mm-dd</strong>

     *
     * @apiError {Json} 401 Usuario o Contraseña Invalidos
     * @apiErrorExample {Json} Ejemplo Error 401:
     * {"ERROR":"USARIO/CONTRASEÑA INVALIDOS"}
     *
     * @apiError {Json} 404 LO QUE BUSCAS DEFINITIVAMENTE NO ESTÁ AQUÍ...
     * @apiErrorExample {Json} Ejemplo Error 404:
     * {"ERROR":"LO QUE BUSCAS DEFINITIVAMENTE NO ESTÁ AQUÍ..."}
     *
     * @apiSuccess {Json} 200 Arreglo de Objetos de tipo LISTA_REFERENCIA
     * @apiSuccessExample {Json} Ejemplo Respuesta:
     * {"LISTAS_REFERENCIA":[{"ID_LISTA":"1","PADRE":"","DESCRIPCION":"Motivo Visita","CODLISTA":"","VALOR":"","ESTADO":""},{...}]}
     *
     */
    $this->get('[/{lastSyncDate}]', function(Request $request, Response $response, $args){
        $referenceList = new ReferenceList($this->db);
        if($args['lastSyncDate']) {
            $lastSyncDate = new \DateTime();
            $lastSyncDate->setTimeStamp(strtotime($args['lastSyncDate']));
            return $response->withJson(['LISTAS_REFERENCIA' => $referenceList->getUpdates($lastSyncDate)->values()]);
        }
        return $response->withJson(['LISTAS_REFERENCIA' => $referenceList->getAll()->values()]);
    });
});

$app->group('/Municipios', function () {
    /**
     * @api {GET} /Municipios/:date
     * @apiGroup Municipios
     * @apiDescription Retorna Todos los registros de Municipios, si se provee :date se filtraran los resultados modificados a partir de :date
     * @apiPermission user
     * @apiSampleRequest off
     *
     * @apiHeader {String} Authorization Clave Unica de Acceso RFC2045-MIME (Base64).
     * @apiHeaderExample {Json} Ejemplo Header:
     * {"Authorization":"Basic cHJ1ZWJhOjM0MDVlMmY1ODYxOTNiMjQ0MDRkODlmMzZjNDdmYmU3"}
     *
     * @apiParam {Date} [date] Fecha de Ultima Sincronizacion de Registros formato <strong>UNIX TIMESTAMP</strong> o <strong>yyyy-mm-dd</strong>

     *
     * @apiError {Json} 401 Usuario o Contraseña Invalidos
     * @apiErrorExample {Json} Ejemplo Error 401:
     * {"ERROR":"USARIO/CONTRASEÑA INVALIDOS"}
     *
     * @apiError {Json} 404 LO QUE BUSCAS DEFINITIVAMENTE NO ESTÁ AQUÍ...
     * @apiErrorExample {Json} Ejemplo Error 404:
     * {"ERROR":"LO QUE BUSCAS DEFINITIVAMENTE NO ESTÁ AQUÍ..."}
     *
     * @apiSuccess {Json} 200 Arreglo de Objetos de tipo MUNICIPIO
     * @apiSuccessExample {Json} Ejemplo Respuesta:
     * {"MUNICIPIOS":[{"ID":"25","NOMBRE":"AMAGÁ Antioquia","ID_DPTO":"05","NOMBRE_DPTO":"Antioquia","CODIGO":"030","ID_CIUDAD":"05030","ESTADO":"0"},{...}]}
     *
     */
    $this->get('[/{lastSyncDate}]', function (Request $request, Response $response, $args) {
        $municipios = new Municipio($this->db);
        if($args['lastSyncDate']) {
            $lastSyncDate = new \DateTime();
            $lastSyncDate->setTimeStamp(strtotime($args['lastSyncDate']));
            return $response->withJson(["MUNICIPIOS" => $municipios->getUpdates($lastSyncDate)->values()]);
        }
        return $response->withJson(["MUNICIPIOS" => $municipios->getAll()->values()]);
    });
});

$app->group('/Departamentos', function () {
    /**
     * @api {GET} /Departamentos/:date
     * @apiGroup Departamentos
     * @apiDescription Retorna Todos los registros de Departamentos, si se provee :date se filtraran los resultados modificados a partir de :date
     * @apiPermission user
     * @apiSampleRequest off
     *
     * @apiHeader {String} Authorization Clave Unica de Acceso RFC2045-MIME (Base64).
     * @apiHeaderExample {Json} Ejemplo Header:
     * {"Authorization":"Basic cHJ1ZWJhOjM0MDVlMmY1ODYxOTNiMjQ0MDRkODlmMzZjNDdmYmU3"}
     *
     * @apiParam {Date} [date] Fecha de Ultima Sincronizacion de Registros formato <strong>UNIX TIMESTAMP</strong> o <strong>yyyy-mm-dd</strong>

     *
     * @apiError {Json} 401 Usuario o Contraseña Invalidos
     * @apiErrorExample {Json} Ejemplo Error 401:
     * {"ERROR":"USARIO/CONTRASEÑA INVALIDOS"}
     *
     * @apiError {Json} 404 LO QUE BUSCAS DEFINITIVAMENTE NO ESTÁ AQUÍ...
     * @apiErrorExample {Json} Ejemplo Error 404:
     * {"ERROR":"LO QUE BUSCAS DEFINITIVAMENTE NO ESTÁ AQUÍ..."}
     *
     * @apiSuccess {Json} 200 Arreglo de Objetos de tipo DEPARTAMENTO
     * @apiSuccessExample {Json} Ejemplo Respuesta:
     *  {"DEPARTAMENTOS":[{"ID" : "2","NOMBRE" : "ANTIOQUIA","PAIS" : "57","CODIGO" : "05","ACTIVO" : "0"},{...}]}
     *
     */
    $this->get('[/{lastSyncDate}]', function (Request $request, Response $response, $args) {
        $departamentos = new Departamento($this->db);
        if($args['lastSyncDate']) {
            $lastSyncDate = new \DateTime();
            $lastSyncDate->setTimeStamp(strtotime($args['lastSyncDate']));
            return $response->withJson(['DEPARTAMENTOS' => $departamentos->getUpdates($lastSyncDate)->values()]);
        }
        return $response->withJson(['DEPARTAMENTOS' => $departamentos->getAll()->values()]);

    });
});

/**
 * @api {GET} /CIE10
 * @apiGroup CIE10
 * @apiDescription Retorna La Lista de CIE10 Completa
 * @apiPermission user
 * @apiSampleRequest off
 *
 * @apiHeader {String} Authorization Clave Unica de Acceso RFC2045-MIME (Base64).
 * @apiHeaderExample {Json} Ejemplo Header:
 * {"Authorization":"Basic eWVubnkubmF2YXJybzowZTljMzA1YmUyMDg2ZGRkZGU3NDM3MzUxMDVhY2ViNQ=="}
 *
 * @apiError {Json} 401 Usuario o Contraseña Invalidos
 * @apiErrorExample {Json} Ejemplo Error 401:
 * {"ERROR":"USARIO/CONTRASEÑA INVALIDOS"}
 *
 * @apiError {Json} 404 LO QUE BUSCAS DEFINITIVAMENTE NO ESTÁ AQUÍ...
 * @apiErrorExample {Json} Ejemplo Error 404:
 * {"ERROR":"LO QUE BUSCAS DEFINITIVAMENTE NO ESTÁ AQUÍ..."}
 *
 * @apiSuccess {Json} 200 Arreglo de Objetos de tipo CIE10
 * @apiSuccessExample {Json} Ejemplo Respuesta:
 * {"CIE10":[{"ID":"1","CODIGO":"A000","DESCRIPCION":"COLERA DEBIDO A VIBRIO CHOLERAE O1, BIOTIPO CHOLERAE","CLASE":"","ACTIVO":"0"},{...}]}
 *
 */
$app->get('/CIE10', function (Request $request, Response $response) {
    $cie10 = new CIE10($this->db);
    return $response->withJson(['CIE10' => $cie10->getAll()->values()]);
});

/**
 * @api {GET} /TiposUsuario
 * @apiGroup TiposUsuario
 * @apiDescription Retorna La Lista de Tipos de Usuarios Completa
 * @apiPermission user
 * @apiSampleRequest off
 *
 * @apiHeader {String} Authorization Clave Unica de Acceso RFC2045-MIME (Base64).
 * @apiHeaderExample {Json} Ejemplo Header:
 * {"Authorization":"Basic eWVubnkubmF2YXJybzowZTljMzA1YmUyMDg2ZGRkZGU3NDM3MzUxMDVhY2ViNQ=="}
 *
 * @apiError {Json} 401 Usuario o Contraseña Invalidos
 * @apiErrorExample {Json} Ejemplo Error 401:
 * {"ERROR":"USARIO/CONTRASEÑA INVALIDOS"}
 *
 * @apiError {Json} 404 LO QUE BUSCAS DEFINITIVAMENTE NO ESTÁ AQUÍ...
 * @apiErrorExample {Json} Ejemplo Error 404:
 * {"ERROR":"LO QUE BUSCAS DEFINITIVAMENTE NO ESTÁ AQUÍ..."}
 *
 * @apiSuccess {Json} 200 Arreglo de Objetos de tipo TIPO_USUARIO
 * @apiSuccessExample {Json} Ejemplo Respuesta:
 * {"TIPOS_USUARIO":[{"ID":"1","NOMBRE":"Administrador","CODIGO":"1","ESTADO":"0","ABREVIATURA":"ADM"},{...}]}
 *
 */
$app->get('/TiposUsuario', function(Request $request, Response $response){
    $tiposUsuario = new UserType($this->db);
    return $response->withJson(["TIPOS_USUARIO" => $tiposUsuario->getAll()->values()]);
});

//TODO Areas especificas para el municipio o departamento del requesting User
$app->group('/Areas', function () {
    /**
     * @api {GET} /Areas/:date
     * @apiGroup Areas
     * @apiDescription Retorna Todos los registros de Areas, si se provee :date se filtraran los resultados modificados a partir de :date
     * @apiPermission user
     * @apiSampleRequest off
     *
     * @apiHeader {String} Authorization Clave Unica de Acceso RFC2045-MIME (Base64).
     * @apiHeaderExample {Json} Ejemplo Header:
     * {"Authorization":"Basic cHJ1ZWJhOjM0MDVlMmY1ODYxOTNiMjQ0MDRkODlmMzZjNDdmYmU3"}
     *
     * @apiParam {Date} [date] Fecha de Ultima Sincronizacion de Registros formato <strong>UNIX TIMESTAMP</strong> o <strong>yyyy-mm-dd</strong>

     *
     * @apiError {Json} 401 Usuario o Contraseña Invalidos
     * @apiErrorExample {Json} Ejemplo Error 401:
     * {"ERROR":"USARIO/CONTRASEÑA INVALIDOS"}
     *
     * @apiError {Json} 404 LO QUE BUSCAS DEFINITIVAMENTE NO ESTÁ AQUÍ...
     * @apiErrorExample {Json} Ejemplo Error 404:
     * {"ERROR":"LO QUE BUSCAS DEFINITIVAMENTE NO ESTÁ AQUÍ..."}
     *
     * @apiSuccess {Json} 200 Arreglo de Objetos de tipo AREA
     * @apiSuccessExample {Json} Ejemplo Respuesta:
     * {"AREAS":[{"ID_AREA":"516","DESCRIPCION":"EL RESPALDO,(VR)  ","CODAREA":"05107R00209","CODPOSTAL":"","DPTO":"05","MUNICIPIO":"107","ZONA":"R","NIVEL4":"00","CODIGO":"209","ESTADO":"A","ORDEN":"516"},{...}]}
     *
     */
    $this->get('[/{lastSyncDate}]', function (Request $request, Response $response, $args) {
        $areas = new Area($this->db);
        if($args['lastSyncDate']) {
            $lastSyncDate = new \DateTime();
            $lastSyncDate->setTimeStamp(strtotime($args['lastSyncDate']));
            return $response->withJson(['AREAS' => $areas->getUpdates($lastSyncDate)->values()]);
        }
        return $response->withJson(['AREAS' => $areas->getAll()->values()]);
    });
});

//TODO IPS especificas para el municipio o departamento del requesting User
$app->group('/Ips', function () {
    /**
     * @api {GET} /Ips/:date
     * @apiGroup Ips
     * @apiDescription Retorna Todos los registros de Instituciones Prestadoras de Servicios, si se provee :date se filtraran los resultados modificados a partir de :date
     * @apiPermission user
     * @apiSampleRequest off
     *
     * @apiHeader {String} Authorization Clave Unica de Acceso RFC2045-MIME (Base64).
     * @apiHeaderExample {Json} Ejemplo Header:
     * {"Authorization":"Basic cHJ1ZWJhOjM0MDVlMmY1ODYxOTNiMjQ0MDRkODlmMzZjNDdmYmU3"}
     *
     * @apiParam {Date} [date] Fecha de Ultima Sincronizacion de Registros formato <strong>UNIX TIMESTAMP</strong> o <strong>yyyy-mm-dd</strong>

     *
     * @apiError {Json} 401 Usuario o Contraseña Invalidos
     * @apiErrorExample {Json} Ejemplo Error 401:
     * {"ERROR":"USARIO/CONTRASEÑA INVALIDOS"}
     *
     * @apiError {Json} 404 LO QUE BUSCAS DEFINITIVAMENTE NO ESTÁ AQUÍ...
     * @apiErrorExample {Json} Ejemplo Error 404:
     * {"ERROR":"LO QUE BUSCAS DEFINITIVAMENTE NO ESTÁ AQUÍ..."}
     *
     * @apiSuccess {Json} 200 Arreglo de Objetos de tipo IPS
     * @apiSuccessExample {Json} Ejemplo Respuesta:
     * {"IPS":[{"ID":"1","COD_INS":"1","NIT":"1","NOMBRE":"SALUDFAMILIAR IPS","DIRECCION":"CARRERA 57 # 74 - 71","PAIS":"57","DPTO":"08","CIUDAD":"001","TELEFONO":"3588128","MOVIL":"3162413498","EMAIL":"rennimunoz@saludfamiliar.com.co","REPRESENTANTE":"","ACTIVO":"0"},{...}]}
     *
     */
    $this->get('[/{lastSyncDate}]', function (Request $request, Response $response, $args) {
        $ips = new Ips($this->db);
        if($args['lastSyncDate']) {
            $lastSyncDate = new \DateTime();
            $lastSyncDate->setTimeStamp(strtotime($args['lastSyncDate']));
            return $response->withJson(['IPS' => $ips->getUpdates($lastSyncDate)->values()]);
        }
        return $response->withJson(['IPS' => $ips->getAll()->values()]);
    });
});

$app->group('/Novedades/', function () {
    /**
     * @api {GET} /Novedades/tipos/:date Tipos
     * @apiGroup Novedades
     * @apiDescription Retorna Todos los registros de Tipos de Novedades, si se provee :date se filtraran los resultados modificados a partir de :date
     * @apiPermission user
     * @apiSampleRequest off
     *
     * @apiHeader {String} Authorization Clave Unica de Acceso RFC2045-MIME (Base64).
     * @apiHeaderExample {Json} Ejemplo Header:
     * {"Authorization":"Basic cHJ1ZWJhOjM0MDVlMmY1ODYxOTNiMjQ0MDRkODlmMzZjNDdmYmU3"}
     *
     * @apiParam {Date} [date] Fecha de Ultima Sincronizacion de Registros formato <strong>UNIX TIMESTAMP</strong> o <strong>yyyy-mm-dd</strong>

     *
     * @apiError {Json} 401 Usuario o Contraseña Invalidos
     * @apiErrorExample {Json} Ejemplo Error 401:
     * {"ERROR":"USARIO/CONTRASEÑA INVALIDOS"}
     *
     * @apiError {Json} 404 LO QUE BUSCAS DEFINITIVAMENTE NO ESTÁ AQUÍ...
     * @apiErrorExample {Json} Ejemplo Error 404:
     * {"ERROR":"LO QUE BUSCAS DEFINITIVAMENTE NO ESTÁ AQUÍ..."}
     *
     * @apiSuccess {Json} 200 Arreglo de Objetos de tipo TIPO_NOVEDAD
     * @apiSuccessExample {Json} Ejemplo Respuesta:
     * {"TIPOS_NOVEDAD":[{"TIPO_NOVEDAD":"NA-03","DESCRIPCION":"NO ATIENDE PORQUE YA FUE VISITADO EN OTRO NUCLEO FAMILIAR","ESTADO":"A"},{...}]}
     *
     */
    $this->get('tipos[/{lastSyncDate}]', function (Request $request, Response $response, $args){
        $tipos = new NewsType($this->db);
        if($args['lastSyncDate']) {
            $lastSyncDate = new \DateTime();
            $lastSyncDate->setTimeStamp(strtotime($args['lastSyncDate']));
            return $response->withJson(['TIPOS_NOVEDAD' => $tipos->getUpdates($lastSyncDate)->values()]);
        }
        return $response->withJson(['TIPOS_NOVEDAD' => $tipos->getAll()->values()]);
    });

    /**
     * @api {GET} /Novedades/listas/:date Listas
     * @apiGroup Novedades
     * @apiDescription Retorna Todas las Listas de Novedades, si se provee :date se filtraran los resultados modificados a partir de :date
     * @apiPermission user
     * @apiSampleRequest off
     *
     * @apiHeader {String} Authorization Clave Unica de Acceso RFC2045-MIME (Base64).
     * @apiHeaderExample {Json} Ejemplo Header:
     * {"Authorization":"Basic cHJ1ZWJhOjM0MDVlMmY1ODYxOTNiMjQ0MDRkODlmMzZjNDdmYmU3"}
     *
     * @apiParam {Date} [date] Fecha de Ultima Sincronizacion de Registros formato <strong>UNIX TIMESTAMP</strong> o <strong>yyyy-mm-dd</strong>

     *
     * @apiError {Json} 401 Usuario o Contraseña Invalidos
     * @apiErrorExample {Json} Ejemplo Error 401:
     * {"ERROR":"USARIO/CONTRASEÑA INVALIDOS"}
     *
     * @apiError {Json} 404 LO QUE BUSCAS DEFINITIVAMENTE NO ESTÁ AQUÍ...
     * @apiErrorExample {Json} Ejemplo Error 404:
     * {"ERROR":"LO QUE BUSCAS DEFINITIVAMENTE NO ESTÁ AQUÍ..."}
     *
     * @apiSuccess {Json} 200 Arreglo de Objetos de tipo LISTA_NOVEDAD
     * @apiSuccessExample {Json} Ejemplo Respuesta:
     * {"LISTAS_NOVEDAD":[{"COD_NOVEDAD":"1","TIPO_NOVEDAD":"N01","DESCRIPCION":"NUEVO TIPO DE DOCUMENTO DE IDENTIDAD","ESTADO":"A","VALOR":"1"},{...}]}
     *
     */
    $this->get('listas/{lastSyncDate}',function (Request $request, Response $response, $args){
        $listas = new NewsList($this->db);
        if($args['lastSyncDate']) {
            $lastSyncDate = new \DateTime();
            $lastSyncDate->setTimeStamp(strtotime($args['lastSyncDate']));
            return $response->withJson(['LISTAS_NOVEDAD' => $listas->getUpdates($lastSyncDate)->values()]);
        }
        return $response->withJson(['LISTAS_NOVEDAD' => $listas->getAll()->values()]);
    });
});

$app->group('/PEC/', function() {
    /**
     * @api {GET} /PEC/GruposObjetivo Grupos
     * @apiGroup PEC
     * @apiDescription Retorna la lista de Grupos Objetivo de PEC Completa
     * @apiPermission user
     * @apiSampleRequest off
     *
     * @apiHeader {String} Authorization Clave Unica de Acceso RFC2045-MIME (Base64).
     * @apiHeaderExample {Json} Ejemplo Header:
     * {"Authorization":"Basic eWVubnkubmF2YXJybzowZTljMzA1YmUyMDg2ZGRkZGU3NDM3MzUxMDVhY2ViNQ=="}
     *
     * @apiError {Json} 401 Usuario o Contraseña Invalidos
     * @apiErrorExample {Json} Ejemplo Error 401:
     * {"ERROR":"USARIO/CONTRASEÑA INVALIDOS"}
     *
     * @apiError {Json} 404 LO QUE BUSCAS DEFINITIVAMENTE NO ESTÁ AQUÍ...
     * @apiErrorExample {Json} Ejemplo Error 404:
     * {"ERROR":"LO QUE BUSCAS DEFINITIVAMENTE NO ESTÁ AQUÍ..."}
     *
     * @apiSuccess {Json} 200 Arreglo de Objetos de tipo PEC_GRUPO_OBJETIVO
     * @apiSuccessExample {Json} Ejemplo Respuesta:
     * {"PEC_GRUPOS_OBJETIVO":[{"ID_OBJETIVO":"0 ","NOMBRE_OBJETIVO":"COORDINADORES LIDERES"},{...}]}
     *
     */
    $this->get('GruposObjetivo', function (Request $request, Response $response){
        $gruposObjetivo = new PECObjetive($this->db);
        return $response->withJson(['PEC_GRUPOS_OBJETIVO' => $gruposObjetivo->getAll()->values()]);
    });

    /**
     * @api {GET} /PEC/Guias/:date Guias
     * @apiGroup PEC
     * @apiDescription Retorna Las Guias PEC, si se provee :date se filtraran los resultados modificados a partir de :date
     * @apiPermission user
     * @apiSampleRequest off
     *
     * @apiHeader {String} Authorization Clave Unica de Acceso RFC2045-MIME (Base64).
     * @apiHeaderExample {Json} Ejemplo Header:
     * {"Authorization":"Basic cHJ1ZWJhOjM0MDVlMmY1ODYxOTNiMjQ0MDRkODlmMzZjNDdmYmU3"}
     *
     * @apiParam {Date} [date] Fecha de Ultima Sincronizacion de Registros formato <strong>UNIX TIMESTAMP</strong> o <strong>yyyy-mm-dd</strong>
     *
     * @apiError {Json} 401 Usuario o Contraseña Invalidos
     * @apiErrorExample {Json} Ejemplo Error 401:
     * {"ERROR":"USARIO/CONTRASEÑA INVALIDOS"}
     *
     * @apiError {Json} 404 LO QUE BUSCAS DEFINITIVAMENTE NO ESTÁ AQUÍ...
     * @apiErrorExample {Json} Ejemplo Error 404:
     * {"ERROR":"LO QUE BUSCAS DEFINITIVAMENTE NO ESTÁ AQUÍ..."}
     *
     * @apiSuccess {Json} 200 Arreglo de Objetos de tipo PEC_GUIA
     * @apiSuccessExample {Json} Ejemplo Respuesta:
     * {"PEC_GUIAS":[{"ID_GUIA":"1","NOMBRE_GUIA":"GUIA 1 ","GRUPO_OBJETIVO":"1|3","PROCESOS":"6|"},{...}]}
     *
     */
    $this->get('Guias[/{lastSyncDate}]', function (Request $request, Response $response, $args){
        $guias = new PECGuide($this->db);
        if($args['lastSyncDate']) {
            $lastSyncDate = new \DateTime();
            $lastSyncDate->setTimeStamp(strtotime($args['lastSyncDate']));
            return $response->withJson(['PEC_GUIAS' => $guias->getUpdates($lastSyncDate)->values()]);
        }
        return $response->withJson(['PEC_GUIAS' => $guias->getAll()->values()]);
    });

    /**
     * @api {GET} /PEC/Procesos Procesos
     * @apiGroup PEC
     * @apiDescription Retorna los Procesos PEC
     * @apiPermission user
     * @apiSampleRequest off
     *
     * @apiHeader {String} Authorization Clave Unica de Acceso RFC2045-MIME (Base64).
     * @apiHeaderExample {Json} Ejemplo Header:
     * {"Authorization":"Basic eWVubnkubmF2YXJybzowZTljMzA1YmUyMDg2ZGRkZGU3NDM3MzUxMDVhY2ViNQ=="}
     *
     * @apiError {Json} 401 Usuario o Contraseña Invalidos
     * @apiErrorExample {Json} Ejemplo Error 401:
     * {"ERROR":"USARIO/CONTRASEÑA INVALIDOS"}
     *
     * @apiError {Json} 404 LO QUE BUSCAS DEFINITIVAMENTE NO ESTÁ AQUÍ...
     * @apiErrorExample {Json} Ejemplo Error 404:
     * {"ERROR":"LO QUE BUSCAS DEFINITIVAMENTE NO ESTÁ AQUÍ..."}
     *
     * @apiSuccess {Json} 200 Arreglo de Objetos de tipo PEC_PROCESO
     * @apiSuccessExample {Json} Ejemplo Respuesta:
     * {"PEC_PROCESOS":[{"ID_PROCESO":"1","NOMBRE_PROCESO":"ASEGURAMIENTO"},{...}]}
     *
     */
    $this->get('Procesos', function (Request $request, Response $response){
        $procesos = new PECProcess($this->db);
        return $response->withJson(['PEC_PROCESOS' => $procesos->getAll()->values()]);
    });

    /**
     * @api {GET} /PEC/Programacion Programacion
     * @apiGroup PEC
     * @apiDescription Retorna la Programacion de Actividades PEC
     * @apiPermission user
     * @apiSampleRequest off
     *
     * @apiHeader {String} Authorization Clave Unica de Acceso RFC2045-MIME (Base64).
     * @apiHeaderExample {Json} Ejemplo Header:
     * {"Authorization":"Basic eWVubnkubmF2YXJybzowZTljMzA1YmUyMDg2ZGRkZGU3NDM3MzUxMDVhY2ViNQ=="}
     *
     * @apiError {Json} 401 Usuario o Contraseña Invalidos
     * @apiErrorExample {Json} Ejemplo Error 401:
     * {"ERROR":"USARIO/CONTRASEÑA INVALIDOS"}
     *
     * @apiError {Json} 404 LO QUE BUSCAS DEFINITIVAMENTE NO ESTÁ AQUÍ...
     * @apiErrorExample {Json} Ejemplo Error 404:
     * {"ERROR":"LO QUE BUSCAS DEFINITIVAMENTE NO ESTÁ AQUÍ..."}
     *
     * @apiSuccess {Json} 200 Arreglo de Objetos de tipo PEC_PROGRAMACION
     * @apiSuccessExample {Json} Ejemplo Respuesta:
     * {"PEC_PROGRAMACIONES":[{"ID":"1","GUIA":"2","DEPARTAMENTO":"  ","CIUDAD":"     ","MIN_ASISTENTES":"20","FECHA_INICIAL":"2014-07-01","FECHA_FINAL":"2014-07-31","GRUPO_OBJETO":"","HORAS":"2"},{...}]}
     *
     */
    $this->get('Programacion', function (Request $request, Response $response){
        $programaciones = new PECSchedule($this->db);
        return $response->withJson(['PEC_PROGRAMACIONES' => $programaciones->getAll()->values()]);
    });

    /**
     * @api {GET} /PEC/Temas/:date Temas
     * @apiGroup PEC
     * @apiDescription Retorna los Temas PEC, si se provee :date se filtraran los resultados modificados a partir de :date
     * @apiPermission user
     * @apiSampleRequest off
     *
     * @apiHeader {String} Authorization Clave Unica de Acceso RFC2045-MIME (Base64).
     * @apiHeaderExample {Json} Ejemplo Header:
     * {"Authorization":"Basic cHJ1ZWJhOjM0MDVlMmY1ODYxOTNiMjQ0MDRkODlmMzZjNDdmYmU3"}
     *
     * @apiParam {Date} [date] Fecha de Ultima Sincronizacion de Registros formato <strong>UNIX TIMESTAMP</strong> o <strong>yyyy-mm-dd</strong>

     *
     * @apiError {Json} 401 Usuario o Contraseña Invalidos
     * @apiErrorExample {Json} Ejemplo Error 401:
     * {"ERROR":"USARIO/CONTRASEÑA INVALIDOS"}
     *
     * @apiError {Json} 404 LO QUE BUSCAS DEFINITIVAMENTE NO ESTÁ AQUÍ...
     * @apiErrorExample {Json} Ejemplo Error 404:
     * {"ERROR":"LO QUE BUSCAS DEFINITIVAMENTE NO ESTÁ AQUÍ..."}
     *
     * @apiSuccess {Json} 200 Arreglo de Objetos de tipo PEC_TEMA
     * @apiSuccessExample {Json} Ejemplo Respuesta:
     * {"PEC_TEMAS":[{"ID_GUIA":"1","ID_TEMA":"1","NOMBRE_TEMA":"Habilidades Comunicativas","PROCESOS":"1|3","SERV_GRUPAL":"28","SERV_INDIVIDUAL":""},{...}]}
     *
     */
    $this->get('Temas[/{lastSyncDate}]', function (Request $request, Response $response, $args){
        $temas = new PECTopic($this->db);
        if($args['lastSyncDate']) {
            $lastSyncDate = new \DateTime();
            $lastSyncDate->setTimeStamp(strtotime($args['lastSyncDate']));
            return $response->withJson(['PEC_TEMAS' => $temas->getUpdates($lastSyncDate)->values()]);
        }
        return $response->withJson(['PEC_TEMAS' => $temas->getAll()->values()]);
    });
});

/**
 * @api {GET} /Medicamentos
 * @apiGroup Medicamentos
 * @apiDescription Retorna el Listado de Medicamentos
 * @apiPermission user
 * @apiSampleRequest off
 *
 * @apiHeader {String} Authorization Clave Unica de Acceso RFC2045-MIME (Base64).
 * @apiHeaderExample {Json} Ejemplo Header:
 * {"Authorization":"Basic eWVubnkubmF2YXJybzowZTljMzA1YmUyMDg2ZGRkZGU3NDM3MzUxMDVhY2ViNQ=="}
 *
 * @apiError {Json} 401 Usuario o Contraseña Invalidos
 * @apiErrorExample {Json} Ejemplo Error 401:
 * {"ERROR":"USARIO/CONTRASEÑA INVALIDOS"}
 *
 * @apiError {Json} 404 LO QUE BUSCAS DEFINITIVAMENTE NO ESTÁ AQUÍ...
 * @apiErrorExample {Json} Ejemplo Error 404:
 * {"ERROR":"LO QUE BUSCAS DEFINITIVAMENTE NO ESTÁ AQUÍ..."}
 *
 * @apiSuccess {Json} 200 Arreglo de Objetos de tipo MEDICAMENTO
 * @apiSuccessExample {Json} Ejemplo Respuesta:
 * {"MEDICAMENTOS":[{"ID_MEDICAMENTO":"1","CODIGO":"J05AF0601","DESCRIPCION":"ABACAVIR","PRINCIPIO":"ABACAVIR","CONCENTRACION":"Incluye todas las concentraciones","PRESENTACION":"TABLETA CON O SIN RECUBRIMIENTO QUE NO MODIFIQUE LA LIBERACI\u00d3N DEL F\u00c1RMACO, C\u00c1PSULA","ACLARACION":"","GRUPO":""},{...}]
 *
 */
$app->group('/Medicamentos', function() {
    $this->get('', function (Request $request, Response $response) {
        $medicines = new Medicine($this->db);
        return $response->withJson(['MEDICAMENTOS' => $medicines->getAll()->values()]);
    });
});

/**
 * @api {GET} /Procedimientos
 * @apiGroup Procedimientos
 * @apiDescription Retorna el Listado de Procedimientos
 * @apiPermission user
 * @apiSampleRequest off
 *
 * @apiHeader {String} Authorization Clave Unica de Acceso RFC2045-MIME (Base64).
 * @apiHeaderExample {Json} Ejemplo Header:
 * {"Authorization":"Basic eWVubnkubmF2YXJybzowZTljMzA1YmUyMDg2ZGRkZGU3NDM3MzUxMDVhY2ViNQ=="}
 *
 * @apiError {Json} 401 Usuario o Contraseña Invalidos
 * @apiErrorExample {Json} Ejemplo Error 401:
 * {"ERROR":"USARIO/CONTRASEÑA INVALIDOS"}
 *
 * @apiError {Json} 404 LO QUE BUSCAS DEFINITIVAMENTE NO ESTÁ AQUÍ...
 * @apiErrorExample {Json} Ejemplo Error 404:
 * {"ERROR":"LO QUE BUSCAS DEFINITIVAMENTE NO ESTÁ AQUÍ..."}
 *
 * @apiSuccess {Json} 200 Arreglo de Objetos de tipo PROCEDIMIENTO
 * @apiSuccessExample {Json} Ejemplo Respuesta:
 * {"PROCEDIMIENTOS":[{"ID_PROCEDIMIENTO":"3186","CODIGO":"395307","DESCRIPCION":"CIERRE DE FISTULA VENOVENOSA VIA ABIERTA","ESTADO":"1"},{...}]
 *
 */
$app->group('/Procedimientos', function() {
    $this->get('', function (Request $request, Response $response) {
        $procedures = new Procedure($this->db);
        return $response->withJson(['PROCEDIMIENTOS' => $procedures->getAll()->values()]);
    });
});

/**
 * @api {GET} /Laboratorios
 * @apiGroup Laboratorios
 * @apiDescription Retorna el Listado de Laboratorios
 * @apiPermission user
 * @apiSampleRequest off
 *
 * @apiHeader {String} Authorization Clave Unica de Acceso RFC2045-MIME (Base64).
 * @apiHeaderExample {Json} Ejemplo Header:
 * {"Authorization":"Basic eWVubnkubmF2YXJybzowZTljMzA1YmUyMDg2ZGRkZGU3NDM3MzUxMDVhY2ViNQ=="}
 *
 * @apiError {Json} 401 Usuario o Contraseña Invalidos
 * @apiErrorExample {Json} Ejemplo Error 401:
 * {"ERROR":"USARIO/CONTRASEÑA INVALIDOS"}
 *
 * @apiError {Json} 404 LO QUE BUSCAS DEFINITIVAMENTE NO ESTÁ AQUÍ...
 * @apiErrorExample {Json} Ejemplo Error 404:
 * {"ERROR":"LO QUE BUSCAS DEFINITIVAMENTE NO ESTÁ AQUÍ..."}
 *
 * @apiSuccess {Json} 200 Arreglo de Objetos de tipo LABORATORIO
 * @apiSuccessExample {Json} Ejemplo Respuesta:
 * {"LABORATORIOS":[{"ID_LABORATORIO":"1","CODIGO":"1","DESCRIPCION":"LABORATORIO DE EJEMPLO","VALORREF1":"10","VALORREF2":"15","TIPO":"1","ORDEN":"1"},{...}]}
 *
 */
$app->group('/Laboratorios', function() {
    $this->get('', function (Request $request, Response $response) {
        $laboratories = new Laboratory($this->db);
        return $response->withJson(['LABORATORIOS' => $laboratories->getAll()->values()]);
    });
});

$app->group('/Modulos', function() {

    /**
     * @api {GET} /Modulos/:date
     * @apiGroup Modulos
     * @apiDescription Retorna el Listado de Modulos, si se provee :date se filtraran los resultados modificados a partir de :date
     * @apiPermission user
     * @apiSampleRequest off
     *
     * @apiHeader {String} Authorization Clave Unica de Acceso RFC2045-MIME (Base64).
     * @apiHeaderExample {Json} Ejemplo Header:
     * {"Authorization":"Basic cHJ1ZWJhOjM0MDVlMmY1ODYxOTNiMjQ0MDRkODlmMzZjNDdmYmU3"}
     *
     * @apiParam {Date} [date] Fecha de Ultima Sincronizacion de Registros formato <strong>UNIX TIMESTAMP</strong> o <strong>yyyy-mm-dd</strong>

     *
     * @apiError {Json} 401 Usuario o Contraseña Invalidos
     * @apiErrorExample {Json} Ejemplo Error 401:
     * {"ERROR":"USARIO/CONTRASEÑA INVALIDOS"}
     *
     * @apiError {Json} 404 LO QUE BUSCAS DEFINITIVAMENTE NO ESTÁ AQUÍ...
     * @apiErrorExample {Json} Ejemplo Error 404:
     * {"ERROR":"LO QUE BUSCAS DEFINITIVAMENTE NO ESTÁ AQUÍ..."}
     *
     * @apiSuccess {Json} 200 Arreglo de Objetos de tipo MODULO
     * @apiSuccessExample {Json} Ejemplo Respuesta:
     * {"MODULOS":[{"ID_MODULO":"1","DESCRIPCION":"IDENTIFICACION Y UBICACI\u00d3N","CODIGO":"1","ENTIDAD":"","ESTADO":"A","ORDEN":"1","TIPO":"P","VALIDAR":"N","EDADINI":"","EDADFIN":"","GENERO":"A","MODULO_P":" ","REGISTROS":"N"},{"ID_MODULO":"2","DESCRIPCION":"PERSONAS DE LA FAMILIA","CODIGO":"2","ENTIDAD":"","ESTADO":"A","ORDEN":"2","TIPO":"F","VALIDAR":"N","EDADINI":"","EDADFIN":"","GENERO":"A","MODULO_P":"","REGISTROS":"S"},{...}]}
     *
     */
    $this->get('[/{lastSyncDate}]', function (Request $request, Response $response, $args){
        $modulos = new Module($this->db);
        if($args['lastSyncDate']) {
            $lastSyncDate = new \DateTime();
            $lastSyncDate->setTimeStamp(strtotime($args['lastSyncDate']));
            return $response->withJson(['MODULOS' => $modulos->getUpdates($lastSyncDate)->values()]);
        }
        return $response->withJson(['MODULOS' => $modulos->getAll()->values()]);
    });
});

$app->group('/Preguntas', function() {

    /**
     * @api {GET} /Preguntas/:date
     * @apiGroup Preguntas
     * @apiDescription Retorna el Listado de Preguntas, si se provee :date se filtraran los resultados modificados a partir de :date
     * @apiPermission user
     * @apiSampleRequest off
     *
     * @apiHeader {String} Authorization Clave Unica de Acceso RFC2045-MIME (Base64).
     * @apiHeaderExample {Json} Ejemplo Header:
     * {"Authorization":"Basic cHJ1ZWJhOjM0MDVlMmY1ODYxOTNiMjQ0MDRkODlmMzZjNDdmYmU3"}
     *
     * @apiParam {Date} [date] Fecha de Ultima Sincronizacion de Registros formato <strong>UNIX TIMESTAMP</strong> o <strong>yyyy-mm-dd</strong>

     *
     * @apiError {Json} 401 Usuario o Contraseña Invalidos
     * @apiErrorExample {Json} Ejemplo Error 401:
     * {"ERROR":"USARIO/CONTRASEÑA INVALIDOS"}
     *
     * @apiError {Json} 404 LO QUE BUSCAS DEFINITIVAMENTE NO ESTÁ AQUÍ...
     * @apiErrorExample {Json} Ejemplo Error 404:
     * {"ERROR":"LO QUE BUSCAS DEFINITIVAMENTE NO ESTÁ AQUÍ..."}
     *
     * @apiSuccess {Json} 200 Arreglo de Objetos de tipo PREGUNTA
     * @apiSuccessExample {Json} Ejemplo Respuesta:
     * {"PREGUNTAS":[{"ID_PREGUNTA":"20788","DESCRIPCION":"COD. DPTO","ENTIDAD":"HC_MEDICA","ATRIBUTO":"DPTO","TIPOCAMPO":"","LONCAMPO":"","DEPENDE":"","OBLIGATORIO":"","ID_MODULO":"","ID_LISTA":"","NOMLISTA":"","VALORLISTA":"","CAMPOSIRFAM":"","TIPO":"","VALIDAR":"","EDADINI":"","EDADFIN":"","GENERO":"","ESTADO":"","VISIBILIDAD":"","NIVEL":"","CODIGO":"","ORDEN":"","FECCREA":"","FECMODI":""},{...}]}
     *
     */
    $this->get('[/{lastSyncDate}]', function (Request $request, Response $response, $args){
        $preguntas = new Question($this->db);
        if($args['lastSyncDate']) {
            $lastSyncDate = new \DateTime();
            $lastSyncDate->setTimeStamp(strtotime($args['lastSyncDate']));
            return $response->withJson(['PREGUNTAS' => $preguntas->getUpdates($lastSyncDate)->values()]);
        }
        return $response->withJson(['PREGUNTAS' => $preguntas->getAll()->values()]);
    });
});

$app->group('/Usuarios', function() {

    /**
     * @api {GET} /Usuarios/:date
     * @apiGroup Usuarios
     * @apiDescription Retorna el Listado de Usuarios del Sistema, si se provee :date se filtraran los resultados modificados a partir de :date
     * @apiPermission user
     * @apiSampleRequest off
     *
     * @apiHeader {String} Authorization Clave Unica de Acceso RFC2045-MIME (Base64).
     * @apiHeaderExample {Json} Ejemplo Header:
     * {"Authorization":"Basic cHJ1ZWJhOjM0MDVlMmY1ODYxOTNiMjQ0MDRkODlmMzZjNDdmYmU3"}
     *
     * @apiParam {Date} [date] Fecha de Ultima Sincronizacion de Registros formato <strong>UNIX TIMESTAMP</strong> o <strong>yyyy-mm-dd</strong>

     *
     * @apiError {Json} 401 Usuario o Contraseña Invalidos
     * @apiErrorExample {Json} Ejemplo Error 401:
     * {"ERROR":"USARIO/CONTRASEÑA INVALIDOS"}
     *
     * @apiError {Json} 404 LO QUE BUSCAS DEFINITIVAMENTE NO ESTÁ AQUÍ...
     * @apiErrorExample {Json} Ejemplo Error 404:
     * {"ERROR":"LO QUE BUSCAS DEFINITIVAMENTE NO ESTÁ AQUÍ..."}
     *
     * @apiSuccess {Json} 200 Arreglo de Objetos de tipo PREGUNTA
     * @apiSuccessExample {Json} Ejemplo Respuesta:
     * {"USUARIOS":[{"ID":"1","NOMBRE":"admin","PASSWORD":"21232f297a57a5a743894a0e4a801fc3","TIPO_USUARIO":"1","ACTIVO":"0","EMAIL":"rennimunoz@saludfamiliar.com.co","DPTO":"08","PAIS":"57","CIUDAD":"758","MOVIL":"3162413498","TELEFONO":"3930527","DIRECCION":"Calle 73a # 22 - 45 PISO 2","DOC_IDENT":"73238372","NOMBRES":"RENNI DE JESUS","APELLIDOS":"MU\u00d1OZ OROZCO","CARGO":"ADMINISTRADOR","TIPO_DOC":"1","INFORMA_A":"1","FECHA_CREA":"2012-10-30 11:54:09.000000","USER_CREA":"admin","IP_CREA":"127.0.0.1","FECHA_MODI":"2015-10-17 09:47:06.000000","USER_MODI":"admin","IP_MODI":"181.192.158.23","START_LATITUD":"","START_LONGITUD":""},{...}]}
     *
     */
    $this->get('[/{lastSyncDate}]', function (Request $request, Response $response, $args){
        $usuarios = new User($this->db);
        if($args['lastSyncDate']) {
            $lastSyncDate = new \DateTime();
            $lastSyncDate->setTimeStamp(strtotime($args['lastSyncDate']));
            return $response->withJson(['USUARIOS' => $usuarios->getUpdates($lastSyncDate)->values()]);
        }
        return $response->withJson(['USUARIOS' => $usuarios->getAll()->values()]);
    });
});

/**
 *************************
 * SERVICIOS ESPECIFICOS *
 *************************
 **/

$app->group('/Programaciones',function() {

    /**
     * @api {GET} /Programaciones/:date
     * @apiGroup Programaciones
     * @apiDescription Retorna la Programacion asignada al usuario que realiza la peticion, si se provee :date se filtraran los resultados modificados a partir de :date
     * @apiPermission specific_user
     * @apiSampleRequest off
     *
     * @apiHeader {String} Authorization Clave Unica de Acceso RFC2045-MIME (Base64).
     * @apiHeaderExample {Json} Ejemplo Header:
     * {"Authorization":"Basic cHJ1ZWJhOjM0MDVlMmY1ODYxOTNiMjQ0MDRkODlmMzZjNDdmYmU3"}
     *
     * @apiParam {Date} [date] Fecha de Ultima Sincronizacion de Registros formato <strong>UNIX TIMESTAMP</strong> o <strong>yyyy-mm-dd</strong>
     *
     * @apiError {Json} 401 Usuario o Contraseña Invalidos
     * @apiErrorExample {Json} Ejemplo Error 401:
     * {"ERROR":"USARIO/CONTRASEÑA INVALIDOS"}
     *
     * @apiError {Json} 404 LO QUE BUSCAS DEFINITIVAMENTE NO ESTÁ AQUÍ...
     * @apiErrorExample {Json} Ejemplo Error 404:
     * {"ERROR":"LO QUE BUSCAS DEFINITIVAMENTE NO ESTÁ AQUÍ..."}
     *
     * @apiSuccess {Json} 200 Arreglo de Objetos de tipo PROGRAMACION
     * @apiSuccessExample {Json} Ejemplo Respuesta:
     * {"PROGRAMACIONES":[{"ID_PROGRAMACION":"11063","DPTO":"08","MUNICIPIO":"001","PROMOTOR":"8389","CEB":"1061","ESTADO":"A","ID_VISITA":"","DIRECCION":"","OTRADIR":"","TELEFONO1":"","TELEFONO2":"","EMAIL":"","LATITUD":"","LONGITUD":"","ID_BARRIO":"","BARRIO":"","FECPROG":"2017-01-31","PERSONAS":[{"ID_USUARIO":"3","MOTVISITA":"","TIPOVISITA":"","PARENTESCO":""}]},{...}]}
     *
     */
    $this->get('[/{lastSyncDate}]', function (Request $request, Response $response, $args) {
        $programaciones = new Schedule($this->db);
        if ($args['lastSyncDate']) {
            $lastSyncDate = new \DateTime();
            $lastSyncDate->setTimeStamp(strtotime($args['lastSyncDate']));
            return $response->withJson(['PROGRAMACIONES' => $programaciones->getUpdates($this->userName, $lastSyncDate)->values()]);
        }
        return $response->withJson(['PROGRAMACIONES' => $programaciones->getAll($this->userName)->values()]);
    });

    $this->post('[/{lastSyncDate}]', function (Request $request, Response $response, $args) {
        $programaciones = new Schedule($this->db);
        $input = $request->getParsedBody();
        if ($args['lastSyncDate']) {
            $lastSyncDate = new \DateTime();
            $lastSyncDate->setTimeStamp(strtotime($args['lastSyncDate']));
            return $response->withJson(['PROGRAMACIONES' => $programaciones->getComparedUpdates($this->userName, $lastSyncDate, $input)->values()]);
        }
        return $response->withJson(['PROGRAMACIONES' => $programaciones->getAllCompared($this->userName, $input)->values()]);
    });
});

$app->group('/Personas',function(){

    /**
     * @api {GET} /Personas/:date
     * @apiGroup Personas
     * @apiDescription Retorna las Personas Afiliadas asignadas al usuario que realiza la peticion, si se provee :date se filtraran los resultados modificados a partir de :date
     * @apiPermission specific_user
     * @apiSampleRequest off
     *
     * @apiHeader {String} Authorization Clave Unica de Acceso RFC2045-MIME (Base64).
     * @apiHeaderExample {Json} Ejemplo Header:
     * {"Authorization":"Basic cHJ1ZWJhOjM0MDVlMmY1ODYxOTNiMjQ0MDRkODlmMzZjNDdmYmU3"}
     *
     * @apiParam {Date} [date] Fecha de Ultima Sincronizacion de Registros formato <strong>UNIX TIMESTAMP</strong> o <strong>yyyy-mm-dd</strong>

     *
     * @apiError {Json} 401 Usuario o Contraseña Invalidos
     * @apiErrorExample {Json} Ejemplo Error 401:
     * {"ERROR":"USARIO/CONTRASEÑA INVALIDOS"}
     *
     * @apiError {Json} 404 LO QUE BUSCAS DEFINITIVAMENTE NO ESTÁ AQUÍ...
     * @apiErrorExample {Json} Ejemplo Error 404:
     * {"ERROR":"LO QUE BUSCAS DEFINITIVAMENTE NO ESTÁ AQUÍ..."}
     *
     * @apiSuccess {Json} 200 Arreglo de Objetos de tipo PERSONA
     * @apiSuccessExample {Json} Ejemplo Respuesta:
     * {"PERSONAS":[{"ID_USUARIO":"3", "APELLIDO1":"CONTRERAS", "APELLIDO2":"DE CONTRERAS", "NOMBRE1":"BARBARA", "NOMBRE2":"", "TIPODOC":"CC", "DOCUMENTO":"28133884", "CARNET":"68296297329", "FECHANAC":"1947-05-10", "SEXO":"F", "ESTADO":"AC", "DPTO":"68", "MUNICIPIO":"296", "SITUACION":"", "CODINST":"ESS024", "CELULAR":"", "EMAIL":"", "PESONACER":"", "TALLANACER":"", "DOCMAMA":"", "DOCPAPA":"", "PROMOTOR":"", "IDULTVISITA":"1459974", "FECULTVISITA":"2017-01-30", "PROGRAMADO":"", "PROGRAMACION":"", "USERCREA":"ADMIN", "FECCREA":"2015-10-20-05.27.40.865969", "IPCREA":"", "USERMODI":"amparo.cordero", "IPMODI":"190.242.76.52", "FECMODI":"2017-01-30-13.46.07.521480"},{...}]}
     *
     */
    $this->get('[/{lastSyncDate}]', function(Request $request, Response $response, $args){
        $personas = new Person($this->db);
        if($args['lastSyncDate']) {
            $lastSyncDate = new \DateTime();
            $lastSyncDate->setTimeStamp(strtotime($args['lastSyncDate']));
            return $response->withJson(['PERSONAS' => $personas->getUpdatedSchedules($this->userName,$lastSyncDate)->values()]);
        }
        return $response->withJson(['PERSONAS' => $personas->getScheduled($this->userName)->values()]);
    });
});

/**
 **************************
 * SERVICIOS PERSISTENCIA *
 **************************
 **/


$app->group('/HistoriaClinica', function () {
    /**
     * @api {POST} /HistoriaClinica/medico
     * @apiGroup Historia Clinica
     * @apiDescription Guarda una o varias historias clinicas y retorna los ids correspondientes
     * @apiPermission specific_user
     * @apiSampleRequest off
     *
     * @apiParam {Json} File Archivo json que contiene todas las respuestas y categorias disponibles para una Historia Clinica
     * @apiParamExample {Json} Request-Example:
     * {"2":{"ACOMPAÑANTES":[[["37","10"],["38","AGUDELO"],["39","GOMEZ"],["40","CARLOS"],["41","AUGUSTO"],["42","CC"],["43","1010102020"],["44","30"],["45","ESS024"],["46","1"],["47","CALLE FALSA 123"],["48","1"],["49","4445263"],["50","3207070803"],["52","1"]],[["37","10"],["38","AGUDELO"],["39","GOMEZ"],["40","ERNEY"],["41","FERNEY"],["42","CC"],["43","1010102020"],["44","30"],["45","ESS024"],["46","1"],["47","CALLE FALSA 123"],["48","1"],["49","4445263"],["50","3207070803"],["52","1"]]],"ANTECEDENTES_MEDICAMENTOS":[[["159","1"],["160","1"],["161","1"],["162","1"],["163","1"],["164","1"],["165","10:30"],["166","1"]],[["159","1"],["160","1"],["161","1"],["162","1"],["163","1"],["164","1"],["165","10:30"],["166","1"]]],"ANTECEDENTES_PERSONALES":[[["98","1"],["99","R90"],["100","1"],["101","2015-08-20"],["102","1"],["103","35"],["104","2015-09-30"]],[["105","1"],["106","1"],["107","1"],["108","2015-09-30"]],[["109","1"],["110","COCA"],["111","1"],["112","20"],["113","2015"],["114","1"],["115","30"],["116","2"]]],"ANTECEDENTES_FAMILIARES":[[["76","1"],["77","1"],["78","1"],["79","1"],["80","2"],["81","0"],["82","0"],["83","1"],["84","1"],["85","3"]],[["76","2"],["77","1"],["78","1"],["79","1"],["80","2"],["81","0"],["82","0"],["83","1"],["84","1"],["85","3"]],[["76","3"],["77","1"],["78","1"],["79","1"],["80","2"],["81","0"],["82","0"],["83","1"],["84","1"],["85","3"]]],"CITAS":[[["289","1"],["290","2016-03-15"],["291","URGENTE"]],[["289","2"],["290","2016-04-15"],["291","Preguntar por ..."]]],"DIAGNOSTICOS":[[["257","E14"],["258","1"]],[["282","1"],["283","DDD"]],[["284","2"],["285","AAA"]],[["286","3"],["287","EEE"]]],"INTERCONSULTA":[[["280","1"],["281","4"]],[["280","2"],["281","5"]],[["280","3"],["281","6"]]],"LABORATORIOS":[[["213","1"],["214","1"],["215","1"],["216","2015-10-18"],["217","1"],["218","42195"],["219","OBSERVACION"]],[["213","1"],["214","1"],["215","1"],["216","2015-10-18"],["217","1"],["218","42195"],["219","OBSERVACION"]]],"OTROS_LABORATORIOS":[[["220","1"],["221","2"],["222","2"],["223","2015-10-30"],["224","OTRA OBSERVACION"]],[["220","1"],["221","2"],["222","2"],["223","2015-10-30"],["224","OTRA OBSERVACION"]]],"PARACLINICOS":[[["259","1"],["260","2"],["261","2015-06-07"]],[["259","1"],["260","3"],["261","2015-06-07"]],[["259","0"],["260","3"],["261","2015-06-07"]]],"PLAN_TERAPEUTICO":[[["262","1"],["263","1"],["264","16"],["265","50"],["266","3"],["267","4"]],[["262","2"],["263","2"],["264","13"],["265","25"],["266","4"],["267","4"]]],"RESPUESTAS":[["201","1"],["202","1"],["203","1"],["204","1"],["205","1"],["206","1"],["207","1"],["208","1"],["209","1"],["210","1"],["211","1"],["212","1"],["182","90"],["183","60"],["184","110"],["185","80"],["186","37"],["187","65"],["188","150"],["189","28,8"],["190","O"],["191","70"],["192","75"],["193","90"],["194","1"],["195","1"],["196","1"],["197","1"],["198","1"],["199","1"],["200","1"],["167","1"],["168","1"],["169","1"],["170","1"],["171","1"],["172","1"],["173","1"],["174","1"],["175","1"],["176","1"],["177","1"],["178","1"],["179","1"],["180","1"],["181","1"],["117","1"],["118","10"],["119","10"],["120","1"],["121","20"],["122","10"],["123","1"],["124","1"],["125","1"],["126","1"],["127","1"],["128","1"],["129","1"],["130","1"],["131","1"],["132","1"],["133","1"],["134","1"],["135","2014-12-31"],["136","1"],["137","1"],["138","1"],["139","1"],["140","1"],["141","2015-08-30"],["142","10"],["143","1"],["144","1"],["145","5"],["146","1"],["147","2015-06-15"],["148","1"],["149","1"],["150","2015-07-10"],["151","1"],["152","1"],["153","2015-08-10"],["154","1"],["155","1"],["156","2015-08-10"],["157","1"],["158","1"],["94","1"],["95","0"],["96","1"],["97","2015-08-20"],["55","1"],["56","1"],["57","1"],["58","1"],["59","1"],["60","1"],["61","1"],["62","1"],["63","1"],["64","1"],["65","1"],["66","1"],["67","1"],["68","1"],["69","1"],["70","1"],["71","1"],["72","1"],["73","1"],["74","1"],["75","OTRO SINTOMA"],["86","1"],["87","1"],["88","1"],["89","1"],["90","2"],["91","0"],["92","0"],["93","1"],["2","RUTA 1"],["3","L"],["4","2015-10-31"],["5","2017-01-13"],["6","1"],["7","L"],["8","05"],["9","250"],["10","U"],["11","1"],["12","REINA"],["13","DE BARCENAS"],["14","CECILIA"],["16","CC"],["17","37829879"],["18","F"],["19","F"],["20","1"],["21","1984-08-12"],["22","33"],["23","ESS024"],["24","S"],["25","S"],["26","1"],["27","1"],["28","1"],["29","4"],["30","9999"],["31","1"],["32","CALLE FALSA 123"],["33","10"],["34","4444444"],["35","3101010100"],["36","3040404004"],["53","UN DOLOR"],["54","UNA GRAN ENFERMEDAD"],["293","2017-01-16-12.21.34.000000"],["294","1"],["53","UN DOLOR"],["54","UNA GRAN ENFERMEDAD"]],"TEMAS":[[["288","1"]],[["288","34"]],[["288","25"]],[["288","18"]]],"GLUCOMETRIAS":[[["244","1"],["245","10:30"],["246","2017-02-20"],["299","1"]],[["244","1"],["245","11:30"],["246","2017-02-20"],["299","1"]],[["244","1"],["245","12:30"],["246","2017-02-20"],["299","1"]]],"EXAMENES":[[["228","1"],["229","2017-02-20"],["230","EXAMEN 1"],["231","I10X"],["232","1"],["247","1"],["248","2"]],[["228","2"],["229","2017-02-20"],["230","EXAMEN 2"],["231","E40"],["232","1"],["247","1"],["248","2"]],[["228","3"],["229","2017-02-20"],["230","EXAMEN 3"],["231","J40"],["232","1"],["247","1"],["248","2"]]]}}
     *
     * @apiHeader {String} Authorization Clave Unica de Acceso RFC2045-MIME (Base64).
     * @apiHeaderExample {Json} Ejemplo Header:
     * {"Authorization":"Basic cHJ1ZWJhOjM0MDVlMmY1ODYxOTNiMjQ0MDRkODlmMzZjNDdmYmU3"}
     *
     * @apiError {Json} 401 Usuario o Contraseña Invalidos
     * @apiErrorExample {Json} Ejemplo Error 401:
     * {"ERROR":"USARIO/CONTRASEÑA INVALIDOS"}
     *
     * @apiError {Json} 404 LO QUE BUSCAS DEFINITIVAMENTE NO ESTÁ AQUÍ...
     * @apiErrorExample {Json} Ejemplo Error 404:
     * {"ERROR":"LO QUE BUSCAS DEFINITIVAMENTE NO ESTÁ AQUÍ..."}
     *
     * @apiSuccess {Json} 200 Arreglo de Objetos de tipo HISTORIA_MEDICA que puede contener uno o varios IDS así como mensajes de error relacionados con la insercion de Historias Clinicas
     * @apiSuccessExample {Json} Ejemplo Respuesta:
     * {"HISTORIA_MEDICA":["8","9",{"ERROR":"DESCRIPCION DEL ERROR"}]}
     */
    $this->post('/medico',function (Request $request, Response $response){
        $historias = new HcMedica($this->db);
        $input = $request->getParsedBody();
        return $response->withJson(["HISTORIA_MEDICA" => $historias->create($input, $this->userName)]);
    });
});
$app->run();