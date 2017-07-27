<?php
$I = new AcceptanceTester($scenario);
$I->wantTo('Verificar que Lista de IPS - All - Funciona');
$I->amHttpAuthenticated("norys.palma","288f4d07498733bf2f6377b32f27e493");
$I->sendGET('/Ips');
$I->seeResponseCodeIs(200);
$I->seeResponseIsJson();
try{
    $I->seeResponseJsonMatchesJsonPath('IPS.[*].COD_INS');
} catch (Exception $e) {
    $I->seeResponseMatchesJsonType(['IPS'=>'array']);
}
