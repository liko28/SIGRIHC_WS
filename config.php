<?php

/** Cadenas de Conexion */
//TEST
const CONNECTION_CREDENTIALS = array('SALUD', '192.168.1.247', 50000, 'db2inst1','db2inst1', 'SALFAM2');
//PRODUCCION
//const CONNECTION_CREDENTIALS = array('SIGRI', '192.168.1.249', 50000, 'salfam','salfam2015', 'SALUD');

/** Labels Columnas DAO */
const LABELS = true;

/** Mensajes */
const ERROR_AUTH = array("ERROR" => "USARIO/CONTRASEÑA INVALIDOS");
const ERROR_CONN = array("ERROR" => "NO SE PUEDE CONECTAR AL SERVIDOR");
const ERROR_404 = "ELEMENTO NO ENCONTRADO";

/** Configuracion de Slim */
/** Errores detallados */
const CONFIG = array("settings" => array("displayErrorDetails" => false));
