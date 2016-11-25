<?php
$I = new AcceptanceTester($scenario);
$I->wantTo('Verificar que Datos de PEC - Updates - Funciona');
$I->amHttpAuthenticated("yenny.navarro","0e9c305be2086dddde743735105aceb5");
//Guias
$I->sendGET('/Programacion/get/updates/1478001600');
$I->seeResponseCodeIs(200);
$I->seeResponseIsJson();
$I->wantTo('Verificar que Programacion Tiene al menos un Detalle de Usuario');
$I->seeResponseJsonMatchesJsonPath('$.[*].PERSONAS.[*].ID_USUARIO');