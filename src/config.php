<?php

/** Cadenas de Conexion */
//TEST
//const CONNECTION_CREDENTIALS = array('SALUD', '192.168.1.247', 50000, 'db2inst1','db2inst1', 'SALFAM2');
//PRODUCCION
//const CONNECTION_CREDENTIALS = array('SIGRI', '192.168.1.249', 50000, 'salfam','salfam2015', 'SALUD');
//Local
const CONNECTION_CREDENTIALS = array('SIGRI', '127.0.0.1', 50000, 'db2inst1','db2inst1', 'SALUD');

/** Labels Columnas DAO */
const LABELS = true;

/** Mensajes */
const ERROR_AUTH = array("ERROR" => "USARIO/CONTRASEÑA INVALIDOS");
const ERROR_CONN = array("ERROR" => "ME SIENTO AGOTADO, ESTOY TOMANDO UN DESCANSO...");
const ERROR_500 = array("ERROR" => "NO ME SIENTO BIEN, LLAMA A UN INGENIERO...");
const ERROR_404 = array("ERROR" => "LO QUE BUSCAS DEFINITIVAMENTE NO ESTÁ AQUÍ...");

/** Configuracion de Slim */
/** Errores detallados */
const CONFIG = array("settings" => array("displayErrorDetails" => true),"determineRouteBeforeAppMiddleware" => true);

/** Version */
const VERSION = '0.5.1';