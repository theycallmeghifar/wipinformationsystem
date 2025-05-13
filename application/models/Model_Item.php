<?php defined('BASEPATH') or exit('No direct script access allowed');

  class Model_Item extends CI_Model
  {
    private $tableItem = "item";

    public function getAllItemMod()
    {
      return $this->db->get($this->tableItem)->result();
    }

    public function getAllActiveItemMod()
    {
      $this->db->where('status', 1);
      return $this->db->get($this->tableItem)->result();
    }

    public function getItemsByItemCodeMod($itemCode)
    {
      $this->db->where('ItemCode', $itemCode);
      return $this->db->get($this->tableItem)->result();
    }

    public function getItemByItemCodeMod($itemCode)
    {
      $this->db->where('itemCode', $itemCode);
      $query = $this->db->get($this->tableItem);
      return $query->row_array();
    }

    public function saveItemMod($data)
    {
      return $this->db->insert($this->tableItem, $data);
    }

    public function updateItemMod($data)
    {
      $where = array(
        'itemCode' => $data['itemCode'],
      );
      $this->db->where($where);
      return $this->db->update($this->tableItem, $data);
    }
  }
?>