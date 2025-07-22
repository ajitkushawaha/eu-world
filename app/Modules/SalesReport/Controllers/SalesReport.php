<?php

namespace Modules\SalesReport\Controllers;


use App\Modules\SalesReport\Models\SalesReportModel;
use App\Modules\Flight\Models\FlightBookingModel;
use App\Modules\Hotel\Models\HotelBookingModel;
use App\Modules\Holiday\Models\HolidayModel;
use App\Modules\Visa\Models\VisaModel;
use App\Modules\CarExtranet\Models\CarBookingModel;
use App\Modules\Bus\Models\BusBookingModel;
use App\Modules\Cruise\Models\CruiseBookingModel;
use App\Controllers\BaseController;
use Modules\SalesReport\Config\Validation;

require 'vendor/excel/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class SalesReport extends BaseController
{
    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        $this->title = "Sales Report";
        $this->web_partner_id = admin_cookie_data()['admin_user_details']['web_partner_id'];
        $this->web_partner_details = admin_cookie_data()['admin_user_details'];
        $this->user_id = admin_cookie_data()['admin_user_details']['id'];
    }

    public function index()
    {
        $service = $this->request->getGet('q');
        $html_view = "";
        $list = "";
        $pager = "";
        $getData = "";
        //if ($service == "Visa") {
            $VisaModel = new VisaModel();
            $getData = $this->request->getGET();
            if (isset($getData['key'])) {

                $list = $VisaModel->search_data_sales_report($this->web_partner_id,$getData, $page = 40);
            } else {
                $list = $VisaModel->data_sales_report($this->web_partner_id,$page = 40);
            }
            $pager = $VisaModel->pager;


            $booking_data = [
                "list" => $list,
                'html_view' => $html_view,
                "search_bar_data" => $getData,
                'pager' => $pager,

            ];
            $html_view = view("Modules\SalesReport\Views/visa-booking-list", $booking_data);
       // } 
        $data = [
            'title' => $this->title,
            'service' => $service,
            "list" => $list,
            'html_view' => $html_view,
            "search_bar_data" => $getData,
            'pager' => $pager,
            'view' => "SalesReport\Views\index",
        ];
        return view('template/sidebar-layout', $data);
    }

    public function get_report()
    {
        $data = $this->request->getPost();
        $rules = $this->validate([
            'service' => [
                'label' => 'service',
                'rules' => 'trim|required',
                'errors' => [
                    'required' => 'Please select service'
                ]
            ],
            'from_date' => [
                'label' => 'From Date',
                'rules' => 'trim|required',
                'errors' => [
                    'required' => 'Please select from date.'
                ]
            ],
            'to_date' => [
                'label' => 'To Date',
                'rules' => 'trim|required',
                'errors' => [
                    'required' => 'Please select to date.'
                ]
            ]
        ]);
        if (!$rules) {
            $errors = $this->validator->getErrors();
            $data_validation = array("StatusCode" => 1, "ErrorMessage" => array_filter($errors));
            return $this->response->setJSON($data_validation);
        } else {
            if($data['service'] == 'Cruise'){
                $data_validation = SalesReport::cruise_report($data['service'], $data);
                if ($data_validation) {
                    return $this->response->setJSON($data_validation);
                } else {
                    $data_validation = array("StatusCode" => 10, 'Message' => 'Service Not Available');
                    return $this->response->setJSON($data_validation);
                }
            } else {
                $data_validation = array("StatusCode" => 10, 'Message' => 'Service Not Available');
                return $this->response->setJSON($data_validation);
            }
        }
    }

    public function visa_report($service, $data)
    {
        $SalesReportModel = new SalesReportModel();
        $BookingDetail = $SalesReportModel->visa_booking_list_report($this->web_partner_id,$data);
        $fileName = $service . '-Sales-Report' . "." . 'xlsx';
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->getStyle("A1:AS1")->getFont()->setBold(true)->setName('Arial')->setSize(11);
        $sheet->getStyle("A:AS")->getFont()->setName('Arial')->setSize(11);
        $sheet->getColumnDimension('A')->setAutoSize(true);
        $sheet->getColumnDimension('B')->setAutoSize(true);
        $sheet->getColumnDimension('C')->setAutoSize(true);
        $sheet->getColumnDimension('D')->setAutoSize(true);
        $sheet->getColumnDimension('E')->setAutoSize(true);
        $sheet->getColumnDimension('F')->setAutoSize(true);
        $sheet->getColumnDimension('G')->setAutoSize(true);
        $sheet->getColumnDimension('H')->setAutoSize(true);
        $sheet->getColumnDimension('I')->setAutoSize(true);
        $sheet->getColumnDimension('J')->setAutoSize(true);
        $sheet->getColumnDimension('K')->setAutoSize(true);
        $sheet->getColumnDimension('L')->setAutoSize(true);
        $sheet->getColumnDimension('M')->setAutoSize(true);
        $sheet->getColumnDimension('N')->setAutoSize(true);
        $sheet->getColumnDimension('O')->setAutoSize(true);
        $sheet->getColumnDimension('P')->setAutoSize(true);
        $sheet->getColumnDimension('Q')->setAutoSize(true);
        $sheet->getColumnDimension('R')->setAutoSize(true);
        $sheet->getColumnDimension('S')->setAutoSize(true);
        $sheet->getColumnDimension('T')->setAutoSize(true);
        $sheet->getColumnDimension('U')->setAutoSize(true);
        $sheet->getColumnDimension('V')->setAutoSize(true);
        $sheet->getColumnDimension('W')->setAutoSize(true);
        $sheet->getColumnDimension('X')->setAutoSize(true);
        $sheet->getColumnDimension('Y')->setAutoSize(true);
        $sheet->getColumnDimension('Z')->setAutoSize(true);
        $sheet->getColumnDimension('AA')->setAutoSize(true);


        $sheet->setCellValue('A1', 'Invoice Date');
        $sheet->setCellValue('B1', 'Invoice');
        $sheet->setCellValue('C1', 'Company Name');
        $sheet->setCellValue('D1', 'Country');
        $sheet->setCellValue('E1', 'Visa Type');
        $sheet->setCellValue('F1', 'Booking Reference No');
        $sheet->setCellValue('G1', 'Lead Pax Name');

        $sheet->setCellValue('H1', 'Travel Date');
        $sheet->setCellValue('I1', 'Product');

        $sheet->setCellValue('J1', 'Basic Fare');
        $sheet->setCellValue('K1', 'Taxes');
        $sheet->setCellValue('L1', 'Ot. & Service Charge');


        $sheet->setCellValue('M1', 'Discount');
        $sheet->setCellValue('N1', 'TDS ');

        $sheet->setCellValue('O1', 'Management Fee');
        $sheet->setCellValue('P1', 'CGST');
        $sheet->setCellValue('Q1', 'SGST');
        $sheet->setCellValue('R1', 'IGST');
        $sheet->setCellValue('S1', 'GST');

        $sheet->setCellValue('T1', 'Net AMT.');



        $rows = 2;

        foreach ($BookingDetail as $key => $val) {


            $acc_ref_number = $val['acc_ref_number'];
            $invoice_number = $val['invoice_number'];
            $client_name = $val['company_name'];

            $fareBreakupArray = json_decode($val['web_partner_fare_break_up'], true);
            $booking_fareBreakupArray_gst = null;
            if (isset($fareBreakupArray['GST'])) {
                $booking_fareBreakupArray_gst = $fareBreakupArray['GST'];
            }


            $TaxableAmount = null;
            $CGSTAmount = null;
            $SGSTAmount = null;
            $IGSTAmount = null;
            $TotalGST = null;
            $AgentCommission = null;
            $Discount = null;
            $TDS = null;
            $OfferedPrice = null;
            $OtherCharges = null;
            $ServiceCharges = null;

            $FareBreakUp = array(
                "FareBreakup" => array(
                    "BasePrice" => array("Value" => $fareBreakupArray['BasePrice'], "LabelText" => "Base Price"),
                    "Taxes" => array("Value" => $fareBreakupArray['Tax'], "LabelText" => "Taxes"),
                    "ServiceAndOtherCharge" => array("Value" => $fareBreakupArray['ServiceCharges'], "LabelText" => "Other & Service Charges"),
                    /* "PublishedPrice" =>   array("Value" => $fareBreakupArray['PublishedPrice'], "LabelText" => "Published Price"), */

                    /*   "OfferedPrice" => array("Value" => $fareBreakupArray['OfferedPrice'], "LabelText" => "Offered Price"), */
                    /*"CommEarned" => array("Value" => $fareBreakupArray['AgentCommission'], "LabelText" => "Comm Earned (-)"),*/
                    "Discount" => array("Value" => $fareBreakupArray['Discount'], "LabelText" => "Discount (-)"),
                    "TDS" => array("Value" => $fareBreakupArray['TDS'], "LabelText" => "TDS (+)")
                ),
                "TotalAmount" => array("Value" => $fareBreakupArray['TDS'] + $fareBreakupArray['OfferedPrice'], "LabelText" => "Total Amount"),
                "GSTDetails" => $fareBreakupArray['GST']
            );

            if (isset($FareBreakUp['GSTDetails']['TaxableAmount'])) {
                $TaxableAmount = $FareBreakUp['GSTDetails']['TaxableAmount'];
            }

            if (isset($FareBreakUp['GSTDetails']['CGSTAmount'])) {
                $CGSTAmount = $FareBreakUp['GSTDetails']['CGSTAmount'];
            }

            if (isset($FareBreakUp['GSTDetails']['SGSTAmount'])) {
                $SGSTAmount = $FareBreakUp['GSTDetails']['SGSTAmount'];
            }
            if (isset($FareBreakUp['GSTDetails']['IGSTAmount'])) {
                $IGSTAmount = $FareBreakUp['GSTDetails']['IGSTAmount'];
            }
            $lead_pax_ticket_number = null;

            $lead_pax_name = ucfirst($val['title']) . ' ' . ucfirst($val['first_name']) . ' ' . ucfirst($val['last_name']);;
            $GST = $CGSTAmount + $SGSTAmount + $IGSTAmount;

            $sheet->setCellValue('A' . $rows, date_created_format($val['created']));
            $sheet->setCellValue('B' . $rows, $invoice_number);
            $sheet->setCellValue('C' . $rows, $client_name);
            $sheet->setCellValue('D' . $rows, $val['visa_country']);
            $sheet->setCellValue('E' . $rows, $val['visa_type']);
            $sheet->setCellValue('F' . $rows, $val['booking_ref_number']);
            $sheet->setCellValue('G' . $rows, $lead_pax_name);
            $sheet->setCellValue('H' . $rows, $val['date_of_journey']);
            $sheet->setCellValue('I' . $rows, 'Visa');


            $sheet->setCellValue('J' . $rows, $FareBreakUp['FareBreakup']['BasePrice']['Value']);
            $sheet->setCellValue('K' . $rows, $FareBreakUp['FareBreakup']['Taxes']['Value']);
            $sheet->setCellValue('L' . $rows, $FareBreakUp['FareBreakup']['ServiceAndOtherCharge']['Value']);


            $sheet->setCellValue('M' . $rows, $FareBreakUp['FareBreakup']['Discount']['Value']);
            $sheet->setCellValue('N' . $rows, $FareBreakUp['FareBreakup']['TDS']['Value']);


            $sheet->setCellValue('O' . $rows, $TaxableAmount);
            $sheet->setCellValue('P' . $rows, $CGSTAmount);
            $sheet->setCellValue('Q' . $rows, $SGSTAmount);
            $sheet->setCellValue('R' . $rows, $IGSTAmount);
            $sheet->setCellValue('S' . $rows, $GST);
            $sheet->setCellValue('T' . $rows, $FareBreakUp['TotalAmount']['Value']);


            $rows++;

        }

        ob_start();
        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        $xlsData = ob_get_contents();
        ob_end_clean();
        $data_validation = array("StatusCode" => 5, 'file' => "data:application/vnd.openxmlformats-officedocument.spreadsheetml.sheet;base64," . base64_encode($xlsData), 'filename' => $fileName);
        return $data_validation;

    }

}
