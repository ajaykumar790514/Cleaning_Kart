<?php
defined('BASEPATH') OR exit('No direct script access allowed');

#[\AllowDynamicProperties]
class pos_order_items_model extends CI_Model
{
	function index(){
		echo 'This is model index function';
	}
	function __construct(){
		$this->tbl1 = 'pos_order_items';
		$this->load->database();
	}
	function getRows($data = array()){
		$this->db->select(" pos_order_items.*,
							id,
							(SELECT name from products_subcategory where id=pos_order_items.product_id) as \"product_name\",
							(SELECT product_code from products_subcategory where id=pos_order_items.product_id) as \"product_code\",
							(SELECT unit_type from products_subcategory where id=pos_order_items.product_id) as \"unit_type\",
							(SELECT unit_value from products_subcategory where id=pos_order_items.product_id) as \"unit_value\",
							CONCAT('".IMGS_URL."',(SELECT img FROM products_photo where item_id = pos_order_items.product_id and is_cover=1)) as \"img\",
							order_id,qty,price_per_unit,total_price,tax,tax_value,offer_applied");
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
		if (is_array($id)) {
			$this->db->where($id);
		}
		else{
			$this->db->where($this->tbl1 . '.' . 'id', $id);
		}
		$result = $this->db->delete($this->tbl1);
		return $result;
	}
}
?>