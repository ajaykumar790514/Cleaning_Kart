<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class offers_model extends CI_Model
{
	
	//Offers model code start
    public function offers($limit=null,$start=null)
    {
        if ($limit!=null) {
            $this->db->limit($limit, $start);
        }
        $this->db
        ->select('t1.*,t2.shop_name')
        ->from('coupons_and_offers t1')       
        ->join('shops t2', 't2.id = t1.offer_created_by','left')        
        ->where(['t1.is_deleted' => 'NOT_DELETED','t1.coupan_or_offer' => '1']);
        if (@$_POST['search']) {
			$data['search'] = $_POST['search'];
			$this->db->like('t1.title', $_POST['search']);
            $this->db->where('t1.is_deleted','NOT_DELETED');
			// $this->db->or_like('t1.owner_name', $_POST['search']);
		}
        if($limit!=null)
        return $this->db->get()->result();
        else
            return $this->db->get()->num_rows();
    }
	public function add_offer_coupon($data)
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
	public function offer($id)
    {
        $query = $this->db
        ->select('t1.*,t2.shop_name,t2.business_id')
        ->from('coupons_and_offers t1')       
        ->join('shops t2', 't2.id = t1.offer_created_by','left')  
		->where(['t1.is_deleted' => 'NOT_DELETED','t1.id'=>$id])    
        ->get();
		return $query->row();
    }
	public function edit_offer_coupon($data,$id)
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
        $data1['coupon_offer'] = $this->master_model->get_row_data1('coupons_and_offers','id',$id);
        $coupon_offer_image = ltrim($data1['coupon_offer']->photo, '/');
        if(is_file(DELETE_PATH.$coupon_offer_image))
        {
            unlink(DELETE_PATH.$coupon_offer_image);
        }
        return $this->db->where('id', $id)->update('coupons_and_offers', $data); 

    }
    public function remove_offer($oid,$pid,$shop_id)
    {
        return $this->db->where(['offer_assosiated_id' => $oid,'product_id' =>$pid,'shop_id' =>$shop_id])->delete('shops_coupons_offers');
    }
    public function get_offers()
    {
        $query = $this->db
        ->select('t1.title,t2.*')
        ->from('coupons_and_offers t1')       
        ->join('shops_coupons_offers t2', 't2.offer_assosiated_id = t1.id','left')  
		->where(['t1.is_deleted' => 'NOT_DELETED'])    
        ->get();
		return $query->result();
    }
    public function fetch_offer_products($id,$shopid)
    {
        $query = $this->db
        ->select('t1.*,t1.id as prod_id,t2.img,t4.title,t4.value,t4.discount_type')
        ->from('products_subcategory t1')
        ->join('products_photo t2', 't2.item_id = t1.id')           
        ->join('shops_coupons_offers t3', 't3.product_id = t1.id','left')           
        ->join('coupons_and_offers t4', 't4.id = t3.offer_assosiated_id','left')         
        ->where(['t1.parent_cat_id' => $id,'t2.is_cover' =>'1','t1.is_deleted' =>'NOT_DELETED','t3.shop_id' => $shopid])
        ->get();
        return $query->result();
    }
    public function check_offer($oid,$pid,$shop_id)
    {
        $query = $this->db->get_where('shops_coupons_offers', ['product_id' => $pid , 'shop_id' => $shop_id]);
        // print_r($query->num_rows());
        if($query->num_rows() > 0)
        {
            return false;
        }
        else
        {
            return true;
        }
    }
    public function check_offer_cat($oid,$parent_cat_id,$shop_id)
    {
        $query = $this->db->get_where('shops_coupons_offers', ['category_id' => $parent_cat_id , 'shop_id' => $shop_id]);
        // print_r($query->num_rows());
        if($query->num_rows() > 0)
        {
            return false;
        }
        else
        {
            return true;
        }
    }
    public function remove_offer_cat($oid,$parent_cat_id,$shop_id)
    {
        return $this->db->where(['offer_assosiated_id' => $oid,'category_id' => $parent_cat_id,'shop_id' =>$shop_id])->delete('shops_coupons_offers');
    }

    public function fetch_offer_categories($pid,$shopid)
    {
        $query = $this->db
        ->select('t1.*,t1.id as prod_id,t3.title,t3.value,t3.discount_type')
        ->from('products_category t1')          
        ->join('shops_coupons_offers t2', 't2.product_id = t1.id','left')           
        ->join('coupons_and_offers t3', 't3.id = t2.offer_assosiated_id','left')         
        ->where(['t1.is_parent' => $pid,'t1.is_deleted' =>'NOT_DELETED','t2.shop_id' => $shopid])
        ->get();
        return $query->result();
    }

    public function delete_offer_products($data)
    {
        return $this->db->where(['shop_id' => $data['shop_id'],'product_id' => $data['product_id']])->delete('shops_coupons_offers');
    }










}
?>