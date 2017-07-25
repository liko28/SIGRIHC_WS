<?php
$I = new AcceptanceTester($scenario);
$I->wantTo('Verificar que Lista de Areas - All - Funciona');
$I->amHttpAuthenticated("liliana.madrid","3405e2f586193b24404d89f36c47fbe7");
$I->sendGET('/Areas');
$I->seeResponseCodeIs(200);
$I->seeResponseIsJson();
try{
    $I->seeResponseJsonMatchesJsonPath('AREAS.[*].ID_AREA');
} catch (Exception $e) {
    $I->seeResponseMatchesJsonType(['AREAS'=>'array']);
}
