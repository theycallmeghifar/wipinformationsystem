<?php defined('BASEPATH') or exit('No direct script access allowed');

  class Model_Order extends CI_Model
  {
    private $tableOrder = "order";

    public function getAllOrderMod()
    {
      return $this->db->get($this->tableOrder)->result();
    }

    public function saveOrderMod($data)
    {
      return $this->db->insert($this->tableOrder, $data);
    }
  }
?>