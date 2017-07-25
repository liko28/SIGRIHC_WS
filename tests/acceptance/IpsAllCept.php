<?php
$I = new AcceptanceTester($scenario);
$I->wantTo('Verificar que Lista de IPS - All - Funciona');
$I->amHttpAuthenticated("liliana.madrid","3405e2f586193b24404d89f36c47fbe7");
$I->sendGET('/Ips');
$I->seeResponseCodeIs(200);
$I->seeResponseIsJson();
try{
    $I->seeResponseJsonMatchesJsonPath('IPS.[*].COD_INS');
} catch (Exception $e) {
    $I->seeResponseMatchesJsonType(['IPS'=>'array']);
}
