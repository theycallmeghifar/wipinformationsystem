    <?php
    defined('BASEPATH') OR exit('No direct script access allowed');
    require 'vendor/autoload.php';
    use PhpOffice\PhpSpreadsheet\IOFactory;

    class Lokasi extends CI_Controller {

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
            $getData["getData"] = $this->model_Location->getMachiningLocationMod();
            $this->load->view('UI/Lokasi', $getData);
        }

        public function saveLocationCon()
        {
            $userSession = $this->session->userdata();
            date_default_timezone_set('Asia/Jakarta');

            $data = array(
                'location' => "Machining",
                'line' => $this->input->post('line'),
                'status' => 1,
                'createdBy' => isset($userSession['username']) ? $userSession['username'] : '',
                'createdDate' => date("Y-m-d H:i:s")
            );

            $insert = $this->model_Location->saveLocationMod($data);
            $this->session->set_flashdata('success', "Data berhasil disimpan!");
            redirect(base_url('./Lokasi'));
        }

        public function updateLocationCon()
        {
            $userSession = $this->session->userdata();
            date_default_timezone_set('Asia/Jakarta');

            $data = array(
                'locationId' => $this->input->post('locationIdU'),
                'line' => $this->input->post('lineU'),
                'status' => $this->input->post('statusU'),
                'modifiedBy' => isset($userSession['username']) ? $userSession['username'] : '',
                'modifiedDate' => date("Y-m-d H:i:s")
            );

            $this->model_Location->updateLocationMod($data);
            $this->session->set_flashdata('success', "Data berhasil diedit!");
            redirect(base_url('./Lokasi'));
        }

        public function ExportExcelLocationCon()
        {
            $data = $this->model_Location->getMachiningLocationMod();

            if (empty($data)) {
                $this->session->set_flashdata('error', "Tidak ada data untuk di-export!");
                redirect(base_url('./Lokasi'));
                return;
            }

            // Buat objek spreadsheet
            $spreadsheet = new PhpOffice\PhpSpreadsheet\Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();

            // Set header kolom
            $table_columns = ['Id', 'Lokasi', 'Line', 'Status'];
            $column = 0;
            foreach ($table_columns as $field) {
                $sheet->setCellValueByColumnAndRow($column + 1, 1, $field);

                // Styling header kolom
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

            // Masukkan data ke dalam sheet
            $row = 2; // Mulai dari baris ke-2 untuk data
            foreach ($data as $d) {
                $status = ($d->status == 0) ? "Tidak Aktif" : "Aktif";
                $sheet->setCellValue('A' . $row, $d->locationId)
                    ->setCellValue('B' . $row, $d->location)
                    ->setCellValue('C' . $row, $d->line)
                    ->setCellValue('D' . $row, $status);
                $row++;
            }

            // Bersihkan output buffer sebelumnya (jika ada)
            ob_end_clean();

            // Set nama file
            date_default_timezone_set('Asia/Jakarta');
            $fileName = "DataLokasi_" . date('Y-m-d_H:i:s') . ".xlsx";

            // Set header HTTP untuk download file Excel
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header("Content-Disposition: attachment;filename=\"$fileName\"");
            header('Cache-Control: max-age=0');

            // Buat writer dan simpan ke output
            $writer = new PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
            $writer->save('php://output');
            exit();
        }

        public function importExcelLocationCon()
        {
            date_default_timezone_set('Asia/Jakarta');
            if (isset($_FILES['file'])) {
                $uploadDir = 'uploads/';
                $fileName = basename($_FILES['file']['name']);
                $filePath = $uploadDir . $fileName;

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

                        $missingLocationIds = [];
                        foreach ($locationIdsFromExcel as $locationId) {
                            $existData = $this->model_Location->getLocationByIdMod($locationId);
                            if ($existData == null) {
                                $missingLocationIds[] = $locationId;
                            }
                        }

                        if (!empty($missingLocationIds)) {
                            $this->session->set_flashdata('error', 'Line id berikut tidak ada di database: ' . implode(', ', $missingLocationIds));
                            redirect(base_url('./Lokasi'));
                            return;
                        }

                        foreach ($data as $key => $row) {
                            if ($key == 0) {
                                continue;
                            }

                            $tempData = array(
                                'locationId'    => $row[0],
                                'line'    => $row[2],
                                'status'      => ($row[3] == "Aktif") ? 1 : 0,
                                'modifiedBy'  => isset($userSession['username']) ? $userSession['username'] : '',
                                'modifiedDate'=> date("Y-m-d H:i:s"),
                            );
                            $this->model_Location->updateLocationMod($tempData);
                        }

                        $this->session->set_flashdata('success', 'Data imported successfully!');
                        unlink($filePath);
                        redirect(base_url('./Lokasi'));
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