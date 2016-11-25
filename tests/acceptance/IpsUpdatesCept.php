<?php
$I = new AcceptanceTester($scenario);
$I->wantTo('Verificar que Lista de IPS - Updates - Funciona');
$I->amHttpAuthenticated("yenny.navarro","0e9c305be2086dddde743735105aceb5");
$I->sendGET('/Ips/get/updates/1478001600');
$I->seeResponseCodeIs(200);
$I->seeResponseIsJson();
$I->seeResponseJsonMatchesJsonPath('$.[*].COD_INS');