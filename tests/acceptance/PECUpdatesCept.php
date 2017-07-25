<?php
$I = new AcceptanceTester($scenario);
$I->wantTo('Verificar que Datos de PEC - Updates - Funciona');
$I->amHttpAuthenticated("liliana.madrid","3405e2f586193b24404d89f36c47fbe7");
//Guias
$I->sendGET('/PEC/Guias/1478001600');
$I->seeResponseCodeIs(200);
$I->seeResponseIsJson();
try{
    $I->seeResponseJsonMatchesJsonPath('PEC_GUIAS.[*].ID_GUIA');
} catch (Exception $e) {
    $I->seeResponseMatchesJsonType(['PEC_GUIAS'=>'array']);
}

//Temas
$I->sendGET('/PEC/Temas/1478001600');
$I->seeResponseCodeIs(200);
$I->seeResponseIsJson();
try{
    $I->seeResponseJsonMatchesJsonPath('PEC_TEMAS.[*].ID_TEMA');
} catch (Exception $e) {
    $I->seeResponseMatchesJsonType(['PEC_TEMAS'=>'array']);
}