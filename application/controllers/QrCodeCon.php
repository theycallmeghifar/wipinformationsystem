<?php
  defined('BASEPATH') OR exit('No direct script access allowed');
  require 'vendor/autoload.php';
  use PhpOffice\PhpSpreadsheet\IOFactory;

  class QrCodeCon extends CI_Controller {

    public function __construct()
    { 
      parent::__construct();
      $this->load->model("model_Item");
      $this->load->model("model_Box");
      $this->load->model("model_Location");
      $this->load->library('session');
      $this->load->library('phpqrcode/qrlib');
      $this->load->helper('url');

      if (!$this->session->userdata('userId')) {
        redirect(site_url('Login'));
      }
    }

    public function qrCodeBoxCon()
    {
        $post = $this->input->post();
        $dataPrint = $post['listPrint'];
        $listPrint = explode("|", $dataPrint);

        $listDataPrint = array();
        $count = 1;
        foreach ($listPrint as $l) {
          $listDataPrint[] = json_encode($this->model_Box->getBoxByBoxCodeMod($l), true);
        }

        $data["print"] = $listDataPrint;
        $data["type"] = "box";

        $this->load->view('UI/QrCode', $data);
    }

    public function qrCodeItemCon()
    {
        $post = $this->input->post();
        $dataPrint = $post['listPrint'];
        $listPrint = explode("|", $dataPrint);

        $listDataPrint = array();
        $count = 1;
        foreach ($listPrint as $l) {
            $listDataPrint[] = json_encode($this->model_Item->getItemsByItemCodeMod($l), true);
        }

        $data["print"] = $listDataPrint;
        $data["type"] = "item";

        $this->load->view('UI/QrCode', $data);
    }

    public function qrCodeLocationCon()
    {
        $post = $this->input->post();
        $dataPrint = $post['listPrint'];
        $listPrint = explode("|", $dataPrint);

        $listDataPrint = array();
        $count = 1;
        foreach ($listPrint as $l) {
            $listDataPrint[] = json_encode($this->model_Location->getLocationsByIdMod($l), true);
        }

        $data["print"] = $listDataPrint;
        $data["type"] = "location";

        $this->load->view('UI/QrCode', $data);
    }

    function qrCodeCon($id)
    {
        qrcode::png(
            $id,
            $outfile = false,
            $level = QR_ECLEVEL_H,
            $size = 12,
            $margin = 0
        );
    }
  }
?>