<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ACL extends CI_Controller {

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
        // else
        // {
        //     redirect(base_url());
        //     exit;
        // }      
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
        $data['title'] = 'ACL';
        $page = 'admin/acl/acl_data';
        $this->header_and_footer($page, $data);
    }
    public function admin_menu($action=null,$p1=null,$p2=null,$p3=null)
    {
        // $data['user']    = $this->checkLogin();
        switch ($action) {
            case null:
                $data['menu_id'] = $this->uri->segment(2);
                $data['title'] = 'Admin Menu';
                $data['tb_url']         = base_url().'admin-menu/tb';
                $data['new_url']        = base_url().'admin-menu/create';
                $page = 'admin/acl/admin_menu/index';
                $this->header_and_footer($page, $data);
                break;

                case 'tb':
                    $this->load->library('pagination');
                    $config = array();
                    $config["base_url"]         = base_url()."admin-menu/tb/";
                    $config["total_rows"]       = count($this->acl_model->admin_menu_data());
                    $data['total_rows']         = $config["total_rows"];
                    $config["per_page"]         = 200;
                    $config["uri_segment"]      = 3;
                    $config['attributes']       = array('class' => 'pag-link');
                    $config['full_tag_open']    = "<div class='pag'>";
                    $config['full_tag_close']   = "</div>";
                    $config['first_link']       = '&lt;&lt;';
                    $config['last_link']        = '&gt;&gt;';
                    $this->pagination->initialize($config);
                    $data["links"]              = $this->pagination->create_links();
                    $data['page']               = $page = ($p1!=null) ? $p1 : 0;
                    
                    $data['menu_data'] = $this->acl_model->admin_menu_data($config["per_page"],$page);
                    $data['per_page']           = $config["per_page"];
                    $data['update_url']         = base_url().'admin-menu/create/';
                    $data['delete_url']         = base_url().'admin-menu/delete/';
                    $page                       = 'admin/acl/admin_menu/tb';    
                    $this->load->view($page, $data);
                    break;
                case 'create':
                    $data['remote']             = base_url().'remote/category/';
                    $data['action_url']         = base_url().'admin-menu/save';
                    $data['parent_menus'] = $this->master_model->get_data1('tb_admin_menu','parent','0');
                    $page                       = 'admin/acl/admin_menu/create';
                    if ($p1!=null) {
                        $data['remote']             = base_url().'remote/category/';
                        $data['action_url']     = base_url().'admin-menu/save/'.$p1;
                        $data['value']          = $this->acl_model->get_row_data1('tb_admin_menu','id',$p1);
                        $page                   = 'admin/acl/admin_menu/update';
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
                                    'icon_class'     => $this->input->post('icon_class'),
                                    'parent'     => $this->input->post('parent'),
                                    'url'     => $this->input->post('url'),
                                    'indexing'     => $this->input->post('indexing'),
                                    );
                                if($this->acl_model->edit_data('tb_admin_menu',$id,$data)){
                                    $return['res'] = 'success';
                                    $return['msg'] = 'Updated.';
                                }
                            }
                            else{
                                $data = array(
                                    'title'     => $this->input->post('title'),
                                    'icon_class'     => $this->input->post('icon_class'),
                                    'parent'     => $this->input->post('parent'),
                                    'url'     => $this->input->post('url'),
                                    'indexing'     => $this->input->post('indexing'),
                                    );
                                if ($this->acl_model->add_data('tb_admin_menu',$data)) {
                                    $return['res'] = 'success';
                                    $return['msg'] = 'Saved.';
                                }
                            }
                        }
                        echo json_encode($return);
                        break;
                        case 'delete':
                            if($this->acl_model->delete_data1('tb_admin_menu',$p1))
                            {
                                $return['res'] = 'success';
                                $return['msg'] = 'Deleted.';
                            }
                            echo json_encode($return);
                            break;
                
        }
    }
    public function users($action=null,$p1=null,$p2=null,$p3=null)
    {
        switch ($action) {
            case null:
                $data['menu_id'] = $this->uri->segment(2);
                $data['title'] = 'Users';
                $data['tb_url']         = base_url().'users/tb';
                $data['new_url']        = base_url().'users/create';
                $page = 'admin/acl/users/index';
                $this->header_and_footer($page, $data);
                break;

                case 'tb':
                    $this->load->library('pagination');
                    $config = array();
                    $config["base_url"]         = base_url()."users/tb/";
                    $config["total_rows"]       = count($this->acl_model->users_data());
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
                    $data['page']               = $page = ($p1!=null) ? $p1 : 0;
                    
                    $data['user_data'] = $this->acl_model->users_data($config["per_page"],$page);
                    $data['per_page']           = $config["per_page"];
                    $data['update_url']         = base_url().'users/create/';
                    $data['delete_url']         = base_url().'users/delete/';
                    $page                       = 'admin/acl/users/tb';    
                    $this->load->view($page, $data);
                    break;
                case 'create':
                    $data['remote']             = base_url().'acl-data/remote/users/';
                    // $data['remote']             = base_url().'acl_remote/users/';
                    $data['action_url']         = base_url().'users/save';
                    $data['user_roles'] = $this->acl_model->get_user_roles();
                    $page                       = 'admin/acl/users/create';
                    if ($p1!=null) {
                        $data['remote']             = base_url().'acl-data/remote/users/';
                        $data['action_url']     = base_url().'users/save/'.$p1;
                        $data['value']          = $this->acl_model->get_row_data('admin','id',$p1);
                        $page                   = 'admin/acl/users/update';
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
                                    'userName'     => $this->input->post('userName'),
                                    'password'     => $this->input->post('password'),
                                    'fullName'     => $this->input->post('fullName'),
                                    'contact'     => $this->input->post('contact'),
                                    'email'     => $this->input->post('email'),
                                    'role_id'     => $this->input->post('role_id'),
                                    );
                                if($this->acl_model->edit_user($id,$data)){
                                    $return['res'] = 'success';
                                    $return['msg'] = 'Updated.';
                                }
                            }
                            else{
                                $data = array(
                                    'userName'     => $this->input->post('userName'),
                                    'password'     => md5($this->input->post('password')),
                                    'fullName'     => $this->input->post('fullName'),
                                    'contact'     => $this->input->post('contact'),
                                    'email'     => $this->input->post('email'),
                                    'role_id'     => $this->input->post('role_id'),
                                    );
                                if ($this->acl_model->add_user($data)) {
                                    $return['res'] = 'success';
                                    $return['msg'] = 'Saved.';
                                }
                            }
                        }
                        echo json_encode($return);
                        break;
                        case 'delete':
                            if($this->acl_model->delete_data('admin',$p1))
                            {
                                $return['res'] = 'success';
                                $return['msg'] = 'Deleted.';
                            }
                            echo json_encode($return);
                            break;

    
                
        }
    }
    public function user_role($action=null,$p1=null,$p2=null,$p3=null)
    {
        switch ($action) {
            case null:
                $data['menu_id'] = $this->uri->segment(2);
                $data['title'] = 'User Role';
                $data['tb_url']         = base_url().'user-role/tb';
                $data['new_url']        = base_url().'user-role/create';
                $page = 'admin/acl/user_role/index';
                $this->header_and_footer($page, $data);
                break;

                case 'tb':
                    $this->load->library('pagination');
                    $config = array();
                    $config["base_url"]         = base_url()."user-role/tb/";
                    $config["total_rows"]       = count($this->acl_model->user_role_data());
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
                    $data['page']               = $page = ($p1!=null) ? $p1 : 0;
                    
                    $data['user_role_data'] = $this->acl_model->user_role_data($config["per_page"],$page);
                    $data['per_page']           = $config["per_page"];
                    $data['update_url']         = base_url().'user-role/create/';
                    $data['delete_url']         = base_url().'user-role/delete/';
                    $data['m_access_url'] =  base_url().'user-role/menu_access/';
                    $page                       = 'admin/acl/user_role/tb';    
                    $this->load->view($page, $data);
                    break;
                case 'create':
                    $data['remote']             = base_url().'acl-data/remote/user_role/';
                    $data['action_url']         = base_url().'user-role/save';
                    $page                       = 'admin/acl/user_role/create';
                    if ($p1!=null) {
                        $data['remote']             = base_url().'acl-data/remote/user_role/';
                        $data['action_url']     = base_url().'user-role/save/'.$p1;
                        $data['value']          = $this->acl_model->get_row_data('tb_user_role','id',$p1);
                        $page                   = 'admin/acl/user_role/update';
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
                                    'name'     => $this->input->post('name'),
                                    'description'     => $this->input->post('description'),
                                    );
                                if($this->acl_model->edit_data('tb_user_role',$id,$data)){
                                    $return['res'] = 'success';
                                    $return['msg'] = 'Updated.';
                                }
                            }
                            else{
                                $data = array(
                                    'name'     => $this->input->post('name'),
                                    'description'     => $this->input->post('description'),
                                    );
                                if ($this->acl_model->add_data('tb_user_role',$data)) {
                                    $return['res'] = 'success';
                                    $return['msg'] = 'Saved.';
                                }
                            }
                        }
                        echo json_encode($return);
                        break;
                        case 'delete':
                            if($this->acl_model->delete_data('tb_user_role',$p1))
                            {
                                $return['res'] = 'success';
                                $return['msg'] = 'Deleted.';
                            }
                            echo json_encode($return);
                            break;
                            case 'menu_access':
                                $return['res'] = 'error';
                                $return['msg'] = 'Not Saved!';
                                $saved = 0;
                                if ($this->input->server('REQUEST_METHOD')=='POST') {
                                    $menu_id    = $_POST['m_id'];
                                    $type   	= $_POST['type'];
                                    $role_id    = $p1;
                                    $row = $this->acl_model->getRow('tb_admin_menu',['id'=>$menu_id]);
                                    if($row){
                                        $check['role_id']   = $role_id;
                                        $check['menu_id'] 	= $menu_id;
                                        $value = 0;
                                        if ($type=='set'){
                                            $value = 1;
                                        }
                                        if ($type=='set' && $_POST['name']=='') {
                                            if($this->acl_model->getRow('tb_role_menus',$check)){
                                                if ($this->acl_model->Update('tb_role_menus',$update,$check)) {
                                                    $saved = 1;
                                                }
                                            }
                                            else{
                                                if ($this->acl_model->Save('tb_role_menus',$check)) {
                                                    $saved = 1;
                                                }
                                            }
                                        }
                                        else if($_POST['name']!=''){
                                            $update[$_POST['name']] = $value;
                                            if($this->acl_model->getRow('tb_role_menus',$check)){
                                                if ($this->acl_model->Update('tb_role_menus',$update,$check)) {
                                                    $saved = 1;
                                                }
                                            }
                                            else{
                                                $return['msg'] = 'Menu Not Assigned!';
                                            }
                                        }
                                        else{
                                            if ($this->acl_model->Delete('tb_role_menus',$check)) {
                                                $saved = 1;
                                            }
                                        }
                                    }
                                    if ($saved == 1) {
                                        $return['res'] = 'success';
                                        $return['msg'] = 'Saved.';
                                    }                
                                    echo json_encode($return);                                    
                                }
                                else{
                                    $page     = 'admin/acl/user_role/menu_access';
                                    $data['m_access_url'] =  base_url().'user-role/menu_access/';
                                    $menus   = $this->acl_model->admin_menus();
                                    $data['role_id'] = $role_id = $p1;
                                    if ($menus) {
                                        foreach ($menus as $row) {
                                            $row->checked = '';
                                            $row->c_checked = '';
                                            $row->u_checked = '';
                                            $row->d_checked = '';
                                            if ($t = $this->acl_model->getRow('tb_role_menus',['menu_id'=>$row->id,'role_id'=>$role_id])) {
                                                $row->checked = 'checked';
                                            }
                                            if (@$t->add==1) {
                                                $row->c_checked = 'checked';
                                            }
                                            if (@$t->update==1) {
                                                $row->u_checked = 'checked';
                                            }
                                            if (@$t->delete==1) {
                                                $row->d_checked = 'checked';
                                            }
                                        }
                                    }
                
                                    // $this->pr($menus);
                                    $data['menus']  = $menus;
                                    $this->load->view($page,$data);
                                }
                                break;
                

    
                
        }
    }
    public function change_menu_status()
    {
        $id = $this->input->post('id');
        $data['status_data'] = $this->acl_model->get_row_data1('tb_admin_menu','id',$id);


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
        $this->acl_model->edit_data('tb_admin_menu',$id,$data1);
        $this->load->view('admin/header_statusview',$data);
        
    }
    public function change_user_status()
    {
        $id = $this->input->post('id');
        $data['status_data'] = $this->acl_model->get_row_data1('admin','id',$id);


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
        $this->acl_model->edit_data('admin',$id,$data1);
        $this->load->view('admin/header_statusview',$data);
        
    }
    public function change_user_role_status()
    {
        $id = $this->input->post('id');
        $data['status_data'] = $this->acl_model->get_row_data1('tb_user_role','id',$id);


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
        $this->acl_model->edit_data('tb_user_role',$id,$data1);
        $this->load->view('admin/header_statusview',$data);
        
    }
   
    public function remote($type,$id=null,$column='name')
    {
        if ($type=='users') {
            $tb = 'admin';
        }
        elseif ($type=='user_role') {
            $tb ='tb_user_role';
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

}