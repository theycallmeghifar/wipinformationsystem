<?php defined('BASEPATH') or exit('No direct script access allowed');

  class Model_User extends CI_Model
  {
    private $tableUser = "user";

    public function getUserMod()
    {
        return $this->db->get($this->tableUser)->result();
    }

    public function getUserByIdMod($userId)
    {
        $this->db->where('userId', $userId);
        return $this->db->get($this->tableUser)->result();
    }

    public function loginMod($username)
    {
        $this->db->where(array('username' => $username));
        return $this->db->get($this->tableUser)->result();
    }
  }
?>