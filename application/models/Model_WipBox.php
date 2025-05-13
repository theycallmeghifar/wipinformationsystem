<?php defined('BASEPATH') or exit('No direct script access allowed');

  class Model_WipBox extends CI_Model
  {
    private $tableWipBox = "wip_box";

    public function getAllWipBoxMod()
    {
      return $this->db->get($this->tableWipBox)->result();
    }

    public function getWipBoxByIdMod($id)
    {
      $this->db->where('productionBoxId', $id);
      return $this->db->get($this->tableWipBox)->row();
    }

    public function saveWipBoxMod($data)
    {
      $this->db->insert('wip_box', $data);
      return $this->db->insert_id();
    }

    public function getWipBoxByItemCodeMod($itemCode)
    {
      $this->db->select('SUM(quantity) AS stock');
      $this->db->from('wip_box wb');
      $this->db->join('location l', 'l.locationId = wb.locationId');
      $this->db->where('l.area', 'WIP');
      $this->db->where('wb.itemCode', $itemCode);
      $this->db->where('wb.orderStatus !=', 1);
      $this->db->where('wb.status !=', 3);
      $this->db->limit(1);

      $query = $this->db->get();
      return $query->row();
    }
    
    public function getWipBoxByItemCodeAndcavityMod($itemCode, $cavity)
    {
      $this->db->select('SUM(quantity) AS stock');
      $this->db->from('wip_box wb');
      $this->db->join('location l', 'l.locationId = wb.locationId');
      $this->db->where('l.area', 'WIP');
      $this->db->where('wb.itemCode', $itemCode);
      $this->db->where('wb.cavity', $cavity);
      $this->db->where('wb.orderStatus !=', 1);
      $this->db->where('wb.status !=', 3);
      $this->db->limit(1);

      $query = $this->db->get();
      return $query->row();
    }

    public function getLatestItemInBoxMod($boxCode)
    {
      $this->db->select('i.itemName');
      $this->db->from('wip_box wb');
      $this->db->join('item i', 'wb.itemCode = i.itemCode');
      $this->db->where('wb.boxCode', $boxCode);
      $this->db->where('wb.status', 3);
      $this->db->order_by('wb.createdDate', 'DESC');
      $this->db->limit(1);

      $query = $this->db->get();
      return $query->row();
    }
  }
?>