<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Master_shop extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->isLoggedIn();
        $this->check_role_menu();
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
        $menu_id = $this->uri->segment(2);
        $data['menu_id'] = $menu_id;
        $role_id = $_SESSION['shop_role_id'];
        $data['sub_menus'] = $this->admin_model->get_submenu_data($menu_id, $role_id);
        $data['title'] = 'Shop Master Data';
        $page = 'shop/master/shop_master_data';
        $this->header_and_footer($page, $data);
    }

    //Home Banners

    public function home_banners()
    {
        $data['title'] = 'Home Banners';
        $shop_id     = $_SESSION['user_data']['id'];
        $data['home_banners']  = $this->master_model->get_home_banner($shop_id);
        $data['link_banner_url'] = base_url() . 'shop-master-data/link_banner_view/';
        $page = 'shop/master/home_banners';
        $this->header_and_footer($page, $data);
    }
    public function link_banner_view($id)
    {
        $data['banner_id'] = $id;
        $data['banners'] = $this->master_model->get_row_data1('home_banners', 'id', $id);
        if (!empty($data['banners'])) {
            if ($data['banners']->link_type == '1') {
                $pid = $data['banners']->link_id;
                $data['linked_item'] = $this->master_model->get_row_data('products_subcategory', 'id', $pid);
            } else if ($data['banners']->link_type == '2') {
                $cid = $data['banners']->link_id;
                $data['linked_item'] = $this->master_model->get_row_data('products_category', 'id', $cid);
            } else if ($data['banners']->link_type == '3') {
                $hid = $data['banners']->link_id;
                $data['linked_item'] = $this->master_model->get_row_data('home_headers', 'id', $hid);
            }
        }
        $this->load->view('shop/master/home_banner/link_banner_view', $data);
    }
    public function fetch_items()
    {
        $link_id = $this->input->post('link_id');
        $bannerid = $this->input->post('bannerid');
        if ($link_id == '3') {
            $data['banner_id'] = $bannerid;
            $data['home_header']  = $this->master_model->view_home_header();
            $this->load->view('shop/master/home_banner/link_header', $data);
        } else if ($link_id == '2') {
            $data['banner_id'] = $bannerid;
            $data['sub_categories'] = $this->master_model->get_category();
            $this->load->view('shop/master/home_banner/link_category', $data);
        } else {
            $data['banner_id'] = $bannerid;
            $data['parent_cat'] = $this->master_model->get_data('products_category', 'is_parent', '0');
            $data['products'] = $this->master_model->view_data('products_subcategory');
            $this->load->view('shop/master/home_banner/link_product', $data);
        }
    }
    public function get_products()
    {
        if ($this->input->post('parent_cat_id')) {
            $id = $this->input->post('parent_cat_id');
            $data['available_products'] = $this->master_model->fetch_products($id);
            $this->load->view('shop/master/home_banner/available_products', $data);
        }
    }
    public function link_header()
    {
        $hid = $this->input->post('hid');
        $bannerid = $this->input->post('bannerid');
        $data = array(
            'link_type'     => '3',
            'link_id'     => $hid,
        );
        if ($this->master_model->edit_data('home_banners', $bannerid, $data)) {
            echo 'linked';
        }
    }
    public function link_category()
    {
        $cid = $this->input->post('cid');
        $bannerid = $this->input->post('bannerid');
        $data = array(
            'link_type'     => '2',
            'link_id'     => $cid,
        );
        if ($this->master_model->edit_data('home_banners', $bannerid, $data)) {
            echo 'linked';
        }
    }
    public function link_product()
    {
        $pid = $this->input->post('pid');
        $bannerid = $this->input->post('bannerid');
        $data = array(
            'link_type'     => '1',
            'link_id'     => $pid,
        );
        if ($this->master_model->edit_data('home_banners', $bannerid, $data)) {
            echo 'linked';
        }
    }
    public function add_home_banner()
    {
        $data = array(
            'shop_id'     => $_SESSION['user_data']['id'],
            'seq'     => $this->input->post('seq'),
            'banner_type'     => $this->input->post('banner_type'),
        );
        if ($this->master_model->add_home_banner($data)) {
            $this->session->set_flashdata('success', 'Home Banner Added Successfully');
            redirect($this->agent->referrer());
        } else {
            $this->session->set_flashdata('error', 'Something Went Wrong!!');
            redirect($this->agent->referrer());
        }
    }

    public function edit_home_banner()
    {
        $id = $this->uri->segment(3);

        $data = array(
            'seq'     => $this->input->post('seq'),
            'banner_type'     => $this->input->post('banner_type'),
        );

        if ($this->master_model->edit_home_banner($data, $id)) {
            $this->session->set_flashdata('success', 'Updated Successfully');
            redirect($this->agent->referrer());
        } else {
            $this->session->set_flashdata('error', 'Something Went Wrong!!');
            redirect($this->agent->referrer());
        }
    }
    public function delete_home_banner()
    {
        $id = $this->uri->segment(3);
        if ($this->master_model->delete_data('home_banners', $id)) {
            $this->session->set_flashdata('success', 'Deleted Successfully ');
            redirect($this->agent->referrer());
        } else {
            $this->session->set_flashdata('error', 'Something Went Wrong!!');
            redirect($this->agent->referrer());
        }
    }
    public function change_homebanner_status()
    {
        $id = $this->input->post('id');
        $data['status_data'] = $this->master_model->get_row_data('home_banners', 'id', $id);

        if ($data['status_data']->active == 1) {
            $data1 = array(
                'active' => 0
            );
        } else if ($data['status_data']->active == 0) {
            $data1 = array(
                'active' => 1
            );
        }
        $this->master_model->edit_data('home_banners', $id, $data1);
        $this->load->view('admin/statusview', $data);
    }


    //Home Header

    public function home_header()
    {
        $data['title'] = 'Home Header';
        $shop_id     = $_SESSION['user_data']['id'];
        $data['home_header']  = $this->master_model->get_home_header($shop_id);
        $page = 'shop/master/home_header/home_header';
        $this->header_and_footer($page, $data);
    }

    public function add_home_header()
    {

        $data = array(
            'title'     => $this->input->post('title'),
            'type'     => $this->input->post('type'),
            'shop_id'     => $_SESSION['user_data']['id'],
            'colorcode'     => $this->input->post('colorcode'),
            'seq'     => $this->input->post('seq'),
        );
        if ($this->master_model->add_data('home_headers', $data)) {
            $this->session->set_flashdata('success', 'Home Header Added Successfully');
            redirect($this->agent->referrer());
        } else {
            $this->session->set_flashdata('error', 'Something Went Wrong!!');
            redirect($this->agent->referrer());
        }
    }
    public function edit_home_header()
    {
        $id = $this->uri->segment(3);

        $data = array(
            'title'     => $this->input->post('title'),
            'type'     => $this->input->post('type'),
            'colorcode'     => $this->input->post('colorcode'),
            'seq'     => $this->input->post('seq'),
        );

        if ($this->master_model->edit_data('home_headers', $id, $data)) {
            $this->session->set_flashdata('success', 'Data Updated Successfully');
            redirect($this->agent->referrer());
        } else {
            $this->session->set_flashdata('error', 'Something Went Wrong!!');
            redirect($this->agent->referrer());
        }
    }
    public function delete_home_header()
    {
        $id = $this->uri->segment(3);
        if ($this->master_model->delete_data('home_headers', $id)) {
            $this->session->set_flashdata('success', 'Data Deleted Successfully ');
            redirect($this->agent->referrer());
        } else {
            $this->session->set_flashdata('error', 'Something Went Wrong!!');
            redirect($this->agent->referrer());
        }
    }

    public function product_headers_mapping()
    {
        $data['title'] = 'Products Headers Mapping';
        $id = $this->uri->segment(3);
        $data['headerid'] = $id;
        $data['headers_mapping'] = $this->master_model->get_headers_mapping($id);
        $page = 'shop/master/home_header/headers_mapping';
        $this->header_and_footer($page, $data);
    }
    public function add_mapping()
    {
        $data['headerid'] = $this->input->post('headerid');
        $data['parent_cat'] = $this->master_model->get_data('products_category', 'is_parent', '0');
        $data['categories'] = $this->master_model->get_data('products_category', 'is_parent !=', '0');
        $this->load->view('shop/master/home_header/add_mapping', $data);
    }
    //Fetch Products
    public function fetch_products()
    {
        if ($this->input->post('parent_cat_id')) {
            $id = $this->input->post('parent_cat_id');
            $headerid = $this->input->post('headerid');
            $data['headerid'] = $headerid;
            $data['available_products'] = $this->master_model->fetch_products($id);
            $data['headers_mapping'] = $this->master_model->get_headers_mapping($headerid);
            // print_r($data['headers_mapping']);
            $this->load->view('shop/master/home_header/available_products', $data);
        }
    }
    public function map_product()
    {
        $pid = $this->input->post('pid');
        $headerid = $this->input->post('headerid');
        $data = array(
            'header_id'     => $headerid,
            'value'     => $pid,
        );
        $data['headers_mapping'] = $this->master_model->add_data('home_headers_mapping', $data);
        $data['flg'] = '1';
        $data['pid'] = $pid;
        if ($data['headers_mapping']) {
            $this->load->view('shop/master/home_header/map_unmap', $data);
        }
    }
    public function remove_map_product()
    {
        $pid = $this->input->post('pid');
        $headerid = $this->input->post('headerid');
        $data['flg'] = '0';
        $data['pid'] = $pid;
        if ($this->master_model->delete_header_mapping($pid, $headerid)) {
            $this->load->view('shop/master/home_header/map_unmap', $data);
        }
    }

    public function delete_header_mapping()
    {
        $id = $this->uri->segment(3);
        if ($this->master_model->delete_header_map($id)) {
            $this->session->set_flashdata('success', 'Data Deleted Successfully ');
            redirect($this->agent->referrer());
        } else {
            $this->session->set_flashdata('error', 'Something Went Wrong!!');
            redirect($this->agent->referrer());
        }
    }

    //Category Headers Mapping
    public function cat_headers_mapping()
    {
        $data['title'] = 'Category Headers Mapping';
        $id = $this->uri->segment(3);
        $data['headerid'] = $id;
        $data['category_mapping'] = $this->master_model->get_category_mapping($id);
        $page = 'shop/master/home_header/category_mapping';
        $this->header_and_footer($page, $data);
    }
    public function add_cat_mapping()
    {
        $data['headerid'] = $this->input->post('headerid');
        $headerid = $data['headerid'];
        $data['parent_cat'] = $this->master_model->get_data('products_category', 'is_parent', '0');
        $data['headers_mapping'] = $this->master_model->get_category_mapping($headerid);
        $this->load->view('shop/master/home_header/add_cat_mapping', $data);
    }
    public function map_category()
    {
        $cid = $this->input->post('cid');
        $headerid = $this->input->post('headerid');
        $data = array(
            'header_id'     => $headerid,
            'value'     => $cid,
        );
        $data['category_mapping'] = $this->master_model->add_data('home_headers_mapping', $data);
        $data['flg'] = '1';
        $data['cid'] = $cid;
        if ($data['category_mapping']) {
            $this->load->view('shop/master/home_header/cat_map_unmap', $data);
        }
    }
    public function remove_map_category()
    {
        $cid = $this->input->post('cid');
        $headerid = $this->input->post('headerid');
        $data['flg'] = '0';
        $data['cid'] = $cid;
        if ($this->master_model->delete_category_mapping($cid, $headerid)) {
            $this->load->view('shop/master/home_header/cat_map_unmap', $data);
        }
    }
    public function delete_cat_header_mapping()
    {
        $id = $this->uri->segment(3);
        if ($this->master_model->delete_category_map($id)) {
            $this->session->set_flashdata('success', 'Data Deleted Successfully ');
            redirect($this->agent->referrer());
        } else {
            $this->session->set_flashdata('error', 'Something Went Wrong!!');
            redirect($this->agent->referrer());
        }
    }

    //Booking Slots
    public function booking_slots()
    {
        $data['title']      = 'Booking Slots';
        $data['booking_slots']  = $this->master_model->get_booking_slots();
        $page = 'shop/master/booking_slot/booking_slots';
        $this->header_and_footer($page, $data);
    }
    //Fetch Slots
    public function fetch_slot()
    {
        if ($this->input->post('day_name')) {
            $day = $this->input->post('day_name');
            print_r($day);
            $shop_id     = $_SESSION['user_data']['id'];
            $data['available_slots'] = $this->master_model->fetch_slot($day, $shop_id);

            $this->load->view('shop/master/booking_slot/available_slots', $data);
        }
    }

    public function add_booking_slot()
    {
        $shop_id     = $_SESSION['user_data']['id'];
        $data = array(
            'day'     => $this->input->post('day_name'),
            'timestart'     => $this->input->post('timestart'),
            'timeend'     => $this->input->post('timeend'),
            'slotsize'     => $this->input->post('slotsize'),
            'shop_id'     => $shop_id
        );
        if ($this->master_model->add_data('booking_slots', $data)) {
            $this->session->set_flashdata('success', 'Booking Slot Added Successfully');
            redirect($this->agent->referrer());
        } else {
            $this->session->set_flashdata('error', 'Something Went Wrong!!');
            redirect($this->agent->referrer());
        }
    }
    public function edit_booking_slot()
    {
        $shop_id     = $_SESSION['user_data']['id'];
        $id = $this->uri->segment(3);
        $data = array(
            'day'     => $this->input->post('day_name'),
            'timestart'     => $this->input->post('timestart'),
            'timeend'     => $this->input->post('timeend'),
            'slotsize'     => $this->input->post('slotsize'),
            'shop_id'     => $shop_id
        );
        if ($this->master_model->edit_data('booking_slots', $id, $data)) {
            $this->session->set_flashdata('success', 'Booking Slot Edited Successfully');
            redirect($this->agent->referrer());
        } else {
            $this->session->set_flashdata('error', 'Something Went Wrong!!');
            redirect($this->agent->referrer());
        }
    }
    public function delete_booking_slot()
    {
        $id = $this->uri->segment(3);
        if ($this->master_model->delete_booking_slot($id)) {
            $this->session->set_flashdata('success', 'Booking Slot Deleted Successfully');
            redirect($this->agent->referrer());
        } else {
            $this->session->set_flashdata('error', 'Something Went Wrong!!');
            redirect($this->agent->referrer());
        }
    }
    public function change_slot_status()
    {
        $id = $this->input->post('id');
        $data['status_data'] = $this->master_model->get_row_data('booking_slots', 'id', $id);

        if ($data['status_data']->active == 1) {
            $data1 = array(
                'active' => 0
            );
        } else if ($data['status_data']->active == 0) {
            $data1 = array(
                'active' => 1
            );
        }
        $this->master_model->edit_data('booking_slots', $id, $data1);
        $this->load->view('admin/statusview', $data);
    }

    public function vendors($action = null, $p1 = null, $p2 = null, $p3 = null)
    {
        // $data['user']    = $this->checkLogin();
        switch ($action) {
            case null:
                $data['title']          = 'Vendors';
                $data['tb_url']         = base_url() . 'shop-vendors/tb';
                $data['new_url']        = base_url() . 'shop-vendors/create';
                $page                   = 'shop/master/vendors/index';
                $this->header_and_footer($page, $data);
                break;

            case 'tb':
                $data['search'] = '';
                if (@$_POST['search']) {
                    $data['search'] = $_POST['search'];
                }


                $this->load->library('pagination');
                $config = array();
                $config["base_url"]         = base_url() . "shop-vendors/tb/";
                $config["total_rows"]       = $this->shops_vendor_model->vendors();
                $data['total_rows']         = $config["total_rows"];
                $config["per_page"]         = 20;
                $config["uri_segment"]      = 3;
                $config['attributes']       = array('class' => 'pag-link');
                $config['full_tag_open']    = "<div class='pag'>";
                $config['full_tag_close']   = "</div>";
                $config['first_link']       = '&lt;&lt;';
                $config['last_link']        = '&gt;&gt;';
                $this->pagination->initialize($config);
                $data["links"]              = $this->pagination->create_links();
                $data['page']               = $page = ($p1 != null) ? $p1 : 0;
                $data['per_page']           = $config["per_page"];
                $data['vendors']           = $this->shops_vendor_model->vendors($config["per_page"], $page);
                $data['update_url']         = base_url() . 'shop-vendors/create/';
                $page                       = 'shop/master/vendors/tb';


                $this->load->view($page, $data);
                break;

            case 'create':
                $data['remote']             = base_url() . 'shop-master-data/remote/vendor/';
                $data['action_url']         = base_url() . 'shop-vendors/save';
                $data['states']  = $this->shops_vendor_model->view_data('states');
                $data['cities']  = $this->shops_vendor_model->view_data('cities');
                $page                       = 'shop/master/vendors/create';
                if ($p1 != null) {
                    $data['value']          = $this->shops_vendor_model->vendor($p1);
                    $data['action_url']     = base_url() . 'shop-vendors/save/' . $p1;
                    $data['remote']         = base_url() . 'shop-master-data/remote/vendor/' . $p1;
                    $data['opening']        = $this->shops_vendor_model->get_vendor_opening($p1);
                    // echo _prx($data['opening']);
                    // die();
                    $page                   = 'shop/master/vendors/update';
                }
                $this->load->view($page, $data);
                break;



            case 'save':
                $id = $p1;
                $return['res'] = 'error';
                $return['msg'] = 'Not Saved!';

                if ($this->input->server('REQUEST_METHOD') == 'POST') {

                    if ($id != null) {
                        $shop_id     = $_SESSION['user_data']['id'];
                        $data = array(
                            'name'     => $this->input->post('name'),
                            'mobile'              => $this->input->post('mobile'),
                            'alternate_mobile'   => $this->input->post('alternate_mobile'),
                            'state'      => $this->input->post('state'),
                            'city'        => $this->input->post('city'),
                            'address'       => $this->input->post('address'),
                            'email'        => $this->input->post('email'),
                            'gstin'        => $this->input->post('gstin'),
                            'shop_id'        => $shop_id,
                            'vendor_code'        => $this->input->post('vendor_code'),
                            'pincode'        => $this->input->post('pincode'),
                        );

                        $opening = array(
                                    'user_id' => $id,
                                    'dr_cr' => $this->input->post('dr_cr'),
                                    'amount' => $this->input->post('amount'),
                                    'remark' => $this->input->post('remark'),
                                    );
                        $this->shops_vendor_model->vendor_opening($opening,$id);
                        if ($this->shops_vendor_model->edit_data('vendors', $id, $data)) {
                            $return['res'] = 'success';
                            $return['msg'] = 'Updated.';
                        }
                    } else {
                        $shop_id     = $_SESSION['user_data']['id'];
                        $data = array(
                            'name'     => $this->input->post('name'),
                            'mobile'              => $this->input->post('mobile'),
                            'alternate_mobile'   => $this->input->post('alternate_mobile'),
                            'state'      => $this->input->post('state'),
                            'city'        => $this->input->post('city'),
                            'address'       => $this->input->post('address'),
                            'email'        => $this->input->post('email'),
                            'gstin'        => $this->input->post('gstin'),
                            'shop_id'        => $shop_id,
                            'vendor_code'        => $this->input->post('vendor_code'),
                            'pincode'        => $this->input->post('pincode'),
                            'user_type'        => '1',
                        );

                        if ($user_id = $this->shops_vendor_model->add_data('vendors', $data)) {
                            $opening = array(
                                    'user_id' => $user_id,
                                    'dr_cr' => $this->input->post('dr_cr'),
                                    'amount' => $this->input->post('amount'),
                                    'remark' => $this->input->post('remark'),
                                    );
                            $this->shops_vendor_model->vendor_opening($opening);

                            $return['res'] = 'success';
                            $return['msg'] = 'Saved.';
                        }
                    }
                }
                echo json_encode($return);
                break;




            case 'delete':
                $id = $this->input->post('vid');
                if ($this->shops_vendor_model->delete_data('vendors', $id)) {
                    $data['search'] = '';
                    if (@$_POST['search']) {
                        $data['search'] = $_POST['search'];
                    }

                    $this->load->library('pagination');
                    $config = array();
                    $config["base_url"]         = base_url() . "shop-vendors/tb/";
                    $config["total_rows"]       = $this->shops_vendor_model->vendors();
                    $data['total_rows']         = $config["total_rows"];
                    $config["per_page"]         = 20;
                    $config["uri_segment"]      = 3;
                    $config['attributes']       = array('class' => 'pag-link');
                    $config['full_tag_open']    = "<div class='pag'>";
                    $config['full_tag_close']   = "</div>";
                    $config['first_link']       = '&lt;&lt;';
                    $config['last_link']        = '&gt;&gt;';
                    $this->pagination->initialize($config);
                    $data["links"]              = $this->pagination->create_links();
                    $data['page']               = $page = ($p2 != null) ? $p2 : 0;
                    $data['per_page']           = $config["per_page"];
                    $data['vendors']           = $this->shops_vendor_model->vendors($config["per_page"], $page);
                    $data['update_url']         = base_url() . 'shop-vendors/create/';
                    $page                       = 'shop/master/vendors/tb';


                    $this->load->view($page, $data);
                }
                break;
            default:
                # code...
                break;
        }
    }
    public function customer($action = null, $p1 = null, $p2 = null, $p3 = null)
    {
        // $data['user']    = $this->checkLogin();
        switch ($action) {
            case null:
                $data['title']          = 'Customer';
                $data['tb_url']         = base_url() . 'shop-customer/tb';
                $data['new_url']        = base_url() . 'shop-customer/create';
                $page                   = 'shop/master/customer/index';
                $this->header_and_footer($page, $data);
                break;

            case 'tb':
                $data['search'] = '';
                if (@$_POST['search']) {
                    $data['search'] = $_POST['search'];
                }


                $this->load->library('pagination');
                $config = array();
                $config["base_url"]         = base_url() . "shop-customer/tb/";
                $config["total_rows"]       = $this->shops_vendor_model->customer();
                $data['total_rows']         = $config["total_rows"];
                $config["per_page"]         = 20;
                $config["uri_segment"]      = 3;
                $config['attributes']       = array('class' => 'pag-link');
                $config['full_tag_open']    = "<div class='pag'>";
                $config['full_tag_close']   = "</div>";
                $config['first_link']       = '&lt;&lt;';
                $config['last_link']        = '&gt;&gt;';
                $this->pagination->initialize($config);
                $data["links"]              = $this->pagination->create_links();
                $data['page']               = $page = ($p1 != null) ? $p1 : 0;
                $data['per_page']           = $config["per_page"];
                $data['vendors']           = $this->shops_vendor_model->customer($config["per_page"], $page);
                $data['update_url']         = base_url() . 'shop-customer/create/';
                $page                       = 'shop/master/customer/tb';


                $this->load->view($page, $data);
                break;

            case 'create':
                $data['remote']             = base_url() . 'shop-master-data/remote/vendor/';
                $data['action_url']         = base_url() . 'shop-customer/save';
                $data['states']  = $this->shops_vendor_model->view_data('states');
                $data['cities']  = $this->shops_vendor_model->view_data('cities');
                $page                       = 'shop/master/customer/create';
                if ($p1 != null) {
                    $data['value']          = $this->shops_vendor_model->vendor($p1);
                    $data['action_url']     = base_url() . 'shop-customer/save/' . $p1;
                    $data['remote']         = base_url() . 'shop-master-data/remote/vendor/' . $p1.'/';
                    $data['opening']        = $this->shops_vendor_model->get_vendor_opening($p1);
                    $page                   = 'shop/master/customer/update';
                }
                $this->load->view($page, $data);
                break;



            case 'save':
                $id = $p1;
                $return['res'] = 'error';
                $return['msg'] = 'Not Saved!';

                if ($this->input->server('REQUEST_METHOD') == 'POST') {

                    if ($id != null) {
                        $shop_id     = $_SESSION['user_data']['id'];
                        $data = array(
                            'name'     => $this->input->post('name'),
                            'mobile'              => $this->input->post('mobile'),
                            'alternate_mobile'   => $this->input->post('alternate_mobile'),
                            'alternate_mobile'   => $this->input->post('alternate_mobile'),
                            'customer_type'   => $this->input->post('customer_type'),
                            'customer_category'   => $this->input->post('customer_category'),
                            'contact_person_name'   => $this->input->post('contact_person_name'),
                            'customer_profile'   => $this->input->post('customer_profile'),
                            'state'      => $this->input->post('state'),
                            'city'        => $this->input->post('city'),
                            'address'       => $this->input->post('address'),
                            'email'        => $this->input->post('email'),
                            'gstin'        => $this->input->post('gstin'),
                            'shop_id'        => $shop_id,
                            'vendor_code'        => $this->input->post('vendor_code'),
                            'pincode'        => $this->input->post('pincode'),
                            'credit_limit'        => $this->input->post('credit_limit'),
                        );

                        $opening = array(
                                    'user_id' => $id,
                                    'dr_cr' => $this->input->post('dr_cr'),
                                    'amount' => $this->input->post('amount'),
                                    'remark' => $this->input->post('remark'),
                                    );
                        $this->shops_vendor_model->vendor_opening($opening,$id);
                        if ($this->shops_vendor_model->edit_data('vendors', $id, $data)) {
                            $return['res'] = 'success';
                            $return['msg'] = 'Updated.';
                        }
                    } else {
                        $shop_id     = $_SESSION['user_data']['id'];
                        $data = array(
                            'name'     => $this->input->post('name'),
                            'mobile'              => $this->input->post('mobile'),
                            'alternate_mobile'   => $this->input->post('alternate_mobile'),
                            'alternate_mobile'   => $this->input->post('alternate_mobile'),
                            'customer_type'   => $this->input->post('customer_type'),
                            'customer_category'   => $this->input->post('customer_category'),
                            'contact_person_name'   => $this->input->post('contact_person_name'),
                            'customer_profile'   => $this->input->post('customer_profile'),
                            'state'      => $this->input->post('state'),
                            'city'        => $this->input->post('city'),
                            'address'       => $this->input->post('address'),
                            'email'        => $this->input->post('email'),
                            'gstin'        => $this->input->post('gstin'),
                            'shop_id'        => $shop_id,
                            'vendor_code'        => $this->input->post('vendor_code'),
                            'pincode'        => $this->input->post('pincode'),
                            'user_type'        => '2',
                            'credit_limit'        => $this->input->post('credit_limit'),
                        );
                        if ($user_id = $this->shops_vendor_model->add_data('vendors', $data)) {
                            $opening = array(
                                    'user_id' => $user_id,
                                    'dr_cr' => $this->input->post('dr_cr'),
                                    'amount' => $this->input->post('amount'),
                                    'remark' => $this->input->post('remark'),
                                    );
                            $this->shops_vendor_model->vendor_opening($opening);
                            $return['res'] = 'success';
                            $return['msg'] = 'Saved.';
                        }
                    }
                }
                echo json_encode($return);
                break;




            case 'delete':
                $id = $this->input->post('vid');
                if ($this->shops_vendor_model->delete_data('vendors', $id)) {
                // if (1==1) {
                    // $this->load->model('pos_orders_model');
                    // $this->load->model('pos_order_items_model');
                    // $this->load->model('cash_register_model');

                    // $order_cond['conditions']['user_id'] = $id;
                    // $orders = $this->pos_orders_model->getRows($order_cond);

                    // foreach ($orders as $key => $value) {
                        
                    //     $items_cond['conditions']['order_id'] = $value['id'];
                    //     $items = $this->pos_order_items_model->getRows($items_cond);
                    //     // echo _prx($items);
                
                    //     // ladger entry deteletion
                    //     $order_delete_cond['order_id']  = $value['id'];
                    //     $order_delete_cond['txn_type']  = 3;
                    //     $order_delete_cond['type']      = 'Sale';
                    //     $this->cash_register_model->deleteRow($order_delete_cond);

                    //     // delete order
                    //     $this->pos_orders_model->deleteRow($value['id']);
                    //     $this->pos_order_items_model->deleteRow(['order_id'=>$value['id']]);
                    //     // delete order
                    // }

                    // echo _prx($orders);
                    // echo "string";
                    // die();

                    $data['search'] = '';
                    if (@$_POST['search']) {
                        $data['search'] = $_POST['search'];
                    }

                    $this->load->library('pagination');
                    $config = array();
                    $config["base_url"]         = base_url() . "customer/tb/";
                    $config["total_rows"]       = $this->shops_vendor_model->customer();
                    $data['total_rows']         = $config["total_rows"];
                    $config["per_page"]         = 20;
                    $config["uri_segment"]      = 3;
                    $config['attributes']       = array('class' => 'pag-link');
                    $config['full_tag_open']    = "<div class='pag'>";
                    $config['full_tag_close']   = "</div>";
                    $config['first_link']       = '&lt;&lt;';
                    $config['last_link']        = '&gt;&gt;';
                    $this->pagination->initialize($config);
                    $data["links"]              = $this->pagination->create_links();
                    $data['page']               = $page = ($p2 != null) ? $p2 : 0;
                    $data['per_page']           = $config["per_page"];
                    $data['vendors']           = $this->shops_vendor_model->customer($config["per_page"], $page);
                    $data['update_url']         = base_url() . 'customer/create/';
                    $page                       = 'shop/master/customer/tb';


                    $this->load->view($page, $data);
                }
                break;
            default:
                # code...
                break;
        }
    }
    public function change_vendor_status()
    {
        $id = $this->input->post('id');
        $data['status_data'] = $this->shops_vendor_model->get_row_data('vendors', 'id', $id);


        if ($data['status_data']->active == 1) {
            $data1 = array(
                'active' => 0
            );
        } else if ($data['status_data']->active == 0) {
            $data1 = array(
                'active' => 1
            );
        }
        $this->shops_vendor_model->edit_data('vendors', $id, $data1);
        $this->load->view('admin/statusview', $data);
    }
    public function change_social_status()
    {
        $id = $this->input->post('id');
        $data['status_data'] = $this->master_model->get_row_data('shop_social', 'id', $id);

        if ($data['status_data']->active == 1) {
            $data1 = array(
                'active' => 0
            );
        } else if ($data['status_data']->active == 0) {
            $data1 = array(
                'active' => 1
            );
        }
        $this->master_model->edit_data('shop_social', $id, $data1);
        $this->load->view('admin/statusview', $data);
    }
    public function fetch_city()
    {
        if ($this->input->post('state')) {
            $sid = $this->input->post('state');
            $this->master_model->fetch_city($sid);
        }
    }
    public function remote($type, $id = null, $column = 'name')
    {
        if ($type == 'vendor') {
            $tb = 'vendors';
        } elseif ($type == 'shop_social') {
            $tb = 'shop_social';
        } else {
        }
        $this->db->where($column, $_GET[$column]);
        if ($id != 'null') {
            $this->db->where('id != ', $id);
        }
        $count = $this->db->count_all_results($tb);
        if ($count > 0) {
            echo "false";
        } else {
            echo "true";
        }
    }

    public function product_flags($action = null, $p1 = null, $p2 = null, $p3 = null, $p4 = null, $p5 = null)
    {
        // $data['user']    = $this->checkLogin();
        switch ($action) {
            case null:
                $data['title']          = 'Product Flags';
                $data['tb_url']         = base_url() . 'shop-product-flags/tb';
                $page                   = 'shop/master/products/index';
                $this->header_and_footer($page, $data);
                break;

            case 'tb':
                $data['search'] = '';
                $data['cat_id'] = '';
                $data['parent_id'] = '';
                $data['child_cat_id'] = '';
                //below variable section used for models and other places
                $cat_id = 'null';
                $parent_id = 'null';
                $search = 'null';
                $child_cat_id = 'null';
                //get section intiliazation
                if ($p2 != null) {
                    $data['parent_id'] = $p1;
                    $data['cat_id'] = $p2;
                    $parent_id = $p1;
                    $cat_id = $p2;
                    $data['sub_cat'] = $this->db->get_where('products_category', ['is_parent' => $p1, 'is_deleted' => 'NOT_DELETED'])->result();
                }
                if ($p3 != null) {
                    $data['child_cat_id'] = $p3;
                    $child_cat_id = $p3;
                    $data['child_cat'] = $this->db->get_where('products_category', ['is_parent' => $p2, 'is_deleted' => 'NOT_DELETED'])->result();
                }
                if ($p4 != null) {
                    $data['search'] = $p4;
                    $search = $p4;
                }
                //end of section
                if (@$_POST['search']) {
                    $data['search'] = $_POST['search'];
                    $search = $_POST['search'];
                }
                if (@$_POST['cat_id']) {
                    $data['cat_id'] = $_POST['cat_id'];
                    $data['parent_id'] = $_POST['parent_id'];
                    $cat_id = $_POST['cat_id'];
                    $parent_id = $_POST['parent_id'];
                    $data['sub_cat'] = $this->db->get_where('products_category', ['is_parent' => $_POST['parent_id'], 'is_deleted' => 'NOT_DELETED'])->result();
                }
                if (@$_POST['child_cat_id']) {
                    $data['child_cat_id'] = $_POST['child_cat_id'];
                    $child_cat_id = $_POST['child_cat_id'];
                    $data['child_cat'] = $this->db->get_where('products_category', ['is_parent' => $_POST['cat_id'], 'is_deleted' => 'NOT_DELETED'])->result();
                }


                $this->load->library('pagination');
                $config = array();
                $config["base_url"]         = base_url() . "shop-product-flags/tb/" . $parent_id . "/" . $cat_id . "/" . $child_cat_id . "/" . $search;
                $config["total_rows"]       = $this->master_model->products($parent_id, $cat_id, $child_cat_id, $search);
                $data['total_rows']         = $config["total_rows"];
                $config["per_page"]         = 20;
                $config["uri_segment"]      = 7;
                $config['attributes']       = array('class' => 'pag-link');
                $config['full_tag_open']    = "<div class='pag'>";
                $config['full_tag_close']   = "</div>";
                $config['first_link']       = '&lt;&lt;';
                $config['last_link']        = '&gt;&gt;';
                $this->pagination->initialize($config);
                $data["links"]              = $this->pagination->create_links();
                $data['page']               = $page = ($p5 != null) ? $p5 : 0;
                $data['per_page']           = $config["per_page"];
                $data['products']           = $this->master_model->products($parent_id, $cat_id, $child_cat_id, $search, $config["per_page"], $page);
                $data['pf_url']             = base_url() . 'shop-product-flags/flags/';
                $data['image_url']         = base_url() . 'shop-product-flags/view_image/';
                $data['plan_type_url']             = base_url() . 'shop-product-flags/plan_type/';
                $page                       = 'shop/master/products/tb';


                $data['properties']         = $this->master_model->view_data('product_props_master');
                $data['unit_type']          = $this->master_model->view_data('unit_master');
                $data['categories']         = $this->master_model->view_data('products_category');
                $data['parent_cat'] = $this->master_model->get_data('products_category', 'is_parent', '0');

                $this->load->view($page, $data);
                break;
            case 'flags':
                $data['pid'] = $p1;
                $shop_id     = $_SESSION['user_data']['id'];
                $data['flags']    = $this->master_model->get_flags($p1, $shop_id);

                $data['business']  = $this->master_model->view_data('business');
                $data['action_url']    = base_url() . 'shop-product-flags/add-flags/' . $p1;
                $data['form_id']       = uniqid();
                $page                  = 'shop/master/products/product_flags';
                $this->load->view($page, $data);

                break;
            case 'add-flags':
                $return['res'] = 'error';
                $return['msg'] = 'Not Saved.';
                if ($this->input->server('REQUEST_METHOD') == 'POST') {
                    $product_id = $this->input->post('pid');
                    $shop_id     = $_SESSION['user_data']['id'];
                    if ($this->input->post('is_cod')) {
                        $is_cod = '1';
                    } else {
                        $is_cod = '0';
                    }
                    if ($this->input->post('is_cancellation')) {
                        $is_cancellation = '1';
                    } else {
                        $is_cancellation = '0';
                    }
                    if ($this->input->post('is_featured')) {
                        $is_featured = '1';
                    } else {
                        $is_featured = '0';
                    }
                    $data       = array(
                        'product_id'    => $product_id,
                        'shop_id'    => $shop_id,
                        'is_cod'      => $is_cod,
                        'is_cancellation'         => $is_cancellation,
                        'is_featured'         => $is_featured,
                        'delivery_period'         => $this->input->post('delivery_period'),
                        'cancellation_period'         => $this->input->post('cancellation_period'),
                        'cancellation_content'         => $this->input->post('cancellation_content'),
                    );

                    if ($this->master_model->add_data('product_flags', $data)) {
                        $return['res'] = 'success';
                        $return['msg'] = 'Saved.';
                    }
                }

                echo json_encode($return);
                break;
            case 'edit-flags':

                if ($this->input->server('REQUEST_METHOD') == 'POST') {

                    $product_id = $this->input->post('pid');
                    $shop_id     = $_SESSION['user_data']['id'];
                    $data       = array(
                        'product_id'    => $product_id,
                        'shop_id'    => $shop_id,
                        'is_cod'      => $this->input->post('is_cod'),
                        'is_cancellation'         => $this->input->post('is_cancellation'),
                        'is_featured'         => $this->input->post('is_featured'),
                        'delivery_period'         => $this->input->post('delivery_period'),
                        'cancellation_period'         => $this->input->post('cancellation_period'),
                        'cancellation_content'         => $this->input->post('cancellation_content'),
                    );
                    if ($this->master_model->edit_product_flag($product_id, $shop_id, $data)) {
                        $return['res'] = 'success';
                        $return['msg'] = 'Updated.';
                    }
                }

                echo json_encode($return);
                break;
            case 'view_image':
                $data['product'] = $this->master_model->get_row_data1('products_photo', 'id', $p1);
                $page                       = 'shop/master/products/view_image';

                $this->load->view($page, $data);
                break;
            case 'plan_type':
                $data['pid'] = $p1;
                $data['plan_types']  = $this->master_model->get_data('subscriptions_plan_types', 'active', '1');
                $data['action_url']    = base_url() . 'shop-product-flags/add-plan-type/' . $p1;
                $page                  = 'shop/master/products/plan_type';
                $this->load->view($page, $data);

                break;
            case 'check_plan_type_existence':
                $plan_id_data = array();
                $plan_type_id_data = array();
                $pid = $this->input->post('pid');
                $shop_id  = $_SESSION['user_data']['id'];
                $plans    = $this->subscription_model->get_plan_data($pid, $shop_id);
                $plan_types  = $this->master_model->get_data('subscriptions_plan_types', 'active', '1');
                foreach ($plans as $plan) {
                    $data['plan_id'] = $plan['plan_id'];
                    array_push($plan_id_data, $data);
                }
                foreach ($plan_types as $plan_type) {
                    $data1['plan_type_id'] = $plan_type->id;
                    array_push($plan_type_id_data, $data1);
                }
                echo json_encode(array('data' => $plan_id_data, 'data2' => $plan_type_id_data));

                break;
            case 'add-plan-type':
                $return['res'] = 'error';
                $return['msg'] = 'Not Saved.';
                if ($this->input->server('REQUEST_METHOD') == 'POST') {
                    $product_id = $this->input->post('pid');
                    $shop_id = $_SESSION['user_data']['id'];
                    $plan_ids = $this->input->post('plan_id');
                    $data  = array(
                        'product_id'    => $product_id,
                        'shop_id'    => $shop_id,
                    );
                    $flag = $this->input->post('flag');
                    if ($flag == '1') {
                        if ($this->subscription_model->edit_product_plan_type($product_id, $shop_id, $plan_ids)) {
                            $return['res'] = 'success';
                            $return['msg'] = 'Updated.';
                        }
                    } else if ($flag == '0') {
                        if ($this->subscription_model->add_product_plan_type($product_id, $shop_id, $plan_ids)) {
                            $return['res'] = 'success';
                            $return['msg'] = 'Saved.';
                        }
                    }
                }

                echo json_encode($return);
                break;
            default:
                # code...
                break;
        }
    }
    //Shop Social
    public function shop_social()
    {
        $shop_id     = $_SESSION['user_data']['id'];
        $data['title']      = 'Shop Social';
        $data['socials']      = $this->shops_model->shop_social($shop_id);
        $data['remote']     = base_url() . 'shop-master-data/remote/shop_social/';
        $page               = 'shop/master/shop_social';
        $this->header_and_footer($page, $data);
    }
    public function add_shop_social()
    {
        $shop_id     = $_SESSION['user_data']['id'];
        $data = array(
            'icon'     => $this->input->post('icon'),
            'url'     => $this->input->post('url'),
            'shop_id'     => $shop_id,
        );
        if ($this->master_model->add_data('shop_social', $data)) {
            $this->session->set_flashdata('success', 'Icon Added Successfully');
            redirect($this->agent->referrer());
        } else {
            $this->session->set_flashdata('error', 'Something Went Wrong!!');
            redirect($this->agent->referrer());
        }
    }
    public function edit_shop_social()
    {
        $shop_id     = $_SESSION['user_data']['id'];
        $id = $this->uri->segment(3);
        $data = array(
            'icon'     => $this->input->post('icon'),
            'url'     => $this->input->post('url'),
            'shop_id'     => $shop_id,
        );
        if ($this->master_model->edit_data('shop_social', $id, $data)) {
            $this->session->set_flashdata('success', 'Icon Edited Successfully');
            redirect($this->agent->referrer());
        } else {
            redirect($this->agent->referrer());
        }
    }
    public function delete_shop_social()
    {
        $id = $this->uri->segment(3);
        if ($this->master_model->delete_data('shop_social', $id)) {
            $this->session->set_flashdata('success', 'Icon Deleted Successfully');
            redirect($this->agent->referrer());
        } else {
            $this->session->set_flashdata('error', 'Something Went Wrong!!');
            redirect($this->agent->referrer());
        }
    }
    public function fetch_category()
    {
        if ($this->input->post('parent_id')) {
            $pid = $this->input->post('parent_id');
            $this->master_model->fetch_category($pid);
        }
    }

    //Bank Accounts
    public function bank_accounts()
    {
        $shop_id     = $_SESSION['user_data']['id'];
        $data['title']      = 'Shop Social';
        $data['rows']    = $this->shops_model->shop_bank_accounts($shop_id);
        $data['remote']     = base_url() . 'shop-master-data/remote/bank_accounts/';
        $page               = 'shop/master/bank_accounts';
        $this->header_and_footer($page, $data);
    }
    public function add_bank_accounts()
    {
        $shop_id     = $_SESSION['user_data']['id'];
        $data = array(
            'account_no'    => $this->input->post('account_no'),
            'ifsc'          => $this->input->post('ifsc'),
            'bank_name'     => $this->input->post('bank_name'),
            'branch_name'   => $this->input->post('branch_name'),
            'shop_id'       => $shop_id,
            'dr_cr'         => $this->input->post('dr_cr'),
            'amount'        => $this->input->post('amount'),
            'remark'        => $this->input->post('remark'),
        );
        if ($this->master_model->add_data('shop_bank_accounts', $data)) {
            $this->session->set_flashdata('success', 'Added Successfully');
            redirect($this->agent->referrer());
        } else {
            $this->session->set_flashdata('error', 'Something Went Wrong!!');
            redirect($this->agent->referrer());
        }
    }
    public function edit_bank_accounts()
    {
        $shop_id     = $_SESSION['user_data']['id'];
        $id = $this->uri->segment(3);
        $data = array(
            'account_no'    => $this->input->post('account_no'),
            'ifsc'          => $this->input->post('ifsc'),
            'bank_name'     => $this->input->post('bank_name'),
            'branch_name'   => $this->input->post('branch_name'),
            'shop_id'       => $shop_id,
            'dr_cr'         => $this->input->post('dr_cr'),
            'amount'        => $this->input->post('amount'),
            'remark'        => $this->input->post('remark'),
        );
        if ($this->master_model->edit_data('shop_bank_accounts', $id, $data)) {
            $this->session->set_flashdata('success', 'Edited Successfully');
            redirect($this->agent->referrer());
        } else {
            redirect($this->agent->referrer());
        }
    }



    public function change_bank_accounts_status()
    {
        $id = $this->input->post('id');
        $data['status_data'] = $this->db->get_where('shop_bank_accounts', ['id'=>$id])->row();

        if ($data['status_data']->active == 1) {
            $data1 = array(
                'active' => 0
            );
        } else if ($data['status_data']->active == 0) {
            $data1 = array(
                'active' => 1
            );
        }
        $this->db->where('id', $id);
        $this->db->update('shop_bank_accounts', $data1);
        $this->load->view('admin/statusview', $data);
    }

    // cash account
    public function cash_account()
    {
        $shop_id     = $_SESSION['user_data']['id'];
        if ($this->input->server('REQUEST_METHOD')=='POST') {
            if ($this->shops_model->save_cash_account($shop_id)) {
                $this->session->set_flashdata('success', 'Edited Successfully');
            } else {
                $this->session->set_flashdata('error', 'Something Went Wrong!');
            }
        }
        $data['title']      = 'Shop Cash Account';
        $data['row']        = $this->shops_model->shop_cash_account($shop_id);
        $page               = 'shop/master/cash_account';
        $this->header_and_footer($page, $data);
    }


    //Fetch Product category
    public function fetch_cat()
    {
        if ($this->input->post('parent_cat_id')) {
            $parent_cat_id = $this->input->post('parent_cat_id');
            $this->master_model->fetch_category($parent_cat_id);
        }
    }
    //Fetch Sub categories
    public function fetch_sub_categories()
    {
        if ($this->input->post('parent_id')) {
            $parent_id = $this->input->post('parent_id');
            $this->master_model->fetch_sub_categories($parent_id);
        }
    }
    function multiple_delete()
    {
        if ($this->input->post('checkbox_value')) {
            $id = $this->input->post('checkbox_value');
            $table = $this->input->post('table');
            for ($count = 0; $count < count($id); $count++) {
                $this->master_model->delete_data($table, $id[$count]);
            }
        }
    }
}
