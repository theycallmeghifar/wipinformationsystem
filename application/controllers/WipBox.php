    <?php
    defined('BASEPATH') OR exit('No direct script access allowed');
    require 'vendor/autoload.php';
    use PhpOffice\PhpSpreadsheet\IOFactory;

    class WipBox extends CI_Controller {

        public function __construct()
        { 
            parent::__construct();
            $this->load->model("model_Box");
            $this->load->model("model_Item");
            $this->load->model("model_Location");
            $this->load->model("model_WipBox");
            $this->load->model("model_WipBoxHistory");
            $this->load->library('session');
            $this->load->library('phpqrcode/qrlib');
            $this->load->helper('url');

            if (!$this->session->userdata('userId')) {
                redirect(site_url('Login'));
            }
        }

        public function index()
        {
            $getData["getData"] = $this->model_WipBox->getAllWipBoxMod();
            $getData["box"] = $this->model_Box->getActiveAndUnusedBoxMod();
            $getData["item"] = $this->model_Item->getAllActiveItemMod();
            $getData["location"] = $this->model_Location->getAllLocationMod();
            $this->load->view('UI/WipBox', $getData);
        }

        public function getItemByItemCodeCon()
        {
            $itemCode = $this->input->get('itemCode');
    
            $data = $this->model_Item->getItemByItemCodeMod($itemCode);
            echo json_encode($data);
        }

        public function getLatestItemInBoxCon()
        {
            $boxCode = $this->input->get('boxCode');
    
            $data = $this->model_WipBox->getLatestItemInBoxMod($boxCode);
            echo json_encode($data);
        }

        public function saveWipBoxCon()
        {
            $userSession = $this->session->userdata();
            date_default_timezone_set('Asia/Jakarta');

            $locationData = $this->getFinishingLocation(); // <- gunakan $this

            $wipBoxData = array(
                'processNumber' => $this->input->post('processNumber'),
                'boxCode' => $this->input->post('boxCode'),
                'productionDate' => $this->input->post('productionDate'),
                'itemCode' => $this->input->post('itemCode'),
                'cavity' => $this->input->post('cavity'),
                'quantity' => $this->input->post('quantity'),
                'locationId' => isset($locationData->locationId) ? $locationData->locationId : null,
                'orderStatus' => 0,
                'orderedBy' => 0,
                'status' => 1,
                'createdBy' => isset($userSession['userId']) ? $userSession['userId'] : '',
                'createdDate' => date("Y-m-d H:i:s")
            );
            $insertId = $this->model_WipBox->saveWipBoxMod($wipBoxData);

            $boxData = array(
                'boxCode' => $this->input->post('boxCode'),
                'usageStatus' => 1,
                'modifiedBy' => isset($userSession['userId']) ? $userSession['userId'] : '',
                'modifiedDate' => date("Y-m-d H:i:s")
            );
            $this->model_Box->updateBoxMod($boxData);

            $initialLocationId = $this->model_WipBoxHistory->getLatestBoxLocationMod($this->input->post('boxCode'));
            $wipBoxHistoryData = array(
                'wipBoxId' => $insertId,
                'processNumber' => $this->input->post('processNumber'),
                'boxCode' => $this->input->post('boxCode'),
                'productionDate' => $this->input->post('productionDate'),
                'itemCode' => $this->input->post('itemCode'),
                'cavity' => $this->input->post('cavity'),
                'quantity' => $this->input->post('quantity'),
                'initialLocationId' => $initialLocationId !== null ? $initialLocationId : (isset($locationData->locationId) ? $locationData->locationId : null),
                'finalLocationId' => isset($locationData->locationId) ? $locationData->locationId : null,
                'status' => 1,
                'createdBy' => isset($userSession['userId']) ? $userSession['userId'] : '',
                'createdDate' => date("Y-m-d H:i:s")
            );
            $this->model_WipBoxHistory->saveWipBoxHistoryMod($wipBoxHistoryData);

            $this->session->set_flashdata('success', "Data berhasil disimpan!");
            redirect(base_url('./WipBox'));
        }

        public function getFinishingLocation()
        {
            $locationData = $this->model_Location->getLocationByAreaAndLineMod('Finishing','Finishing');
            return $locationData;
        }
    }
?>