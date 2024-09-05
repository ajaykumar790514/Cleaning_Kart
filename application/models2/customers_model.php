<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class customers_model extends CI_Model
{
	function index(){
		echo 'This is model index function';
	}
	function __construct(){
		$this->tbl1 = 'customers';
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






	//customer code starts

	public function get_customers()
    {
        $query = $this->db
        ->select('t1.*,t2.*')
        ->from('customers t1')       
        ->join('customers_address t2', 't2.customer_id = t1.mobile','left')  
        ->get();
		return $query->result();
    }

	public function get_customers_data($from_date,$to_date,$search,$limit=null,$start=null)
    {
        if ($limit!=null) {
            $this->db->limit($limit, $start);
        }
        $this->db
        ->select('t1.*')
        ->from('customers t1');
		// ->group_by('t2.customer_id'); 
        if ($search!='null') {
			$this->db->like('t1.fname', $search);
			$this->db->or_like('t1.lname', $search);
			$this->db->or_like('t1.mobile', $search);
			$this->db->or_like('t1.email', $search);
		}
        if ($to_date!='null') {
			$this->db->where('t1.added >=' , $from_date);
			$this->db->where('t1.added <=' , $to_date);
		}
		if($limit!=null)
            return $this->db->get()->result();
        else
            return $this->db->get()->num_rows();
    }

	public function address($id)
    {
        $query = $this->db
        ->select('t1.*,t2.name as state_name,t3.name as city_name')
        ->from('customers_address t1')       
        ->join('states t2', 't2.id = t1.state','left')  
        ->join('cities t3', 't3.id = t1.city','left')  
		->where('t1.customer_id',$id)
        ->get();
		return $query->result();
    }
}
?>