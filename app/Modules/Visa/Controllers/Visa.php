<?php

namespace Modules\Visa\Controllers;

use App\Controllers\BaseController;
use Modules\Visa\Config\Validation;
use App\Modules\Visa\Models\VisaCountryModel;
use App\Modules\Visa\Models\VisaTypeModel;
use App\Modules\Visa\Models\DocumentTypeModel;
use App\Modules\Visa\Models\VisaModel;
use App\Modules\Visa\Models\VisaDetailModel;
use App\Modules\Visa\Models\AmendmentModel;
use App\Modules\Visa\Models\VisaQueryModel;
use App\Modules\Visa\Models\VisaMarkupModel;
use App\Modules\Visa\Models\VisaDiscountModel;
use App\Modules\Visa\Models\AgentClassModel;
use App\Models\CommonModel;

class Visa extends BaseController
{
    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        helper('Modules\Visa\Helpers\visa');
        $this->web_partner_id = admin_cookie_data()['admin_user_details']['web_partner_id'];
        $this->web_partner_details = admin_cookie_data()['admin_user_details'];
        $this->user_id = admin_cookie_data()['admin_user_details']['id'];
        $this->title = "Visa";
        $this->folder_name = 'visa_documents';
        $this->folder_visa_type = 'visa_type';
        $this->Services = API_REQUEST_URL . '/visaservice/rest/';
        $this->geticketurl = "https://staging.bdsd.technology/visa2fly/api/visaservice/rest/";

        if (permission_access_error("Visa", "Visa_Module")) {
        }
    }


    public function visa_country_list()
    {
        if (permission_access_error("Visa", "visa_country_list")) {
            $VisaCountryModel = new VisaCountryModel();
            if ($this->request->getGet() && $this->request->getGet('key')) {
                $lists = $VisaCountryModel->search_data($this->request->getGet(), $this->web_partner_id);
            } else {
                $lists = $VisaCountryModel->visa_country_list($this->web_partner_id);
            }
            $data = [
                'title' => $this->title,
                'list' => $lists,
                'view' => "Visa\Views\country-list",
                'pager' => $VisaCountryModel->pager,
                'search_bar_data' => $this->request->getGet(),
            ];

            return view('template/sidebar-layout', $data);
        }
    }

    public function add_visa_country_view()
    {
        if (permission_access("Visa", "add_country")) {
            $add_view = view('Modules\Visa\Views\add-visa-country');
            $data = array("StatusCode" => 0, "Message" => $add_view, 'class' => 'success_popup', "Reload" => "false");
            return $this->response->setJSON($data);
        } else {
            $message = array("StatusCode" => 2, "Message" => "Permission Denied", "Class" => "error_popup");
            return $this->response->setJSON($message);
        }
    }

    public function add_visa_country()
    {
        if (permission_access("Visa", "add_country")) {
            $validate = new Validation();
            $rules = $this->validate($validate->visa_country_validation);
            if (!$rules) {
                $errors = $this->validator->getErrors();
                $data_validation = array("StatusCode" => 1, "ErrorMessage" => array_filter($errors));
                return $this->response->setJSON($data_validation);
            } else {
                $VisaCountryModel = new VisaCountryModel();
                $data = $this->request->getPost();
                #use getFile() for single image or getFiles() for multiple image
                $field_name = 'country_image';
                $file = $this->request->getFile($field_name);
                $resizeDim = array('width' => 235, 'height' => 250);
                $image_upload = image_upload($file, $field_name, $this->folder_name, $resizeDim);
                if ($image_upload['status_code'] == 0) {
                    $country = explode('-', $data['country_name']);
                    $data['country_name'] = $country[0];
                    $data['country_code'] = $country[1];
                    $data['created'] = create_date();
                    $data['web_partner_id'] = $this->web_partner_id;
                    $data[$field_name] = $image_upload['file_name'];

                    $added_data = $VisaCountryModel->insert($data);

                    if ($added_data) {
                        $message = array("StatusCode" => 0, "Message" => "Visa Country Successfully added", "Class" => "success_popup", "Reload" => "true");
                    } else {
                        $message = array("StatusCode" => 2, "Message" => "Visa Country  added", "Class" => "error_popup", "Reload" => "true");
                    }
                } else {
                    $message = array("StatusCode" => 2, "Message" => $image_upload['message'], "Class" => "error_popup", "Reload" => "true");
                }
                $this->session->setFlashdata('Message', $message);
                return $this->response->setJSON($message);
            }
        } else {
            $message = array("StatusCode" => 2, "Message" => "Permission Denied", "Class" => "error_popup");
            return $this->response->setJSON($message);
        }
    }

    public function edit_visa_country_view()
    {
        if (permission_access("Visa", "edit_country")) {
            $id = dev_decode($this->request->uri->getSegment(3));
            $VisaCountryModel = new VisaCountryModel();
            $details = $VisaCountryModel->country_details($id, $this->web_partner_id);

            $data = [
                'title' => $this->title,
                'id' => $id,
                'details' => $details,
            ];

            $details = view('Modules\Visa\Views\edit-visa-country', $data);
            $data = array("StatusCode" => 0, "Message" => $details, 'class' => 'success_popup', "Reload" => "false");
            return $this->response->setJSON($data);
        } else {
            $message = array("StatusCode" => 2, "Message" => "Permission Denied", "Class" => "error_popup");
            return $this->response->setJSON($message);
        }
    }

    public function edit_visa_country()
    {
        if (permission_access("Visa", "edit_country")) {
            $id = dev_decode($this->request->uri->getSegment(3));
            $field_name = 'country_image';

            $validate = new Validation();

            $images = $this->request->getFile($field_name);
            if ($images->getName() == '') {
                unset($validate->visa_country_validation[$field_name]);
            }

            $rules = $this->validate($validate->visa_country_validation);
            if (!$rules) {
                $errors = $this->validator->getErrors();
                $data_validation = array("StatusCode" => 1, "ErrorMessage" => array_filter($errors));
                return $this->response->setJSON($data_validation);
            } else {
                $VisaCountryModel = new VisaCountryModel();
                $data = $this->request->getPost();
                $previous_data = $VisaCountryModel->country_details($id, $this->web_partner_id);
                $file = $this->request->getFile($field_name);
                if ($file->getName() != '') {
                    $resizeDim = array('width' => 235, 'height' => 250);
                    $image_upload = image_upload($file, $field_name, $this->folder_name, $resizeDim);
                    if ($image_upload['status_code'] == 0) {

                        if ($previous_data[$field_name]) {
                            if (file_exists(FCPATH . "../uploads/$this->folder_name/" . $previous_data[$field_name])) {
                                unlink(FCPATH . "../uploads/$this->folder_name/" . $previous_data[$field_name]);
                                unlink(FCPATH . "../uploads/$this->folder_name/thumbnail/" . $previous_data[$field_name]);
                            }
                        }

                        $data['modified'] = create_date();
                        $country = explode('-', $data['country_name']);
                        $data['country_name'] = $country[0];
                        $data['country_code'] = $country[1];
                        $data[$field_name] = $image_upload['file_name'];
                        $added_data = $VisaCountryModel->where("id", $id)->where(["web_partner_id" => $this->web_partner_id])->set($data)->update();

                        if ($added_data) {
                            $message = array("StatusCode" => 0, "Message" => "visa country Successfully updated", "Class" => "success_popup", "Reload" => "true");
                        } else {
                            $message = array("StatusCode" => 2, "Message" => "visa country not updated", "Class" => "error_popup", "Reload" => "true");
                        }
                    } else {
                        $message = array("StatusCode" => 2, "Message" => $image_upload['message'], "Class" => "error_popup", "Reload" => "true");
                    }
                } else {

                    $data['modified'] = create_date();
                    $country = explode('-', $data['country_name']);
                    $data['country_name'] = $country[0];
                    $data['country_code'] = $country[1];
                    $data[$field_name] = $previous_data[$field_name];
                    $added_data = $VisaCountryModel->where("id", $id)->set($data)->update();

                    if ($added_data) {
                        $message = array("StatusCode" => 0, "Message" => "visa country Successfully updated", "Class" => "success_popup", "Reload" => "true");
                    } else {
                        $message = array("StatusCode" => 2, "Message" => "visa country not updated", "Class" => "error_popup", "Reload" => "true");
                    }
                }

                $this->session->setFlashdata('Message', $message);
                return $this->response->setJSON($message);
            }
        } else {
            $message = array("StatusCode" => 2, "Message" => "Permission Denied", "Class" => "error_popup");
            return $this->response->setJSON($message);
        }
    }

    public function country_status_change()
    {
        if (permission_access("Visa", "country_status")) {
            $validate = new Validation();
            $rules = $this->validate($validate->status);
            if (!$rules) {
                $errors = $this->validator->getErrors();
                $data_validation = array("StatusCode" => 1, "ErrorMessage" => array_filter($errors));
                return $this->response->setJSON($data_validation);
            } else {
                $VisaCountryModel = new VisaCountryModel();
                $ids = $this->request->getPost('checkedvalue');
                $data['modified'] = create_date();
                $data['status'] = $this->request->getPost('status');

                $update = $VisaCountryModel->status_change($ids, $data, $this->web_partner_id);

                if ($update) {
                    $message = array("StatusCode" => 0, "Message" => "Country status  successfully changed", "Class" => "success_popup", "Reload" => "true");
                } else {
                    $message = array("StatusCode" => 2, "Message" => "Country status not changed successfully", "Class" => "error_popup", "Reload" => "true");
                }
                $this->session->setFlashdata('Message', $message);
                return $this->response->setJSON($message);
            }
        } else {
            $message = array("StatusCode" => 2, "Message" => "Permission Denied", "Class" => "error_popup");
            return $this->response->setJSON($message);
        }
    }

    public function remove_visa_country()
    {
        if (permission_access("Visa", "delete_country")) {
            $VisaCountryModel = new VisaCountryModel();
            $ids = $this->request->getPost('checklist');

            $field_name = 'country_image';

            foreach ($ids as $id) {
                $blog_details = $VisaCountryModel->delete_image($id, $this->web_partner_id);

                if ($blog_details[$field_name]) {
                    if (file_exists(FCPATH . "../uploads/$this->folder_name/" . $blog_details[$field_name])) {
                        unlink(FCPATH . "../uploads/$this->folder_name/" . $blog_details[$field_name]);
                        unlink(FCPATH . "../uploads/$this->folder_name/thumbnail/" . $blog_details[$field_name]);
                    }
                }

                $blog_delete = $VisaCountryModel->remove_country($id, $this->web_partner_id);
            }

            if ($blog_delete) {
                $message = array("StatusCode" => 0, "Message" => "Visa Country  Successfully  Deleted", "Class" => "success_popup", "Reload" => "true");
            } else {
                $message = array("StatusCode" => 2, "Message" => "Visa Country  not Deleted", "Class" => "error_popup", "Reload" => "true");
            }
            $this->session->setFlashdata('Message', $message);
            return $this->response->setJSON($message);
        } else {
            $message = array("StatusCode" => 2, "Message" => "Permission Denied", "Class" => "error_popup");
            return $this->response->setJSON($message);
        }
    }

    public function visa_type_list()
    {
        if (permission_access_error("Visa", "visa_type_list")) {
            $VisaTypeModel = new VisaTypeModel();
            if ($this->request->getGet() && $this->request->getGet('key')) {
                $lists = $VisaTypeModel->search_data($this->request->getGet(), $this->web_partner_id);
            } else {
                $lists = $VisaTypeModel->visa_type($this->web_partner_id);
            }

            $data = [
                'title' => $this->title,
                'list' => $lists,
                'view' => "Visa\Views\Visa-type-list",
                'pager' => $VisaTypeModel->pager,
                'search_bar_data' => $this->request->getGet(),
            ];
            return view('template/sidebar-layout', $data);
        }
    }

    public function add_visa_type_view()
    {
        if (permission_access("Visa", "add_visa_type")) {
            $add_view = view('Modules\Visa\Views\add-visa-type');
            $data = array("StatusCode" => 0, "Message" => $add_view, 'class' => 'success_popup', "Reload" => "false");
            return $this->response->setJSON($data);
        } else {
            $message = array("StatusCode" => 2, "Message" => "Permission Denied", "Class" => "error_popup");
            return $this->response->setJSON($message);
        }
    }

    public function add_visa_type()
    {
        if (permission_access("Visa", "add_visa_type")) {
            $validate = new Validation();
            $rules = $this->validate($validate->visa_type);
            if (!$rules) {
                $errors = $this->validator->getErrors();
                $data_validation = array("StatusCode" => 1, "ErrorMessage" => array_filter($errors));
                return $this->response->setJSON($data_validation);
            } else {
                $VisaTypeModel = new VisaTypeModel();
                $data = $this->request->getPost();
                $value = $data['visa_title_slug'];
                $existingValue = $VisaTypeModel->CheckUniqueSlug($value, $this->web_partner_id);
                if ($existingValue) {
                    $data_validation = array("StatusCode" => 1, "ErrorMessage" => ["visa_title_slug" => "Visa slug already exists"]);
                    return $this->response->setJSON($data_validation);
                }
                $field_name = 'image';
                $file = $this->request->getFile($field_name);
                $resizeDim = array('width' => 235, 'height' => 250);
                $image_upload = image_upload($file, $field_name, $this->folder_visa_type, $resizeDim);
                if ($image_upload['status_code'] == 0) {
                    $data['created'] = create_date();
                    $data['web_partner_id'] = $this->web_partner_id;
                    $data[$field_name] = $image_upload['file_name'];
                    $added_data = $VisaTypeModel->insert($data);
                    if ($added_data) {
                        $message = array("StatusCode" => 0, "Message" => "Visa Type Successfully added", "Class" => "success_popup", "Reload" => "true");
                    } else {
                        $message = array("StatusCode" => 2, "Message" => "Visa Type not  added", "Class" => "error_popup", "Reload" => "true");
                    }
                } else {
                    $message = array("StatusCode" => 2, "Message" => $image_upload['message'], "Class" => "error_popup", "Reload" => "true");
                }
                $this->session->setFlashdata('Message', $message);
                return $this->response->setJSON($message);
            }
        } else {
            $message = array("StatusCode" => 2, "Message" => "Permission Denied", "Class" => "error_popup");
            return $this->response->setJSON($message);
        }
    }

    public function edit_visa_type_view()
    {
        if (permission_access("Visa", "edit_visa_type")) {
            $id = dev_decode($this->request->uri->getSegment(3));
            $VisaTypeModel = new VisaTypeModel();
            $details = $VisaTypeModel->visa_type_details($id, $this->web_partner_id);

            $data = [
                'title' => $this->title,
                'id' => $id,
                'details' => $details,
            ];

            $details = view('Modules\Visa\Views\edit-visa-type', $data);
            $data = array("StatusCode" => 0, "Message" => $details, 'class' => 'success_popup', "Reload" => "false");
            return $this->response->setJSON($data);
        } else {
            $message = array("StatusCode" => 2, "Message" => "Permission Denied", "Class" => "error_popup");
            return $this->response->setJSON($message);
        }
    }

    public function edit_visa_type()
    {
        if (permission_access("Visa", "edit_visa_type")) {
            $id = dev_decode($this->request->uri->getSegment(3));
            $field_name = 'image';
            $validate = new Validation();
            $images = $this->request->getFile($field_name);
            if ($images->getName() == '') {
                unset($validate->visa_type[$field_name]);
            }
            $rules = $this->validate($validate->visa_type);
            if (!$rules) {
                $errors = $this->validator->getErrors();
                $data_validation = array("StatusCode" => 1, "ErrorMessage" => array_filter($errors));
                return $this->response->setJSON($data_validation);
            } else {
                $VisaTypeModel = new VisaTypeModel();
                $data = $this->request->getPost();


                $previous_data = $VisaTypeModel->visa_type_details($id, $this->web_partner_id);
                $file = $this->request->getFile($field_name);

                if ($previous_data['visa_title_slug'] != $data['visa_title_slug']) {
                    $value = $data['visa_title_slug'];
                    $existingValue = $VisaTypeModel->CheckUniqueSlug($value, $this->web_partner_id);
                    if ($existingValue) {
                        $data_validation = array("StatusCode" => 1, "ErrorMessage" => ["visa_title_slug" => "Visa slug already exists"]);
                        return $this->response->setJSON($data_validation);
                    }
                }
                if ($file->getName() != '') {
                    $resizeDim = array('width' => 235, 'height' => 250);
                    $image_upload = image_upload($file, $field_name, $this->folder_visa_type, $resizeDim);
                    if ($image_upload['status_code'] == 0) {
                        if ($previous_data[$field_name]) {
                            if (file_exists(FCPATH . "../uploads/$this->folder_visa_type/" . $previous_data[$field_name])) {
                                unlink(FCPATH . "../uploads/$this->folder_visa_type/" . $previous_data[$field_name]);
                                unlink(FCPATH . "../uploads/$this->folder_visa_type/thumbnail/" . $previous_data[$field_name]);
                            }
                        }
                        $data['modified'] = create_date();
                        $data[$field_name] = $image_upload['file_name'];
                        $added_data = $VisaTypeModel->where("id", $id)->where(["web_partner_id" => $this->web_partner_id])->set($data)->update();

                        if ($added_data) {
                            $message = array("StatusCode" => 0, "Message" => "visa Type Successfully updated", "Class" => "success_popup", "Reload" => "true");
                        } else {
                            $message = array("StatusCode" => 2, "Message" => "visa Type not updated", "Class" => "error_popup", "Reload" => "true");
                        }
                    } else {
                        $message = array("StatusCode" => 2, "Message" => $image_upload['message'], "Class" => "error_popup", "Reload" => "true");
                    }
                } else {
                    $data['modified'] = create_date();
                    $added_data = $VisaTypeModel->where("id", $id)->where(['web_partner_id' => $this->web_partner_id])->set($data)->update();
                    if ($added_data) {
                        $message = array("StatusCode" => 0, "Message" => "visa Type Successfully updated", "Class" => "success_popup", "Reload" => "true");
                    } else {
                        $message = array("StatusCode" => 2, "Message" => "visa Type not updated", "Class" => "error_popup", "Reload" => "true");
                    }
                }
                $this->session->setFlashdata('Message', $message);
                return $this->response->setJSON($message);
            }
        } else {
            $message = array("StatusCode" => 2, "Message" => "Permission Denied", "Class" => "error_popup");
            return $this->response->setJSON($message);
        }
    }

    public function remove_visa_type()
    {
        if (permission_access("Visa", "delete_visa_type")) {
            $VisaTypeModel = new VisaTypeModel();
            $ids = $this->request->getPost('checklist');
            $field_name = 'image';
            foreach ($ids as $id) {
                $visa_type_details = $VisaTypeModel->delete_image($id, $this->web_partner_id);

                if ($visa_type_details[$field_name]) {
                    if (file_exists(FCPATH . "../uploads/$this->folder_visa_type/" . $visa_type_details[$field_name])) {
                        unlink(FCPATH . "../uploads/$this->folder_visa_type/" . $visa_type_details[$field_name]);
                        unlink(FCPATH . "../uploads/$this->folder_visa_type/thumbnail/" . $visa_type_details[$field_name]);
                    }
                }
                $delete = $VisaTypeModel->remove_visa_type($ids, $this->web_partner_id);
            }
            if ($delete) {
                $message = array("StatusCode" => 0, "Message" => "Visa Type Successfully  Deleted", "Class" => "success_popup", "Reload" => "true");
            } else {
                $message = array("StatusCode" => 2, "Message" => "Visa Type not Deleted", "Class" => "error_popup", "Reload" => "true");
            }
            $this->session->setFlashdata('Message', $message);
            return $this->response->setJSON($message);
        } else {
            $message = array("StatusCode" => 2, "Message" => "Permission Denied", "Class" => "error_popup");
            return $this->response->setJSON($message);
        }
    }

    public function document_type_view()
    {
        if (permission_access_error("Visa", "visa_document_type_list")) {
            $DocumentTypeModel = new DocumentTypeModel();
            $lists = $DocumentTypeModel->document_details_list($this->web_partner_id);
            // pr($lists);
            // die;
            $data = [
                'title' => $this->title,
                'list' => $lists,
                'view' => "Visa\Views\document-type-list",
                'pager' => $DocumentTypeModel->pager,
            ];
            return view('template/sidebar-layout', $data);
        }
    }

    public function add_document_type_view()
    {
        if (permission_access("Visa", "add_visa_document_type")) {
            $add_view = view('Modules\Visa\Views\add-document-type');
            $data = array("StatusCode" => 0, "Message" => $add_view, 'class' => 'success_popup', "Reload" => "false");
            return $this->response->setJSON($data);
        } else {
            $message = array("StatusCode" => 2, "Message" => "Permission Denied", "Class" => "error_popup");
            return $this->response->setJSON($message);
        }
    }

    public function add_document_type()
    {
        if (permission_access("Visa", "add_visa_document_type")) {
            $validate = new Validation();
            $rules = $this->validate($validate->document_type);
            if (!$rules) {
                $errors = $this->validator->getErrors();
                $data_validation = array("StatusCode" => 1, "ErrorMessage" => array_filter($errors));
                return $this->response->setJSON($data_validation);
            } else {
                $DocumentTypeModel = new DocumentTypeModel();
                $data = $this->request->getPost();

                $document = array(
                    'web_partner_id' => $this->web_partner_id,
                    'service' => 'Visa',
                    'key_source' => str_replace(' ', '_', strtolower($data['document_name'])),
                    'value' => ucfirst($data['document_name'])
                );

                $added_data = $DocumentTypeModel->insertData('website_common_data', $document);
                if ($added_data) {
                    $message = array("StatusCode" => 0, "Message" => "Document Type Successfully added", "Class" => "success_popup", "Reload" => "true");
                } else {
                    $message = array("StatusCode" => 2, "Message" => "Document Type not  added", "Class" => "error_popup", "Reload" => "true");
                }
                $this->session->setFlashdata('Message', $message);
                return $this->response->setJSON($message);
            }
        } else {
            $message = array("StatusCode" => 2, "Message" => "Permission Denied", "Class" => "error_popup");
            return $this->response->setJSON($message);
        }
    }

    public function remove_document_type()
    {
        if (permission_access("Visa", "delete_visa_document_type")) {
            $DocumentTypeModel = new DocumentTypeModel();
            $ids = $this->request->getPost('checklist');
            $delete = $DocumentTypeModel->remove_document_type($ids, $this->web_partner_id);
            if ($delete) {
                $message = array("StatusCode" => 0, "Message" => "Document Type  Successfully  Deleted", "Class" => "success_popup", "Reload" => "true");
            } else {
                $message = array("StatusCode" => 2, "Message" => "Document Type  not Deleted", "Class" => "error_popup", "Reload" => "true");
            }
            $this->session->setFlashdata('Message', $message);
            return $this->response->setJSON($message);
        } else {
            $message = array("StatusCode" => 2, "Message" => "Permission Denied", "Class" => "error_popup");
            return $this->response->setJSON($message);
        }
    }

    public function visa_list()
    {
        $VisaDetailModel = new VisaDetailModel();
        if ($this->request->getGet() && $this->request->getGet('key')) {
            $lists = $VisaDetailModel->search_data($this->request->getGet(), $this->web_partner_id);
        } else {
            $lists = $VisaDetailModel->visa_details_list($this->web_partner_id);
        }

        $data = [
            'title' => $this->title,
            'list' => $lists,
            'view' => "Visa\Views\Visa-list",
            'pager' => $VisaDetailModel->pager,
            'search_bar_data' => $this->request->getGet(),
        ];
        return view('template/sidebar-layout', $data);
    }

    public function add_visa_details_view()
    {
        if (permission_access("Visa", "add_visa")) {
            $VisaCountryModel = new VisaCountryModel();
            $VisaTypeModel = new VisaTypeModel();
            $DocumentTypeModel = new DocumentTypeModel();
            $country = $VisaCountryModel->get_country_code($this->web_partner_id);
            $visa_list = $VisaTypeModel->visa_type_select($this->web_partner_id);
            $documentType = $DocumentTypeModel->document_details_list($this->web_partner_id);
            $data = [
                'title' => $this->title,
                'country' => $country,
                'visa_list' => $visa_list,
                'documentType' => $documentType,
                'view' => "Visa\Views\add-visa-details",
            ];
            return view('template/sidebar-layout', $data);
        } else {
            $message = array("StatusCode" => 2, "Message" => "Permission Denied", "Class" => "error_popup");
            return $this->response->setJSON($message);
        }
    }

    public function add_visa_details()
    {
        if (permission_access("Visa", "add_visa")) {
            $validate = new Validation();
            $input = $this->request->getPost();
            $country_id = $input['visa_country_id'];
            $visa_type_id = $input['visa_list_id'];
            $VisaDetailModel = new VisaDetailModel();
            $exist_visa_type = $VisaDetailModel->get_visa_unique_details($this->web_partner_id, $country_id, $visa_type_id);
            $rules = $this->validate($validate->visa_details);
            if ($exist_visa_type) {
                $rules = false;
            }

            if (!$rules) {
                $errors = $this->validator->getErrors();
                if ($exist_visa_type) {
                    $errors['visa_list_id'] = "Visa Type already exists for the country";
                }

                $data_validation = array("StatusCode" => 1, "ErrorMessage" => array_filter($errors));
                return $this->response->setJSON($data_validation);
            } else {

                $DocumentTypeModel = new DocumentTypeModel();
                $data = $this->request->getPost();

                $documentType = array();
                $documentTypeArray = $DocumentTypeModel->document_details_list($this->web_partner_id);


                $visa_id = dev_decode($this->request->uri->getSegment(3));

                if (isset($data['documentType']) && $data['documentType'] != null) {
                    foreach ($data['documentType'] as $key => $document) {
                        foreach ($document as $key1 => $value) {
                            $documentType[$key1] = $value;
                        }
                    }
                }
                // else {
                //     foreach ($documentTypeArray as $key => $document) {
                //         $documentType[$document['key_source']] = 0;
                //     }
                // }
                if ($data['e_visa'] == "true") {
                    $e_visa = true;
                } else {
                    $e_visa = false;
                }
                $data['e_visa'] = $e_visa;
                $data['documentType'] = json_encode($documentType);
                $data['inclusions'] = implode(",", $data['inclusions']);
                $data['important_information'] = implode(",", $data['important_information']);
                $data['created'] = create_date();
                $data['web_partner_id'] = $this->web_partner_id;
                $added_data = $VisaDetailModel->insert($data);
                if ($added_data) {
                    $message = array("StatusCode" => 0, "Message" => "Visa Details Successfully added", "Class" => "success_popup", "Reload" => "true");
                } else {
                    $message = array("StatusCode" => 2, "Message" => "Visa Details not  added", "Class" => "error_popup", "Reload" => "true");
                }
                $this->session->setFlashdata('Message', $message);
                return $this->response->setJSON($message);
            }
        } else {
            $message = array("StatusCode" => 2, "Message" => "Permission Denied", "Class" => "error_popup");
            return $this->response->setJSON($message);
        }
    }


    public function edit_visa_details_view()
    {
        if (permission_access("Visa", "edit_visa")) {
            $id = dev_decode($this->request->uri->getSegment(3));
            $VisaDetailModel = new VisaDetailModel();
            $details = $VisaDetailModel->visa_details($id, $this->web_partner_id);

            $VisaCountryModel = new VisaCountryModel();
            $country = $VisaCountryModel->get_country_code($this->web_partner_id);

            $VisaTypeModel = new VisaTypeModel();
            $visa_list = $VisaTypeModel->visa_type_select($this->web_partner_id);

            $DocumentTypeModel = new DocumentTypeModel();
            $documentType = $DocumentTypeModel->document_details_list($this->web_partner_id);

            $data = [
                'title' => $this->title,
                'id' => $id,
                'details' => $details,
                'country' => $country,
                'visa_list' => $visa_list,
                'document_type' => $documentType,
                'view' => "Visa\Views/edit-visa-details",
            ];
            return view('template/sidebar-layout', $data);
        } else {
            $message = array("StatusCode" => 2, "Message" => "Permission Denied", "Class" => "error_popup");
            return $this->response->setJSON($message);
        }
    }

    public function edit_visa_details()
    {
        if (permission_access("Visa", "edit_visa")) {
            $id = dev_decode($this->request->uri->getSegment(3));
            $validate = new Validation();
            $rules = $this->validate($validate->visa_details);
            if (!$rules) {
                $errors = $this->validator->getErrors();
                if (isset($errors['inclusions.*'])) {
                    $errors['inclusions[]'] = $errors['inclusions.*'];
                }
                if (isset($errors['important_information.*'])) {
                    $errors['important_information[]'] = $errors['important_information.*'];
                }
                $data_validation = array("StatusCode" => 1, "ErrorMessage" => array_filter($errors));
                return $this->response->setJSON($data_validation);
            } else {
                $VisaDetailModel = new VisaDetailModel();
                $DocumentTypeModel = new DocumentTypeModel();
                $data = $this->request->getPost();
                $data['modified'] = create_date();
                $documentType = array();
                $documentTypeArray = $DocumentTypeModel->document_details_list($this->web_partner_id);
                $visa_id = dev_decode($this->request->uri->getSegment(3));

                if (isset($data['documentType']) && $data['documentType'] != null) {
                    foreach ($data['documentType'] as $key => $document) {
                        foreach ($document as $key1 => $value) {
                            $documentType[$key1] = $value;
                        }
                    }
                }
                // else {
                //     foreach ($documentTypeArray as $key => $document) {
                //         $documentType[] = "";
                //     }
                // }
                if ($data['e_visa'] == "true") {
                    $e_visa = true;
                } else {
                    $e_visa = false;
                }
                $data['e_visa'] = $e_visa;
                $data['inclusions'] = implode(",", $data['inclusions']);
                $data['important_information'] = implode(",", $data['important_information']);
                $data['documentType'] = json_encode($documentType);

                $added_data = $VisaDetailModel->where("id", $id)->where(['web_partner_id' => $this->web_partner_id])->set($data)->update();
                if ($added_data) {
                    $message = array("StatusCode" => 0, "Message" => "visa details successfully updated", "Class" => "success_popup", "Reload" => "true");
                } else {
                    $message = array("StatusCode" => 2, "Message" => "visa details not updated", "Class" => "error_popup", "Reload" => "true");
                }
                $this->session->setFlashdata('Message', $message);
                return $this->response->setJSON($message);
            }
        } else {
            $message = array("StatusCode" => 2, "Message" => "Permission Denied", "Class" => "error_popup");
            return $this->response->setJSON($message);
        }
    }

    public function details_status_change()
    {
        if (permission_access("Visa", "visa_status")) {
            $validate = new Validation();
            $rules = $this->validate($validate->status);
            if (!$rules) {
                $errors = $this->validator->getErrors();
                $data_validation = array("StatusCode" => 1, "ErrorMessage" => array_filter($errors));
                return $this->response->setJSON($data_validation);
            } else {
                $VisaDetailModel = new VisaDetailModel();
                $ids = $this->request->getPost('checkedvalue');
                $data['modified'] = create_date();
                $data['status'] = $this->request->getPost('status');

                $update = $VisaDetailModel->status_change($ids, $data, $this->web_partner_id);

                if ($update) {
                    $message = array("StatusCode" => 0, "Message" => "visa detail status  successfully changed", "Class" => "success_popup", "Reload" => "true");
                } else {
                    $message = array("StatusCode" => 2, "Message" => "visa detail status not changed successfully", "Class" => "error_popup", "Reload" => "true");
                }
                $this->session->setFlashdata('Message', $message);
                return $this->response->setJSON($message);
            }
        } else {
            $message = array("StatusCode" => 2, "Message" => "Permission Denied", "Class" => "error_popup");
            return $this->response->setJSON($message);
        }
    }

    public function remove_visa_details()
    {
        if (permission_access("Visa", "delete_visa")) {
            $VisaDetailModel = new VisaDetailModel();
            $ids = $this->request->getPost('checklist');
            $delete = $VisaDetailModel->remove_visa_details($ids, $this->web_partner_id);

            if ($delete) {
                $message = array("StatusCode" => 0, "Message" => "visa details successfully  Deleted", "Class" => "success_popup", "Reload" => "true");
            } else {
                $message = array("StatusCode" => 2, "Message" => "visa details not deleted", "Class" => "error_popup", "Reload" => "true");
            }
            $this->session->setFlashdata('Message', $message);
            return $this->response->setJSON($message);
        } else {
            $message = array("StatusCode" => 2, "Message" => "Permission Denied", "Class" => "error_popup");
            return $this->response->setJSON($message);
        }
    }

    public function visa_markup_list()
    {
        $VisaMarkupModel = new VisaMarkupModel();
        if ($this->request->getGet() && $this->request->getGet('key')) {
            $lists = $VisaMarkupModel->search_data($this->request->getGet(), $this->web_partner_id);
        } else {
            $lists = $VisaMarkupModel->visa_markup_list($this->web_partner_id);
        }
        $AgentClassModel = new AgentClassModel();
        $agent_class_list = $AgentClassModel->agent_class_list($this->web_partner_id);
        $agent_class_list = array_column($agent_class_list, 'class_name', 'id');


        $visa_type_list = $VisaMarkupModel->visa_type_list($this->web_partner_id);
        $visa_type_list = array_column($visa_type_list, 'visa_title', 'id');

        $data = [
            'title' => $this->title,
            'list' => $lists,
            'agent_class_list' => $agent_class_list,
            'visa_type_list' => $visa_type_list,
            'view' => "Visa\Views\MarkupAndDiscount/visa-markup-list",
            'pager' => $VisaMarkupModel->pager,
            'search_bar_data' => $this->request->getGet(),
        ];
        return view('template/sidebar-layout', $data);
    }

    public function visa_markup_view()
    {
        if (permission_access("Visa", "add_visa_markup")) {
            $VisaCountryModel = new VisaCountryModel();
            $AgentClassModel = new AgentClassModel();
            $data = [
                'title' => $this->title,
                'country' => $VisaCountryModel->get_country_code($this->web_partner_id),
                'agent_class' => $AgentClassModel->agent_class_list($this->web_partner_id)
            ];
            $add_blog_view = view('Modules\Visa\Views\MarkupAndDiscount\add-visa-markup', $data);
            $data = array("StatusCode" => 0, "Message" => $add_blog_view, 'class' => 'success_popup', "Reload" => "false");
            return $this->response->setJSON($data);
        } else {
            $message = array("StatusCode" => 2, "Message" => "Permission Denied", "Class" => "error_popup");
            return $this->response->setJSON($message);
        }
    }

    public function get_visa_list_select_markup()
    {
        $VisaMarkupModel = new VisaMarkupModel();
        $data = $this->request->getPost();
        $country_id = $data['country_id'];
        $visa_list = $VisaMarkupModel->visa_list_page_select($this->web_partner_id);
        if ($visa_list) {
            foreach ($visa_list as $data) {
                echo "<option value=" . $data['id'] . ">" . $data['visa_title'] . "</option>";
            }
        }
    }

    public function get_visa_list_select()
    {
        $VisaMarkupModel = new VisaMarkupModel();
        $data = $this->request->getPost();
        $country_id = $data['country_id'];
        $visa_list = $VisaMarkupModel->visa_list_page_select($this->web_partner_id);
        if ($visa_list) {
            foreach ($visa_list as $data) {
                echo "<option value=" . $data['id'] . ">" . $data['visa_title'] . "</option>";
            }
        } else {
            echo "<option value='' selected>" . 'Select Visa Type' . "</option>";
        }
    }

    public function add_visa_markup()
    {
        if (permission_access("Visa", "add_visa_markup")) {
            $data = $this->request->getPost();

            $validate = new Validation();
            if ($data['markup_for'] == "B2C") {
                unset($validate->visa_markup_validation['agent_class.*']);
            }
            $rules = $this->validate($validate->visa_markup_validation);
            if (!$rules) {
                $errors = $this->validator->getErrors();
                if (isset($errors['visa_type_id.*']) && $errors['visa_type_id.*'] != '') {
                    $errors['visa_type_id[]'] = $errors['visa_type_id.*'];
                    unset($errors['visa_type_id.*']);
                }
                if (isset($errors['agent_class.*']) && $errors['agent_class.*'] != '') {
                    $errors['agent_class[]'] = $errors['agent_class.*'];
                    unset($errors['agent_class.*']);
                }
                $data_validation = array("StatusCode" => 1, "ErrorMessage" => array_filter($errors));
                return $this->response->setJSON($data_validation);
            } else {
                $VisaMarkupModel = new VisaMarkupModel();

                $data['created'] = create_date();
                $data['web_partner_id'] = $this->web_partner_id;
                $data['agent_class'] = ($data['markup_for'] == 'B2C') ? NULL : implode(',', $data['agent_class']);
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
        } else {
            $message = array("StatusCode" => 2, "Message" => "Permission Denied", "Class" => "error_popup");
            return $this->response->setJSON($message);
        }
    }

    public function edit_admin_visa_markup_template()
    {
        if (permission_access("Visa", "edit_visa_markup")) {
            $id = dev_decode($this->request->uri->getSegment(3));
            $VisaCountryModel = new VisaCountryModel();
            $country = $VisaCountryModel->get_country_code($this->web_partner_id);
            $VisaMarkupModel = new VisaMarkupModel();
            $details = $VisaMarkupModel->visa_markup_details($id, $this->web_partner_id);

            $country_id = $details['visa_country_id'];
            $visa_list = $VisaMarkupModel->visa_list_page_select($this->web_partner_id);

            $details['agent_class'] = explode(',', $details['agent_class']);
            $details['visa_type_id'] = explode(',', $details['visa_type_id']);

            $AgentClassModel = new AgentClassModel();
            $data = [
                'title' => $this->title,
                'id' => $id,
                'details' => $details,
                'country' => $country,
                'visa_list' => $visa_list,
                'agent_class_list' => $AgentClassModel->agent_class_list($this->web_partner_id)

            ];

            $details = view('Modules\Visa\Views\MarkupAndDiscount\edit-visa-markup', $data);
            $data = array("StatusCode" => 0, "Message" => $details, 'class' => 'success_popup', "Reload" => "false");
            return $this->response->setJSON($data);
        } else {
            $message = array("StatusCode" => 2, "Message" => "Permission Denied", "Class" => "error_popup");
            return $this->response->setJSON($message);
        }
    }

    public function edit_admin_visa_markup()
    {
        if (permission_access("Visa", "edit_visa_markup")) {
            $data = $this->request->getPost();
            $id = dev_decode($this->request->uri->getSegment(3));
            $validate = new Validation();
            if ($data['markup_for'] == "B2C") {
                unset($validate->visa_markup_validation['agent_class.*']);
            }
            $rules = $this->validate($validate->visa_markup_validation);
            if (!$rules) {
                $errors = $this->validator->getErrors();
                if (isset($errors['visa_type_id.*']) && $errors['visa_type_id.*'] != '') {
                    $errors['visa_type_id[]'] = $errors['visa_type_id.*'];
                    unset($errors['visa_type_id.*']);
                }
                if (isset($errors['agent_class.*']) && $errors['agent_class.*'] != '') {
                    $errors['agent_class[]'] = $errors['agent_class.*'];
                    unset($errors['agent_class.*']);
                }
                $data_validation = array("StatusCode" => 1, "ErrorMessage" => array_filter($errors));
                return $this->response->setJSON($data_validation);
            } else {
                $VisaMarkupModel = new VisaMarkupModel();

                $data['modified'] = create_date();
                $data['agent_class'] = ($data['markup_for'] == 'B2C') ? NULL : implode(',', $data['agent_class']);
                $data['visa_type_id'] = implode(',', $data['visa_type_id']);
                $added_data = $VisaMarkupModel->where(["id" => $id, "web_partner_id" => $this->web_partner_id])->set($data)->update();
                if ($added_data) {
                    $message = array("StatusCode" => 0, "Message" => "visa markup successfully updated", "Class" => "success_popup", "Reload" => "true");
                } else {
                    $message = array("StatusCode" => 2, "Message" => "visa markup not updated", "Class" => "error_popup", "Reload" => "true");
                }
                $this->session->setFlashdata('Message', $message);
                return $this->response->setJSON($message);
            }
        } else {
            $message = array("StatusCode" => 2, "Message" => "Permission Denied", "Class" => "error_popup");
            return $this->response->setJSON($message);
        }
    }

    public function visa_markup_status_change()
    {
        if (permission_access("Visa", "visa_markup_status")) {
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

                $update = $VisaMarkupModel->status_change($ids, $data, $this->web_partner_id);

                if ($update) {
                    $message = array("StatusCode" => 0, "Message" => "Visa Markup status  successfully changed", "Class" => "success_popup", "Reload" => "true");
                } else {
                    $message = array("StatusCode" => 2, "Message" => "Visa Markup status not changed successfully", "Class" => "error_popup", "Reload" => "true");
                }
                $this->session->setFlashdata('Message', $message);
                return $this->response->setJSON($message);
            }
        } else {
            $message = array("StatusCode" => 2, "Message" => "Permission Denied", "Class" => "error_popup");
            return $this->response->setJSON($message);
        }
    }

    public function remove_visa_markup()
    {
        if (permission_access("Visa", "delete_visa_markup")) {

            $VisaMarkupModel = new VisaMarkupModel();
            $ids = $this->request->getPost('checklist');
            $delete = $VisaMarkupModel->remove_markup($ids, $this->web_partner_id);

            if ($delete) {
                $message = array("StatusCode" => 0, "Message" => "Visa markup successfully  Deleted", "Class" => "success_popup", "Reload" => "true");
            } else {
                $message = array("StatusCode" => 2, "Message" => "Visa markup not deleted", "Class" => "error_popup", "Reload" => "true");
            }
            $this->session->setFlashdata('Message', $message);
            return $this->response->setJSON($message);
        } else {
            $message = array("StatusCode" => 2, "Message" => "Permission Denied", "Class" => "error_popup");
            return $this->response->setJSON($message);
        }
    }

    public function visa_discount_list()
    {
        $VisaDiscountModel = new VisaDiscountModel();
        if ($this->request->getGet() && $this->request->getGet('key')) {
            $lists = $VisaDiscountModel->search_data($this->request->getGet(), $this->web_partner_id);
        } else {
            $lists = $VisaDiscountModel->visa_discount_list($this->web_partner_id);
        }
        $AgentClassModel = new AgentClassModel();
        $agent_class_list = $AgentClassModel->agent_class_list($this->web_partner_id);
        $agent_class_list = array_column($agent_class_list, 'class_name', 'id');

        $visa_type_list = $VisaDiscountModel->visa_type_list($this->web_partner_id);
        $visa_type_list = array_column($visa_type_list, 'visa_title', 'id');

        $data = [
            'title' => $this->title,
            'list' => $lists,
            'visa_type_list' => $visa_type_list,
            'agent_class_list' => $agent_class_list,
            'view' => "Visa\Views\MarkupAndDiscount/visa-discount-list",
            'pager' => $VisaDiscountModel->pager,
            'search_bar_data' => $this->request->getGet(),
        ];
        return view('template/sidebar-layout', $data);
    }

    public function visa_discount_view()
    {
        if (permission_access("Visa", "add_visa_discount")) {
            $VisaCountryModel = new VisaCountryModel();
            $AgentClassModel = new AgentClassModel();
            $data = [
                'title' => $this->title,
                'country' => $VisaCountryModel->get_country_code($this->web_partner_id),
                'agent_class' => $AgentClassModel->agent_class_list($this->web_partner_id)
            ];
            $add_blog_view = view('Modules\Visa\Views\MarkupAndDiscount\add-visa-discount', $data);
            $data = array("StatusCode" => 0, "Message" => $add_blog_view, 'class' => 'success_popup', "Reload" => "false");
            return $this->response->setJSON($data);
        } else {
            $message = array("StatusCode" => 2, "Message" => "Permission Denied", "Class" => "error_popup");
            return $this->response->setJSON($message);
        }
    }

    public function add_visa_discount()
    {
        if (permission_access("Visa", "add_visa_discount")) {
            $data = $this->request->getPost();
            $validate = new Validation();
            if ($data['discount_for'] == "B2C") {
                unset($validate->visa_discount_validation['agent_class.*']);
            }
            $rules = $this->validate($validate->visa_discount_validation);
            if (!$rules) {
                $errors = $this->validator->getErrors();
                $data_validation = array("StatusCode" => 1, "ErrorMessage" => array_filter($errors));
                return $this->response->setJSON($data_validation);
            } else {
                $VisaDiscountModel = new VisaDiscountModel();
                $data['created'] = create_date();
                $data['web_partner_id'] = $this->web_partner_id;
                $data['agent_class'] = ($data['discount_for'] == 'B2C') ? NULL : implode(',', $data['agent_class']);
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
        } else {
            $message = array("StatusCode" => 2, "Message" => "Permission Denied", "Class" => "error_popup");
            return $this->response->setJSON($message);
        }
    }

    public function edit_admin_visa_discount_template()
    {
        if (permission_access("Visa", "edit_visa_discount")) {
            $id = dev_decode($this->request->uri->getSegment(3));

            $VisaCountryModel = new VisaCountryModel();

            $country = $VisaCountryModel->get_country_code($this->web_partner_id);
            $VisaDiscountModel = new VisaDiscountModel();
            $details = $VisaDiscountModel->visa_discount_details($id, $this->web_partner_id);

            $VisaMarkupModel = new VisaMarkupModel();
            $country_id = $details['visa_country_id'];
            $visa_list = $VisaMarkupModel->visa_list_page_select($this->web_partner_id);
            $details['agent_class'] = explode(',', $details['agent_class']);
            $details['visa_type_id'] = explode(',', $details['visa_type_id']);
            $AgentClassModel = new AgentClassModel();
            $data = [
                'title' => $this->title,
                'id' => $id,
                'details' => $details,
                'country' => $country,
                'visa_list' => $visa_list,
                'agent_class_list' => $AgentClassModel->agent_class_list($this->web_partner_id)

            ];

            $details = view('Modules\Visa\Views\MarkupAndDiscount/edit-visa-discount', $data);
            $data = array("StatusCode" => 0, "Message" => $details, 'class' => 'success_popup', "Reload" => "false");
            return $this->response->setJSON($data);
        } else {
            $message = array("StatusCode" => 2, "Message" => "Permission Denied", "Class" => "error_popup");
            return $this->response->setJSON($message);
        }
    }

    public function edit_admin_visa_discount()
    {
        if (permission_access("Visa", "edit_visa_discount")) {
            $id = dev_decode($this->request->uri->getSegment(3));
            $data = $this->request->getPost();
            $validate = new Validation();
            if ($data['discount_for'] == "B2C") {
                unset($validate->visa_discount_validation['agent_class.*']);
            }
            $rules = $this->validate($validate->visa_discount_validation);
            if (!$rules) {
                $errors = $this->validator->getErrors();
                $data_validation = array("StatusCode" => 1, "ErrorMessage" => array_filter($errors));
                return $this->response->setJSON($data_validation);
            } else {
                $VisaDiscountModel = new VisaDiscountModel();

                $data['modified'] = create_date();
                $data['agent_class'] = ($data['discount_for'] == 'B2C') ? NULL : implode(',', $data['agent_class']);
                $data['visa_type_id'] = implode(',', $data['visa_type_id']);

                $added_data = $VisaDiscountModel->where(["id" => $id, "web_partner_id" => $this->web_partner_id])->set($data)->update();
                if ($added_data) {
                    $message = array("StatusCode" => 0, "Message" => "Visa discount successfully updated", "Class" => "success_popup", "Reload" => "true");
                } else {
                    $message = array("StatusCode" => 2, "Message" => "Visa discount not updated", "Class" => "error_popup", "Reload" => "true");
                }
                $this->session->setFlashdata('Message', $message);
                return $this->response->setJSON($message);
            }
        } else {
            $message = array("StatusCode" => 2, "Message" => "Permission Denied", "Class" => "error_popup");
            return $this->response->setJSON($message);
        }
    }

    public function visa_discount_status_change()
    {
        if (permission_access("Visa", "visa_discount_status")) {
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

                $update = $VisaDiscountModel->status_change($ids, $data, $this->web_partner_id);

                if ($update) {
                    $message = array("StatusCode" => 0, "Message" => "Visa Discount status  successfully changed", "Class" => "success_popup", "Reload" => "true");
                } else {
                    $message = array("StatusCode" => 2, "Message" => "Visa Discount status not changed successfully", "Class" => "error_popup", "Reload" => "true");
                }
                $this->session->setFlashdata('Message', $message);
                return $this->response->setJSON($message);
            }
        } else {
            $message = array("StatusCode" => 2, "Message" => "Permission Denied", "Class" => "error_popup");
            return $this->response->setJSON($message);
        }
    }
    public function remove_visa_discount()
    {
        if (permission_access("Visa", "delete_visa_discount")) {
            $VisaDiscountModel = new VisaDiscountModel();
            $ids = $this->request->getPost('checklist');

            $delete = $VisaDiscountModel->remove_discount($ids, $this->web_partner_id);

            if ($delete) {
                $message = array("StatusCode" => 0, "Message" => "visa discount successfully  Deleted", "Class" => "success_popup", "Reload" => "true");
            } else {
                $message = array("StatusCode" => 2, "Message" => "visa discount not deleted", "Class" => "error_popup", "Reload" => "true");
            }
            $this->session->setFlashdata('Message', $message);
            return $this->response->setJSON($message);
        } else {
            $message = array("StatusCode" => 2, "Message" => "Permission Denied", "Class" => "error_popup");
            return $this->response->setJSON($message);
        }
    }


    public function VisaQueryList()
    {
        if (permission_access("Visa", "visa_query")) {

            $VisaQueryModel = new VisaQueryModel();
            if ($this->request->getGet() && $this->request->getGet('key')) {
                $lists = $VisaQueryModel->search_data($this->web_partner_id, $this->request->getGet());
            } else {
                $lists = $VisaQueryModel->visa_query_list($this->web_partner_id);
            }

            $data = [
                'title' => $this->title,
                'list' => $lists,
                'view' => "Visa\Views\Visa-query-list",
                'pager' => $VisaQueryModel->pager,
                'search_bar_data' => $this->request->getGet(),
            ];
            return view('template/sidebar-layout', $data);
        } else {
            $message = array("StatusCode" => 2, "Message" => "Permission Denied", "Class" => "error_popup");
            return $this->response->setJSON($message);
        }
    }


    public function remove_visa_Query_list()
    {
        if (permission_access("Visa", "delete_visa_query")) {
            $VisaQueryModel = new VisaQueryModel();
            $ids = $this->request->getPost('checklist');

            $delete = $VisaQueryModel->visa_query_list_delete($ids, $this->web_partner_id);

            if ($delete) {
                $message = array("StatusCode" => 0, "Message" => "visa query successfully  Deleted", "Class" => "success_popup", "Reload" => "true");
            } else {
                $message = array("StatusCode" => 2, "Message" => "visa query not deleted", "Class" => "error_popup", "Reload" => "true");
            }
            $this->session->setFlashdata('Message', $message);
            return $this->response->setJSON($message);
        } else {
            $message = array("StatusCode" => 2, "Message" => "Permission Denied", "Class" => "error_popup");
            return $this->response->setJSON($message);
        }
    }








    public function get_invoice_ticket()
    {
        if (permission_access("Visa", "invoice_ticket")) {
            $VisaModel = new VisaModel();
            if (!$this->request->isAJAX()) {
                $getData = $this->request->getGet();
                $bookingRefNumbers = $getData['booking_ref_number'];
                $getTicketInvioceType = array("PrintTicket" => "Ticket", "AgencyInvoice" => "AgencyInvoice", "CustomerInvoice" => "CustomerInvoice");
                $getUserType = array("PrintTicket" => "wl-agent", "AgencyInvoice" => "webpartner", "CustomerInvoice" => "wl-agent");
                if ($bookingRefNumbers) {
                    $bookingInfoData = $VisaModel->getBookingWithBookingRefNumberWithVariableFieldNameData($bookingRefNumbers, $this->web_partner_id, "id,tts_search_token,booking_source");

                    $tts_search_token = isset($bookingInfoData['tts_search_token']) ? $bookingInfoData['tts_search_token'] : "";
                    $booking_source = isset($bookingInfoData['booking_source']) ? $bookingInfoData['booking_source'] : "";
                    if ($booking_source == "Wl_b2b") {
                        $getUserType = array("PrintTicket" => "wl-agent", "AgencyInvoice" => "WebPartner", "CustomerInvoice" => "wl-agent");
                    } else {
                        $getUserType = array("PrintTicket" => "wl-customer", "AgencyInvoice" => "WebPartner", "CustomerInvoice" => "wl-customer");
                    }
                    $bookingInfoId = $bookingInfoData['id'];
                    if ($bookingRefNumbers && $bookingInfoData) {

                        if ($getData['type'] == "PrintTicket") {
                            $TicketViewRequest = array(
                                "BookingId" => $bookingInfoId,
                                "SearchTokenId" => $tts_search_token,
                                "HtmlType" => $getTicketInvioceType[$getData['type']],
                                "UserType" => $getUserType[$getData['type']],
                                "ViewService" => "View",
                                "WithPrice" => isset($getData['price']) ? 1 : 0,
                                "WithAgencyDetail" => isset($getData['agency_detail']) ? 1 : 0,
                                "ViewSize" => "",
                                "RequestBy" => "WebPartner",
                            );
                        } else {
                            $TicketViewRequest = array(
                                "BookingId" => $bookingInfoId,
                                "SearchTokenId" => $tts_search_token,
                                "HtmlType" => $getTicketInvioceType[$getData['type']],
                                "UserType" => $getUserType[$getData['type']],
                                "ViewService" => "View",
                                "WithPrice" => 1,
                                "WithAgencyDetail" => 1,
                                "ViewSize" => "",
                                "RequestBy" => "WebPartner",
                            );
                        }
                        // generate-wl-voucher-invoice
                        $url = $this->Services . 'generate-wl-voucher-invoice';
// pr($url);die;
                        // echo $url;
                        // echo json_encode($TicketViewRequest);exit; 
                        $response = RequestWithoutAuth($TicketViewRequest, $url);

                        if (isset($response['Result']['Html'])) {
                            $Html = $response['Result']['Html'];
                        } else {
                            $Html = "Something went wrong please call admin";
                        }
                        $data = [
                            'title' => $this->title,
                            'view' => "Visa\Views\booking\listing\print_ticket",
                            'data' => $Html,
                        ];
                        return view('template/sidebar-layout', $data);
                    } else {
                        return $this->response->redirect(site_url('visa/error?errormessage=Request Not Allowed'));
                    }
                } else {
                    return $this->response->redirect(site_url('visa/error?errormessage=Request Not Allowed'));
                }
            } else {
                $validate = new Validation();
                $rules = $this->validate($validate->EmailTicketValidation);
                if (!$rules) {
                    $errors = $this->validator->getErrors();
                    $data_validation = array("StatusCode" => 1, "ErrorMessage" => array_filter($errors));
                    return $this->response->setJSON($data_validation);
                } else {
                    $getData = $this->request->getPost();
                    $bookingRefNumbers = $getData['booking_ref_number'];
                    if ($bookingRefNumbers) {

                        $bookingInfoData = $VisaModel->getBookingWithBookingRefNumberWithVariableFieldNameData($bookingRefNumbers, $this->web_partner_id, "id,tts_search_token");
                        $bookingInfo = $bookingInfoData;
                        $bookingInfoId = $bookingInfoData['id'];
                        $tts_search_token = isset($bookingInfoData['tts_search_token']) ? $bookingInfoData['tts_search_token'] : "";

                        if ($bookingRefNumbers && $bookingInfo) {
                            $TicketViewRequest = array(
                                "BookingId" => $bookingInfoId,
                                "SearchTokenId" => $tts_search_token,
                                "HtmlType" => "Ticket",
                                "UserType" => "WebPartner",
                                "ViewService" => "Email",
                                "WithPrice" => "1",
                                "WithAgencyDetail" => "0",
                                "TicketInvoiceJourney" => "Both",
                                "ViewSize" => "",
                                "RequestBy" => "WebPartner",
                            );
                            $url = $this->Services . 'generate-voucher-invoice';
                            $response = RequestWithoutAuth($TicketViewRequest, $url);

                            $htmlView = $response['Result']['Html'];
                            $subject = "Visa Voucher";
                            $to = $getData['email'];
                            $data = send_email($to, $subject, $htmlView);
                            $message = array("StatusCode" => 0, "Message" => "Email Successfully Send", "Class" => "success_popup", "Reload" => "true");
                        } else {
                            $message = array("StatusCode" => 2, "Message" => "Request Not Allowed", "Class" => "error_popup");
                        }
                        $this->session->setFlashdata('Message', $message);
                        return $this->response->setJSON($message);
                    } else {
                        return $this->response->redirect(site_url('visa/error?errormessage=Request Not Allowed'));
                    }
                }
            }
        } else {
            $message = array("StatusCode" => 2, "Message" => "Permission Denied", "Class" => "error_popup");
            return $this->response->setJSON($message);
        }
    }

    public function booking_list()
    {
        if (permission_access("Visa", "visa_booking_list")) {
            $VisaModel = new VisaModel();
            $bookingType = 'all';
            $source = '';
            $getData = $this->request->getGET();
            if (isset($getData['key'])) {
                $lists = $VisaModel->search_data($getData, $this->web_partner_id, $this->web_partner_details['id'], $this->web_partner_details['primary_user'], $bookingType, $source);
            } else {
                $source = $this->request->getGET('source');
                if ($source == 'dashboard') {
                    $source = 'dashboard';
                }
                $bookingType = 'all';
                if (isset($_GET['bookingtype'])) {
                    $bookingType = $this->request->getGET('bookingtype');
                }
                $lists = $VisaModel->visa_booking_list($this->web_partner_id, $this->web_partner_details['id'], $this->web_partner_details['primary_user'], $bookingType, $source);
            }

            $data = [
                'title' => $this->title,
                'list' => $lists,
                'view' => "Visa\Views\booking\listing\Visa-booking-list",
                'pager' => $VisaModel->pager,
                'search_bar_data' => $this->request->getGet(),
            ];
            return view('template/sidebar-layout', $data);
        } else {
            $message = array("StatusCode" => 2, "Message" => "Permission Denied", "Class" => "error_popup");
            return $this->response->setJSON($message);
        }
    }

    function AssignUpdateVisaTicket()
    {
        if (permission_access_error("Visa", "assign_user_booking")) {
            $bookingReferenceNumber = dev_decode($this->request->uri->getSegment(3));

            $VisaModel = new VisaModel();
            $BookingDetail = $VisaModel->Visa_booking_detail($this->web_partner_id, $bookingReferenceNumber, $this->web_partner_details['id'], $this->web_partner_details['primary_user']);

            if ($BookingDetail) {
                $checkbookingflighttime = checkbookingflighttime($BookingDetail['created'], 'Visa');
                if (isset($checkbookingflighttime['WaitingTime']) && $checkbookingflighttime['WaitingTime']) {
                    $message = array("StatusCode" => 2, "Message" => $checkbookingflighttime['WaitingMessage'], "Class" => "error_popup", "Reload" => "true");
                    $this->session->setFlashdata('Message', $message);
                    return $this->response->redirect($this->request->getUserAgent()->getReferrer());
                }
                $updateData['webpartner_assign_user'] = $this->user_id;
                $VisaModel->updateUserData("visa_booking_list", array("booking_ref_number" => $bookingReferenceNumber), $updateData);
                $message = array("StatusCode" => 0, "Message" => "Voucher assign successfully", "Class" => "success_popup", "Reload" => "true");
                $this->session->setFlashdata('Message', $message);
                return $this->response->redirect($this->request->getUserAgent()->getReferrer());
            } else {
                return $this->response->redirect(site_url('visa/error?errormessage=Request Not Allowed'));
            }
        } else {
            $message = array("StatusCode" => 2, "Message" => "Permission Denied", "Class" => "error_popup");
            return $this->response->setJSON($message);
        }
    }

    function getUpdatevisaVoucherInfo()
    {
        if (permission_access_error("Visa", "update_booking_ticket")) {
            $uri = service('uri');
            $bookingReferenceNumber = $uri->getSegment(3);
            $VisaModel = new VisaModel();
            $bookingInfo = $VisaModel->Visa_booking_detail($this->web_partner_id, $bookingReferenceNumber, $this->web_partner_details['id'], $this->web_partner_details['primary_user']);
            $amendment_list = $VisaModel->amendment_list($this->web_partner_id, $bookingInfo['id'], $bookingInfo['booking_source']);

            $webpartnerfareBreakupArray = json_decode($bookingInfo['web_partner_fare_break_up'], true);
            if ($bookingInfo['booking_source'] == "Wl_b2b") {
                $fareBreakupArray = json_decode($bookingInfo['agent_fare_break_up'], true);
            } else {
                $fareBreakupArray = json_decode($bookingInfo['customer_fare_break_up'], true);
            }
            $couponAmount = 0;
            $couponInfo = json_decode($bookingInfo['coupon_info'], true);
            if (isset($couponInfo['couponAmount']) && $bookingInfo['coupon_info'] != NULL && !empty($bookingInfo['coupon_info'])) {
                $couponAmount = $couponInfo['couponAmount'];
            }

            $markup = isset($webpartnerfareBreakupArray['WebPMarkUp']) ? $webpartnerfareBreakupArray['WebPMarkUp'] : 0;
            $discount = isset($webpartnerfareBreakupArray['WebPDiscount']) ? $webpartnerfareBreakupArray['WebPDiscount'] : 0;
            if (isset($webpartnerfareBreakupArray['WebPDisplayMarkup']) && $webpartnerfareBreakupArray['WebPDisplayMarkup'] == 'in_service_charge') {
                $WebPDisplayMarkup = $webpartnerfareBreakupArray['WebPDisplayMarkup'];
                $addMarkupInServiceCharge = $markup;
            } else {
                $WebPDisplayMarkup = "in_tax";
                $addMarkupInTax = $markup;
            }
            $TotalAmount = round_value($fareBreakupArray['OfferedPrice'] - $couponAmount);
            if ($bookingInfo['booking_source'] == "Wl_b2b") {
                $TotalAmount = round_value($fareBreakupArray['TDS'] + $fareBreakupArray['OfferedPrice'] - $couponAmount);
            }

            $FareBreakUp = array(
                "FareBreakup" => array(
                    "BaseFare" => array("Value" => round_value($fareBreakupArray['BasePrice']), "LabelText" => "Base Fare"),
                    "Taxes" => array("Value" => round_value($fareBreakupArray['Tax']), "LabelText" => "Taxes"),
                    "ServiceAndOtherCharge" => array("Value" => round_value($fareBreakupArray['ServiceCharges']), "LabelText" => "Service Charges"),
                    "CommEarned" => array("Value" => round_value($fareBreakupArray['AgentCommission'] + $fareBreakupArray['Discount']), "LabelText" => "Discount (-)"),
                    "TDS" => array("Value" => round_value($fareBreakupArray['TDS']), "LabelText" => "TDS (+)")
                ),
                "TotalAmount" => array("Value" => $TotalAmount, "LabelText" => "Total Amount"),
                "GSTDetails" => ($fareBreakupArray['GST']),
                "WebPMarkUp" => array("Value" => round_value($markup), "LabelText" => "Apply Mark Up"),
                "WebPDiscount" => array("Value" => round_value($discount), "LabelText" => "Apply Discount"),
                "WebPDisplayMarkup" => array("Value" => ucfirst(str_replace("_", " ", $WebPDisplayMarkup)), "LabelText" => "Apply Markup At"),
            );
            if ($couponAmount > 0) {
                $FareBreakUp['FareBreakup']['Promocode'] = array("Value" => round_value($couponAmount), "LabelText" => "Promocode Discount (-)");
            }

            $visaSupplier = $VisaModel->getBulkData("offline_provider", array('visa_service' => 'active'), 'id,supplier_name');

            $bookingInfo['FareBreakUp'] = $FareBreakUp;

            $data = [
                'title' => $this->title,
                'amendment_list' => $amendment_list,
                'bookingDetail' => $bookingInfo,
                "visaSupplier" => $visaSupplier,
                "UpdateVoucher" => 1,
                'view' => "Visa\Views\booking\listing/Visa-booking-details",
            ];

            return view('template/sidebar-layout', $data);
        } else {
            $message = array("StatusCode" => 2, "Message" => "Permission Denied", "Class" => "error_popup");
            return $this->response->setJSON($message);
        }
    }

    public function UpdateVisaVoucherInfo()
    {
        if (permission_access_error("Visa", "update_booking_ticket")) {
            $input = $this->request->getPost();
            $validate = new Validation();
            $validationConfigArray = $validate->voucher_update_validation($input);
            $this->validation->setRules($validationConfigArray);
            $rules = true;
            if ($input['booking_status'] != "Failed") {
                $rules = $this->validation->run($input);
            }
            if (!$rules) {
                $errors = $this->validation->getErrors();
                $data_validation = array("StatusCode" => 1, "ErrorMessage" => array_filter($errors));
                return $this->response->setJSON($data_validation);
            } else {
                $VisaModel = new VisaModel();
                $AmendmentModel = new AmendmentModel();
                $booking_refrence_number = dev_decode($input['booking_ref_number']);
                $visa_booking_id = dev_decode($input['visa_booking_id']);
                $bookingInfo = $VisaModel->Visa_booking_detail($this->web_partner_id, $booking_refrence_number, $this->web_partner_details['id'], $this->web_partner_details['primary_user']);
                if ($bookingInfo && (isset($bookingInfo['id']) && ($bookingInfo['id'] == $visa_booking_id))) {
                    $checkbookingflighttime = checkbookingflighttime($bookingInfo['created'], "Visa");
                    if (isset($checkbookingflighttime['WaitingTime']) && $checkbookingflighttime['WaitingTime']) {
                        $message = array("StatusCode" => 2, "Message" => $checkbookingflighttime['WaitingMessage'], "Class" => "error_popup", "Reload" => "true");
                        $this->session->setFlashdata('Message', $message);
                        $RedirectUrl = site_url('visa/booking-list');
                        $data_validation = array("StatusCode" => 3, "ErrorMessage" => '', "Redirect_Url" => $RedirectUrl);
                        return $this->response->setJSON($data_validation);
                    }
                    if ($bookingInfo['booking_source'] == "Wl_b2b") {
                        $AccountTableName = "agent_account_log";
                        $key = "wl_agent_id";
                        $user = "Agent";
                        $account_log_id = $bookingInfo['wl_agent_id'];
                        $fareBreakupArray = json_decode($bookingInfo['agent_fare_break_up'], true);
                    } else if ($bookingInfo['booking_source'] == "Wl_b2c") {
                        $AccountTableName = "customer_account_log";
                        $key = 'customer_id';
                        $user = "Customer";
                        $account_log_id = $bookingInfo['wl_customer_id'];
                        $fareBreakupArray = json_decode($bookingInfo['customer_fare_break_up'], true);
                    }
                    if ($bookingInfo['webpartner_assign_user'] == $this->user_id || admin_cookie_data()['admin_user_details']['primary_user'] == 1) {
                        if (isset($input['refundbookingamount']) && $input['refundbookingamount'] == "yes") {
                            if (((isset($bookingInfo['booking_status']) && $bookingInfo['booking_status'] == 'Failed') || $input['booking_status'] == "Failed") && (isset($bookingInfo['payment_status']) && $bookingInfo['payment_status'] == 'Successful')) {
                                $bookingWhereArray = array("booking_ref_no" => $bookingInfo['id'], 'service' => "visa", "action_type" => "booking", 'transaction_type' => "debit", 'web_partner_id' => $bookingInfo['web_partner_id']);
                                $bookRefundWhereArray = array("booking_ref_no" => $bookingInfo['id'], 'service' => "visa", "action_type" => "refund", 'transaction_type' => "credit", 'web_partner_id' => $bookingInfo['web_partner_id']);
                                $bookingWhereArray[$key] = $account_log_id;
                                $bookRefundWhereArray[$key] = $account_log_id;
                                $VisaBookingAccountinfo = $VisaModel->getData($AccountTableName, $bookingWhereArray, '*');
                                $CheckVisaBookingRefund = $VisaModel->getData($AccountTableName, $bookRefundWhereArray, "*");
                                if (empty($CheckVisaBookingRefund)) {
                                    if (!empty($VisaBookingAccountinfo) && $VisaBookingAccountinfo) {
                                        $serviceLog = json_decode($VisaBookingAccountinfo['service_log'], true);
                                        $extra_param = json_decode($VisaBookingAccountinfo['extra_param'], true);
                                        if (empty($serviceLog)) {
                                            $serviceLog = [];
                                        }
                                        if (empty($extra_param)) {
                                            $extra_param = [];
                                        }
                                        $serviceLog['BookingRefrenceNumber'] = $booking_refrence_number;
                                        $web_partner_id = $VisaBookingAccountinfo['web_partner_id'];
                                        $topupAmount = round_value(($VisaBookingAccountinfo['debit']));
                                        $WebPartnerAccountLogData['web_partner_id'] = $web_partner_id;
                                        $WebPartnerAccountLogData['user_id'] = $this->user_id;
                                        $WebPartnerAccountLogData[$key] = $account_log_id;
                                        $WebPartnerAccountLogData['created'] = create_date();
                                        $WebPartnerAccountLogData['transaction_type'] = "credit";
                                        $WebPartnerAccountLogData['payment_mode'] = "Account_Transfer";
                                        $WebPartnerAccountLogData['action_type'] = "refund";
                                        $WebPartnerAccountLogData['role'] = 'web_partner';
                                        $WebPartnerAccountLogData['remark'] = $input['remark'];
                                        $WebPartnerAccountLogData['service_log'] = json_encode($serviceLog);
                                        $WebPartnerAccountLogData['extra_param'] = json_encode($extra_param);
                                        $WebPartnerAccountLogData['service'] = "visa";
                                        $WebPartnerAccountLogData['booking_ref_no'] = $bookingInfo['id'];
                                        $WebPartnerAccountLogData['acc_ref_number'] = mt_rand(100000, 999999);
                                        $available_balance = $AmendmentModel->agent_user_available_balance($AccountTableName, $key, $account_log_id, $web_partner_id);
                                        if (!$available_balance) {
                                            $available_balance['balance'] = 0;
                                        }
                                        $WebPartnerAccountLogData['balance'] = round_value(($available_balance['balance'] + $topupAmount));
                                        $WebPartnerAccountLogData['credit'] = $topupAmount;
                                        $added_data_id = $VisaModel->insertData($AccountTableName, $WebPartnerAccountLogData);
                                        $updateData['acc_ref_number'] = reference_number($added_data_id);
                                        $VisaModel->updateUserData($AccountTableName, array("id" => $added_data_id), $updateData);
                                    } else {
                                        $message = array("StatusCode" => 2, "Message" => "You are not eligible update ticket", "Class" => "error_popup");
                                        $this->session->setFlashdata('Message', $message);;
                                        $RedirectUrl = site_url('visa/booking-list');
                                        $data_validation = array("StatusCode" => 3, "ErrorMessage" => '', "Redirect_Url" => $RedirectUrl);
                                        return $this->response->setJSON($data_validation);
                                    }
                                } else {
                                    $message = array("StatusCode" => 2, "Message" => "Refund for this booking has been done already", "Class" => "error_popup");
                                    $this->session->setFlashdata('Message', $message);;
                                    $RedirectUrl = site_url('visa/booking-list');
                                    $data_validation = array("StatusCode" => 3, "ErrorMessage" => '', "Redirect_Url" => $RedirectUrl);
                                    return $this->response->setJSON($data_validation);
                                }
                            } else {
                                $message = array("StatusCode" => 2, "Message" => "You are not eligible update voucher", "Class" => "error_popup");
                                $this->session->setFlashdata('Message', $message);;
                                $RedirectUrl = site_url('visa/booking-list');
                                $data_validation = array("StatusCode" => 3, "ErrorMessage" => '', "Redirect_Url" => $RedirectUrl);
                                return $this->response->setJSON($data_validation);
                            }
                        }
                        if ($input['booking_status'] == "Confirmed") {
                            $bookingWhereArray = array("booking_ref_no" => $bookingInfo['id'], 'service' => "visa", "action_type" => "booking", 'transaction_type' => "debit", 'web_partner_id' => $bookingInfo['web_partner_id']);
                            $bookingWhereArray[$key] = $account_log_id;
                            $CarBookingAccountinfo = $VisaModel->getData($AccountTableName, $bookingWhereArray, "*");
                            if (empty($CarBookingAccountinfo)) {
                                if (isset($input['deductbookingamount']) && $input['deductbookingamount'] == "yes") {
                                    $web_partner_id = $bookingInfo['web_partner_id'];
                                    $available_balance = $AmendmentModel->agent_user_available_balance($AccountTableName, $key, $account_log_id, $web_partner_id);
                                    $first_name = isset($bookingInfo['travellers'][0]['first_name']) ? $bookingInfo['travellers'][0]['first_name'] : '';
                                    $last_name = isset($bookingInfo['travellers'][0]['last_name']) ? $bookingInfo['travellers'][0]['last_name'] : '';
                                    $serviceLog['PaxName'] = $first_name . " " . $last_name;
                                    $serviceLog['Sector'] = $bookingInfo['visa_country'] . "-" . $bookingInfo['visa_type'] . "-" . $bookingInfo["processing_time"];
                                    $serviceLog['TravelDate'] = isset($bookingInfo['date_of_journey']) ? $bookingInfo['date_of_journey'] : '';

                                    $extra_parm['booking_ref_number'] = $bookingInfo['booking_ref_number'];
                                    $extra_parm['webPartnerBreakUpInfo'] = json_decode($bookingInfo['web_partner_fare_break_up'], true);
                                    if ($bookingInfo['booking_source'] == "Wl_b2b") {
                                        $extra_parm['agentBreakUpInfo'] = json_decode($bookingInfo['agent_fare_break_up'], true);
                                        $extra_parm['convenienceFee'] = (isset($extra_parm['agentBreakUpInfo']['convenienceFee'])) ? $extra_parm['agentBreakUpInfo']['convenienceFee'] : 0;
                                    } else {
                                        $extra_parm['customerBreakUpInfo'] = json_decode($bookingInfo['customer_fare_break_up'], true);
                                        $extra_parm['convenienceFee'] = (isset($extra_parm['customerBreakUpInfo']['convenienceFee'])) ? $extra_parm['customerBreakUpInfo']['convenienceFee'] : 0;
                                    }
                                    if (isset($available_balance['balance']) && $available_balance['balance'] >= $bookingInfo['total_price']) {
                                        $debitAmount = round_value(($bookingInfo['total_price']));
                                        $WebPartnerAccountLogData['web_partner_id'] = $web_partner_id;
                                        $WebPartnerAccountLogData['user_id'] = $this->user_id;
                                        $WebPartnerAccountLogData[$key] = $account_log_id;
                                        $WebPartnerAccountLogData['created'] = create_date();
                                        $WebPartnerAccountLogData['transaction_type'] = "debit";
                                        $WebPartnerAccountLogData['action_type'] = "booking";
                                        $WebPartnerAccountLogData['payment_mode'] = "Account_Transfer";
                                        $WebPartnerAccountLogData['role'] = 'web_partner';
                                        $WebPartnerAccountLogData['remark'] = $input['remark'];
                                        $WebPartnerAccountLogData['service_log'] = json_encode($serviceLog);
                                        $WebPartnerAccountLogData['extra_param'] = json_encode($extra_parm);
                                        $WebPartnerAccountLogData['service'] = "visa";
                                        $WebPartnerAccountLogData['booking_ref_no'] = $bookingInfo['id'];
                                        $WebPartnerAccountLogData['acc_ref_number'] = mt_rand(100000, 999999);
                                        $available_balance = $AmendmentModel->agent_user_available_balance($AccountTableName, $key, $account_log_id, $web_partner_id);
                                        if (!$available_balance) {
                                            $available_balance['balance'] = 0;
                                        }
                                        $WebPartnerAccountLogData['balance'] = round_value(($available_balance['balance'] - $debitAmount));
                                        $WebPartnerAccountLogData['debit'] = $debitAmount;
                                        $added_data_id = $VisaModel->insertData($AccountTableName, $WebPartnerAccountLogData);
                                        $updateData['acc_ref_number'] = reference_number($added_data_id);
                                        $VisaModel->updateUserData($AccountTableName, array("id" => $added_data_id), $updateData);
                                        $input['payment_status'] = "Successful";
                                    } else {
                                        $message = array("StatusCode" => 2, "Message" => "$user have not enough balance", "Class" => "error_popup");
                                        $this->session->setFlashdata('Message', $message);
                                        $RedirectUrl = site_url('visa/get-update-visa-voucher-info/' . $booking_refrence_number);
                                        $data_validation = array("StatusCode" => 3, "ErrorMessage" => '', "Redirect_Url" => $RedirectUrl);
                                        return $this->response->setJSON($data_validation);
                                    }
                                } else {
                                    $message = array("StatusCode" => 2, "Message" => "Payment  have not done for this booking", "Class" => "error_popup");
                                    $this->session->setFlashdata('Message', $message);;
                                    $RedirectUrl = site_url('visa/get-update-visa-voucher-info/' . $booking_refrence_number);
                                    $data_validation = array("StatusCode" => 3, "ErrorMessage" => '', "Redirect_Url" => $RedirectUrl);
                                    return $this->response->setJSON($data_validation);
                                }
                            }
                        }

                        $saveNoteData = array(
                            "booking_ref_no" => $visa_booking_id,
                            'agent_staff_id' => $this->user_id,
                            'web_partner_id' => $this->web_partner_id,
                            'wl_agent_staff_id' => $bookingInfo['wl_agent_staff_id'],
                            'service_type' => "visa",
                            'add_by' => "weppartner",
                            'comment' => $input['remark'],
                            'created' => create_date()
                        );
                        $saveNoteDataId = $VisaModel->insertData('web_partner_booking_notes', $saveNoteData);

                        if ($input['booking_status'] == 'Confirmed' && $bookingInfo['booking_status'] != 'Confirmed') {
                            $InvoiceNumber = "";
                            /* invoice  Number Generate Number */
                            $CommonModel = new CommonModel();
                            $WebPartnerfareBreakup = $fareBreakupArray;
                            $checkTaxableInvoce = checkTaxableNonTaxableINV($WebPartnerfareBreakup, "", 'visa', 'INV');
                            $INVPrifix = getTaxableNonTaxableINVSuffix('INV', $checkTaxableInvoce, 'visa');
                            $financialYear = get_financial_year();
                            $whereCondition['service'] = 'visa';
                            $whereCondition['invoice_type'] = 'INV';
                            $whereCondition['financial_year'] = $financialYear;
                            $otherParameter['financialYear'] = $financialYear;
                            $otherParameter['service'] = 'visa';
                            $otherParameter['invoice_type'] = 'INV';
                            $otherParameter['INVPrifix'] = $INVPrifix;
                            $otherParameter['web_partner_id'] = $this->web_partner_id;
                            $otherParameter['checkTaxableInvoce'] = $checkTaxableInvoce;
                            $generateInvoiceData = $CommonModel->getInvoiceSuffixData($whereCondition, $otherParameter);
                            $InvoiceInfoData = generateInvoiceNumber($generateInvoiceData);
                            $InvoiceNumber = $InvoiceInfoData['InvoiceNumber'];
                            $InvoiceupdateData = $InvoiceInfoData['updateData'];
                            $VisaModel->updateUserData('invoice_suffix_list', $whereCondition, $InvoiceupdateData);
                            $VisaModel->updateUserData($AccountTableName, ['booking_ref_no' => $visa_booking_id, "service" => "visa", 'transaction_type' => "debit", 'action_type' => "booking"], ["invoice_number" => $InvoiceNumber]);
                            /* invoice  Number Generate Number */
                        }

                        $superAdminStaffDetail = admin_cookie_data()['admin_user_details'];
                        $updateVisaBookingData = array(
                            "booking_status" => $input['booking_status'],
                            "payment_status" => $input['payment_status'],
                            "issue_supplier" => $input['supplier'],
                            "webpartner_assign_user" => null,
                            "confirmation_no" => $input['confirmation_number'],
                            'is_manual' => 1,
                            "webpartner_update_ticket_by" => json_encode(array("first_name" => $superAdminStaffDetail['first_name'], "last_name" => $superAdminStaffDetail['last_name'], "StaffId" => $superAdminStaffDetail['id'])),
                        );

                        $VisaModel->updateUserData("visa_booking_list", array("id" => $visa_booking_id), $updateVisaBookingData);
                        $message = array("StatusCode" => 1, "Message" => "Ticket Update successfully", "Class" => "success_popup");
                        $this->session->setFlashdata('Message', $message);;
                        $RedirectUrl = site_url('visa/visa-booking-details/' . $booking_refrence_number);
                        $data_validation = array("StatusCode" => 3, "ErrorMessage" => '', "Redirect_Url" => $RedirectUrl);
                        return $this->response->setJSON($data_validation);
                    } else {
                        $message = array("StatusCode" => 2, "Message" => "You are not eligible update Voucher", "Class" => "error_popup");
                        $this->session->setFlashdata('Message', $message);;
                        $RedirectUrl = site_url('visa/booking-list');
                        $data_validation = array("StatusCode" => 3, "ErrorMessage" => '', "Redirect_Url" => $RedirectUrl);
                        return $this->response->setJSON($data_validation);
                    }
                } else {
                    $message = array("StatusCode" => 2, "Message" => "Record not found", "Class" => "error_popup");
                    $this->session->setFlashdata('Message', $message);
                    $RedirectUrl = site_url('visa');
                    $data_validation = array("StatusCode" => 3, "ErrorMessage" => '', "Redirect_Url" => $RedirectUrl);
                    return $this->response->setJSON($data_validation);
                }
            }
        } else {
            $message = array("StatusCode" => 2, "Message" => "Permission Denied", "Class" => "error_popup");
            return $this->response->setJSON($message);
        }
    }

    function confirmation()
    {
        if (permission_access_error("Visa", "view_confirmation")) {
            $uri = service('uri');
            $ticketData = $uri->getSegment(3);
            $bookingId = json_decode(dev_decode($ticketData), true);
            if ($bookingId) {
                $VisaModel = new VisaModel();
                $bookingInfo = $VisaModel->getBookingConfirmationData($bookingId['BookingId'], $this->web_partner_id);
                $couponAmount = 0;
                $couponInfo = json_decode($bookingInfo['coupon_info'], true);
                if (isset($couponInfo['couponAmount']) && $bookingInfo['coupon_info'] != NULL && !empty($bookingInfo['coupon_info'])) {
                    $couponAmount = $couponInfo['couponAmount'];
                }
                $webpartnerBreakupArray = json_decode($bookingInfo['web_partner_fare_break_up'], true);
                $fareBreakupArray = json_decode($bookingInfo['booking_source'] == "Wl_b2b" ? $bookingInfo['agent_fare_break_up'] : $bookingInfo['customer_fare_break_up'], true);
                $markup = isset($webpartnerBreakupArray['WebPMarkUp']) ? $webpartnerBreakupArray['WebPMarkUp'] : 0;
                $discount = isset($webpartnerBreakupArray['WebPDiscount']) ? $webpartnerBreakupArray['WebPDiscount'] : 0;
                $addMarkupInTax = 0;
                $addMarkupInServiceCharge = 0;
                if (isset($webpartnerBreakupArray['WebPDisplayMarkup']) && $webpartnerBreakupArray['WebPDisplayMarkup'] == 'in_service_charge') {
                    $WebPDisplayMarkup = $webpartnerBreakupArray['WebPDisplayMarkup'];
                    $addMarkupInServiceCharge = $markup;
                } else {
                    $WebPDisplayMarkup = "in_tax";
                    $addMarkupInTax = $markup;
                }

                $TotalAmount = round_value($bookingInfo['booking_source'] == "Wl_b2b" ? $fareBreakupArray['TDS'] + $fareBreakupArray['OfferedPrice'] : $fareBreakupArray['OfferedPrice']);

                $GSTAmount = 0;
                if (isset($fareBreakupArray['GST']['TotalGSTAmount'])) {
                    $GSTAmount = $fareBreakupArray['GST']['TotalGSTAmount'];
                }

                $FareBreakUp = [
                    "FareBreakup" => [
                        "BaseFare" => ["Value" => round_value($fareBreakupArray['BasePrice'] + $couponAmount), "LabelText" => "Base Fare"],
                        "Taxes" => ["Value" => round_value($fareBreakupArray['Tax']), "LabelText" => "Taxes"],
                        "ServiceAndOtherCharge" => ["Value" => round_value($fareBreakupArray['ServiceCharges']), "LabelText" => "Other & Service Charges"],
                        "GST" => ["Value" => round_value($GSTAmount), "LabelText" => "GST"],

                    ],
                    "TotalAmount" => ["Value" => $TotalAmount, "LabelText" => "Total Amount"],
                    "BookingId" => $bookingInfo['id'],
                    "WebPMarkUp" => round_value($markup),
                    "WebPDiscount" => round_value($discount),
                    "WebPDisplayMarkup" => $WebPDisplayMarkup,
                ];

                if ($couponAmount > 0) {
                    $FareBreakUp['FareBreakup']['Promocode'] = ["Value" => round_value($couponAmount), "LabelText" => "Promocode Discount (-)"];
                }
                $BookingRefNumber = $bookingInfo['booking_ref_number'];
                $BookingStatus = $bookingInfo['booking_status'];
                $PaymentStatus = $bookingInfo['payment_status'];

                $ConfrimationData = array(
                    "ConfirmationBookingData" => $bookingInfo,
                    "bookingRefNumber" => $BookingRefNumber,
                    'FareBreakUpData' => $FareBreakUp,
                    "paymentStatus" => $PaymentStatus,
                    "bookingStatus" => $BookingStatus,
                    "visa_country" => $bookingInfo['visa_country'],
                    "visa_type" => $bookingInfo['visa_type']
                );
                $data = [
                    'title' => $this->title,
                    'booking' => $ConfrimationData,
                    'view' => "Visa\Views\booking\listing\booking-confirmation-page",
                ];
                return view('template/sidebar-layout', $data);
            } else {
                return $this->response->redirect(site_url('visa/error?errormessage=Request Not Allowed'));
            }
        } else {
            $message = array("StatusCode" => 2, "Message" => "Permission Denied", "Class" => "error_popup");
            return $this->response->setJSON($message);
        }
    }

    public function visa_booking_detail()
    {
        if (permission_access_error("Visa", "visa_booking_detail")) {
            $uri = service('uri');
             $bookingReferenceNumber = $uri->getSegment(3);
           
            $VisaModel = new VisaModel();
            $bookingInfo = $VisaModel->Visa_booking_detail($this->web_partner_id, $bookingReferenceNumber, $this->web_partner_details['id'], $this->web_partner_details['primary_user']);
        //    pr($bookingInfo);
        //     die;
            $amendment_list = $VisaModel->amendment_list($this->web_partner_id, $bookingInfo['id'], $bookingInfo['booking_source']);
            $webpartnerfareBreakupArray = json_decode($bookingInfo['web_partner_fare_break_up'], true);
            if ($bookingInfo['booking_source'] == "Wl_b2b") {
                $fareBreakupArray = json_decode($bookingInfo['agent_fare_break_up'], true);
            } else {
                $fareBreakupArray = json_decode($bookingInfo['customer_fare_break_up'], true);
            }
            $couponAmount = 0;
            $couponInfo = json_decode($bookingInfo['coupon_info'], true);
            if (isset($couponInfo['couponAmount']) && $bookingInfo['coupon_info'] != NULL && !empty($bookingInfo['coupon_info'])) {
                $couponAmount = $couponInfo['couponAmount'];
            }

            $markup = isset($webpartnerfareBreakupArray['WebPMarkUp']) ? $webpartnerfareBreakupArray['WebPMarkUp'] : 0;
            $discount = isset($webpartnerfareBreakupArray['WebPDiscount']) ? $webpartnerfareBreakupArray['WebPDiscount'] : 0;
            if (isset($webpartnerfareBreakupArray['WebPDisplayMarkup']) && $webpartnerfareBreakupArray['WebPDisplayMarkup'] == 'in_service_charge') {
                $WebPDisplayMarkup = $webpartnerfareBreakupArray['WebPDisplayMarkup'];
                $addMarkupInServiceCharge = $markup;
            } else {
                $WebPDisplayMarkup = "in_tax";
                $addMarkupInTax = $markup;
            }
            $TotalAmount = round_value($fareBreakupArray['OfferedPrice']);
            if ($bookingInfo['booking_source'] == "Wl_b2b") {
                $TotalAmount = round_value($fareBreakupArray['TDS'] + $fareBreakupArray['OfferedPrice']);
            }

            $FareBreakUp = array(
                "FareBreakup" => array(
                    "BaseFare" => array("Value" => round_value($fareBreakupArray['BasePrice'] + $couponAmount), "LabelText" => "Base Fare"),
                    "Taxes" => array("Value" => round_value($fareBreakupArray['Tax']), "LabelText" => "Taxes"),
                    "ServiceAndOtherCharge" => array("Value" => round_value($fareBreakupArray['ServiceCharges']), "LabelText" => "Service Charges"),
                    "CommEarned" => array("Value" => round_value($fareBreakupArray['AgentCommission'] + $fareBreakupArray['Discount']), "LabelText" => "Discount (-)"),
                    "TDS" => array("Value" => round_value($fareBreakupArray['TDS']), "LabelText" => "TDS (+)")
                ),
                "TotalAmount" => array("Value" => $TotalAmount, "LabelText" => "Total Amount"),
                "GSTDetails" => ($fareBreakupArray['GST']),
                "WebPMarkUp" => array("Value" => round_value($markup), "LabelText" => "Apply Mark Up"),
                "WebPDiscount" => array("Value" => round_value($discount), "LabelText" => "Apply Discount"),
                "WebPDisplayMarkup" => array("Value" => ucfirst(str_replace("_", " ", $WebPDisplayMarkup)), "LabelText" => "Apply Markup At"),
            );
            if ($couponAmount > 0) {
                $FareBreakUp['FareBreakup']['Promocode'] = array("Value" => round_value($couponAmount), "LabelText" => "Promocode Discount (-)");
            }

            $bookingInfo['FareBreakUp'] = $FareBreakUp;
            $data = [
                'title' => $this->title,
                'bookingDetail' => $bookingInfo,
                'amendment_list' => $amendment_list,
                'view' => "Visa\Views\booking\listing\Visa-booking-details",
            ];

            return view('template/sidebar-layout', $data);
        } else {
            $message = array("StatusCode" => 2, "Message" => "Permission Denied", "Class" => "error_popup");
            return $this->response->setJSON($message);
        }
    }


    public function amendment_lists()
    {
        //if (permission_access_error("Visa", "view_amendment_list")) {
        $AmendmentModel = new AmendmentModel();
        $bookingType = 'all';
        $source = '';
        $getData = $this->request->getGET();
        if ($this->request->getGet() && $this->request->getGet('key')) {
            $list = $AmendmentModel->search_data($getData, $this->web_partner_id, $this->web_partner_details['id'], $this->web_partner_details['primary_user'], $bookingType, $source);
        } else {
            $source = $this->request->getGET('source');
            if ($source == 'dashboard') {
                $source = 'dashboard';
            }
            $list = $AmendmentModel->amendment_list($this->web_partner_id, $this->web_partner_details['id'], $this->web_partner_details['primary_user'], $bookingType, $source);
        }
        $data = [
            'title' => $this->title,
            'view' => "Visa\Views/booking/amendment-list",
            "list" => $list,
            "search_bar_data" => $getData,
            'pager' => $AmendmentModel->pager,
        ];
        return view('template/sidebar-layout', $data);
        // } else {
        //     $message = array("StatusCode" => 2, "Message" => "Permission Denied", "Class" => "error_popup");
        //     return $this->response->setJSON($message);
        // }
    }

    public function amendments_details()
    {
        if (permission_access_error("Visa", "visa_amendment")) {
            $uri = service('uri');
            $amendment = $uri->getSegment(3);
            $amendmentId = dev_decode($amendment);
            $AmendmentModel = new AmendmentModel();
            $AmendmentDetail = $AmendmentModel->amendment_detail($this->web_partner_id, $amendmentId);
            $bookingReferenceNumber = $AmendmentDetail['booking_ref_number'];
            $VisaModel = new VisaModel();
            if ($amendmentId && $AmendmentDetail) {
                $BookingDetail = $VisaModel->Visa_booking_detail($this->web_partner_id, $bookingReferenceNumber, $this->web_partner_details['id'], $this->web_partner_details['primary_user']);
                $webpartnerBreakupArray = json_decode($BookingDetail['web_partner_fare_break_up'], true);
                if ($BookingDetail['booking_source'] == "Wl_b2b") {
                    $fareBreakupArray = json_decode($BookingDetail['agent_fare_break_up'], true);
                } else if ($BookingDetail['booking_source'] == "Wl_b2c") {
                    $fareBreakupArray = json_decode($BookingDetail['customer_fare_break_up'], true);
                }

                $markup = isset($webpartnerBreakupArray['WebPMarkUp']) ? $webpartnerBreakupArray['WebPMarkUp'] : 0;
                $discount = isset($webpartnerBreakupArray['WebPDiscount']) ? $webpartnerBreakupArray['WebPDiscount'] : 0;
                if (isset($webpartnerBreakupArray['WebPDisplayMarkup']) && $webpartnerBreakupArray['WebPDisplayMarkup'] == 'in_service_charge') {
                    $WebPDisplayMarkup = $webpartnerBreakupArray['WebPDisplayMarkup'];
                    $addMarkupInServiceCharge = $markup;
                } else {
                    $WebPDisplayMarkup = "in_tax";
                    $addMarkupInTax = $markup;
                }

                $couponAmount = 0;
                $couponInfo = json_decode($BookingDetail['coupon_info'], true);
                if (isset($couponInfo['couponAmount']) && $BookingDetail['coupon_info'] != NULL && !empty($BookingDetail['coupon_info'])) {
                    $couponAmount = $couponInfo['couponAmount'];
                }
                $TDS = 0;
                if (isset($fareBreakupArray['TDS'])) {
                    $TDS = $fareBreakupArray['TDS'];
                }
                $TotalAmount = round_value($fareBreakupArray['OfferedPrice']);
                if ($BookingDetail['booking_source'] == "Wl_b2b") {
                    $TotalAmount = round_value($fareBreakupArray['TDS'] + $fareBreakupArray['OfferedPrice']);
                }


                $FareBreakUp = array(
                    "FareBreakup" => array(
                        "BaseFare" => array("Value" => round_value($fareBreakupArray['BaseFare']) + $couponAmount, "LabelText" => "Base Fare"),
                        "Taxes" => array("Value" => round_value($fareBreakupArray['OtherCharges'] + $fareBreakupArray['Tax']), "LabelText" => "Taxes"),
                        "ServiceAndOtherCharge" => array("Value" => round_value($fareBreakupArray['ServiceCharges']), "LabelText" => "Service Charges"),
                        "CommEarned" => array("Value" => round_value($fareBreakupArray['AgentCommission'] + $fareBreakupArray['Discount']), "LabelText" => "Discount (-)"),
                        "TDS" => array("Value" => round_value($fareBreakupArray['TDS']), "LabelText" => "TDS (+)")
                    ),
                    "TotalAmount" => array("Value" => $TotalAmount, "LabelText" => "Total Amount"),
                    "GSTDetails" => ($fareBreakupArray['GST']),
                    "WebPMarkUp" => array("Value" => round_value($markup), "LabelText" => "Apply Mark Up"),
                    "WebPDiscount" => array("Value" => round_value($discount), "LabelText" => "Apply Discount"),
                    "WebPDisplayMarkup" => array("Value" => ucfirst(str_replace("_", " ", $WebPDisplayMarkup)), "LabelText" => "Apply Markup At"),
                );
                if ($couponAmount > 0) {
                    $FareBreakUp['FareBreakup']['Promocode'] = array("Value" => round_value($couponAmount), "LabelText" => "Promocode Discount (-)");
                }
                $BookingDetail['FareBreakUp'] = $FareBreakUp;
            }

            $data = [
                'title' => $this->title,
                'view' => "Visa\Views\booking\amendments-detail",
                "amendmentDetail" => $AmendmentDetail,
                "bookingDetail" => $BookingDetail,

            ];
            return view('template/sidebar-layout', $data);
        } else {
            $message = array("StatusCode" => 2, "Message" => "Permission Denied", "Class" => "error_popup");
            return $this->response->setJSON($message);
        }
    }


    function amendment_cancellation_charge()
    {
        //if (permission_access("Visa", "cancellation_charge")) {
        $data = $this->request->getPost();
        $validate = new Validation();
        $rules = $this->validate($validate->amendment_refund_validation);
        if (!$rules) {
            $message = ["StatusCode" => 2, "Message" => "Insufficient Refund Parameters", "Class" => "error_popup", "Reload" => "true"];
            $this->session->setFlashdata('Message', $message);
            return $this->response->setJSON($message);
        } else {
            $VisaModel = new VisaModel();
            $AmendmentModel = new AmendmentModel();
            $amendment_id = dev_decode($data['amendment_id']);
            $AmendmentDetail = $AmendmentModel->visa_amendment_detail_by_id($amendment_id, $this->web_partner_id);
            if ($AmendmentDetail) {
                $visa_booking_id = $AmendmentDetail['booking_ref_no'];
                if (isset($AmendmentDetail['wl_agent_id']) && $AmendmentDetail['wl_agent_id'] > 0) {
                    $tableName = "agent";
                    $user_id = $AmendmentDetail['wl_agent_id'];
                    $agentUserGstCode = $AmendmentModel->agent_user_gst_state_code($tableName, $user_id, $this->web_partner_id);
                } else {
                    $tableName = "customer";
                    $user_id = $AmendmentDetail['wl_customer_id'];
                    $agentUserGstCode = "";
                }

                $refundAmount = $data['refund'];
                $TDS = 0;
                $TDSReturn = 0;

                $TDSReturnidentifier = "no";

                if (isset($data['tdsreturn']) && $data['tdsreturn'] == "yes") {
                    $TDSReturnidentifier = "yes";
                    $TDSReturn = $TDS;
                }

                $GSTInfo = gst_calculate("Visa", $agentUserGstCode, super_admin_website_setting['gst_state_code'], $data['service_charge']);

                $refundAmountTotal = round_value(($refundAmount + $TDSReturn));
                $RefundChargeDetails = [
                    "Charge" => $data['charge'],
                    "ServiceCharge" => $data['service_charge'],
                    "Refund" => $refundAmountTotal,
                    "GST" => $GSTInfo,
                    "TDSReturnIdentifier" => $TDSReturnidentifier,
                ];

                $updateData = [];
                if ($refundAmountTotal > 0) {
                    $updateData = [
                        "amendment_charges" => json_encode($RefundChargeDetails),
                        "amendment_type" => $AmendmentDetail['amendment_type'],
                        "amendment_id" => $amendment_id,
                    ];

                    $update = $VisaModel->updateUserData("visa_booking_list", ["id" => $visa_booking_id, "web_partner_id" => $this->web_partner_id], $updateData);

                    $updateAmendmentData = [
                        'agent_staff_id' => $this->user_id,
                        'refund_status' => "Open",
                        'refund_amount' => $refundAmountTotal,
                        'refund_date' => create_date(),
                        'modified' => create_date(),
                    ];

                    $update = $VisaModel->updateUserData("visa_amendment", ["id" => $amendment_id, "web_partner_id" => $this->web_partner_id], $updateAmendmentData);

                    $message = ["StatusCode" => 0, "Message" => "Refund is Opened", "Class" => "success_popup", "Reload" => "true"];
                } else {
                    $message = ["StatusCode" => 2, "Message" => "Please check refund amount value is negative", "Class" => "error_popup", "Reload" => "true"];
                }
            } else {
                $message = ["StatusCode" => 2, "Message" => "Insufficient Refund Parameters", "Class" => "error_popup", "Reload" => "true"];
            }

            $this->session->setFlashdata('Message', $message);
            return $this->response->setJSON($message);
        }
        // } else {
        //     $message = array("StatusCode" => 2, "Message" => "Permission Denied", "Class" => "error_popup");
        //     return $this->response->setJSON($message);
        // }
    }


    public function amendmentStatusChange()
    {
        //if (permission_access("Visa", "amendment_status_change")) {
        $validate = new Validation();
        $rules = $this->validate($validate->amendment_status);
        if (!$rules) {
            $errors = $this->validator->getErrors();
            $data_validation = ["StatusCode" => 1, "ErrorMessage" => array_filter($errors)];
            return $this->response->setJSON($data_validation);
        }
        $data = $this->request->getPost();
        $AmendmentModel = new AmendmentModel();
        $VisaModel = new VisaModel();
        $amendment_id = dev_decode($data['amendment_id']);

        if ($data['status'] == "approved") {
            $AmendmentDetail = $AmendmentModel->amendment_detail($this->web_partner_id, $amendment_id);
            if ($AmendmentDetail['amendment_type'] == "cancellation") {
                $booking_id = $AmendmentDetail['booking_ref_no'];
                if ($data['status'] == 'approved') {
                    $VisaModel->updateUserData("visa_booking_list", ["id" => $booking_id, "web_partner_id" => $this->web_partner_id], ["booking_status" => 'Cancelled']);
                }
            }
        }
        $updateData = [
            'amendment_status' => $data['status'],
            'remark_from_web_partner' => $data['admin_remark'],
            'agent_staff_id' => $this->user_id,
            'modified' => create_date()
        ];
        $update = $VisaModel->updateUserData("visa_amendment", ["id" => $amendment_id, "web_partner_id" => $this->web_partner_id], $updateData);
        if ($update) {
            $message = ["StatusCode" => 0, "Message" => "Amendment status successfully changed", "Class" => "success_popup", "Reload" => true];
        } else {
            $message = ["StatusCode" => 2, "Message" => "Amendment status not changed", "Class" => "error_popup", "Reload" => true];
        }
        $this->session->setFlashdata('Message', $message);
        return $this->response->setJSON($message);
        // } else {
        //     $message = array("StatusCode" => 2, "Message" => "Permission Denied", "Class" => "error_popup");
        //     return $this->response->setJSON($message);
        // }
    }


    function refund_lists()
    {
        if (permission_access_error("Visa", "visa_refund")) {
            $AmendmentModel = new AmendmentModel();
            $bookingType = 'all';
            $source = '';
            $getData = $this->request->getGET();
            if (isset($getData['key'])) {
                $list = $AmendmentModel->search_refund_list($getData, $this->web_partner_id, $this->web_partner_details['id'], $this->web_partner_details['primary_user'], $bookingType, $source);
            } else {
                $source = $this->request->getGET('source');
                if ($source == 'dashboard') {
                    $source = 'dashboard';
                }

                if (isset($getData['bookingtype'])) {
                    $bookingType = $getData['bookingtype'];
                }
                $list = $AmendmentModel->refund_list($this->web_partner_id, $this->web_partner_details['id'], $this->web_partner_details['primary_user'], $bookingType, $source);
            }
            /*  pr($list);exit; */
            $data = [
                'title' => $this->title,
                'view' => "Visa\Views/booking/refund-list",
                "list" => $list,
                "search_bar_data" => $getData,
                'pager' => $AmendmentModel->pager,
            ];
            return view('template/sidebar-layout', $data);
        } else {
            $message = array("StatusCode" => 2, "Message" => "Permission Denied", "Class" => "error_popup");
            return $this->response->setJSON($message);
        }
    }


    public function refund_close()
    {
        //if (permission_access("Visa", "refund_close")) {
        $validate = new Validation();
        $rules = $this->validate($validate->refund_close_status);
        if (!$rules) {
            $errors = $this->validator->getErrors();
            $data_validation = array("StatusCode" => 1, "ErrorMessage" => array_filter($errors));
            return $this->response->setJSON($data_validation);
        } else {
            $data = $this->request->getPost();

            $VisaModel = new VisaModel();
            $CommonModel = new CommonModel();
            $AmendmentModel = new AmendmentModel();
            $amendment_id = dev_decode($data['amendment_id']);
            $AmendmentDetail = $AmendmentModel->visa_amendment_detail_by_id($amendment_id, $this->web_partner_id);

            if ($AmendmentDetail) {
                $Visa_booking_id = $AmendmentDetail['booking_ref_no'];
                $whereArray = array('id' => $Visa_booking_id, 'web_partner_id' => $AmendmentDetail['web_partner_id']);
                $booking_list = $VisaModel->getData('visa_booking_list', $whereArray, 'id,visa_country,visa_type,date_of_journey,processing_time,booking_ref_number,agent_fare_break_up,customer_fare_break_up,amendment_charges');

                $web_partner_id = $AmendmentDetail['web_partner_id'];
                if (isset($AmendmentDetail['wl_agent_id']) && $AmendmentDetail['wl_agent_id'] > 0) {
                    $AccounttableName = "agent_account_log";
                    $fareBreakupArray = json_decode($booking_list['agent_fare_break_up'], true);
                    $user_id = $AmendmentDetail['wl_agent_id'];
                    $key = "wl_agent_id";
                    $CompanyGSTInfo = $CommonModel->getDataRowType('agent', array("id" => $user_id, 'web_partner_id' => $this->web_partner_id), "gst_state_code");
                } else {
                    $AccounttableName = "customer_account_log";
                    $fareBreakupArray = json_decode($booking_list['customer_fare_break_up'], true);
                    $key = "customer_id";
                    $user_id = $AmendmentDetail['wl_customer_id'];
                    $CompanyGSTInfo = "";
                }

                $offeredfare = $fareBreakupArray['OfferedPrice'];

                $hotelBookingAccountinfo = $VisaModel->getDataArray($AccounttableName, array("booking_ref_no" => $Visa_booking_id, 'service' => "visa", "action_type" => "booking", 'transaction_type' => "debit", 'web_partner_id' => $AmendmentDetail['web_partner_id']), $singalRecord = 1, $whereApply = 1);



                if (!empty($hotelBookingAccountinfo)) {
                    $amendmentChargesArray = json_decode($booking_list['amendment_charges'], true);
                    $TDSReturn = 0;
                    if (isset($amendmentChargesArray['TDSReturnIdentifier']) && $amendmentChargesArray['TDSReturnIdentifier'] == "yes") {
                        $TDSReturn = $fareBreakupArray['TDS'];
                    }
                    $refundAmount = $offeredfare - $amendmentChargesArray['Charge'] - $amendmentChargesArray['ServiceCharge'] - $amendmentChargesArray['GST']['TotalGSTAmount'] + $TDSReturn;

                    $extra_param = json_decode($hotelBookingAccountinfo['extra_param'], true);

                    /* invoice  Number Generate Number */
                    $ServiceCharges = intval($amendmentChargesArray['ServiceCharge']);
                    $checkTaxableInvoce = checkTaxableNonTaxableINV($ServiceCharges, $CompanyGSTInfo, 'visa', 'RFND');

                    $INVPrifix = getTaxableNonTaxableINVSuffix('RFND', $checkTaxableInvoce, 'visa');
                    $financialYear = get_financial_year();
                    $whereCondition['service'] = 'visa';
                    $whereCondition['invoice_type'] = 'RFND';
                    $whereCondition['financial_year'] = $financialYear;
                    $otherParameter['financialYear'] = $financialYear;
                    $otherParameter['service'] = 'visa';
                    $otherParameter['invoice_type'] = 'RFND';
                    $otherParameter['INVPrifix'] = $INVPrifix;
                    $otherParameter['web_partner_id'] = $this->web_partner_id;
                    $otherParameter['checkTaxableInvoce'] = $checkTaxableInvoce;

                    $generateInvoiceData = $CommonModel->getInvoiceSuffixData($whereCondition, $otherParameter);
                    $InvoiceInfoData = generateInvoiceNumber($generateInvoiceData);
                    $InvoiceNumber = $InvoiceInfoData['InvoiceNumber'];
                    $InvoiceupdateData = $InvoiceInfoData['updateData'];
                    $VisaModel->updateUserData('invoice_suffix_list', $whereCondition, $InvoiceupdateData);

                    /* invoice  Number Generate Number */

                    if (empty($extra_param)) {

                        $extra_param = array();
                    }

                    $web_partner_id = $hotelBookingAccountinfo['web_partner_id'];
                    $topupAmount = round_value($refundAmount);
                    $WebPartnerAccountLogData['web_partner_id'] = $web_partner_id;
                    $WebPartnerAccountLogData['user_id'] = $this->user_id;
                    $WebPartnerAccountLogData[$key] = $user_id;
                    $WebPartnerAccountLogData['created'] = create_date();
                    $WebPartnerAccountLogData['transaction_type'] = "credit";
                    $WebPartnerAccountLogData['action_type'] = "refund";
                    $WebPartnerAccountLogData['role'] = 'web_partner';
                    $WebPartnerAccountLogData['extra_param'] = json_encode($extra_param);
                    $WebPartnerAccountLogData['service'] = "visa";
                    $WebPartnerAccountLogData['invoice_number'] = $InvoiceNumber;
                    $WebPartnerAccountLogData['acc_ref_number'] = mt_rand(100000, 999999);
                    $available_balance = $AmendmentModel->agent_user_available_balance($AccounttableName, $key, $user_id, $web_partner_id);
                    if (!$available_balance) {
                        $available_balance['balance'] = 0;
                    }
                    $WebPartnerAccountLogData['balance'] = round_value(($available_balance['balance'] + $topupAmount));
                    $WebPartnerAccountLogData['credit'] = $topupAmount;
                    $pax_detail = $VisaModel->getData('visa_booking_travelers', ["visa_booking_id" => $AmendmentDetail['booking_ref_no'], 'lead_pax' => 1], "first_name,last_name");
                    $first_name = isset($pax_detail['first_name']) ? $pax_detail['first_name'] : '';
                    $last_name = isset($pax_detail['last_name']) ? $pax_detail['last_name'] : '';
                    $serviceLog['PaxName'] = $first_name . " " . $last_name;
                    $serviceLog['Sector'] = $booking_list['visa_country'] . "-" . $booking_list['visa_type'] . "-" . $booking_list["processing_time"];
                    $serviceLog['TravelDate'] = isset($booking_list['date_of_journey']) ? $booking_list['date_of_journey'] : '';

                    $WebPartnerAccountLogData['service_log'] = json_encode($serviceLog);

                    $WebPartnerAccountLogData['remark'] = "Refund for Reference No - " . $booking_list['booking_ref_number'] . " Remark " . $AmendmentDetail['remark_from_user'] . " Remark " . $AmendmentDetail['remark_from_web_partner'] . " Remark " . $data['account_remark'];
                    $WebPartnerAccountLogData['booking_ref_no'] = $Visa_booking_id;
                    $added_data_id = $VisaModel->insertData($AccounttableName, $WebPartnerAccountLogData);
                    $WebPatnerAccountLogDataUpdate['acc_ref_number'] = reference_number($added_data_id);

                    $VisaModel->updateUserData($AccounttableName, array("id" => $added_data_id), $WebPatnerAccountLogDataUpdate);
                    $VisaModel->updateUserData("visa_booking_list", array("id" => $Visa_booking_id), array("refund_account_id" => $added_data_id));


                    $updateData['refund_status'] = "Close";
                    $updateData['account_remark'] = $data['account_remark'];
                    $updateData['agent_staff_id'] = $this->user_id;
                    $updateData['refund_close_date'] = create_date();
                    $update = $AmendmentModel->updateData($updateData, array("id" => $amendment_id));
                    if ($update) {
                        $message = array("StatusCode" => 0, "Message" => "Refund  has been successfully done", "Class" => "success_popup", "Reload" => "true");
                    } else {
                        $message = array("StatusCode" => 2, "Message" => "Refund  has not been successfully done", "Class" => "error_popup", "Reload" => "true");
                    }
                } else {
                    $message = array("StatusCode" => 2, "Message" => "Refund unable to process,Booking amount not deducted", "Class" => "error_popup", "Reload" => "true");
                }
            } else {
                $message = array("StatusCode" => 2, "Message" => "In Sufficient Refund Parameter ", "Class" => "error_popup", "Reload" => "true");
            }
            $this->session->setFlashdata('Message', $message);
            return $this->response->setJSON($message);
        }
        // } else {
        //     $message = array("StatusCode" => 2, "Message" => "Permission Denied", "Class" => "error_popup");
        //     return $this->response->setJSON($message);
        // }
    }

    function getCreditNote()
    {
        $VisaBookingModel = new VisaModel();
        $getData = $this->request->getPOST();
        if (!$this->request->isAJAX()) {
            $getVoucherInvioceType = array("PrintVoucher" => "Voucher", "AgencyInvoice" => "AgencyInvoice", "CustomerInvoice" => "CustomerInvoice");
            $getData = $this->request->getGet();
            $bookingRefNumber = $getData['booking_ref_number'];
            $bookingInfo = array();
            if ($bookingRefNumber) {
                $whereClauseBookingCheck = array("booking_ref_number" => $bookingRefNumber);
                $bookingInfo = $VisaBookingModel->getData("visa_booking_list", $whereClauseBookingCheck, "*");
                if ($bookingInfo) {
                    $TicketViewRequest = array(
                        "BookingId" => isset($bookingInfo['id']) ? $bookingInfo['id'] : "",
                        "SearchTokenId" => isset($bookingInfo['tts_search_token']) ? $bookingInfo['tts_search_token'] : "",
                        "HtmlType" => "Ticket",
                        "UserType" => "WebPartner",
                        "ViewService" => "View",
                        "WithAgencyDetail" => "1",
                        "ViewSize" => "",
                    );
                    $url = $this->Services . 'generate-credit-note';

                    $response = RequestWithoutAuth($TicketViewRequest, $url);

                    // echo $url; die;
                    $data = [
                        'title' => $this->title,
                        'view' => "Visa\Views\booking\listing\print_ticket",
                        'data' => $response['Result']['Html'],
                    ];
                    return view('template/sidebar-layout', $data);
                } else {
                    return $this->response->redirect(site_url('visa/error?errormessage=Request Not Allowed'));
                }
            } else {
                return $this->response->redirect(site_url('visa/error?errormessage=Request Not Allowed'));
            }
        }
    }

    function error()
    {
        $error = $this->request->getGET('errormessage');
        return view('template/custom-error-layout', ['error_message' => $error]);
    }
}
