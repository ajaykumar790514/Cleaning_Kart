<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Master extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->isLoggedIn();
        $this->check_role_menu();
    }

    public function isLoggedIn()
    {
        $is_logged_in = $this->session->userdata('admin_logged_in');
        if (!isset($is_logged_in) || $is_logged_in !== TRUE) {
            redirect(base_url());
            exit;
        }
    }
    public function check_role_menu()
    {
        $admin_role_id = $_SESSION['admin_role_id'];
        $uri = $this->uri->segment(1);
        $role_menus = $this->admin_model->all_role_menu_data($admin_role_id);
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
        $admin_role_id = $_SESSION['admin_role_id'];
        $user_id = $_SESSION['user_id'];
        $data['dashboard'] = $this->admin_model->get_row_data('admin', 'id', $user_id);
        $data['admin_menus'] = $this->admin_model->get_role_menu_data($admin_role_id);
        $this->load->view('admin/includes/header', $data);
        $this->load->view($page);
        $this->load->view('admin/includes/footer');
    }

    public function index()
    {
        $menu_id = $this->uri->segment(2);
        $data['menu_id'] = $menu_id;
        $role_id = $_SESSION['admin_role_id'];
        $data['sub_menus'] = $this->admin_model->get_submenu_data($menu_id, $role_id);
        $data['title'] = 'Master';
        $page = 'admin/master/master_data';
        $this->header_and_footer($page, $data);
    }


    public function remote($type, $id = null, $column = 'name')
    {
        if ($type == 'category') {
            $tb = 'products_category';
        } elseif ($type == 'tax') {
            $tb = 'tax_slabs';
        } elseif ($type == 'products') {
            $tb = 'products_subcategory';
        } elseif ($type == 'products') {
            $tb = 'products_subcategory';
        } elseif ($type == 'unit') {
            $tb = 'unit_master';
        } elseif ($type == 'brand') {
            $tb = 'brand_master';
        } elseif ($type == 'tax_slab') {
            $tb = 'tax_slabs';
        } elseif ($type == 'product_props') {
            $tb = 'product_props_master';
        } elseif ($type == 'pincode') {
            $tb = 'pincodes_criteria';
        } elseif ($type == 'vendor') {
            $tb = 'vendors';
        } elseif ($type == 'shop_category') {
            $tb = 'shop_category';
        } elseif ($type == 'cancellation_reason') {
            $tb = 'cancellation_reason';
        } elseif ($type == 'shop_social') {
            $tb = 'shop_social';
        } else {
        }
        $this->db->where($column, $_GET[$column]);
        if ($id != NULL) {
            $this->db->where('id != ', $id)->where('is_deleted', 'NOT_DELETED');
        }
        $count = $this->db->count_all_results($tb);
        if ($count > 0) {
            echo "false";
        } else {
            echo "true";
        }
    }
    public function society_remote($type, $id = null, $column = 'name')
    {
        if ($type == 'societyr') {
            $tb = 'society_master';
        } else {
        }
        $this->db->where($column, $_GET[$column]);
        if ($id != NULL) {
            $this->db->where('socity_id != ', $id);
        }
        $count = $this->db->count_all_results($tb);
        if ($count > 0) {
            echo "false";
        } else {
            echo "true";
        }
    }
    // public function add_category()
    // {
    //     $tax_slab = explode(",",$this->input->post('tax_id'));

    //     $data = array(
    //         'tax_id'     => $tax_slab[0],
    //         'tax_value'     => $tax_slab[1],
    //         'name'     => $this->input->post('name'),
    //         'is_parent'     => $this->input->post('parent_id'),
    //         'description'     => $this->input->post('description'),
    //     );

    //     if ($this->master_model->add_category($data)) {
    //         $this->session->set_flashdata('success', 'Category Added Successfully');
    //         redirect($this->agent->referrer());
    //     } else {
    //         $this->session->set_flashdata('error', 'Something Went Wrong!!');
    //         redirect($this->agent->referrer());
    //     }
    // }
    // public function edit_category()
    // {
    //     $id = $this->uri->segment(2);
    //     $tax_slab = explode(",",$this->input->post('tax_id'));

    //     $data = array(
    //         'tax_id'     => $tax_slab[0],
    //         'tax_value'     => $tax_slab[1],
    //         'name'     => $this->input->post('name'),
    //         'description'     => $this->input->post('description'),
    //     );

    //     if ($this->master_model->edit_category($data,$id)) {
    //         redirect($this->agent->referrer());
    //     } else {
    //         $this->session->set_flashdata('error', 'Something Went Wrong!!');
    //         redirect($this->agent->referrer());
    //     }
    // }
    public function delete_category()
    {
        $id = $this->uri->segment(3);
        if ($this->master_model->delete_data('products_category', $id)) {
            redirect($this->agent->referrer());
        } else {
            $this->session->set_flashdata('error', 'Something Went Wrong!!');
            redirect($this->agent->referrer());
        }
    }

    //Products

    // Start::collection_manager 
    public function products($action = null, $p1 = null, $p2 = null, $p3 = null, $p4 = null, $p5 = null)
    {
        // $data['user']    = $this->checkLogin();
        switch ($action) {
            case null:
                $data['menu_id'] = $this->uri->segment(2);
                $data['title']          = 'Products';
                $data['unit_type']      = $this->master_model->view_data('unit_master');
                $data['categories']     = $this->master_model->view_data('products_category');
                $data['tb_url']         = base_url() . 'products/tb';
                $data['new_url']        = base_url() . 'products/create';
                $page                   = 'admin/master/products/index';
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
                $config["base_url"]         = base_url() . "products/tb/" . $parent_id . "/" . $cat_id . "/" . $child_cat_id . "/" . $search;
                $config["total_rows"]       = $this->master_model->products($parent_id, $cat_id, $child_cat_id, $search);
                $data['total_rows']         = $config["total_rows"];
                $config["per_page"]         = 20;
                $config["uri_segment"]      = 7;
                $ustomeronfig['attributes']       = array('class' => 'pag-link');
                $config['full_tag_open']    = "<div class='pag'>";
                $config['full_tag_close']   = "</div>";
                $config['first_link']       = '&lt;&lt;';
                $config['last_link']        = '&gt;&gt;';
                $this->pagination->initialize($config);
                $data["links"]              = $this->pagination->create_links();
                $data['page']               = $page = ($p5 != null) ? $p5 : 0;
                $data['per_page']           = $config["per_page"];
                $data['products']           = $this->master_model->products($parent_id, $cat_id, $child_cat_id, $search, $config["per_page"], $page);
                $data['update_url']         = base_url() . 'products/create/';
                $data['image_url']         = base_url() . 'products/view_image/';
                $data['duplicate_url']         = base_url() . 'products/duplicate/';
                $data['pv_url']             = base_url() . 'products/add-property-value/';
                $data['map_url']             = base_url() . 'products/map-product/';
                $data['pf_url']             = base_url() . 'products/flags/';
                $data['plan_type_url']             = base_url() . 'products/plan_type/';
                $data['pimg_url']           = base_url() . 'products/property-image/';
                $page                       = 'admin/master/products/tb';
                $data['properties']         = $this->master_model->view_data('product_props_master');
                $data['unit_type']          = $this->master_model->view_data('unit_master');
                $data['categories']         = $this->master_model->view_data('products_category');
                $data['parent_cat'] = $this->master_model->get_data('products_category', 'is_parent', '0');

                $this->load->view($page, $data);
                break;

            case 'map-product':
                $data['product_id'] = $p1;
                $data['parent_cat'] = $this->master_model->get_data('products_category', 'is_parent', '0');
                $data['products'] = $this->master_model->get_map_products($p1);
                $page                       = 'admin/master/products/map_product';
                $this->load->view($page, $data);
                break;
            case 'fetch_products':
                $psearch = 'null';
                $data['psearch'] = '';
                $parent_id = 'null';
                $data['parent_id'] = '';

                if (@$_POST['psearch']) {
                    $data['psearch'] = $_POST['psearch'];
                    $psearch = $_POST['psearch'];
                }
                if (@$_POST['parent_cat_id']) {
                    $data['parent_id'] = $_POST['parent_cat_id'];
                    $parent_id = $_POST['parent_cat_id'];
                }

                $product_id = $this->input->post('product_id');

                $data['product_id'] = $product_id;
                $data['available_products'] = $this->master_model->get_products($parent_id, $psearch, $product_id);
                $data['product_mapping'] = $this->master_model->get_mapped_data($product_id);
                $this->load->view('admin/master/products/available_products', $data);


                break;
            case 'delete_map_product':
                $pid = $this->input->post('pid');
                $product_id = $this->input->post('product_id');

                if ($this->db->where('map_pro_id', $pid)->delete('products_mapping') && $this->db->where('pro_id', $pid)->delete('products_mapping')) {
                    $data['product_id'] = $product_id;
                    $data['parent_cat'] = $this->master_model->get_data('products_category', 'is_parent', '0');
                    $data['products'] = $this->master_model->get_map_products($product_id);
                    $page                       = 'admin/master/products/map_product';
                    $this->load->view($page, $data);
                }

                break;
            case 'remove_map_product':

                $pid = $this->input->post('pid');
                $product_id = $this->input->post('product_id');
                $data['pid'] = $pid;
                $data['flg'] = '0';
                if ($this->db->where('map_pro_id', $pid)->delete('products_mapping') && $this->db->where('pro_id', $pid)->delete('products_mapping')) {
                    $this->db->where(['map_pro_id' => $pid, 'pro_id' => $product_id])->delete('products_mapping');
                    $this->load->view('admin/master/products/map_unmap', $data);
                }

                break;

            case 'view_image':
                $data['product'] = $this->master_model->get_row_data1('products_photo', 'id', $p1);
                $page                       = 'admin/master/products/view_image';

                $this->load->view($page, $data);
                break;

            case 'create':
                $data['remote']             = base_url() . 'master-data/remote/products/';
                $data['action_url']         = base_url() . 'products/save';
                $data['tax_slabs'] = $this->master_model->get_data('tax_slabs', 'active', '1');
                $page                       = 'admin/master/products/create';
                if ($p1 != null) {
                    $data['action_url']     = base_url() . 'products/save/' . $p1;
                    $data['value']          = $this->master_model->product($p1);
                    $data['remote']         = base_url() . 'master-data/remote/products/' . $p1;
                    $page                   = 'admin/master/products/update';
                }
                $data['properties']         = $this->master_model->view_data('product_props_master');
                $data['unit_type']          = $this->master_model->get_data('unit_master', 'active', '1');
                $data['brands']          = $this->master_model->get_data('brand_master', 'active', '1');

                $data['parent_cat'] = $this->master_model->get_parent_category();
                $data['parent_id'] = $this->master_model->get_parent_id();
                $data['categories'] = $this->master_model->get_data('products_category', 'is_parent !=', '0');
                // $data['categories']         = $this->master_model->view_data('products_category');
                $data['form_id']            = uniqid();


                $this->load->view($page, $data);
                break;
            case 'duplicate':
                $data['tax_slabs'] = $this->master_model->get_data('tax_slabs', 'active', '1');
                $data['properties']         = $this->master_model->view_data('product_props_master');
                $data['unit_type']          = $this->master_model->get_data('unit_master', 'active', '1');
                $data['brands']          = $this->master_model->get_data('brand_master', 'active', '1');

                $data['parent_cat'] = $this->master_model->get_parent_category();
                $data['parent_id'] = $this->master_model->get_parent_id();
                $data['categories'] = $this->master_model->get_data('products_category', 'is_parent !=', '0');
                $data['action_url']     = base_url() . 'products/save';
                $data['value']          = $this->master_model->product($p1);
                $data['remote']         = base_url() . 'master-data/remote/products/';
                $page                   = 'admin/master/products/duplicate';
                $this->load->view($page, $data);
                break;
            case 'delete_image':
                //delete code    
                $id = $p2;
                if ($this->master_model->delete_pro_image($id)) {

                    $data['pid']           = $p1;
                    $data['images']        = $this->master_model->product_img($p1);
                    $data['action_url']    = base_url() . 'products/property-image/' . $p1;
                    $data['form_id']       = uniqid();
                    $page                  = 'admin/master/products/property_images';

                    $this->load->view($page, $data);
                }
                break;
            case 'delete_product':
                $id = $p1;
                if ($this->master_model->delete_product($id)) {
                    $data['search'] = '';
                    $data['cat_id'] = '';
                    $data['parent_id'] = '';
                    //below variable section used for models and other places
                    $cat_id = 'null';
                    $parent_id = 'null';
                    //get section intiliazation
                    if ($p2 != null) {
                        $data['parent_id'] = $p1;
                        $data['cat_id'] = $p2;
                        $parent_id = $p1;
                        $cat_id = $p2;
                        $data['sub_cat'] = $this->db->get_where('products_category', ['is_parent' => $p1, 'is_deleted' => 'NOT_DELETED'])->result();
                    }
                    //end of section
                    if (@$_POST['search']) {
                        $data['search'] = $_POST['search'];
                        $data['parent_id'] = $_POST['parent_id'];
                        $data['cat_id'] = $_POST['cat_id'];
                        $cat_id = $_POST['cat_id'];
                        $parent_id = $_POST['parent_id'];
                        $search = $_POST['search'];
                    }
                    if (@$_POST['cat_id']) {
                        $data['search'] = $_POST['search'];
                        $data['cat_id'] = $_POST['cat_id'];
                        $data['parent_id'] = $_POST['parent_id'];
                        $cat_id = $_POST['cat_id'];
                        $parent_id = $_POST['parent_id'];
                        $search = $_POST['search'];
                        $data['sub_cat'] = $this->db->get_where('products_category', ['is_parent' => $_POST['parent_id'], 'is_deleted' => 'NOT_DELETED'])->result();
                    }

                    $this->load->library('pagination');
                    $config = array();
                    $config["base_url"]         = base_url() . "products/tb/" . $parent_id . "/" . $cat_id;
                    $config["total_rows"]       = $this->master_model->products($parent_id, $cat_id);
                    $data['total_rows']         = $config["total_rows"];
                    $config["per_page"]         = 20;
                    $config["uri_segment"]      = 5;
                    $config['attributes']       = array('class' => 'pag-link');
                    $config['full_tag_open']    = "<div class='pag'>";
                    $config['full_tag_close']   = "</div>";
                    $config['first_link']       = '&lt;&lt;';
                    $config['last_link']        = '&gt;&gt;';
                    $this->pagination->initialize($config);
                    $data["links"]              = $this->pagination->create_links();
                    $data['page']               = $page = ($p3 != null) ? $p3 : 0;
                    $data['per_page']           = $config["per_page"];
                    $data['products']           = $this->master_model->products($parent_id, $cat_id, $config["per_page"], $page);
                    $data['update_url']         = base_url() . 'products/create/';
                    $data['image_url']         = base_url() . 'products/view_image/';
                    $data['duplicate_url']         = base_url() . 'products/duplicate/';
                    $data['map_url']             = base_url() . 'products/map-product/';
                    $data['pv_url']             = base_url() . 'products/add-property-value/';
                    $data['pf_url']             = base_url() . 'products/flags/';
                    $data['pimg_url']           = base_url() . 'products/property-image/';
                    $page                       = 'admin/master/products/tb';


                    $data['properties']         = $this->master_model->view_data('product_props_master');
                    $data['unit_type']          = $this->master_model->view_data('unit_master');
                    $data['categories']         = $this->master_model->view_data('products_category');
                    $data['parent_cat'] = $this->master_model->get_data('products_category', 'is_parent', '0');

                    $this->load->view($page, $data);
                }
                break;
            case 'make_cover':
                $id = $p2;
                if ($this->master_model->remove_product_cover($p1) && $this->master_model->make_product_cover($id)) {
                    $data['pid']           = $p1;
                    $data['images']        = $this->master_model->product_img($p1);
                    $data['action_url']    = base_url() . 'products/property-image/' . $p1;
                    $data['form_id']       = uniqid();
                    $page                  = 'admin/master/products/property_images';

                    $this->load->view($page, $data);
                }
                break;
            case 'update_prod_seq':
                $id = $p2;
                $seq = $p3;
                $data = array(
                    'seq'     => $seq,
                );
                if ($this->master_model->update_prod_seq($id, $data)) {
                    $data['pid']           = $p1;
                    $data['images']        = $this->master_model->product_img($p1);
                    $data['action_url']    = base_url() . 'products/property-image/' . $p1;
                    $data['form_id']       = uniqid();
                    $page                  = 'admin/master/products/property_images';

                    $this->load->view($page, $data);
                } else {
                    echo ('Sequence Already Exists!!');
                }
                break;

            case 'save':
                $id = $p1;
                $return['res'] = 'error';
                $return['msg'] = 'Not Saved!';

                if ($this->input->server('REQUEST_METHOD') == 'POST') {

                    if ($id != null) {
                        $tax_slab = explode(",", $this->input->post('tax_id'));
                        $unit_type = explode(",", $this->input->post('unit_type_id'));

                        $data = array(
                            'tax_id'     => $tax_slab[0],
                            'tax_value'     => $tax_slab[1],
                            'parent_cat_id'     => $this->input->post('parent_cat_id'),
                            'sub_cat_id'     => $this->input->post('cat_id'),
                            'name'              => $this->input->post('name'),
                            'search_keywords'   => $this->input->post('search_keywords'),
                            'product_code'      => $this->input->post('product_code'),
                            'unit_value'        => $this->input->post('unit_value'),
                            'unit_type_id'         => $unit_type[0],
                            'unit_type'         => $unit_type[1],
                            'description'       => $this->input->post('description'),
                            'sku'        => $this->input->post('sku'),
                            'brand_id'        => $this->input->post('brand_id'),
                        );
                        if ($this->master_model->edit_product($data, $id)) {
                            $return['res'] = 'success';
                            $return['msg'] = 'Saved.';
                        }
                    } else {
                        $tax_slab = explode(",", $this->input->post('tax_id'));
                        $unit_type = explode(",", $this->input->post('unit_type_id'));

                        $data = array(
                            'tax_id'     => $tax_slab[0],
                            'tax_value'     => $tax_slab[1],
                            'parent_cat_id'     => $this->input->post('parent_cat_id'),
                            'sub_cat_id'     => $this->input->post('cat_id'),
                            'name'              => $this->input->post('name'),
                            'search_keywords'   => $this->input->post('search_keywords'),
                            'product_code'      => $this->input->post('product_code'),
                            'unit_value'        => $this->input->post('unit_value'),
                            'unit_type_id'         => $unit_type[0],
                            'unit_type'         => $unit_type[1],
                            'description'       => $this->input->post('description'),
                            'sku'        => $this->input->post('sku'),
                            'brand_id'        => $this->input->post('brand_id'),
                        );

                        if ($this->master_model->add_product($data)) {
                            $return['res'] = 'success';
                            $return['msg'] = 'Saved.';
                        }
                    }
                }
                echo json_encode($return);
                break;

            case 'add-property-value':
                if ($this->input->server('REQUEST_METHOD') == 'POST') {
                    $product_id = $this->input->post('pid');
                    $props_id = $this->input->post('props_id');
                    $data       = array(
                        'product_id'    => $product_id,
                        'props_id'      => $this->input->post('props_id'),
                        'value'         => $this->input->post('value'),
                    );
                    $data1['get_product_props']    = $this->master_model->get_product_props($product_id, $props_id);
                    if ($data1['get_product_props']) {
                        if ($this->master_model->update_product_props($product_id, $props_id, $data)) {
                            $data['pid'] = $this->input->post('pid');
                            $pid = $this->input->post('pid');
                            $data['property_val']    = $this->master_model->get_property_val($pid);
                            $data['properties']    = $this->master_model->get_data('product_props_master', 'active', '1');
                            $data['action_url']    = base_url() . 'products/add-property-value/' . $pid;
                            $data['form_id']       = uniqid();
                            $page                  = 'admin/master/products/property_value';
                            $this->load->view($page, $data);
                        }
                    } else {
                        if ($this->master_model->add_product_props($data)) {
                            $data['pid'] = $this->input->post('pid');
                            $pid = $this->input->post('pid');
                            $data['property_val']    = $this->master_model->get_property_val($pid);
                            $data['properties']    = $this->master_model->get_data('product_props_master', 'active', '1');
                            $data['action_url']    = base_url() . 'products/add-property-value/' . $pid;
                            $data['form_id']       = uniqid();
                            $page                  = 'admin/master/products/property_value';
                            $this->load->view($page, $data);
                        }
                    }
                } else {
                    $data['pid'] = $p1;
                    $data['property_val']    = $this->master_model->get_property_val($p1);
                    $data['properties']    = $this->master_model->get_data('product_props_master', 'active', '1');
                    $data['action_url']    = base_url() . 'products/add-property-value/' . $p1;
                    $data['form_id']       = uniqid();
                    $page                  = 'admin/master/products/property_value';

                    $this->load->view($page, $data);
                }

                break;

            case 'flags':
                $data['pid'] = $p1;
                // $shop_id  = $this->input->post('shop_id');
                // $data['flags']    = $this->master_model->get_flags_data($p1,$shop_id);
                // print_r($data['flags']);
                // // $data['flags']    = $this->master_model->get_flags_data1($p1);
                // if(!empty($data['flags_data']))
                // {
                //     $business_id = $data['flags']->business_id;  
                //     $data['shops']  = $this->master_model->get_data('shops','business_id',$business_id);

                // }
                $data['business']  = $this->master_model->view_data('business');
                $data['action_url']    = base_url() . 'products/add-flags/' . $p1;
                $data['form_id']       = uniqid();
                $page                  = 'admin/master/products/product_flags';
                $this->load->view($page, $data);

                break;
            case 'check_flag_existence':
                $pid = $this->input->post('pid');
                $shop_id  = $this->input->post('shop_id');
                $data['flags']    = $this->master_model->get_flags_data($pid, $shop_id);
                echo json_encode(array('data' => $data['flags']));

                // // $data['flags']    = $this->master_model->get_flags_data1($p1);
                // if(!empty($data['flags_data']))
                // {
                //     $business_id = $data['flags']->business_id;  
                //     $data['shops']  = $this->master_model->get_data('shops','business_id',$business_id);

                // }

                break;
            case 'add-flags':
                $return['res'] = 'error';
                $return['msg'] = 'Not Saved.';
                if ($this->input->server('REQUEST_METHOD') == 'POST') {
                    $product_id = $this->input->post('pid');
                    $shop_id = $this->input->post('shop_id');
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
                    $flag = $this->input->post('flag');
                    if ($flag == '1') {
                        if ($this->master_model->edit_product_flag($product_id, $shop_id, $data)) {
                            $return['res'] = 'success';
                            $return['msg'] = 'Updated.';
                        }
                    } else if ($flag == '0') {
                        if ($this->master_model->add_data('product_flags', $data)) {
                            $return['res'] = 'success';
                            $return['msg'] = 'Saved.';
                        }
                    }
                }

                echo json_encode($return);
                break;

            case 'plan_type':
                $data['pid'] = $p1;
                $data['business']  = $this->master_model->view_data('business');
                $data['plan_types']  = $this->master_model->get_data('subscriptions_plan_types', 'active', '1');
                $data['action_url']    = base_url() . 'products/add-plan-type/' . $p1;
                $page                  = 'admin/master/products/plan_type';
                $this->load->view($page, $data);

                break;
            case 'check_plan_type_existence':
                $plan_id_data = array();
                $plan_type_id_data = array();
                $pid = $this->input->post('pid');
                $shop_id  = $this->input->post('shop_id');
                $plans    = $this->subscription_model->get_plan_data($pid, $shop_id);
                $plan_types  = $this->master_model->get_data('subscriptions_plan_types', 'active', '1');
                // print_r($plan_types);
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
                    $shop_id = $this->input->post('shop_id');
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
            case 'update_prop_value':
                $id =     $this->input->post('id');
                $pid =     $this->input->post('pid');
                $data       = array(
                    'props_id'         => $this->input->post('props_id'),
                    'value'         => $this->input->post('propvalue'),
                );
                if ($this->master_model->edit_data('product_props', $id, $data)) {
                    $data['pid']    = $pid;
                    $data['property_val']    = $this->master_model->get_property_val($pid);
                    // $data['property_val']    = $this->master_model->get_data('product_props','product_id',$p2);
                    $data['properties']    = $this->master_model->view_data('product_props_master');
                    $data['action_url']    = base_url() . 'products/add-property-value/' . $p2;
                    $data['form_id']       = uniqid();
                    $page                  = 'admin/master/products/property_value';

                    $this->load->view($page, $data);
                }
                break;

            case 'delete_prop_val':
                $id = $p1;
                if ($this->master_model->delete_prop_val($id)) {
                    $data['pid']    = $p2;
                    $data['property_val']    = $this->master_model->get_property_val($p2);
                    // $data['property_val']    = $this->master_model->get_data('product_props','product_id',$p2);
                    $data['properties']    = $this->master_model->view_data('product_props_master');
                    $data['action_url']    = base_url() . 'products/add-property-value/' . $p2;
                    $data['form_id']       = uniqid();
                    $page                  = 'admin/master/products/property_value';

                    $this->load->view($page, $data);
                }
                break;



            case 'property-image':

                if ($this->input->server('REQUEST_METHOD') == 'POST') {
                    $return['res'] = 'error';
                    $return['msg'] = 'Not Saved!';

                    $product_id = $p1;
                    $data       = array(
                        'product_id'    => $product_id,
                        'props_id'      => $this->input->post('props_id'),
                        'value'         => $this->input->post('value'),
                    );
                    if ($this->master_model->product_img_upload($p1)) {
                        $return['res'] = 'success';
                        $return['msg'] = 'Saved.';
                    }
                    echo json_encode($return);
                } else {
                    $data['pid'] = $p1;
                    $data['images']        = $this->master_model->product_img($p1);
                    $data['action_url']    = base_url() . 'products/property-image/' . $p1;
                    $data['form_id']       = uniqid();
                    $page                  = 'admin/master/products/property_images';

                    // echo "<pre>";
                    // print_r($p1);
                    // echo "</pre>";
                    // die();

                    $this->load->view($page, $data);
                }

                break;
            case 'add_image':
                $id = $this->input->post('pid');
                $imageCount = count($_FILES['file']['name']);
                if (!empty($imageCount)) {
                    for ($i = 0; $i < $imageCount; $i++) {
                        $config['file_name'] = date('Ymd') . rand(1000, 1000000);
                        $config['upload_path'] = UPLOAD_PATH . 'product/';
                        $config['allowed_types'] = 'jpg|jpeg|png|gif';
                        $this->load->library('upload', $config);
                        $this->upload->initialize($config);
                        $_FILES['files']['name'] = $_FILES['file']['name'][$i];
                        $_FILES['files']['type'] = $_FILES['file']['type'][$i];
                        $_FILES['files']['tmp_name'] = $_FILES['file']['tmp_name'][$i];
                        $_FILES['files']['size'] = $_FILES['file']['size'][$i];
                        $_FILES['files']['error'] = $_FILES['file']['error'][$i];

                        if ($this->upload->do_upload('files')) {
                            $imageData = $this->upload->data();
                            $config2 = array(
                                'image_library' => 'gd2', //get original image
                                'source_image' =>   UPLOAD_PATH . 'product/' . $imageData['file_name'],
                                'width' => 640,
                                'height' => 360,
                                'new_image' =>  UPLOAD_PATH . 'product/thumbnail/' . $imageData['file_name'],

                            );
                            $this->load->library('image_lib');
                            $this->image_lib->initialize($config2);
                            $this->image_lib->resize();
                            $this->image_lib->clear();
                            $images[] = "product/" . $imageData['file_name'];
                            $images2[] = "product/thumbnail/" . $imageData['file_name'];
                        }
                    }
                }
                if (!empty($images)) {
                    foreach (array_combine($images, $images2) as $file => $file2) {
                        $file_data = array(
                            'img' => $file,
                            'thumbnail' => $file2,
                            'item_id' => $id
                        );
                        $this->db->insert('products_photo', $file_data);
                    }
                }
                break;

            case 'delete_product':
                $id = $p1;
                // $data1['images']        = $this->master_model->product_img($id);
                // print_r($data1['images']->img);
                // die();
                if ($this->master_model->delete_product($id)) {
                    $data['search'] = '';
                    if (@$_POST['search']) {
                        $data['search'] = $_POST['search'];
                    }
                    $data['cat_id'] = '';
                    if (@$_POST['cat_id']) {
                        $data['cat_id'] = $_POST['cat_id'];
                    }

                    $this->load->library('pagination');
                    $config = array();
                    $config["base_url"]         = base_url() . "products/tb/";
                    $config["total_rows"]       = count($this->master_model->products());
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
                    $data['products']           = $this->master_model->products($config["per_page"], $page);
                    $data['update_url']         = base_url() . 'products/create/';
                    $data['duplicate_url']         = base_url() . 'products/duplicate/';
                    $data['map_url']             = base_url() . 'products/map-product/';
                    $data['pv_url']             = base_url() . 'products/add-property-value/';
                    $data['pimg_url']           = base_url() . 'products/property-image/';
                    $page                       = 'admin/master/products/tb';


                    $data['properties']         = $this->master_model->view_data('product_props_master');
                    $data['unit_type']          = $this->master_model->view_data('unit_master');
                    $data['categories']         = $this->master_model->view_data('products_category');

                    $data['parent_cat'] = $this->master_model->get_data('products_category', 'is_parent', '0');
                    $this->load->view($page, $data);
                }
                break;

            case 'map_product':
                $pid = $this->input->post('pid');

                $product_id = $this->input->post('product_id');

                $data1['flg'] = '1';

                $data1['pid'] = $pid;
                $data = array(
                    'pro_id'     => $product_id,
                    'map_pro_id'     => $pid,
                );
                $rev_data = array(
                    'pro_id'     => $pid,
                    'map_pro_id'     => $product_id,
                );
                $getmapdata =  $this->db->where(['pro_id' => $product_id])->get('products_mapping')->result();
                if (!empty($getmapdata)) {
                    foreach ($getmapdata as $map_data) {
                        $rev_map_data = array(
                            'map_pro_id'     => $map_data->map_pro_id,
                            'pro_id'     => $pid,
                        );
                        $map_data = array(
                            'pro_id'     => $map_data->map_pro_id,
                            'map_pro_id'     => $pid,
                        );
                        $this->master_model->add_data('products_mapping', $map_data);
                        $this->master_model->add_data('products_mapping', $rev_map_data);
                    }
                }
                if ($this->master_model->add_data('products_mapping', $data) && $this->master_model->add_data('products_mapping', $rev_data)) {
                    $this->load->view('admin/master/products/map_unmap', $data1);
                }
                break;
            default:
                # code...
                break;
        }
    }
    public function categories($action = null, $p1 = null, $p2 = null, $p3 = null)
    {
        // $data['user']    = $this->checkLogin();
        switch ($action) {
            case null:
                $data['menu_id'] = $this->uri->segment(2);
                $data['title'] = 'Categories';
                $data['parent_cat'] = $this->master_model->get_data('products_category', 'is_parent', '0');
                $data['tax_slabs'] = $this->master_model->view_data('tax_slabs');
                $data['tb_url']         = base_url() . 'categories/tb';
                $data['new_url']        = base_url() . 'categories/create';
                $page = 'admin/master/categories/index';
                $this->header_and_footer($page, $data);
                break;

            case 'tb':
                $data['cat_id'] = '';
                $data['parent_id'] = '';
                //below variable section used for models and other places
                $cat_id = 'null';
                $parent_id = 'null';
                //get section intiliazation
                if ($p2 != null) {
                    $data['parent_id'] = $p1;
                    $data['cat_id'] = $p2;
                    $parent_id = $p1;
                    $cat_id = $p2;
                    $data['sub_cat'] = $this->db->get_where('products_category', ['is_parent' => $p1, 'is_deleted' => 'NOT_DELETED'])->result();
                }
                //end of section

                if (@$_POST['parent_id']) {
                    $data['parent_id'] = $_POST['parent_id'];
                    $parent_id = $_POST['parent_id'];
                }
                if (@$_POST['cat_id']) {
                    $data['cat_id'] = $_POST['cat_id'];
                    $cat_id = $_POST['cat_id'];
                    $data['sub_cat'] = $this->db->get_where('products_category', ['is_parent' => $_POST['parent_id'], 'is_deleted' => 'NOT_DELETED'])->result();
                }
                $this->load->library('pagination');
                $config = array();
                $config["base_url"]         = base_url() . "categories/tb/";
                $config["total_rows"]       = count($this->master_model->get_parent_cat($parent_id, $cat_id));
                $data['total_rows']         = $config["total_rows"];
                $config["per_page"]         = 5;
                $config["uri_segment"]      = 3;
                $config['attributes']       = array('class' => 'pag-link');
                $config['full_tag_open']    = "<div class='pag'>";
                $config['full_tag_close']   = "</div>";
                $config['first_link']       = '&lt;&lt;';
                $config['last_link']        = '&gt;&gt;';
                $this->pagination->initialize($config);
                $data["links"]              = $this->pagination->create_links();
                $data['page']               = $page = ($p1 != null) ? $p1 : 0;

                $data['parent_cat'] = $this->master_model->get_parent_cat($parent_id, $cat_id, $config["per_page"], $page);
                $data['parent_cat_list'] = $this->master_model->get_parent_cat_list();
                $data['categories'] = $this->master_model->get_categories($parent_id, $cat_id);
                $data['per_page']           = $config["per_page"];
                $data['update_url']         = base_url() . 'categories/create/';
                $data['image_url']         = base_url() . 'categories/view_image/';
                $page                       = 'admin/master/categories/tb';



                $data['tax_slabs'] = $this->master_model->view_data('tax_slabs');

                $this->load->view($page, $data);
                break;
            case 'create':
                $data['remote']             = base_url() . 'master-data/remote/category/';
                $data['action_url']         = base_url() . 'categories/save';
                $data['tax_slabs'] = $this->master_model->get_data('tax_slabs', 'active', '1');
                $page                       = 'admin/master/categories/create';
                if ($p1 != null) {
                    $data['remote']             = base_url() . 'master-data/remote/category/';
                    $data['action_url']     = base_url() . 'categories/save/' . $p1;
                    $data['value']          = $this->master_model->category($p1);
                    $data['tax_slabs'] = $this->master_model->view_data('tax_slabs');

                    $data['remote']         = base_url() . 'master-data/remote/products/' . $p1;
                    $page                   = 'admin/master/categories/update';
                }
                $data['properties']         = $this->master_model->view_data('product_props_master');
                $data['unit_type']          = $this->master_model->view_data('unit_master');

                $data['parent_cat'] = $this->master_model->get_parent_category();
                $data['parent_id'] = $this->master_model->get_parent_id();
                $data['form_id']            = uniqid();


                $this->load->view($page, $data);
                break;
            case 'view_image':
                $data['category'] = $this->master_model->get_row_data('products_category', 'id', $p1);
                $page                       = 'admin/master/categories/view_image';

                $this->load->view($page, $data);
                break;

            case 'save':
                $id = $p1;
                $return['res'] = 'error';
                $return['msg'] = 'Not Saved!';

                if ($this->input->server('REQUEST_METHOD') == 'POST') {
                    if ($id != null) {
                        $tax_slab = explode(",", $this->input->post('tax_id'));
                        if ($this->input->post('tax_id') == "")
                            $tax_slab = "0,0.0";
                        if ($this->input->post('parent_id') && !$this->input->post('sub_cat_id')) {
                            $is_parent = $this->input->post('parent_id');
                        } else if ($this->input->post('parent_id') && $this->input->post('sub_cat_id')) {
                            $is_parent = $this->input->post('sub_cat_id');
                        } else {
                            $is_parent = '0';
                        }
                        $data = array(
                            'tax_id'     => $tax_slab[0],
                            'tax_value'     => $tax_slab[1],
                            'name'     => $this->input->post('name'),
                            'is_parent'     => $is_parent,
                            'description'     => $this->input->post('description'),
                            'seq'     => $this->input->post('seq'),
                        );
                        if ($this->master_model->edit_category($data, $id)) {
                            $return['res'] = 'success';
                            $return['msg'] = 'Saved.';
                        }
                    } else {
                        $tax_slab = explode(",", $this->input->post('tax_id'));
                        if ($this->input->post('tax_id') == "")
                            $tax_slab = "0,0.0";
                        if ($this->input->post('parent_id') && !$this->input->post('sub_cat_id')) {
                            $is_parent = $this->input->post('parent_id');
                        } else if ($this->input->post('parent_id') && $this->input->post('sub_cat_id')) {
                            $is_parent = $this->input->post('sub_cat_id');
                        } else {
                            $is_parent = '0';
                        }
                        $data = array(
                            'tax_id'     => $tax_slab[0],
                            'tax_value'     => $tax_slab[1],
                            'is_parent'     => $is_parent,
                            'name'     => $this->input->post('name'),
                            'description'     => $this->input->post('description'),
                            'seq'     => $this->input->post('seq'),
                        );
                        $fileinfo = @getimagesize($_FILES["icon"]["tmp_name"]);
                        $width = $fileinfo[0];
                        $height = $fileinfo[1];
                        // if ($width > "300" || $height > "200") {

                        //         $return['res'] = 'error';
                        //         $return['msg'] = 'Image dimension should be within 300X200';

                        // }
                        if ($this->master_model->add_category($data)) {
                            $return['res'] = 'success';
                            $return['msg'] = 'Saved.';
                        }
                    }
                }
                echo json_encode($return);
                break;
        }
    }

    public function products_oldd($p = null)
    {
        $data['title'] = 'Products';

        // $data['products'] = $this->master_model->view_data('products_subcategory');

        $data['search'] = '';
        if (@$_POST['search']) {
            $data['search'] = $_GET['search'];
        }
        $this->load->library('pagination');
        $config = array();
        $config["base_url"]         = base_url() . "products";
        $config["total_rows"]       = count($this->master_model->products());
        $data['total_rows']         = $config["total_rows"];
        $config["per_page"]         = 20;
        $config["uri_segment"]      = 2;
        $config['attributes']       = array('class' => 'pag-link');
        $config['full_tag_open']    = "<div class='pag'>";
        $config['full_tag_close']   = "</div>";
        $config['first_link']        = '&lt;&lt;';
        $config['last_link']        = '&gt;&gt;';
        $this->pagination->initialize($config);
        $data["links"]          = $this->pagination->create_links();
        $data['page']           = $page = ($p != null) ? $p : 0;
        $data['per_page']       = $config["per_page"];
        $data['products']       = $this->master_model->products($config["per_page"], $page);
        $data['properties']     = $this->master_model->view_data('product_props_master');
        $data['unit_type']      = $this->master_model->view_data('unit_master');
        $data['categories']     = $this->master_model->view_data('products_category');
        $data['remote']         = base_url() . 'master-data/remote/products/';
        $page                   = 'admin/master/products';
        $this->header_and_footer($page, $data);
    }

    public function products_old()
    {
        $data['title'] = 'Products';

        $data['products'] = $this->master_model->view_data('products_subcategory');

        $data['properties'] = $this->master_model->view_data('product_props_master');
        $data['unit_type'] = $this->master_model->view_data('unit_master');
        $data['categories'] = $this->master_model->view_data('products_category');
        $data['remote']     = base_url() . 'master-data/remote/products/';
        $page = 'admin/master/products';
        $this->header_and_footer($page, $data);
    }

    public function add_product()
    {
        $data = array(
            'parent_cat_id'     => $this->input->post('parent_cat_id'),
            'name'              => $this->input->post('name'),
            'search_keywords'   => $this->input->post('search_keywords'),
            'product_code'      => $this->input->post('product_code'),
            'unit_value'        => $this->input->post('unit_value'),
            'unit_type'         => $this->input->post('unit_type'),
            'description'       => $this->input->post('description'),
        );
        if ($this->master_model->add_product($data)) {
            $this->session->set_flashdata('success', 'Product Added Successfully');
            redirect($this->agent->referrer());
        } else {
            $this->session->set_flashdata('error', 'Something Went Wrong!!');
            redirect($this->agent->referrer());
        }
    }
    public function edit_product()
    {
        $id = $this->uri->segment(2);
        $data = array(
            'parent_cat_id'     => $this->input->post('parent_cat_id'),
            'name'     => $this->input->post('name'),
            'search_keywords'     => $this->input->post('search_keywords'),
            'product_code'     => $this->input->post('product_code'),
            'unit_value'     => $this->input->post('unit_value'),
            'unit_type'     => $this->input->post('unit_type'),
            'description'     => $this->input->post('description'),
        );
        if ($this->master_model->edit_data('products_subcategory', $id, $data)) {
            $this->session->set_flashdata('success', 'Product Edited Successfully');
            redirect($this->agent->referrer());
        } else {
            $this->session->set_flashdata('error', 'Something Went Wrong!!');
            redirect($this->agent->referrer());
        }
    }
    public function delete_product()
    {
        $id = $this->uri->segment(2);
        if ($this->master_model->delete_data('products_subcategory', $id)) {
            $this->session->set_flashdata('success', 'Product Deleted Successfully');
            redirect($this->agent->referrer());
        } else {
            $this->session->set_flashdata('error', 'Something Went Wrong!!');
            redirect($this->agent->referrer());
        }
    }
    public function view_product_images()
    {
        //     $data['title'] = 'Product Photos';
        //     $id = $this->uri->segment(3);
        //     $data['prod_img'] = $this->master_model->get_data('products_photo','item_id',$id);
        // $page = 'admin/master/products_photo';
        // $this->header_and_footer($page, $data);
        // $id = $this->uri->segment(3);
        // echo $id;exit;
    }
    public function add_property_value()
    {
        $product_id = $this->uri->segment(2);
        $data = array(
            'product_id'     => $product_id,
            'props_id'     => $this->input->post('props_id'),
            'value'     => $this->input->post('value'),
        );
        if ($this->master_model->add_data('product_props', $data)) {
            $this->session->set_flashdata('success', 'Property Value Added Successfully');
            redirect($this->agent->referrer());
        } else {
            $this->session->set_flashdata('error', 'Something Went Wrong!!');
            redirect($this->agent->referrer());
        }
    }
    // Product Property
    public function product_property()
    {
        $data['menu_id'] = $this->uri->segment(2);
        $data['title'] = 'Product Property';
        $data['properties'] = $this->master_model->view_data('product_props_master');
        $data['remote']     = base_url() . 'master-data/remote/product_props/';
        $page = 'admin/master/product_property';
        $this->header_and_footer($page, $data);
    }
    public function add_product_property()
    {
        if ($this->input->post('is_selectable')) {
            $is_selectable = '1';
        } else {
            $is_selectable = '0';
        }
        $data = array(
            'name'     => $this->input->post('name'),
            'is_selectable'     => $is_selectable
        );
        $this->form_validation->set_rules('name', 'Property Name', 'required');
        if ($this->master_model->add_data('product_props_master', $data)) {
            $this->session->set_flashdata('success', 'Product Property Added Successfully');
            redirect($this->agent->referrer());
        } else {
            $this->session->set_flashdata('error', 'Something Went Wrong!!');
            redirect($this->agent->referrer());
        }
    }
    public function edit_product_property()
    {
        $id = $this->uri->segment(3);
        if ($this->input->post('is_selectable')) {
            $is_selectable = '1';
        } else {
            $is_selectable = '0';
        }
        $data = array(
            'name'     => $this->input->post('name'),
            'is_selectable'     => $is_selectable
        );
        $this->form_validation->set_rules('name', 'Property Name', 'required');
        if ($this->master_model->edit_data('product_props_master', $id, $data)) {
            $this->session->set_flashdata('success', 'Product Property Edited Successfully');
            redirect($this->agent->referrer());
        } else {
            $this->session->set_flashdata('error', 'Something Went Wrong!!');
            redirect($this->agent->referrer());
        }
    }
    public function delete_product_property()
    {
        $id = $this->uri->segment(3);
        if ($this->master_model->delete_data('product_props_master', $id)) {
            $this->session->set_flashdata('success', 'Product Property Deleted Successfully');
            redirect($this->agent->referrer());
        } else {
            $this->session->set_flashdata('error', 'Something Went Wrong!!');
            redirect($this->agent->referrer());
        }
    }
    // Shop Category
    public function shop_category()
    {
        $data['menu_id'] = $this->uri->segment(2);
        $data['title'] = 'Shop Category';
        $data['categories'] = $this->master_model->view_data('shop_category');
        $data['remote']     = base_url() . 'master-data/remote/shop_category/';
        $page = 'admin/master/shop_category';
        $this->header_and_footer($page, $data);
    }
    public function add_shop_category()
    {
        $data = array(
            'name'     => $this->input->post('name')
        );
        $config['file_name'] = rand(10000, 10000000000);
        $config['upload_path'] = UPLOAD_PATH . 'shop_category/';
        $config['allowed_types'] = 'jpg|jpeg|png|gif|pdf';
        $this->load->library('upload', $config);
        $this->upload->initialize($config);

        if (!empty($_FILES['icon']['name'])) {
            //upload images
            $_FILES['icons']['name'] = $_FILES['icon']['name'];
            $_FILES['icons']['type'] = $_FILES['icon']['type'];
            $_FILES['icons']['tmp_name'] = $_FILES['icon']['tmp_name'];
            $_FILES['icons']['size'] = $_FILES['icon']['size'];
            $_FILES['icons']['error'] = $_FILES['icon']['error'];

            if ($this->upload->do_upload('icons')) {
                $image_data = $this->upload->data();
                $fileName = "shop_category/" . $image_data['file_name'];
            }
            $data['icon'] = $fileName;
        } else {
            $data['icon'] = "";
        }
        $this->form_validation->set_rules('name', 'Category Name', 'required');
        if ($this->master_model->add_data('shop_category', $data)) {
            $this->session->set_flashdata('success', 'Shop Category Added Successfully');
            redirect($this->agent->referrer());
        } else {
            $this->session->set_flashdata('error', 'Something Went Wrong!!');
            redirect($this->agent->referrer());
        }
    }
    public function edit_shop_category()
    {
        $id = $this->uri->segment(3);
        $data = array(
            'name'     => $this->input->post('name')
        );
        $this->form_validation->set_rules('name', 'Category Name', 'required');
        if ($this->master_model->edit_data('shop_category', $id, $data)) {
            $this->session->set_flashdata('success', 'Shop Category Edited Successfully');
            redirect($this->agent->referrer());
        } else {
            $this->session->set_flashdata('error', 'Something Went Wrong!!');
            redirect($this->agent->referrer());
        }
    }
    public function delete_shop_category()
    {
        $id = $this->uri->segment(3);
        if ($this->master_model->delete_data('shop_category', $id)) {
            $this->session->set_flashdata('success', 'Shop Category Deleted Successfully');
            redirect($this->agent->referrer());
        } else {
            $this->session->set_flashdata('error', 'Something Went Wrong!!');
            redirect($this->agent->referrer());
        }
    }
    // Unit Master
    public function unit_master()
    {
        $data['menu_id'] = $this->uri->segment(2);
        $data['title']      = 'Unit Master';
        $data['units']      = $this->master_model->view_unit_master('unit_master');
        $data['remote']     = base_url() . 'master-data/remote/unit/';
        $page               = 'admin/master/unit_master';
        $this->header_and_footer($page, $data);
    }
    public function add_unit()
    {
        $data = array(
            'name'     => $this->input->post('name')
        );
        $this->form_validation->set_rules('name', 'Unit Name', 'required');
        if ($this->master_model->add_data('unit_master', $data)) {
            $this->session->set_flashdata('success', 'Unit Added Successfully');
            redirect($this->agent->referrer());
        } else {
            $this->session->set_flashdata('error', 'Something Went Wrong!!');
            redirect($this->agent->referrer());
        }
    }
    public function edit_unit()
    {
        $id = $this->uri->segment(3);
        $data = array(
            'name'     => $this->input->post('name')
        );
        $this->form_validation->set_rules('name', 'Unit Name', 'required');
        if ($this->master_model->edit_data('unit_master', $id, $data)) {
            $this->session->set_flashdata('success', 'Unit Edited Successfully');
            redirect($this->agent->referrer());
        } else {
            redirect($this->agent->referrer());
        }
    }
    public function delete_unit()
    {
        $id = $this->uri->segment(3);
        if ($this->master_model->delete_data('unit_master', $id)) {
            $this->session->set_flashdata('success', 'Unit Deleted Successfully');
            redirect($this->agent->referrer());
        } else {
            $this->session->set_flashdata('error', 'Something Went Wrong!!');
            redirect($this->agent->referrer());
        }
    }

    //Pin Code Criteria
    public function pincodes_criteria()
    {
        $data['menu_id'] = $this->uri->segment(2);
        $data['title']      = 'Pincodes Criteria';
        $data['pincodes_criteria']  = $this->master_model->view_pincodes_criteria();
        $data['business']  = $this->master_model->view_data('business');
        $data['shops']  = $this->master_model->view_data('shops');
        $data['remote']     = base_url() . 'master-data/remote/pincode/';
        $page = 'admin/master/pincodes_criteria';
        $this->header_and_footer($page, $data);
    }
    //Fetch Shops
    public function fetch_shop()
    {
        if ($this->input->post('business_id')) {
            $bid = $this->input->post('business_id');
            $this->master_model->fetch_shop($bid);
        }
    }


    public function add_pincodes_criteria()
    {
        $data = array(
            'pincode'     => $this->input->post('pincode'),
            'shop_id'     => $this->input->post('shop_id'),
            'price'     => $this->input->post('price')
        );
        if ($this->master_model->add_data('pincodes_criteria', $data)) {
            $this->session->set_flashdata('success', 'Pincodes Criteria Added Successfully');
            redirect($this->agent->referrer());
        } else {
            $this->session->set_flashdata('error', 'Something Went Wrong!!');
            redirect($this->agent->referrer());
        }
    }
    public function edit_pincodes_criteria()
    {
        $id = $this->uri->segment(3);
        $data = array(
            'pincode'     => $this->input->post('pincode'),
            'shop_id'     => $this->input->post('shop_id'),
            'price'     => $this->input->post('price')
        );
        if ($this->master_model->edit_data('pincodes_criteria', $id, $data)) {
            $this->session->set_flashdata('success', 'Pincodes Criteria Edited Successfully');
            redirect($this->agent->referrer());
        } else {
            $this->session->set_flashdata('error', 'Something Went Wrong!!');
            redirect($this->agent->referrer());
        }
    }
    public function delete_pincodes_criteria()
    {
        $id = $this->uri->segment(3);
        if ($this->master_model->delete_pincodes_criteria($id)) {
            $this->session->set_flashdata('success', 'Pincodes Criteria Deleted Successfully');
            redirect($this->agent->referrer());
        } else {
            $this->session->set_flashdata('error', 'Something Went Wrong!!');
            redirect($this->agent->referrer());
        }
    }
    //Booking Slots
    public function booking_slots()
    {
        $data['menu_id'] = $this->uri->segment(2);
        $data['title']      = 'Booking Slots';
        $data['booking_slots']  = $this->master_model->get_booking_slots();
        $data['business']  = $this->master_model->view_data('business');
        $data['shops']  = $this->master_model->view_data('shops');
        $page = 'admin/master/booking_slots';
        $this->header_and_footer($page, $data);
    }
    //Fetch Slots
    public function fetch_slot()
    {
        if ($this->input->post('day_name')) {
            $day = $this->input->post('day_name');
            $shop_id = $this->input->post('shop_id');
            $data['available_slots'] = $this->master_model->fetch_slot($day, $shop_id);
            $this->load->view('admin/master/available_slots', $data);
        }
    }

    public function add_booking_slot()
    {
        $data = array(
            'day'     => $this->input->post('day_name'),
            'timestart'     => $this->input->post('timestart'),
            'timeend'     => $this->input->post('timeend'),
            'slotsize'     => $this->input->post('slotsize'),
            'shop_id'     => $this->input->post('shop_id')
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
        $id = $this->uri->segment(3);
        $data = array(
            'day'     => $this->input->post('day_name'),
            'timestart'     => $this->input->post('timestart'),
            'timeend'     => $this->input->post('timeend'),
            'slotsize'     => $this->input->post('slotsize'),
            'shop_id'     => $this->input->post('shop_id')
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

    //Society
    public function society()
    {
        $data['menu_id'] = $this->uri->segment(2);
        $data['title']      = 'Society';
        $data['societyr']     = base_url() . 'master-data/society_remote/societyr/';
        $data['society']  = $this->master_model->view_data('society_master');
        $data['states']  = $this->master_model->view_data('states');
        $data['cities']  = $this->master_model->view_data('cities');
        $data['link_shop_url'] = base_url() . 'master-data/link_shop_view/';
        $page = 'admin/master/society';
        // $page = 'admin/master/society_copy';
        $this->header_and_footer($page, $data);
    }

    //Fetch City
    public function fetch_city()
    {
        if ($this->input->post('state')) {
            $sid = $this->input->post('state');
            $this->master_model->fetch_city($sid);
        }
    }
    //Fetch Business by city id
    public function fetch_business()
    {
        if ($this->input->post('cityid')) {
            $cid = $this->input->post('cityid');
            $this->master_model->fetch_business($cid);
        }
    }

    public function add_society()
    {
        $data = array(
            'name'     => $this->input->post('name'),
            'state'     => $this->input->post('state'),
            'city'     => $this->input->post('city'),
            'society_range'     => $this->input->post('society_range'),
            'longitude'     => $this->input->post('longitude'),
            'latitude'     => $this->input->post('latitude'),
            'address'     => $this->input->post('address')
        );
        //society image code
        $config['file_name'] = rand(10000, 10000000000);
        $config['upload_path'] = UPLOAD_PATH . 'society_photo/';
        $config['allowed_types'] = 'jpg|jpeg|png|gif|pdf';
        $this->load->library('upload', $config);
        $this->upload->initialize($config);

        if (!empty($_FILES['img']['name'])) {
            //upload images
            $_FILES['imgs']['name'] = $_FILES['img']['name'];
            $_FILES['imgs']['type'] = $_FILES['img']['type'];
            $_FILES['imgs']['tmp_name'] = $_FILES['img']['tmp_name'];
            $_FILES['imgs']['size'] = $_FILES['img']['size'];
            $_FILES['imgs']['error'] = $_FILES['img']['error'];

            if ($this->upload->do_upload('imgs')) {
                $image_data = $this->upload->data();
                $fileName = "society_photo/" . $image_data['file_name'];
            }
            $data['img'] = $fileName;
        } else {
            $data['img'] = "";
        }
        if ($this->master_model->add_data('society_master', $data)) {
            $this->session->set_flashdata('success', 'Society Added Successfully');
            redirect($this->agent->referrer());
        } else {
            $this->session->set_flashdata('error', 'Something Went Wrong!!');
            redirect($this->agent->referrer());
        }
    }
    public function edit_society()
    {
        $id = $this->uri->segment(3);
        $data = array(
            'name'     => $this->input->post('name'),
            'state'     => $this->input->post('state'),
            'city'     => $this->input->post('city'),
            'society_range'     => $this->input->post('society_range'),
            'longitude'     => $this->input->post('longitude'),
            'latitude'     => $this->input->post('latitude'),
            'address'     => $this->input->post('address')
        );
        //society image code
        $config['file_name'] = rand(10000, 10000000000);
        $config['upload_path'] = UPLOAD_PATH . 'society_photo/';
        $config['allowed_types'] = 'jpg|jpeg|png|gif|pdf';
        $this->load->library('upload', $config);
        $this->upload->initialize($config);

        if (!empty($_FILES['img']['name'])) {
            //upload images
            $_FILES['imgs']['name'] = $_FILES['img']['name'];
            $_FILES['imgs']['type'] = $_FILES['img']['type'];
            $_FILES['imgs']['tmp_name'] = $_FILES['img']['tmp_name'];
            $_FILES['imgs']['size'] = $_FILES['img']['size'];
            $_FILES['imgs']['error'] = $_FILES['img']['error'];

            if ($this->upload->do_upload('imgs')) {
                $image_data = $this->upload->data();
                $fileName = "society_photo/" . $image_data['file_name'];
            }

            if (!empty($fileName)) {
                $data2 = $this->db->get_where('society_master', ['socity_id' => $id])->row();
                if (!empty($data2->img)) {
                    if (is_file(DELETE_PATH . $data2->img)) {
                        unlink(DELETE_PATH . $data2->img);
                    }
                }

                $data['img'] = $fileName;
            }
        }
        if ($this->master_model->edit_society($id, $data)) {
            $this->session->set_flashdata('success', 'Society Edited Successfully');
            redirect($this->agent->referrer());
        } else {
            $this->session->set_flashdata('error', 'Something Went Wrong!!');
            redirect($this->agent->referrer());
        }
    }
    public function delete_society()
    {
        $id = $this->uri->segment(3);
        if ($this->master_model->delete_society($id)) {
            $this->session->set_flashdata('success', 'Society Deleted Successfully');
            redirect($this->agent->referrer());
        } else {
            $this->session->set_flashdata('error', 'Something Went Wrong!!');
            redirect($this->agent->referrer());
        }
    }
    //Link Shops with society
    public function link_shop_view($id)
    {
        $data['society_id'] = $id;
        $data['states']  = $this->master_model->view_data('states');
        $data['shops'] = $this->master_model->get_shops_by_society($id);
        if (!empty($data['banners'])) {
            if ($data['banners']->link_type == '4') {
                $sid = $data['banners']->link_id;
                $data['linked_item'] = $this->master_model->get_row_data('shops', 'id', $sid);
            }
        }
        $this->load->view('admin/master/society/link_shop_view', $data);
    }
    public function fetch_society_shops()
    {
        $business_id = $this->input->post('business_id');
        $society_id = $this->input->post('society_id');
        $data['flg'] = '2';
        $data['shops']  = $this->master_model->get_data('shops', 'business_id', $business_id);
        $data['mapped_data'] = $this->master_model->get_data1('society_shops_link', 'socity_id', $society_id);
        $this->load->view('admin/master/society/shop_list', $data);
    }
    public function link_society_shop()
    {
        $shop_id = $this->input->post('shop_id');
        $society_id = $this->input->post('society_id');
        $data2['flg'] = '1';
        $data2['shop_id'] = $this->input->post('shop_id');
        $data = array(
            'shop_id'     => $shop_id,
            'socity_id'     => $society_id,
            'is_inside'     => $this->input->post('is_inside')
        );
        if ($this->master_model->add_data('society_shops_link', $data)) {
            $this->load->view('admin/master/society/map_unmap', $data2);
        }
    }
    //remove linked shop in society master
    public function remove_linked_shop()
    {
        $shop_id = $this->input->post('shop_id');
        $society_id = $this->input->post('society_id');
        $data['flg'] = '0';
        $data['shop_id'] = $shop_id;
        if ($this->master_model->delete_linked_shop($shop_id, $society_id)) {
            $this->load->view('admin/master/society/map_unmap', $data);
        }
    }
    //Tax Slab
    public function tax_slab()
    {
        $data['menu_id'] = $this->uri->segment(2);
        $data['title']      = 'Tax Slab';
        $data['tax_slabs']  = $this->master_model->view_data('tax_slabs');
        $data['remote']     = base_url() . 'master-data/remote/tax_slab/';
        $page               = 'admin/master/tax_slab';
        $this->header_and_footer($page, $data);
    }
    public function add_tax_slab()
    {
        $data = array(
            'slab'     => $this->input->post('slab')
        );
        $this->form_validation->set_rules('slab', 'Tax Slab', 'required');
        if ($this->master_model->add_data('tax_slabs', $data)) {
            $this->session->set_flashdata('success', 'Tax Slab Added Successfully');
            redirect($this->agent->referrer());
        } else {
            $this->session->set_flashdata('error', 'Something Went Wrong!!');
            redirect($this->agent->referrer());
        }
    }
    public function edit_tax_slab()
    {
        $id = $this->uri->segment(3);
        $data = array(
            'slab'     => $this->input->post('slab')
        );
        $this->form_validation->set_rules('slab', 'Tax Slab', 'required');
        if ($this->master_model->edit_data('tax_slabs', $id, $data)) {
            $this->session->set_flashdata('success', 'Tax Slab Edited Successfully');
            redirect($this->agent->referrer());
        } else {
            $this->session->set_flashdata('error', 'Something Went Wrong!!');
            redirect($this->agent->referrer());
        }
    }
    public function delete_tax_slab()
    {
        $id = $this->uri->segment(3);
        if ($this->master_model->delete_data('tax_slabs', $id)) {
            $this->session->set_flashdata('success', 'Tax Slab Deleted Successfully');
            redirect($this->agent->referrer());
        } else {
            $this->session->set_flashdata('error', 'Something Went Wrong!!');
            redirect($this->agent->referrer());
        }
    }


    public function pr($data, $die = true)
    {
        echo "<pre>";
        print_r($data);
        echo "</pre>";
        if ($die == true) {
            die();
        }
    }
    public function delete_product_image()
    {
        $imageid = $this->uri->segment(2);
        if ($this->master_model->delete_data('products_photo', $imageid) == true) {
            echo "1";
        } else {
            echo "2";
        }
    }

    public function change_status()
    {
        $id = $this->input->post('id');
        $data['status_data'] = $this->master_model->get_row_data('pincodes_criteria', 'id', $id);


        if ($data['status_data']->active == 1) {
            $data1 = array(
                'active' => 0
            );
        } else if ($data['status_data']->active == 0) {
            $data1 = array(
                'active' => 1
            );
        }
        $this->master_model->edit_data('pincodes_criteria', $id, $data1);
        $this->load->view('admin/statusview', $data);
    }
    public function change_cat_status()
    {
        $id = $this->input->post('id');
        $data['status_data'] = $this->master_model->get_row_data('products_category', 'id', $id);


        if ($data['status_data']->active == 1) {
            $data1 = array(
                'active' => 0
            );
        } else if ($data['status_data']->active == 0) {
            $data1 = array(
                'active' => 1
            );
        }
        $this->master_model->edit_data('products_category', $id, $data1);
        $this->load->view('admin/statusview', $data);
    }
    public function change_product_status()
    {
        $id = $this->input->post('id');
        $data['status_data'] = $this->master_model->get_row_data('products_subcategory', 'id', $id);


        if ($data['status_data']->active == 1) {
            $data1 = array(
                'active' => 0
            );
        } else if ($data['status_data']->active == 0) {
            $data1 = array(
                'active' => 1
            );
        }
        $this->master_model->edit_data('products_subcategory', $id, $data1);
        $this->load->view('admin/statusview', $data);
    }
    public function change_prod_prop_status()
    {
        $id = $this->input->post('id');
        $data['status_data'] = $this->master_model->get_row_data('product_props_master', 'id', $id);


        if ($data['status_data']->active == 1) {
            $data1 = array(
                'active' => 0
            );
        } else if ($data['status_data']->active == 0) {
            $data1 = array(
                'active' => 1
            );
        }
        $this->master_model->edit_data('product_props_master', $id, $data1);
        $this->load->view('admin/statusview', $data);
    }
    public function change_society_status()
    {
        $socity_id = $this->input->post('socity_id');
        $data['status_data'] = $this->master_model->get_row_data('society_master', 'socity_id', $socity_id);

        if ($data['status_data']->active == 1) {
            $data1 = array(
                'active' => 0
            );
        } else if ($data['status_data']->active == 0) {
            $data1 = array(
                'active' => 1
            );
        }
        $this->master_model->change_society_status($socity_id, $data1);
        $this->load->view('admin/societystatusview', $data);
    }
    public function change_unit_status()
    {
        $id = $this->input->post('id');
        $data['status_data'] = $this->master_model->get_row_data('unit_master', 'id', $id);

        if ($data['status_data']->active == 1) {
            $data1 = array(
                'active' => 0
            );
        } else if ($data['status_data']->active == 0) {
            $data1 = array(
                'active' => 1
            );
        }
        $this->master_model->edit_data('unit_master', $id, $data1);
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
    public function change_cancellation_reason_status()
    {
        $id = $this->input->post('id');
        $data['status_data'] = $this->master_model->get_row_data('cancellation_reason', 'id', $id);

        if ($data['status_data']->active == 1) {
            $data1 = array(
                'active' => 0
            );
        } else if ($data['status_data']->active == 0) {
            $data1 = array(
                'active' => 1
            );
        }
        $this->master_model->edit_data('cancellation_reason', $id, $data1);
        $this->load->view('admin/statusview', $data);
    }
    public function change_brand_status()
    {
        $id = $this->input->post('id');
        $data['status_data'] = $this->master_model->get_row_data('brand_master', 'id', $id);

        if ($data['status_data']->active == 1) {
            $data1 = array(
                'active' => 0
            );
        } else if ($data['status_data']->active == 0) {
            $data1 = array(
                'active' => 1
            );
        }
        $this->master_model->edit_data('brand_master', $id, $data1);
        $this->load->view('admin/statusview', $data);
    }
    public function change_tax_status()
    {
        $id = $this->input->post('id');
        $data['status_data'] = $this->master_model->get_row_data('tax_slabs', 'id', $id);

        if ($data['status_data']->active == 1) {
            $data1 = array(
                'active' => 0
            );
        } else if ($data['status_data']->active == 0) {
            $data1 = array(
                'active' => 1
            );
        }
        $this->master_model->edit_data('tax_slabs', $id, $data1);
        $this->load->view('admin/statusview', $data);
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
    public function change_homeheader_status()
    {
        $id = $this->input->post('id');
        $data['status_data'] = $this->master_model->get_row_data('home_headers', 'id', $id);

        if ($data['status_data']->status == 1) {
            $data1 = array(
                'status' => 0
            );
        } else if ($data['status_data']->status == 0) {
            $data1 = array(
                'status' => 1
            );
        }
        $this->master_model->edit_data('home_headers', $id, $data1);
        $this->load->view('admin/header_statusview', $data);
    }
    public function change_shop_cat_status()
    {
        $id = $this->input->post('id');
        $data['status_data'] = $this->master_model->get_row_data('shop_category', 'id', $id);

        if ($data['status_data']->active == 1) {
            $data1 = array(
                'active' => 0
            );
        } else if ($data['status_data']->active == 0) {
            $data1 = array(
                'active' => 1
            );
        }
        $this->master_model->edit_data('shop_category', $id, $data1);
        $this->load->view('admin/statusview', $data);
    }
    public function change_shop_status()
    {
        $id = $this->input->post('id');
        $data['status_data'] = $this->master_model->get_row_data('shops', 'id', $id);


        if ($data['status_data']->isActive == 1) {
            $data1 = array(
                'isActive' => 0
            );
        } else if ($data['status_data']->isActive == 0) {
            $data1 = array(
                'isActive' => 1
            );
        }
        $this->master_model->edit_data('shops', $id, $data1);
        $this->load->view('admin/shopstatusview', $data);
    }

    public function fetch_category()
    {
        if ($this->input->post('parent_id')) {
            $pid = $this->input->post('parent_id');
            $this->master_model->fetch_category($pid);
        }
    }
    //Fetch Product category
    public function fetch_cat()
    {
        if ($this->input->post('parent_cat_id')) {
            $parent_cat_id = $this->input->post('parent_cat_id');
            $this->master_model->fetch_category($parent_cat_id);
        }
    }

    //Home Banners

    public function home_banners()
    {
        $data['menu_id'] = $this->uri->segment(2);
        $data['title'] = 'Home Banners';
        $data['link_banner_url'] = base_url() . 'master-data/link_banner_view/';
        $shop_id     = $this->input->post('shop');
        if (!empty($shop_id)) {
            $data['home_banners']  = $this->master_model->get_home_banner($shop_id);
        } else {
            $data['home_banners']  = $this->master_model->view_home_banner();
        }
        $data['business']  = $this->master_model->view_data('business');
        $data['shops']  = $this->master_model->view_data('shops');
        $page = 'admin/master/home_banners';
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
        $this->load->view('admin/master/home_banner/link_banner_view', $data);
    }

    public function fetch_items()
    {
        $link_id = $this->input->post('link_id');
        $bannerid = $this->input->post('bannerid');
        if ($link_id == '3') {
            $data['banner_id'] = $bannerid;
            $data['home_header']  = $this->master_model->view_home_header();
            $this->load->view('admin/master/home_banner/link_header', $data);
        } else if ($link_id == '2') {
            $data['banner_id'] = $bannerid;
            $data['sub_categories'] = $this->master_model->get_category();
            $this->load->view('admin/master/home_banner/link_category', $data);
        } else {
            $data['banner_id'] = $bannerid;
            $data['parent_cat'] = $this->master_model->get_data('products_category', 'is_parent', '0');
            $data['products'] = $this->master_model->view_data('products_subcategory');
            $this->load->view('admin/master/home_banner/link_product', $data);
        }
    }
    public function get_products()
    {
        if ($this->input->post('parent_cat_id')) {
            $id = $this->input->post('parent_cat_id');
            $data['available_products'] = $this->master_model->fetch_products($id);
            $this->load->view('admin/master/home_banner/available_products', $data);
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
            'shop_id'     => $this->input->post('shop_id'),
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
    // public function filter_home_banner()
    // {

    //     if(!empty($shop_id))
    //     {
    //         $this->master_model->filter_home_banner($shop_id);
    //     }
    //     if ($this->master_model->filter_home_banner($data)) {
    //         $this->session->set_flashdata('success', 'Home Banner Filtered Successfully');
    //         redirect($this->agent->referrer());
    //     } else {
    //         $this->session->set_flashdata('error', 'Something Went Wrong!!');
    //         redirect($this->agent->referrer());
    //     }
    // }
    public function edit_home_banner()
    {
        $id = $this->uri->segment(3);

        $data = array(
            'shop_id'     => $this->input->post('shop_id'),
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
    //Market Place Home Banners
    public function market_place_home_banners()
    {
        $data['menu_id'] = $this->uri->segment(2);
        $data['title'] = 'Market Place Home Banners';
        $data['link_banner_url'] = base_url() . 'master-data/market_place_link_banner_view/';
        $data['home_banners']  = $this->master_model->get_market_place_home_banner();
        $page = 'admin/master/market_place_home_banners';
        $this->header_and_footer($page, $data);
    }
    public function add_market_place_home_banners()
    {

        $data = array(
            'shop_id'     => '0',
            'seq'     => $this->input->post('seq'),
            'banner_type'     => $this->input->post('banner_type'),
        );
        if ($this->master_model->add_market_place_home_banners($data)) {
            $this->session->set_flashdata('success', 'Home Banner Added Successfully');
            redirect($this->agent->referrer());
        } else {
            $this->session->set_flashdata('error', 'Something Went Wrong!!');
            redirect($this->agent->referrer());
        }
    }
    public function edit_market_place_home_banners()
    {
        $id = $this->uri->segment(3);

        $data = array(
            'shop_id'     => '0',
            'seq'     => $this->input->post('seq'),
            'banner_type'     => $this->input->post('banner_type'),
        );

        if ($this->master_model->edit_market_place_home_banners($data, $id)) {
            $this->session->set_flashdata('success', 'Updated Successfully');
            redirect($this->agent->referrer());
        } else {
            $this->session->set_flashdata('error', 'Something Went Wrong!!');
            redirect($this->agent->referrer());
        }
    }
    public function delete_market_place_home_banners()
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
    public function market_place_link_banner_view($id)
    {
        $data['banner_id'] = $id;
        $data['states']  = $this->master_model->view_data('states');
        $data['banners'] = $this->master_model->get_row_data1('home_banners', 'id', $id);
        if (!empty($data['banners'])) {
            if ($data['banners']->link_type == '4') {
                $sid = $data['banners']->link_id;
                $data['linked_item'] = $this->master_model->get_row_data('shops', 'id', $sid);
            }
        }
        $this->load->view('admin/master/market_place_home_banner/link_banner_view', $data);
    }
    // Cancellation Reason
    public function cancellation_reason()
    {
        $data['menu_id'] = $this->uri->segment(2);
        $data['title']      = 'Cancellation Reason';
        $data['cancellation_reasons']      = $this->master_model->view_data('cancellation_reason');
        $data['remote']     = base_url() . 'master-data/remote/cancellation_reason/';
        $page               = 'admin/master/cancellation_reason';
        $this->header_and_footer($page, $data);
    }
    public function add_cancellation_reason()
    {
        $data = array(
            'content'     => $this->input->post('content')
        );
        $this->form_validation->set_rules('content', 'Content Field', 'required');
        if ($this->master_model->add_data('cancellation_reason', $data)) {
            $this->session->set_flashdata('success', 'Reason Added Successfully');
            redirect($this->agent->referrer());
        } else {
            $this->session->set_flashdata('error', 'Something Went Wrong!!');
            redirect($this->agent->referrer());
        }
    }
    public function edit_cancellation_reason()
    {
        $id = $this->uri->segment(3);
        $data = array(
            'content'     => $this->input->post('content')
        );
        $this->form_validation->set_rules('content', 'Content Field', 'required');
        if ($this->master_model->edit_data('cancellation_reason', $id, $data)) {
            $this->session->set_flashdata('success', 'Reason Edited Successfully');
            redirect($this->agent->referrer());
        } else {
            redirect($this->agent->referrer());
        }
    }
    public function delete_cancellation_reason()
    {
        $id = $this->uri->segment(3);
        if ($this->master_model->delete_data('cancellation_reason', $id)) {
            $this->session->set_flashdata('success', 'Reason Deleted Successfully');
            redirect($this->agent->referrer());
        } else {
            $this->session->set_flashdata('error', 'Something Went Wrong!!');
            redirect($this->agent->referrer());
        }
    }
    //Shop Social
    public function shop_social()
    {
        $data['menu_id'] = $this->uri->segment(2);
        $data['title']      = 'Shop Social';
        $data['socials']      = $this->master_model->shop_social();
        $data['business']  = $this->master_model->view_data('business');
        $data['remote']     = base_url() . 'master-data/remote/shop_social/';
        $page               = 'admin/master/shop_social';
        $this->header_and_footer($page, $data);
    }
    public function add_shop_social()
    {
        $data = array(
            'icon'     => $this->input->post('icon'),
            'url'     => $this->input->post('url'),
            'shop_id'     => $this->input->post('shop_id'),
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
        $id = $this->uri->segment(3);
        $data = array(
            'icon'     => $this->input->post('icon'),
            'url'     => $this->input->post('url'),
            'shop_id'     => $this->input->post('shop_id'),
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
    public function fetch_shops()
    {
        $business_id = $this->input->post('business_id');
        $data['shops']  = $this->master_model->get_data('shops', 'business_id', $business_id);
        $this->load->view('admin/master/market_place_home_banner/shop_list', $data);
    }
    public function link_shop()
    {
        $sid = $this->input->post('sid');
        $bannerid = $this->input->post('bannerid');
        $data = array(
            'link_type'     => '4',
            'link_id'     => $sid,
        );
        if ($this->master_model->edit_data('home_banners', $bannerid, $data)) {
            echo 'linked';
        }
    }
    //Home Header

    public function home_header()
    {
        $data['menu_id'] = $this->uri->segment(2);
        $data['title'] = 'Home Header';
        $data['home_header']  = $this->master_model->view_home_header();
        $data['business']  = $this->master_model->view_data('business');
        $data['shops']  = $this->master_model->view_data('shops');
        $page = 'admin/master/home_header/home_header';
        $this->header_and_footer($page, $data);
    }

    public function add_home_header()
    {

        $data = array(
            'title'     => $this->input->post('title'),
            'type'     => $this->input->post('type'),
            'shop_id'     => $this->input->post('shop_id'),
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
        $id = $this->uri->segment(2);

        $data = array(
            'title'     => $this->input->post('title'),
            'type'     => $this->input->post('type'),
            'shop_id'     => $this->input->post('shop_id'),
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
        $id = $this->uri->segment(2);
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
        $id = $this->uri->segment(2);
        $data['headerid'] = $id;
        $data['headers_mapping'] = $this->master_model->get_headers_mapping($id);
        $page = 'admin/master/home_header/headers_mapping';
        $this->header_and_footer($page, $data);
    }
    public function add_mapping()
    {
        $data['headerid'] = $this->input->post('headerid');
        $data['parent_cat'] = $this->master_model->get_data('products_category', 'is_parent', '0');
        $data['categories'] = $this->master_model->get_data('products_category', 'is_parent !=', '0');
        $this->load->view('admin/master/home_header/add_mapping', $data);
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
            $this->load->view('admin/master/home_header/available_products', $data);
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
            $this->load->view('admin/master/home_header/map_unmap', $data);
        }
    }
    public function remove_map_product()
    {
        $pid = $this->input->post('pid');
        $headerid = $this->input->post('headerid');
        $data['flg'] = '0';
        $data['pid'] = $pid;
        if ($this->master_model->delete_header_mapping($pid, $headerid)) {
            $this->load->view('admin/master/home_header/map_unmap', $data);
        }
    }

    public function delete_header_mapping()
    {
        $id = $this->uri->segment(2);
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
        $id = $this->uri->segment(2);
        $data['headerid'] = $id;
        $data['category_mapping'] = $this->master_model->get_category_mapping($id);
        $page = 'admin/master/home_header/category_mapping';
        $this->header_and_footer($page, $data);
    }
    public function add_cat_mapping()
    {
        $data['headerid'] = $this->input->post('headerid');
        $headerid = $data['headerid'];
        $data['parent_cat'] = $this->master_model->get_data('products_category', 'is_parent', '0');
        $data['headers_mapping'] = $this->master_model->get_category_mapping($headerid);
        $this->load->view('admin/master/home_header/add_cat_mapping', $data);
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
            $this->load->view('admin/master/home_header/cat_map_unmap', $data);
        }
    }
    public function remove_map_category()
    {
        $cid = $this->input->post('cid');
        $headerid = $this->input->post('headerid');
        $data['flg'] = '0';
        $data['cid'] = $cid;
        if ($this->master_model->delete_category_mapping($cid, $headerid)) {
            $this->load->view('admin/master/home_header/cat_map_unmap', $data);
        }
    }
    public function delete_cat_header_mapping()
    {
        $id = $this->uri->segment(2);
        if ($this->master_model->delete_category_map($id)) {
            $this->session->set_flashdata('success', 'Data Deleted Successfully ');
            redirect($this->agent->referrer());
        } else {
            $this->session->set_flashdata('error', 'Something Went Wrong!!');
            redirect($this->agent->referrer());
        }
    }

    public function vendors($action = null, $p1 = null, $p2 = null, $p3 = null)
    {
        // $data['user']    = $this->checkLogin();
        switch ($action) {
            case null:
                $data['menu_id'] = $this->uri->segment(2);
                $data['title']          = 'Vendors';
                $data['tb_url']         = base_url() . 'vendors/tb';
                $data['new_url']        = base_url() . 'vendors/create';
                $page                   = 'admin/master/vendors/index';
                $this->header_and_footer($page, $data);
                break;

            case 'tb':
                $data['search'] = '';
                if (@$_POST['search']) {
                    $data['search'] = $_POST['search'];
                }


                $this->load->library('pagination');
                $config = array();
                $config["base_url"]         = base_url() . "vendors/tb/";
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
                $data['update_url']         = base_url() . 'vendors/create/';
                $page                       = 'admin/master/vendors/tb';


                $this->load->view($page, $data);
                break;

            case 'create':
                $data['remote']             = base_url() . 'master-data/remote/vendor/';
                $data['action_url']         = base_url() . 'vendors/save';
                $data['states']  = $this->shops_vendor_model->view_data('states');
                $data['cities']  = $this->shops_vendor_model->view_data('cities');
                $data['business']  = $this->master_model->view_data('business');
                $page                       = 'admin/master/vendors/create';
                if ($p1 != null) {
                    $data['value']          = $this->shops_vendor_model->vendor($p1);
                    $data['action_url']     = base_url() . 'vendors/save/' . $p1;
                    $data['remote']         = base_url() . 'master-data/remote/vendors/' . $p1;
                    $page                   = 'admin/master/vendors/update';
                }

                $data['form_id']            = uniqid();


                $this->load->view($page, $data);
                break;



            case 'save':
                $id = $p1;
                $return['res'] = 'error';
                $return['msg'] = 'Not Saved!';

                if ($this->input->server('REQUEST_METHOD') == 'POST') {

                    if ($id != null) {
                        $data = array(
                            'name'     => $this->input->post('name'),
                            'mobile'              => $this->input->post('mobile'),
                            'alternate_mobile'   => $this->input->post('alternate_mobile'),
                            'state'      => $this->input->post('state'),
                            'city'        => $this->input->post('city'),
                            'address'       => $this->input->post('address'),
                            'email'        => $this->input->post('email'),
                            'gstin'        => $this->input->post('gstin'),
                            'shop_id'        => $this->input->post('shop_id'),
                            'vendor_code'        => $this->input->post('vendor_code'),
                            'pincode'        => $this->input->post('pincode'),
                            'user_type'        => '1',
                        );

                        if ($this->shops_vendor_model->edit_data('vendors', $id, $data)) {
                            $return['res'] = 'success';
                            $return['msg'] = 'Updated.';
                        }
                    } else {
                        $data = array(
                            'name'     => $this->input->post('name'),
                            'mobile'              => $this->input->post('mobile'),
                            'alternate_mobile'   => $this->input->post('alternate_mobile'),
                            'state'      => $this->input->post('state'),
                            'city'        => $this->input->post('city'),
                            'address'       => $this->input->post('address'),
                            'email'        => $this->input->post('email'),
                            'gstin'        => $this->input->post('gstin'),
                            'shop_id'        => $this->input->post('shop_id'),
                            'vendor_code'        => $this->input->post('vendor_code'),
                            'pincode'        => $this->input->post('pincode'),
                            'user_type'        => '1',
                        );
                        if ($this->shops_vendor_model->add_data('vendors', $data)) {
                            $return['res'] = 'success';
                            $return['msg'] = 'Saved.';
                        }
                    }
                }
                echo json_encode($return);
                break;




            case 'delete':
                $id = $p1;
                if ($this->shops_vendor_model->delete_data('vendors', $id)) {
                    $data['search'] = '';
                    if (@$_POST['search']) {
                        $data['search'] = $_POST['search'];
                    }

                    $this->load->library('pagination');
                    $config = array();
                    $config["base_url"]         = base_url() . "vendors/tb/";
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
                    $data['update_url']         = base_url() . 'vendors/create/';
                    $page                       = 'admin/master/vendors/tb';


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
                $data['menu_id'] = $this->uri->segment(2);
                $data['title']          = 'Customer';
                $data['tb_url']         = base_url() . 'customer/tb';
                $data['new_url']        = base_url() . 'customer/create';
                $page                   = 'admin/master/customer/index';
                $this->header_and_footer($page, $data);
                break;

            case 'tb':
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
                $data['page']               = $page = ($p1 != null) ? $p1 : 0;
                $data['per_page']           = $config["per_page"];
                $data['vendors']           = $this->shops_vendor_model->customer($config["per_page"], $page);
                $data['update_url']         = base_url() . 'customer/create/';
                $page                       = 'admin/master/customer/tb';


                $this->load->view($page, $data);
                break;

            case 'create':
                $data['remote']             = base_url() . 'master-data/remote/vendor/';
                $data['action_url']         = base_url() . 'customer/save';
                $data['states']  = $this->shops_vendor_model->view_data('states');
                $data['cities']  = $this->shops_vendor_model->view_data('cities');
                $data['business']  = $this->master_model->view_data('business');
                $page                       = 'admin/master/customer/create';
                if ($p1 != null) {
                    $data['value']          = $this->shops_vendor_model->vendor($p1);
                    $data['action_url']     = base_url() . 'customer/save/' . $p1;
                    $data['remote']         = base_url() . 'master-data/remote/vendors/' . $p1;
                    $page                   = 'admin/master/customer/update';
                }

                $data['form_id']            = uniqid();


                $this->load->view($page, $data);
                break;



            case 'save':
                $id = $p1;
                $return['res'] = 'error';
                $return['msg'] = 'Not Saved!';

                if ($this->input->server('REQUEST_METHOD') == 'POST') {

                    if ($id != null) {
                        $data = array(
                            'name'     => $this->input->post('name'),
                            'mobile'              => $this->input->post('mobile'),
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
                            'aadhar_no'        => $this->input->post('aadhar_no'),
                            'shop_id'        => $this->input->post('shop_id'),
                            'vendor_code'        => $this->input->post('vendor_code'),
                            'pincode'        => $this->input->post('pincode'),
                            'user_type'        => '2',
                        );

                        if ($this->shops_vendor_model->edit_data('vendors', $id, $data)) {
                            $return['res'] = 'success';
                            $return['msg'] = 'Updated.';
                        }
                    } else {
                        $data = array(
                            'name'     => $this->input->post('name'),
                            'mobile'              => $this->input->post('mobile'),
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
                            'aadhar_no'        => $this->input->post('aadhar_no'),
                            'shop_id'        => $this->input->post('shop_id'),
                            'vendor_code'        => $this->input->post('vendor_code'),
                            'pincode'        => $this->input->post('pincode'),
                            'user_type'        => '2',
                        );
                        if ($this->shops_vendor_model->add_data('vendors', $data)) {
                            $return['res'] = 'success';
                            $return['msg'] = 'Saved.';
                        }
                    }
                }
                echo json_encode($return);
                break;




            case 'delete':
                $id = $p1;
                if ($this->shops_vendor_model->delete_data('vendors', $id)) {
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
                    $page                       = 'admin/master/customer/tb';


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

    // Brand Master
    public function brand_master()
    {
        $data['menu_id'] = $this->uri->segment(2);
        $data['title']      = 'Brand Master';
        $data['brands']      = $this->master_model->view_brand_master('brand_master');
        $data['remote']     = base_url() . 'master-data/remote/brand/';
        $page               = 'admin/master/brand_master';
        $this->header_and_footer($page, $data);
    }
    public function add_brand()
    {
        $data = array(
            'name'     => $this->input->post('name')
        );
        $this->form_validation->set_rules('name', 'Brand Name', 'required');
        if ($this->master_model->add_data('brand_master', $data)) {
            $this->session->set_flashdata('success', 'Brand Added Successfully');
            redirect($this->agent->referrer());
        } else {
            $this->session->set_flashdata('error', 'Something Went Wrong!!');
            redirect($this->agent->referrer());
        }
    }
    public function edit_brand()
    {
        $id = $this->uri->segment(2);
        $data = array(
            'name'     => $this->input->post('name')
        );
        $this->form_validation->set_rules('name', 'Brand Name', 'required');
        if ($this->master_model->edit_data('brand_master', $id, $data)) {
            $this->session->set_flashdata('success', 'Brand Edited Successfully');
            redirect($this->agent->referrer());
        } else {
            redirect($this->agent->referrer());
        }
    }
    public function delete_brand()
    {
        $id = $this->uri->segment(2);
        if ($this->master_model->delete_data('brand_master', $id)) {
            $this->session->set_flashdata('success', 'Brand Deleted Successfully');
            redirect($this->agent->referrer());
        } else {
            $this->session->set_flashdata('error', 'Something Went Wrong!!');
            redirect($this->agent->referrer());
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
                if ($table == 'society_master') {
                    $is_deleted = array('is_deleted' => 'DELETED');
                    $this->db->where('socity_id', $id[$count])->update($table, $is_deleted);
                } else {
                    $this->master_model->delete_data($table, $id[$count]);
                }
            }
        }
    }
}
