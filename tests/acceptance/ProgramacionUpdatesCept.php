<?php
$I = new AcceptanceTester($scenario);
$I->wantTo('Verificar que Datos de PEC - Updates - Funciona');
$I->amHttpAuthenticated("liliana.madrid","3405e2f586193b24404d89f36c47fbe7");
//Guias
$I->sendGET('/Programaciones/1478001600');
$I->seeResponseCodeIs(200);
$I->seeResponseIsJson();
try{
    $I->seeResponseJsonMatchesJsonPath('PROGRAMACIONES.[*].ID_PROGRAMACION');
} catch (Exception $e) {
    $I->seeResponseMatchesJsonType(['PROGRAMACIONES'=>'array']);
}
$I->wantTo('Verificar que Programacion Tiene al menos un Detalle de Usuario');
$I->seeResponseJsonMatchesJsonPath('PROGRAMACIONES.[0].PERSONAS.[0].ID_USUARIO');