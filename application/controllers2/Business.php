<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Business extends CI_Controller {

    public function __construct()
    {
        parent::__construct();

        $this->isLoggedIn();
        $this->check_role_menu();
    }

    public function isLoggedIn(){
        $is_logged_in = $this->session->userdata('admin_logged_in');
        if(!isset($is_logged_in) || $is_logged_in!==TRUE)
        {
            redirect(base_url());
            exit;
        }
    } 
    public function check_role_menu(){
        $admin_role_id = $_SESSION['admin_role_id'];
        $uri = $this->uri->segment(1);
        $role_menus = $this->admin_model->all_role_menu_data($admin_role_id);
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
    function getSmsRows($params = array()){
        $this->db->select('*');
        $this->db->from("sms_gateway_master");
        
        //fetch data by conditions
        if(array_key_exists("conditions",$params)) {
			foreach ($params['conditions'] as $key => $value) {
				$value= str_replace("+"," ",$value);
				$this->db->where($key,$value);
			}
        }
        
        if(array_key_exists("id",$params)){
            $this->db->where('id',$params['id']);
			$query = $this->db->get();
			$result = $query->row_array();
        } else {
            //set start and limit
            if(array_key_exists("start",$params) && array_key_exists("limit",$params)){
                $this->db->limit($params['limit'],$params['start']);
            } else if(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
                $this->db->limit($params['limit']);
            }
            $query = $this->db->get();
            if(array_key_exists("returnType",$params) && $params['returnType'] == 'count'){
				$result = $query->num_rows();
			} else if(array_key_exists("returnType",$params) && $params['returnType'] == 'single') {
				$result = ($query->num_rows() > 0) ? $query->row_array(): 0;
			} else {
                $result = ($query->num_rows() > 0) ? $query->result_array(): 0;
            }
        }
        //return fetched data
        return $result;
    }
    public function send_sms($smsData = array())
    {
        $senderId=$smsData["sender_id"];
        $serverUrl=$smsData["url"];
        $authKey=$smsData["auth_key"];
        $routeId=$smsData["route_id"];
        $msg = $smsData["msg"];
        $mob = $smsData["mob"];
        $message=$msg." is your login OTP. Treat this as confidential. Techfi Zone will never call you to verify your OTP. Techfi Zone Pvt Ltd.";
        
        $getData = 'mobileNos='.$mob.'&message='.urlencode($message).'&senderId='.$senderId.'&routeId='.$routeId;
    
        //API URL
        $url=$serverUrl."AUTH_KEY=".$authKey."&".$getData;
    
        // init the resource
        $ch = curl_init();
        curl_setopt_array($ch, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0
    
        ));
    
    
        //get response
        $output = curl_exec($ch);
    
        //Print error if any
        if(curl_errno($ch))
        {
            echo 'error:' . curl_error($ch);
        }
    
        curl_close($ch);
    
        return $output;
    }

    public function header_and_footer($page, $data)
    {
        $admin_role_id = $_SESSION['admin_role_id'];
        $user_id = $_SESSION['user_id'];
        $data['dashboard'] = $this->admin_model->get_row_data('admin','id',$user_id);
        $data['admin_menus'] = $this->admin_model->get_role_menu_data($admin_role_id);
        $this->load->view('admin/includes/header',$data);
        $this->load->view($page);
        $this->load->view('admin/includes/footer');
    }

    public function index()
    {
        $menu_id = $this->uri->segment(2);
        $data['menu_id'] = $menu_id;
        $role_id = $_SESSION['admin_role_id'];
        $data['sub_menus'] = $this->admin_model->get_submenu_data($menu_id,$role_id);
        $data['title'] = 'Business';
        $page = 'admin/business/business_data';
        $this->header_and_footer($page, $data);
    }
    public function business_remote($type,$id=null,$column='name')
    {
        if ($type=='businesses') {
            $tb = 'business';
        }
        elseif ($type=='shops') {
            $tb ='shops';
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
    public function businesses($action=null,$p1=null,$p2=null,$p3=null,$p4=null)
    {
        switch ($action) {
            case null:
                $data['menu_id'] = $this->uri->segment(2);
                $data['title']          = 'Business';
                $data['tb_url']         = base_url().'businesses/tb';
                $data['new_url']        = base_url().'businesses/create';
                $page                   = 'admin/business/businesses/index';
                $this->header_and_footer($page, $data);
                break;

                case 'tb':
                    $data['search'] = '';
                    $data['city_id'] = '';
                    $data['state_id'] = '';
                    $city_id = 'null';
                    $state_id = 'null';
                    $search = 'null';
                    if($p1!=null)
                    {
                        $data['state_id'] = $p1;
                        $state_id = $p1;
                    }
                    if($p2!=null)
                    {
                        $data['city_id'] = $p2;
                        $city_id = $p2;
                        $data['cities']  = $this->master_model->get_data('cities','state_id',$state_id);
                    }
                    if($p3!=null)
                    {
                        $data['search'] = $p3;
                        $search = $p3;
                    }
                    if (@$_POST['search']) {
                        $data['search'] = $_POST['search'];
                        $search = $_POST['search'];
                    }
                    if (@$_POST['city_id']) {
                        $data['city_id'] = $_POST['city_id'];
                        $city_id = $_POST['city_id'];
                        $state_id = $_POST['state_id'];
                        $data['state_id'] = $_POST['state_id'];
                        $data['cities']  = $this->master_model->get_data('cities','state_id',$_POST['state_id']);
                    }
                    $this->load->library('pagination');
                    $config = array();
                    $config["base_url"]         = base_url()."businesses/tb/".$state_id."/".$city_id."/".$search;
                    $config["total_rows"]       = count($this->business_model->businesses($city_id));
                    $data['total_rows']         = $config["total_rows"];
                    $config["per_page"]         = 10;
                    $config["uri_segment"]      = 6;
                    $config['attributes']       = array('class' => 'pag-link');
                    $config['full_tag_open']    = "<div class='pag'>";
                    $config['full_tag_close']   = "</div>";
                    $config['first_link']       = '&lt;&lt;';
                    $config['last_link']        = '&gt;&gt;';
                    $this->pagination->initialize($config);
                    $data["links"]              = $this->pagination->create_links();
                    $data['page']               = $page = ($p4!=null) ? $p4 : 0;
                    $data['per_page']           = $config["per_page"];
                    $data['businesses']           = $this->business_model->businesses($city_id,$config["per_page"],$page);
                    $data['update_url']         = base_url().'businesses/create/';
                    $page                       = 'admin/business/businesses/tb';
                    $data['states']  = $this->master_model->view_data('states');
                    $this->load->view($page, $data);
                    break;
                
                    case 'create':
                        $data['remote']             = base_url().'business-store/business_remote/businesses/';
                        $data['action_url']         = base_url().'businesses/save';
                        $data['states']  = $this->master_model->view_data('states');
                        $data['cities']  = $this->master_model->view_data('cities');
                        $page                       = 'admin/business/businesses/create';
                        if ($p1!=null) {
                            $data['action_url']     = base_url().'businesses/save/'.$p1;
                            $data['value']          = $this->business_model->business($p1);
                            $data['remote']         = base_url().'business-store/business_remote/businesses/'.$p1;
                            $page                   = 'admin/business/businesses/update';
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
                                            'owner_name'              => $this->input->post('owner_name'),
                                            'owner_contact'      => $this->input->post('owner_contact'),
                                            'alter_contact'        => $this->input->post('alter_contact'),
                                            'dob'       => $this->input->post('dob'),
                                            'email'       => $this->input->post('email'),
                                            'city'       => $this->input->post('city'),
                                            'state'       => $this->input->post('state'),
                                            'address'       => $this->input->post('address'),
                                        );
                                    if($this->business_model->edit_business($data,$id)){
                                        $return['res'] = 'success';
                                        $return['msg'] = 'Saved.';
                                    }
                                }
                                else{
                                    $password = $this->input->post('password');
                                    $data = array(
                                        'title'     => $this->input->post('title'),
                                        'owner_name'              => $this->input->post('owner_name'),
                                        'owner_contact'      => $this->input->post('owner_contact'),
                                        'alter_contact'        => $this->input->post('alter_contact'),
                                        'dob'       => $this->input->post('dob'),
                                        'email'       => $this->input->post('email'),
                                        'city'       => $this->input->post('city'),
                                        'state'       => $this->input->post('state'),
                                        'address'       => $this->input->post('address'),
                                        'username'       => $this->input->post('username'),
                                        'password'       => md5($this->input->post('password')),
                                        // 'password' => password_hash($password, PASSWORD_BCRYPT),
                                        );
                                        $conditions = array(
                                            'conditions'=>array(
                                                'type'=>'business_sms',
                                            ),
                                            'returnType' => 'single',
                                        );
                                        $smsData = $this->getSmsRows($conditions);
                                        $smsData['mob'] = $this->input->post('owner_contact');
                                        $smsData["msg"] = mt_rand(100000, 999999);
                                    if ($this->business_model->add_business($data)) {
                                        $this->send_sms($smsData);
                                        $return['res'] = 'success';
                                        $return['msg'] = 'Saved.';
                                    }
                                }
                            }
                            echo json_encode($return);
                            break;
                            case 'delete_business':
                                $id = $p1;
                                if($this->master_model->delete_data('business',$id))
                                {
                                    $data['search'] = '';
                                    $data['city_id'] = '';
                                    $data['state_id'] = '';
                                    $city_id = 'null';
                                    $state_id = 'null';
                                    $search = 'null';
                                    if($p1!=null)
                                    {
                                        $data['state_id'] = $p1;
                                        $state_id = $p1;
                                    }
                                    if($p2!=null)
                                    {
                                        $data['city_id'] = $p2;
                                        $city_id = $p2;
                                        $data['cities']  = $this->master_model->get_data('cities','state_id',$state_id);
                                    }
                                    if($p3!=null)
                                    {
                                        $data['search'] = $p3;
                                        $search = $p3;
                                    }
                                    if (@$_POST['search']) {
                                        $data['search'] = $_POST['search'];
                                        $search = $_POST['search'];
                                    }
                                    if (@$_POST['city_id']) {
                                        $data['city_id'] = $_POST['city_id'];
                                        $city_id = $_POST['city_id'];
                                        $state_id = $_POST['state_id'];
                                        $data['state_id'] = $_POST['state_id'];
                                        $data['cities']  = $this->master_model->get_data('cities','state_id',$_POST['state_id']);
                                    }
                                    $this->load->library('pagination');
                                    $config = array();
                                    $config["base_url"]         = base_url()."businesses/tb/".$state_id."/".$city_id."/".$search;
                                    $config["total_rows"]       = count($this->business_model->businesses($city_id));
                                    $data['total_rows']         = $config["total_rows"];
                                    $config["per_page"]         = 10;
                                    $config["uri_segment"]      = 6;
                                    $config['attributes']       = array('class' => 'pag-link');
                                    $config['full_tag_open']    = "<div class='pag'>";
                                    $config['full_tag_close']   = "</div>";
                                    $config['first_link']       = '&lt;&lt;';
                                    $config['last_link']        = '&gt;&gt;';
                                    $this->pagination->initialize($config);
                                    $data["links"]              = $this->pagination->create_links();
                                    $data['page']               = $page = ($p4!=null) ? $p4 : 0;
                                    $data['per_page']           = $config["per_page"];
                                    $data['businesses']           = $this->business_model->businesses($city_id,$config["per_page"],$page);
                                    $data['update_url']         = base_url().'businesses/create/';
                                    $page                       = 'admin/business/businesses/tb';
                                    $data['states']  = $this->master_model->view_data('states');
                                    $this->load->view($page, $data);
                                }
                              
                                break;
            default:
                # code...
                break;
        }
    }

    public function fetch_city()
    {
        if($this->input->post('state'))
        {
            $sid= $this->input->post('state');
            $this->master_model->fetch_city($sid);
        }
    }
    public function delete_business()
    {
        $id = $this->uri->segment(2);
        if ($this->master_model->delete_data('business',$id)) {
            $this->session->set_flashdata('success', 'Business Deleted Successfully');
            redirect($this->agent->referrer());
        } else {
            $this->session->set_flashdata('error', 'Something Went Wrong!!');
            redirect($this->agent->referrer());
        }
    }

    //SHOPS
    public function shops($action=null,$p1=null,$p2=null,$p3=null,$p4=null,$p5=null)
    {
        switch ($action) {
            case null:
                // $data['menu_id'] = $this->uri->segment(2);
                $data['title']          = 'Shops';
                $data['business_id']= $this->uri->segment(2);
                $business_id= $this->uri->segment(2);
                $data['tb_url']         = base_url().'shops/tb/'.$business_id;
                $data['new_url']        = base_url().'shops/create';
                $page                   = 'admin/business/shops/index';
                $this->header_and_footer($page, $data);
                break;

                case 'tb':
                    $data['search'] = '';
                    $data['city_id'] = '';
                    $data['state_id'] = '';
                    $data['business_id'] = '';
                    $city_id = 'null';
                    $state_id = 'null';
                    $search = 'null';
                    $business_id = 'null';
                    
                    if($p1!=null)
                    {
                        $data['business_id'] = $p1;
                        $business_id = $p1;
                    }
                    if($p2!=null)
                    {
                        $data['state_id'] = $p2;
                        $state_id = $p2;
                    }
                    if($p3!=null)
                    {
                        $data['city_id'] = $p3;
                        $city_id = $p3;
                        $data['cities']  = $this->master_model->get_data('cities','state_id',$state_id);
                    }
                    if($p4!=null)
                    {
                        $data['search'] = $p4;
                        $search = $p4;
                    }
                    if (@$_POST['search']) {
                        $data['search'] = $_POST['search'];
                        $search = $_POST['search'];
                    }
                    if (@$_POST['city_id']) {
                        $data['city_id'] = $_POST['city_id'];
                        $city_id = $_POST['city_id'];
                        $state_id = $_POST['state_id'];
                        $data['state_id'] = $_POST['state_id'];
                        $data['cities']  = $this->master_model->get_data('cities','state_id',$_POST['state_id']);
                    }
                    if (@$_POST['business_id']) {
                        $data['business_id'] = $_POST['business_id'];
                        $business_id = $_POST['business_id'];
                    }
                    
                    $this->load->library('pagination');
                    $config = array();
                    $config["base_url"]         = base_url()."shops/tb/".$business_id."/".$state_id."/".$city_id."/".$search;
                    $config["total_rows"]       = count($this->business_model->shops($city_id,$business_id));
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
                    $data['page']               = $page = ($p5!=null) ? $p5 : 0;
                    $data['details_url']             = base_url().'shops/shop_details/';
                    $data['per_page']           = $config["per_page"];
                    $data['shops']           = $this->business_model->shops($city_id,$business_id,$config["per_page"],$page);
                    $data['update_url']         = base_url().'shops/create/';
                    $data['simg_url']           = base_url().'shops/shop-images/';
                    $data['states']  = $this->master_model->view_data('states');
                    $data['businesses']  = $this->master_model->view_data('business');
                    $page                       = 'admin/business/shops/tb';
                    
                    $this->load->view($page, $data);
                    break;
                    case 'shop_details':
            
                        $data['shops']           = $this->business_model->get_data('shops','id',$p1);
                        $page                  = 'admin/business/shops/shop_details';
                        $this->load->view($page, $data);
        
                        break;
                    case 'create':
                        $data['remote']             = base_url().'business-store/business_remote/shops/';
                        $data['action_url']         = base_url().'shops/save';
                        $data['shop_cat']  = $this->master_model->view_data('shop_category');
                        $data['states']  = $this->master_model->view_data('states');
                        $data['cities']  = $this->master_model->view_data('cities');
                        $data['businesses']  = $this->master_model->view_data('business');
                        $page                       = 'admin/business/shops/create';
                        if ($p1!=null) {
                            $data['action_url']     = base_url().'shops/save/'.$p1;
                            $data['value']          = $this->business_model->shop($p1);
                            $shop_id = $data['value']->id;
                            $data['selected_shop_cat']  = $this->master_model->get_data1('shops_deals_in_category','shop_id',$shop_id);
                            $data['remote']         = base_url().'business-store/business_remote/shops/'.$p1;
                            $page                   = 'admin/business/shops/update';
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
                                    if($this->input->post('isDelivery'))
                                    {
                                        $isDelivery = '1';
                                    }
                                    else
                                    {
                                        $isDelivery = '0';
                                    }
                                    if($this->input->post('is_cod'))
                                    {
                                        $is_cod = '1';
                                    }
                                    else
                                    {
                                        $is_cod = '0';
                                    }
                                    if($this->input->post('is_online_payments'))
                                    {
                                        $is_online_payments = '1';
                                    }
                                    else
                                    {
                                        $is_online_payments = '0';
                                    }
                                    if($this->input->post('is_live'))
                                    {
                                        $is_live = '1';
                                    }
                                    else
                                    {
                                        $is_live = '0';
                                    }
                                    if($this->input->post('is_security'))
                                    {
                                        $is_security = '1';
                                    }
                                    else
                                    {
                                        $is_security = '0';
                                    }
                                    $data = array(
                                        'shop_name'              => $this->input->post('shop_name'),
                                        'state'      => $this->input->post('state'),
                                        'city'        => $this->input->post('city'),
                                        'pin_code'       => $this->input->post('pin_code'),
                                        'address'       => $this->input->post('address'),
                                        'contact'       => $this->input->post('contact'),
                                        'alternate_contact'       => $this->input->post('alternate_contact'),
                                        'email'       => $this->input->post('email'),
                                        'isDelivery'       => $isDelivery,
                                        'open_time'       => $this->input->post('open_time'),
                                        'close_time'       => $this->input->post('close_time'),
                                        'longitude'       => $this->input->post('longitude'),
                                        'latitude'       => $this->input->post('latitude'),
                                        'is_cod'       => $is_cod,
                                        'cod_limit'       => $this->input->post('cod_limit'),
                                        'gstin'       => $this->input->post('gstin'),
                                        'is_online_payments'       => $is_online_payments,
                                        'payment_gateway_name'       => $this->input->post('payment_gateway_name'),
                                        'key_id'       => $this->input->post('key_id'),
                                        'key_secret'       => $this->input->post('key_secret'),
                                        'is_live'       => $is_live,
                                        'delivery_range'       => $this->input->post('delivery_range'),
                                        'description'       => $this->input->post('description'),
                                        'business_id'       => $this->input->post('business_id'),
                                        'is_security'       => $is_security,
                                        'site_key'       => $this->input->post('site_key'),
                                        'secret_key'       => $this->input->post('secret_key'),
                                        'analytics_code'       => $this->input->post('analytics_code'),
                                        );
                                        $shop_category_input     = $this->input->post('shop_category_id');
                                    if($this->business_model->edit_shop($id,$data,$shop_category_input)){
                                        $return['res'] = 'success';
                                        $return['msg'] = 'Saved.';
                                    }
                                }
                                else
                                {
                                    if($this->input->post('isDelivery'))
                                    {
                                        $isDelivery = '1';
                                    }
                                    else
                                    {
                                        $isDelivery = '0';
                                    }
                                    if($this->input->post('is_cod'))
                                    {
                                        $is_cod = '1';
                                    }
                                    else
                                    {
                                        $is_cod = '0';
                                    }
                                    if($this->input->post('is_online_payments'))
                                    {
                                        $is_online_payments = '1';
                                    }
                                    else
                                    {
                                        $is_online_payments = '0';
                                    }
                                    if($this->input->post('is_live'))
                                    {
                                        $is_live = '1';
                                    }
                                    else
                                    {
                                        $is_live = '0';
                                    }
                                    if($this->input->post('is_security'))
                                    {
                                        $is_security = '1';
                                    }
                                    else
                                    {
                                        $is_security = '0';
                                    }
                                    $data = array(
                                        'shop_name'              => $this->input->post('shop_name'),
                                        'state'      => $this->input->post('state'),
                                        'city'        => $this->input->post('city'),
                                        'pin_code'       => $this->input->post('pin_code'),
                                        'address'       => $this->input->post('address'),
                                        'contact'       => $this->input->post('contact'),
                                        'alternate_contact'       => $this->input->post('alternate_contact'),
                                        'email'       => $this->input->post('email'),
                                        'isDelivery'       => $isDelivery,
                                        'open_time'       => $this->input->post('open_time'),
                                        'close_time'       => $this->input->post('close_time'),
                                        'longitude'       => $this->input->post('longitude'),
                                        'latitude'       => $this->input->post('latitude'),
                                        'is_cod'       => $is_cod,
                                        'cod_limit'       => $this->input->post('cod_limit'),
                                        'gstin'       => $this->input->post('gstin'),
                                        'is_online_payments'       => $is_online_payments,
                                        'payment_gateway_name'       => $this->input->post('payment_gateway_name'),
                                        'key_id'       => $this->input->post('key_id'),
                                        'key_secret'       => $this->input->post('key_secret'),
                                        'is_live'       => $is_live,
                                        'delivery_range'       => $this->input->post('delivery_range'),
                                        'description'       => $this->input->post('description'),
                                        'business_id'       => $this->input->post('business_id'),
                                        'is_security'       => $is_security,
                                        'password'       => md5($this->input->post('password')),
                                        'site_key'       => $this->input->post('site_key'),
                                        'secret_key'       => $this->input->post('secret_key'),
                                        'analytics_code'       => $this->input->post('analytics_code'),
                                        );
                                        $shop_category_ids     = $this->input->post('shop_category_id');
                                        $conditions = array(
                                            'conditions'=>array(
                                                'type'=>'shop_sms',
                                            ),
                                            'returnType' => 'single',
                                        );
                                        $smsData = $this->getSmsRows($conditions);
                                        $smsData['mob'] = $this->input->post('contact');
                                        $smsData["msg"] = mt_rand(100000, 999999);
                                    if($this->business_model->add_shop($data,$shop_category_ids) ) 
                                    {
                                        $this->send_sms($smsData);
                                        $return['res'] = 'success';
                                        $return['msg'] = 'Your shop has been successfully registered with shopzone247.com';
                                    }
                                }
                            }
                            echo json_encode($return);
                            break;

                            case 'delete_shop':
                                $id = $this->input->post('shopid');
                                if($this->master_model->delete_data('shops',$id))
                                {
                                    $data['search'] = '';
                                    $data['city_id'] = '';
                                    $data['state_id'] = '';
                                    $data['business_id'] = '';
                                    $city_id = 'null';
                                    $state_id = 'null';
                                    $search = 'null';
                                    $business_id = 'null';
                                    
                                    if($p1!=null)
                                    {
                                        $data['business_id'] = $p1;
                                        $business_id = $p1;
                                    }
                                    if($p2!=null)
                                    {
                                        $data['state_id'] = $p2;
                                        $state_id = $p2;
                                    }
                                    if($p3!=null)
                                    {
                                        $data['city_id'] = $p3;
                                        $city_id = $p3;
                                        $data['cities']  = $this->master_model->get_data('cities','state_id',$state_id);
                                    }
                                    if($p4!=null)
                                    {
                                        $data['search'] = $p4;
                                        $search = $p4;
                                    }
                                    if (@$_POST['search']) {
                                        $data['search'] = $_POST['search'];
                                        $search = $_POST['search'];
                                    }
                                    if (@$_POST['city_id']) {
                                        $data['city_id'] = $_POST['city_id'];
                                        $city_id = $_POST['city_id'];
                                        $state_id = $_POST['state_id'];
                                        $data['state_id'] = $_POST['state_id'];
                                        $data['cities']  = $this->master_model->get_data('cities','state_id',$_POST['state_id']);
                                    }
                                    if (@$_POST['business_id']) {
                                        $data['business_id'] = $_POST['business_id'];
                                        $business_id = $_POST['business_id'];
                                    }
                                    
                                    $this->load->library('pagination');
                                    $config = array();
                                    $config["base_url"]         = base_url()."shops/tb/".$business_id."/".$state_id."/".$city_id."/".$search;
                                    $config["total_rows"]       = count($this->business_model->shops($city_id,$business_id));
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
                                    $data['page']               = $page = ($p5!=null) ? $p5 : 0;
                                    $data['details_url']             = base_url().'shops/shop_details/';
                                    $data['per_page']           = $config["per_page"];
                                    $data['shops']           = $this->business_model->shops($city_id,$business_id,$config["per_page"],$page);
                                    $data['update_url']         = base_url().'shops/create/';
                                    $data['simg_url']           = base_url().'shops/shop-images/';
                                    $data['states']  = $this->master_model->view_data('states');
                                    $data['businesses']  = $this->master_model->view_data('business');
                                    $page                       = 'admin/business/shops/tb';
                                    
                                    $this->load->view($page, $data);
                                }
                              
                                break;
            
                                case 'shop-images':
                                        $data['sid'] = $p1;
                                        $data['images']        = $this->business_model->get_data1('shops_photo','shop_id',$p1);
                                        $page                  = 'admin/business/shops/shop_images';
                                        
                                        $this->load->view($page, $data);
                    
                                    break;
                                    case 'add_image':
                                        $id = $this->input->post('sid');
                                        $imageCount = count($_FILES['file']['name']);
                                        if (!empty($imageCount)) {
                                            for ($i = 0; $i < $imageCount; $i++) {
                                                $config['file_name'] = date('Ymd') . rand(1000, 1000000);
                                                $config['upload_path'] = UPLOAD_PATH.'shop_photo/';
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
                                                    $images[] = "shop_photo/" . $imageData['file_name'];
                                                }
                                            }
                                            }
                                            if (!empty($images)) {      
                                                foreach ($images as $file) {
                                                    $file_data = array(
                                                        'image' => $file,
                                                        'shop_id' => $id
                                                    );
                                                    $this->db->insert('shops_photo', $file_data);
                                                }
                                            }
                                        break;
                                        case 'delete_image':
                                            //delete code    
                                            $id = $p2;
                                            if($this->business_model->delete_shop_image($id))
                                            {
                                       
                                                $data['sid']           = $p1;
                                                $data['images']        = $this->business_model->get_data1('shops_photo','shop_id',$p1);
                                                $page                  = 'admin/business/shops/shop_images';
                                                $this->load->view($page, $data);
                                                
                                            }
                                            break;
                                            case 'make_cover': 
                                                $id = $p2;
                                                if($this->business_model->remove_shop_cover($p1) && $this->business_model->make_shop_cover($id))
                                                {
                                                    $data['sid']           = $p1;
                                                    $data['images']        = $this->business_model->get_data1('shops_photo','shop_id',$p1);
                                                    $page                  = 'admin/business/shops/shop_images';
                                                    $this->load->view($page, $data);
                                                    
                                                }
                                                break;
                                                case 'update_shop_seq':
                                                    $id = $p2;
                                                    $seq = $p3;
                                                    $data = array(
                                                        'seq'     => $seq,
                                                    );
                                                    if($this->business_model->edit_data('shops_photo',$id,$data))
                                                    {
                                                        $data['sid']           = $p1;
                                                        $data['images']        = $this->business_model->get_data1('shops_photo','shop_id',$p1);
                                                        $page                  = 'admin/business/shops/shop_images';
                                                        $this->load->view($page, $data);
                                                        
                                                    }
                                                    else
                                                    {
                                                        echo('Sequence Already Exists!!');
                                                    }
                                                    break;
                                default:
                # code...
                break;
        }

    }

    public function change_business_status()
    {
        $id = $this->input->post('id');
        $data['status_data'] = $this->master_model->get_row_data('business','id',$id);
        $business_id = $data['status_data']->id;
        $shop_data = $this->master_model->get_data('shops','business_id',$business_id);

        if($data['status_data']->status == 1)
        {
            $data1 = array(
                'status' => 0
            );
            if(!empty($shop_data))
            {
                $data2 = array(
                    'isActive' => 0
                );
            }
        }
        else if($data['status_data']->status == 0)
        {
            $data1 = array(
                'status' => 1
            );
            if(!empty($shop_data))
            {
                $data2 = array(
                    'isActive' => 1
                );
            }
        }
        if(!empty($shop_data))
        {
            $this->master_model->update_data('shops','business_id',$business_id,$data2);
        }
        $this->master_model->edit_data('business',$id,$data1);
        $this->load->view('admin/header_statusview',$data);
        
    }
}