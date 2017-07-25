<?php
$I = new AcceptanceTester($scenario);
$I->wantTo('Verificar que Lista de Preguntas - All - Funciona');
$I->amHttpAuthenticated("liliana.madrid","3405e2f586193b24404d89f36c47fbe7");
$I->sendGET('/Preguntas');
$I->seeResponseCodeIs(200);
$I->seeResponseIsJson();
try{
    $I->seeResponseJsonMatchesJsonPath('PREGUNTAS.[*].ID_PREGUNTA');
} catch (Exception $e) {
    $I->seeResponseMatchesJsonType(['PREGUNTAS'=>'array']);
}