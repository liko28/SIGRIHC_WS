<?php
$I = new AcceptanceTester($scenario);
$I->wantTo('Verificar que Lista de Municipios - Updates - Funciona');
$I->amHttpAuthenticated("liliana.madrid","3405e2f586193b24404d89f36c47fbe7");
$I->sendGET('/Departamentos/1478001600');
$I->seeResponseCodeIs(200);
$I->seeResponseIsJson();
try{
    $I->seeResponseJsonMatchesJsonPath('DEPARTAMENTOS.[*].ID');;
} catch (Exception $e) {
    $I->seeResponseMatchesJsonType(['DEPARTAMENTOS'=>'array']);
}
