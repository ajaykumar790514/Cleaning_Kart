<?php
defined('BASEPATH') or exit('No direct script access allowed');

#[\AllowDynamicProperties]
class shops_inventory_model extends CI_Model
{
	function index()
	{
		echo 'This is model index function';
	}
	function __construct()
	{
		$this->tbl1 = 'shops_inventory';
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
	function insertRow1($data = array())
	{
		if ($this->db->insert($this->tbl1, $data)) {
			$result = $this->db->insert_id();
		} else {
			$result = $this->db->_error_message();
		}
		return $result;
	}
	function updateRow($id, $data = array())
	{
		$this->db->where($this->tbl1 . '.' . 'id', $id);
		$result = $this->db->update($this->tbl1, $data);
		return $result;
	}
	function deleteRow($id)
	{
		if ($this->db->get_where('pos_order_items',['inventory_id'=>$id])->row()) {
			return false;
		}
		else{
			$this->db->where($this->tbl1 . '.' . 'id', $id);
			$result = $this->db->delete($this->tbl1);
			return $result;
		}
		
	}
	function getInventoryData($data = array())
	{
		$this->db->select('
							shops_inventory.id as "id",
							CONCAT("' . IMGS_URL . '",(SELECT img FROM products_photo where item_id = products_subcategory.id and is_cover=1)) as "img",
							products_subcategory.id as "product_id",
							shops_inventory.qty as "qty",
							shops_inventory.purchase_rate as "purchase_rate",
							shops_inventory.mrp as "mrp",
							shops_inventory.selling_rate as "selling_rate",						
							shops_inventory.status as "status"	,					
							shops_inventory.mfg_date as "mfg_date",						
							shops_inventory.expiry_date as "expiry_date",
							shops_inventory.total_value as "total_value",
							shops_inventory.total_tax as "total_tax",
							shops_inventory.invoice_no as "invoice_no",
							shops_inventory.invoice_date as "invoice_date",
							shops_inventory.vendor_id as "vendor_id",
							shops_inventory.is_igst as "is_igst",
							shops_inventory.tax_value as "tax_value",
							vendors.name as "vendor_name",			
							vendors.active as "vendor_active",			
							vendors.id as "vendor_id",			
							shops_inventory.AdditionalDiscount as "AdditionalDiscount",		
							products_subcategory.unit_type as "unit_type",	
							products_subcategory.unit_value as "unit_value",	
						');
		$this->db->from($this->tbl1);
		$this->db->join('products_subcategory', 'products_subcategory.id = shops_inventory.product_id', 'INNER');
		$this->db->join('vendors', 'vendors.id = shops_inventory.vendor_id', 'INNER');
		if (array_key_exists("conditions", $data)) {
			foreach ($data['conditions'] as $key => $value) {
				$this->db->where($key, $value);
				$this->db->where('shops_inventory.is_deleted', 'NOT_DELETED');	//added
				// $this->db->where('shops_inventory.status','1');	//added
			}
		}
		if (array_key_exists("conditions_like", $data)) {
			foreach ($data['conditions_like'] as $key => $value) {
				$this->db->like($key, $value);
			}
		}
		if (isset($data['limit']) && isset($data['offset'])) {
			$this->db->limit($data['limit'], $data['offset']);
		}
		$query = $this->db->get();
		$result = ($query->num_rows() > 0) ? $query->result_array() : FALSE;
		return $result;
	}


	function getProductimg($product_id)
	{
		$this->db->select('
				CONCAT("' . IMGS_URL . '",(SELECT img FROM products_photo where item_id = products_subcategory.id and is_cover=1)) as "img"');
		$this->db->from('products_subcategory');
		$this->db->where('id', $product_id);

		
		$query = $this->db->get();
		$result = ($query->num_rows() > 0) ? $query->row() : FALSE;
		return $result;
	}


}
