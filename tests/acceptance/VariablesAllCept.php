<?php
$I = new AcceptanceTester($scenario);
$I->wantTo('Verificar que Lista de Variables - All - Funciona');
$I->amHttpAuthenticated("liliana.madrid","3405e2f586193b24404d89f36c47fbe7");
$I->sendGET('/Variables');
$I->seeResponseCodeIs(200);
$I->seeResponseIsJson();
try{
    $I->seeResponseJsonMatchesJsonPath('VARIABLES.[*].ID_VARIABLE');
} catch (Exception $e) {
    $I->seeResponseMatchesJsonType(['VARIABLES'=>'array']);
}
