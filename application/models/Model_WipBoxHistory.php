<?php defined('BASEPATH') or exit('No direct script access allowed');

  class Model_WipBoxHistory extends CI_Model
  {
    private $tableWipBoxHistory = "wip_box_history";

    public function getAllWipBoxHistoryMod()
    {
      return $this->db->get($this->tableWipBoxHistory)->result();
    }

    public function getAllTodaysWipBoxHistoryMod()
    {
      $this->db->select('*');
      $this->db->from($this->tableWipBoxHistory);
      $this->db->where('DATE(createdDate)', date('Y-m-d'));
      $this->db->order_by('createdDate', 'DESC');

      $query = $this->db->get();
      return $query->result();
    }

    public function getWipBoxHistoryByDateMod($startDate, $endDate)
    {
      $this->db->select('*');
      $this->db->from($this->tableWipBoxHistory);
      $this->db->where('createdDate >=', $startDate);
      $this->db->where('createdDate <=', $endDate);
      $this->db->order_by('createdDate', 'DESC');

      $query = $this->db->get();
      return $query->result();
    }

    public function saveWipBoxHistoryMod($data)
    {
      return $this->db->insert($this->tableWipBoxHistory, $data);
    }

    public function getLatestBoxLocationMod($boxCode)
    {
      $this->db->select('initialLocationId');
      $this->db->from($this->tableWipBoxHistory);
      $this->db->where('boxCode', $boxCode);
      $this->db->where('status', 3);
      $this->db->order_by('createdDate', 'DESC');
      $this->db->limit(1);

      $query = $this->db->get();
      $row = $query->row();
      return $row ? $row->initialLocationId : null;
    }
  }
?>