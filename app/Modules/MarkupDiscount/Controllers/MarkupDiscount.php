<?php
namespace Modules\MarkupDiscount\Controllers;
use App\Modules\MarkupDiscount\Models\FlightAirportModel;
use App\Modules\MarkupDiscount\Models\FlightAirlineModel;
use App\Modules\MarkupDiscount\Models\VisaMarkupModel;
use App\Modules\MarkupDiscount\Models\VisaDiscountModel;
use App\Modules\Visa\Models\VisaCountryModel;
use App\Modules\Visa\Models\VisaListModel;
use App\Modules\MarkupDiscount\Models\AgentClassModel;
use App\Controllers\BaseController;
use Modules\MarkupDiscount\Config\Validation;

class MarkupDiscount extends BaseController
{

    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        $this->title = "Admin";
        $this->web_partner_id = admin_cookie_data()['admin_user_details']['web_partner_id'];
    }



    public function get_airports()
    {

        $terms = $this->request->getGet('term');
        $terms = explode(',', $terms);
        $terms = end($terms);

        $FlightAirportModel = new FlightAirportModel();

        $get_airport = $FlightAirportModel->get_airport_autosuggestion($terms);
        $availableAirport = [];
        if (!empty($get_airport)) {
            foreach ($get_airport as $data) {
                $availableAirport[] = ['city' => $data['city_name'], 'airport_code' => $data['code'], 'label' => $data['city_name'] . ' (' . $data['code'] . '), ' . ucfirst(strtolower($data['country_name'])) . '', 'airport_name' => $data['name'], 'country_code' => $data['country_code'], 'country_name' => ucfirst(strtolower($data['country_name']))];
            }
        }
        echo json_encode($availableAirport);
    }

    public function get_airline()
    {
        $terms = $this->request->getGet('term');
        $FlightAirlineModel = new FlightAirlineModel();

        $get_airport = $FlightAirlineModel->get_airline_autosuggestion($terms);
        $availableAirline = [];
        $availableAirline[] = 'ANY' . '-' . 'Any Airline';
        if (!empty($get_airport)) {
            foreach ($get_airport as $data) {
                $availableAirline[] = $data['airline_code'] . '-' . $data['airline_name'];
            }
        }

        echo json_encode($availableAirline);
    }




    public function visa_markup_list()
    {
        if (permission_access_error("Visa", "visa_markup_list")) {
            $VisaMarkupModel = new VisaMarkupModel();

            if ($this->request->getGet() && $this->request->getGet('key')) {
                $lists = $VisaMarkupModel->search_data($this->request->getGet());
            } else {
                $lists = $VisaMarkupModel->visa_markup_list();
            }
            $AgentClassModel = new AgentClassModel();
            $agent_class_list = $AgentClassModel->agent_class_list($this->web_partner_id);
            $agent_class_list = array_column($agent_class_list, 'class_name', 'id');


            $visa_type_list = $VisaMarkupModel->visa_type_list();
            $visa_type_list = array_column($visa_type_list, 'visa_title', 'id');

            $data = [
                'title' => $this->title,
                'list' => $lists,
                'agent_class_list'=>$agent_class_list,
                'visa_type_list'=>$visa_type_list,
                'view' => "MarkupDiscount\Views\visa-markup-list",
                'pager' => $VisaMarkupModel->pager,
                'search_bar_data' => $this->request->getGet(),
            ];

            return view('template/sidebar-layout', $data);
        }

    }

    public function visa_markup_view()
    {
        if (permission_access_error("Visa", "add_visa_markup")) {
            $VisaCountryModel = new VisaCountryModel();
            $VisaMarkupModel = new VisaMarkupModel();
            $data = [
                'title' => $this->title,
                'country' => $VisaCountryModel->get_country_code(),
                'agent_class_list' => $VisaMarkupModel->agent_class_list($this->web_partner_id)
            ];
            $add_blog_view = view('Modules\MarkupDiscount\Views\add-visa-markup', $data);
            $data = array("StatusCode" => 0, "Message" => $add_blog_view, 'class' => 'success_popup', "Reload" => "false");
            return $this->response->setJSON($data);
        }
    }

    public function add_visa_markup()
    {
        if (permission_access_error("Visa", "add_visa_markup")) {
            $validate = new Validation();
            $rules = $this->validate($validate->visa_markup_validation);
            if (!$rules) {
                $errors = $this->validator->getErrors();
                $data_validation = array("StatusCode" => 1, "ErrorMessage" => array_filter($errors));
                return $this->response->setJSON($data_validation);
            } else {
                $VisaMarkupModel = new VisaMarkupModel();
                $data = $this->request->getPost();
                $data['created'] = create_date();
                $data['agent_class_list_id'] = implode(',', $data['agent_class_list_id']);
                $data['visa_type_id'] = implode(',', $data['visa_type_id']);
                $added_data = $VisaMarkupModel->insert($data);

                if ($added_data) {
                    $message = array("StatusCode" => 0, "Message" => "Visa Markup Successfully Added", "Class" => "success_popup");
                } else {
                    $message = array("StatusCode" => 2, "Message" => "Visa Markup not  Added", "Class" => "error_popup");
                }

                $this->session->setFlashdata('Message', $message);
                return $this->response->setJSON($message);
            }
        }

    }

    public function visa_markup_status_change()
    {
        if (permission_access_error("Visa", "visa_markup_status")) {
            $validate = new Validation();
            $rules = $this->validate($validate->status);
            if (!$rules) {
                $errors = $this->validator->getErrors();
                $data_validation = array("StatusCode" => 1, "ErrorMessage" => array_filter($errors));
                return $this->response->setJSON($data_validation);
            } else {
                $VisaMarkupModel = new VisaMarkupModel();
                $ids = $this->request->getPost('checkedvalue');

                $data['status'] = $this->request->getPost('status');

                $update = $VisaMarkupModel->status_change($ids, $data);

                if ($update) {
                    $message = array("StatusCode" => 0, "Message" => "Visa Markup status  successfully changed", "Class" => "success_popup", "Reload" => "true");
                } else {
                    $message = array("StatusCode" => 2, "Message" => "Visa Markup status not changed successfully", "Class" => "error_popup", "Reload" => "true");
                }
                $this->session->setFlashdata('Message', $message);
                return $this->response->setJSON($message);
            }
        }
    }


    public function edit_admin_visa_markup_template()
    {
        if (permission_access_error("Visa", "edit_visa_markup")) {
            $id = dev_decode($this->request->uri->getSegment(3));

            $VisaCountryModel = new VisaCountryModel();

            $country = $VisaCountryModel->get_country_code();
            $VisaMarkupModel = new VisaMarkupModel();
            $details = $VisaMarkupModel->visa_markup_details($id);

            $VisaListModel = new VisaListModel();
            $country_id = $details['visa_country_id'];
            $visa_list = $VisaListModel->visa_list_page_select($country_id);
            $details['agent_class_list_id'] = explode(',', $details['agent_class_list_id']);
            $details['visa_type_id'] = explode(',', $details['visa_type_id']);
            $data = [
                'title' => $this->title,
                'id' => $id,
                'details' => $details,
                'country' => $country,
                'visa_list' => $visa_list,
                'agent_class_list' => $VisaMarkupModel->agent_class_list($this->web_partner_id)

            ];

            $details = view('Modules\MarkupDiscount\Views\edit-visa-markup', $data);
            $data = array("StatusCode" => 0, "Message" => $details, 'class' => 'success_popup', "Reload" => "false");
            return $this->response->setJSON($data);
        }

    }

    public function edit_admin_visa_markup()
    {
        if (permission_access_error("Visa", "edit_visa_markup")) {
            $id = dev_decode($this->request->uri->getSegment(3));
            $validate = new Validation();
            $rules = $this->validate($validate->visa_markup_validation);
            if (!$rules) {
                $errors = $this->validator->getErrors();
                $data_validation = array("StatusCode" => 1, "ErrorMessage" => array_filter($errors));
                return $this->response->setJSON($data_validation);
            } else {
                $VisaMarkupModel = new VisaMarkupModel();
                $data = $this->request->getPost();
                $data['modified'] = create_date();
                $data['agent_class_list_id'] = implode(',', $data['agent_class_list_id']);
                $data['visa_type_id'] = implode(',', $data['visa_type_id']);
                $added_data = $VisaMarkupModel->where("id", $id)->set($data)->update();
                if ($added_data) {
                    $message = array("StatusCode" => 0, "Message" => "visa markup successfully updated", "Class" => "success_popup", "Reload" => "true");
                } else {
                    $message = array("StatusCode" => 2, "Message" => "visa markup not updated", "Class" => "error_popup", "Reload" => "true");
                }
                $this->session->setFlashdata('Message', $message);
                return $this->response->setJSON($message);
            }
        }
    }

    public function remove_visa_markup()
    {
        if (permission_access_error("Visa", "delete_visa_markup")) {
            $VisaMarkupModel = new VisaMarkupModel();
            $ids = $this->request->getPost('checklist');

            $delete = $VisaMarkupModel->remove_markup($ids);

            if ($delete) {
                $message = array("StatusCode" => 0, "Message" => "visa markup successfully  Deleted", "Class" => "success_popup", "Reload" => "true");
            } else {
                $message = array("StatusCode" => 2, "Message" => "visa markup not deleted", "Class" => "error_popup", "Reload" => "true");
            }
            $this->session->setFlashdata('Message', $message);
            return $this->response->setJSON($message);
        }
    }


    public function visa_discount_list()
    {
        if (permission_access_error("Visa", "visa_discount_list")) {
            $VisaDiscountModel = new VisaDiscountModel();

            if ($this->request->getGet() && $this->request->getGet('key')) {
                $lists = $VisaDiscountModel->search_data($this->request->getGet());
            } else {
                $lists = $VisaDiscountModel->visa_discount_list();
            }
            $AgentClassModel = new AgentClassModel();
            $agent_class_list = $AgentClassModel->agent_class_list($this->web_partner_id);
            $agent_class_list = array_column($agent_class_list, 'class_name', 'id');

            $visa_type_list = $VisaDiscountModel->visa_type_list();
            $visa_type_list = array_column($visa_type_list, 'visa_title', 'id');

            $data = [
                'title' => $this->title,
                'list' => $lists,
                'visa_type_list'=>$visa_type_list,
                'agent_class_list'=>$agent_class_list,
                'view' => "MarkupDiscount\Views/visa-discount-list",
                'pager' => $VisaDiscountModel->pager,
                'search_bar_data' => $this->request->getGet(),
            ];

            return view('template/sidebar-layout', $data);
        }

    }

    public function visa_discount_view()
    {
        if (permission_access_error("Visa", "add_visa_discount")) {
            $VisaCountryModel = new VisaCountryModel();
            $VisaDiscountModel = new VisaDiscountModel();
            $data = [
                'title' => $this->title,
                'country' => $VisaCountryModel->get_country_code(),
                'agent_class_list' => $VisaDiscountModel->agent_class_list($this->web_partner_id)
            ];
            $add_blog_view = view('Modules\MarkupDiscount\Views\add-visa-discount', $data);
            $data = array("StatusCode" => 0, "Message" => $add_blog_view, 'class' => 'success_popup', "Reload" => "false");
            return $this->response->setJSON($data);
        }
    }

    public function add_visa_discount()
    {
        if (permission_access_error("Visa", "add_visa_discount")) {
            $validate = new Validation();
            $rules = $this->validate($validate->visa_discount_validation);
            if (!$rules) {
                $errors = $this->validator->getErrors();
                $data_validation = array("StatusCode" => 1, "ErrorMessage" => array_filter($errors));
                return $this->response->setJSON($data_validation);
            } else {
                $VisaDiscountModel = new VisaDiscountModel();
                $data = $this->request->getPost();
                $data['created'] = create_date();
                $data['agent_class_list_id'] = implode(',', $data['agent_class_list_id']);
                $data['visa_type_id'] = implode(',', $data['visa_type_id']);
                $added_data = $VisaDiscountModel->insert($data);

                if ($added_data) {
                    $message = array("StatusCode" => 0, "Message" => "Visa Discount Successfully Added", "Class" => "success_popup");
                } else {
                    $message = array("StatusCode" => 2, "Message" => "Visa Discount not  Added", "Class" => "error_popup");
                }

                $this->session->setFlashdata('Message', $message);
                return $this->response->setJSON($message);
            }
        }
    }

    public function visa_discount_status_change()
    {
        if (permission_access_error("Visa", "visa_discount_status")) {
            $validate = new Validation();
            $rules = $this->validate($validate->status);
            if (!$rules) {
                $errors = $this->validator->getErrors();
                $data_validation = array("StatusCode" => 1, "ErrorMessage" => array_filter($errors));
                return $this->response->setJSON($data_validation);
            } else {
                $VisaDiscountModel = new VisaDiscountModel();
                $ids = $this->request->getPost('checkedvalue');

                $data['status'] = $this->request->getPost('status');

                $update = $VisaDiscountModel->status_change($ids, $data);

                if ($update) {
                    $message = array("StatusCode" => 0, "Message" => "Visa Discount status  successfully changed", "Class" => "success_popup", "Reload" => "true");
                } else {
                    $message = array("StatusCode" => 2, "Message" => "Visa Discount status not changed successfully", "Class" => "error_popup", "Reload" => "true");
                }
                $this->session->setFlashdata('Message', $message);
                return $this->response->setJSON($message);
            }
        }
    }


    public function edit_admin_visa_discount_template()
    {
        if (permission_access_error("Visa", "edit_visa_discount")) {
            $id = dev_decode($this->request->uri->getSegment(3));

            $VisaCountryModel = new VisaCountryModel();

            $country = $VisaCountryModel->get_country_code();
            $VisaDiscountModel = new VisaDiscountModel();
            $details = $VisaDiscountModel->visa_discount_details($id);

            $VisaListModel = new VisaListModel();
            $country_id = $details['visa_country_id'];
            $visa_list = $VisaListModel->visa_list_page_select($country_id);
            $details['agent_class_list_id'] = explode(',', $details['agent_class_list_id']);

            $details['visa_type_id'] = explode(',', $details['visa_type_id']);


            $data = [
                'title' => $this->title,
                'id' => $id,
                'details' => $details,
                'country' => $country,
                'visa_list' => $visa_list,
                'agent_class_list' => $VisaDiscountModel->agent_class_list($this->web_partner_id)

            ];

            $details = view('Modules\MarkupDiscount\Views\edit-visa-discount', $data);
            $data = array("StatusCode" => 0, "Message" => $details, 'class' => 'success_popup', "Reload" => "false");
            return $this->response->setJSON($data);
        }

    }

    public function edit_admin_visa_discount()
    {
        if (permission_access_error("Visa", "edit_visa_discount")) {
            $id = dev_decode($this->request->uri->getSegment(3));
            $validate = new Validation();
            $rules = $this->validate($validate->visa_discount_validation);
            if (!$rules) {
                $errors = $this->validator->getErrors();
                $data_validation = array("StatusCode" => 1, "ErrorMessage" => array_filter($errors));
                return $this->response->setJSON($data_validation);
            } else {
                $VisaDiscountModel = new VisaDiscountModel();
                $data = $this->request->getPost();
                $data['modified'] = create_date();
                $data['agent_class_list_id'] = implode(',', $data['agent_class_list_id']);
                $data['visa_type_id'] = implode(',', $data['visa_type_id']);
                $added_data = $VisaDiscountModel->where("id", $id)->set($data)->update();
                if ($added_data) {
                    $message = array("StatusCode" => 0, "Message" => "visa discount successfully updated", "Class" => "success_popup", "Reload" => "true");
                } else {
                    $message = array("StatusCode" => 2, "Message" => "visa discount not updated", "Class" => "error_popup", "Reload" => "true");
                }
                $this->session->setFlashdata('Message', $message);
                return $this->response->setJSON($message);
            }
        }
    }

    public function remove_visa_discount()
    {
        if (permission_access_error("Visa", "delete_visa_discount")) {
            $VisaDiscountModel = new VisaDiscountModel();
            $ids = $this->request->getPost('checklist');

            $delete = $VisaDiscountModel->remove_discount($ids);

            if ($delete) {
                $message = array("StatusCode" => 0, "Message" => "visa discount successfully  Deleted", "Class" => "success_popup", "Reload" => "true");
            } else {
                $message = array("StatusCode" => 2, "Message" => "visa discount not deleted", "Class" => "error_popup", "Reload" => "true");
            }
            $this->session->setFlashdata('Message', $message);
            return $this->response->setJSON($message);
        }
    }


}