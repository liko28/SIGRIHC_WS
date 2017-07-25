<?php
$I = new AcceptanceTester($scenario);
$I->wantTo('Verificar que Lista de Procedimientos - All - Funciona');
$I->amHttpAuthenticated("liliana.madrid","3405e2f586193b24404d89f36c47fbe7");
$I->sendGET('/Procedimientos');
$I->seeResponseCodeIs(200);
$I->seeResponseIsJson();
try{
    $I->seeResponseJsonMatchesJsonPath('PROCEDIMIENTOS.[*].ID_PROCEDIMIENTO');
} catch (Exception $e) {
    $I->seeResponseMatchesJsonType(['PROCEDIMIENTOS'=>'array']);
}
