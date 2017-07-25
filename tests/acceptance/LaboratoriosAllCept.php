<?php
$I = new AcceptanceTester($scenario);
$I->wantTo('Verificar que Lista de Laboratorios - All - Funciona');
$I->amHttpAuthenticated("prueba","3405e2f586193b24404d89f36c47fbe7");
$I->sendGET('/Laboratorios');
$I->seeResponseCodeIs(200);
$I->seeResponseIsJson();
try{
    $I->seeResponseJsonMatchesJsonPath('LABORATORIOS.[*].ID_LABORATORIO');
} catch (Exception $e) {
    $I->seeResponseMatchesJsonType(['LABORATORIOS'=>'array']);
}
