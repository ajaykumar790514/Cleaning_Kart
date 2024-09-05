<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Coupons_offers extends CI_Controller {

	public function __construct()
    {
        parent::__construct();

        $this->isLoggedIn();
        $this->check_role_menu();
    }

    public function isLoggedIn(){
        $is_logged_in = $this->session->userdata('shop_logged_in');
        if(!isset($is_logged_in) || $is_logged_in!==TRUE)
        {
            redirect(base_url());
            exit;
        }
    } 
    public function check_role_menu(){
        $shop_role_id = $_SESSION['shop_role_id'];
        $uri = $this->uri->segment(1);
        $role_menus = $this->admin_model->all_role_menu_data($shop_role_id);
        $url_array = array();
        if(!empty($role_menus))
        {
            foreach($role_menus as $menus)
            {
                array_push($url_array,$menus->url);
            }
            if(!in_array($uri,$url_array))
            {
                redirect(base_url());
            }
        }
        else
        {
            redirect(base_url());
            exit;
        }      
    } 

    public function header_and_footer($page, $data)
    {
        $shop_id     = $_SESSION['user_data']['id'];
        $shop_role_id     = $_SESSION['user_data']['role_id'];
        $data['all_menus'] = $this->admin_model->get_data1('tb_admin_menu','status','1');
        $data['shop_menus'] = $this->admin_model->get_role_menu_data($shop_role_id);
		$shop_details = $this->shops_model->get_shop_data($shop_id);
        $template_data = array(
        'menu'=> $this->load->view('template/menu',$data,TRUE),
        'main_body_data'=> $this->load->view($page,$data,TRUE),
        'shop_photo'=>$shop_details->logo
        );
            $this->load->view('template/main_template',$template_data);
    }

    public function index()
    {
        $data['title'] = 'Offers';
        $menu_id = $this->uri->segment(2);
        $data['menu_id'] = $menu_id;
        $role_id = $_SESSION['shop_role_id'];
        $data['sub_menus'] = $this->admin_model->get_submenu_data($menu_id,$role_id);
        $page = 'shop/offers_coupons/offers_coupons_data';
        $this->header_and_footer($page, $data);
    }
    public function coupons_offers_remote($type,$id=null,$column='name')
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
    public function shop_offers($action=null,$p1=null,$p2=null,$p3=null)
    {
        switch ($action) {
            case null:
                $data['title']          = 'Offers';
                $data['tb_url']         = base_url().'shop-offers/tb';
                $data['new_url']        = base_url().'shop-offers/create';
                $page                   = 'shop/offers_coupons/offers/index';
                $this->header_and_footer($page, $data);
                break;

                case 'tb':
                    $data['search'] = '';
                    if (@$_POST['search']) {
                        $data['search'] = $_POST['search'];
                    }
                    
                    $this->load->library('pagination');
                    $config = array();
                    $config["base_url"]         = base_url()."shop-offers/tb/";
                    $config["total_rows"]       = $this->offers_model->offers();
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
                    $data['update_url']         = base_url().'shop-offers/create/';
                    $page                       = 'shop/offers_coupons/offers/tb';
                    $this->load->view($page, $data);
                    break;
                
                    case 'create':
                        $data['remote']             = base_url().'coupons-offers/coupons_offers_remote/offers/';
                        $data['action_url']         = base_url().'shop-offers/save';
                        $data['business']  = $this->offers_model->view_data('business');
                        $data['shops']  = $this->offers_model->view_data('shops');
                        $page                       = 'shop/offers_coupons/offers/create';
                        if ($p1!=null) {
                            $data['action_url']     = base_url().'shop-offers/save/'.$p1;
                            $data['business']  = $this->offers_model->view_data('business');
                            $data['shops']  = $this->offers_model->view_data('shops');
                            $data['value']          = $this->offers_model->offer($p1);
                            $data['remote']         = base_url().'coupons-offers/coupons_offers_remote/offers/'.$p1;
                            $page                   = 'shop/offers_coupons/offers/update';
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
                                            'offer_created_by'       => $_SESSION['user_data']['id'],
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
                                    $config["base_url"]         = base_url()."shop-offers/tb/";
                                    $config["total_rows"]       = $this->offers_model->offers();
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
                                    $data['update_url']         = base_url().'shop-offers/create/';
                                    $page                       = 'shop/offers_coupons/offers/tb';
                                    $this->load->view($page, $data);
                                }
                              
                                break;
            default:
                # code...
                break;
        }
            //Status change
    
    }

    //COUPONS
    public function shop_coupons($action=null,$p1=null,$p2=null,$p3=null)
    {
        switch ($action) {
            case null:
                $data['title']          = 'Coupons';
                $data['tb_url']         = base_url().'shop-coupons/tb';
                $data['new_url']        = base_url().'shop-coupons/create';
                $page                   = 'shop/offers_coupons/coupons/index';
                $this->header_and_footer($page, $data);
                break;

                case 'tb':
                    $data['search'] = '';
                    if (@$_POST['search']) {
                        $data['search'] = $_POST['search'];
                    }
                    
                    $this->load->library('pagination');
                    $config = array();
                    $config["base_url"]         = base_url()."shop-coupons/tb/";
                    $config["total_rows"]       = $this->coupons_model->coupons();
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
                    $data['update_url']         = base_url().'shop-coupons/create/';
                    $page                       = 'shop/offers_coupons/coupons/tb';
                    $this->load->view($page, $data);
                    break;
                
                    case 'create':
                        $data['remote']             = base_url().'coupons-offers/coupons_offers_remote/coupons/';
                        $data['action_url']         = base_url().'shop-coupons/save';
                        $data['business']  = $this->coupons_model->view_data('business');
                        $data['shops']  = $this->coupons_model->view_data('shops');
                        $page                       = 'shop/offers_coupons/coupons/create';
                        if ($p1!=null) {
                            $data['action_url']     = base_url().'shop-coupons/save/'.$p1;
                            $data['business']  = $this->coupons_model->view_data('business');
                            $data['shops']  = $this->coupons_model->view_data('shops');
                            $data['value']          = $this->coupons_model->coupon($p1);
                            $data['remote']         = base_url().'coupons-offers/coupons_offers_remote/coupons/'.$p1;
                            $page                   = 'shop/offers_coupons/coupons/update';
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
                                            'offer_created_by'       => $_SESSION['user_data']['id'],
                                            'coupan_or_offer'       => '0',
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
                                    $config["base_url"]         = base_url()."shop-coupons/tb/";
                                    $config["total_rows"]       = $this->coupons_model->coupons();
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
                                    $data['update_url']         = base_url().'shop-coupons/create/';
                                    $page                       = 'shop/offers_coupons/coupons/tb';
                                    $this->load->view($page, $data);
                                }
                              
                                break;
            default:
                # code...
                break;
        }
    }
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

        public function shop_apply_offer()
        {
            $data['title'] = 'Apply Offer';
            $data['business']  = $this->offers_model->view_data('business');
            $data['shops']  = $this->offers_model->view_data('shops');
            $data['parent_cat'] = $this->master_model->get_data('products_category','is_parent','0');
            $data['categories'] = $this->master_model->get_data('products_category','is_parent !=','0');
            $page = 'shop/offers_coupons/offers/apply_offer';
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
                $shopid= $_SESSION['user_data']['id'];
                $data['shop_id']= $_SESSION['user_data']['id'];
                $data['available_products'] = $this->master_model->fetch_products($id);
                $data['offer_products'] = $this->offers_model->fetch_offer_products($id,$shopid);
                $this->load->view('shop/offers_coupons/offers/available_products',$data);
            }
        }
        public function available_offers()
        {
            $pid = $this->input->post('pid');
            $data['pid'] = $this->input->post('pid');
            $data['shop_id'] = $_SESSION['user_data']['id'];
            $data['offers'] = $this->offers_model->get_data1('coupons_and_offers','coupan_or_offer','1');
            $data['offer_list'] = $this->offers_model->view_data1('shops_coupons_offers');
            // print_r($data['offers']);
            $this->load->view('shop/offers_coupons/offers/available_offers',$data);
           
        }
        public function add_offer()
        {
            $oid= $this->input->post('oid');
            $pid= $this->input->post('pid');
            $shop_id= $_SESSION['user_data']['id'];
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
            $shop_id= $_SESSION['user_data']['id'];
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
            $data['shop_id'] = $_SESSION['user_data']['id'];
            $data['offers'] = $this->offers_model->get_data1('coupons_and_offers','coupan_or_offer','1');
            $data['offer_list'] = $this->offers_model->view_data1('shops_coupons_offers');
            // print_r($data['offers']);
            $this->load->view('shop/offers_coupons/offers/available_offers_cat',$data);
           
        }
        public function add_offer_cat()
        {
            $oid= $this->input->post('oid');
            $parent_cat_id= $this->input->post('parent_cat_id');
            $shop_id= $_SESSION['user_data']['id'];
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
            $shop_id= $_SESSION['user_data']['id'];
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























































    // public function index(){
	// 	if($this->session->has_userdata('logged_in') && $this->session->logged_in === TRUE){
            
    //         $couponCond = array('coupan_or_offer'=> '0','offer_created_by'=>$_SESSION['user_data']['id']);
    //         $offersCond = array('coupan_or_offer'=> '1','offer_created_by'=>$_SESSION['user_data']['id']);
    //         if(isset($_SESSION['coupon_offer_filter']['status'])){
    //             $couponCond['isActive'] = $_SESSION['coupon_offer_filter']['status'];
    //             $offersCond['isActive'] = $_SESSION['coupon_offer_filter']['status'];
    //         }
    //         $viewData= array(
    //                             'couponData' => $this->coupons_and_offers_model->getRows(array('conditions'=> $couponCond)),
    //                             'offersData' => $this->coupons_and_offers_model->getRows(array('conditions'=> $offersCond))
    //                         );
	// 		$template_data = array(
	// 								'menu'=>$this->load->view('template/menu',NULL,TRUE),
    //                                 'main_body_data'=>$this->load->view('shop/offers-coupons',$viewData,TRUE),
	// 							);
	// 		$this->load->view('template/main_template',$template_data);
	// 	}else{
	// 		redirect(base_url());
	// 	}
    // }
    // public function enableDisabled(){
    //     if(isset($_POST['id']) && isset($_POST['currstatus'])){
    //         if($_POST['currstatus'] === '0'){
    //             $newStatus = '1';
    //         }else{
    //             $newStatus = '0';
    //         }
    //         $this->coupons_and_offers_model->updateRow($_POST['id'],array('isActive'=>$newStatus));
    //     }
    // }
    // public function submitAddEdit(){
    //     if(isset($_POST['id'])){
    //         if($_POST['id']==='0'){
    //             //insert
    //             if($_FILES['poster']['size']>'0'){
    //                 $target_dir = "/application/photo/offers/";
    //                 $target_file = $target_dir .date('Y-m-d-H-i-s'). basename($_FILES["poster"]["name"]);
    //                 if (move_uploaded_file($_FILES["poster"]["tmp_name"], FCPATH.$target_file)) {
    //                     $insertArray = array(
    //                                             'title'=> $_POST['title'],
    //                                             'description'=> $_POST['description'],
    //                                             'discount_type'=> $_POST['discount_type'],
    //                                             'value'=> $_POST['value'],
    //                                             'expiry_date'=> date('Y-m-d H:i:s',strtotime($_POST['expiry_date'])),
    //                                             'creation_date'=> date('Y-m-d H:i:s'),
    //                                             'start_date'=> date('Y-m-d H:i:s',strtotime($_POST['start_date'])),
    //                                             'poster'=> $target_file,
    //                                             'isActive'=> '1',
    //                                             'coupan_or_offer'=> $_POST['coupan_or_offer'],
    //                                             'photo'=> $target_file,
    //                                             'offer_created_by'=> $_POST['offer_created_by'],
    //                                         );
    //                     if($insertArray['discount_type'] === '0'){
    //                         $insertArray['maximum_coupan_discount_value'] = '0';
    //                     }else{
    //                         $insertArray['maximum_coupan_discount_value'] = $_POST['maximum_coupan_discount_value'];
    //                     }
    //                     if($insertArray['coupan_or_offer'] === '0'){
    //                         $insertArray['code'] = $_POST['code'];
    //                         $insertArray['minimum_coupan_amount'] = $_POST['minimum_coupan_amount'];
    //                         $data['message']='New coupon created.';
    //                     }else{
    //                         $insertArray['code'] = '';
    //                         $insertArray['minimum_coupan_amount'] = '';
    //                         $data['message']='New offer created.';
    //                     }
    //                     $this->coupons_and_offers_model->insertRow($insertArray);
    //                     $data['status']=TRUE;
    //                 }else{
    //                     $data['status']=FALSE;
    //                     $data['message']='Image could not be uploaded.';
    //                 }
    //             }else{
    //                 $data['status']=FALSE;
    //                 $data['message']='No image uploaded.';
    //             }
    //         }else{
    //             //update
    //             $data['status']=TRUE;
    //             $updateArray = array(
    //                 'title'=> $_POST['title'],
    //                 'description'=> $_POST['description'],
    //                 'discount_type'=> $_POST['discount_type'],
    //                 'value'=> $_POST['value'],
    //                 'expiry_date'=> date('Y-m-d H:i:s',strtotime($_POST['expiry_date'])),
    //                 'creation_date'=> date('Y-m-d H:i:s'),
    //                 'start_date'=> date('Y-m-d H:i:s',strtotime($_POST['start_date'])),
    //                 'isActive'=> '1',
    //                 'coupan_or_offer'=> $_POST['coupan_or_offer'],
    //                 'offer_created_by'=> $_POST['offer_created_by'],
    //             );
    //             if($_FILES['poster']['size']>'0'){
    //                 $target_dir = "/application/photo/offers/";
    //                 $target_file = $target_dir .date('Y-m-d-H-i-s'). basename($_FILES["poster"]["name"]);
                    
    //                 if (move_uploaded_file($_FILES["poster"]["tmp_name"], FCPATH.$target_file)) {
    //                     $updateArray['poster']=  $target_file;
    //                     $updateArray['photo']=  $target_file;
    //                 }else{
    //                     $data['status']=FALSE;
    //                     $data['message']='Image could not be uploaded.';
    //                 }
                    
    //             }
    //             if($updateArray['discount_type'] === '0'){
    //                 $updateArray['maximum_coupan_discount_value'] = '0';
    //             }else{
    //                 $updateArray['maximum_coupan_discount_value'] = $_POST['maximum_coupan_discount_value'];
    //             }
    //             if($updateArray['coupan_or_offer'] === '0'){
    //                 $updateArray['code'] = $_POST['code'];
    //                 $updateArray['minimum_coupan_amount'] = $_POST['minimum_coupan_amount'];
    //                 $data['message']='Coupon updated.';
    //             }else{
    //                 $updateArray['code'] = '';
    //                 $updateArray['minimum_coupan_amount'] = '';
    //                 $data['message']='Offer updated.';
    //             }
    //             $this->coupons_and_offers_model->updateRow($_POST['id'],$updateArray);
    //         }
    //     }else{
    //         $data['status']=FALSE;
    //         $data['message']='Form data not received.';
    //     }
    //     echo json_encode($data);
    // }
    // public function detailsPage($couponOfferId){
    //     if($this->session->has_userdata('logged_in') && $this->session->logged_in === TRUE){
            
            
    //         $viewData= array(
    //                             'couponOfferData' => $this->coupons_and_offers_model->getRows(array('conditions'=> array('id'=>$couponOfferId))),
    //                             'productAssociated' => $this->shops_coupons_offers_model->getProductRows(array('conditions'=>array('offer_assosiated_id'=>$couponOfferId,'shop_id'=>$_SESSION['user_data']['id']))),
    //                             'categoryList' => $this->products_category_model->getRows(array('conditions'=>array('is_parent'=>'0','active'=>'1')))
    //                         );
            
	// 		$template_data = array(
	// 								'menu'=>$this->load->view('template/menu',NULL,TRUE),
    //                                 'main_body_data'=>$this->load->view('shop/offers-coupons-details',$viewData,TRUE),
	// 							);
	// 		$this->load->view('template/main_template',$template_data);
	// 	}else{
	// 		redirect(base_url());
	// 	}
    // }
    // public function removeProductFromOffers(){
    //     if(isset($_POST['co_id'])){
    //         if($this->shops_coupons_offers_model->deleteRow($_POST['co_id'])){
    //             $data['status']=TRUE;
    //             $data['message']='Product removed.';
    //         }else{
    //             $data['status']=FALSE;
    //             $data['message']='Product could not be removed.';
    //         }
    //     }else{
    //         $data['status']=FALSE;
    //         $data['message']='Product data not received.';
    //     }
    //     echo json_encode($data);
    // }
    // public function getCategorydata(){
    //     $subCat = NULL;
    //     if(isset($_POST['cat_id']) && $_POST['cat_id']!=='0'){
    //         $subCatData = $this->products_category_model->getRows(array('conditions'=>array('is_parent'=>$_POST['cat_id'],'active'=>'0')));
    //         $data['subCatData'] = $data['productList'] = '';
            
    //         if($subCatData!==FALSE){
    //             if(count($subCatData)>1){
    //                 $subCat=TRUE;
    //                 $temp = '';
    //                 foreach($subCatData as $data){
    //                      $temp .= '<option value="'.$data['id'].'">'.$data['name'].'</option>';
    //                 }
    //                 $data['subCatData'] = $temp;
    //             }else{
    //                 $subCat=FALSE;
    //             }
    //         }else{
    //             $subCat=FALSE;
    //         }
    //         if($subCat === FALSE){
    //             $productData = $this->products_subcategory_model->getRows(array('conditions'=>array('parent_cat_id'=>$subCatData[0]['id'],'active'=>'1')));
    //             if($productData!==FALSE){
    //                 $html ='';
    //                 foreach($productData as $data){
    //                     $html .= '<option value="'.$data['id'].'"> '.str_pad($data['product_code'], 6, '0', STR_PAD_LEFT).' | '.$data['name'].'</option>';
    //                 }
    //                 $data['productList'] = $html;
    //             }
    //         }
    //     }
    //     $data['subCat'] = $subCat;
    //     echo json_encode($data);
    // }
    // public function submitAddProduct(){
    //     if(isset($_POST['product_id'])){
    //         $insertArray = array(
    //                                 'shop_id'=>$_POST['shop_id'],
    //                                 'offer_assosiated_id'=>$_POST['offer_assosiated_id'],
    //                                 'offer_associated'=>$_POST['offer_associated'],
    //                                 'product_id'=>$_POST['product_id'],
    //                                 'category_id'=>$_POST['category_id'],
    //                                 'offer_upto'=>'0',
    //                                 'added'=>date('Y-m-d H:i:S'),
    //                                 'updated'=>date('Y-m-d H:i:S'),
    //                             );
    //         if($this->shops_coupons_offers_model->insertRow($insertArray)){
    //             $data['status']=TRUE;
    //             $data['message']='Product added successfully';
    //         }else{
    //             $data['status']=FALSE;
    //             $data['message']='Product could not be added';
    //         }
    //     }else{
    //         $data['status']=FALSE;
    //         $data['message']='Product data not received';
    //     }
    //     echo json_encode($data);
    // }
}

