<?php

namespace Modules\Pages\Controllers;

use App\Modules\Pages\Models\PagesModel;
use App\Controllers\BaseController;
use Modules\Pages\Config\Validation;


class Pages extends BaseController
{
    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);

        $this->title = "Pages";
        $this->folder_name = 'pagesimage';
        if (isset(admin_cookie_data()['admin_user_details'])) {
            $admin_cookie_data = admin_cookie_data();
            $this->web_partner_id = $admin_cookie_data['admin_user_details']['web_partner_id'];
            $this->web_partner_details = $admin_cookie_data['admin_user_details'];
            $this->admin_comapny_detail = $admin_cookie_data['admin_comapny_detail'];
            $this->user_id = $admin_cookie_data['admin_user_details']['id'];
        }


        if (permission_access_error("Page", "Page_Module")) {
        }
    }

    public function index()
    {
        $PagesModel = new PagesModel();
        if ($this->request->getGet() && $this->request->getGet('key')) {
            $lists = $PagesModel->search_data($this->request->getGet(), $this->web_partner_id);
        } else {
            $lists = $PagesModel->pages_list($this->web_partner_id);
        }
        $data = [
            'title' => $this->title,
            'list' => $lists,
            'view' => "Pages\Views\pages-list",
            'pager' => $PagesModel->pager,
            'search_bar_data' => $this->request->getGet(),
        ];
        return view('template/sidebar-layout', $data);
    }

    public function add_pages_view()
    {

        if (permission_access_error("Page", "add_page")) {
            $data = [
                'title' => $this->title,
                'view' => "Pages\Views\add-pages",
            ];
            return view('template/sidebar-layout', $data);
        }
    }

    public function add_pages()
    {

        if (permission_access("Page", "add_page")) {

            $validate = new Validation();
            $rules = $this->validate($validate->pages_validation);
            if (!$rules) {
                $errors = $this->validator->getErrors();
                $data_validation = array("StatusCode" => 1, "ErrorMessage" => array_filter($errors));
                return $this->response->setJSON($data_validation);
            } else {
                $PagesModel = new PagesModel();
                $data = $this->request->getPost();


                $value = $data['slug_url'];
                $existingValue = $PagesModel->CheckUniqueSlug($value, $this->web_partner_id);
                if ($existingValue) {
                    $data_validation = array("StatusCode" => 1, "ErrorMessage" => ["slug_url" => " Page slug already exists"]);
                    return $this->response->setJSON($data_validation);
                }
                #use getFile() for single image or getFiles() for multiple image

                $field_name = 'banner_image';
                $file = $this->request->getFile($field_name);
                $resizeDim = array('width' => 360, 'height' => 200);
                $image_upload = image_upload($file, $field_name, $this->folder_name, $resizeDim);

                if ($image_upload['status_code'] == 0) {

                    $QUESTION = $data['faq_question'];
                    $answer = $data['faq_answer'];
                    $faq = [];

                    if (!empty($QUESTION) && !empty($answer) && is_array($QUESTION) && is_array($answer)) {
                        $count = min(count($QUESTION), count($answer));

                        for ($i = 0; $i < $count; $i++) {
                            if (!empty($QUESTION[$i]) && !empty($answer[$i])) {
                                $faq[] = [
                                    'question' => trim($QUESTION[$i]),
                                    'answer' => trim($answer[$i])
                                ];
                            }
                        }
                    }

                    $data['faq_question_answer'] = json_encode($faq);
                    $data['feature_content1'] = json_encode($data['feature_content1']);
                    unset($data['faq_question'], $data['faq_answer'], $data['submit_type']);
                    $data['created'] = create_date();
                    $data['web_partner_id'] = $this->web_partner_id;
                    $data['banner_image'] = $image_upload['file_name'];

                    $added_data = $PagesModel->insert($data);
                    if ($added_data) {
                        $message = array("StatusCode" => 0, "Message" => "Page Successfully added", "Class" => "success_popup", "Reload" => "true");
                    } else {
                        $message = array("StatusCode" => 2, "Message" => "Page not  added", "Class" => "error_popup", "Reload" => "true");
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


    public function edit_pages_view()
    {

        if (permission_access_error("Page", "edit_page")) {
            $page_id = dev_decode($this->request->uri->getSegment(3));
            $PagesModel = new PagesModel();
            $data = [
                'title' => $this->title,
                'id' => $page_id,
                'details' => $PagesModel->pages_list_details($page_id, $this->web_partner_id),
                'view' => 'Pages\Views\edit_pages'
            ];
            return view('template/sidebar-layout', $data);
        }
    }


    public function edit_pages()
    {
        if (permission_access("Page", "edit_page")) {
            $id = dev_decode($this->request->uri->getSegment(3));
            $validate = new Validation();
            $field_name = 'banner_image';
            $banner_images = $this->request->getFile($field_name);
            if ($banner_images->getName() == '') {
                unset($validate->pages_validation[$field_name]);
            }
            $rules = $this->validate($validate->pages_validation);
            if (!$rules) {
                $errors = $this->validator->getErrors();
                $data_validation = array("StatusCode" => 1, "ErrorMessage" => array_filter($errors));
                return $this->response->setJSON($data_validation);
            } else {
                $PagesModel = new PagesModel();
                $data = $this->request->getPost();

                $previous_data = $PagesModel->pages_list_details($id, $this->web_partner_id);

                if ($previous_data['slug_url'] != $data['slug_url']) {
                    $value = $data['slug_url'];
                    $existingValue = $PagesModel->CheckUniqueSlug($value, $this->web_partner_id);
                    if ($existingValue) {
                        $data_validation = array("StatusCode" => 1, "ErrorMessage" => ["slug_url" => "Page slug already exists"]);
                        return $this->response->setJSON($data_validation);
                    }
                }
                $file = $this->request->getFile($field_name);
                if ($file->getName() != '') {
                    $resizeDim = array('width' => 360, 'height' => 200);
                    $image_upload = image_upload($file, $field_name, $this->folder_name, $resizeDim);
                    if ($image_upload['status_code'] == 0) {

                        if ($previous_data[$field_name]) {
                            if (file_exists(FCPATH . "../uploads/$this->folder_name/" . $previous_data[$field_name])) {
                                unlink(FCPATH . "../uploads/$this->folder_name/" . $previous_data[$field_name]);
                                unlink(FCPATH . "../uploads/$this->folder_name/thumbnail/" . $previous_data[$field_name]);
                            }
                        }
                        $faq = [];
                        if (
                            !empty($data['faq_question']) && !empty($data['faq_answer']) &&
                            is_array($data['faq_question']) && is_array($data['faq_answer'])
                        ) {

                            $count = min(count($data['faq_question']), count($data['faq_answer']));

                            for ($i = 0; $i < $count; $i++) {
                                if (!empty($data['faq_question'][$i]) && !empty($data['faq_answer'][$i])) {
                                    $faq[] = [
                                        'question' => trim($data['faq_question'][$i]),
                                        'answer' => trim($data['faq_answer'][$i])
                                    ];
                                }
                            }
                        }

                        $data['faq_question_answer'] = json_encode($faq);
                        unset($data['faq_question'], $data['faq_answer']);
                       // $data['feature_content1'] = json_encode($data['feature_content1']);
                        $data['modified'] = create_date();
                        $data[$field_name] = $image_upload['file_name'];
                        $added_data = $PagesModel->where(["id" => $id, "web_partner_id" => $this->web_partner_id])->set($data)->update();

                        if ($added_data) {
                            $message = array("StatusCode" => 0, "Message" => "Blog Successfully Edit", "Class" => "success_popup", "Reload" => "true");
                        } else {
                            $message = array("StatusCode" => 2, "Message" => "Blog not  Edit", "Class" => "error_popup", "Reload" => "true");
                        }
                    } else {
                        $message = array("StatusCode" => 2, "Message" => $image_upload['message'], "Class" => "error_popup", "Reload" => "true");
                    }
                } else {
                    $faq = [];
                    if (
                        !empty($data['faq_question']) && !empty($data['faq_answer']) &&
                        is_array($data['faq_question']) && is_array($data['faq_answer'])
                    ) {

                        $count = min(count($data['faq_question']), count($data['faq_answer']));

                        for ($i = 0; $i < $count; $i++) {
                            if (!empty($data['faq_question'][$i]) && !empty($data['faq_answer'][$i])) {
                                $faq[] = [
                                    'question' => trim($data['faq_question'][$i]),
                                    'answer' => trim($data['faq_answer'][$i])
                                ];
                            }
                        }
                    }

                    $data['faq_question_answer'] = json_encode($faq);
                    $data['feature_content1'] = json_encode($data['feature_content1']);
                    unset($data['faq_question'], $data['faq_answer']);
                    $data['modified'] = create_date();
                    $added_data = $PagesModel->where(["id" => $id, "web_partner_id" => $this->web_partner_id])->set($data)->update();
                    if ($added_data) {
                        $message = array("StatusCode" => 0, "Message" => "Page Successfully updated", "Class" => "success_popup", "Reload" => "true");
                    } else {
                        $message = array("StatusCode" => 2, "Message" => "Page not  updated", "Class" => "error_popup", "Reload" => "true");
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


    public function remove_pages()
    {

        if (permission_access("Page", "delete_page")) {
            $PagesModel = new PagesModel();
            $ids = $this->request->getPost('checklist');

            $field_name = 'banner_image';

            foreach ($ids as $id) {

                $blog_details = $PagesModel->delete_image($id, $this->web_partner_id);

                if ($blog_details[$field_name]) {
                    if (file_exists(FCPATH . "../uploads/$this->folder_name/" . $blog_details[$field_name])) {
                        unlink(FCPATH . "../uploads/$this->folder_name/" . $blog_details[$field_name]);
                        unlink(FCPATH . "../uploads/$this->folder_name/thumbnail/" . $blog_details[$field_name]);
                    }
                }
                $blog_delete = $PagesModel->remove_pages($id, $this->web_partner_id);
            }
            if ($blog_delete) {
                $message = array("StatusCode" => 0, "Message" => "Pages Successfully  Deleted", "Class" => "success_popup", "Reload" => "true");
            } else {
                $message = array("StatusCode" => 2, "Message" => "Pages  not Deleted", "Class" => "error_popup", "Reload" => "true");
            }
            $this->session->setFlashdata('Message', $message);
            return $this->response->setJSON($message);
        } else {
            $message = array("StatusCode" => 2, "Message" => "Permission Denied", "Class" => "error_popup");
            return $this->response->setJSON($message);
        }
    }


    public function pages_status_change()
    {
        if (permission_access("Page", "change_status")) {
            $validate = new Validation();
            $rules = $this->validate($validate->page_status);
            if (!$rules) {
                $errors = $this->validator->getErrors();
                $data_validation = array("StatusCode" => 1, "ErrorMessage" => array_filter($errors));
                return $this->response->setJSON($data_validation);
            } else {
                $PagesModel = new PagesModel();
                $ids = $this->request->getPost('checkedvalue');
                $data['status'] = $this->request->getPost('status');
                $data['modified'] = create_date();
                $update = $PagesModel->pages_status_change($ids, $data, $this->web_partner_id);

                if ($update) {
                    $message = array("StatusCode" => 0, "Message" => "Page status  successfully changed", "Class" => "success_popup", "Reload" => "true");
                } else {
                    $message = array("StatusCode" => 2, "Message" => "Page status not changed successfully", "Class" => "error_popup", "Reload" => "true");
                }
                $this->session->setFlashdata('Message', $message);
                return $this->response->setJSON($message);
            }
        } else {
            $message = array("StatusCode" => 2, "Message" => "Permission Denied", "Class" => "error_popup");
            return $this->response->setJSON($message);
        }
    }

    public function menu_list()
    {
        $PagesModel = new PagesModel();
        $menu_selected_list = $PagesModel->menu_selected_list($this->web_partner_id);
        if ($this->request->getMethod() == 'post') {
            $data = $this->request->getPost();
            $menu_type_id = $data['menu_type'];
            $menu_selected_list = $PagesModel->menu_selected_list_by_id($menu_type_id, $this->web_partner_id);
            $update_data = [
                'is_selected' => 1
            ];
            $added_data = $PagesModel->updateUserData("pages_menu_list", $menu_type_id, $update_data, $this->web_partner_id);
        }
        $menu_type_list = $PagesModel->menu_type_list($this->web_partner_id);
        $data = [
            'title' => 'Menu Management',
            'page_list' => $PagesModel->menu_page_list($this->web_partner_id),
            'menu_type_list' => $menu_type_list,
            'menu_selected_list' => $menu_selected_list,
            'menu_type_id' => $PagesModel->selected_menu_id($this->web_partner_id),
            'view' => "Pages\Views\menu-list"
        ];
        return view('template/sidebar-layout', $data);
    }

    public function update_menu()
    {

        if (permission_access_error("Page", "add_menu")) {
            $PagesModel = new PagesModel();
            if ($this->request->getMethod() == 'post') {
                $data = $this->request->getPost();
                $menu_type_id = $data['menu_type_id'];
                $get_data = $PagesModel->remove_menu_list_by_id($menu_type_id, $this->web_partner_id);
                $update_data = [];
                $page_content = null;
                if (isset($data['pages'])) {
                    $page_content = implode(',', $data['pages']);
                }
                $update_data = [
                    'page_content' => $page_content,
                    'is_selected' => 1

                ];
                $added_data = $PagesModel->updateUserData("pages_menu_list", $menu_type_id, $update_data, $this->web_partner_id);

                return redirect()->to(site_url('/pages/menu-list'));
            }
        }
    }

    public function remove_menu()
    {
        if (permission_access_error("Page", "remove_menu")) {
            $PagesModel = new PagesModel();
            if ($this->request->getMethod() == 'post') {
                $data = $this->request->getPost();
                $menu_type_id = $data['menu_type_id'];
                $get_data = $PagesModel->remove_menu_list_by_id($menu_type_id, $this->web_partner_id);

                $sort_order = null;
                $remove_data = [];
                if (isset($data['pages_remove'])) {
                    $remove_data = $data['pages_remove'];
                }
                $get_data = explode(',', $get_data['page_content']);
                $page_content = array_diff($get_data, $remove_data);
                $page_content = implode(',', $page_content);
                $update_data = [
                    'page_content' => $page_content,
                    'is_selected' => 1,
                ];
                $added_data = $PagesModel->updateUserData("pages_menu_list", $menu_type_id, $update_data, $this->web_partner_id);

                return redirect()->to(site_url('/pages/menu-list'));
            }
        }
    }

    public function menu_labels()
    {
        if (permission_access_error("Page", "view_menu_label")) {
            $PagesModel = new PagesModel();
            $menu_selected_list = $PagesModel->selected_menu_labels($this->web_partner_id);
            if (empty($menu_selected_list)) {
                $menu_selected_list = $PagesModel->selected_menu_labels_superadmin();
                $WebPartnerMenu = array();
                if ($menu_selected_list) {
                    foreach ($menu_selected_list as $menu) {
                        $menu['web_partner_id'] = $this->web_partner_id;
                        array_push($WebPartnerMenu, $menu);
                    }
                    $PagesModel->insertBatchData('pages_menu_list', $WebPartnerMenu);
                }
                $menu_selected_list = $PagesModel->selected_menu_labels($this->web_partner_id);
            }
            $data = [
                'title' => $this->title,
                'details' => $menu_selected_list,
            ];
            $details = view('Modules\Pages\Views\menu-labels', $data);
            $data = array("StatusCode" => 0, "Message" => $details, 'class' => 'success_popup', "Reload" => "false");
            return $this->response->setJSON($data);
        }
    }

    public function edit_menu_labels()
    {

        if (permission_access("Page", "update_menu_label")) {
            $data = $this->request->getPost();
            $validate = new Validation();
            $validationConfigArray = $validate->menu_name_validation($data);
            $this->validation->setRules($validationConfigArray);
            $rules = $this->validation->run($data);
            if (!$rules) {
                $errors = $this->validation->getErrors();
                $data_validation = array("StatusCode" => 1, "ErrorMessage" => array_filter($errors));
                return $this->response->setJSON($data_validation);
            } else {

                $PagesModel = new PagesModel();

                foreach ($data['menu_name'] as $id => $menu) {
                    $update_data = [
                        'menu_name' => $menu,
                    ];

                    $added_data = $PagesModel->updateMenuLabelData("pages_menu_list", $id, $update_data, $this->web_partner_id);
                }

                if ($added_data) {
                    $message = array("StatusCode" => 0, "Message" => "Page Successfully added", "Class" => "success_popup", "Reload" => "true");
                } else {
                    $message = array("StatusCode" => 2, "Message" => "Page not  added", "Class" => "error_popup", "Reload" => "true");
                }

                $this->session->setFlashdata('Message', $message);
                return $this->response->setJSON($message);
            }
        } else {
            $message = array("StatusCode" => 2, "Message" => "Permission Denied", "Class" => "error_popup");
            return $this->response->setJSON($message);
        }
    }
    public function sortMenu()
    {
        $PagesModel = new PagesModel();
        if ($this->request->getMethod() == 'post') {
            $data = $this->request->getPost();
            $menu_type_id = $data['menuid'];
            $update_data = [];
            $sortedmenuIDs = isset($data['sortedmenuIDs']) ? $data['sortedmenuIDs'] : array();
            $sortedmenuIDsString = implode(',', $sortedmenuIDs);
            $update_data = [
                'page_content' => $sortedmenuIDsString,
                'is_selected' => 1,
            ];
            $added_data = $PagesModel->updateUserData("pages_menu_list", $menu_type_id, $update_data, $this->web_partner_id);
            $message = array("StatusCode" => 0, "Message" => "Menu Sorted", "Class" => "success_popup", "Reload" => "false");
            return $this->response->setJSON($message);
        }
    }
}
