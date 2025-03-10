<?php defined('BASEPATH') or exit('No direct script access allowed');

  class Model_ProductionBox extends CI_Model
  {
    private $tableProductionBox = "production_box";

    public function getAllProductionBoxMod()
    {
      $this->db->select("pb.*, COUNT(dp.itemCode) AS itemTypeCount, COALESCE(SUM(dp.itemQuantity), 0) AS totalQuantity");
      $this->db->from("production_box pb");
      $this->db->join("detail_production_box dp", "dp.productionBoxId = pb.productionBoxId", "left");
      $this->db->group_by("pb.productionBoxId");
      
      return $this->db->get()->result();
    }

    public function getProductionBoxByIdMod($id)
    {
      $this->db->where('productionBoxId', $id);
      return $this->db->get($this->tableProductionBox)->result();
    }

    public function saveProductionBoxMod($data)
    {
      $this->db->insert('production_box', $data);
      return $this->db->insert_id();
    }

    public function updateProductionBoxMod($data)
    {
      $where = array(
        'productionBoxId' => $data['id'],
      );
      $this->db->where($where);
      return $this->db->update($this->tableProductionBox, $data);
    }
  }
?>