<?php
/**
 * Created by PhpStorm.
 * User: ramiro
 * Date: 26/12/16
 * Time: 09:47 AM
 */

namespace SIGRI_HC\Models;


class HcMedicaModel extends BaseModel {
    /** @param Connection $connection */
    public function __construct(Connection $connection) {
        parent::__construct($connection);
        $this->setTableName('HC_MEDICA');
        $this->setPrimaryKey('ID_HC');
        $this->addColumns('ID_HC','ID_USUARIO','NUM_HC','TIPOHC','FECATENCION','RUTA','CLASIFICACION','FECINGRESO','DPTO','MUNICIPIO','ZONA','CODEPS','DIRECCION','BARRIO','TELEFONO','CELULAR1','CELULAR2','TIPOREGIMEN','ESTADOCIVIL','GPOBLACIONAL','ETNIA','ESCOLARIDAD','OCUPACION','ACTECONO','RELIGION','GENERO','OSEXUAL','EDAD','MOTCONSULTA','ENFERMEDAD','RECOMENDACIONES','FECULTCITAMI','HORAFINHC','ID_USER','FIRMA','TARJETA','ESTADO','NOVEDAD','PROGRAMACION','RIESGOCV','USERCREA','FECCREA','IPCREA','USERMODI','FECMODI','IPMODI');
    }

    public function getByPerson($idUser){
        return $this->query("SELECT * FROM {$this->getSchema()}.{$this->getTableName()} WHERE ID_USUARIO = ? AND ESTADO in(?)",$idUser,'A');
    }
}