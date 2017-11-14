<?php
  class Users_model extends CI_Model{

    public $user_id;
    public $username;
    public $email;

    function __construct() {
        parent::__construct();
    }

    public function findAll(){
      $this->db->order_by("user_id", "asc");
      $query = $this->db->get('users');
      if ($query->num_rows() > 0) {
          return  $query->result();
      }
      else {
          return FALSE;
      }
    }
  }
?>
