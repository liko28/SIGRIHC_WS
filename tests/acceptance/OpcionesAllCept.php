<?php
$I = new AcceptanceTester($scenario);
$I->wantTo('Verificar que Lista de Opciones - All - Funciona');
$I->amHttpAuthenticated("norys.palma","288f4d07498733bf2f6377b32f27e493");
$I->sendGET('/Opciones');
$I->seeResponseCodeIs(200);
$I->seeResponseIsJson();
try{
    $I->seeResponseJsonMatchesJsonPath('OPCIONES.[*].ID_LISTA');
} catch (Exception $e) {
    $I->seeResponseMatchesJsonType(['OPCIONES'=>'array']);
}
