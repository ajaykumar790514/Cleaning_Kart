<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Shopzone_portal extends CI_Controller {

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
        $data['title'] = 'Shopzone Portal';
        $page = 'admin/portal/portal_data';
        $this->header_and_footer($page, $data);
    }

    public function portal_news($action=null,$p1=null)
    {
        switch ($action) {
            case null:
                $data['menu_id'] = $this->uri->segment(2);
                $data['title']          = 'News';
                $data['tb_url']         = base_url().'portal-news/tb';
                $data['new_url']        = base_url().'portal-news/create';
                $page                   = 'admin/portal/news/index';
                $this->header_and_footer($page, $data);
                break;

                case 'tb':
    
                    $this->load->library('pagination');
                    $config = array();
                    $config["base_url"]         = base_url()."portal-news/tb/";
                    $config["total_rows"]       = $this->portal_model->news_data();
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
                    $data['news_data']           = $this->portal_model->news_data($config["per_page"],$page);
                    $data['update_url']         = base_url().'portal-news/create/';
                    $page                       = 'admin/portal/news/tb';
                    
                    $this->load->view($page, $data);
                    break;
                

            case 'create':
                $data['remote']             = base_url().'shopzone-portal/remote/products/';
                $data['action_url']         = base_url().'portal-news/save';
                $page                       = 'admin/portal/news/create';
                if ($p1!=null) {
                    $data['action_url']     = base_url().'portal-news/save/'.$p1;
                    $data['value']          = $this->portal_model->get_row_data1('news','id',$p1);
                    $data['remote']         = base_url().'shopzone-portal/remote/products/'.$p1;
                    $page                   = 'admin/portal/news/update';
                }
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
                                'description'     => $this->input->post('description'),
                                'datetime'              => $this->input->post('datetime'),
                                'meta_keyword'   => $this->input->post('meta_keyword'),
                                'meta_description'      => $this->input->post('meta_description'),
                                'priority'      => $this->input->post('priority'),
                                
                                );
                            if($this->portal_model->edit_news($data,$id)){
                                $return['res'] = 'success';
                                $return['msg'] = 'Updated.';
                            }
                        }
                        else{ 
                            $data = array(
                                    'title'     => $this->input->post('title'),
                                    'description'     => $this->input->post('description'),
                                    'datetime'              => $this->input->post('datetime'),
                                    'meta_keyword'   => $this->input->post('meta_keyword'),
                                    'meta_description'      => $this->input->post('meta_description'),
                                    'priority'      => $this->input->post('priority'),
                                );
                               
                            if ($this->portal_model->add_news($data)) {
                                $return['res'] = 'success';
                                $return['msg'] = 'Saved.';
                            }
                        }
                    }
                    echo json_encode($return);
                    break;
                    case 'delete_news':
                        $id = $this->input->post('news_id');
                        if($this->portal_model->delete_news($id))
                        {
                            $this->load->library('pagination');
                            $config = array();
                            $config["base_url"]         = base_url()."portal-news/tb/";
                            $config["total_rows"]       = $this->portal_model->news_data();
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
                            $data['news_data']           = $this->portal_model->news_data($config["per_page"],$page);
                            $data['update_url']         = base_url().'portal-news/create/';
                            $page                       = 'admin/portal/news/tb';
                            
                            $this->load->view($page, $data);
                        }
                        break;
            
            default:
                # code...
                break;
        }
    }
    public function portal_recaptcha($action=null,$p1=null)
    {
        switch ($action) {
            case null:
                $data['menu_id'] = $this->uri->segment(2);
                $data['title']          = 'Recaptcha';
                $data['tb_url']         = base_url().'portal-recaptcha/tb';
                $page                   = 'admin/portal/recaptcha/index';
                $this->header_and_footer($page, $data);
                break;

                case 'tb':
                    $data['recaptcha_data']           = $this->portal_model->get_row_data1('recaptcha','id','1');
                    $data['update_url']         = base_url().'portal-recaptcha/create/';
                    $page                       = 'admin/portal/recaptcha/tb';
                    
                    $this->load->view($page, $data);
                    break;
                

            case 'create':
                if ($p1!=null) {
                    $data['action_url']     = base_url().'portal-recaptcha/save/'.$p1;
                    $data['value']          = $this->portal_model->get_row_data1('recaptcha','id',$p1);
                    $page                   = 'admin/portal/recaptcha/update';
                }
                $this->load->view($page, $data);
                break;
                case 'save':
                    $id = $p1;
                    $return['res'] = 'error';
                    $return['msg'] = 'Not Saved!';
    
                    if ($this->input->server('REQUEST_METHOD')=='POST') { 
                      
                         if ($id!=null) {
                            $data = array(
                                'site_key'     => $this->input->post('site_key'),
                                'secret_key'     => $this->input->post('secret_key'),
                                );
                            if($this->portal_model->edit_data('recaptcha',$id,$data)){
                                $return['res'] = 'success';
                                $return['msg'] = 'Updated.';
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
    public function portal_enquiry($action=null,$p1=null)
    {
        switch ($action) {
            case null:
                $data['menu_id'] = $this->uri->segment(2);
                $data['title']          = 'Enquiry';
                $data['tb_url']         = base_url().'portal-enquiry/tb';
                $data['new_url']        = base_url().'portal-enquiry/create';
                $page                   = 'admin/portal/enquiry/index';
                $this->header_and_footer($page, $data);
                break;

                case 'tb':
    
                    $this->load->library('pagination');
                    $config = array();
                    $config["base_url"]         = base_url()."portal-enquiry/tb/";
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
                    $page                       = 'admin/portal/enquiry/tb';
                    
                    $this->load->view($page, $data);
                    break;
            default:
                # code...
                break;
        }
    }
    public function change_news_status()
    {
        $id = $this->input->post('id');
        $data['status_data'] = $this->portal_model->get_row_data1('news','id',$id);


        if($data['status_data']->status == 1)
        {
            $data1 = array(
                'status' => 0
            );
        }
        else if($data['status_data']->status == 0)
        {
            $data1 = array(
                'status' => 1
            );
        }
        $this->portal_model->edit_data('news',$id,$data1);
        $this->load->view('admin/header_statusview',$data);
        
    }
}

?>