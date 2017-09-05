<?php
$I = new AcceptanceTester($scenario);
$I->wantTo('Verificar que Lista de Referencia - All - Funciona');
$I->amHttpAuthenticated("norys.palma","288f4d07498733bf2f6377b32f27e493");
$I->sendGET('/ListasReferencia');
$I->seeResponseCodeIs(200);
$I->seeResponseIsJson();
try{
    $I->seeResponseJsonMatchesJsonPath('LISTAS_REFERENCIA.[*].ID_LISTA');
} catch (Exception $e) {
    $I->seeResponseMatchesJsonType(['LISTAS_REFERENCIA'=>'array']);
}
