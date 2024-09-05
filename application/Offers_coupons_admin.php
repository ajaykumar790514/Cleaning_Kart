<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Offers_coupons_admin extends CI_Controller {

    public function __construct()
    {
        parent::__construct();

        // if (!is_admin()) {
        //     redirect('admin');
        // }
        $this->isLoggedIn();
    }

    public function isLoggedIn(){
            $is_logged_in = $this->session->userdata('logged_in');
            if(!isset($is_logged_in) || $is_logged_in!==TRUE)
            {
                redirect('logout');
                exit;
            }
    } 

    public function header_and_footer($page, $data)
    {
        $user_id = $_SESSION['user_id'];
        $data['dashboard'] = $this->admin_model->get_row_data('admin','id',$user_id);
        $this->load->view('admin/includes/header',$data);
        $this->load->view($page);
        $this->load->view('admin/includes/footer');
    }

    public function index()
    {
        $data['title'] = 'Offers';
        $page = 'admin/offers_coupons/offers_coupons_data';
        $this->header_and_footer($page, $data);
    }
    public function offers_coupons_remote($type,$id=null,$column='name')
    {
        if ($type=='offers') {
            $tb = 'coupons_and_offers';
        }
        elseif ($type=='coupons') {
            $tb ='coupons_and_offers';
        }
        
        else{

        }
        $this->db->where($column,$_GET[$column]);
        if($id!=NULL){
            $this->db->where('id != ',$id)->where('is_deleted','NOT_DELETED');
        }
        $count=$this->db->count_all_results($tb);
        if($count>0)
        {
            echo "false";
        }
        else
        {
            echo "true";
        }        
    }
    public function offers($action=null,$p1=null,$p2=null,$p3=null)
    {
        switch ($action) {
            case null:
                $data['title']          = 'Offers';
                $data['tb_url']         = base_url().'offers/tb';
                $data['new_url']        = base_url().'offers/create';
                $page                   = 'admin/offers_coupons/offers/index';
                $this->header_and_footer($page, $data);
                break;

                case 'tb':
                    $data['search'] = '';
                    if (@$_POST['search']) {
                        $data['search'] = $_POST['search'];
                    }
                    
                    $this->load->library('pagination');
                    $config = array();
                    $config["base_url"]         = base_url()."offers/tb/";
                    $config["total_rows"]       = count($this->offers_model->offers());
                    $data['total_rows']         = $config["total_rows"];
                    $config["per_page"]         = 10;
                    $config["uri_segment"]      = 3;
                    $config['attributes']       = array('class' => 'pag-link');
                    $config['full_tag_open']    = "<div class='pag'>";
                    $config['full_tag_close']   = "</div>";
                    $config['first_link']       = '&lt;&lt;';
                    $config['last_link']        = '&gt;&gt;';
                    $this->pagination->initialize($config);
                    $data["links"]              = $this->pagination->create_links();
                    $data['page']               = $page = ($p1!=null) ? $p1 : 0;
                    $data['per_page']           = $config["per_page"];
                    $data['offers']           = $this->offers_model->offers($config["per_page"],$page);
                    $data['update_url']         = base_url().'offers/create/';
                    $page                       = 'admin/offers_coupons/offers/tb';
                    $this->load->view($page, $data);
                    break;
                
                    case 'create':
                        $data['remote']             = base_url().'offers_coupons_remote/offers/';
                        $data['action_url']         = base_url().'offers/save';
                        $data['business']  = $this->offers_model->view_data('business');
                        $data['shops']  = $this->offers_model->view_data('shops');
                        $page                       = 'admin/offers_coupons/offers/create';
                        if ($p1!=null) {
                            $data['action_url']     = base_url().'offers/save/'.$p1;
                            $data['business']  = $this->offers_model->view_data('business');
                            $data['shops']  = $this->offers_model->view_data('shops');
                            $data['value']          = $this->offers_model->offer($p1);
                            $data['remote']         = base_url().'offers_coupons_remote/offers/'.$p1;
                            $page                   = 'admin/offers_coupons/offers/update';
                        }
                        $data['form_id']            = uniqid();
                        
                       
                        $this->load->view($page, $data);
                        break;

                        case 'save':
                            $id = $p1;
                            $return['res'] = 'error';
                            $return['msg'] = 'Not Saved!';
                            if ($this->input->server('REQUEST_METHOD')=='POST') {
                                if ($id!=null) {
                                    $data = array(
                                            'title'     => $this->input->post('title'),
                                            'description'              => $this->input->post('description'),
                                            'discount_type'      => $this->input->post('discount_type'),
                                            'value'        => $this->input->post('value'),
                                            'expiry_date'       => $this->input->post('expiry_date'),
                                            'start_date'       => $this->input->post('start_date'),
                                            'offer_created_by'       => $this->input->post('offer_created_by'),
                                        );
                                    if($this->offers_model->edit_offer_coupon($data,$id)){
                                        $return['res'] = 'success';
                                        $return['msg'] = 'Saved.';
                                    }
                                }
                                else{
                                    $data = array(
                                            'title'     => $this->input->post('title'),
                                            'description'              => $this->input->post('description'),
                                            'discount_type'      => $this->input->post('discount_type'),
                                            'value'        => $this->input->post('value'),
                                            'expiry_date'       => $this->input->post('expiry_date'),
                                            'start_date'       => $this->input->post('start_date'),
                                            'offer_created_by'       => $this->input->post('offer_created_by'),
                                            'coupan_or_offer'       => '1',
                                        );
                                    if ($this->offers_model->add_offer_coupon($data)) {
                                        $return['res'] = 'success';
                                        $return['msg'] = 'Saved.';
                                    }
                                }
                            }
                            echo json_encode($return);
                            break;
                            case 'delete_offer':
                                $id = $p1;
                                if($this->offers_model->delete_data('coupons_and_offers',$id))
                                {
                                    $data['search'] = '';
                                    if (@$_POST['search']) {
                                        $data['search'] = $_POST['search'];
                                    }
                                    
                                    $this->load->library('pagination');
                                    $config = array();
                                    $config["base_url"]         = base_url()."offers/tb/";
                                    $config["total_rows"]       = count($this->offers_model->offers());
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
                                    $data['page']               = $page = ($p2!=null) ? $p2 : 0;
                                    $data['per_page']           = $config["per_page"];
                                    $data['offers']           = $this->offers_model->offers($config["per_page"],$page);
                                    $data['update_url']         = base_url().'offers/create/';
                                    $page                       = 'admin/offers_coupons/offers/tb';
                                    $this->load->view($page, $data);
                                }
                              
                                break;
            default:
                # code...
                break;
        }
    }

    //Fetch Shops
    public function fetch_shop()
    {
        if($this->input->post('business_id'))
        {
            $bid= $this->input->post('business_id');
            $this->master_model->fetch_shop($bid);
        }
    }

    //COUPONS
    public function coupons($action=null,$p1=null,$p2=null,$p3=null)
    {
        switch ($action) {
            case null:
                $data['title']          = 'Coupons';
                $data['tb_url']         = base_url().'coupons/tb';
                $data['new_url']        = base_url().'coupons/create';
                $page                   = 'admin/offers_coupons/coupons/index';
                $this->header_and_footer($page, $data);
                break;

                case 'tb':
                    $data['search'] = '';
                    if (@$_POST['search']) {
                        $data['search'] = $_POST['search'];
                    }
                    
                    $this->load->library('pagination');
                    $config = array();
                    $config["base_url"]         = base_url()."coupons/tb/";
                    $config["total_rows"]       = count($this->coupons_model->coupons());
                    $data['total_rows']         = $config["total_rows"];
                    $config["per_page"]         = 10;
                    $config["uri_segment"]      = 3;
                    $config['attributes']       = array('class' => 'pag-link');
                    $config['full_tag_open']    = "<div class='pag'>";
                    $config['full_tag_close']   = "</div>";
                    $config['first_link']       = '&lt;&lt;';
                    $config['last_link']        = '&gt;&gt;';
                    $this->pagination->initialize($config);
                    $data["links"]              = $this->pagination->create_links();
                    $data['page']               = $page = ($p1!=null) ? $p1 : 0;
                    $data['per_page']           = $config["per_page"];
                    $data['coupons']           = $this->coupons_model->coupons($config["per_page"],$page);
                    $data['update_url']         = base_url().'coupons/create/';
                    $page                       = 'admin/offers_coupons/coupons/tb';
                    $this->load->view($page, $data);
                    break;
                
                    case 'create':
                        $data['remote']             = base_url().'offers_coupons_remote/coupons/';
                        $data['action_url']         = base_url().'coupons/save';
                        $data['business']  = $this->coupons_model->view_data('business');
                        $data['shops']  = $this->coupons_model->view_data('shops');
                        $page                       = 'admin/offers_coupons/coupons/create';
                        if ($p1!=null) {
                            $data['action_url']     = base_url().'coupons/save/'.$p1;
                            $data['business']  = $this->coupons_model->view_data('business');
                            $data['shops']  = $this->coupons_model->view_data('shops');
                            $data['value']          = $this->coupons_model->coupon($p1);
                            $data['remote']         = base_url().'offers_coupons_remote/coupons/'.$p1;
                            $page                   = 'admin/offers_coupons/coupons/update';
                        }
                        $data['form_id']            = uniqid();
                        
                       
                        $this->load->view($page, $data);
                        break;

                        case 'save':
                            $id = $p1;
                            $return['res'] = 'error';
                            $return['msg'] = 'Not Saved!';
                            if ($this->input->server('REQUEST_METHOD')=='POST') {
                                if ($id!=null) {
                                    $data = array(
                                            'title'     => $this->input->post('title'),
                                            'description'              => $this->input->post('description'),
                                            'discount_type'      => $this->input->post('discount_type'),
                                            'value'        => $this->input->post('value'),
                                            'expiry_date'       => $this->input->post('expiry_date'),
                                            'start_date'       => $this->input->post('start_date'),
                                            'offer_created_by'       => $this->input->post('offer_created_by'),
                                            'code'       => $this->input->post('code'),
                                            'minimum_coupan_amount'       => $this->input->post('minimum_coupan_amount'),
                                            'maximum_coupan_discount_value'       => $this->input->post('maximum_coupan_discount_value'),
                                        );
                                    if($this->offers_model->edit_offer_coupon($data,$id)){
                                        $return['res'] = 'success';
                                        $return['msg'] = 'Saved.';
                                    }
                                }
                                else{
                                    $data = array(
                                            'title'     => $this->input->post('title'),
                                            'description'              => $this->input->post('description'),
                                            'discount_type'      => $this->input->post('discount_type'),
                                            'value'        => $this->input->post('value'),
                                            'expiry_date'       => $this->input->post('expiry_date'),
                                            'start_date'       => $this->input->post('start_date'),
                                            'offer_created_by'       => $this->input->post('offer_created_by'),'coupan_or_offer'       => '0',
                                            'code'       => $this->input->post('code'),
                                            'minimum_coupan_amount'       => $this->input->post('minimum_coupan_amount'),
                                            'maximum_coupan_discount_value'       => $this->input->post('maximum_coupan_discount_value'),
                                        );
                                    if ($this->offers_model->add_offer_coupon($data)) {
                                        $return['res'] = 'success';
                                        $return['msg'] = 'Saved.';
                                    }
                                }
                            }
                            echo json_encode($return);
                            break;
                            case 'delete_coupon':
                                $id = $p1;
                                if($this->coupons_model->delete_data('coupons_and_offers',$id))
                                {
                                    $data['search'] = '';
                                    if (@$_POST['search']) {
                                        $data['search'] = $_POST['search'];
                                    }
                                    
                                    $this->load->library('pagination');
                                    $config = array();
                                    $config["base_url"]         = base_url()."coupons/tb/";
                                    $config["total_rows"]       = count($this->coupons_model->coupons());
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
                                    $data['page']               = $page = ($p2!=null) ? $p2 : 0;
                                    $data['per_page']           = $config["per_page"];
                                    $data['coupons']           = $this->coupons_model->coupons($config["per_page"],$page);
                                    $data['update_url']         = base_url().'coupons/create/';
                                    $page                       = 'admin/offers_coupons/coupons/tb';
                                    $this->load->view($page, $data);
                                }
                              
                                break;
            default:
                # code...
                break;
        }
    }

    //Status change
    public function change_offer_coupon_status()
    {
        $id = $this->input->post('id');
        $data['status_data'] = $this->coupons_model->get_row_data('coupons_and_offers','id',$id);


        if($data['status_data']->active == 1)
        {
            $data1 = array(
                'active' => 0
            );
        }
        else if($data['status_data']->active == 0)
        {
            $data1 = array(
                'active' => 1
            );
        }
        $this->coupons_model->edit_data('coupons_and_offers',$id,$data1);
        $this->load->view('admin/statusview',$data);
        
    }

    //Apply Offer

    public function apply_offer()
    {
        $data['title'] = 'Apply Offer';
        $data['business']  = $this->offers_model->view_data('business');
        $data['shops']  = $this->offers_model->view_data('shops');
        $data['parent_cat'] = $this->master_model->get_data('products_category','is_parent','0');
        $data['categories'] = $this->master_model->get_data('products_category','is_parent !=','0');
        $page = 'admin/offers_coupons/offers/apply_offer';
        $this->header_and_footer($page, $data);
    }
    //Fetch Product category
    public function fetch_category()
    {
        if($this->input->post('parent_id'))
        {
            $pid= $this->input->post('parent_id');
            $shopid= $this->input->post('shop_id');
            $data['offer_categories'] = $this->offers_model->fetch_offer_categories($pid,$shopid);
            $this->master_model->fetch_category($pid);
        }
    }
    //Fetch Products
    public function fetch_products()
    {
        if($this->input->post('parent_cat_id'))
        {
            $id= $this->input->post('parent_cat_id');
            $shopid= $this->input->post('shop_id');
            $data['shop_id']= $this->input->post('shop_id');
            $data['available_products'] = $this->master_model->fetch_products($id);
            $data['offer_products'] = $this->offers_model->fetch_offer_products($id,$shopid);
            $this->load->view('admin/offers_coupons/offers/available_products',$data);
        }
    }
    public function available_offers()
    {
        $pid = $this->input->post('pid');
        $data['pid'] = $this->input->post('pid');
        $data['shop_id'] = $this->input->post('shop_id');
        $data['offers'] = $this->offers_model->get_data1('coupons_and_offers','coupan_or_offer','1');
        $data['offer_list'] = $this->offers_model->view_data1('shops_coupons_offers');
        // print_r($data['offers']);
        $this->load->view('admin/offers_coupons/offers/available_offers',$data);
       
    }
    public function add_offer()
    {
        $oid= $this->input->post('oid');
        $pid= $this->input->post('pid');
        $shop_id= $this->input->post('shop_id');
        $value= $this->input->post('value');
        $discount_type= $this->input->post('discount_type');
        $data = array(
            'offer_assosiated_id'     => $oid,
            'product_id'     => $pid,
            'shop_id'     => $shop_id,
            'offer_associated'     => $value,
            'offer_upto'     => $value,
            'discount_type'     => $discount_type,
        );
        $check_offer = $this->offers_model->check_offer($oid,$pid,$shop_id);
        if($check_offer)
        {
            $data['add_offer'] = $this->offers_model->add_data('shops_coupons_offers',$data);
       
            $data['flg'] = '1';
            $data['oid'] = $oid;
            $data['value'] = $value;
            $data['discount_type'] = $discount_type;
            if($data['add_offer'])
            {
                // echo "success";
                $this->load->view('admin/offers_coupons/offers/offer_action',$data);
            }

        }
        else
        {
            echo "false";
        }
    }

    public function remove_offer()
    {
        $oid= $this->input->post('oid');
        $pid= $this->input->post('pid');
        $shop_id= $this->input->post('shop_id');
        $value= $this->input->post('value');
        $discount_type= $this->input->post('discount_type');
        $data['flg'] = '0';
        $data['oid'] = $oid;
        $data['value'] = $value;
        $data['discount_type'] = $discount_type;
        if ($this->offers_model->remove_offer($oid,$pid,$shop_id)) {
            $this->load->view('admin/offers_coupons/offers/offer_action',$data);
        } 
    }
    public function available_offers_cat()
    {
        $parent_cat_id = $this->input->post('parent_cat_id');
        $data['parent_cat_id'] = $this->input->post('parent_cat_id');
        $data['shop_id'] = $this->input->post('shop_id');
        $data['offers'] = $this->offers_model->get_data1('coupons_and_offers','coupan_or_offer','1');
        $data['offer_list'] = $this->offers_model->view_data1('shops_coupons_offers');
        // print_r($data['offers']);
        $this->load->view('admin/offers_coupons/offers/available_offers_cat',$data);
       
    }
    public function add_offer_cat()
    {
        $oid= $this->input->post('oid');
        $parent_cat_id= $this->input->post('parent_cat_id');
        $shop_id= $this->input->post('shop_id');
        $value= $this->input->post('value');
        $discount_type= $this->input->post('discount_type');
        $check_offer = $this->offers_model->check_offer_cat($oid,$parent_cat_id,$shop_id);
        if($check_offer)
        {
            $data['get_products_by_category'] = $this->offers_model->get_data('products_subcategory','parent_cat_id',$parent_cat_id);
            foreach($data['get_products_by_category'] as $products)
            {
                $pro = $products->id;
                $data = array(
                    'offer_assosiated_id'     => $oid,
                    'category_id'     => $parent_cat_id,
                    'shop_id'     => $shop_id,
                    'offer_associated'     => $value,
                    'offer_upto'     => $value,
                    'discount_type'     => $discount_type,
                    'product_id'     => $pro,
                );
                $this->offers_model->delete_offer_products($data);
                $data['add_offer'] = $this->offers_model->add_data('shops_coupons_offers',$data);
            }
            
       
            $data['flg'] = '1';
            $data['oid'] = $oid;
            $data['value'] = $value;
            $data['discount_type'] = $discount_type;
            if($data['add_offer'])
            {
                // echo "success";
                $this->load->view('admin/offers_coupons/offers/offer_action_cat',$data);
            }

        }
        else
        {
            echo "false";
        }
    }
    public function remove_offer_cat()
    {
        $oid= $this->input->post('oid');
        $parent_cat_id= $this->input->post('parent_cat_id');
        $shop_id= $this->input->post('shop_id');
        $value= $this->input->post('value');
        $discount_type= $this->input->post('discount_type');
        $data['flg'] = '0';
        $data['oid'] = $oid;
        $data['value'] = $value;
        $data['discount_type'] = $discount_type;
        if ($this->offers_model->remove_offer_cat($oid,$parent_cat_id,$shop_id)) {
            $this->load->view('admin/offers_coupons/offers/offer_action_cat',$data);
        } 
    }


}