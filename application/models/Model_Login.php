<?php defined('BASEPATH') or exit('No direct script access allowed');

  class Model_Login extends CI_Model
  {

    ///TABLE
    private $tableUser = "user";

///////////////////////////////////////////////////////////////////////////////////////////////LOGIN

    public function getUserMod()
    {
        $this->db->get($this->tableUser)->result();
        $this->db->order_by('role');
        return $this->db->get($this->tableUser)->result();
    }

    public function getUserModByID($id)
    {
        $this->db->where('idUser', $id);
        return $this->db->get($this->tableUser)->result();
    }

    public function cekLoginMod($uname)
    {
        $this->db->where(array('username' => $uname));
        return $this->db->get($this->tableUser)->result();
    }

    public function cekPassMod($id)
    {

        $this->db->where(array('id' => $id));
        return $this->db->get($this->tableUser)->result();
    }

    public function saveUserMod()
    {
        $post = $this->input->post();
        $id = $post["id"];
        $user = $this->getUserModByID($id);

        if ($id != "" || $id != null) {
            $data = array(
                'username' => $post["uname"],
                'role' => $post["role"],
                'password' => $user[0]->password,
                'status' => $post["status"]
            );
            return $this->db->update($this->tableUser, $data, array('id' => $id));
        } else {
            $this->username = $post["uname"];
            $this->role = $post["role"];
            $this->password = "fim@2021";
            return $this->db->insert($this->tableUser, $this);
        }
    }

    public function editProfilMod()
    {
        $post = $this->input->post();
        $id = $this->session->userdata('id');
        $user = $this->getUserModByID($id);

        $data = array(
            'username' => $post["uname"],
            'role' => $user[0]->role,
            'password' => $user[0]->password,
            'status' => $user[0]->status
        );

        // $this->session->set_userdata("Nama", $post["nama"]);
        $this->session->set_userdata("username", $post["uname"]);

        return $this->db->update($this->tableUser, $data, array('id' => $id));
    }

    public function editPassMod()
    {
        $post = $this->input->post();
        $id = $this->session->userdata('ID');
        $user = $this->getUserModByID($id);

        $data = array(
            'username' => $user[0]->username,
            'role' => $user[0]->role,
            'password' => $post["confirmPass"],
            'status' => $user[0]->status
        );

        return $this->db->update($this->tableUser, $data, array('id' => $id));
    }

    public function statusEditMod()
    {
        $post = $this->input->post();
        $id = $post['id'];
        $data = array();

        $user = $this->getUserModByID($id);

        $data['role'] = $user[0]->role;
        $data['username'] = $user[0]->username;
        $data['password'] = $user[0]->password;

        if ($user[0]->status == 0) {   // tdk aktif
            $data['status'] = 1;
        } else {    // aktif
            $data['status'] = 0;
        }

        return $this->db->update($this->tableUser, $data, array('id' => $id));
    }

  }
?>