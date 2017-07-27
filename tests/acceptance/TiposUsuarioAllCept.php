<?php
$I = new AcceptanceTester($scenario);
$I->wantTo('Verificar que Tipos de Usuario - All - Funciona');
$I->amHttpAuthenticated("norys.palma","288f4d07498733bf2f6377b32f27e493");
$I->sendGET('/TiposUsuario');
$I->seeResponseCodeIs(200);
$I->seeResponseIsJson();
try{
    $I->seeResponseJsonMatchesJsonPath('TIPOS_USUARIO.[*].ID');
} catch (Exception $e) {
    $I->seeResponseMatchesJsonType(['TIPOS_USUARIO'=>'array']);
}