<?php
  defined('BASEPATH') OR exit('No direct script access allowed');

  class Login extends CI_Controller {

    public function __construct()
    { 
      parent::__construct();
      $this->load->model("model_User");
      $this->load->library('session');
      $this->load->helper('url');
    }

///////////////////////////////////////////////////////////////////////////////////////LOGIN
    
    public function index()
    {
        $this->load->library('session');
        $this->session->sess_destroy();
        $this->load->view('UI/Login');
    }

    public function getLogin()
    {
      $username = $_POST['username'];
      $pass = $_POST['password'];

      $data = $this->model_User->loginMod($username);

      if (empty($data)) {
        // Jika username tidak ditemukan dalam database
        echo json_encode(array("cek" => 0, "msg" => "Username atau password salah!"));
        return;
      }

      $user = $data[0]; // Mengambil data user pertama yang cocok

      if ($user->password === $pass) {
        // Jika password benar
        $msg = "Selamat Datang!";
        $role = $user->role;

        if ($role == 1) $msg = "Selamat Datang WIP!";
        else if ($role == 2) $msg = "Selamat Datang Machining!";
        else if ($role == 3) $msg = "Selamat Datang Finishing!";

        $session = array(
            'userId' => $user->userId,
            'role' => $user->role,
            'username' => $user->username
        );
        $this->session->set_userdata($session);

        echo json_encode(array("cek" => 1, "msg" => $msg, "role" => $role));
      } else {
        // Jika password salah
        echo json_encode(array("cek" => 0, "msg" => "Username atau password salah!"));
      }
    }
  }
?>