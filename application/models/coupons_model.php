<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class coupons_model extends CI_Model
{
	
    public function coupons($limit=null,$start=null)
    {
        if ($limit!=null) {
            $this->db->limit($limit, $start);
        }
        $this->db
        ->select('t1.*,t2.shop_name')
        ->from('coupons_and_offers t1')       
        ->join('shops t2', 't2.id = t1.offer_created_by','left')        
        ->where(['t1.is_deleted' => 'NOT_DELETED','t1.coupan_or_offer' => '0']);
        if (@$_POST['search']) {
            $this->db->group_start();
			$this->db->like('t1.title', $_POST['search']);
			$this->db->or_like('t1.code', $_POST['search']);
            $this->db->group_end();
		}
        if($limit!=null)
            return $this->db->get()->result();
        else
            return $this->db->get()->num_rows();
    }
	public function add_coupon($data)
    {
		$config['file_name'] = rand(10000, 10000000000);
        $config['upload_path'] = UPLOAD_PATH.'offers/';
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
                $fileName = "offers/" . $image_data['file_name'];
            }
            $data['photo'] = $fileName;
        } else {
            $data['photo'] = "";
        }
        return $this->db->insert('coupons_and_offers', $data);

    }
    public function coupon($id)
    {
        $query = $this->db
        ->select('t1.*,t2.shop_name,t2.business_id')
        ->from('coupons_and_offers t1')       
        ->join('shops t2', 't2.id = t1.offer_created_by','left')  
		->where(['t1.is_deleted' => 'NOT_DELETED','t1.id'=>$id])    
        ->get();
		return $query->row();
    }
    public function edit_coupon($data,$id)
    {
		$config['file_name'] = rand(10000, 10000000000);
        $config['upload_path'] = UPLOAD_PATH.'offers/';
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
                $fileName = "offers/" . $image_data['file_name'];
            }
            $data['photo'] = $fileName;
        } 
        return $this->db->where('id', $id)->update('coupons_and_offers', $data); 

    }


}
?>