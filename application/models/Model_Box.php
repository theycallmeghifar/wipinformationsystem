<?php defined('BASEPATH') or exit('No direct script access allowed');

  class Model_Box extends CI_Model
  {
    private $tableBox = "box";

    public function getAllBoxMod()
    {
      return $this->db->get($this->tableBox)->result();
    }

    public function getBoxByBoxCodeMod($boxCode)
    {
      $this->db->where('boxCode', $boxCode);
      return $this->db->get($this->tableBox)->result();
    }

    public function getActiveAndUnusedBoxMod()
    {
      $this->db->where('usageStatus', 0);
      $this->db->where('status', 1);
      return $this->db->get($this->tableBox)->result();
    }

    public function saveBoxMod($data)
    {
      return $this->db->insert($this->tableBox, $data);
    }

    public function updateBoxMod($data)
    {
      $where = array(
        'boxCode' => $data['boxCode'],
      );
      $this->db->where($where);
      return $this->db->update($this->tableBox, $data);
    }
  }
?>