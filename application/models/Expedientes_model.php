<?php
  class Expedientes_model extends CI_Model{

    public $user_id;
    public $username;
    public $email;

    function __construct() {
        parent::__construct();
    }

    public function buscarExpedientes(){
      $data = array(
        'expedientes' => '',
        'detalles' => ''
      );
      $this->db->select('*')->from('expediente');
      $query1 = $this->db->get();

      $this->db->select('*')->from('detalle_expediente');
      $query2 = $this->db->get();

      if ($query1->num_rows() > 0 && $query2->num_rows() > 0) {
          $data['expedientes'] = $query1->result();
          $data['detalles'] = $query2->result();
          return $data;
      }
      else {
          return FALSE;
      }
    }
  }
?>
