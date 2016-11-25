<?php
$I = new AcceptanceTester($scenario);
$I->wantTo('Verificar que Lista de Referencia - Updates - Funciona');
$I->amHttpAuthenticated("yenny.navarro","0e9c305be2086dddde743735105aceb5");
//Tipo
$I->sendGET('/Novedades/tipo/get/updates/1478001600');
$I->seeResponseCodeIs(200);
$I->seeResponseIsJson();
$I->seeResponseJsonMatchesJsonPath('$.[*].TIPO_NOVEDAD');
//Lista
$I->sendGET('/Novedades/lista/get/updates/1478001600');
$I->seeResponseCodeIs(200);
$I->seeResponseIsJson();
$I->seeResponseJsonMatchesJsonPath('$.[*].COD_NOVEDAD');