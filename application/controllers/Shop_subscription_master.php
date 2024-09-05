<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
class Shop_subscription_master extends CI_Controller {

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
        $data['shop_menus'] = $this->admin_model->get_role_menu_data($shop_role_id);
        $data['all_menus'] = $this->admin_model->get_data1('tb_admin_menu','status','1');
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
        $data['title'] = 'Subscription';
        $menu_id = $this->uri->segment(2);
        $data['menu_id'] = $menu_id;
        $role_id = $_SESSION['shop_role_id'];
        $data['sub_menus'] = $this->admin_model->get_submenu_data($menu_id,$role_id);
        $page = 'shop/subscription/subscription_data';
        $this->header_and_footer($page, $data);
    }
   


    //Subscription Slots
    public function subscription_slots()
    {
        $data['title']      = 'Subscription Slots';
        $data['subscription_slots']  = $this->subscription_model->get_subscription_slots();
        $data['business']  = $this->subscription_model->view_data('business');
        $page = 'shop/subscription/subscription_slots';
        $this->header_and_footer($page, $data);
    }


    public function add_subscription_slot()
    {
        $data = array(
            'timestart'     => $this->input->post('timestart'),
            'timeend'     => $this->input->post('timeend'),
            'seq'     => $this->input->post('seq'),
            'shop_id'     => $_SESSION['user_data']['id']
        );
        if ($this->subscription_model->add_data('subscriptions_slots',$data)) {
            $this->session->set_flashdata('success', 'Slot Added Successfully');
            redirect($this->agent->referrer());
        } else {
            $this->session->set_flashdata('error', 'Something Went Wrong!!');
            redirect($this->agent->referrer());
        }
    }   
    public function edit_subscription_slot()
    {
        $id = $this->uri->segment(3);
        $data = array(
            'timestart'     => $this->input->post('timestart'),
            'timeend'     => $this->input->post('timeend'),
            'seq'     => $this->input->post('seq'),
            'shop_id'     => $_SESSION['user_data']['id']
        );
        if ($this->subscription_model->edit_data('subscriptions_slots',$id,$data)) {
            $this->session->set_flashdata('success', 'Slot Edited Successfully');
            redirect($this->agent->referrer());
        } else {
            $this->session->set_flashdata('error', 'Something Went Wrong!!');
            redirect($this->agent->referrer());
        }
    }   
    public function delete_subscription_slot()
    {
        $id = $this->uri->segment(3);
        if ($this->master_model->delete_data('subscriptions_slots',$id)) {
            $this->session->set_flashdata('success', 'Slot Deleted Successfully');
            redirect($this->agent->referrer());
        } else {
            $this->session->set_flashdata('error', 'Something Went Wrong!!');
            redirect($this->agent->referrer());
        }
    }

    function multiple_delete()
    {
     if($this->input->post('checkbox_value'))
     {
        $id = $this->input->post('checkbox_value');
        $table = $this->input->post('table');
        for($count = 0; $count < count($id); $count++)
        {
            $this->subscription_model->delete_data($table,$id[$count]);
        }
        
     }
    }

    //Status
    public function change_plan_type_status()
    {
        $id = $this->input->post('id');
        $data['status_data'] = $this->subscription_model->get_row_data('subscriptions_plan_types','id',$id);


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
        $this->subscription_model->edit_data('subscriptions_plan_types',$id,$data1);
        $this->load->view('admin/statusview',$data);
        
    }
    public function change_slot_status()
    {
        $id = $this->input->post('id');
        $data['status_data'] = $this->subscription_model->get_row_data('subscriptions_slots','id',$id);

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
        $this->subscription_model->edit_data('subscriptions_slots',$id,$data1);
        $this->load->view('admin/statusview',$data);
        
    }
}

?>