<?php
defined('BASEPATH') OR exit('No direct script access allowed');

#[\AllowDynamicProperties]
class admin_model extends CI_Model
{
	function index(){
		echo 'This is model index function';
	}
	function __construct(){
		$this->tbl1 = 'admin';
		$this->load->database();
	}
	function getRows($data = array()){
		$this->db->select("*");
		$this->db->from($this->tbl1);
		if (array_key_exists("conditions", $data)) {
			foreach ($data['conditions'] as $key => $value) {
				$this->db->where($key,$value);
			}
		}
		$query = $this->db->get();
		$result = ($query->num_rows() > 0)?$query->result_array():FALSE;
		return $result;
	}
	function insertRow($data = array()){
		$result = $this->db->insert($this->tbl1,$data);
		return $result;
	}
	function updateRow($id,$data = array()){
		$this->db->where($this->tbl1.'.'.'id',$id);
		$result = $this->db->update($this->tbl1,$data);
		return $result;
	}
	function deleteRow($id){
		$this->db->where($this->tbl1.'.'.'id',$id);
		$result = $this->db->delete($this->tbl1);
		return $result;
	}

	//admin login

	public function admin_login($username, $password) { 
        $this->db->where('userName', $username);
        $this->db->where('password', $password);
        $this->db->where('status', '1');
        $query = $this->db->get('admin');
        if($query->num_rows()==1){
            foreach ($query->result() as $row){
                $data = array(
                            'user_id'=> $row->id,
                            'userName'=> $row->userName,
                            'admin_role_id'=> $row->role_id,
                            'logged_in'=>TRUE,
                            'admin_logged_in'=>TRUE
                        );
            }
            $this->session->set_userdata($data);
            return TRUE;
        }
        else{
            return FALSE;
      }    
    }
        
    public function isLoggedIn(){
            $is_logged_in = $this->session->userdata('logged_in');
            if(!isset($is_logged_in) || $is_logged_in!==TRUE)
            {
                redirect('admin-dashboard');
                exit;
            }
    } 
	//is admin
    public function is_admin()
    {
        //check logged in
        if (!$this->isLoggedIn()) {
            echo "false";exit;
        }
        else
        {
            echo "true";exit;
        }
    }
    public function edit_admin_profile($data,$id)
    {
        $config['file_name'] = rand(10000, 10000000000);
        $config['upload_path'] = UPLOAD_PATH.'admin/';
        $config['allowed_types'] = 'jpg|jpeg|png|gif|pdf';
        $this->load->library('upload', $config);
        $this->upload->initialize($config);

        if (!empty($_FILES['photo']['name'])) {
            //upload images
            $_FILES['photos']['name'] = $_FILES['photo']['name'];
            $_FILES['photos']['type'] = $_FILES['photo']['type'];
            $_FILES['photos']['tmp_name'] = $_FILES['photo']['tmp_name'];
            $_FILES['photos']['size'] = $_FILES['photo']['size'];
            $_FILES['photos']['error'] = $_FILES['photo']['error'];

            if ($this->upload->do_upload('photos')) {
                $image_data = $this->upload->data();
                $fileName = "admin/" . $image_data['file_name'];
            }

            if (!empty($fileName)) 
            {
                $data2 = $this->db->get_where('admin', ['id' =>$id])->row();
                $path = $data2->photo;
                if(is_file(DELETE_PATH.$path))
                {
                    unlink(DELETE_PATH.$path);
                }
                $data['photo'] = $fileName;
            } 
        }
        
        return $this->db->where('id', $id)->update('admin', $data); 
    }
	public function admin_logout()
    {
        //unset user data
        // $this->session->unset_userdata('logged_in');
        $this->session->unset_userdata(array('userName','admin_logged_in','logged_in','admin_role_id'));
        $this->session->sess_destroy();
    }
    

	public function check_old_password($old_pass)
	{
		$query = $this->db->where(['id' => '1' ,'password' =>$old_pass])->get('admin');
		if($query->num_rows() > 0)
        {
            return true;
        }
        else
        {
            return false;
        }
	}
    public function get_role_menu_data($role_id)
    {
        $this->db
        ->select('t1.*,t2.menu_id')
        ->from('tb_admin_menu t1')
        ->join('tb_role_menus t2', 't2.menu_id = t1.id')
        ->where('t2.role_id',$role_id)
        ->where('t1.parent','0')
        ->order_by('t1.indexing','asc');
        return $this->db->get()->result();
    }
    public function all_role_menu_data($role_id)
    {
        $this->db
        ->select('t1.*,t2.menu_id')
        ->from('tb_admin_menu t1')
        ->join('tb_role_menus t2', 't2.menu_id = t1.id')
        ->where('t2.role_id',$role_id)
        ->order_by('t1.indexing','asc');
        return $this->db->get()->result();
    }

    public function get_menu_data($menu_id)
    {
        return $this->db->get_where('tb_admin_menu',['id'=>$menu_id])->row();
    }


    public function get_submenu_data($menu_id,$role_id)
    {
        $this->db
        ->select('t1.*')
        ->from('tb_admin_menu t1')
        ->join('tb_role_menus t2', 't2.menu_id = t1.id')
        ->where('t2.role_id',$role_id)
        ->where('t1.parent',$menu_id)
        ->order_by('indexing','ASC');
        return $this->db->get()->result();
    }
    // public function get_submenu_data($menu_id)
    // {
    //     $this->db
    //     ->select('t1.*')
    //     ->from('tb_admin_menu t1')
    //     // ->join('tb_role_menus t2', 't2.menu_id = t1.id')
    //     // ->where('t2.role_id',$role_id)
    //     ->where('t1.parent',$menu_id);
    //     return $this->db->get()->result();
    // }

}
?>