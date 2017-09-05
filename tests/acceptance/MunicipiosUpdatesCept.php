<?php
$I = new AcceptanceTester($scenario);
$I->wantTo('Verificar que Lista de Municipios - Updates - Funciona');
$I->amHttpAuthenticated("norys.palma","288f4d07498733bf2f6377b32f27e493");
$I->sendGET('/Municipios/1478001600');
$I->seeResponseCodeIs(200);
$I->seeResponseIsJson();
try{
    $I->seeResponseJsonMatchesJsonPath('MUNICIPIOS.[*].ID_CIUDAD');
} catch (Exception $e) {
    $I->seeResponseMatchesJsonType(['MUNICIPIOS'=>'array']);
}