<?php defined('BASEPATH') or exit('No direct script access allowed');

  class Model_OrderItem extends CI_Model
  {
    private $tableOrderItem = "order_item";

    public function getAllOrderItemMod()
    {
      return $this->db->get($this->tableOrderItem)->result();
    }

    public function getOrderItemByIdMod($id)
    {
      $this->db->where('orderItemId', $id);
      return $this->db->get($this->tableOrderItem)->result();
    }

    public function saveOrderItemMod($data)
    {
      return $this->db->insert($this->tableOrderItem, $data);
    }

    public function updateBoxMod($data)
    {
      $where = array(
        'boxCode' => $data['boxCode'],
      );
      $this->db->where($where);
      return $this->db->update($this->tableOrderItem, $data);
    }
  }
?>