<?php
  defined('BASEPATH') OR exit('No direct script access allowed');

  class Dashboard extends CI_Controller {

    public function __construct()
    { 
      parent::__construct();
      $this->load->model("model_Dashboard");
      $this->load->library('session');
      $this->load->helper('url');

      if (!$this->session->userdata('userId')) {
        redirect(site_url('Login'));
      }
    }

///////////////////////////////////////////////////////////////////////////////////////DASHBOARD

    public function index()
    {
      $this->load->view('UI/Dashboard');
    }

  }
?>