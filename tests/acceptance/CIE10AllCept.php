<?php
$I = new AcceptanceTester($scenario);
$I->wantTo('Verificar que CIE10 - All - Funciona');
$I->amHttpAuthenticated("norys.palma","288f4d07498733bf2f6377b32f27e493");
$I->sendGET('/CIE10');
$I->seeResponseCodeIs(200);
$I->seeResponseIsJson();
try{
    $I->seeResponseJsonMatchesJsonPath('CIE10.[*].CODIGO');
} catch (Exception $e) {
    $I->seeResponseMatchesJsonType(['CIE10'=>'array']);
}