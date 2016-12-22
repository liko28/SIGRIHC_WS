<?php
$I = new AcceptanceTester($scenario);
$I->wantTo('Verificar que Lista de Modulos - Updates - Funciona');
$I->amHttpAuthenticated("prueba","3405e2f586193b24404d89f36c47fbe7");
$I->sendGET('/Modulos/1478001600');
$I->seeResponseCodeIs(200);
$I->seeResponseIsJson();
try{
    $I->seeResponseJsonMatchesJsonPath('MODULOS.[*].ID_MODULO');
} catch (Exception $e) {
    $I->seeResponseMatchesJsonType(['MODULOS'=>'array']);
}
