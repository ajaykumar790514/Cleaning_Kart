<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class shops_vendor_model extends CI_Model
{
    public function vendors($limit=null,$start=null)
    {
        if ($limit!=null) {
            $this->db->limit($limit, $start);
        }
        $this->db
        ->select('t1.*,t1.name as vendor_name,t2.name as state_name,t3.name as city_name')
        ->from('vendors t1')
        ->join('states t2', 't2.id = t1.state')        
        ->join('cities t3', 't3.id = t1.city')        
        ->where(['t1.is_deleted' => 'NOT_DELETED'])
        ->where(['t1.user_type' => '1'])
        ->order_by('t1.added','desc');
        if (@$_POST['search']) {
			$data['search'] = $_POST['search'];
			$this->db->like('t1.name', $_POST['search']);
			$this->db->or_like('t1.vendor_code', $_POST['search']);
            $this->db->where('t1.is_deleted','NOT_DELETED');
		}
        if($limit!=null)
            return $this->db->get()->result();
        else
            return $this->db->get()->num_rows();
		return $this->db->get()->result();
    }
    public function customer($limit=null,$start=null)
    {
        if ($limit!=null) {
            $this->db->limit($limit, $start);
        }
        $this->db
        ->select('t1.*,t1.name as vendor_name,t2.name as state_name,t3.name as city_name')
        ->from('vendors t1')
        ->join('states t2', 't2.id = t1.state')        
        ->join('cities t3', 't3.id = t1.city')        
        ->where(['t1.is_deleted' => 'NOT_DELETED'])
        ->where(['t1.user_type' => '2'])
        ->order_by('t1.added','desc');
        if (@$_POST['search']) {
			$data['search'] = $_POST['search'];
			$this->db->like('t1.name', $_POST['search']);
			$this->db->or_like('t1.vendor_code', $_POST['search']);
            $this->db->where('t1.is_deleted','NOT_DELETED');
		}
        if($limit!=null)
            return $this->db->get()->result();
        else
            return $this->db->get()->num_rows();
		return $this->db->get()->result();
    }
    public function vendor($id)
    {
        $query = $this->db
        ->select('t1.*,t2.name as state_name,t3.name as city_name,t4.business_id,t4.id as shop_id,t4.shop_name')
        ->from('vendors t1')
        ->join('states t2', 't2.id = t1.state','left')        
        ->join('cities t3', 't3.id = t1.city','left')        
        ->join('shops t4', 't4.id = t1.shop_id','left')        
		->where(['t1.is_deleted' => 'NOT_DELETED','t1.id'=>$id])    
        ->get();
		return $query->row();
    }
    public function customers($id)
    {
        $query = $this->db
        ->select('t1.*,t2.name as state_name,t3.name as city_name,t4.business_id,t4.id as shop_id,t4.shop_name')
        ->from('vendors t1')
        ->join('states t2', 't2.id = t1.state','left')        
        ->join('cities t3', 't3.id = t1.city','left')        
        ->join('shops t4', 't4.id = t1.shop_id','left')        
		->where(['t1.is_deleted' => 'NOT_DELETED','t1.id'=>$id])    
        ->get();
		return $query->row();
    }

    public function vendor_opening($data,$user_id=null)
    {
        if ($this->get_vendor_opening($user_id)) {
            $this->db->where('user_id',$user_id);
            $this->db->update('vendors_opening',$data);
        }
        else{
            $this->db->insert('vendors_opening',$data);
        }
    }

    public function get_vendor_opening($user_id)
    {
        $this->db->where('user_id',$user_id);
        return $this->db->get('vendors_opening')->row();
    }
}

?>