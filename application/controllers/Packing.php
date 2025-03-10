    <?php
    defined('BASEPATH') OR exit('No direct script access allowed');
    require 'vendor/autoload.php';
    use PhpOffice\PhpSpreadsheet\IOFactory;

    class Packing extends CI_Controller {

        public function __construct()
        { 
            parent::__construct();
            $this->load->model("model_Box");
            $this->load->model("model_Item");
            $this->load->model("model_Location");
            $this->load->model("model_WipBox");
            $this->load->model("model_WipBoxDetail");
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
            $getData["box"] = $this->model_Box->getActiveAndNotUsedBoxMod();
            $getData["item"] = $this->model_Item->getActiveItemMod();
            $getData["location"] = $this->model_Location->getAllLocationMod();
            $getData["wipBoxDetail"] = $this->model_WipBoxDetail->getAllWipBoxDetailMod();
            $this->load->view('UI/Packing', $getData);
        }

        public function saveWipBoxCon()
        {
            $userSession = $this->session->userdata();
            date_default_timezone_set('Asia/Jakarta');

            $data = array(
                'boxCode' => strtoupper($this->input->post('boxCode')),
                'locationId' => 1,
                'status' => 1,
                'createdBy' => isset($userSession['username']) ? $userSession['username'] : '',
                'createdDate' => date("Y-m-d H:i:s")
            );

            $insertedWipBoxId = $this->model_WipBox->saveWipBoxMod($data);

            $itemCodes = $this->input->post('itemCode');
            $quantities = $this->input->post('quantity');

            if (!empty($itemCodes) && !empty($quantities)) {
                $details = array();
                foreach ($itemCodes as $index => $itemCode) {
                    $details[] = array(
                        'wipBoxId' => $insertedWipBoxId,
                        'itemCode' => $itemCode,
                        'quantity' => $quantities[$index],
                        'createdBy' => isset($userSession['username']) ? $userSession['username'] : '',
                        'createdDate' => date("Y-m-d H:i:s")
                    );
                }
        
                $this->model_WipBoxDetail->saveWipBoxDetailBatchMod($details);
            }

            $boxData = array(
                'boxCode' => strtoupper($this->input->post('boxCode')),
                'usageStatus' => 1
            );
            $this->model_Box->updateBoxMod($boxData);

            $this->session->set_flashdata('success', "Data berhasil disimpan!");
            redirect(base_url('./Packing'));
        }

        public function updateWipBoxCon()
        {
            $userSession = $this->session->userdata();
            $wipBoxId = strtoupper($this->input->post('wipBoxIdU'));

            $data = array(
                'wipBoxId' => $wipBoxId,
                'boxCode' => strtoupper($this->input->post('boxCodeU')),
                'modifiedBy' => isset($userSession['username']) ? $userSession['username'] : '',
                'modifiedDate' => date("Y-m-d H:i:s")
            );

            $this->db->trans_start();

            // Update the productionBox record
            $this->model_WipBox->updateWipBoxMod($data);

            $itemCodes = $this->input->post('itemCodeU');
            $quantities = $this->input->post('quantityU');

            if (!empty($itemCodes) && !empty($quantities)) {
                // Fetch existing detail records for this productionBoxId
                $existingDetails = $this->model_WipBoxDetail->getWipBoxDetailByWipBoxIdMod($wipBoxId);
                $existingItemCodes = array_column($existingDetails, 'itemCode');

                $newItemCodes = [];
                foreach ($itemCodes as $index => $itemCode) {
                    $newItemCodes[] = $itemCode;

                    if (in_array($itemCode, $existingItemCodes)) {
                        // Update existing record
                        $updateData = array(
                            'quantity' => $quantities[$index],
                            'modifiedBy' => isset($userSession['username']) ? $userSession['username'] : '',
                            'modifiedDate' => date("Y-m-d H:i:s")
                        );
                        $this->model_WipBoxDetail->updateWipBoxDetailMod($wipBoxId, $itemCode, $updateData);
                    } else {
                        // Insert new record
                        $insertData = array(
                            'wipBoxId' => $wipBoxId,
                            'itemCode' => $itemCode,
                            'quantity' => $quantities[$index],
                            'createdBy' => isset($userSession['username']) ? $userSession['username'] : '',
                            'createdDate' => date("Y-m-d H:i:s")
                        );
                        $this->model_WipBoxDetail->saveWipBoxDetailMod($insertData);
                    }
                }

                // Delete records that are no longer needed
                $this->model_WipBoxDetail->deleteUnwantedWipBoxDetailMod($wipBoxId, $newItemCodes);
            }

            $this->db->trans_complete(); // End Transaction

            if ($this->db->trans_status() === FALSE) {
                $this->session->set_flashdata('error', "Data gagal diedit!");
            } else {
                $this->session->set_flashdata('success', "Data berhasil diedit!");
            }

            redirect(base_url('./Packing'));
        }
    }
    ?>