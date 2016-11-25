<?php
$I = new AcceptanceTester($scenario);
$I->wantTo('Verificar que Datos de PEC - Updates - Funciona');
$I->amHttpAuthenticated("yenny.navarro","0e9c305be2086dddde743735105aceb5");
//Guias
$I->sendGET('/PEC/Guias/get/updates/1478001600');
$I->seeResponseCodeIs(200);
$I->seeResponseIsJson();
$I->seeResponseJsonMatchesJsonPath('$.[*].ID_GUIA');
//Temas
$I->sendGET('/PEC/Temas/get/updates/1478001600');
$I->seeResponseCodeIs(200);
$I->seeResponseIsJson();
$I->seeResponseJsonMatchesJsonPath('$.[*].ID_TEMA');