<?php
$I = new AcceptanceTester($scenario);
$I->wantTo('Verificar que Lista de Medicamentos - All - Funciona');
$I->amHttpAuthenticated("liliana.madrid","3405e2f586193b24404d89f36c47fbe7");
$I->sendGET('/Medicamentos');
$I->seeResponseCodeIs(200);
$I->seeResponseIsJson();
try{
    $I->seeResponseJsonMatchesJsonPath('MEDICAMENTOS.[*].ID_MEDICAMENTO');
} catch (Exception $e) {
    $I->seeResponseMatchesJsonType(['MEDICAMENTOS'=>'array']);
}