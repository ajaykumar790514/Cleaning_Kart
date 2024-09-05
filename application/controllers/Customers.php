<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Customers extends CI_Controller {

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


    public function customers_acquisition($action=null,$p1=null,$p2=null,$p3=null,$p4=null)
    {
        switch ($action) {
            case null:
                $data['title']          = 'Customers';
                $data['tb_url']         = base_url().'customers-acquisition/tb';
                $page                   = 'admin/customers/index';
                $this->header_and_footer($page, $data);
                break;

                case 'tb':
                    $data['search'] = '';
                    $data['from_date'] = '';
                    $data['to_date'] = '';

                    //below variable section used for models and other places
                    $from_date='null';
                    $to_date='null';
                    $search='null';

                    //get section intiliazation
                    if($p2!=null)
                    {
                        $data['from_date'] = $p1;
                        $data['to_date'] = $p2;
                        $from_date = $p1;
                        $to_date = $p2;
                    }
                    if($p3!=null)
                    {
                        $data['search'] = $p3;
                        $search = $p3;
                    }
                    //end of section

                    if (@$_POST['search']) {
                        $data['search'] = $_POST['search'];
                        $search = $_POST['search'];
                    }
                    if (@$_POST['to_date']) {
                        $data['from_date'] = $_POST['from_date'];
                        $data['to_date'] = $_POST['to_date'];
                        $from_date = $_POST['from_date'];
                        $to_date = $_POST['to_date'];
                    }
                    
                    $this->load->library('pagination');
                    $config = array();
                    $config["base_url"]         = base_url()."customers-acquisition/tb/".$from_date."/".$to_date."/".$search;
                    $config["total_rows"]       = $this->customers_model->get_customers_data($from_date,$to_date,$search);
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
                    $data['address_url']             = base_url().'customers-acquisition/customer_addresses/';
                    $data['reward_url']             = base_url().'customers-acquisition/rewards/';
                    $data['per_page']           = $config["per_page"];
                    $data['customers']           = $this->customers_model->get_customers_data($from_date,$to_date,$search,$config["per_page"],$page);
                    $page                       = 'admin/customers/tb';
                    $this->load->view($page, $data);
                    break;
                
                case 'customer_addresses':
            
                $data['address']           = $this->customers_model->address($p1);
                $page                  = 'admin/customers/customer_addresses';
                $this->load->view($page, $data);

                break;
                case 'rewards':
                    $data['cust_id'] = $p1;
                    $admin_data = $this->customers_model->display_data('admin');
                    $customer_data = $this->customers_model->get_row_data1('customers','id',$p1);
                    $data['cust_reward'] = $customer_data->rewards;
                    $data['admin_reward'] = $admin_data->rewards;
                    $page                  = 'admin/customers/add_reward';
                    $this->load->view($page,$data);

                break;
                case 'add_reward_point':
                    
                    $cust_id =  $this->input->post('cust_id'); 
                    $cust_reward =  $this->input->post('cust_reward');
                    $total =  $cust_reward + $this->input->post('rewards');
                    $data['rewards'] = $total; 
                    if($this->master_model->edit_data('customers',$cust_id,$data)) 
                    {
                        $admin_data = $this->customers_model->display_data('admin');
                        $admin['rewards'] = $admin_data->rewards - $this->input->post('rewards');
                        $this->master_model->edit_data('admin','1',$admin);
                        echo $total;
                    }

                break;
                case 'change_cust_status':
                    
                    $id = $this->input->post('id');
                    $data['status_data'] = $this->customers_model->get_row_data('customers','id',$id);

                    if($data['status_data']->isActive == 1)
                    {
                        $data1 = array(
                            'isActive' => 0
                        );
                    }
                    else if($data['status_data']->isActive == 0)
                    {
                        $data1 = array(
                            'isActive' => 1
                        );
                    }
                    $this->customers_model->edit_data('customers',$id,$data1);
                    $this->load->view('admin/customers/cust_status_view',$data);

                break;
                case 'send_notifications':
                    
                    $title = $this->input->post('title');
                    $body = $this->input->post('body');

                    // set post fields
                    
                    $post['tokens']= $this->customers_model->get_customers();
                    foreach($post['tokens'] as $post)
                    {
                        $post = [
                            'title' => $title,
                            'body' => $body,
                        ];
                        
                        $ch = curl_init('http://3.12.154.83/shopzonews_cleaningkart/shopzone/index.php/Utility/remoteNotification');
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
                
                        // execute!
                        $response = curl_exec($ch);
                
                        // close the connection, release resources used
                        curl_close($ch);
                
                        // do anything you want with your response
                        // var_dump($response);
                    }
                    if($response == true)
                    {
                    echo('Notification Sent Successfully');
                    }

                break;
                default:
                # code...
                break;
        }
    }
    public function change_cust_status()
    {
        $id = $this->input->post('id');
        $data['status_data'] = $this->customers_model->get_row_data('customers','id',$id);

        if($data['status_data']->isActive == 1)
        {
            $data1 = array(
                'isActive' => 0
            );
        }
        else if($data['status_data']->isActive == 0)
        {
            $data1 = array(
                'isActive' => 1
            );
        }
        $this->customers_model->edit_data('customers',$id,$data1);
        $this->load->view('admin/customers/cust_status_view',$data);
        
    }
   


}