    <?php
    defined('BASEPATH') OR exit('No direct script access allowed');
    require 'vendor/autoload.php';
    use PhpOffice\PhpSpreadsheet\IOFactory;

    class OrderItem extends CI_Controller {

        public function __construct()
        { 
            parent::__construct();
            $this->load->model("model_OrderItem");
            $this->load->model("model_Item");
            $this->load->library('session');
            $this->load->library('phpqrcode/qrlib');
            $this->load->helper('url');

            if (!$this->session->userdata('userId')) {
                redirect(site_url('Login'));
            }
        }

        public function index()
        {
            $getData["getData"] = $this->model_OrderItem->getAllOrderItemMod();
            $getData["item"] = $this->model_Item->getActiveItemMod();
            $this->load->view('UI/OrderItem', $getData);
        }

        public function saveOrderItemCon()
        {
            $userSession = $this->session->userdata();
            date_default_timezone_set('Asia/Jakarta');

            $data = array(
                'itemCode' => strtoupper($this->input->post('itemCode')),
                'quantity' => $this->input->post('quantity'),
                'status' => 1,
                'createdBy' => isset($userSession['username']) ? $userSession['username'] : '',
                'createdDate' => date("Y-m-d H:i:s")
            );

            $insert = $this->model_OrderItem->saveOrderItemMod($data);
            $this->session->set_flashdata('success', "Data berhasil disimpan!");
            redirect(base_url('./OrderItem'));
        }

        public function updateOrderItemStatusCon()
        {
            $userSession = $this->session->userdata();
            date_default_timezone_set('Asia/Jakarta');

            $data = array(
                'orderItemCode' => strtoupper($this->input->post('orderItemCodeU')),
                'status' => $this->input->post('statusU'),
                'modifiedBy' => isset($userSession['username']) ? $userSession['username'] : '',
                'modifiedDate' => date("Y-m-d H:i:s")
            );

        $this->model_OrderItem->updateOrderItemMod($data);
        $this->session->set_flashdata('success', "Data berhasil diedit!");
        redirect(base_url('./Box'));
        }
    }
    ?>