<?php
    defined('BASEPATH') OR exit('No direct script access allowed');
    require 'vendor/autoload.php';
    use PhpOffice\PhpSpreadsheet\Spreadsheet;
    use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
    use PhpOffice\PhpSpreadsheet\IOFactory;

    class Item extends CI_Controller {

        public function __construct()
        { 
            parent::__construct();
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
            $getData["getData"] = $this->model_Item->getAllItemMod();
            $this->load->view('UI/Item', $getData);
        }

        public function saveItemCon()
        {
            $userSession = $this->session->userdata();
            date_default_timezone_set('Asia/Jakarta');

            $itemCode = strtoupper($this->input->post('itemCode'));
            $existData = $this->model_Item->getItemByItemCodeMod($itemCode);
            if ($existData != null) {
                $this->session->set_flashdata('error', "Kode item '$itemCode' sudah ada!");
                redirect(base_url('./Item'));
                return;
            }

            $data = array(
                'itemCode' => strtoupper($this->input->post('itemCode')),
                'itemName' => $this->input->post('itemName'),
                'capacityInBox' => $this->input->post('capacityInBox'),
                'status' => 1,
                'createdBy' => isset($userSession['userId']) ? $userSession['userId'] : '',
                'createdDate' => date("Y-m-d H:i:s")
            );

            $insert = $this->model_Item->saveItemMod($data);
            $this->session->set_flashdata('success', "Data berhasil disimpan!");
            redirect(base_url('./Item'));
        }

        public function updateItemCon()
        {
            $userSession = $this->session->userdata();
            date_default_timezone_set('Asia/Jakarta');

            $data = array(
                'itemCode' => strtoupper($this->input->post('itemCodeU')),
                'itemName' => $this->input->post('itemNameU'),
                'capacityInBox' => $this->input->post('capacityInBoxU'),
                'status' => $this->input->post('statusU'),
                'modifiedBy' => isset($userSession['userId']) ? $userSession['userId'] : '',
                'modifiedDate' => date("Y-m-d H:i:s")
            );

        $this->model_Item->updateItemMod($data);
        $this->session->set_flashdata('success', "Data berhasil diedit!");
        redirect(base_url('./Item'));
        }

        public function ExportExcelItemCon()
        {
            $data = $this->model_Item->getAllItemMod();

            if (empty($data)) {
                log_message('error', 'Tidak ada data ditemukan untuk di-export.');
                echo 'Tidak ada data untuk di-export.';
                return;
            }

            $spreadsheet = new PhpOffice\PhpSpreadsheet\Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();

            $table_columns = ['Kode Item', 'Nama Item', 'Kapasitas', 'Status'];
            $column = 0;
            foreach ($table_columns as $field) {
                $sheet->setCellValueByColumnAndRow($column + 1, 1, $field);

                $sheet->getStyle('A1:D1')->applyFromArray([
                    'fill' => [
                        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        'startColor' => ['rgb' => '0F4ED8'],
                    ],
                    'font' => [
                        'bold' => true,
                        'color' => ['rgb' => 'FFFFFF'],
                        'size' => 11,
                    ],
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    ],
                ]);
                $sheet->getColumnDimensionByColumn($column + 1)->setAutoSize(true);
                $column++;
            }

            $row = 2;
            foreach ($data as $d) {
                $status = ($d->status == 0) ? "Tidak Aktif" : "Aktif";
                $sheet->setCellValue('A' . $row, $d->itemCode)
                    ->setCellValue('B' . $row, $d->itemName)
                    ->setCellValue('C' . $row, $d->capacityInBox)
                    ->setCellValue('D' . $row, $status);
                $row++;
            }

            ob_end_clean();

            date_default_timezone_set('Asia/Jakarta');
            $fileName = "DataItem_" . date('Y-m-d_H:i:s') . ".xlsx";

            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header("Content-Disposition: attachment;filename=\"$fileName\"");
            header('Cache-Control: max-age=0');

            $writer = new PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
            $writer->save('php://output');
            exit();
        }

        public function importExcelItemCon()
        {
            date_default_timezone_set('Asia/Jakarta');
            if (isset($_FILES['file'])) {
                $uploadDir = 'uploads/';
                $fileName = basename($_FILES['file']['name']);
                $filePath = $uploadDir . $fileName;
                $mode = $this->input->post('submit');

                if (move_uploaded_file($_FILES['file']['tmp_name'], $filePath)) {
                    try {
                        $spreadsheet = IOFactory::load($filePath);
                        $sheet = $spreadsheet->getActiveSheet();
                        $data = $sheet->toArray();

                        $itemCodesFromExcel = [];
                        foreach ($data as $key => $row) {
                            if ($key == 0) {
                                continue;
                            }
                            $itemCodesFromExcel[] = $row[0];
                        }

                        if($mode == 'edit') {
                            $missingItemCodes = [];
                            foreach ($itemCodesFromExcel as $itemCode) {
                                $existData = $this->model_Item->getItemByItemCodeMod($itemCode);
                                if ($existData == null) {
                                    $missingItemCodes[] = $itemCode;
                                }
                            }
    
                            if (!empty($missingItemCodes)) {
                                $this->session->set_flashdata('error', 'Kode item berikut tidak ada di database: ' . implode(', ', $missingItemCodes));
                                redirect(base_url('./Item'));
                                return;
                            }
    
                            foreach ($data as $key => $row) {
                                if ($key == 0) {
                                    continue;
                                }
    
                                $tempData = array(
                                    'itemCode'      => $row[0],
                                    'itemName'      => $row[1],
                                    'capacityInBox' => $row[2],
                                    'status'        => ($row[3] == "Aktif") ? 1 : 0,
                                    'modifiedBy'    => isset($userSession['userId']) ? $userSession['userId'] : '',
                                    'modifiedDate'  => date("Y-m-d H:i:s"),
                                );
                                $this->model_Item->updateItemMod($tempData);
                            }
                        } else {
                            $existItemCodes = [];
                            foreach ($itemCodesFromExcel as $itemCode) {
                                $existData = $this->model_Item->getItemByItemCodeMod($itemCode);
                                if ($existData != null) {
                                    $existItemCodes[] = $itemCode;
                                }
                            }
    
                            if (!empty($existItemCodes)) {
                                $this->session->set_flashdata('error', 'Kode item sudah ada di database: ' . implode(', ', $existItemCodes));
                                redirect(base_url('./Item'));
                                return;
                            }

                            foreach ($data as $key => $row) {
                                if ($key == 0) {
                                    continue;
                                }

                                $tempData = array(
                                    'itemCode'      => $row[0],
                                    'itemName'      => $row[1],
                                    'capacityInBox' => $row[2],
                                    'status'        => 1,
                                    'createdBy'     => isset($userSession['userId']) ? $userSession['userId'] : '',
                                    'createdDate'   => date("Y-m-d H:i:s"),
                                );
                                $this->model_Item->saveItemMod($tempData);
                            }
                        }

                        $this->session->set_flashdata('success', 'Data berhasil diimport!');
                        unlink($filePath);
                        redirect(base_url('./Item'));
                    } catch (\PhpOffice\PhpSpreadsheet\Reader\Exception $e) {
                        echo $e->getMessage();
                    }
                } else {
                    echo "Error mengunggah file.";
                }
            } else {
                echo "Tidak ada file yang diunggah.";
            }
        }
    }
    ?>