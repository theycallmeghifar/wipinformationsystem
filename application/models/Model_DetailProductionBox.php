<?php defined('BASEPATH') or exit('No direct script access allowed');

  class Model_DetailProductionBox extends CI_Model
  {
    private $tableDetailProductionBox = "detail_production_box";

    public function getAllDetailProductionBoxMod()
    {
      return $this->db->get($this->tableDetailProductionBox)->result();
    }

    public function getDetailProductionBoxByProductionBoxIdMod($id)
    {
      $this->db->where('productionBoxId', $id);
      return $this->db->get($this->tableDetailProductionBox)->result();
    }

    public function saveDetailProductionBoxMod($data)
    {
      return $this->db->insert($this->tableDetailProductionBox, $data);
    }

    public function saveDetailProductionBoxBatchMod($data)
    {
      return $this->db->insert_batch($this->tableDetailProductionBox, $data);
    }

    public function updateDetailProductionBoxMod($productionBoxId, $itemCode, $data)
    {
        $this->db->where([
            'productionBoxId' => $productionBoxId,
            'itemCode' => $itemCode
        ]);
        return $this->db->update($this->tableDetailProductionBox, $data);
    }

    public function deleteUnwantedDetailProductionBoxMod($productionBoxId, $newItemCodes)
    {
        $this->db->where('productionBoxId', $productionBoxId);
        $this->db->where_not_in('itemCode', $newItemCodes);
        return $this->db->delete($this->tableDetailProductionBox);
    }
  }
?>