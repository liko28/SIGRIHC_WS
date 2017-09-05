<?php
$I = new AcceptanceTester($scenario);
$I->wantTo('Verificar que Lista de Modulos - All - Funciona');
$I->amHttpAuthenticated("norys.palma","288f4d07498733bf2f6377b32f27e493");
$I->sendGET('/Modulos');
$I->seeResponseCodeIs(200);
$I->seeResponseIsJson();
try{
    $I->seeResponseJsonMatchesJsonPath('MODULOS.[*].ID_MODULO');
} catch (Exception $e) {
    $I->seeResponseMatchesJsonType(['MODULOS'=>'array']);
}
