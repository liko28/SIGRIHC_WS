<?php
$I = new AcceptanceTester($scenario);
$I->wantTo('Verificar que Lista de Referencia - All - Funciona');
$I->amHttpAuthenticated("prueba","3405e2f586193b24404d89f36c47fbe7");
//Tipo
$I->sendGET('/Novedades/tipos');
$I->seeResponseCodeIs(200);
$I->seeResponseIsJson();
try{
    $I->seeResponseJsonMatchesJsonPath('TIPOS_NOVEDAD.[*].TIPO_NOVEDAD');
} catch (Exception $e) {
    $I->seeResponseMatchesJsonType(['TIPOS_NOVEDAD'=>'array']);
}
//Lista
$I->sendGET('/Novedades/campos');
$I->seeResponseCodeIs(200);
$I->seeResponseIsJson();
try{
    $I->seeResponseJsonMatchesJsonPath('CAMPOS_NOVEDAD.[*].COD_NOVEDAD');
} catch (Exception $e) {
    $I->seeResponseMatchesJsonType(['CAMPOS_NOVEDAD'=>'array']);
}
