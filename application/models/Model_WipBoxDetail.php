<?php defined('BASEPATH') or exit('No direct script access allowed');

  class Model_WipBoxDetail extends CI_Model
  {
    private $tableWipBoxDetail = "wip_box_detail";

    public function getAllWipBoxDetailMod()
    {
      return $this->db->get($this->tableWipBoxDetail)->result();
    }

    public function getWipBoxDetailForTransferMod()
    {
      $this->db->select("d.*, i.itemName");
      $this->db->from("wip_box_detail d");
      $this->db->join("wip_box w", "w.wipBoxId = d.wipBoxId");
      $this->db->join("item i", "d.itemCode = i.itemCode");
      $this->db->where("w.status", 1);

      return $this->db->get()->result();

      return $this->db->get($this->tableWipBoxDetail)->result();
    }

    public function getWipBoxDetailByWipBoxIdMod($id)
    {
      $this->db->where('wipBoxId', $id);
      return $this->db->get($this->tableWipBoxDetail)->result();
    }

    public function saveWipBoxDetailMod($data)
    {
      return $this->db->insert($this->tableWipBoxDetail, $data);
    }

    public function saveWipBoxDetailBatchMod($data)
    {
      return $this->db->insert_batch($this->tableWipBoxDetail, $data);
    }

    public function updateWipBoxDetailMod($wipBoxId, $itemCode, $data)
    {
        $this->db->where([
            'wipBoxId' => $wipBoxId,
            'itemCode' => $itemCode
        ]);
        return $this->db->update($this->tableWipBoxDetail, $data);
    }

    public function deleteUnwantedWipBoxDetailMod($wipBoxId, $newItemCodes)
    {
        $this->db->where('wipBoxId', $wipBoxId);
        $this->db->where_not_in('itemCode', $newItemCodes);
        return $this->db->delete($this->tableWipBoxDetail);
    }
  }
?>