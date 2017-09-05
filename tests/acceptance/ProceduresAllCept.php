<?php
$I = new AcceptanceTester($scenario);
$I->wantTo('Verificar que Lista de Procedimientos - All - Funciona');
$I->amHttpAuthenticated("norys.palma","288f4d07498733bf2f6377b32f27e493");
$I->sendGET('/Procedimientos');
$I->seeResponseCodeIs(200);
$I->seeResponseIsJson();
try{
    $I->seeResponseJsonMatchesJsonPath('PROCEDIMIENTOS.[*].ID_PROCEDIMIENTO');
} catch (Exception $e) {
    $I->seeResponseMatchesJsonType(['PROCEDIMIENTOS'=>'array']);
}
