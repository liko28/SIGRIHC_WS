<?php
$I = new AcceptanceTester($scenario);
$I->wantTo('Verificar que Lista de Referencia - All - Funciona');
$I->amHttpAuthenticated("prueba","3405e2f586193b24404d89f36c47fbe7");
$I->sendGET('/ListasReferencia');
$I->seeResponseCodeIs(200);
$I->seeResponseIsJson();
try{
    $I->seeResponseJsonMatchesJsonPath('LISTAS_REFERENCIA.[*].ID_LISTA');
} catch (Exception $e) {
    $I->seeResponseMatchesJsonType(['LISTAS_REFERENCIA'=>'array']);
}
