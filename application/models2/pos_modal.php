<?php
defined('BASEPATH') or exit('No direct script access allowed');

class POS_modal extends CI_Model
{
    function index()
    {
        echo 'This is model index function';
    }
    function __construct()
    {
        $this->tbl1 = '';
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
        $this->db->where($this->tbl1 . '.' . 'id', $id);
        $result = $this->db->update($this->tbl1, $data);
        return $result;
    }
    function deleteRow($id)
    {
        $this->db->where($this->tbl1 . '.' . 'id', $id);
        $result = $this->db->delete($this->tbl1);
        return $result;
    }
    function getItem($search, $shop_id)
    {

        $response = array();

        if (isset($search['search'])) {
            // Select record
            $this->db->select('t1.*,t2.*,t3.name as vendor_name')
                ->from('products_subcategory t1')
                ->join('shops_inventory t2', 't2.product_id = t1.id')
                ->join('vendors t3', 't3.id = t2.vendor_id')
                ->where(['t2.shop_id' => $shop_id, 't2.is_deleted' => 'NOT_DELETED'])
                ->order_by('t1.name', 'asc');
            $this->db->like('t1.product_code', $search['search']);
            $this->db->or_like('t1.name', $search['search']);
            $this->db->or_like('t2.selling_rate', $search['search']);
            $records = $this->db->get()->result();

            // echo _prx($records);

            foreach ($records as $row) {
                $response[] = array("value" => $row->product_id, "label" => $row->name.' - '.$row->vendor_name , "product_code" => $row->product_code,"purchase_rate" => $row->purchase_rate ,"mrp" => $row->mrp, "description" => $row->description, "qty" => $row->qty, "AdditionalDiscount" => $row->AdditionalDiscount, "tax_value" => $row->tax_value);
            }
        }
        return $response;
    }
    function getcustomer($search, $shop_id)
    {
        $response = array();

        if (isset($search['search'])) {
            // Select record
            $this->db->select('*')
                ->from('vendors t1')
                ->where(['shop_id' => $shop_id, 'is_deleted' => 'NOT_DELETED', 'active' => '1', "user_type" => "2"])
                ->order_by('name', 'asc');
            $this->db->like('name', $search['search']);
            $records = $this->db->get()->result();

            foreach ($records as $row) {
                $response[] = array("value" => $row->id, "label" => $row->name, "mobile" => $row->mobile, "gstin" => $row->gstin, "vendor_code" => $row->vendor_code,  "contact_person_name" => $row->contact_person_name,  "email" => $row->email, "email" => $row->email, "address" => $row->address);
            }
        }
        return $response;
    }


    public function get_customer_code($vendor_code)
    {
        $query = $this->db->select("vendor_code")
            ->from('vendors')
            ->where('vendor_code', $vendor_code)
            ->get();
        return $query->row();
    }


    // ankit Verma

    public function save_order($data)
    {
        if ($this->db->insert('pos_orders',$data)) {
            return $this->db->insert_id();
        }
        return false;
    }

    public function update_order($data,$id)
    {
        $this->db->where('id',$id);
        if ($this->db->update('pos_orders',$data)) {
            return true;
        }
        return false;
    }
}
