<?php
$I = new AcceptanceTester($scenario);
$I->wantTo('Verificar que Datos de PEC - All - Funciona');
$I->amHttpAuthenticated("norys.palma","288f4d07498733bf2f6377b32f27e493");

//Grupos Objetivo
$I->sendGET('/PEC/GruposObjetivo');
$I->seeResponseCodeIs(200);
$I->seeResponseIsJson();
try{
    $I->seeResponseJsonMatchesJsonPath('PEC_GRUPOS_OBJETIVO.[*].ID_OBJETIVO');
} catch (Exception $e) {
    $I->seeResponseMatchesJsonType(['PEC_GRUPOS_OBJETIVO'=>'array']);
}

//Guias
$I->sendGET('/PEC/Guias');
$I->seeResponseCodeIs(200);
$I->seeResponseIsJson();
try{
    $I->seeResponseJsonMatchesJsonPath('PEC_GUIAS.[*].ID_GUIA');
} catch (Exception $e) {
    $I->seeResponseMatchesJsonType(['PEC_GUIAS'=>'array']);
}

//Procesos
$I->sendGET('/PEC/Procesos');
$I->seeResponseCodeIs(200);
$I->seeResponseIsJson();
try{
    $I->seeResponseJsonMatchesJsonPath('PEC_PROCESOS.[*].ID_PROCESO');
} catch (Exception $e) {
    $I->seeResponseMatchesJsonType(['PEC_PROCESOS'=>'array']);
}

//Programacion
$I->sendGET('/PEC/Programacion');
$I->seeResponseCodeIs(200);
$I->seeResponseIsJson();
try{
    $I->seeResponseJsonMatchesJsonPath('PEC_PROGRAMACIONES.[*].ID');
} catch (Exception $e) {
    $I->seeResponseMatchesJsonType(['PEC_PROGRAMACIONES'=>'array']);
}

//Temas
$I->sendGET('/PEC/Temas');
$I->seeResponseCodeIs(200);
$I->seeResponseIsJson();
try{
    $I->seeResponseJsonMatchesJsonPath('PEC_TEMAS.[*].ID_TEMA');
} catch (Exception $e) {
    $I->seeResponseMatchesJsonType(['PEC_TEMAS'=>'array']);
}