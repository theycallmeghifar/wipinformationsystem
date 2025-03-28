<?php defined('BASEPATH') or exit('No direct script access allowed');

  class Model_Location extends CI_Model
  {
    private $tableLocation = "location";

    public function getAllLocationMod()
    {
      return $this->db->get($this->tableLocation)->result();
    }

    public function getLocationByIdMod($id)
    {
      $this->db->where('locationId', $id);
      $query = $this->db->get($this->tableLocation);
      return $query->row_array();
    }

    public function getLocationByAreaMod($area)
    {
      return $this->db->where('area', $area)->get($this->tableLocation)->result();
    }


    public function saveLocationMod($data)
    {
      return $this->db->insert($this->tableLocation, $data);
    }

    public function updateLocationMod($data)
    {
      $where = array(
        'locationId' => $data['locationId'],
      );
      $this->db->where($where);
      return $this->db->update($this->tableLocation, $data);
    }
  }
?>