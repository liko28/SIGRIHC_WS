<?php
$I = new AcceptanceTester($scenario);
$I->wantTo('Verificar que Programacion - All - Funciona');
$I->amHttpAuthenticated("norys.palma","288f4d07498733bf2f6377b32f27e493");
$I->sendPost('/Programaciones',[],[]);
$I->seeResponseCodeIs(200);
$I->seeResponseIsJson();
try{
    $I->seeResponseJsonMatchesJsonPath('PROGRAMACIONES.[*].ID_PROGRAMACION');
} catch (Exception $e) {
    $I->seeResponseMatchesJsonType(['PROGRAMACIONES'=>'array']);
}
$I->wantTo('Verificar que Programacion Tiene al menos un Detalle de Usuario');
$I->seeResponseJsonMatchesJsonPath('PROGRAMACIONES.[0].PERSONAS.[0].ID_USUARIO');
