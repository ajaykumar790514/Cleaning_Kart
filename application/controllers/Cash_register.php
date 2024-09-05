<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Cash_register extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->isLoggedIn();
        // $this->check_role_menu();
    }

    public function isLoggedIn()
    {
        $is_logged_in = $this->session->userdata('shop_logged_in');
        if (!isset($is_logged_in) || $is_logged_in !== TRUE) {
            redirect(base_url());
            exit;
        }
    }
    public function check_role_menu()
    {
        $shop_role_id = $_SESSION['shop_role_id'];
        $uri = $this->uri->segment(1);
        $role_menus = $this->admin_model->all_role_menu_data($shop_role_id);
        $url_array = array();
        if (!empty($role_menus)) {
            foreach ($role_menus as $menus) {
                array_push($url_array, $menus->url);
            }
            if (!in_array($uri, $url_array)) {
                redirect(base_url());
            }
        } else {
            redirect(base_url());
            exit;
        }
    }

    public function header_and_footer($page, $data)
    {
        $shop_id     = $_SESSION['user_data']['id'];
        $shop_role_id     = $_SESSION['user_data']['role_id'];
        $data['shop_menus'] = $this->admin_model->get_role_menu_data($shop_role_id);
        $data['all_menus'] = $this->admin_model->get_data1('tb_admin_menu', 'status', '1');
        $shop_details = $this->shops_model->get_shop_data($shop_id);
        $template_data = array(
            'menu' => $this->load->view('template/menu', $data, TRUE),
            'main_body_data' => $this->load->view($page, $data, TRUE),
            'shop_photo' => $shop_details->logo
        );
        $this->load->view('template/main_template', $template_data);
    }
    public function index()
    {
        $data['title'] = 'Master';
        $menu_id = $this->uri->segment(2);
        $data['menu_id'] = $menu_id;
        $role_id = $_SESSION['shop_role_id'];
        $data['sub_menus'] = $this->admin_model->get_submenu_data($menu_id, $role_id);
        $page = 'shop/cash_register/cash_register_data';
        $this->header_and_footer($page, $data);
    }
    public function cash($action = null, $p1 = null, $p2 = null, $p3 = null, $p4 = null, $p5 = null, $p6 = null, $p7 = null)
    {
        $shop_id     = $_SESSION['user_data']['id'];
        switch ($action) {
            case null:
                $data['menu_id'] = $this->uri->segment(2);
                $data['title']          = 'Cash';
                $this->load->model('cash_register_model');
                $data['vendor']        = $this->cash_register_model->getvendor();
                $data['customer']        = $this->cash_register_model->getcustomer();
                $data['bank_accounts']   = $this->shops_model->shop_bank_accounts($shop_id);
                // $data['cashvendor']        = $this->cash_register_model->getcashlist();
                $page                   = 'shop/cash_register/cashRegister/index';
                $this->header_and_footer($page, $data);
                break;
            case 'tb':
                $fromdate = "null";
                $todate = "null";
                $vendorId = "null";
                $customerId = "null";
                $getvendor = "null";
                $getcustomer = "null";

                if ($p1 != null) {
                    $fromdate = $p1;
                }
                if ($p2 != null) {
                    $todate =  $p2;
                }
                if ($p3 != null) {
                    $vendorId =   $p3;
                }
                if ($p4 != null) {
                    $customerId = $p4;
                }
                if ($p5 != null) {
                    $getvendor = $p5;
                }
                if ($p6 != null) {
                    $getcustomer = $p6;
                }

                if (@$_POST['fromdate']) {
                    $fromdate = $_POST['fromdate'];
                }
                if (@$_POST['todate']) {
                    $todate = $_POST['todate'];
                }
                if (@$_POST['vendor']) {
                    $vendorId = $_POST['vendor'];
                }
                if (@$_POST['customer']) {
                    $customerId = $_POST['customer'];
                }
                if (@$_POST['vendorid']) {
                    $getvendor = $_POST['vendorid'];
                }
                if (@$_POST['customerid']) {
                    $getcustomer = $_POST['customerid'];
                }
                $this->load->library('pagination');
                $config = array();
                $config["base_url"]         = base_url() . "cash_register/cash/tb/" . $fromdate . "/" . $todate . "/" . $vendorId . "/" . $customerId . "/" . $getvendor . "/" . $getcustomer;
                $this->load->model('cash_register_model');
                $config["total_rows"]       = $this->cash_register_model->getcashlist($fromdate, $todate, $vendorId, $customerId, $getvendor, $getcustomer);

                $data['total_rows']         = $config["total_rows"];
                $config["per_page"]         = 15;
                // $config["uri_segment"]      = 0;
                $config['attributes']       = array('class' => 'pag-link');
                $config['full_tag_open']    = "<div class='pag'>";
                $config['full_tag_close']   = "</div>";
                $config['first_link']       = '&lt;&lt;';
                $config['last_link']        = '&gt;&gt;';
                $this->pagination->initialize($config);
                $this->load->model('cash_register_model');
                $data["links"]              = $this->pagination->create_links();
                $data['page']               = $page = ($p7 != null) ? $p7 : 0;
                $data['per_page']           = $config["per_page"];
                $data['cashvendor']         = $this->cash_register_model->getcashlist($fromdate, $todate, $vendorId, $customerId, $getvendor, $getcustomer,  $data['per_page'], $page);
                $data['totalamount']        = $this->cash_register_model->getcashamount($fromdate, $todate, $vendorId, $customerId, $getvendor, $getcustomer,  $data['per_page'], $page);
                // echo _prx($data["cashvendor"]);
                // die();
                $page                       = 'shop/cash_register/cashRegister/tb';

                $this->load->view($page, $data);
                break;
            case 'save':
                // echo _prx($_POST);
                // die();
                if ($this->input->post('txntype')=='3') {
                  
                    $data = array(
                        'bank_account'     => $this->input->post('customerId'),
                        $this->input->post('dr_cr') => $this->input->post('Amount'),
                        'reference_no'      => $this->input->post('refno'),
                        'txn_type'       => 1,
                        'PaymentDate' => $this->input->post('PaymentDate'),
                        'narration' => $this->input->post('narration'),
                        'shop_id' => $shop_id,
                        'updated' => '',
                        'type' => ($this->input->post('dr_cr')=='dr') ? 'Rcpt' : 'Pymt',
                    );
                    $this->load->model('cash_register_model');
                    if ($cash_id = $this->cash_register_model->add_data('cash_register', $data)) {

                        $dr_cr2 = ($this->input->post('dr_cr')=='dr') ? 'cr' : 'dr';
                        $data1 = array(
                            'bank_account'      => $this->input->post('customerId'),
                            $dr_cr2             => $this->input->post('Amount'),
                            'reference_no'      => $this->input->post('refno'),
                            'txn_type'          => 2,
                            'PaymentDate'       => $this->input->post('PaymentDate'),
                            'narration'         => $this->input->post('narration'),
                            'shop_id'           => $shop_id,
                            'updated'           => '',
                            'type' => ($this->input->post('dr_cr')=='dr') ? 'Rcpt' : 'Pymt',
                            'cash_id'           => $cash_id,
                        );
                        $this->cash_register_model->add_data('cash_register', $data1);

                        echo 1;
                    } else {
                        echo 2;
                    }
                }
                else {
                    $data = array(
                        'customer_id'     => $this->input->post('customerId'),
                        $this->input->post('dr_cr') => $this->input->post('Amount'),
                        'reference_no'      => $this->input->post('refno'),
                        'txn_type'       => 1,
                        'PaymentDate' => $this->input->post('PaymentDate'),
                        'narration' => $this->input->post('narration'),
                        'shop_id' => $shop_id,
                        'updated' => '',
                        'type' => ($this->input->post('dr_cr')=='dr') ? 'Rcpt' : 'Pymt',
                    );
                    $this->load->model('cash_register_model');
                    if ($this->cash_register_model->add_data('cash_register', $data)) {
                        echo 1;
                    } else {
                        echo 2;
                    }
                }
                break;

            case 'edit':
                $id = $this->input->post('cashid');
                $data = $this->db->get_where('cash_register', ['id' => $id])->result_array();
                $data[0]['amount'] = ($data[0]['dr']==0) ? $data[0]['cr'] : $data[0]['dr'];
                $data[0]['dr_cr'] = ($data[0]['dr']==0) ? 'cr' : 'dr';
                echo json_encode($data);
                break;

            case 'update':
                $id = $this->input->post('Id');
                $row = $this->db->get_where('cash_register', ['id' => $id])->row();
                $dr_cr = ($row->dr==0) ? 'cr' : 'dr';
                $data = array(
                    // 'customer_id'       => $this->input->post('customerId'),
                    $dr_cr              => $this->input->post('Amount'),
                    'reference_no'      => $this->input->post('refno'),
                    'txn_type'          => 1,
                    'PaymentDate'       => $this->input->post('PaymentDate'),
                    'narration'         => $this->input->post('narration'),
                    'updated'           => $this->input->post('update'),
                );
                $this->load->model('cash_register_model');
                if ($this->cash_register_model->edit_data('cash_register', $id, $data)) {
                    $cash_cond['conditions']['cash_id'] = $id;
                    if ($this->cash_register_model->getRows($cash_cond)) {
                         $dr_cr = ($row->dr==0) ? 'dr' : 'cr';
                        $data = array(
                           
                            $dr_cr              => $this->input->post('Amount'),
                            'reference_no'      => $this->input->post('refno'),
                            'txn_type'          => 1,
                            'PaymentDate'       => $this->input->post('PaymentDate'),
                            'narration'         => $this->input->post('narration'),
                            'updated'           => $this->input->post('update'),
                        );
                    }

                    echo 1;
                } else {
                    echo 9;
                }
                break;

            case 'delete':
                $id = $this->uri->segment(4);
                $this->load->model('cash_register_model');
                if ($this->cash_register_model->deleteRow($id)) {
                    $cash_cond['cash_id'] = $id;
                    $this->cash_register_model->deleteRow($cash_cond);
                    redirect($this->agent->referrer());
                } else {
                    $this->session->set_flashdata('error', 'Something Went Wrong!!');
                    redirect($this->agent->referrer());
                }
                break;
        }
    }
    public function bank($action = null, $p1 = null, $p2 = null, $p3 = null, $p4 = null, $p5 = null, $p6 = null, $p7 = null)
    {
        switch ($action) {
            case null:
                $shop_id     = $_SESSION['user_data']['id'];
                $data['menu_id'] = $this->uri->segment(2);
                $data['title']          = 'Bank';
                $this->load->model('cash_register_model');
                $data['vendor']        = $this->cash_register_model->getvendor();
                $data['customer']        = $this->cash_register_model->getcustomer();
                $data['bank_accounts']   = $this->shops_model->shop_bank_accounts($shop_id);
                $page                   = 'shop/cash_register/bank_register/index';
                $this->header_and_footer($page, $data);
                break;
            case 'tb':
                $fromdate = "null";
                $todate = "null";
                $vendorId = "null";
                $customerId = "null";
                $getvendor = "null";
                $getcustomer = "null";

                if ($p1 != null) {
                    $fromdate = $p1;
                }
                if ($p2 != null) {
                    $todate =  $p2;
                }
                if ($p3 != null) {
                    $vendorId =   $p3;
                }
                if ($p4 != null) {
                    $customerId = $p4;
                }
                if ($p5 != null) {
                    $getvendor = $p5;
                }
                if ($p6 != null) {
                    $getcustomer = $p6;
                }

                if (@$_POST['fromdate']) {
                    $fromdate = $_POST['fromdate'];
                }
                if (@$_POST['todate']) {
                    $todate = $_POST['todate'];
                }
                if (@$_POST['vendor']) {
                    $vendorId = $_POST['vendor'];
                }
                if (@$_POST['customer']) {
                    $customerId = $_POST['customer'];
                }
                if (@$_POST['vendorid']) {
                    $getvendor = $_POST['vendorid'];
                }
                if (@$_POST['customerid']) {
                    $getcustomer = $_POST['customerid'];
                }
                $this->load->library('pagination');
                $config = array();
                $config["base_url"]         = base_url() . "cash_register/bank/tb/" . $fromdate . "/" . $todate . "/" . $vendorId . "/" . $customerId . "/" . $getvendor . "/" . $getcustomer;
                $this->load->model('cash_register_model');
                $config["total_rows"]       = $this->cash_register_model->getbanktb($fromdate, $todate, $vendorId, $customerId, $getvendor, $getcustomer);
                $data['total_rows']         = $config["total_rows"];
                $config["per_page"]         = 15;
                // $config["uri_segment"]      = 0;
                $config['attributes']       = array('class' => 'pag-link');
                $config['full_tag_open']    = "<div class='pag'>";
                $config['full_tag_close']   = "</div>";
                $config['first_link']       = '&lt;&lt;';
                $config['last_link']        = '&gt;&gt;';
                $this->pagination->initialize($config);
                $this->load->model('cash_register_model');
                $data["links"]              = $this->pagination->create_links();
                $data['page']               = $page = ($p7 != null) ? $p7 : 0;
                $data['per_page']           = $config["per_page"];
                $data['cashvendor'] = $this->cash_register_model->getbanktb($fromdate, $todate, $vendorId, $customerId, $getvendor, $getcustomer,  $data['per_page'], $page);
                $data['totalamount'] = $this->cash_register_model->getamount($fromdate, $todate, $vendorId, $customerId, $getvendor, $getcustomer,  $data['per_page'], $page);
                $page                       = 'shop/cash_register/bank_register/tb';

                $this->load->view($page, $data);
                break;
            case 'save':
                $shop_id     = $_SESSION['user_data']['id'];
                $data = array(
                    'customer_id'     => $this->input->post('customerId'),
                    $this->input->post('dr_cr') => $this->input->post('Amount'),
                    'reference_no'      => $this->input->post('refno'),
                    'txn_type'       => 2,
                    'PaymentDate' => $this->input->post('PaymentDate'),
                    'bank_account' => $this->input->post('bank_account'),
                    'narration' => $this->input->post('narration'),
                    'shop_id' => $shop_id,
                    'updated' => '',
                    'type' => ($this->input->post('dr_cr')=='dr') ? 'Rcpt' : 'Pymt',
                );
                $this->load->model('cash_register_model');
                if ($this->cash_register_model->add_data('cash_register', $data)) {
                    echo 1;
                } else {
                    echo 2;
                }
                break;
            case 'edit':
                $id = $this->input->post('cashid');
                $data = $this->db->get_where('cash_register', ['id' => $id])->result();
                echo json_encode($data);
                break;
            case 'update':
                $id = $this->input->post('Id');
                $data = array(
                    'customer_id'     => $this->input->post('customerId'),
                    $this->input->post('dr_cr') => $this->input->post('Amount'),
                        'reference_no'      => $this->input->post('refno'),
                        'txn_type'       => 2,
                        'PaymentDate' => $this->input->post('PaymentDate'),
                        'narration' => $this->input->post('narration'),
                        'updated' => $this->input->post('update'),
                    'type' => ($this->input->post('dr_cr')=='dr') ? 'Rcpt' : 'Pymt',
                );
                $this->load->model('cash_register_model');
                if ($this->cash_register_model->edit_data('cash_register', $id, $data)) {

                    $row = $this->db->get_where('cash_register', ['id' => $id])->row();

                    if (@$row->cash_id) {
                        $dr_cr = ($row->dr==0) ? 'dr' : 'cr';
                         $update = array(
                                'customer_id'     => $this->input->post('customerId'),
                                $dr_cr  => $this->input->post('Amount'),
                                'reference_no'      => $this->input->post('refno'),
                                'PaymentDate' => $this->input->post('PaymentDate'),
                                'narration' => $this->input->post('narration'),
                                'updated' => $this->input->post('update'),
                            );
                        $this->cash_register_model->edit_data('cash_register', $row->cash_id, $update);
                    }

                    echo 1;
                } else {
                    echo 9;
                }
                break;
            case 'delete':
                $id = $this->uri->segment(4);
                $this->load->model('cash_register_model');
                $row = $this->db->get_where('cash_register', ['id' => $id])->row();
                if ($this->cash_register_model->delete_data('cash_register', $id)) {
                     if (@$row->cash_id) {
                        $this->cash_register_model->delete_data('cash_register', $row->cash_id);
                     }
                    // $this->session->set_flashdata('success', 'Deleted Successfully');
                    redirect($this->agent->referrer());
                } else {
                    $this->session->set_flashdata('error', 'Something Went Wrong!!');
                    redirect($this->agent->referrer());
                }
                break;
        }
    }
    public function checkref_no()
    {
        if ($this->input->post('refval')) {
            $refval = $this->input->post('refval');
            $this->load->model('cash_register_model');
            if ($this->cash_register_model->checkrefno($refval)) {
                echo 1;
            } else {
                echo 2;
            }
        }
    }
    public function editcheckref_no()
    {
        if ($this->input->post('refval')) {
            $id =  $this->input->post('id');
            $refval = $this->input->post('refval');
            $this->load->model('cash_register_model');
            if ($this->cash_register_model->editcheckrefno($id, $refval)) {
                echo 1;
            } else {
                echo 2;
            }
        }
    }
    function multiple_delete()
    {
        if ($this->input->post('checkbox_value')) {
            $id = $this->input->post('checkbox_value');
            $table = $this->input->post('table');
            for ($count = 0; $count < count($id); $count++) {
                if ($table == 'cash_register') {
                    $is_deleted = array('is_deleted' => 'DELETED');
                    $this->db->where('id', $id[$count])->update($table, $is_deleted);
                } else {
                    $this->cash_register_model->delete_data($table, $id[$count]);
                }
            }
        }
    }
}
