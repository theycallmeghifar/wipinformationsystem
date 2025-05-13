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

    public function getLocationsByIdMod($id)
    {
      $this->db->where('locationId', $id);
      return $this->db->get($this->tableLocation)->result();
    }

    public function getLocationsByAreaMod($area)
    {
      return $this->db->where('area', $area)->get($this->tableLocation)->result();
    }

    public function getLocationByAreaAndLineMod($area, $line)
    {
      $this->db->select('*');
      $this->db->from('location');
      $this->db->where('area', $area);
      $this->db->where('line', $line);
      $this->db->where('status =', 1);
      $this->db->limit(1);

      $query = $this->db->get();
      return $query->row();
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