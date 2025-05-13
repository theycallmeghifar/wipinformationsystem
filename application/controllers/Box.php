    <?php
    defined('BASEPATH') OR exit('No direct script access allowed');
    require 'vendor/autoload.php';
    use PhpOffice\PhpSpreadsheet\Spreadsheet;
    use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
    use PhpOffice\PhpSpreadsheet\IOFactory;

    class Box extends CI_Controller {

        public function __construct()
        { 
            parent::__construct();
            $this->load->model("model_Box");
            $this->load->library('session');
            $this->load->library('phpqrcode/qrlib');
            $this->load->helper('url');

            if (!$this->session->userdata('userId')) {
                redirect(site_url('Login'));
            }
        }

        public function index()
        {
            $getData["getData"] = $this->model_Box->getAllBoxMod();
            $this->load->view('UI/Box', $getData);
        }

        public function saveBoxCon()
        {
            $userSession = $this->session->userdata();
            date_default_timezone_set('Asia/Jakarta');

            $boxCode = strtoupper($this->input->post('boxCode'));
            $existData = $this->model_Box->getBoxByBoxCodeMod($boxCode);
            if ($existData != null) {
                $this->session->set_flashdata('error', "Kode box '$boxCode' sudah ada!");
                redirect(base_url('./Box'));
                return;
            }

            $data = array(
                'boxCode' => strtoupper($this->input->post('boxCode')),
                'usageStatus' => 0,
                'status' => 1,
                'createdBy' => isset($userSession['userId']) ? $userSession['userId'] : '',
                'createdDate' => date("Y-m-d H:i:s")
            );

            $insert = $this->model_Box->saveBoxMod($data);
            $this->session->set_flashdata('success', "Data berhasil disimpan!");
            redirect(base_url('./Box'));
        }

        public function updateBoxCon()
        {
            $userSession = $this->session->userdata();
            date_default_timezone_set('Asia/Jakarta');

            $data = array(
                'boxCode' => strtoupper($this->input->post('boxCodeU')),
                'status' => $this->input->post('statusU'),
                'modifiedBy' => isset($userSession['userId']) ? $userSession['userId'] : '',
                'modifiedDate' => date("Y-m-d H:i:s")
            );

            $this->model_Box->updateBoxMod($data);
            $this->session->set_flashdata('success', "Data berhasil diedit!");
            redirect(base_url('./Box'));
        }

        public function ExportExcelBoxCon()
        {
            $data = $this->model_Box->getAllBoxMod();

            if (empty($data)) {
                log_message('error', 'Tidak ada data ditemukan untuk di-export.');
                echo 'Tidak ada data untuk di-export.';
                return;
            }

            $spreadsheet = new PhpOffice\PhpSpreadsheet\Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();

            $table_columns = ['Kode Box', 'Status'];
            $column = 0;
            foreach ($table_columns as $field) {
                $sheet->setCellValueByColumnAndRow($column + 1, 1, $field);

                $sheet->getStyle('A1:B1')->applyFromArray([
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
                $sheet->setCellValue('A' . $row, $d->boxCode)
                    ->setCellValue('B' . $row, $status);
                $row++;
            }

            ob_end_clean();

            date_default_timezone_set('Asia/Jakarta');
            $fileName = "DataBox_" . date('Y-m-d_H:i:s') . ".xlsx";

            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header("Content-Disposition: attachment;filename=\"$fileName\"");
            header('Cache-Control: max-age=0');

            $writer = new PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
            $writer->save('php://output');
            exit();
        }

        public function importExcelBoxCon()
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

                        $boxCodesFromExcel = [];
                        foreach ($data as $key => $row) {
                            if ($key == 0) {
                                continue;
                            }
                            $boxCodesFromExcel[] = $row[0];
                        }

                        if($mode == 'edit') {
                            $missingBoxCodes = [];
                            foreach ($boxCodesFromExcel as $boxCode) {
                                $existData = $this->model_Box->getBoxByBoxCodeMod($boxCode);
                                if ($existData == null) {
                                    $missingBoxCodes[] = $boxCode;
                                }
                            }
    
                            if (!empty($missingBoxCodes)) {
                                $this->session->set_flashdata('error', 'Kode box berikut tidak ada di database: ' . implode(', ', $missingBoxCodes));
                                redirect(base_url('./Box'));
                                return;
                            }
    
                            foreach ($data as $key => $row) {
                                if ($key == 0) {
                                    continue;
                                }
    
                                $tempData = array(
                                    'boxCode'    => $row[0],
                                    'status'      => ($row[1] == "Aktif") ? 1 : 0,
                                    'modifiedBy'  => isset($userSession['userId']) ? $userSession['userId'] : '',
                                    'modifiedDate'=> date("Y-m-d H:i:s"),
                                );
                                $this->model_Box->updateBoxMod($tempData);
                            }
                        } else {
                            $existBoxCodes = [];
                            foreach ($boxCodesFromExcel as $boxCode) {
                                $existData = $this->model_Box->getBoxByBoxCodeMod($boxCode);
                                if ($existData != null) {
                                    $existBoxCodes[] = $boxCode;
                                }
                            }
    
                            if (!empty($existBoxCodes)) {
                                $this->session->set_flashdata('error', 'Kode box berikut tidak ada di database: ' . implode(', ', $existBoxCodes));
                                redirect(base_url('./Box'));
                                return;
                            }
    
                            foreach ($data as $key => $row) {
                                if ($key == 0) {
                                    continue;
                                }
    
                                $tempData = array(
                                    'boxCode'    => $row[0],
                                    'usageStatus' => 0,
                                    'status'      => 1,
                                    'createdBy'  => isset($userSession['userId']) ? $userSession['userId'] : '',
                                    'createdDate'=> date("Y-m-d H:i:s"),
                                );
                                $this->model_Box->saveBoxMod($tempData);
                            }
                        }

                        $this->session->set_flashdata('success', 'Data berhasil diimport!');
                        unlink($filePath);
                        redirect(base_url('./Box'));
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