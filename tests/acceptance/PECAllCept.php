<?php
$I = new AcceptanceTester($scenario);
$I->wantTo('Verificar que Datos de PEC - All - Funciona');
$I->amHttpAuthenticated("yenny.navarro","0e9c305be2086dddde743735105aceb5");
//Grupos Objetivo
$I->sendGET('/PEC/GruposObjetivo/tipo/get/all');
$I->seeResponseCodeIs(200);
$I->seeResponseIsJson();
$I->seeResponseJsonMatchesJsonPath('$.[*].ID_OBJETIVO');
//Guias
$I->sendGET('/PEC/Guias/lista/get/all');
$I->seeResponseCodeIs(200);
$I->seeResponseIsJson();
$I->seeResponseJsonMatchesJsonPath('$.[*].ID_GUIA');
//Procesos
$I->sendGET('/PEC/Procesos/lista/get/all');
$I->seeResponseCodeIs(200);
$I->seeResponseIsJson();
$I->seeResponseJsonMatchesJsonPath('$.[*].ID_PROCESO');
//Programacion
$I->sendGET('/PEC/Programacion/lista/get/all');
$I->seeResponseCodeIs(200);
$I->seeResponseIsJson();
$I->seeResponseJsonMatchesJsonPath('$.[*].ID');
//Temas
$I->sendGET('/PEC/Temas/lista/get/all');
$I->seeResponseCodeIs(200);
$I->seeResponseIsJson();
$I->seeResponseJsonMatchesJsonPath('$.[*].ID_TEMA');