<?php
$I = new AcceptanceTester($scenario);
$I->wantTo('Verificar que Programacion - All - Funciona');
$I->amHttpAuthenticated("yenny.navarro","0e9c305be2086dddde743735105aceb5");
$I->sendGET('/Programacion/get/all');
$I->seeResponseCodeIs(200);
$I->seeResponseIsJson();
$I->seeResponseJsonMatchesJsonPath('$.[*].ID_PROGRAMACION');
$I->wantTo('Verificar que Programacion Tiene al menos un Detalle de Usuario');
$I->seeResponseJsonMatchesJsonPath('$.[*].PERSONAS.[*].ID_USUARIO');