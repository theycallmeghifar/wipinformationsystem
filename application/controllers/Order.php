    <?php
    defined('BASEPATH') OR exit('No direct script access allowed');
    require 'vendor/autoload.php';
    use PhpOffice\PhpSpreadsheet\IOFactory;

    class Order extends CI_Controller {

        public function __construct()
        {
            parent::__construct();
            $this->load->model("model_Order");
            $this->load->model("model_Location");
            $this->load->model("model_Item");
            $this->load->model("model_WipBox");
            $this->load->library('session');
            $this->load->library('phpqrcode/qrlib');
            $this->load->helper('url');

            if (!$this->session->userdata('userId')) {
                redirect(site_url('Login'));
            }
        }

        public function index()
        {
            $getData["getData"] = $this->model_Order->getAllOrderMod();
            $getData["item"] = $this->model_Item->getAllActiveItemMod();
            $getData["location"] = $this->model_Location->getLocationsByAreaMod('Machining');
            $this->load->view('UI/Order', $getData);
        }

        public function getAllOrderDataCon()
        {
            $data = $this->model_Order->getAllOrderMod();
            header('Content-Type: application/json');
            echo json_encode($data);
        }

        public function getItemStockInWipCon()
        {
            $itemCode = $this->input->get('itemCode');
            $cavity = $this->input->get('cavity');
    
            if (empty($cavity)) {
                $data = $this->model_WipBox->getWipBoxByItemCodeMod($itemCode);
            } else {
                $data = $this->model_WipBox->getWipBoxByItemCodeAndcavityMod($itemCode, $cavity);
            }

            echo json_encode($data);
        }

        public function saveOrderCon()
        {
            $userSession = $this->session->userdata();
            date_default_timezone_set('Asia/Jakarta');

            $cavityInput = $this->input->post('cavity');
            $cavity = ($cavityInput !== null && $cavityInput !== '') ? $cavityInput : 0;

            $data = array(
                'locationId' => $this->input->post('locationId'),
                'itemCode' => $this->input->post('itemCode'),
                'cavity' => $cavity,
                'quantity' => $this->input->post('quantity'),
                'status' => 1,
                'createdBy' => isset($userSession['userId']) ? $userSession['userId'] : '',
                'createdDate' => date("Y-m-d H:i:s")
            );

            $insert = $this->model_Order->saveOrderMod($data);
            $this->session->set_flashdata('success', "Data berhasil disimpan!");
            redirect(base_url('./Order'));
        }
    }
    ?>