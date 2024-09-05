<?php 

/**
 * 
 */
class Return_model extends CI_Model
{
	
	function __construct()
    {
        $this->load->database();
    }




    public function get_sales_return()
    {
        $rows = [];
        if (@$_POST['customer_id'] or @$_POST['product_id']):

            $customer_id = $_POST['customer_id'];
            $product_id  = $_POST['product_id'];

            if (@$_POST['customer_id'] && @$_POST['product_id']) {
                $where = "mtb.customer_id = $customer_id AND mtb.product_id = $product_id";
            }
            elseif (@$_POST['customer_id']) {
                $where = "mtb.customer_id = $customer_id";
            }
            elseif (@$_POST['product_id']) {
                $where = "mtb.customer_id = $product_id";
            }

           
            $query = "SELECT mtb.*, 
                            p.name as product_name,
                            v.name as customer_name
                        FROM sales_return mtb
                        LEFT JOIN products_subcategory p on p.id = mtb.product_id
                        LEFT JOIN vendors v on v.id = mtb.customer_id
                        WHERE $where
                        ORDER BY mtb.date DESC
                        ";

            $rows = $this->db->query($query)->result();
            // echo $this->db->last_query();
        endif;

        return $rows;
    }

    public function get_purchase_return()
    {
        $rows = [];
        if (@$_POST['vendor_id'] or @$_POST['product_id']):
            $vendor_id = $_POST['vendor_id'];
            $product_id  = $_POST['product_id'];

            if (@$_POST['vendor_id'] && @$_POST['product_id']) {
                $where = "mtb.vendor_id = $vendor_id AND mtb.product_id = $product_id";
            }
            elseif (@$_POST['vendor_id']) {
                $where = "mtb.vendor_id = $vendor_id";
            }
            elseif (@$_POST['product_id']) {
                $where = "mtb.customer_id = $product_id";
            }

            $query = "SELECT mtb.*, 
                            p.name as product_name,
                            v.name as customer_name
                        FROM purchase_return mtb
                        LEFT JOIN products_subcategory p on p.id = mtb.product_id
                        LEFT JOIN vendors v on v.id = mtb.vendor_id
                        WHERE $where
                        ORDER BY mtb.date DESC
                        ";

            $rows = $this->db->query($query)->result();
            // echo $this->db->last_query();
        endif;

        return $rows;
    }





    public function get_stocks($shop_id,$pro_id)
    {

    	$date = "'".date('Y-m-d')."'";
    	$query = "SELECT mtb.*,v.name as vendor_name,v.vendor_code as vendor_code
    				FROM shops_inventory mtb
    				LEFT JOIN vendors v on v.id = mtb.vendor_id
    				WHERE mtb.product_id = $pro_id
    				AND mtb.shop_id = $shop_id
    				AND mtb.status = 1
    				AND mtb.is_deleted = 'NOT_DELETED'
    				AND mtb.expiry_date > $date
    				AND v.is_deleted = 'NOT_DELETED'
    				AND v.active = 1

                    ORDER BY mtb.expiry_date DESC  LIMIT 5";

    	$result = $this->db->query($query)->result();
    	// echo $this->db->last_query();

    	// echo _prx($result);
    	return $result;
    }

    public function get_stocks_purchase($shop_id,$pro_id,$vendor_id)
    {
        $query = "SELECT mtb.*,v.name as vendor_name,v.vendor_code as vendor_code
                    FROM shops_inventory mtb
                    LEFT JOIN vendors v on v.id = mtb.vendor_id
                    WHERE mtb.product_id = $pro_id
                    AND mtb.shop_id = $shop_id
                    AND mtb.vendor_id = $vendor_id
                    AND mtb.qty != 0
                    AND mtb.status = 1
                    AND mtb.is_deleted = 'NOT_DELETED'
                    AND v.is_deleted = 'NOT_DELETED'
                    AND v.active = 1
                    ORDER BY mtb.expiry_date ASC LIMIT 5";

        $result = $this->db->query($query)->result();
        // echo $this->db->last_query();

        // echo _prx($result);
        return $result;
    }

    public function report()
    {
       // echo "jsejf";
        $result = false;
        $where = '';
        if (@$_POST['from_date'] && @$_POST['to_date'] && (@$_POST['is_Customer']=='on' or @$_POST['is_Vendor']=='on')) {
            $shop_id     = $_SESSION['user_data']['id'];
            $f_date = $_POST['from_date'];
            $t_date = $_POST['to_date'];
            $customer_id = @$_POST['business_id'];

            $tb = (@$_POST['is_Customer']=='on') ? 'sales_return' : 'purchase_return' ;
            $_POST['type'] = $tb;
            if (@$_POST['business_id']) {
                $where = " AND mtb.vendor_id = $customer_id ";
            }

            if ($tb == 'sales_return') {

                if (@$_POST['business_id']) {
                    $where = " AND mtb.customer_id = $customer_id ";
                }
                $query = "SELECT mtb.*, 
                            p.name as product_name,
                            p.product_code as product_code,
                            v.name as name,
                            v.vendor_code as code
                        FROM sales_return mtb
                        LEFT JOIN products_subcategory p on p.id = mtb.product_id
                        LEFT JOIN vendors v on v.id = mtb.customer_id
                        WHERE mtb.date >= '{$f_date}' 
                            AND mtb.date <= '{$t_date}'
                            $where
                        ORDER BY mtb.date DESC";
            }
            else{
                // echo "string";
                if (@$_POST['business_id']) {
                    $where = " AND mtb.vendor_id = $customer_id ";
                }
                $query = "SELECT mtb.*, 
                            p.name as product_name,
                            p.product_code as product_code,
                            v.name as name,
                            v.vendor_code as code
                        FROM purchase_return mtb
                        LEFT JOIN products_subcategory p on p.id = mtb.product_id
                        LEFT JOIN vendors v on v.id = mtb.vendor_id
                        WHERE mtb.date >= '{$f_date}' 
                            AND mtb.date <= '{$t_date}'
                            $where
                        ORDER BY mtb.date DESC";
            }

            $result = $this->db->query($query)->result();
                  
        }
        return $result;

    
    }
}

 ?>