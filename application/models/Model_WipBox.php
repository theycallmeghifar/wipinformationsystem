<?php defined('BASEPATH') or exit('No direct script access allowed');

  class Model_WipBox extends CI_Model
  {
    private $tableWipBox = "wip_box";

    public function getAllWipBoxMod()
    {
      $this->db->select("wb.*, COUNT(dw.itemCode) AS itemTypeCount, COALESCE(SUM(dw.quantity), 0) AS totalQuantity");
      $this->db->from("wip_box wb");
      $this->db->join("wip_box_detail dw", "dw.wipBoxId = wb.wipBoxId", "left");
      $this->db->group_by("wb.wipBoxId");
      
      return $this->db->get()->result();
    }

    public function getReadyTransferWipBoxMod()
    {
      $this->db->where('status !=', 3);
      return $this->db->get($this->tableWipBox)->result();
    }

    public function getReadyReturWipBoxMod()
    {
      $this->db->select("wb.*, COUNT(dw.itemCode) AS itemTypeCount, COALESCE(SUM(dw.quantity), 0) AS totalQuantity");
      $this->db->from("wip_box wb");
      $this->db->join("wip_box_detail dw", "dw.wipBoxId = wb.wipBoxId", "left");
      $this->db->join("location l", "l.locationId = wb.locationId");
      $this->db->group_by("wb.wipBoxId");
      $this->db->where("l.location", "Machining");
      
      return $this->db->get()->result();
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

    public function updateWipBoxOrderStatusMod($data)
    {
      $where = array(
        'wipBoxId' => $data['wipBoxId'],
      );
      $this->db->where($where);
      return $this->db->update($this->tableWipBox, $data);
    }
  }
?>