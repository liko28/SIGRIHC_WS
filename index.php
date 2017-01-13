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
     * @api {GET} /ListasReferencia/:date updates
     * @apiGroup ListasReferencia
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
     * @apiError {Json} 404 Ruta Invalida o Elemento No Encontrado
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
            return $response->withJson(['LISTAS_REFERENCIA' => $referenceList->getAll()->values()]);
        }
        return $response->withJson(['LISTAS_REFERENCIA' => $referenceList->getUpdates($lastSyncDate)->values()]);
    });
});

$app->group('/Municipios', function () {
    /**
     * @api {GET} /Municipios/:date updates
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
     * @apiError {Json} 404 Ruta Invalida o Elemento No Encontrado
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
     * @api {GET} /Departamentos/:date updates
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
     * @apiError {Json} 404 Ruta Invalida o Elemento No Encontrado
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
 * @api {GET} /CIE10 all
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
 * @apiError {Json} 404 Ruta Invalida o Elemento No Encontrado
 * @apiErrorExample {Json} Ejemplo Error 404:
 * {"ERROR":"LO QUE BUSCAS DEFINITIVAMENTE NO ESTÁ AQUÍ..."}
 *
 * @apiSuccess {Json} 200 Arreglo de Objetos de tipo DEPARTAMENTO
 * @apiSuccessExample {Json} Ejemplo Respuesta:
 * {"CIE10":[{"ID":"1","CODIGO":"A000","DESCRIPCION":"COLERA DEBIDO A VIBRIO CHOLERAE O1, BIOTIPO CHOLERAE","CLASE":"","ACTIVO":"0"},{...}]}
 *
 */
$app->get('/CIE10', function (Request $request, Response $response) {
    $cie10 = new CIE10($this->db);
    return $response->withJson(['CIE10' => $cie10->getAll()->values()]);
});

/**
 * @api {GET} /TiposUsuario all
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
 * @apiError {Json} 404 Ruta Invalida o Elemento No Encontrado
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
     * @api {GET} /Areas/:date updates
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
     * @apiError {Json} 404 Ruta Invalida o Elemento No Encontrado
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
     * @api {GET} /Ips/:date updates
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
     * @apiError {Json} 404 Ruta Invalida o Elemento No Encontrado
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
     * @api {GET} /Novedades/tipo all
     * @apiGroup Novedades Tipo
     * @apiDescription Retorna la lista de Tipos de Novedades Completa
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
     * @apiError {Json} 404 Ruta Invalida o Elemento No Encontrado
     * @apiErrorExample {Json} Ejemplo Error 404:
     * {"ERROR":"ELEMENTO NO ENCONTRADO"}
     * @apiErrorExample {Json} Ejemplo Error 404:
     * {"ERROR":"RUTA INVALIDA"}
     *
     * @apiSuccess {Json} 200 Arreglo de Objetos de tipo IPS
     * @apiSuccessExample {Json} Ejemplo Respuesta:
     * TODO EJEMPLO PENDIENTE
     *
     */
    $this->get('tipos', function (Request $request, Response $response) {
        $tipos = new NewsType($this->db);
        return $response->withJson(['TIPOS_NOVEDAD' => $tipos->getAll()->values()]);
    });

    /**
     * @api {GET} /Novedades/tipo/:date updates
     * @apiGroup Novedades Tipos
     * @apiDescription Retorna Los registros de Tipos de Novedades que han sufrido modificaciones posteriores a :date
     * @apiPermission user
     * @apiSampleRequest off
     *
     * @apiHeader {String} Authorization Clave Unica de Acceso RFC2045-MIME (Base64).
     * @apiHeaderExample {Json} Ejemplo Header:
     * {"Authorization":"Basic cHJ1ZWJhOjM0MDVlMmY1ODYxOTNiMjQ0MDRkODlmMzZjNDdmYmU3"}
     *
     * @apiParam {Date} date Fecha de Ultima Sincronizacion de Registros formato <strong>UNIX TIMESTAMP</strong> o <strong>yyyy-mm-dd</strong>

     *
     * @apiError {Json} 401 Usuario o Contraseña Invalidos
     * @apiErrorExample {Json} Ejemplo Error 401:
     * {"ERROR":"USARIO/CONTRASEÑA INVALIDOS"}
     *
     * @apiError {Json} 404 Ruta Invalida o Elemento No Encontrado
     * @apiErrorExample {Json} Ejemplo Error 404:
     * {"ERROR":"ELEMENTO NO ENCONTRADO"}
     * @apiErrorExample {Json} Ejemplo Error 404:
     * {"ERROR":"RUTA INVALIDA"}
     *
     * @apiSuccess {Json} 200 Arreglo de Objetos de tipo IPS
     * @apiSuccessExample {Json} Ejemplo Respuesta:
     * TODO EJEMPLO PENDIENTE
     *
     */
    $this->get('tipos/{lastSyncDate}', function (Request $request, Response $response, $args){
        $lastSyncDate = new \DateTime();
        $lastSyncDate->setTimeStamp(strtotime($args['lastSyncDate']));
        $tipos = new NewsType($this->db);
        return $response->withJson(['TIPOS_NOVEDAD' => $tipos->getUpdates($lastSyncDate)->values()]);
    });

    /**
     * @api {GET} /Novedades/campo all
     * @apiGroup Novedades Campos
     * @apiDescription Retorna las Listas de Novedades
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
     * @apiError {Json} 404 Ruta Invalida o Elemento No Encontrado
     * @apiErrorExample {Json} Ejemplo Error 404:
     * {"ERROR":"ELEMENTO NO ENCONTRADO"}
     * @apiErrorExample {Json} Ejemplo Error 404:
     * {"ERROR":"RUTA INVALIDA"}
     *
     * @apiSuccess {Json} 200 Arreglo de Objetos de tipo IPS
     * @apiSuccessExample {Json} Ejemplo Respuesta:
     * TODO EJEMPLO PENDIENTE
     *
     */
    $this->get('campos', function (Request $request, Response $response) {
        $listas = new NewsList($this->db);
        return $response->withJson(['LISTAS_NOVEDAD' => $listas->getAll()->values()]);
    });

    /**
     * @api {GET} /Novedades/lista/:date updates
     * @apiGroup Novedades Lista
     * @apiDescription Retorna Las Listas de Novedades que han sufrido modificaciones posteriores a :date
     * @apiPermission user
     * @apiSampleRequest off
     *
     * @apiHeader {String} Authorization Clave Unica de Acceso RFC2045-MIME (Base64).
     * @apiHeaderExample {Json} Ejemplo Header:
     * {"Authorization":"Basic cHJ1ZWJhOjM0MDVlMmY1ODYxOTNiMjQ0MDRkODlmMzZjNDdmYmU3"}
     *
     * @apiParam {Date} date Fecha de Ultima Sincronizacion de Registros formato <strong>UNIX TIMESTAMP</strong> o <strong>yyyy-mm-dd</strong>

     *
     * @apiError {Json} 401 Usuario o Contraseña Invalidos
     * @apiErrorExample {Json} Ejemplo Error 401:
     * {"ERROR":"USARIO/CONTRASEÑA INVALIDOS"}
     *
     * @apiError {Json} 404 Ruta Invalida o Elemento No Encontrado
     * @apiErrorExample {Json} Ejemplo Error 404:
     * {"ERROR":"ELEMENTO NO ENCONTRADO"}
     * @apiErrorExample {Json} Ejemplo Error 404:
     * {"ERROR":"RUTA INVALIDA"}
     *
     * @apiSuccess {Json} 200 Arreglo de Objetos de tipo IPS
     * @apiSuccessExample {Json} Ejemplo Respuesta:
     * TODO EJEMPLO PENDIENTE
     *
     */
    $this->get('campos/{lastSyncDate}',function (Request $request, Response $response, $args){
        $lastSyncDate = new \DateTime();
        $lastSyncDate->setTimeStamp(strtotime($args['lastSyncDate']));
        $listas = new NewsList($this->db);
        return $response->withJson(['LISTAS_NOVEDAD' => $listas->getUpdates($lastSyncDate)->values()]);
    });
});

$app->group('/PEC/', function() {
    /**
     * @api {GET} /PEC/GruposObjetivo all
     * @apiGroup PEC Grupos Objetivo
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
     * @apiError {Json} 404 Ruta Invalida o Elemento No Encontrado
     * @apiErrorExample {Json} Ejemplo Error 404:
     * {"ERROR":"ELEMENTO NO ENCONTRADO"}
     * @apiErrorExample {Json} Ejemplo Error 404:
     * {"ERROR":"RUTA INVALIDA"}
     *
     * @apiSuccess {Json} 200 Arreglo de Objetos de tipo PEC_GRUPO_OBJETIVO
     * @apiSuccessExample {Json} Ejemplo Respuesta:
     * TODO EJEMPLO PENDIENTE
     *
     */
    $this->get('GruposObjetivo', function (Request $request, Response $response){
        $gruposObjetivo = new PECObjetive($this->db);
        return $response->withJson(['PEC_GRUPOS_OBJETIVO' => $gruposObjetivo->getAll()->values()]);
    });

    /**
     * @api {GET} /PEC/Guias all
     * @apiGroup PEC Guias
     * @apiDescription Retorna la lista de Guias PEC
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
     * @apiError {Json} 404 Ruta Invalida o Elemento No Encontrado
     * @apiErrorExample {Json} Ejemplo Error 404:
     * {"ERROR":"ELEMENTO NO ENCONTRADO"}
     * @apiErrorExample {Json} Ejemplo Error 404:
     * {"ERROR":"RUTA INVALIDA"}
     *
     * @apiSuccess {Json} 200 Arreglo de Objetos de tipo PEC_GUIA
     * @apiSuccessExample {Json} Ejemplo Respuesta:
     * TODO EJEMPLO PENDIENTE
     *
     */
    $this->get('Guias', function (Request $request, Response $response){
        $guias = new PECGuide($this->db);
        return $response->withJson(['PEC_GUIAS' => $guias->getAll()->values()]);
    });

    /**
     * @api {GET} /PEC/Guias/:date updates
     * @apiGroup PEC Guias
     * @apiDescription Retorna Las Guias PEC que han sufrido modificaciones posteriores a :date
     * @apiPermission user
     * @apiSampleRequest off
     *
     * @apiHeader {String} Authorization Clave Unica de Acceso RFC2045-MIME (Base64).
     * @apiHeaderExample {Json} Ejemplo Header:
     * {"Authorization":"Basic cHJ1ZWJhOjM0MDVlMmY1ODYxOTNiMjQ0MDRkODlmMzZjNDdmYmU3"}
     *
     * @apiParam {Date} date Fecha de Ultima Sincronizacion de Registros formato <strong>UNIX TIMESTAMP</strong> o <strong>yyyy-mm-dd</strong>
     *
     * @apiError {Json} 401 Usuario o Contraseña Invalidos
     * @apiErrorExample {Json} Ejemplo Error 401:
     * {"ERROR":"USARIO/CONTRASEÑA INVALIDOS"}
     *
     * @apiError {Json} 404 Ruta Invalida o Elemento No Encontrado
     * @apiErrorExample {Json} Ejemplo Error 404:
     * {"ERROR":"ELEMENTO NO ENCONTRADO"}
     * @apiErrorExample {Json} Ejemplo Error 404:
     * {"ERROR":"RUTA INVALIDA"}
     *
     * @apiSuccess {Json} 200 Arreglo de Objetos de tipo PEC_GUIA
     * @apiSuccessExample {Json} Ejemplo Respuesta:
     * TODO EJEMPLO PENDIENTE
     *
     */
    $this->get('Guias/{lastSyncDate}', function (Request $request, Response $response, $args){
        $lastSyncDate = new \DateTime();
        $lastSyncDate->setTimeStamp(strtotime($args['lastSyncDate']));
        $guias = new PECGuide($this->db);
        return $response->withJson(['PEC_GUIAS' => $guias->getUpdates($lastSyncDate)->values()]);
    });

    /**
     * @api {GET} /PEC/Procesos all
     * @apiGroup PEC Procesos
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
     * @apiError {Json} 404 Ruta Invalida o Elemento No Encontrado
     * @apiErrorExample {Json} Ejemplo Error 404:
     * {"ERROR":"ELEMENTO NO ENCONTRADO"}
     * @apiErrorExample {Json} Ejemplo Error 404:
     * {"ERROR":"RUTA INVALIDA"}
     *
     * @apiSuccess {Json} 200 Arreglo de Objetos de tipo PEC_PROCESO
     * @apiSuccessExample {Json} Ejemplo Respuesta:
     * TODO EJEMPLO PENDIENTE
     *
     */
    $this->get('Procesos', function (Request $request, Response $response){
        $procesos = new PECProcess($this->db);
        return $response->withJson(['PEC_PROCESOS' => $procesos->getAll()->values()]);
    });

    /**
     * @api {GET} /PEC/Programacion all
     * @apiGroup PEC Programacion
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
     * @apiError {Json} 404 Ruta Invalida o Elemento No Encontrado
     * @apiErrorExample {Json} Ejemplo Error 404:
     * {"ERROR":"ELEMENTO NO ENCONTRADO"}
     * @apiErrorExample {Json} Ejemplo Error 404:
     * {"ERROR":"RUTA INVALIDA"}
     *
     * @apiSuccess {Json} 200 Arreglo de Objetos de tipo PEC_PROGRAMACION
     * @apiSuccessExample {Json} Ejemplo Respuesta:
     * TODO EJEMPLO PENDIENTE
     *
     */
    $this->get('Programacion', function (Request $request, Response $response){
        $programaciones = new PECSchedule($this->db);
        return $response->withJson(['PEC_PROGRAMACIONES' => $programaciones->getAll()->values()]);
    });

    /**
     * @api {GET} /PEC/temas all
     * @apiGroup PEC Temas
     * @apiDescription Retorna la lista de Temas PEC
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
     * @apiError {Json} 404 Ruta Invalida o Elemento No Encontrado
     * @apiErrorExample {Json} Ejemplo Error 404:
     * {"ERROR":"ELEMENTO NO ENCONTRADO"}
     * @apiErrorExample {Json} Ejemplo Error 404:
     * {"ERROR":"RUTA INVALIDA"}
     *
     * @apiSuccess {Json} 200 Arreglo de Objetos de tipo PEC_TEMA
     * @apiSuccessExample {Json} Ejemplo Respuesta:
     * TODO EJEMPLO PENDIENTE
     *
     */
    $this->get('Temas', function (Request $request, Response $response){
        $temas = new PECTopic($this->db);
        return $response->withJson(['PEC_TEMAS' => $temas->getAll()->values()]);
    });

    /**
     * @api {GET} /PEC/Temas/:date updates
     * @apiGroup PEC Temas
     * @apiDescription Retorna los Temas PEC que han sufrido modificaciones posteriores a :date
     * @apiPermission user
     * @apiSampleRequest off
     *
     * @apiHeader {String} Authorization Clave Unica de Acceso RFC2045-MIME (Base64).
     * @apiHeaderExample {Json} Ejemplo Header:
     * {"Authorization":"Basic cHJ1ZWJhOjM0MDVlMmY1ODYxOTNiMjQ0MDRkODlmMzZjNDdmYmU3"}
     *
     * @apiParam {Date} date Fecha de Ultima Sincronizacion de Registros formato <strong>UNIX TIMESTAMP</strong> o <strong>yyyy-mm-dd</strong>

     *
     * @apiError {Json} 401 Usuario o Contraseña Invalidos
     * @apiErrorExample {Json} Ejemplo Error 401:
     * {"ERROR":"USARIO/CONTRASEÑA INVALIDOS"}
     *
     * @apiError {Json} 404 Ruta Invalida o Elemento No Encontrado
     * @apiErrorExample {Json} Ejemplo Error 404:
     * {"ERROR":"ELEMENTO NO ENCONTRADO"}
     * @apiErrorExample {Json} Ejemplo Error 404:
     * {"ERROR":"RUTA INVALIDA"}
     *
     * @apiSuccess {Json} 200 Arreglo de Objetos de tipo PEC_TEMA
     * @apiSuccessExample {Json} Ejemplo Respuesta:
     * TODO EJEMPLO PENDIENTE
     *
     */
    $this->get('Temas/{lastSyncDate}', function (Request $request, Response $response, $args){
        $lastSyncDate = new \DateTime();
        $lastSyncDate->setTimeStamp(strtotime($args['lastSyncDate']));
        $temas = new PECTopic($this->db);
        return $response->withJson(['PEC_TEMAS' => $temas->getUpdates($lastSyncDate)->values()]);
    });
});

/**
 * @api {GET} /Medicamentos all
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
 * @apiError {Json} 404 Ruta Invalida o Elemento No Encontrado
 * @apiErrorExample {Json} Ejemplo Error 404:
 * {"ERROR":"ELEMENTO NO ENCONTRADO"}
 * @apiErrorExample {Json} Ejemplo Error 404:
 * {"ERROR":"RUTA INVALIDA"}
 *
 * @apiSuccess {Json} 200 Arreglo de Objetos de tipo PEC_TEMA
 * @apiSuccessExample {Json} Ejemplo Respuesta:
 * TODO EJEMPLO PENDIENTE
 *
 */
$app->group('/Medicamentos', function() {
    $this->get('', function (Request $request, Response $response) {
        $medicines = new Medicine($this->db);
        return $response->withJson(['MEDICAMENTOS' => $medicines->getAll()->values()]);
    });
});

/**
 * @api {GET} /Laboratorios all
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
 * @apiError {Json} 404 Ruta Invalida o Elemento No Encontrado
 * @apiErrorExample {Json} Ejemplo Error 404:
 * {"ERROR":"ELEMENTO NO ENCONTRADO"}
 * @apiErrorExample {Json} Ejemplo Error 404:
 * {"ERROR":"RUTA INVALIDA"}
 *
 * @apiSuccess {Json} 200 Arreglo de Objetos de tipo PEC_TEMA
 * @apiSuccessExample {Json} Ejemplo Respuesta:
 * TODO EJEMPLO PENDIENTE
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
     * @api {GET} /Modulos all
     * @apiGroup Modulos
     * @apiDescription Retorna el Listado de Modulos
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
     * @apiError {Json} 404 Ruta Invalida o Elemento No Encontrado
     * @apiErrorExample {Json} Ejemplo Error 404:
     * {"ERROR":"ELEMENTO NO ENCONTRADO"}
     * @apiErrorExample {Json} Ejemplo Error 404:
     * {"ERROR":"RUTA INVALIDA"}
     *
     * @apiSuccess {Json} 200 Arreglo de Objetos de tipo PEC_TEMA
     * @apiSuccessExample {Json} Ejemplo Respuesta:
     * TODO EJEMPLO PENDIENTE
     *
     */
    $this->get('', function (Request $request, Response $response){
        $modulos = new Module($this->db);
        return $response->withJson(['MODULOS' => $modulos->getAll()->values()]);
    });

    /**
     * @api {GET} /Modulos/:date updates
     * @apiGroup Modulos
     * @apiDescription Retorna el Listado de Modulos con modificaciones posteriores a :date
     * @apiPermission user
     * @apiSampleRequest off
     *
     * @apiHeader {String} Authorization Clave Unica de Acceso RFC2045-MIME (Base64).
     * @apiHeaderExample {Json} Ejemplo Header:
     * {"Authorization":"Basic cHJ1ZWJhOjM0MDVlMmY1ODYxOTNiMjQ0MDRkODlmMzZjNDdmYmU3"}
     *
     * @apiParam {Date} date Fecha de Ultima Sincronizacion de Registros formato <strong>UNIX TIMESTAMP</strong> o <strong>yyyy-mm-dd</strong>

     *
     * @apiError {Json} 401 Usuario o Contraseña Invalidos
     * @apiErrorExample {Json} Ejemplo Error 401:
     * {"ERROR":"USARIO/CONTRASEÑA INVALIDOS"}
     *
     * @apiError {Json} 404 Ruta Invalida o Elemento No Encontrado
     * @apiErrorExample {Json} Ejemplo Error 404:
     * {"ERROR":"ELEMENTO NO ENCONTRADO"}
     * @apiErrorExample {Json} Ejemplo Error 404:
     * {"ERROR":"RUTA INVALIDA"}
     *
     * @apiSuccess {Json} 200 Arreglo de Objetos de tipo PEC_TEMA
     * @apiSuccessExample {Json} Ejemplo Respuesta:
     * TODO EJEMPLO PENDIENTE
     *
     */
    $this->get('/{lastSyncDate}', function (Request $request, Response $response, $args){
        $lastSyncDate = new \DateTime();
        $lastSyncDate->setTimeStamp(strtotime($args['lastSyncDate']));
        $modulos = new Module($this->db);
        return $response->withJson(['MODULOS' => $modulos->getUpdates($lastSyncDate)->values()]);
    });
});

$app->group('/Preguntas', function() {
    /**
     * @api {GET} /Preguntas all
     * @apiGroup Preguntas
     * @apiDescription Retorna el Listado de Preguntas
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
     * @apiError {Json} 404 Ruta Invalida o Elemento No Encontrado
     * @apiErrorExample {Json} Ejemplo Error 404:
     * {"ERROR":"ELEMENTO NO ENCONTRADO"}
     * @apiErrorExample {Json} Ejemplo Error 404:
     * {"ERROR":"RUTA INVALIDA"}
     *
     * @apiSuccess {Json} 200 Arreglo de Objetos de tipo PEC_TEMA
     * @apiSuccessExample {Json} Ejemplo Respuesta:
     * TODO EJEMPLO PENDIENTE
     *
     */
    $this->get('', function (Request $request, Response $response){
        $preguntas = new Question($this->db);
        return $response->withJson(['PREGUNTAS' => $preguntas->getAll()->values()]);
    });

    /**
     * @api {GET} /Preguntas/:date updates
     * @apiGroup Preguntas
     * @apiDescription Retorna el Listado de Preguntas con modificaciones posteriores a :date
     * @apiPermission user
     * @apiSampleRequest off
     *
     * @apiHeader {String} Authorization Clave Unica de Acceso RFC2045-MIME (Base64).
     * @apiHeaderExample {Json} Ejemplo Header:
     * {"Authorization":"Basic cHJ1ZWJhOjM0MDVlMmY1ODYxOTNiMjQ0MDRkODlmMzZjNDdmYmU3"}
     *
     * @apiParam {Date} date Fecha de Ultima Sincronizacion de Registros formato <strong>UNIX TIMESTAMP</strong> o <strong>yyyy-mm-dd</strong>

     *
     * @apiError {Json} 401 Usuario o Contraseña Invalidos
     * @apiErrorExample {Json} Ejemplo Error 401:
     * {"ERROR":"USARIO/CONTRASEÑA INVALIDOS"}
     *
     * @apiError {Json} 404 Ruta Invalida o Elemento No Encontrado
     * @apiErrorExample {Json} Ejemplo Error 404:
     * {"ERROR":"ELEMENTO NO ENCONTRADO"}
     * @apiErrorExample {Json} Ejemplo Error 404:
     * {"ERROR":"RUTA INVALIDA"}
     *
     * @apiSuccess {Json} 200 Arreglo de Objetos de tipo PEC_TEMA
     * @apiSuccessExample {Json} Ejemplo Respuesta:
     * TODO EJEMPLO PENDIENTE
     *
     */
    $this->get('/{lastSyncDate}', function (Request $request, Response $response, $args){
        $lastSyncDate = new \DateTime();
        $lastSyncDate->setTimeStamp(strtotime($args['lastSyncDate']));
        $preguntas = new Question($this->db);
        return $response->withJson(['PREGUNTAS' => $preguntas->getUpdates($lastSyncDate)->values()]);
    });
});

/**
 *************************
 * SERVICIOS ESPECIFICOS *
 *************************
 **/

$app->group('/Programaciones',function(){
    /**
     * @api {GET} /Programaciones all
     * @apiGroup Programaciones
     * @apiDescription Retorna la Programacion asignada al usuario que realiza la peticion
     * @apiPermission specific_user
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
     * @apiError {Json} 404 Ruta Invalida o Elemento No Encontrado
     * @apiErrorExample {Json} Ejemplo Error 404:
     * {"ERROR":"ELEMENTO NO ENCONTRADO"}
     * @apiErrorExample {Json} Ejemplo Error 404:
     * {"ERROR":"RUTA INVALIDA"}
     *
     * @apiSuccess {Json} 200 Arreglo de Objetos de tipo PEC_TEMA
     * @apiSuccessExample {Json} Ejemplo Respuesta:
     * TODO EJEMPLO PENDIENTE
     *
     */
    $this->get('', function(Request $request, Response $response){
        $programaciones = new Schedule($this->db);
        return $response->withJson(['PROGRAMACIONES' => $programaciones->getAll($this->userName)->values()]);
    });

    /**
     * @api {GET} /Programaciones/:date updates
     * @apiGroup Programaciones
     * @apiDescription Retorna la Programacion asignada al usuario que realiza la peticion y que haya sido modificado posterior a :date
     * @apiPermission specific_user
     * @apiSampleRequest off
     *
     * @apiHeader {String} Authorization Clave Unica de Acceso RFC2045-MIME (Base64).
     * @apiHeaderExample {Json} Ejemplo Header:
     * {"Authorization":"Basic cHJ1ZWJhOjM0MDVlMmY1ODYxOTNiMjQ0MDRkODlmMzZjNDdmYmU3"}
     *
     * @apiParam {Date} date Fecha de Ultima Sincronizacion de Registros formato <strong>UNIX TIMESTAMP</strong> o <strong>yyyy-mm-dd</strong>

     *
     * @apiError {Json} 401 Usuario o Contraseña Invalidos
     * @apiErrorExample {Json} Ejemplo Error 401:
     * {"ERROR":"USARIO/CONTRASEÑA INVALIDOS"}
     *
     * @apiError {Json} 404 Ruta Invalida o Elemento No Encontrado
     * @apiErrorExample {Json} Ejemplo Error 404:
     * {"ERROR":"ELEMENTO NO ENCONTRADO"}
     * @apiErrorExample {Json} Ejemplo Error 404:
     * {"ERROR":"RUTA INVALIDA"}
     *
     * @apiSuccess {Json} 200 Arreglo de Objetos de tipo PEC_TEMA
     * @apiSuccessExample {Json} Ejemplo Respuesta:
     * TODO EJEMPLO PENDIENTE
     *
     */
    $this->get('/{lastSyncDate}', function(Request $request, Response $response, $args){
        $lastSyncDate = new \DateTime();
        $lastSyncDate->setTimeStamp(strtotime($args['lastSyncDate']));
        $programaciones = new Schedule($this->db);
        return $response->withJson(['PROGRAMACIONES' => $programaciones->getUpdates($this->userName,$lastSyncDate)->values()]);
    });
});

/**
 **************************
 * SERVICIOS PERSISTENCIA *
 **************************
 **/
$app->group('/HistoriaClinica', function () {
    $this->post('/medico',function (Request $request, Response $response){
        $historias = new HcMedica($this->db);
        $input = $request->getParsedBody();
        return $response->withJson(["HISTORIA_MEDICA" => $historias->create($input)]);
    });
});
$app->run();