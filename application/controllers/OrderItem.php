    <?php
    defined('BASEPATH') OR exit('No direct script access allowed');
    require 'vendor/autoload.php';
    use PhpOffice\PhpSpreadsheet\IOFactory;

    class OrderItem extends CI_Controller {

        public function __construct()
        { 
            parent::__construct();
            $this->load->model("model_WipBox");
            $this->load->model("model_OrderItem");
            $this->load->model("model_Location");
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
            $getData["location"] = $this->model_Location->getLocationByAreaMod('Machining');
            $this->load->view('UI/OrderItem', $getData);
        }

        public function getAllOrderDataCon()
        {
            $data = $this->model_OrderItem->getAllOrderItemMod();
            header('Content-Type: application/json'); // Pastikan response JSON
            echo json_encode($data);
        }

        public function getOrderItemDataCon()
        {
            $itemCode = $this->input->get('itemCode');
    
            $data = $this->model_OrderItem->getItemReadyOrderMod($itemCode);
            echo json_encode($data);
        }

        public function getOrderCavityDataCon()
        {
            $cavity = $this->input->get('cavity');

            $data = $this->model_OrderItem->getCavityReadyOrderMod($cavity);
            echo json_encode($data);
        }
        
        public function getMatchingBoxCon()
        {
            $item = $this->input->get('item');
            $quantity = $this->input->get('quantity');

            $data = $this->model_OrderItem->getMatchingBoxItemMod($item, $quantity);
            echo json_encode($data);
        }

        public function confirmOrderCon()
        {
            $userSession = $this->session->userdata();
            date_default_timezone_set('Asia/Jakarta');

            $postData = $this->input->post();
            $wipBoxData = isset($postData['wipBoxData']) ? $postData['wipBoxData'] : [];
            $action = isset($postData['action']) ? $postData['action'] : '';
            $orderId = isset($postData['orderId']) ? $postData['orderId'] : '';
            $status = ($action == 'accept') ? 1 : 2;
            $orderStatus = ($action == 'accept') ? 1 : 0;

            $orderData = array(
                'orderId' => $orderId,
                'status' => $status,
                'modifiedBy' => 'wip',
                'modifiedDate' => date("Y-m-d H:i:s")
            );
            $this->model_OrderItem->updateOrderStatusMod($orderData);

            if (!empty($wipBoxData)) {
                foreach ($wipBoxData as $item) {
                    $data = array(
                        'wipBoxId' => $item['wipBoxId'],
                        'orderStatus' => $orderStatus,
                    );
                    $this->model_WipBox->updateWipBoxOrderStatusMod($data);
                }
            }

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