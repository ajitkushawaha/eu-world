<?php

namespace Modules\Visa\Controllers;
 
use App\Controllers\BaseController;
use Modules\Visa\Config\VisaUploadValidation;
use App\Modules\Visa\Models\DocumentTypeModel;
use App\Modules\Visa\Models\VisaTypeModel; 
use App\Modules\Visa\Models\UploadTicketTempDataModel; 
use App\Modules\Visa\Models\VisaUploadModel; 

require 'vendor/excel/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class VisaUpload extends BaseController
{
    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        helper('Modules\Visa\Helpers\visa');
        $this->web_partner_id = admin_cookie_data()['admin_user_details']['web_partner_id'];
        $this->web_partner_details = admin_cookie_data()['admin_user_details'];

        $this->user_id = admin_cookie_data()['admin_user_details']['id'];
        $this->title = "Visa Upload";
        $this->folder_name = 'visa_documents';
       // $this->Services = API_REQUEST_URL . '/visaservice/rest/';


        if(permission_access_error("Visa","Visa_Module")) {

        }
    }

    public function index()
    {  
        $DocumentTypeModel = new DocumentTypeModel();
        $documentTypeArray = $DocumentTypeModel->document_details_list($this->web_partner_id);
        $VisaTypeModel = new VisaTypeModel();
        $VisaTypes = $VisaTypeModel->visa_type($this->web_partner_id);
        $VisaUploadModel = new VisaUploadModel();
        $offline_supplier=$VisaUploadModel->get_offline_supplier($this->web_partner_id); 

        $UploadTicketTempDataModel = new UploadTicketTempDataModel();

        if (isset($_GET['visainfokey']) && $_GET['visainfokey'] != "") {
            $input = $this->request->getGET(); 
            $visaInfoData = $UploadTicketTempDataModel->getData('upload_ticket_temp', ["id" => $input['visainfokey'], 'service' => "Visa", "web_partner_id" => $this->web_partner_id], $singalRecord = 1, $whereApply = 1);
            
            $getVisaInfo =  json_decode($visaInfoData['data'], true);
            unset($visaInfoData['data']);
            $VisaInfoId = $_GET['visainfokey'];
            
        }
      
        $data = [
            'title' => $this->title, 
            'document_type' => $documentTypeArray, 
            'VisaTypes' => $VisaTypes, 
            'offline_supplier'=>$offline_supplier,
            'getVisaInfo' => isset($getVisaInfo) ? $getVisaInfo : "",
            'VisaInfoId' => isset($VisaInfoId) ? $VisaInfoId : "", 
            'view' => "Visa\Views\Visa-upload\index" 
        ];

        return view('template/sidebar-layout', $data);
    }

    public function visa_upload_data_store()
    {  
        $data = $this->request->getPost(); 
       
        $validate = new VisaUploadValidation();
        
        if($data['bussiness_type']== "B2C"){
            unset($validate->visa_upload_validation['agent_info']);
        }
        if($data['bussiness_type']== "B2B"){
            unset($validate->visa_upload_validation['customer_info']);
        }
        $rules = $this->validate($validate->visa_upload_validation);
        if (!$rules) {
            $errors = $this->validator->getErrors();
            $data_validation = array("StatusCode" => 1, "ErrorMessage" => array_filter($errors));
            return $this->response->setJSON($data_validation);
        } else {
            $UploadTicketTempDataModel = new UploadTicketTempDataModel(); 
            
        } 
        if(!isset($data['visainfokey'])) {
            $insertData = array(
                'web_partner_id' => $this->web_partner_id,
                'service' => 'Visa',
                'data' => json_encode($data),
                'created' => create_date()
            );   
            $lastInsertedId = $UploadTicketTempDataModel->insertData("upload_ticket_temp", $insertData);
        } else {
            $lastInsertedId = $data['visainfokey']; 
            $updateData = array(
                'web_partner_id' => $this->web_partner_id,
                'service' => 'Visa',
                'data' => json_encode($data),
                'created' => create_date()
            ); 

            $UploadTicketTempDataModel->updateData("upload_ticket_temp", ["id" => $data['visainfokey']], $updateData);
      

        }
        $RedirectUrl  =  site_url('visa-upload/visa-passenger-detail?visainfokey='.$lastInsertedId);
        $data_validation = array("StatusCode" => 3, "ErrorMessage" => '',"Redirect_Url"=>$RedirectUrl);
        return $this->response->setJSON($data_validation); 

    }


    public function visa_passenger_detail()
    { 
        if(isset($_GET['visainfokey']) && $_GET['visainfokey']!="")
        {
            $UploadTicketTempDataModel = new UploadTicketTempDataModel(); 
            $input  =  $this->request->getGET();
            $visaInfoData = $UploadTicketTempDataModel->getData('upload_ticket_temp', ["id" => $input['visainfokey'], 'service' => "Visa", "web_partner_id" => $this->web_partner_id], $singalRecord = 1, $whereApply = 1);
            if($visaInfoData)
            {
                $getVisaInfo =  json_decode($visaInfoData['data'], true); 
                 unset($visaInfoData['data']);
                 $data = [
                     "title"=> "Passenger Detail",
                     "visainfokey" => $input['visainfokey'],
                     "getVisaInfo" => $getVisaInfo,
                     'passengerCounter' => 1,
                     'view' => "Visa\Views\Visa-upload/visa-passenger-details" 
                 ];
                 return view('template/sidebar-layout', $data);
            }else{
                $message = ["StatusCode" => 2, "Message" => "Record not found", "Class" => "error_popup"]; 
                $this->session->setFlashdata('Message', $message); 
                return redirect()->to(site_url('visa-upload'));
            } 
        }else{
            $message = ["StatusCode" => 2, "Message" => "Record not found", "Class" => "error_popup"]; 
            $this->session->setFlashdata('Message', $message); 
            return redirect()->to(site_url('visa-upload'));
        }
    }


    public function passenger_details()
    {
        $passengerCounter = $this->request->getPost('passenger_counter') + 1; 
        $visainfokey = $this->request->getPost('visainfokey'); 

        $Visapassenger['passengerCounter'] = $passengerCounter;  
        $UploadTicketTempDataModel = new UploadTicketTempDataModel();  
        $visaInfoData = $UploadTicketTempDataModel->getData('upload_ticket_temp', ["id" => $visainfokey, 'service' => "Visa", "web_partner_id" => $this->web_partner_id], $singalRecord = 1, $whereApply = 1);

        if ($visaInfoData) {
            $Visapassenger['VisaJsonData'] = json_decode($visaInfoData['data'], true); 
            $Visapassenger['document'] = isset($Visapassenger['VisaJsonData']['document']) ? $Visapassenger['VisaJsonData']['document'] : null; 
        } 
        
        $passengerView = view("Modules\Visa\Views\Visa-upload\add-more-passenger-details", $Visapassenger); 
        $data = [
			"passengerCounter" => $passengerCounter,
			"passengerView" => $passengerView,  
		];
        return $this->response->setJSON($data);
    }
 

    public function validate_travellers()
    {
        $data = $this->request->getPost(); 
        $files = $this->request->getFiles();  
        if($data)
        {
            foreach($data['pax_details'] as $key=>$item)
            {
                if(isset($item['document']) && !empty($item['document']))
                {
                    foreach($item['document'] as $dockey=>$doc)
                    {
                        if($files['pax_details'][$key][$dockey])
                        {
                            $data['pax_details'][$key]['document'][$dockey] = $files['pax_details'][$key][$dockey]->getName();
                        }
                    }
                }
            }
        }  
        $validate = new VisaUploadValidation();
        $validationConfigArray = $validate->pax_validation($data); 
        $this->validation->setRules($validationConfigArray);
        $rules = $this->validation->run($data);
        if (!$rules) {
            $errors = $this->validation->getErrors();
            $data_validation = array("StatusCode" => 1, "ErrorMessage" => array_filter($errors));
            return $this->response->setJSON($data_validation);
        } else {  
            $visainfoid = $data['visainfokey'];  
            if($visainfoid)
            {
                $UploadTicketTempDataModel = new UploadTicketTempDataModel();  
                $visaInfoData = $UploadTicketTempDataModel->getData('upload_ticket_temp', ["id" => $visainfoid, 'service' => "Visa", "web_partner_id" => $this->web_partner_id], $singalRecord = 1, $whereApply = 1);
                if($visaInfoData)
                {
                    $Visapassenger = json_decode($visaInfoData['data'], true);
                    $Visapassenger['dial_code'] = $data['dial_code'];
                    $Visapassenger['mobile_number'] = $data['mobile_number'];
                    $Visapassenger['email'] = $data['email'];
                    foreach($data['pax_details'] as $key=>$document){ 
                        $AllData[] = $document;
                        $documentArray = array();
                        $imagename = "";
                        $Visapassenger['pax_details'][$key] = $document;
                        foreach ($document['document'] as $key2 => $value) { 
                            $pan_card_file = $this->request->getFile("pax_details.$key.$key2");
                            $resizeDim = array('width' => 360, 'height' => 200);
                            $documentArray = image_upload($pan_card_file, "pax_details.$key.$key2", $this->folder_name, $resizeDim);
        
                            if($documentArray['status_code'] == 0){
                                $imagename = $documentArray['file_name'];
                            }
                        $Visapassenger['pax_details'][$key]['document'][$key2] =  $imagename;
                        } 
                    }  
                    $insertData  =  array(
                        "web_partner_id" => $this->web_partner_id, 
                        "data" =>  json_encode($Visapassenger), 
                        'service' => 'Visa',
                        "created" => create_date(),
                    );
                
                    $UploadTicketTempDataModel->updateData("upload_ticket_temp", ["id" => $visainfoid], $insertData);  
                    $RedirectUrl  =  site_url('visa-upload/visa-review-detail?visainfokey='.$visainfoid);
                    $data_validation = array("StatusCode" => 3, "ErrorMessage" => '',"Redirect_Url"=>$RedirectUrl);
                    return $this->response->setJSON($data_validation); 
        
                }else{
                    $message = ["StatusCode" => 2, "Message" => "Record not found", "Class" => "error_popup"]; 
                    $this->session->setFlashdata('Message', $message); 
                    return redirect()->to(site_url('visa-upload'));
                } 
            }else{
                $RedirectUrl  =  site_url('visa-upload');
                $data_validation = array("StatusCode" => 3, "ErrorMessage" => '',"Redirect_Url"=>$RedirectUrl);
                return $this->response->setJSON($data_validation); 
            }
            
        }
    }


    public function visa_review_detail()
    {
        if (isset($_GET['visainfokey']) && !empty($_GET['visainfokey']) && $_GET['visainfokey'] != "")
        {
            $input = $this->request->getGET(); 
            $UploadTicketTempDataModel = new UploadTicketTempDataModel();  
            $visaInfoData = $UploadTicketTempDataModel->getData('upload_ticket_temp', ["id" => $input['visainfokey'], 'service' => "Visa", "web_partner_id" => $this->web_partner_id], $singalRecord = 1, $whereApply = 1);
          
            if(!empty($visaInfoData))
            {
                $getTicketData = json_decode($visaInfoData['data'],true);
                $getTicketData['supplier'] = explode("#", $getTicketData['supplier'])[1]; 
                $visaInfo = array(); 
                $WebPartnerInfo = $UploadTicketTempDataModel->getData('web_partner', array("id" => $this->web_partner_id), $singalRecord = 1, $whereApply  =  1, 'company_name,company_id,gst_state_code');
              
                $agentInfo = array();
                $customerInfo = array();
                $tableName = "";
                $user_id = 0;
                $gst_info = array();
                if($getTicketData['bussiness_type'] == "B2B")
                {
                    $tableName = "agent";
                    $user_id = $getTicketData['tts_agent_info_id']; 
                    $AgentInfo = $UploadTicketTempDataModel->getData('agent', array("id" => $user_id), $singalRecord = 1, $whereApply  =  1, 'company_name,web_partner_id,gst_number');     
                    $gst_info = (!empty($agentInfo['gst_number'])) ? substr($agentInfo['gst_number'], 0, 2) : 0;
                }else{
                    $tableName = "customer";
                    $user_id = $getTicketData['tts_customer_info_id']; 
                    $CustomerInfo = $UploadTicketTempDataModel->getData('customer', array("id" => $user_id), $singalRecord = 1, $whereApply  =  1, 'email_id,web_partner_id,gst_number');
                    $gst_info = (!empty($customerInfo['gst_number'])) ? substr($customerInfo['gst_number'], 0, 2) : 0;
                }
                $visaInfo['AgentInfo'] = $AgentInfo;
               
                $visaInfo['CustomerInfo'] = $customerInfo;
              
                $data = [
                    'title' => $this->title,
                    'visainfokey' => $_GET['visainfokey'],
                    'visaInfo' => $visaInfo,
                    'getTicketData' => $getTicketData,
                    'view' => "Visa\Views\Visa-upload/visa-review-detail" ,
                    
                ];
                return view('template/sidebar-layout', $data);
            }else{
                $message = ["StatusCode" => 2, "Message" => "Record not found", "Class" => "error_popup"];
                $this->session->setFlashdata('Message', $message);
                $RedirectUrl = site_url('visa-upload/visa-passenger-detail?visainfokey=' . $input['visainfokey']);
                return redirect()->to($RedirectUrl);
            }
        }else{
            $message = ["StatusCode" => 2, "Message" => "Record not found", "Class" => "error_popup"];
            $this->session->setFlashdata('Message', $message);
            $RedirectUrl = site_url('visa-upload/visa-passenger-detail?visainfokey=' . $input['visainfokey']);
            return redirect()->to($RedirectUrl);
        }
    }

   

}
