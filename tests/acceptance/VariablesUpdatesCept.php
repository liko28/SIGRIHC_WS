<?php
$I = new AcceptanceTester($scenario);
$I->wantTo('Verificar que Lista de Variables - Updates - Funciona');
$I->amHttpAuthenticated("norys.palma","288f4d07498733bf2f6377b32f27e493");
$I->sendGET('/Variables/1478001600');
$I->seeResponseCodeIs(200);
$I->seeResponseIsJson();
try{
    $I->seeResponseJsonMatchesJsonPath('VARIABLES.[*].ID_VARIABLE');
} catch (Exception $e) {
    $I->seeResponseMatchesJsonType(['VARIABLES'=>'array']);
}
