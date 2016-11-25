<?php
$I = new AcceptanceTester($scenario);
$I->wantTo('Verificar que Datos de PEC - All - Funciona');
$I->amHttpAuthenticated("yenny.navarro","0e9c305be2086dddde743735105aceb5");
//Grupos Objetivo
$I->sendGET('/PEC/GruposObjetivo/get/all');
$I->seeResponseCodeIs(200);
$I->seeResponseIsJson();
$I->seeResponseJsonMatchesJsonPath('$.[*].ID_OBJETIVO');
//Guias
$I->sendGET('/PEC/Guias/get/all');
$I->seeResponseCodeIs(200);
$I->seeResponseIsJson();
$I->seeResponseJsonMatchesJsonPath('$.[*].ID_GUIA');
//Procesos
$I->sendGET('/PEC/Procesos/get/all');
$I->seeResponseCodeIs(200);
$I->seeResponseIsJson();
$I->seeResponseJsonMatchesJsonPath('$.[*].ID_PROCESO');
//Programacion
$I->sendGET('/PEC/Programacion/get/all');
$I->seeResponseCodeIs(200);
$I->seeResponseIsJson();
$I->seeResponseJsonMatchesJsonPath('$.[*].ID');
//Temas
$I->sendGET('/PEC/Temas/get/all');
$I->seeResponseCodeIs(200);
$I->seeResponseIsJson();
$I->seeResponseJsonMatchesJsonPath('$.[*].ID_TEMA');