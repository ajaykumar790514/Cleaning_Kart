<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function isLoggedIn(){
        $is_logged_in = $this->session->userdata('shop_logged_in');
        if(!isset($is_logged_in) || $is_logged_in!==TRUE)
        {
            redirect(base_url());
            exit;
        }
    } 
	public function check_role(){
        $shop_role_id = $_SESSION['shop_role_id'];
        if($shop_role_id !== '2')
        {
            redirect(base_url());
            exit;
        }    
    } 
	public function index()
	{
        if($this->session->has_userdata('logged_in')===FALSE || $this->session->logged_in === FALSE){
			$login = $this->load->view('auth/login',NULL,TRUE);
			echo $login;
		}
		elseif($this->session->has_userdata('admin_logged_in')===TRUE)
		{
			redirect('admin-dashboard');
		}
		else{
			$this->dashboard();
		}
	}
	public function shop_generate_otp(){
		if(isset($_POST['mobile']) && $_POST['mobile']!==''){
			$check_existing_record = $this->shops_model->getRows(array('conditions'=>array('contact '=>$_POST['mobile'],'isActive'=>'1')));
			// print_r($check_existing_record);
			// die();
			if($check_existing_record){
				$otp=mt_rand(100000, 999999);
				if($this->shops_model->updateRow($check_existing_record[0]['id'],array('otp'=>$otp)))
				{
					//code to send the otp to the mobile number will be placed here
					if(TRUE)
					{
						$data['status']= TRUE;
						$data['message'] = $otp;
					}
					else
					{
						$data['status']= FALSE;
						$data['message'] = "Message could not be sent.";	
					}
				}
				else
				{
					$data['status']= FALSE;
					$data['message'] = "Otp could not be generated.";	
				}
			}
			else
			{
				$data['status']= FALSE;
				$data['message'] = "Mobile number does not exist.";
			}
		}
		else
		{
			$data['status']= FALSE;
			$data['message'] = "Mobile number not received.";
		}
		echo json_encode($data);
		return TRUE;
	}
	public function shop_login(){
		if(isset($_POST['contact']) && $_POST['contact']!==''){
			$check_existing_record = $this->shops_model->getRows(array('conditions'=>array('contact '=>$_POST['contact'],'isActive'=>'1')));
			// print_r($check_existing_record);
			// die();
			if($check_existing_record){
				$contact = $_POST['contact'];
        		$password = md5($_POST['password']);
				if($this->shops_model->shop_login($contact,$password))
				{
						if($check_existing_record[0]['is_security'] == '1')
						{
							$otp=mt_rand(100000, 999999);
							$this->shops_model->updateRow($check_existing_record[0]['id'],array('otp'=>$otp));
							$data['status']= TRUE;
							$data['message'] = 'secured';
							$data['otp'] = $otp;
						}
						else
						{
							$session_array = array(
								'user_table'=>'shops',
								'shop_role_id'=>$check_existing_record[0]['role_id'],
								'user_data'=>$check_existing_record[0],
								'logged_in'=>TRUE,
								'shop_logged_in'=>TRUE
							);
							$this->session->set_userdata($session_array);
							$data['status']= TRUE;
							$data['message'] = 'not_secured';
						}
				}
				else
				{
					$data['status']= FALSE;
					$data['message'] = "Incorrect password";	
				}
			}
			else
			{
				$data['status']= FALSE;
				$data['message'] = "Mobile number does not exist.";
			}
		}
		else
		{
			$data['status']= FALSE;
			$data['message'] = "Something went wrong!!";
		}
		echo json_encode($data);
		return TRUE;
	}

	public function shop_verify_login(){
		if(isset($_POST['mobile']) && isset($_POST['otp']) && $_POST['otp']!=='' && $_POST['mobile']!==''){
			$check_existing_record = $this->shops_model->getRows(array('conditions'=>array('contact'=>$_POST['mobile'],'isActive'=>'1')));
			if($check_existing_record !== NULL){
				if($_POST['otp']===$check_existing_record[0]['otp']){
					$this->shops_model->updateRow($check_existing_record[0]['id'],array('otp'=>'######'));
					$business_data = $this->business_model->getRows(array('conditions'=>array('id'=>$check_existing_record[0]['business_id'])));
					$session_array = array(
											'user_table'=>'shops',
											'shop_role_id'=>$check_existing_record[0]['role_id'],
											'user_data'=>$check_existing_record[0],
											'user_business_data'=>$business_data[0],
											'logged_in'=>TRUE,
											'shop_logged_in'=>TRUE
										);
					$this->session->set_userdata($session_array);
					$data['status']= TRUE;
					$data['message'] = "OTP Verified.";				
				}else{
					$data['status']= FALSE;
					$data['message'] = "OTP did not match";	
				}
			}else{
				$data['status']= FALSE;
				$data['message'] = "User does not exist.";
			}
		}else{
			$data['status']= FALSE;
			$data['message'] = "OTP not received.";
		}
		echo json_encode($data);
		return TRUE;
	}
	public function logout(){
		$this->session->unset_userdata(array('user_table','user_data','logged_in','shop_logged_in','shop_role_id'));
		redirect(base_url());
	}
	public function dashboard(){
		$this->isLoggedIn();
		$this->check_role();
		//edited by sanya on 06-01-2022
		$shop_id     = $_SESSION['user_data']['id'];
		$shop_role_id     = $_SESSION['user_data']['role_id'];
		$shop_details = $this->shops_model->get_shop_data($shop_id);
		$data['all_menus'] = $this->admin_model->get_data1('tb_admin_menu','status','1');
		$data['shop_menus'] = $this->admin_model->get_role_menu_data($shop_role_id);

		if($this->session->has_userdata('logged_in') && $this->session->logged_in === TRUE){
			$template_data = array(
									'menu'=>$this->load->view('template/menu',$data,TRUE),
									// 'menu'=>$this->load->view('template/menu',NULL,TRUE),
									'main_body_data'=>$this->load->view('template/sample_dashboard',NULL,TRUE),
									'shop_photo'=>$shop_details->logo
								);
			$this->load->view('template/main_template',$template_data);
		}else{
			redirect(base_url());
		}
	}
	public function profile(){
		$this->isLoggedIn();
		$this->check_role();
		$shop_id     = $_SESSION['user_data']['id'];
		$shop_role_id     = $_SESSION['user_data']['role_id'];
		$shop_details = $this->shops_model->get_shop_data($shop_id);
		$data['shop_menus'] = $this->admin_model->get_role_menu_data($shop_role_id);
		$data['all_menus'] = $this->admin_model->get_data1('tb_admin_menu','status','1');
		if($this->session->has_userdata('logged_in') && $this->session->logged_in === TRUE){
			$shop_id     = $_SESSION['user_data']['id'];
		    $shop_details = $this->shops_model->get_shop_data($shop_id);
			$template_data = array(
									'menu'=>$this->load->view('template/menu',$data,TRUE),
									'main_body_data'=>$this->load->view('auth/profile',NULL,TRUE),
									'shop_photo'=>$shop_details->logo
								);
			$this->load->view('template/main_template',$template_data);
		}else{
			redirect(base_url());
		}
	}

	public function header_and_footer($page, $data)
    {
		$shop_id     = $_SESSION['user_data']['id'];
		$shop_role_id     = $_SESSION['user_data']['role_id'];
		$shop_details = $this->shops_model->get_shop_data($shop_id);
		$data['shop_menus'] = $this->admin_model->get_role_menu_data($shop_role_id);
		$data['all_menus'] = $this->admin_model->get_data1('tb_admin_menu','status','1');
        $template_data = array(
        'menu'=> $this->load->view('template/menu',$data,TRUE),
        'main_body_data'=> $this->load->view($page,$data,TRUE),
		'shop_photo'=>$shop_details->logo
        );
            $this->load->view('template/main_template',$template_data);
    }
    public function shop_profile()
	{
		$this->isLoggedIn();
		$this->check_role();
        $data['title'] = 'Shop Profile';
		$shop_id     = $_SESSION['user_data']['id'];
		$data['shop_id']     = $_SESSION['user_data']['id'];
        $data['shop_data'] = $this->shops_model->get_shop_data($shop_id);
		$data['shop_img_url']           = base_url().'welcome/shop_images/';
	
            $page = 'shop/shop_profile';
        $this->header_and_footer($page, $data);
	}
    public function shop_images($id)
	{
			$data['sid'] = $id;
			$data['images']        = $this->business_model->get_data1('shops_photo','shop_id',$id);
			$page                  = 'shop/shop_images';
			
			$this->load->view($page, $data);
	}
	//function for adding shop images
    public function add_image()
	{
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
	}
	//function for deleting shop image
    public function delete_shop_image()
	{
		$shop_id     = $this->uri->segment(3);
		$imageid = $this->uri->segment(4);
		if($this->business_model->delete_shop_image($imageid))
		{
	
			$data['sid']           = $shop_id;
			$data['images']        = $this->business_model->get_data1('shops_photo','shop_id',$shop_id);
			$page                  = 'shop/shop_images';
			$this->load->view($page, $data);
			
		}
	}
	//function for making shop cover photo
    public function make_shop_cover()
	{
		$shop_id     = $this->uri->segment(3);
		$imageid = $this->uri->segment(4);
		if($this->business_model->remove_shop_cover($shop_id) && $this->business_model->make_shop_cover($imageid))
		{
			$data['sid']           = $shop_id;
			$data['images']        = $this->business_model->get_data1('shops_photo','shop_id',$shop_id);
			$page                  = 'shop/shop_images';
			$this->load->view($page, $data);
			
		}
	}

    public function edit_shop_profile()
	{
        $shop_id     = $_SESSION['user_data']['id'];
		if($this->input->post('is_cod'))
		{
			$is_cod = '1';
		}
		else
		{
			$is_cod = '0';
		}
		if($this->input->post('is_live'))
		{
			$is_live = '1';
		}
		else
		{
			$is_live = '0';
		}
		if($this->input->post('isDelivery'))
		{
			$isDelivery = '1';
		}
		else
		{
			$isDelivery = '0';
		}
		if($this->input->post('is_online_payments'))
		{
			$is_online_payments = '1';
		}
		else
		{
			$is_online_payments = '0';
		}
		if($this->input->post('is_security'))
		{
			$is_security = '1';
		}
		else
		{
			$is_security = '0';
		}
		if($this->input->post('is_ecommerce'))
		{
			$is_ecommerce = '1';
		}
		else
		{
			$is_ecommerce = '0';
		}
        $data = array(
            'cod_limit'     => $this->input->post('cod_limit'),
            'is_cod'     => $is_cod,
            'is_live'     => $is_live,
            'open_time'     => $this->input->post('open_time'),
            'close_time'     => $this->input->post('close_time'),
            'email'     => $this->input->post('email'),
            'isDelivery'     => $isDelivery,
            'is_online_payments'     => $is_online_payments,
            'is_security'     => $is_security,
            'analytics_code'     => $this->input->post('analytics_code'),
        );
        $layout_data = array(
            'slider_buttons'     => $this->input->post('slider_buttons'),
            'iphone_url'     => $this->input->post('iphone_url'),
            'android_url'     => $this->input->post('android_url'),
            'is_ecommerce'     => $is_ecommerce,
        );
        if($this->shops_model->edit_shop_profile($data,$shop_id)) {
			$layout_settings = $this->shops_model->get_data1('layout_settings','shop_id',$shop_id);
			if(!empty($layout_settings))
			{
				$this->shops_model->update_data('layout_settings','shop_id',$shop_id,$layout_data);
			}
			else
			{
				$layout_data['shop_id'] = $shop_id;
				$this->shops_model->add_data('layout_settings',$layout_data);
			}
			$check_existing_record = $this->shops_model->getRows(array('conditions'=>array('id '=>$shop_id,'isActive'=>'1')));
			$session_array['user_data'] = $check_existing_record[0];
			$this->session->set_userdata($session_array);
            redirect($this->agent->referrer());
        } else {
            redirect($this->agent->referrer());
        }
    
    }

	public function shop_change_password()
	{		
		$this->isLoggedIn();
		$this->check_role();
        $data['title'] = 'Change Password';
        $page = 'shop/shop_change_password';
        $this->header_and_footer($page, $data);
	}
    public function update_shop_password()
	{
        $password = $this->input->post('new_password');
        $shop_id     = $_SESSION['user_data']['id'];
        $data = array(
            'password'     => md5($this->input->post('new_password')),
        );
        $old_pass = md5($this->input->post('old_password'));
        $result = $this->shops_model->check_old_password($old_pass,$shop_id);

        if($result)
        {
            if ($this->shops_model->edit_data('shops',$shop_id,$data)) {
                $this->session->set_flashdata('success','Password Changed Successfully..');
                redirect($this->agent->referrer());
            } else {
                $this->session->set_flashdata('error','Password Not Changed!!');
                redirect($this->agent->referrer());
            }
        }
        else
        {
            $this->session->set_flashdata('error','Old Password Does not match!!');
			redirect($this->agent->referrer());
        }
	}
	public function shop_enquiry($action=null,$p1=null)
    {
        switch ($action) {
            case null:
                $data['menu_id'] = $this->uri->segment(2);
                $data['title']          = 'Enquiry';
                $data['tb_url']         = base_url().'shop-enquiry/tb';
                $page                   = 'shop/enquiry/index';
                $this->header_and_footer($page, $data);
                break;

                case 'tb':
    
                    $this->load->library('pagination');
                    $config = array();
                    $config["base_url"]         = base_url()."shop-enquiry/tb/";
                    $config["total_rows"]       = $this->portal_model->enquiry_data();
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
                    $data['enquiry_data']           = $this->portal_model->enquiry_data($config["per_page"],$page);
                    $page                       = 'shop/enquiry/tb';
                    
                    $this->load->view($page, $data);
                    break;
					case 'delete_enquiry':
						$id = $this->input->post('enquiry_id');
						if($this->db->where('id', $id)->delete('feedback'))
						{
							echo "success";
						}
						break;
            default:
                # code...
                break;
        }
    }
}
