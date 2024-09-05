<?php
defined('BASEPATH') OR exit('No direct script access allowed');

#[\AllowDynamicProperties]
class business_model extends CI_Model
{
	function index(){
		echo 'This is model index function';
	}
	function __construct(){
		$this->tbl1 = 'business';
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



	//Business model code start
    public function businesses($city_id,$limit=null,$start=null)
    {
        if ($limit!=null) {
            $this->db->limit($limit, $start);
        }
        $this->db
        ->select('t1.*,t2.name as state_name,t3.name as city_name')
        ->from('business t1')
        ->join('states t2', 't2.id = t1.state','left')        
        ->join('cities t3', 't3.id = t1.city','left')        
        ->where(['t1.is_deleted' => 'NOT_DELETED']);
        if (@$_POST['search']) {
			$this->db->like('t1.title', $_POST['search']);
			$this->db->or_like('t1.owner_name', $_POST['search']);
		}
        if ($city_id!='null') {
			$this->db->where('t3.id',$city_id);
		}
		return $this->db->get()->result();
    }
	public function add_business($data)
    {
		$config['file_name'] = rand(10000, 10000000000);
        $config['upload_path'] = UPLOAD_PATH.'business_photo/';
        $config['allowed_types'] = 'jpg|jpeg|png|gif|pdf';
        $this->load->library('upload', $config);
        $this->upload->initialize($config);

        if (!empty($_FILES['pic']['name'])) {
            //upload images
            $_FILES['pics']['name'] = $_FILES['pic']['name'];
            $_FILES['pics']['type'] = $_FILES['pic']['type'];
            $_FILES['pics']['tmp_name'] = $_FILES['pic']['tmp_name'];
            $_FILES['pics']['size'] = $_FILES['pic']['size'];
            $_FILES['pics']['error'] = $_FILES['pic']['error'];

            if ($this->upload->do_upload('pics')) {
                $image_data = $this->upload->data();
                $fileName = "business_photo/" . $image_data['file_name'];
            }
            $data['pic'] = $fileName;
        } else {
            $data['pic'] = "";
        }
        return $this->db->insert('business', $data);

    }
	public function business($id)
    {
        $query = $this->db
        ->select('t1.*,t2.name as state_name,t3.name as city_name')
        ->from('business t1')
        ->join('states t2', 't2.id = t1.state')        
        ->join('cities t3', 't3.id = t1.city')    
		->where(['t1.is_deleted' => 'NOT_DELETED','t1.id'=>$id])    
        ->get();
		return $query->row();
    }
	public function edit_business($data,$id)
    {
		$config['file_name'] = rand(10000, 10000000000);
        $config['upload_path'] = UPLOAD_PATH.'business_photo/';
        $config['allowed_types'] = 'jpg|jpeg|png|gif|pdf';
        $this->load->library('upload', $config);
        $this->upload->initialize($config);

        if (!empty($_FILES['pic']['name'])) {
            //upload images
            $_FILES['pics']['name'] = $_FILES['pic']['name'];
            $_FILES['pics']['type'] = $_FILES['pic']['type'];
            $_FILES['pics']['tmp_name'] = $_FILES['pic']['tmp_name'];
            $_FILES['pics']['size'] = $_FILES['pic']['size'];
            $_FILES['pics']['error'] = $_FILES['pic']['error'];

            if ($this->upload->do_upload('pics')) {
                $image_data = $this->upload->data();
                $fileName = "business_photo/" . $image_data['file_name'];
            }
            $data['pic'] = $fileName;
        } 
        return $this->db->where('id', $id)->update('business', $data); 

    }

    //SHOPS

    public function shops($city_id,$business_id,$limit=null,$start=null)
    {
        if ($limit!=null) {
            $this->db->limit($limit, $start);
        }
        
        $this->db
        ->select('t1.*,t2.name as state_name,t3.name as city_name,t4.name as shop_cat_name')
        ->from('shops t1')
        ->join('states t2', 't2.id = t1.state','left')        
        ->join('cities t3', 't3.id = t1.city','left')        
        ->join('shop_category t4', 't4.id = t1.shop_category_id ','left')      
        ->join('business t5', 't5.id = t1.business_id ','left')   
        ->where(['t1.is_deleted' => 'NOT_DELETED']);
        if (@$_POST['search']) {
			$data['search'] = $_POST['search'];
			$this->db->like('t1.shop_name', $_POST['search']);
            $this->db->where('t1.is_deleted','NOT_DELETED');
			//$this->db->or_like('products_subcategory.name', $_POST['search']);
		}
        if ($city_id!='null') {
			$this->db->where('t3.id',$city_id);
		}
        if ($business_id!='null') {
			$this->db->where('t5.id',$business_id);
		}
		return $this->db->get()->result();
    }
    public function shop($id)
    {
        $query = $this->db
        ->select('t1.*,t2.name as state_name,t3.name as city_name,t4.name as shop_cat_name,t5.id as business_id')
        ->from('shops t1')
        ->join('states t2', 't2.id = t1.state','left')        
        ->join('cities t3', 't3.id = t1.city','left')        
        ->join('shop_category t4', 't4.id = t1.shop_category_id ','left') 
        ->join('business t5', 't5.id = t1.business_id ','left') 
		->where(['t1.is_deleted' => 'NOT_DELETED','t1.id'=>$id])    
        ->get();
		return $query->row();
    }
    public function add_shop($data,$shop_category_ids)
    {
        //code for inserting shop logo
        $config['file_name'] = rand(10000, 10000000000);
        $config['upload_path'] = UPLOAD_PATH.'shop_photo/';
        $config['allowed_types'] = 'jpg|jpeg|png|gif|pdf';
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
        } else {
            $data['logo'] = "";
        }
        //end code for inserting shop logo
        $imageCount = count($_FILES['photo']['name']);
        if (!empty($imageCount)) {
            for ($i = 0; $i < $imageCount; $i++) {
                $config['file_name'] = date('Ymd') . rand(1000, 1000000);
                $config['upload_path'] = UPLOAD_PATH.'shop_photo/';
                $config['allowed_types'] = 'jpg|jpeg|png|gif';
                $this->load->library('upload', $config);
                $this->upload->initialize($config);
                $_FILES['photos']['name'] = $_FILES['photo']['name'][$i];
                $_FILES['photos']['type'] = $_FILES['photo']['type'][$i];
                $_FILES['photos']['tmp_name'] = $_FILES['photo']['tmp_name'][$i];
                $_FILES['photos']['size'] = $_FILES['photo']['size'][$i];
                $_FILES['photos']['error'] = $_FILES['photo']['error'][$i];

                if ($this->upload->do_upload('photos')) {
                    $imageData = $this->upload->data();
                    $images[] = "shop_photo/" . $imageData['file_name'];
                }
            }
        }

        if (!empty($images))
        {    
            $this->db->insert('shops', $data);
            $insert_id = $this->db->insert_id();
            if (!empty($shop_category_ids))
            {     
                foreach ($shop_category_ids as $cids) {
                        $deals_data = array(
                            'cat_id' => $cids,
                            'shop_id' => $insert_id
                        );
                        $this->db->insert('shops_deals_in_category', $deals_data);
                    }
            }
            foreach ($images as $file) {
                    $file_data = array(
                        'image' => $file,
                        'shop_id' => $insert_id
                    );
                    $this->db->insert('shops_photo', $file_data);
                }
            $cover_image = $images[0];
            $cover_image_data = array(
                    'is_cover' => 1
                );
              $query=  $this->db->where('image', $cover_image)->update('shops_photo', $cover_image_data);
        }

        if ($insert_id) {
            return $insert_id;
        } else {
            return false;
        }
        // return $this->db->insert('shops', $data);

    }
    public function edit_shop($id,$data,$shop_category_input)
    {
        //code for updating shop logo
        $config['file_name'] = rand(10000, 10000000000);
        $config['upload_path'] = UPLOAD_PATH.'shop_photo/';
        $config['allowed_types'] = 'jpg|jpeg|png|gif|pdf';
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
            if (!empty($fileName)) 
            {
                $data2 = $this->db->get_where('shops', ['id' =>$id])->row();
                if (!empty($data2->logo))
                {
                    if(DELETE_PATH.is_file($data2->logo))
                    {
                        unlink(DELETE_PATH.$data2->logo);
                    }
                }
                $data['logo'] = $fileName;
            } 
        } 
        //end code for updating shop logo
        //code for updating shop categories in shop_deals table
        $all_cat  = $this->master_model->get_data1('shops_deals_in_category','shop_id',$id);

        $all_shop_cat = [];
        foreach ($all_cat as $cat) {
            $all_shop_cat[] = $cat->cat_id;
        }

        if (!empty($shop_category_input))
        {     
            //Insert newly added categories
            foreach ($shop_category_input as $cids) 
            {
                if(!in_array($cids,$all_shop_cat))
                {
                    $deals_data = array(
                        'cat_id' => $cids,
                        'shop_id' => $id
                    );
                    $this->db->insert('shops_deals_in_category', $deals_data);
                }
            }
            //Delete added categories
            foreach ($all_shop_cat as $scat) 
            {
                if(!in_array($scat,$shop_category_input))
                {
                    $delete_data = array(
                        'cat_id' => $scat,
                        'shop_id' => $id
                    );
                    $this->db->delete('shops_deals_in_category',$delete_data);
                }
            }
        }

        return $this->db->where('id', $id)->update('shops', $data); 

    }

    //deleted shop image
    public function delete_shop_image($id){
        $data1['shop_images'] = $this->master_model->get_row_data1('shops_photo','id',$id);
        if(is_file(DELETE_PATH.$data1['shop_images']->image))
        {
            unlink(DELETE_PATH.$data1['shop_images']->image);
        }
        return $this->db->where('id', $id)->delete('shops_photo');
    }
    public function remove_shop_cover($p1){
        $change_cover = array('is_cover' => '0');
        return $this->db->where('shop_id', $p1)->update('shops_photo', $change_cover);
	}
	public function make_shop_cover($id){
        $is_cover = array('is_cover' => '1');
		return $this->db->where('id', $id)->update('shops_photo', $is_cover);
	}








}
?>