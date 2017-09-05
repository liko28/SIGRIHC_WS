<?php
$I = new AcceptanceTester($scenario);
$I->wantTo('Verificar que Novedades Tipo y Lista - All - Funciona');
$I->amHttpAuthenticated("norys.palma","288f4d07498733bf2f6377b32f27e493");
//Tipo
$I->sendGET('/Novedades/tipos');
$I->seeResponseCodeIs(200);
$I->seeResponseIsJson();
try{
    $I->seeResponseJsonMatchesJsonPath('TIPOS_NOVEDAD.[*].TIPO_NOVEDAD');
} catch (Exception $e) {
    $I->seeResponseMatchesJsonType(['TIPOS_NOVEDAD'=>'array']);
}
//Lista
$I->sendGET('/Novedades/listas');
$I->seeResponseCodeIs(200);
$I->seeResponseIsJson();
try{
    $I->seeResponseJsonMatchesJsonPath('LISTAS_NOVEDAD.[*].COD_NOVEDAD');
} catch (Exception $e) {
    $I->seeResponseMatchesJsonType(['LISTAS_NOVEDAD'=>'array']);
}
