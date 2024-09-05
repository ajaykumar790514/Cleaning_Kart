<?php
defined('BASEPATH') or exit('No direct script access allowed');

#[\AllowDynamicProperties]
class cash_register_model extends CI_Model
{
	function index()
	{
		echo 'This is model index function';
	}
	function __construct()
	{
		$this->tbl1 = 'cash_register';
		$this->load->database();
	}
	function getRows($data = array())
	{
		$this->db->select("*");
		$this->db->from($this->tbl1);
		if (array_key_exists("conditions", $data)) {
			foreach ($data['conditions'] as $key => $value) {
				$this->db->where($key, $value);
			}
		}
		$query = $this->db->get();
		$result = ($query->num_rows() > 0) ? $query->result_array() : FALSE;
		return $result;
	}
	function insertRow($data = array())
	{
		$result = $this->db->insert($this->tbl1, $data);
		return $result;
	}
	
	function updateRow($id, $data = array())
	{
		if (is_array($id)) {
			$this->db->where($id);
		}
		else{
			$this->db->where($this->tbl1 . '.' . 'id', $id);
		}
		
		$result = $this->db->update($this->tbl1, $data);
		return $result;
	}

	function deleteRow($id)
	{
		if (is_array($id)) {
			$this->db->where($id);
		}
		else{
			$this->db->where($this->tbl1 . '.' . 'id', $id);
		}
		$result = $this->db->delete($this->tbl1);
		return $result;
	}

	public function getvendor()
	{
		$shop_id     = $_SESSION['user_data']['id'];
		$this->db->select("*")
			->from('vendors')
			->where('user_type', '1')
			->where('is_deleted!=', 'DELETED')
			->where('active', '1')
			->where('shop_id', $shop_id);
		return $this->db->get()->result();
	}

	public	function getcustomer()
	{
		$shop_id     = $_SESSION['user_data']['id'];
		$this->db->select("*")
			->from('vendors')
			->where('is_deleted!=', 'DELETED')
			->where('active', '1')
			->where('user_type', '2')
			->where('shop_id', $shop_id);
		return $this->db->get()->result();
	}

	public function checkrefno($ref)
	{
		$query =	$this->db->select("reference_no")
			->from('cash_register')
			->where('reference_no', $ref)
			->get();
		return $query->row();
	}

	public function editcheckrefno($id, $ref)
	{
		$query =	$this->db->select("reference_no")
			->from('cash_register')
			->where('reference_no', $ref)
			->where('id!=', $id)
			->get();
		return $query->row();
	}

	public function getcashlist($fromdate, $todate, $vendorId = null, $customerId = null, $getvendor=null, $getcustomer = null, $limit=null,$start=null)
	{
		if ($limit!=null) { 
            
            $this->db->limit($limit, $start);
        }
		$this->db->select("t1.*,t2.name,t3.bank_name")
			->from('cash_register t1')
			->join('vendors t2', 't2.id = t1.customer_id','LEFT')
			->join('shop_bank_accounts t3', 't3.id = t1.bank_account','LEFT')
			->where('t1.is_deleted!=', 'DELETED')
			->where('t1.active', '1')
			->where('t1.txn_type', '1');
			if ($getvendor != "null") {
				$this->db->where('t1.customer_id', $getvendor);
			}
			if ($getcustomer != "null") {
				$this->db->where('t1.customer_id', $getcustomer);
			}
			if ($todate != "null") {
				$this->db->where('t1.PaymentDate >=', $fromdate);
				$this->db->where('t1.PaymentDate <=', $todate);
			}
			if($limit!=null)
						return $this->db->get()->result();
					else
						return $this->db->get()->num_rows();
	}
	public function getcashamount($fromdate, $todate, $vendorId = null, $customerId = null,$getvendor=null,$getcustomer =null, $limit=null,$start=null)
	{
		// if ($limit!=null) { 
            
        //     $this->db->limit($limit, $start);
        // }
		$this->db->select("( SUM(cr) - (SUM(dr)*-1) ) as balance_amount")
			->from('cash_register')
			->where('is_deleted!=', 'DELETED')
			->where('active', '1')
			->where('txn_type', '1');
		
		if ($getvendor != "null") {
			$this->db->where('customer_id', $getvendor);
		}
		if ($getcustomer != "null") {
			$this->db->where('customer_id', $getcustomer);
		}
		if ($todate != "null") {
			$this->db->where(' PaymentDate >=', $fromdate);
			$this->db->where(' PaymentDate <=', $todate);
		}
		// if($limit!=null)
        //             return $this->db->get()->result();
        //         else
        //             return $this->db->get()->num_rows();
		$return = $this->db->get()->result();

		// echo _prx($return);

		return $return;
	}
	public function getbanktb($fromdate, $todate, $vendorId = null, $customerId = null, $getvendor=null, $getcustomer = null, $limit=null,$start=null)
	{
		if ($limit!=null) { 
            
            $this->db->limit($limit, $start);
        }
		$this->db->select("t1.*,t2.name,")
			->from('cash_register t1')
			->join('vendors t2', 't2.id = t1.customer_id')
			->where('t1.is_deleted!=', 'DELETED')
			->where('t1.active', '1')
			->where('t1.txn_type', '2');
		
		if ($getvendor != "null") {
			$this->db->where('t1.customer_id', $getvendor);
		}
		if ($getcustomer != "null") {
			$this->db->where('t1.customer_id', $getcustomer);
		}
		if ($todate != "null") {
			$this->db->where('t1.PaymentDate >=', $fromdate);
			$this->db->where('t1.PaymentDate <=', $todate);
		}
		if($limit!=null)
                    return $this->db->get()->result();
                else
                    return $this->db->get()->num_rows();
		// return $this->db->get()->result();
	}
	public function getamount($fromdate, $todate, $vendorId = null, $customerId = null,$getvendor=null,$getcustomer =null, $limit=null,$start=null)
	{
		// if ($limit!=null) { 
            
        //     $this->db->limit($limit, $start);
        // }
		$this->db->select("( SUM(cr) - (SUM(dr)*-1) ) as balance_amount")
			->from('cash_register')
			->where('is_deleted!=', 'DELETED')
			->where('active', '1')
			->where('txn_type', '2');
		
		if ($getvendor != "null") {
			$this->db->where('customer_id', $getvendor);
		}
		if ($getcustomer != "null") {
			$this->db->where('customer_id', $getcustomer);
		}
		if ($todate != "null") {
			$this->db->where(' PaymentDate >=', $fromdate);
			$this->db->where(' PaymentDate <=', $todate);
		}
		// if($limit!=null)
        //             return $this->db->get()->result();
        //         else
        //             return $this->db->get()->num_rows();
		return $this->db->get()->result();
	}
}
