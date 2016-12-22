<?php
$I = new AcceptanceTester($scenario);
$I->wantTo('Verificar que Lista de IPS - Updates - Funciona');
$I->amHttpAuthenticated("prueba","3405e2f586193b24404d89f36c47fbe7");
$I->sendGET('/Ips/1478001600');
$I->seeResponseCodeIs(200);
$I->seeResponseIsJson();
try{
    $I->seeResponseJsonMatchesJsonPath('IPS.[*].COD_INS');
} catch (Exception $e) {
    $I->seeResponseMatchesJsonType(['IPS'=>'array']);
}