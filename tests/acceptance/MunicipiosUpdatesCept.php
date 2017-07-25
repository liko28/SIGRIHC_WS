<?php
$I = new AcceptanceTester($scenario);
$I->wantTo('Verificar que Lista de Municipios - Updates - Funciona');
$I->amHttpAuthenticated("prueba","3405e2f586193b24404d89f36c47fbe7");
$I->sendGET('/Municipios/1478001600');
$I->seeResponseCodeIs(200);
$I->seeResponseIsJson();
try{
    $I->seeResponseJsonMatchesJsonPath('MUNICIPIOS.[*].ID_CIUDAD');
} catch (Exception $e) {
    $I->seeResponseMatchesJsonType(['MUNICIPIOS'=>'array']);
}