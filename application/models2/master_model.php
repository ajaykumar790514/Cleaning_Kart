<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class master_model extends CI_Model
{
    //Category
    public function add_category($data)
    {
        $config['file_name'] = rand(10000, 10000000000);
        $config['upload_path'] = UPLOAD_PATH.'category/';
        $config['allowed_types'] = 'jpg|jpeg|png|gif|pdf';
        $this->load->library('upload', $config);
        $this->upload->initialize($config);

        if (!empty($_FILES['icon']['name'])) {
            // $fileinfo = @getimagesize($_FILES["icon"]["tmp_name"]);
            // $width = $fileinfo[0];
            // $height = $fileinfo[1];

            //upload images
            $_FILES['icons']['name'] = $_FILES['icon']['name'];
            $_FILES['icons']['type'] = $_FILES['icon']['type'];
            $_FILES['icons']['tmp_name'] = $_FILES['icon']['tmp_name'];
            $_FILES['icons']['size'] = $_FILES['icon']['size'];
            $_FILES['icons']['error'] = $_FILES['icon']['error'];

            if ($this->upload->do_upload('icons')) {
                $image_data = $this->upload->data();
                $config2 = array(
                    'image_library' => 'gd2', //get original image
                    'source_image' =>   UPLOAD_PATH.'category/'. $image_data['file_name'],
                    'width' => 640,
                    'height' => 360,
                    'new_image' =>  UPLOAD_PATH.'category/thumbnail/'. $image_data['file_name'],

                );
                $this->load->library('image_lib');
                $this->image_lib->initialize($config2);
                $this->image_lib->resize();
                $this->image_lib->clear();

                $fileName = "category/" . $image_data['file_name'];
                $fileName2 = "category/thumbnail/" . $image_data['file_name'];
            }
            $data['icon'] = $fileName;
            $data['thumbnail'] = $fileName2;
        } else {
            $data['icon'] = "";
        }
        if (!empty($fileName))
        {  
            return $this->db->insert('products_category', $data);
        }
    }
    public function edit_category($data,$id)
    {
        $config['file_name'] = rand(10000, 10000000000);
        $config['upload_path'] = UPLOAD_PATH.'category/';
        $config['allowed_types'] = 'jpg|jpeg|png|gif|pdf';
        $this->load->library('upload', $config);
        $this->upload->initialize($config);

        if (!empty($_FILES['icon']['name'])) {
            //upload images
            $_FILES['icons']['name'] = $_FILES['icon']['name'];
            $_FILES['icons']['type'] = $_FILES['icon']['type'];
            $_FILES['icons']['tmp_name'] = $_FILES['icon']['tmp_name'];
            $_FILES['icons']['size'] = $_FILES['icon']['size'];
            $_FILES['icons']['error'] = $_FILES['icon']['error'];

            if ($this->upload->do_upload('icons')) {
                $image_data = $this->upload->data();
                $config2 = array(
                    'image_library' => 'gd2', //get original image
                    'source_image' =>   UPLOAD_PATH.'category/'. $image_data['file_name'],
                    'width' => 640,
                    'height' => 360,
                    'new_image' =>  UPLOAD_PATH.'category/thumbnail/'. $image_data['file_name'],

                );
                $this->load->library('image_lib');
                $this->image_lib->initialize($config2);
                $this->image_lib->resize();
                $this->image_lib->clear();
                $fileName = "category/" . $image_data['file_name'];
                $fileName2 = "category/thumbnail/" . $image_data['file_name'];
            }
            $data['icon'] = $fileName;
            $data['thumbnail'] = $fileName2;
            

            if (!empty($fileName) && !empty($fileName2))    
            {
                $data1['cat_images'] = $this->master_model->get_row_data1('products_category','id',$id);
                $cat_image = ltrim($data1['cat_images']->icon, '/');
                $cat_thumb = ltrim($data1['cat_images']->thumbnail, '/');
                if(is_file(DELETE_PATH.$cat_image))
                {
                    unlink(DELETE_PATH.$cat_image);
                }
                if(is_file(DELETE_PATH.$cat_thumb))
                {
                    unlink(DELETE_PATH.$cat_thumb); 
                }
            }
        }

            return $this->db->where('id', $id)->update('products_category', $data); 

        
    }

    //Product
	public function get_parent_category()
	{
		$query = $this->db->get_where('products_category', ['is_deleted' => 'NOT_DELETED', 'is_parent' => '0', 'active' => '1']);
		return $query->result();
	}
    public function add_product($data)
    {
        $imageCount = count($_FILES['img']['name']);
        if (!empty($imageCount)) {
            for ($i = 0; $i < $imageCount; $i++) {
                $config['file_name'] = date('Ymd') . rand(1000, 1000000);
                $config['upload_path'] = UPLOAD_PATH.'product/';
                $config['allowed_types'] = 'jpg|jpeg|png|gif';
                $this->load->library('upload', $config);
                $this->upload->initialize($config);
                $_FILES['imgs']['name'] = $_FILES['img']['name'][$i];
                $_FILES['imgs']['type'] = $_FILES['img']['type'][$i];
                $_FILES['imgs']['tmp_name'] = $_FILES['img']['tmp_name'][$i];
                $_FILES['imgs']['size'] = $_FILES['img']['size'][$i];
                $_FILES['imgs']['error'] = $_FILES['img']['error'][$i];
                // $fileinfo = @getimagesize($_FILES["img"]["tmp_name"][$i]);
                // $width = $fileinfo[0];
                // $height = $fileinfo[1];
                // if ($width > "300" || $height > "200") {
                
                //         $return['res'] = 'error';
                //         $return['msg'] = 'Image dimension should be within 300X200';
                  
                // }
                if ($this->upload->do_upload('imgs')) {
                    $imageData = $this->upload->data();
                    $config2 = array(
                        'image_library' => 'gd2', //get original image
                        'source_image' =>   UPLOAD_PATH.'product/'. $imageData['file_name'],
                        'width' => 640,
                        'height' => 360,
                        'new_image' =>  UPLOAD_PATH.'product/thumbnail/'. $imageData['file_name'],
                    );
                    $this->load->library('image_lib');
                    $this->image_lib->initialize($config2);
                    $this->image_lib->resize();
                    $this->image_lib->clear();

                    $images[] = "product/" . $imageData['file_name'];
                    $images2[] = "product/thumbnail/" . $imageData['file_name'];
                }
            }
        }

        //application upload code
        $config['file_name'] = rand(10000, 10000000000);    
        $config['upload_path'] = UPLOAD_PATH.'product/';
        $config['allowed_types'] = 'jpg|jpeg|png|gif';
        $this->load->library('upload', $config);
        $this->upload->initialize($config);

        if (!empty($_FILES['application']['name'])) {

            //upload images
            $_FILES['applications']['name'] = $_FILES['application']['name'];
            $_FILES['applications']['type'] = $_FILES['application']['type'];
            $_FILES['applications']['tmp_name'] = $_FILES['application']['tmp_name'];
            $_FILES['applications']['size'] = $_FILES['application']['size'];
            $_FILES['applications']['error'] = $_FILES['application']['error'];

            if ($this->upload->do_upload('applications')) {
                $image_data = $this->upload->data();
             
                $fileName = "product/" . $image_data['file_name'];
            }
            $data['application'] = $fileName;
        } else {
            $data['application'] = "";
        }
        // end application upload code

        if (!empty($images))
        {     
            $this->db->insert('products_subcategory', $data);
            $insert_id = $this->db->insert_id();
            foreach (array_combine($images, $images2) as $file => $file2) {
                    $file_data = array(
                        'img' => $file,
                        'thumbnail' => $file2,
                        'item_id' => $insert_id
                    );
                    $this->db->insert('products_photo', $file_data);
                }
            $cover_image = $images[0];
            $cover_image_data = array(
                    'is_cover' => 1
                );
              $query=  $this->db->where('img', $cover_image)->update('products_photo', $cover_image_data);

              //sitemap code
                $product_data          = $this->master_model->product($insert_id);
                $url = base_url('product-detail/').$insert_id."/".$product_data->parent_cat_id."/".$product_data->is_parent;
                $users = simplexml_load_file(SITEMAP_URL);
                $user = $users->addChild('url');
                $user->addChild('id', $insert_id);
                $user->addChild('loc', $url);
                $user->addChild('lastmod', date('Y-m-d'));
                $user->addChild('priority', '1.0');
                $dom = new DomDocument();
                $dom->preserveWhiteSpace = false;
                $dom->formatOutput = true;
                $dom->loadXML($users->asXML());
                $dom->save(SITEMAP_URL);
                //end sitemap code
        }

        if ($insert_id) {
            return $insert_id;
        } else {
            return false;
        }
    }


    public function products($parent_id,$cat_id,$child_cat_id,$search,$limit=null,$start=null)
    {
        if ($limit!=null) {
            $this->db->limit($limit, $start);
        }
        $this->db
        ->select('t1.*,t2.img,t2.thumbnail,t2.is_cover,t2.id as cover_id')
        ->from('products_subcategory t1')
        ->join('products_photo t2', 't2.item_id = t1.id')        
        ->where(['t1.is_deleted' => 'NOT_DELETED','t2.is_cover' => '1'])
        ->order_by('t1.added','desc');
        if ($search != 'null'  && $cat_id =='null' || $search != 'null') {
            $this->db->group_start();
			$this->db->like('t1.name', $search);
            $this->db->or_like('t1.product_code', $search);
            $this->db->group_end();
		}
        if ($child_cat_id!='null') {
			$this->db->where('t1.sub_cat_id',$child_cat_id);
		}
        if ($cat_id!='null') {
			$this->db->where('t1.parent_cat_id',$cat_id);
            $this->db->where('t1.is_deleted','NOT_DELETED');
            $this->db->where('t2.is_cover','1');    
		}
		if($limit!=null)
            return $this->db->get()->result();
        else
            return $this->db->get()->num_rows();
    }


    public function product($id)
    {
        $query = $this->db
        ->select('t1.*,t1.parent_cat_id,t2.id as cat_id,t2.name as cat_name,t2.is_parent,t3.id as main_cat_id,t3.name as main_cat_name,t3.is_parent as main_is_parent')
        ->from('products_subcategory t1')
        ->join('products_category t2', 't2.id = t1.parent_cat_id','left')        
        ->join('products_category t3', 't3.id = t1.sub_cat_id','left')        
        ->where(['t1.is_deleted' => 'NOT_DELETED','t1.id'=>$id])
        ->get();
		return $query->row();
        // return $this->db->get_where('products_subcategory',['id'=>$id])->row();
    }

    public function product_img($id)
    {
        return $this->db->get_where('products_photo',['item_id'=>$id])->result();
    }

    public function product_img_upload($id)
    {
        $imageCount = count($_FILES['img']['name']);
        if (!empty($imageCount)) {
            for ($i = 0; $i < $imageCount; $i++) {
                $config['file_name'] = date('Ymd') . rand(1000, 1000000);
                $config['upload_path'] = UPLOAD_PATH.'product/';
                $config['allowed_types'] = 'jpg|jpeg|png|gif|pdf|xlsx|xls|csv';
                $this->load->library('upload', $config);
                $this->upload->initialize($config);
                $_FILES['imgs']['name'] = $_FILES['img']['name'][$i];
                $_FILES['imgs']['type'] = $_FILES['img']['type'][$i];
                $_FILES['imgs']['tmp_name'] = $_FILES['img']['tmp_name'][$i];
                $_FILES['imgs']['size'] = $_FILES['img']['size'][$i];
                $_FILES['imgs']['error'] = $_FILES['img']['error'][$i];

                if ($this->upload->do_upload('imgs')) {
                    $imageData = $this->upload->data();
                    $images[] = "product/" . $imageData['file_name'];
                }
            }
        }

        if ($images != '') {            
            foreach ($images as $file) {
                $file_data = array(
                    'img' => $file,
                    'item_id' => $id
                );
                $this->db->insert('products_photo', $file_data);
            }
            $cover_image = $images[0];
            $cover_image_data = array(
                    'is_cover' => 1
                );
              $query=  $this->db->where('img', $cover_image)->update('products_photo', $cover_image_data);
        }



    }
    

    public function fetch_shop($bid)
    {
        $data = $this->db->get_where('shops',['business_id' => $bid , 'is_deleted' => 'NOT_DELETED'])->result();
        echo "<option value=''>Select Shop</option>";
        foreach($data as $val)
        {
            echo "<option value='" . $val->id . "'>" . $val->shop_name . "</option>";
        }
    }
    public function view_pincodes_criteria()
	{
		$query = $this->db
        ->select('t1.*,t2.shop_name,t2.business_id')
        ->from('pincodes_criteria t1')
        ->join('shops t2', 't2.id = t1.shop_id')        
        ->where(['t1.is_deleted' => 'NOT_DELETED'])
        ->get();
		return $query->result();
	}
    public function fetch_slot($day,$shop_id)
    {
        return $this->db->get_where('booking_slots',['day' => $day,'shop_id' => $shop_id])->result();
       
    }
    public function get_booking_slots()
	{
		$query = $this->db
        ->select('t1.*,t2.shop_name,t2.business_id')
        ->from('booking_slots t1')
        ->join('shops t2', 't2.id = t1.shop_id')        
        ->where(['t1.is_deleted' => 'NOT_DELETED'])
        ->order_by('day','desc')
        ->get();
		return $query->result();
	}
    
	public function delete_booking_slot($id)
	{
		return $this->db->where('id', $id)->delete('booking_slots');
	}

    public function fetch_city($sid)
    {
        $data = $this->db->get_where('cities',['state_id' => $sid , 'is_deleted' => 'NOT_DELETED'])->result();
        echo "<option value=''>Select City</option>";
        foreach($data as $val)
        {
            echo "<option value='" . $val->id . "'>" . $val->name . "</option>";
        }
    }
    //fetch business by city id
    public function fetch_business($cid)
    {
        $data = $this->db->get_where('business',['city' => $cid , 'is_deleted' => 'NOT_DELETED'])->result();
        echo "<option value=''>Select Business</option>";
        foreach($data as $val)
        {
            echo "<option value='" . $val->id . "'>" . $val->title . "</option>";
        }
    }
    	//edit society 
	public function edit_society($id, $data)
	{
		return $this->db->where('socity_id ', $id)->update('society_master', $data);
	}
    	//deleted society
	public function delete_society($id)
	{
		$is_deleted = array('is_deleted' => 'DELETED');
		return $this->db->where('socity_id', $id)->update('society_master', $is_deleted);
	}
    	//deleted data
	public function delete_pincodes_criteria($id)
	{
		return $this->db->where('id', $id)->delete('pincodes_criteria');
	}
    public function get_categories($parent_id,$cat_id)
	{
		$this->db->order_by('seq','asc')->where(['is_deleted' => 'NOT_DELETED']);
        if ($cat_id!=='null') {
            $this->db->group_start();
			$this->db->like('id', $cat_id);
			$this->db->or_like('is_parent', $cat_id);
            $this->db->where('is_deleted','NOT_DELETED');
            $this->db->group_end();
            
		}
		return $this->db->get('products_category')->result();
	}
    public function get_cat()
	{
		$this->db->order_by('seq','asc')->where(['is_deleted' => 'NOT_DELETED']);

		return $this->db->get('products_category')->result();
	}
    	//get parent categories
	// public function get_parent_cat($limit=null,$start=null)
	// {
    //     if ($limit!=null) {
    //         $this->db->limit($limit, $start);
    //     }
	// 	$this->db->order_by('seq','asc')->where(['is_deleted' => 'NOT_DELETED', 'is_parent' => '0']);
	// 	return $this->db->get('products_category')->result();
	// }
    public function category($id)
    {
        $query = $this->db
        ->select('t1.*,t2.id as subcat_id,t2.name as subcat_name,t2.is_parent as subcat_is_parent')
        ->from('products_category t1')
        ->join('products_category t2', 't1.is_parent = t2.id AND t2.is_parent!=0','left')        
        ->where(['t1.is_deleted' => 'NOT_DELETED','t1.id'=>$id])
        ->get();
		return $query->row();
        // return $this->db->get_where('products_category',['id'=>$id])->row();
    }
	//edit data 
	public function change_society_status($socity_id,$data1)
	{
		return $this->db->where('socity_id', $socity_id)->update('society_master', $data1);
	}
    	//view unit master
	public function view_unit_master()
	{
		$query = $this->db->order_by('name','asc')->get_where('unit_master', ['is_deleted' => 'NOT_DELETED']);
		return $query->result();
	}
    //view brand master
    public function view_brand_master()
    {
        $query = $this->db->order_by('name','asc')->get_where('brand_master', ['is_deleted' => 'NOT_DELETED']);
        return $query->result();
    }
    public function fetch_category($pid)
    {
        $data = $this->db->get_where('products_category',['is_parent' => $pid , 'is_deleted' => 'NOT_DELETED'])->result();
        echo "<option value=''>Select Category</option>";
        foreach($data as $val)
        {
            echo "<option value='" . $val->id . "'>" . $val->name . "</option>";
        }
    }
    	//get data by id
	public function get_parent_id()
	{
		$query = $this->db->get_where('products_category');
		return $query->row();
	}
    	//deleted pro image
	public function delete_pro_image($id){
        $data1['prod_images'] = $this->master_model->get_row_data1('products_photo','id',$id);
        $prod_image = ltrim($data1['prod_images']->img, '/');
        $prod_thumb = ltrim($data1['prod_images']->thumbnail, '/');
        if(is_file(DELETE_PATH.$prod_image))
        {
            unlink(DELETE_PATH.$prod_image);
        }
        if(is_file(DELETE_PATH.$prod_thumb))
        {
            unlink(DELETE_PATH.$prod_thumb);
        }
		return $this->db->where('id', $id)->delete('products_photo');
	}
	public function remove_product_cover($p1){
        $change_cover = array('is_cover' => '0');
        return $this->db->where('item_id', $p1)->update('products_photo', $change_cover);
	}
	public function make_product_cover($id){
        $is_cover = array('is_cover' => '1');
		return $this->db->where('id', $id)->update('products_photo', $is_cover);
	}
	public function update_prod_seq($id,$data){
		return $this->db->where('id', $id)->update('products_photo',$data);
	}
	public function add_product_props($data)
	{
		return $this->db->insert('product_props', $data);
	}
	public function update_product_props($product_id,$props_id,$data)
	{
		return $this->db->where(['product_id' => $product_id,'props_id' => $props_id])->update('product_props', $data);
	}
	public function delete_prop_val($id){
		return $this->db->where('id', $id)->delete('product_props');
	}
    public function get_product_props($product_id,$props_id)
	{
		$query = $this->db->get_where('product_props', ['product_id' => $product_id,'props_id' => $props_id]);
		return ($query->num_rows()>0)?true:false;
	}
    public function check_cancellation_existence($product_id,$shop_id)
	{
		$query = $this->db->get_where('products_cancellation_policy', ['pro_id' => $product_id,'shop_id' => $shop_id]);
		return ($query->num_rows()>0)?true:false;
	}

    	//get data by id
	public function get_property_val($id)
	{
        $query = $this->db
        ->select('t1.*,t2.name,t2.id as propid')
        ->from('product_props t1')
        ->join('product_props_master t2', 't2.id = t1.props_id')        
        ->where(['t1.product_id' => $id])
        ->get();
		return $query->result();
		// $query = $this->db->get_where('product_props', ['product_id' => $id]);
		// return $query->result();
	}

        //Home Banner
        public function add_home_banner($data)
        {
            $config['file_name'] = rand(10000, 10000000000);
            $config['upload_path'] = UPLOAD_PATH.'banners/';
            $config['allowed_types'] = 'jpg|jpeg|png|gif|pdf';
            $this->load->library('upload', $config);
            $this->upload->initialize($config);
    
            if (!empty($_FILES['img']['name'])) {
                //upload images
                $_FILES['imgs']['name'] = $_FILES['img']['name'];
                $_FILES['imgs']['type'] = $_FILES['img']['type'];
                $_FILES['imgs']['tmp_name'] = $_FILES['img']['tmp_name'];
                $_FILES['imgs']['size'] = $_FILES['img']['size'];
                $_FILES['imgs']['error'] = $_FILES['img']['error'];
    
                if ($this->upload->do_upload('imgs')) {
                    $image_data = $this->upload->data();
                    $fileName = "banners/" . $image_data['file_name'];
                }
                $data['img'] = $fileName;
            } else {
                $data['img'] = "";
            }
            return $this->db->insert('home_banners', $data);
        }
        public function view_home_banner()
        {
            $query = $this->db
            ->select('t1.*,t2.id as shop_id,t2.shop_name,t2.business_id')
            ->from('home_banners t1')
            ->join('shops t2', 't2.id = t1.shop_id')        
            ->where(['t1.is_deleted' => 'NOT_DELETED'])
            ->order_by('t1.seq','asc')
            ->get();
            return $query->result();
        }
        public function get_home_banner($shop_id)
        {
            $query = $this->db
            ->select('t1.*,t2.id as shop_id,t2.shop_name,t2.business_id')
            ->from('home_banners t1')
            ->join('shops t2', 't2.id = t1.shop_id')        
            ->where(['t1.is_deleted' => 'NOT_DELETED','t1.shop_id' => $shop_id])
            ->order_by('t1.seq','asc')
            ->get();
            return $query->result();
        }
        public function edit_home_banner($data,$id)
        {
            $config['file_name'] = rand(10000, 10000000000);
            $config['upload_path'] = UPLOAD_PATH.'banners/';
            $config['allowed_types'] = 'jpg|jpeg|png|gif|pdf';
            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            
            if (!empty($_FILES['img']['name'])) {
                //upload images
                $_FILES['imgs']['name'] = $_FILES['img']['name'];
                $_FILES['imgs']['type'] = $_FILES['img']['type'];
                $_FILES['imgs']['tmp_name'] = $_FILES['img']['tmp_name'];
                $_FILES['imgs']['size'] = $_FILES['img']['size'];
                $_FILES['imgs']['error'] = $_FILES['img']['error'];
    
                if ($this->upload->do_upload('imgs')) {
                    $image_data = $this->upload->data();
                    $fileName = "banners/" . $image_data['file_name'];
                }
    
                if (!empty($fileName)) 
                {
                    $data2 = $this->db->get_where('home_banners', ['id' =>$id])->row();
                    if (!empty($data2->img))
                    {
                        if(is_file(DELETE_PATH.$data2->img))
                        {
                            unlink(DELETE_PATH.$data2->img);
                        }
                    }
                    $data['img'] = $fileName;
                } 
                
            }
            
            return $this->db->where('id', $id)->update('home_banners', $data); 
        }
        public function view_home_header()
        {
            $query = $this->db
            ->select('t1.*,t2.id as shop_id,t2.shop_name,t2.business_id')
            ->from('home_headers t1')
            ->join('shops t2', 't2.id = t1.shop_id')        
            ->where(['t1.is_deleted' => 'NOT_DELETED'])
            ->order_by('t1.seq','asc')
            ->get();
            return $query->result();
        }
        public function get_home_header($shop_id)       //function using in master_shop controller
        {
            $query = $this->db
            ->select('t1.*,t2.id as shop_id,t2.shop_name,t2.business_id')
            ->from('home_headers t1')
            ->join('shops t2', 't2.id = t1.shop_id')        
            ->where(['t1.is_deleted' => 'NOT_DELETED','t1.shop_id' => $shop_id])
            ->order_by('t1.seq','asc')
            ->get();
            return $query->result();
        }
        public function get_headers_mapping($id)
        {
            $query = $this->db
            ->select('t1.*,t2.id as prod_id,t2.product_code,t2.name as prod_name,t3.title,t4.img')
            ->from('home_headers_mapping t1')
            ->join('products_subcategory t2', 't2.id = t1.value')        
            ->join('home_headers t3', 't3.id = t1.header_id')        
            ->join('products_photo t4', 't4.item_id = t2.id')       
            ->where(['t1.header_id' => $id,'t4.is_cover' =>'1'])
            ->get();
            return $query->result();
        }
        public function fetch_products($id)
        {
            $query = $this->db
            ->select('t1.*,t1.id as prod_id,t2.img')
            ->from('products_subcategory t1')
            ->join('products_photo t2', 't2.item_id = t1.id')           
            // ->join('home_headers_mapping t3', 't3.value = t1.id')           
            ->where(['t1.parent_cat_id' => $id,'t2.is_cover' =>'1','t1.is_deleted' =>'NOT_DELETED'])
            ->get();
            return $query->result();
        }
        public function fetch_products2($id,$psearch)
        {
            $query = $this->db
            ->select('t1.*,t1.id as prod_id,t2.img')
            ->from('products_subcategory t1')
            ->join('products_photo t2', 't2.item_id = t1.id')                 
            ->where(['t2.is_cover' =>'1','t1.is_deleted' =>'NOT_DELETED']);
            if ($psearch !='null' && $id =='null' || $psearch !='null') {
                $this->db->group_start();
                $this->db->like('t1.name', $psearch);
                $this->db->or_like('t1.product_code', $psearch);
                $this->db->group_end();
            }
            if ($id !='null') {
                $this->db->where('t1.parent_cat_id', $id);
            }
            return $query->get()->result();
        }
        public function delete_header_map($id)
        {
            return $this->db->where('id', $id)->delete('home_headers_mapping');
        }
        public function delete_header_mapping($pid,$headerid)
        {
            return $this->db->where(['value' => $pid,'header_id' =>$headerid])->delete('home_headers_mapping');
        }

        //Category Header Mapping
        public function get_category_mapping($id)
        {
            $query = $this->db
            ->select('t1.*,t2.name,t2.icon,t2.id as catid,t3.title')
            ->from('home_headers_mapping t1')
            ->join('products_category t2', 't2.id = t1.value') 
            ->join('home_headers t3', 't3.id = t1.header_id')        
            ->where(['t1.header_id' => $id])
            ->get();
            return $query->result();
        }
        public function delete_category_map($id)
        {
            return $this->db->where('id', $id)->delete('home_headers_mapping');
        }
        public function delete_category_mapping($cid,$headerid)
        {
            return $this->db->where(['value' => $cid,'header_id' =>$headerid])->delete('home_headers_mapping');
        }

        public function delete_product($id)
        {
          
            // $data1['images']        = $this->master_model->product_img($id);
            // unlink($data1['images']->img);
            $is_deleted = array('is_deleted' => 'DELETED');
            return $this->db->where('id', $id)->update('products_subcategory', $is_deleted);
        }
        public function get_cancellation_data($pid)
        {
            $query = $this->db
            ->select('t1.*,t2.shop_name,t2.id as shop_id,t2.business_id')
            ->from('products_cancellation_policy t1')
            ->join('shops t2', 't2.id = t1.shop_id')  
            ->where('pro_id',$pid)
            ->get();
            return $query->result();
        }

        public function edit_product($data,$id)
        {
            $config['file_name'] = rand(10000, 10000000000);
            $config['upload_path'] = UPLOAD_PATH.'product/';
            $config['allowed_types'] = 'jpg|jpeg|png';
            $this->load->library('upload', $config);
            $this->upload->initialize($config);
    
            if (!empty($_FILES['application']['name'])) {
                //upload images
                $_FILES['applications']['name'] = $_FILES['application']['name'];
                $_FILES['applications']['type'] = $_FILES['application']['type'];
                $_FILES['applications']['tmp_name'] = $_FILES['application']['tmp_name'];
                $_FILES['applications']['size'] = $_FILES['application']['size'];
                $_FILES['applications']['error'] = $_FILES['application']['error'];
    
                if ($this->upload->do_upload('applications')) {
                    $image_data = $this->upload->data();
                   
                    $fileName = "product/" . $image_data['file_name'];
                }
    
                $data['application'] = $fileName;
                $data1['app_image'] = $this->master_model->get_row_data1('products_subcategory','id',$id);
                $application = ltrim($data1['app_image']->application, '/');
                if(is_file(DELETE_PATH.$application))
                {
                    unlink(DELETE_PATH.$application);
                }
            }
            //update xml
            $cat_data          = $this->master_model->get_row_data('products_category','id',$data['parent_cat_id']);
            $users = simplexml_load_file(SITEMAP_URL);
            $flag = "0";
            $url = base_url('product-detail/').$id."/".$data['parent_cat_id']."/".$cat_data->is_parent;
            foreach($users->url as $user){
                if($user->id == $id){
                    if($user->id == $id)
                    {
                        $flag = '1';
                    }
                    $user->loc = $url;
                    $user->lastmod = date('Y-m-d');
                    $user->priority = '1.0';
                    break;
                }
            }
            if($flag == '1') 
            {
                file_put_contents(SITEMAP_URL, $users->asXML());
            }
            else
            {
                $user = $users->addChild('url');
                $user->addChild('id', $id);
                $user->addChild('loc', $url);
                $user->addChild('lastmod', date('Y-m-d'));
                $user->addChild('priority', '1.0');
                $dom = new DomDocument();
                $dom->preserveWhiteSpace = false;
                $dom->formatOutput = true;
                $dom->loadXML($users->asXML());
                $dom->save(SITEMAP_URL);
            }

            return $this->db->where('id', $id)->update('products_subcategory', $data); 
        }

        public function get_parent_cat($parent_id,$cat_id,$limit=null,$start=null)
        {
            if ($limit!=null) {
                $this->db->limit($limit, $start);
            }
            $this->db->where(['is_deleted' => 'NOT_DELETED', 'is_parent' => '0']);
            if ($parent_id!='null') {
                $this->db->like('id', $parent_id);
                $this->db->where('is_deleted','NOT_DELETED');
            }
            return $this->db->get('products_category')->result();
        }
        public function get_parent_cat_list()
        {
            $this->db->where(['is_deleted' => 'NOT_DELETED', 'is_parent' => '0']);

            return $this->db->get('products_category')->result();
        }
        public function get_flags_data1($pid)
        {
            $query = $this->db
            ->select('t1.*,t2.shop_name,t2.id as shop_id,t2.business_id')
            ->from('product_flags t1')
            ->join('shops t2', 't2.id = t1.shop_id')  
            ->where(['product_id' => $pid])
            ->get();
            return $query->row();
        }
        public function get_flags_data($pid,$shop_id)
        {
            $query = $this->db
            ->select('t1.*,t2.shop_name,t2.id as shop_id,t2.business_id')
            ->from('product_flags t1')
            ->join('shops t2', 't2.id = t1.shop_id')  
            ->where(['product_id' => $pid, 'shop_id' => $shop_id])
            ->get();
            return $query->result_array();
        }
        public function edit_product_flag($product_id,$shop_id,$data)
        {
            return $this->db->where(['product_id' => $product_id, 'shop_id' => $shop_id])->update('product_flags', $data);
        }

        //shop models
        public function get_flags($pid,$shop_id)
        {
            $query = $this->db
            ->select('t1.*,t2.shop_name,t2.id as shop_id,t2.business_id')
            ->from('product_flags t1')
            ->join('shops t2', 't2.id = t1.shop_id')  
            ->where(['product_id' => $pid, 'shop_id' => $shop_id])
            ->get();
            return $query->row();
        }
        public function get_category()
        {
            $query = $this->db
            ->select('t1.*,t1.name as cat_name,t2.name as parent_name,t2.id as parent_id')
            ->from('products_category t1')
            ->join('products_category t2', 't2.id = t1.is_parent')  
            ->where(['t1.is_deleted' => 'NOT_DELETED'])
            ->get();
            return $query->result();
        }

        public function get_map_products($pid)
        {
            $query = $this->db

            ->select('t1.id as pm_id,t2.name as product_name,t2.product_code,t2.id as pid,t3.img')
            ->from('products_mapping t1')                                         
            ->join('products_subcategory t2', 't2.id = t1.map_pro_id','left')                          
            ->join('products_photo t3', 't3.item_id = t2.id AND t3.is_cover = 1','left')   
            ->where('t1.pro_id' , $pid)
            ->get();
            return $query->result();
    
        }
        public function get_mapped_data($product_id)
        {
            $query = $this->db
            ->select('t1.*')
            ->from('products_mapping t1')    
            ->where('t1.map_pro_id',$product_id)   
            ->or_where('t1.pro_id',$product_id)
            ->get();
            return $query->result();
        }

        //Market Place Home Banner
        public function get_market_place_home_banner()
        {
            $query = $this->db
            ->select('t1.*')
            ->from('home_banners t1')     
            ->where(['t1.is_deleted' => 'NOT_DELETED','t1.shop_id' => '0'])
            ->order_by('t1.seq','asc')
            ->get();
            return $query->result();
        }
        public function add_market_place_home_banners($data)
        {
            $config['file_name'] = rand(10000, 10000000000);
            $config['upload_path'] = UPLOAD_PATH.'banners/';
            $config['allowed_types'] = 'jpg|jpeg|png|gif|pdf';
            $this->load->library('upload', $config);
            $this->upload->initialize($config);
    
            if (!empty($_FILES['img']['name'])) {
                //upload images
                $_FILES['imgs']['name'] = $_FILES['img']['name'];
                $_FILES['imgs']['type'] = $_FILES['img']['type'];
                $_FILES['imgs']['tmp_name'] = $_FILES['img']['tmp_name'];
                $_FILES['imgs']['size'] = $_FILES['img']['size'];
                $_FILES['imgs']['error'] = $_FILES['img']['error'];
    
                if ($this->upload->do_upload('imgs')) {
                    $image_data = $this->upload->data();
                    $fileName = "banners/" . $image_data['file_name'];
                }
                $data['img'] = $fileName;
            }
            else
            {
                $data['img'] = "";
            }
            return $this->db->insert('home_banners', $data);
        }
        public function edit_market_place_home_banners($data,$id)
        {
            $config['file_name'] = rand(10000, 10000000000);
            $config['upload_path'] = UPLOAD_PATH.'banners/';
            $config['allowed_types'] = 'jpg|jpeg|png|gif|pdf';
            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            
            if (!empty($_FILES['img']['name'])) {
                //upload images
                $_FILES['imgs']['name'] = $_FILES['img']['name'];
                $_FILES['imgs']['type'] = $_FILES['img']['type'];
                $_FILES['imgs']['tmp_name'] = $_FILES['img']['tmp_name'];
                $_FILES['imgs']['size'] = $_FILES['img']['size'];
                $_FILES['imgs']['error'] = $_FILES['img']['error'];
    
                if ($this->upload->do_upload('imgs')) {
                    $image_data = $this->upload->data();
                    $fileName = "banners/" . $image_data['file_name'];
                }
    
                if (!empty($fileName)) 
                {
                    $data2 = $this->db->get_where('home_banners', ['id' =>$id])->row();
                    if (!empty($data2->img))
                    {
                        if(is_file(DELETE_PATH.$data2->img))
                        {
                            unlink(DELETE_PATH.$data2->img);
                        }
                    }
                    $data['img'] = $fileName;
                } 
                
            }
            
            return $this->db->where('id', $id)->update('home_banners', $data); 
        }

        //remove linked shop in society master
        public function delete_linked_shop($shop_id,$society_id)
        {
            return $this->db->where(['shop_id' => $shop_id,'socity_id' =>$society_id])->delete('society_shops_link');
        }
        public function get_shops_by_society($society_id)
        {
            $query = $this->db
            ->select('t2.shop_name,t3.title,t1.is_inside')
            ->from('society_shops_link t1')    
            ->join('shops t2', 't2.id = t1.shop_id','left') 
            ->join('business t3', 't3.id = t2.business_id','left') 
            ->where(['t1.socity_id' => $society_id])
            ->get();
            return $query->result();
    
        }
        public function fetch_sub_categories($parent_id)
        {
            $data = $this->db->get_where('products_category',['is_parent' => $parent_id , 'is_deleted' => 'NOT_DELETED'])->result();
            echo "<option value=''>Select Sub Category</option>";
            foreach($data as $val)
            {
                echo "<option value='" . $val->id . "'>" . $val->name . "</option>";
            }
        }
        public function shop_social()
        {
            $query = $this->db
            ->select('t1.*,t2.shop_name,t2.business_id')
            ->from('shop_social t1')
            ->join('shops t2', 't2.id = t1.shop_id')        
            ->where(['t1.is_deleted' => 'NOT_DELETED'])
            ->get();
            return $query->result();
        }
        public function get_products($id,$psearch,$product_id)
        {
            $query = $this->db
            ->select('t1.*,t1.id as prod_id,t2.img')
            ->from('products_subcategory t1')
            ->join('products_photo t2', 't2.item_id = t1.id')    
            ->where(['t2.is_cover' =>'1','t1.is_deleted' =>'NOT_DELETED','t1.id!=' => $product_id]);
            if ($psearch !='null' && $id =='null' || $psearch !='null') {
                $this->db->group_start();
                $this->db->like('t1.name', $psearch);
                $this->db->or_like('t1.product_code', $psearch);
                $this->db->group_end();
            }
            if ($id !='null') {
                $this->db->where('t1.parent_cat_id', $id);
            }
            return $query->get()->result();
    
        }
        
}
?>