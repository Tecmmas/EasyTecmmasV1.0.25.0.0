<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Mposrevision extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function buscarPrerevision($numero_placa_ref) {
        $result = $this->db->query("select
                        idpre_prerevision,
                        consecutivo,
                        fecha_prerevision,
                        numero_placa_ref,
                         CASE
                           WHEN tipo_inspeccion = '1' THEN 'TECNICOMECANICA'
                           WHEN tipo_inspeccion = '2' THEN 'PREVENTIVA'
                           WHEN tipo_inspeccion = '3' THEN 'PRUEBA LIBRE'
                        END tipo_inspeccion,
                        CASE
                           WHEN reinspeccion = '0' THEN 'PRIMERA VEZ'
                           WHEN reinspeccion = '1' THEN 'SEGUNDA VEZ'
                        END reinspeccion
                        from 
                        pre_prerevision 
                        where 
                        numero_placa_ref='$numero_placa_ref' and
                        DATE_FORMAT(fecha_prerevision,'%Y%M%d') = DATE_FORMAT(now(),'%Y%M%d') 
                        order by consecutivo desc limit 1");
        return $result;
    }

}
