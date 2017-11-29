<?php
  class Expedientes_model extends CI_Model{
    function __construct() {
        parent::__construct();
    }

    public function buscarExpediente(){
      $this->db->select('*')->from('expediente');
      $query1 = $this->db->get();
      if ($query1->num_rows() > 0) {
        return $query1->result();
      }else {
        return FALSE;
      }
    }

    public function buscarHistoriales($numero_expediente){
      $this->db->select('d.id_detalle_expediente, d.medico_atendio, d.diagnostico, d.fecha_consulta, d.motivo_consulta, d.id_expediente, d.peso')
               ->from('detalle_expediente d')
               ->join('expediente e','e.id_expediente = d.id_expediente')
               ->where('e.numero_expediente',$numero_expediente);
      $query2 = $this->db->get();
      if ($query2->num_rows() > 0) {
        return $query2->result();
      }else {
        return FALSE;
      }
    }
  }
?>
