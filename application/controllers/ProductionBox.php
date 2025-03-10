    <?php
    defined('BASEPATH') OR exit('No direct script access allowed');
    require 'vendor/autoload.php';
    use PhpOffice\PhpSpreadsheet\IOFactory;

    class ProductionBox extends CI_Controller {

        public function __construct()
        { 
            parent::__construct();
            $this->load->model("model_Box");
            $this->load->model("model_Item");
            $this->load->model("model_ProductionBox");
            $this->load->model("model_DetailProductionBox");
            $this->load->library('session');
            $this->load->library('phpqrcode/qrlib');
            $this->load->helper('url');

            if (!$this->session->userdata('userId')) {
                redirect(site_url('Login'));
            }
        }

        public function index()
        {
            $getData["getData"] = $this->model_ProductionBox->getAllProductionBoxMod();
            $getData["box"] = $this->model_Box->getAllBoxMod();
            $getData["item"] = $this->model_Item->getAllItemMod();
            $getData["detailProductionBox"] = $this->model_DetailProductionBox->getAllDetailProductionBoxMod();
            $this->load->view('UI/ProductionBox', $getData);
        }

        public function saveProductionBoxCon()
        {
            $userSession = $this->session->userdata();
            date_default_timezone_set('Asia/Jakarta');

            $data = array(
                'boxCode' => strtoupper($this->input->post('boxCode')),
                'location' => 'WIP',
                'status' => 1,
                'createdBy' => isset($userSession['username']) ? $userSession['username'] : '',
                'createdDate' => date("Y-m-d H:i:s")
            );

            $insertedProductionBoxId = $this->model_ProductionBox->saveProductionBoxMod($data);

            $itemCodes = $this->input->post('itemCode');
            $itemQuantities = $this->input->post('itemQuantity');

            if (!empty($itemCodes) && !empty($itemQuantities)) {
                $details = array();
                foreach ($itemCodes as $index => $itemCode) {
                    $details[] = array(
                        'productionBoxId' => $insertedProductionBoxId,
                        'itemCode' => $itemCode,
                        'itemQuantity' => $itemQuantities[$index],
                        'createdBy' => isset($userSession['username']) ? $userSession['username'] : '',
                        'createdDate' => date("Y-m-d H:i:s")
                    );
                }
        
                $this->model_DetailProductionBox->saveDetailProductionBoxBatchMod($details);
            }

            $this->session->set_flashdata('success', "Data saved successfully!");
            redirect(base_url('./ProductionBox'));
        }

        public function updateProductionBoxCon()
        {
            $userSession = $this->session->userdata();
            $productionBoxId = strtoupper($this->input->post('productionBoxIdU'));

            $data = array(
                'productionBoxId' => $productionBoxId,
                'boxCode' => strtoupper($this->input->post('boxCodeU')),
                'modifiedBy' => isset($userSession['username']) ? $userSession['username'] : '',
                'modifiedDate' => date("Y-m-d H:i:s")
            );

            $this->db->trans_start(); // Start Transaction

            // Update the productionBox record
            $this->model_ProductionBox->updateProductionBoxMod($data);

            $itemCodes = $this->input->post('itemCodeU');
            $itemQuantities = $this->input->post('itemQuantityU');

            if (!empty($itemCodes) && !empty($itemQuantities)) {
                // Fetch existing detail records for this productionBoxId
                $existingDetails = $this->model_DetailProductionBox->getDetailProductionBoxByProductionBoxIdMod($productionBoxId);
                $existingItemCodes = array_column($existingDetails, 'itemCode');

                $newItemCodes = [];
                foreach ($itemCodes as $index => $itemCode) {
                    $newItemCodes[] = $itemCode;

                    if (in_array($itemCode, $existingItemCodes)) {
                        // Update existing record
                        $updateData = array(
                            'itemQuantity' => $itemQuantities[$index],
                            'modifiedBy' => isset($userSession['username']) ? $userSession['username'] : '',
                            'modifiedDate' => date("Y-m-d H:i:s")
                        );
                        $this->model_DetailProductionBox->updateDetailProductionBoxMod($productionBoxId, $itemCode, $updateData);
                    } else {
                        // Insert new record
                        $insertData = array(
                            'productionBoxId' => $productionBoxId,
                            'itemCode' => $itemCode,
                            'itemQuantity' => $itemQuantities[$index],
                            'createdBy' => isset($userSession['username']) ? $userSession['username'] : '',
                            'createdDate' => date("Y-m-d H:i:s")
                        );
                        $this->model_DetailProductionBox->saveDetailProductionBoxMod($insertData);
                    }
                }

                // Delete records that are no longer needed
                $this->model_DetailProductionBox->deleteUnwantedDetailProductionBoxMod($productionBoxId, $newItemCodes);
            }

            $this->db->trans_complete(); // End Transaction

            if ($this->db->trans_status() === FALSE) {
                $this->session->set_flashdata('error', "Data update failed!");
            } else {
                $this->session->set_flashdata('success', "Data updated successfully!");
            }

            redirect(base_url('./ProductionBox'));
        }
    }
?>