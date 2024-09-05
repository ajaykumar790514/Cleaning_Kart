<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Subscription extends CI_Controller {

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
        $data['title'] = 'Subscription';
        $page = 'admin/subscription/subscription_data';
        $this->header_and_footer($page, $data);
    }
    // Plan types
    public function subscription_plan_types()
    {
        $data['menu_id'] = $this->uri->segment(2);
        $data['title']      = 'Plan types';
        $data['plan_types']      = $this->subscription_model->view_data('subscriptions_plan_types');
        $data['remote']     = base_url().'subscription-data/remote/plan_types/';
        $page               = 'admin/subscription/plan_types';
        $this->header_and_footer($page, $data);
    }
    public function add_plan_type()
    {
        $data = array(
            'plan'     => $this->input->post('plan')
        );
        if ($this->subscription_model->add_data('subscriptions_plan_types',$data)) {
            $this->session->set_flashdata('success', 'Plan type Added Successfully');
            redirect($this->agent->referrer());
        } else {
            $this->session->set_flashdata('error', 'Something Went Wrong!!');
            redirect($this->agent->referrer());
        }
    }   
    public function edit_plan_type()
    {
        $id = $this->uri->segment(3);
        $data = array(
            'plan'     => $this->input->post('plan')
        );
        if ($this->master_model->edit_data('subscriptions_plan_types',$id,$data)) {
            $this->session->set_flashdata('success', 'Plan type Edited Successfully');
            redirect($this->agent->referrer());
        } else {
            redirect($this->agent->referrer());
        }
    }   
    public function delete_plan_type()
    {
        $id = $this->uri->segment(3);
        if ($this->master_model->delete_data('subscriptions_plan_types',$id)) {
            $this->session->set_flashdata('success', 'Plan type Deleted Successfully');
            redirect($this->agent->referrer());
        } else {
            $this->session->set_flashdata('error', 'Something Went Wrong!!');
            redirect($this->agent->referrer());
        }
    } 

    public function remote($type,$id=null,$column='name')
    {
        if ($type=='plan_types') {
            $tb = 'subscriptions_plan_types';
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

    //Subscription Slots
    public function subscription_slots()
    {
        $data['menu_id'] = $this->uri->segment(2);
        $data['title']      = 'Subscription Slots';
        $data['subscription_slots']  = $this->subscription_model->get_subscription_slots();
        $data['business']  = $this->subscription_model->view_data('business');
        $page = 'admin/subscription/subscription_slots';
        $this->header_and_footer($page, $data);
    }
    //Fetch Slots
    public function fetch_slot()
    {
        $shop_id= $this->input->post('shop_id');
        $data['available_slots'] = $this->subscription_model->get_data('subscriptions_slots','shop_id',$shop_id);
        $this->load->view('admin/master/available_slots',$data);
    }

    public function add_subscription_slot()
    {
        $data = array(
            'timestart'     => $this->input->post('timestart'),
            'timeend'     => $this->input->post('timeend'),
            'seq'     => $this->input->post('seq'),
            'shop_id'     => $this->input->post('shop_id')
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
            'shop_id'     => $this->input->post('shop_id')
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

    //Fetch Shops
    public function fetch_shop()
    {
        if($this->input->post('business_id'))
        {
            $bid= $this->input->post('business_id');
            $this->master_model->fetch_shop($bid);
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