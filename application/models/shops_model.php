<?php
defined('BASEPATH') OR exit('No direct script access allowed');

#[\AllowDynamicProperties]
class shops_model extends CI_Model
{
	function index(){
		echo 'This is model index function';
	}
	function __construct(){
		$this->tbl1 = 'shops';
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

    public function edit_shop_profile($data,$id)
    {

        $config['file_name'] = rand(10000, 10000000000);
        $config['upload_path'] = UPLOAD_PATH.'shop_photo/';
        $config['allowed_types'] = 'jpg|jpeg|png|gif';
        $this->load->library('upload', $config);
        $this->upload->initialize($config);

        if (!empty($_FILES['logo']['name'])) {
            //upload images
            $_FILES['logos']['name'] = $_FILES['logo']['name'];
            $_FILES['logos']['type'] = $_FILES['logo']['type'];
            $_FILES['logos']['tmp_name'] = $_FILES['logo']['tmp_name'];
            $_FILES['logos']['size'] = $_FILES['logo']['size'];
            $_FILES['logos']['error'] = $_FILES['logo']['error'];
			
            if ($this->upload->do_upload('logos')) {
				
                $image_data = $this->upload->data();
                $fileName = "shop_photo/" . $image_data['file_name'];
            }

			$data['logo'] = $fileName;
            if (!empty($fileName)) 
            {
				$data2 = $this->db->get_where('shops', ['id' =>$id])->row();
                if (!empty($data2->logo))
                {
					if(is_file(DELETE_PATH.$data2->logo))
					{
						unlink(DELETE_PATH.$data2->logo);
					}
                }
            } 
			// die();
            
        }

        		return $this->db->where('id', $id)->update('shops', $data); 

    }

	public function get_shop_data($shop_id)
	{
		// $query = $this->db->get_where('shops', ['id' => $shop_id]);
		// return $query->row();
		$query = $this->db
        ->select('t1.*,t2.image,t2.id as img_id,t3.*,t3.id as layout_id')
        ->from('shops t1')
        ->join('shops_photo t2', 't2.shop_id = t1.id AND t2.is_cover = 1')        
        ->join('layout_settings t3', 't3.shop_id = t1.id','left')        
        ->where(['t1.is_deleted' => 'NOT_DELETED','t1.id' => $shop_id])
        ->get();
		return $query->row();
	}
	public function shop_social($shop_id)
	{
		$query = $this->db
		->select('t1.*,t2.shop_name,t2.business_id')
		->from('shop_social t1')
		->join('shops t2', 't2.id = t1.shop_id')        
		->where(['t1.is_deleted' => 'NOT_DELETED','t1.shop_id' => $shop_id])
		->get();
		return $query->result();
	}

	public function shop_bank_accounts($shop_id)
	{
		$query = $this->db
		->select('t1.*')
		->from('shop_bank_accounts t1')      
		->where(['t1.shop_id' => $shop_id])
		->get();
		return $query->result();
	}

	public function shop_cash_account($shop_id)
	{
		return $this->db->get_where('shop_cash_account',['shop_id' => $shop_id])->row();
	}

	public function save_cash_account($shop_id)
	{
		$p = $this->input->post();
		$this->db->where('shop_id',$shop_id);
		return $this->db->update('shop_cash_account',['dr_cr'=>$p['dr_cr'],'amount'=>$p['amount'],'remark'=>$p['remark']]);
	}
	//shop login
	public function shop_login($contact, $password) { 
		$this->db->where('contact', $contact);
		$this->db->where('password', $password);
		$query = $this->db->get('shops');
		if($query->num_rows()==1){
			return TRUE;
		}
		else{
			return FALSE;
		}    
	}
	public function check_old_password($old_pass,$shop_id)
	{
		$query = $this->db->where(['id' => $shop_id ,'password' =>$old_pass])->get('shops');
		if($query->num_rows() > 0)
        {
            return true;
        }
        else
        {
            return false;
        }
	}

}
?>