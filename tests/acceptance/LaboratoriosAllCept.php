<?php
$I = new AcceptanceTester($scenario);
$I->wantTo('Verificar que Lista de Laboratorios - All - Funciona');
$I->amHttpAuthenticated("norys.palma","288f4d07498733bf2f6377b32f27e493");
$I->sendGET('/Laboratorios');
$I->seeResponseCodeIs(200);
$I->seeResponseIsJson();
try{
    $I->seeResponseJsonMatchesJsonPath('LABORATORIOS.[*].ID_LABORATORIO');
} catch (Exception $e) {
    $I->seeResponseMatchesJsonType(['LABORATORIOS'=>'array']);
}
