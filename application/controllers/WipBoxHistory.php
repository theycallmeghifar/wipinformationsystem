    <?php
    defined('BASEPATH') OR exit('No direct script access allowed');
    require 'vendor/autoload.php';
    use PhpOffice\PhpSpreadsheet\IOFactory;

    class WipBoxHistory extends CI_Controller {

        public function __construct()
        { 
            parent::__construct();
            $this->load->model("model_Box");
            $this->load->model("model_Item");
            $this->load->model("model_Location");
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
            $getData["getData"] = $this->model_WipBoxHistory->getAllTodaysWipBoxHistoryMod();
            $getData["item"] = $this->model_Item->getAllActiveItemMod();
            $getData["location"] = $this->model_Location->getAllLocationMod();
            $this->load->view('UI/WipBoxHistory', $getData);
        }

        public function getWipBoxHistoryByDateCon()
        {
            $startDate = $this->input->get('startDate');
            $endDate = $this->input->get('endDate');
    
            $data = $this->model_WipBoxHistory->getWipBoxHistoryByDateMod($startDate, $endDate);
            echo json_encode($data);
        }

        public function ExportExcelBoxCon()
        {
            $startDate = $this->input->post('startDate');
            $endDate = $this->input->post('endDate');
            $data = $this->model_WipBoxHistory->getWipBoxHistoryByDateMod($startDate, $endDate);

            if (empty($data)) {
                log_message('error', 'Tidak ada data ditemukan untuk di-export.');
                echo 'Tidak ada data untuk di-export.';
                return;
            }

            $spreadsheet = new PhpOffice\PhpSpreadsheet\Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();

            $table_columns = ['Item', 'Cavity', 'Jumlah', 'Lokasi Awal', 'Lokasi AKhir', 'Tanggal'];
            $column = 0;
            foreach ($table_columns as $field) {
                $sheet->setCellValueByColumnAndRow($column + 1, 1, $field);

                $sheet->getStyle('A1:F1')->applyFromArray([
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
                $sheet->setCellValue('A' . $row, $d->itemCode)
                    ->setCellValue('B' . $row, $d->cavity)
                    ->setCellValue('C' . $row, $d->quantity)
                    ->setCellValue('D' . $row, $d->initialLocationId)
                    ->setCellValue('E' . $row, $d->finalLocationId)
                    ->setCellValue('F' . $row, $d->createdDate);
                $row++;
            }

            ob_end_clean();

            date_default_timezone_set('Asia/Jakarta');
            $fileName = "DataWipBoxHistory_" . date('Y-m-d_H:i:s') . ".xlsx";

            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header("Content-Disposition: attachment;filename=\"$fileName\"");
            header('Cache-Control: max-age=0');

            $writer = new PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
            $writer->save('php://output');
            exit();
        }
    }
?>