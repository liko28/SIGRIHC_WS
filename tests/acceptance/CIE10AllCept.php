<?php
$I = new AcceptanceTester($scenario);
$I->wantTo('Verificar que CIE10 - All - Funciona');
$I->amHttpAuthenticated("prueba","3405e2f586193b24404d89f36c47fbe7");
$I->sendGET('/CIE10');
$I->seeResponseCodeIs(200);
$I->seeResponseIsJson();
try{
    $I->seeResponseJsonMatchesJsonPath('CIE10.[*].CODIGO');
} catch (Exception $e) {
    $I->seeResponseMatchesJsonType(['CIE10'=>'array']);
}