    <?php
    defined('BASEPATH') OR exit('No direct script access allowed');
    require 'vendor/autoload.php';
    use PhpOffice\PhpSpreadsheet\IOFactory;

    class Location extends CI_Controller {

        public function __construct()
        { 
            parent::__construct();
            $this->load->model("model_Location");
            $this->load->library('session');
            $this->load->library('phpqrcode/qrlib');
            $this->load->helper('url');

            if (!$this->session->userdata('userId')) {
                redirect(site_url('Login'));
            }
        }

        public function index()
        {
            $getData["getData"] = $this->model_Location->getAllLocationMod();
            $this->load->view('UI/Location', $getData);
        }
        
        public function getLocationByIdCon()
        {
            $locationId = $this->input->get('locationId');
    
            $data = $this->model_Location->getLocationByIdMod($locationId);
            echo json_encode($data);
        }

        public function getLocationByAreaCon()
        {
            $area = $this->input->get('area');
    
            $data = $this->model_Location->getLocationsByAreaMod($area);
            echo json_encode($data);
        }


        public function saveLocationCon()
        {
            $userSession = $this->session->userdata();
            date_default_timezone_set('Asia/Jakarta');

            $data = array(
                'area' => $this->input->post('area'),
                'line' => $this->input->post('line'),
                'number' => $this->input->post('number') !== null ? $this->input->post('number') : 0,
                'status' => 1,
                'createdBy' => isset($userSession['userId']) ? $userSession['userId'] : '',
                'createdDate' => date("Y-m-d H:i:s")
            );

            $insert = $this->model_Location->saveLocationMod($data);
            $this->session->set_flashdata('success', "Data berhasil disimpan!");
            redirect(base_url('./Location'));
        }

        public function updateLocationCon()
        {
            $userSession = $this->session->userdata();
            date_default_timezone_set('Asia/Jakarta');

            $data = array(
                'locationId' => $this->input->post('locationIdU'),
                'area' => $this->input->post('areaU'),
                'line' => $this->input->post('lineU'),
                'number' => $this->input->post('numberU') !== null ? $this->input->post('numberU') : 0,
                'status' => $this->input->post('statusU'),
                'modifiedBy' => isset($userSession['userId']) ? $userSession['userId'] : '',
                'modifiedDate' => date("Y-m-d H:i:s")
            );

            $this->model_Location->updateLocationMod($data);
            $this->session->set_flashdata('success', "Data berhasil diedit!");
            redirect(base_url('./Location'));
        }

        public function ExportExcelLocationCon()
        {
            $data = $this->model_Location->getAllLocationMod();

            if (empty($data)) {
                $this->session->set_flashdata('error', "Tidak ada data untuk di-export!");
                redirect(base_url('./Location'));
                return;
            }

            $spreadsheet = new PhpOffice\PhpSpreadsheet\Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();

            $table_columns = ['Id', 'Area', 'Line/Jalur/Lokasi', 'Nomor', 'Status'];
            $column = 0;
            foreach ($table_columns as $field) {
                $sheet->setCellValueByColumnAndRow($column + 1, 1, $field);

                $sheet->getStyle('A1:E1')->applyFromArray([
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
                $sheet->setCellValue('A' . $row, $d->locationId)
                    ->setCellValue('B' . $row, $d->area)
                    ->setCellValue('C' . $row, $d->line)
                    ->setCellValue('D' . $row, $d->number === 0 ? '' : $d->number)
                    ->setCellValue('E' . $row, $status);
                $row++;
            }

            ob_end_clean();

            date_default_timezone_set('Asia/Jakarta');
            $fileName = "DataLokasi_" . date('Y-m-d_H:i:s') . ".xlsx";

            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header("Content-Disposition: attachment;filename=\"$fileName\"");
            header('Cache-Control: max-age=0');

            $writer = new PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
            $writer->save('php://output');
            exit();
        }

        public function importExcelLocationCon()
        {
            $userSession = $this->session->userdata();
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

                        $locationIdsFromExcel = [];
                        foreach ($data as $key => $row) {
                            if ($key == 0) {
                                continue;
                            }
                            $locationIdsFromExcel[] = $row[0];
                        }

                        if ($mode == 'edit') {
                            $missingLocationIds = [];
                            foreach ($locationIdsFromExcel as $locationId) {
                                $existData = $this->model_Location->getLocationByIdMod($locationId);
                                if ($existData == null) {
                                    $missingLocationIds[] = $locationId;
                                }
                            }

                            if (!empty($missingLocationIds)) {
                                $this->session->set_flashdata('error', 'Id Lokasi berikut tidak ada di database: ' . implode(', ', $missingLocationIds));
                                redirect(base_url('./Location'));
                                return;
                            }

                            foreach ($data as $key => $row) {
                                if ($key == 0) {
                                    continue;
                                }

                                $tempData = array(
                                    'locationId'    => $row[0],
                                    'area'    => $row[1],
                                    'line'    => $row[2],
                                    'number' => ($row[1] === 'WIP') ? $row[3] : 0,
                                    'status'      => ($row[4] == "Aktif") ? 1 : 0,
                                    'modifiedBy'  => isset($userSession['userId']) ? $userSession['userId'] : '',
                                    'modifiedDate'=> date("Y-m-d H:i:s"),
                                );
                                $this->model_Location->updateLocationMod($tempData);
                            }
                        } else {
                            $existLocationIds = [];
                            foreach ($locationIdsFromExcel as $locationId) {
                                $existData = $this->model_Location->getLocationByIdMod($locationId);
                                if ($existData != null) {
                                    $existLocationIds[] = $locationId;
                                }
                            }
    
                            if (!empty($existLocationIds)) {
                                $this->session->set_flashdata('error', 'Id lokasi berikut sudah ada di database: ' . implode(', ', $existLocationIds));
                                redirect(base_url('./Location'));
                                return;
                            }
    
                            foreach ($data as $key => $row) {
                                if ($key == 0) {
                                    continue;
                                }
    
                                $tempData = array(
                                    'area'    => $row[1],
                                    'line'    => $row[2],
                                    'number' => ($row[1] === 'WIP') ? $row[3] : 0,
                                    'status'      => 1,
                                    'createdBy'  => isset($userSession['userId']) ? $userSession['userId'] : '',
                                    'createdDate'=> date("Y-m-d H:i:s"),
                                );
                                $this->model_Location->saveLocationMod($tempData);
                            }
                        }

                        $this->session->set_flashdata('success', 'Data berhasil diimport!');
                        unlink($filePath);
                        redirect(base_url('./Location'));
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