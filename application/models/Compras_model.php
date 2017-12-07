<?php
  class Compras_model extends CI_Model{
    function __construct() {
        parent::__construct();
    }

    public function buscarAntiretrovirales(){
      $this->db->select('id_antiretrovirales, numero_establecimiento, numero_producto, cantidad, fecha')
               ->from('compras.antiretrovirales');
      $query = $this->db->get();
      if ($query->num_rows() > 0) {
        return $query->result();
      }else {
        return FALSE;
      }
    }
  }
?>
