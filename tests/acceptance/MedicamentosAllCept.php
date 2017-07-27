<?php
$I = new AcceptanceTester($scenario);
$I->wantTo('Verificar que Lista de Medicamentos - All - Funciona');
$I->amHttpAuthenticated("norys.palma","288f4d07498733bf2f6377b32f27e493");
$I->sendGET('/Medicamentos');
$I->seeResponseCodeIs(200);
$I->seeResponseIsJson();
try{
    $I->seeResponseJsonMatchesJsonPath('MEDICAMENTOS.[*].ID_MEDICAMENTO');
} catch (Exception $e) {
    $I->seeResponseMatchesJsonType(['MEDICAMENTOS'=>'array']);
}