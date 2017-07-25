<?php
$I = new AcceptanceTester($scenario);
$I->wantTo('Verificar que Tipos de Usuario - All - Funciona');
$I->amHttpAuthenticated("prueba","3405e2f586193b24404d89f36c47fbe7");
$I->sendGET('/TiposUsuario');
$I->seeResponseCodeIs(200);
$I->seeResponseIsJson();
try{
    $I->seeResponseJsonMatchesJsonPath('TIPOS_USUARIO.[*].ID');
} catch (Exception $e) {
    $I->seeResponseMatchesJsonType(['TIPOS_USUARIO'=>'array']);
}