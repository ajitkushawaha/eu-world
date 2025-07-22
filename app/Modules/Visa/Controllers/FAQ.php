<?php

namespace Modules\Visa\Controllers;

use App\Modules\Visa\Models\FAQModel;
use App\Controllers\BaseController;
use Modules\Visa\Config\Validation;

class FAQ extends BaseController
{

    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        $this->title = "FAQ";
        $this->web_partner_id = admin_cookie_data()['admin_user_details']['web_partner_id'];
        $this->web_partner_details = admin_cookie_data()['admin_user_details'];
        $this->user_id = admin_cookie_data()['admin_user_details']['id'];
    }

    public function index(): string
    {
        $visa_detail_id = dev_decode($this->request->uri->getSegment(3));
        $FAQModel = new FAQModel();
        if ($this->request->getGet() && $this->request->getGet('key')) {
            $lists = $FAQModel->search_data($this->request->getGet(), $this->web_partner_id, $visa_detail_id);
        } else {
            $lists = $FAQModel->faq_list($this->web_partner_id, $visa_detail_id);
        }
        $data = [
            'title' => $this->title,
            'list' => $lists,
            'visa_detail_id'=>$visa_detail_id,
            'view' => "Visa\Views\FAQ\Faq-list",
            'pager' => $FAQModel->pager,
            'search_bar_data' => $this->request->getGet(),
        ];
        return view('template/sidebar-layout', $data);
    }

    public function remove_faq_List()
    {
        $FAQModel = new FAQModel();
        $ids = $this->request->getPost('checklist');
        foreach ($ids as $id) {
            $delete = $FAQModel->remove_faq_list($id, $this->web_partner_id);
        }
        if ($delete) {
            $message = array("StatusCode" => 0, "Message" => "FAQ successfully  deleted", "Class" => "success_popup", "Reload" => "true");
        } else {
            $message = array("StatusCode" => 2, "Message" => "FAQ not deleted", "Class" => "error_popup", "Reload" => "true");
        }
        $this->session->setFlashdata('Message', $message);
        return $this->response->setJSON($message);
    }


    public function faq_status_change()
    {
        $validate = new Validation();
        $rules = $this->validate($validate->status);
        if (!$rules) {
            $errors = $this->validator->getErrors();
            $data_validation = array("StatusCode" => 1, "ErrorMessage" => array_filter($errors));
            return $this->response->setJSON($data_validation);
        } else {
            $FAQModel = new FAQModel();
            $ids = $this->request->getPost('checkedvalue');
            $data['status'] = $this->request->getPost('status');
            $update = $FAQModel->status_change($ids, $this->web_partner_id, $data);
            if ($update) {
                $message = array("StatusCode" => 0, "Message" => "FAQ status  successfully changed", "Class" => "success_popup", "Reload" => "true");
            } else {
                $message = array("StatusCode" => 2, "Message" => "FAQ status not changed successfully", "Class" => "error_popup", "Reload" => "true");
            }
            $this->session->setFlashdata('Message', $message);
            return $this->response->setJSON($message);
        }
    }




    public function faqListView()
    {
        $FAQModel = new FAQModel();
        $uri = $this->request->getUri();
        $visa_detail_id =  dev_decode($uri->getSegment(3));
        $country = $FAQModel->visa_country_list($this->web_partner_id);
        $data = [
            'title' => $this->title,
            'country' => $country,
            'visa_detail_id' => $visa_detail_id,
            'view' => "Visa\Views\FAQ\add-faq",
        ];
        return view('template/sidebar-layout', $data);
    }

    public function add_faq_Saved()
    {

        $validate = new Validation();
        $rules = $this->validate($validate->faq_validation);
        if (!$rules) {
            $errors = $this->validator->getErrors();
            $data_validation = array("StatusCode" => 1, "ErrorMessage" => array_filter($errors));
            return $this->response->setJSON($data_validation);
        } else {
            $uri = $this->request->getUri();
            $visa_detail_id =  dev_decode($uri->getSegment(3));
            $FAQModel = new FAQModel();
            $postData = $this->request->getPost();
            $QUESTION = $postData['faq_question'];
            $answer = $postData['faq_answer'];
            $faq = [];
            for ($i = 0; $i < count($QUESTION); $i++) {
                $faq[] = array(
                    'question' => $QUESTION[$i],
                    'answer' => $answer[$i]
                );
            }
            $postData['created'] = create_date();
            $postData['visa_detail_id'] = $visa_detail_id;
            $postData['faq_question_answer'] = json_encode($faq);
            unset($postData['faq_question']);
            unset($postData['faq_answer']);
            $postData['web_partner_id'] = $this->web_partner_id;
            
            $added_data = $FAQModel->insert($postData);
            if ($added_data) {
                $message = array("StatusCode" => 0, "Message" => "FAQ successfully add", "Class" => "success_popup", "Reload" => "true");
            } else {
                $message = array("StatusCode" => 2, "Message" => "FAQ not  add", "Class" => "error_popup", "Reload" => "true");
            }
            $this->session->setFlashdata('Message', $message);
            $response_data = ["StatusCode" => 0, "Message" => "Data inserted successfully"];
            return $this->response->setJSON($response_data);
        }
    }

    public function edit_faq_view()
    {

        $id = dev_decode($this->request->uri->getSegment(3));
        $FAQModel = new FAQModel();
        $country = $FAQModel->visa_country_list($this->web_partner_id);
        $data = [
            'title' => $this->title,
            'id' => $id,
            'country' => $country,
            'details' => $FAQModel->faq_list_details($id, $this->web_partner_id),
            'view' => "Visa\Views/FAQ/edit-faq",
        ];
        return view('template/sidebar-layout', $data);
    }

    public function edit_faq_Seved()
    {
        $id = dev_decode($this->request->uri->getSegment(3));
        $validate = new Validation();
        $postData = $this->request->getPost();
        $rules = $this->validate($validate->faq_validation);
        if (!$rules) {
            $errors = $this->validator->getErrors();
            $data_validation = array("StatusCode" => 1, "ErrorMessage" => array_filter($errors));
            return $this->response->setJSON($data_validation);
        } else {
            $FAQModel = new FAQModel();
            $postData = $this->request->getPost();
            $QUESTION = $postData['faq_question'];
            $answer = $postData['faq_answer'];
            $faq = [];
            for ($i = 0; $i < count($QUESTION); $i++) {
                $faq[] = array(
                    'question' => $QUESTION[$i],
                    'answer' => $answer[$i]
                );
            }
            $postData['faq_question_answer'] = json_encode($faq);
            unset($postData['faq_question']);
            unset($postData['faq_answer']);
            $postData['modified'] = create_date();
            $added_data = $FAQModel->where("id", $id)->set($postData)->update();
            if ($added_data) {
                $message = array("StatusCode" => 0, "Message" => "FAQ successfully updated", "Class" => "success_popup", "Reload" => "true");
            } else {
                $message = array("StatusCode" => 2, "Message" => "FAQ not  updated", "Class" => "error_popup", "Reload" => "true");
            }
            $this->session->setFlashdata('Message', $message);
            return $this->response->setJSON($message);
        }
    }
}
