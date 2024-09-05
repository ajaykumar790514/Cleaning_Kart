<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class reports_model extends CI_Model
{
	
    public function get_stock_report($parent_id,$cat_id,$shop_id,$search,$limit=null,$start=null)
    {
        if ($limit!=null) {
            $this->db->limit($limit, $start);
        }
        $this->db
        ->select('t1.id as prod_id,t1.name as prod_name,t1.product_code,t1.unit_type,t1.unit_value,t2.qty,t2.selling_rate,t2.purchase_rate,t2.invoice_no,t3.id as cat_id,t3.name as cat_name')
        ->from('products_subcategory t1')       
        ->join('shops_inventory t2', 't2.product_id = t1.id')  
        ->join('products_category t3', 't3.id = t1.parent_cat_id')  
		->where(['t2.shop_id'=>$shop_id,'t2.qty<'=>10,'t2.is_deleted'=>'NOT_DELETED'])
        ->order_by('t1.name','asc');
        if ($search!='null') {
            $this->db->group_start();
			$this->db->like('t1.product_code', $search);
			$this->db->or_like('t1.name', $search);
			$this->db->or_like('t1.sku', $search);
			$this->db->or_like('t2.invoice_no', $search);
            $this->db->group_end();
		}
        if ($cat_id!='null') {
			$this->db->where('t1.parent_cat_id',$cat_id);
		}
        if($limit!=null)
            return $this->db->get()->result();
        else
            return $this->db->get()->num_rows();

		// return $this->db->get()->result();

    }
    public function get_stock_report_result($cat_id,$shop_id,$search)
    {
        $this->db
        ->select('sum(t2.purchase_rate*t2.qty) as total_purchase,sum(t2.qty) as total_stock')
        ->from('products_subcategory t1')       
        ->join('shops_inventory t2', 't2.product_id = t1.id')  
        ->join('products_category t3', 't3.id = t1.parent_cat_id')  
		->where(['t2.shop_id'=>$shop_id,'t2.qty<'=>10,'t2.is_deleted'=>'NOT_DELETED'])
        ->order_by('t1.name','asc');
        if ($search!='null') {
            $this->db->group_start();
			$this->db->like('t1.product_code', $search);
			$this->db->or_like('t1.name', $search);
			$this->db->or_like('t1.sku', $search);
			$this->db->or_like('t2.invoice_no', $search);
            $this->db->group_end();
		}
        if ($cat_id!='null') {
			$this->db->where('t1.parent_cat_id',$cat_id);
		}
            return $this->db->get()->row();

    }
    public function export_stock_report($shop_id,$cat_id,$search)
    {
        $this->db
        ->select('t1.id as prod_id,t1.name as prod_name,t1.product_code,t1.unit_type,t1.unit_value,t2.qty,t2.selling_rate,t2.purchase_rate,t2.invoice_no,t3.id as cat_id,t3.name as cat_name')
        ->from('products_subcategory t1')       
        ->join('shops_inventory t2', 't2.product_id = t1.id')  
        ->join('products_category t3', 't3.id = t1.parent_cat_id')  
		->where(['t2.shop_id'=>$shop_id,'t2.qty<'=>10,'t2.is_deleted'=>'NOT_DELETED'])
        ->order_by('t1.name','asc');
        if ($search!='null') {
			$this->db->group_start();
			$this->db->like('t1.product_code', $search);
			$this->db->or_like('t1.name', $search);
			$this->db->or_like('t1.sku', $search);
			$this->db->or_like('t2.invoice_no', $search);
            $this->db->group_end();
		}
        if ($cat_id!='null') {
			$this->db->where('t1.parent_cat_id',$cat_id);
		}
		return $this->db->get()->result();

    }
    //stock report
    public function get_product_stock_report($shop_id,$limit=null,$start=null)
    {

        if ($limit!=null) {
            $this->db->limit($limit, $start);
        }
        $this->db
        ->select('t1.id as prod_id,t1.name as prod_name,t1.product_code,t1.unit_type,t1.unit_value,t2.qty,t2.selling_rate,t2.purchase_rate,t2.invoice_no,t3.id as cat_id,t3.name as cat_name')
        ->from('products_subcategory t1')       
        ->join('shops_inventory t2', 't2.product_id = t1.id')  
        ->join('products_category t3', 't3.id = t1.parent_cat_id')  
		->where(['t2.shop_id'=>$shop_id,'t2.is_deleted'=>'NOT_DELETED'])
        ->order_by('t1.name','asc');
        if (@$_POST['tb-search']) {
			$search = $_POST['tb-search'];
			$this->db->group_start();
			$this->db->like('t1.product_code', $search);
			$this->db->or_like('t1.name', $search);
			$this->db->or_like('t1.sku', $search);
			$this->db->or_like('t2.invoice_no', $search);
            $this->db->group_end();
		}
        if (@$_POST['parent_cat_id']) {
			$this->db->where('t1.parent_cat_id',$_POST['parent_cat_id']);
		}
        if (@$_POST['brand_id']) {
            $this->db->where('t1.brand_id',$_POST['brand_id']);
        }
        if (@$_POST['product_id']) {
            $this->db->where('t1.id',$_POST['product_id']);
        }
        if (@$_POST['vendor_id']) {
            $this->db->where('t2.vendor_id',$_POST['vendor_id']);
        }
        if($limit!=null):
            $return = $this->db->get()->result();
            // echo $this->db->last_query();
            return $return;
        else:
            $return = $this->db->get()->num_rows();
            // echo $this->db->last_query();
            return $return;
        endif;

    }
    public function get_product_stock_report_result($shop_id)
    {
        $this->db
        ->select('sum(t2.purchase_rate*t2.qty) as total_purchase,sum(t2.qty) as total_stock')
        ->from('products_subcategory t1')       
        ->join('shops_inventory t2', 't2.product_id = t1.id')  
        ->join('products_category t3', 't3.id = t1.parent_cat_id')  
		->where(['t2.shop_id'=>$shop_id,'t2.is_deleted'=>'NOT_DELETED'])
        ->order_by('t1.name','asc');
       if (@$_POST['tb-search']) {
            $search = $_POST['tb-search'];
            $this->db->group_start();
            $this->db->like('t1.product_code', $search);
            $this->db->or_like('t1.name', $search);
            $this->db->or_like('t1.sku', $search);
            $this->db->or_like('t2.invoice_no', $search);
            $this->db->group_end();
        }
        if (@$_POST['parent_cat_id']) {
            $this->db->where('t1.parent_cat_id',$_POST['parent_cat_id']);
        }
        if (@$_POST['brand_id']) {
            $this->db->where('t1.brand_id',$_POST['brand_id']);
        }
        if (@$_POST['product_id']) {
            $this->db->where('t1.id',$_POST['product_id']);
        }
         if (@$_POST['vendor_id']) {
            $this->db->where('t2.vendor_id',$_POST['vendor_id']);
        }
            return $this->db->get()->row();
    }
    
    public function export_product_stock_report($filter)
    {
        
        $this->db
        ->select('t1.id as prod_id,t1.name as prod_name,t1.product_code,t1.unit_type,t1.unit_value,t2.qty,t2.selling_rate,t2.purchase_rate,t2.invoice_no,t3.id as cat_id,t3.name as cat_name')
        ->from('products_subcategory t1')       
        ->join('shops_inventory t2', 't2.product_id = t1.id')  
        ->join('products_category t3', 't3.id = t1.parent_cat_id')  
        ->where(['t2.shop_id'=>$filter['shop_id'],'t2.is_deleted'=>'NOT_DELETED'])
        ->order_by('t1.name','asc');
        if (@$filter['tb_search']!='null') {
            $search = $filter['tb_search'];
            $this->db->group_start();
            $this->db->like('t1.product_code', $search);
            $this->db->or_like('t1.name', $search);
            $this->db->or_like('t1.sku', $search);
            $this->db->or_like('t2.invoice_no', $search);
            $this->db->group_end();
        }
        if (@$filter['parent_cat_id']!='null') {
            $this->db->where('t1.parent_cat_id',$filter['parent_cat_id']);
        }
        if (@$filter['brand_id']!='null') {
            $this->db->where('t1.brand_id',$filter['brand_id']);
        }
        if (@$filter['product_id']!='null') {
            $this->db->where('t1.id',$filter['product_id']);
        }
        if (@$filter['vendor_id']!='null') {
            $this->db->where('t2.vendor_id',$filter['vendor_id']);
        }
        
            $return = $this->db->get()->result();
           return $return;




        $this->db
        ->select('t1.id as prod_id,t1.name as prod_name,t1.product_code,t1.unit_type,t1.unit_value,t2.qty,t2.selling_rate,t2.purchase_rate,t2.invoice_no,t3.id as cat_id,t3.name as cat_name')
        ->from('products_subcategory t1')       
        ->join('shops_inventory t2', 't2.product_id = t1.id')  
        ->join('products_category t3', 't3.id = t1.parent_cat_id')  
        ->where(['t2.shop_id'=>$filter['shop_id'],'t2.is_deleted'=>'NOT_DELETED'])
        ->order_by('t1.name','asc');
        if (@$filter['tb_search']) {
            $search = $filter['tb_search'];
            $this->db->group_start();
            $this->db->like('t1.product_code', $search);
            $this->db->or_like('t1.name', $search);
            $this->db->or_like('t1.sku', $search);
            $this->db->or_like('t2.invoice_no', $search);
            $this->db->group_end();
        }
        if (@$filter['parent_cat_id']) {
            $this->db->where('t1.parent_cat_id',$filter['parent_cat_id']);
        }
        if (@$filter['brand_id']) {
            $this->db->where('t1.brand_id',$filter['brand_id']);
        }
        if (@$filter['product_id']) {
            $this->db->where('t1.id',$filter['product_id']);
        }
        if (@$filter['vendor_id']) {
            $this->db->where('t2.vendor_id',$filter['vendor_id']);
        }
        $return = $this->db->get()->result();
        return $return;
    }

    public function get_sales_report_accounting($shop_id,$from_date,$to_date,$group_by,$status,$limit=null,$start=null)
    {
        if ($limit!=null) {
            $this->db->limit($limit, $start);
        }
        $this->db
        ->select('t1.id as order_id,t1.*,t2.*,count(t1.added)  as order_count,sum(t2.qty) as total_products,sum(t1.tax) as total_tax,sum(t2.total_price) as total,min(t1.added) as min_date,max(t1.added) as max_date')
        ->from('orders t1')       
        ->join('order_items t2', 't2.order_id = t1.id') 
		->where('t1.shop_id',$shop_id)
		->where(['DATE(t1.added) >='=>$from_date , 'DATE(t1.added) <='=>$to_date])
        ->order_by('sum(t2.qty)','desc');
		// ->group_by('DATE(t1.added)');
        if($group_by!='null')
        {
            if($group_by=='Months') 
            {
                $this->db->group_by('MONTH(DATE(t1.added))');
                $this->db->where('t1.shop_id',$shop_id);
                $this->db->where(['DATE(t1.added) >='=>$from_date , 'DATE(t1.added) <='=>$to_date]);
            }
            else if($group_by=='Days')
            {
                $this->db->group_by('DATE(t1.added)');
                $this->db->where('t1.shop_id',$shop_id);
                $this->db->where(['DATE(t1.added) >='=>$from_date , 'DATE(t1.added) <='=>$to_date]);
            }
            else if($group_by=='Years')
            {
                $this->db->group_by('YEAR(DATE(t1.added))');
                $this->db->where('t1.shop_id',$shop_id);
                $this->db->where(['DATE(t1.added) >='=>$from_date , 'DATE(t1.added) <='=>$to_date]);
            }
        }
            if ($status!='null') {
                $this->db->where('t1.status' , $status);
                $this->db->where('t1.shop_id',$shop_id);
                $this->db->where(['DATE(t1.added) >='=>$from_date , 'DATE(t1.added) <='=>$to_date]);
            }
            if($limit!=null)
                return $this->db->get()->result();
            else
                return $this->db->get()->num_rows();
  
		// return $this->db->get()->result();

    }
    public function export_sales_report_accounting($shop_id,$from_date,$to_date,$group_by,$status)
    {
        $this->db
        ->select('t1.id as order_id,t1.*,t2.*,count(t1.added)  as order_count,sum(t2.qty) as total_products,sum(t1.tax) as total_tax,sum(t2.total_price) as total,min(t1.added) as min_date,max(t1.added) as max_date')
        ->from('orders t1')       
        ->join('order_items t2', 't2.order_id = t1.id') 
		->where('t1.shop_id',$shop_id)
		->where(['DATE(t1.added) >='=>$from_date , 'DATE(t1.added) <='=>$to_date])
        ->order_by('sum(t2.qty)','desc');
		// ->group_by('DATE(t1.added)');

            if($group_by=='Months') 
            {
                $this->db->group_by('MONTH(DATE(t1.added))');
                $this->db->where('t1.shop_id',$shop_id);
                $this->db->where(['DATE(t1.added) >='=>$from_date , 'DATE(t1.added) <='=>$to_date]);
            }
            else if($group_by=='Days')
            {
                $this->db->group_by('DATE(t1.added)');
                $this->db->where('t1.shop_id',$shop_id);
                $this->db->where(['DATE(t1.added) >='=>$from_date , 'DATE(t1.added) <='=>$to_date]);
            }
            else if($group_by=='Years')
            {
                $this->db->group_by('YEAR(DATE(t1.added))');
                $this->db->where('t1.shop_id',$shop_id);
                $this->db->where(['DATE(t1.added) >='=>$from_date , 'DATE(t1.added) <='=>$to_date]);
            }
 
            if ($status) {
                $this->db->where('t1.status' , $status);
                $this->db->where('t1.shop_id',$shop_id);
                $this->db->where(['DATE(t1.added) >='=>$from_date , 'DATE(t1.added) <='=>$to_date]);
            }

		return $this->db->get()->result();

    }

    public function get_product_purchased_report($shop_id,$from_date,$to_date,$limit=null,$start=null)
    {
        if ($limit!=null) {
            $this->db->limit($limit, $start);
        }
        $this->db
        ->select('t1.*,t2.*,t2.id as item_id,t3.name as prod_name,t3.product_code,sum(t2.qty) as quantity,sum(t2.total_price) as total,t3.unit_type,t3.unit_value')
        ->from('orders t1')       
        ->join('order_items t2', 't2.order_id = t1.id')  
        ->join('products_subcategory t3', 't3.id = t2.product_id')  
		->where('t1.shop_id',$shop_id)
        ->order_by('sum(t2.qty)','desc')
		->group_by('t2.product_id'); 
        if ($to_date!='null') {
			$this->db->where('DATE(t1.added) >=' , $from_date);
			$this->db->where('DATE(t1.added) <=' , $to_date);
            $this->db->where('t1.shop_id',$shop_id);
		}
        if($limit!=null)
            return $this->db->get()->result();
        else
            return $this->db->get()->num_rows();

    }
    public function export_product_purchased_report($shop_id,$from_date,$to_date)
    {
        $this->db
        ->select('t1.*,t2.*,t2.id as item_id,t3.name as prod_name,t3.product_code,sum(t2.qty) as quantity,sum(t2.total_price) as total,t3.unit_type,t3.unit_value')
        ->from('orders t1')       
        ->join('order_items t2', 't2.order_id = t1.id')  
        ->join('products_subcategory t3', 't3.id = t2.product_id')  
		->where('t1.shop_id',$shop_id)
        ->order_by('sum(t2.qty)','desc')
		->group_by('t2.product_id'); 
        if ($to_date) {
			$this->db->where('DATE(t1.added) >=' , $from_date);
			$this->db->where('DATE(t1.added) <=' , $to_date);
            $this->db->where('t1.shop_id',$shop_id);
		}
        return $this->db->get()->result();

    }
    public function get_tax_report($shop_id,$from_date,$to_date,$status,$limit=null,$start=null)
    {
        if ($limit!=null) {
            $this->db->limit($limit, $start);
        }
        $this->db
        ->select('t1.id as order_id,t1.*,t2.*,count(t1.added)  as order_count,sum(t2.qty) as total_products,sum(t1.tax) as total_tax,sum(t2.total_price) as total,min(t1.added) as min_date,max(t1.added) as max_date,t1.tax as order_tax')
        ->from('orders t1')       
        ->join('order_items t2', 't2.order_id = t1.id') 
		->where('t1.shop_id',$shop_id)
		->where(['DATE(t1.added) >='=>$from_date , 'DATE(t1.added) <='=>$to_date])
        ->group_by('DATE(t1.added)')
        ->order_by('count(t1.added)','desc');

        if ($status!='null') {
			$this->db->where('t1.status' , $status);
		}
	    if($limit!=null)
            return $this->db->get()->result();
        else
            return $this->db->get()->num_rows();

    }
    public function export_tax_report($shop_id,$from_date,$to_date,$status)
    {
        $this->db
        ->select('t1.id as order_id,t1.*,t2.*,count(t1.added)  as order_count,sum(t2.qty) as total_products,sum(t1.tax) as total_tax,sum(t2.total_price) as total,min(t1.added) as min_date,max(t1.added) as max_date,t1.tax as order_tax')
        ->from('orders t1')       
        ->join('order_items t2', 't2.order_id = t1.id') 
		->where('t1.shop_id',$shop_id)
		->where(['DATE(t1.added) >='=>$from_date , 'DATE(t1.added) <='=>$to_date])
        ->group_by('DATE(t1.added)')
        ->order_by('count(t1.added)','desc');

        if ($status) {
			$this->db->where('t1.status' , $status);
		}
	    return $this->db->get()->result();

    }

    public function get_purchase_report($shop_id,$from_date,$to_date,$vendor,$search,$brand_id,$parent_cat_id,$child_cat_id,$limit=null,$start=null)
    {
       if ($limit!=null) { 
            
            $this->db->limit($limit, $start);
        }
        // $arr_ids=array();
        // $this->db->distinct()
        // ->select('MAX(id) as id')
        // ->from('shop_inventory_logs')
        // ->group_by('shops_inventory_id')
        // ->where('shop_id',$shop_id)
        // ->where('action !=','DELETED')
        // ->where(['date_added >='=>$from_date , 'date_added <='=>$to_date]);

        // $subquery = $this->db->get()->result();
        
        
    
        // foreach($subquery as $row)
        // {
        //     array_push($arr_ids,$row->id);
        // }
        
        // if(count($arr_ids)<=0)
        // {
        //     if($limit==null)
        //         return 0;
        //     else
        //         return [];
                
        // }
    
        $this->db->select('t1.*,t2.id as prod_id,t2.name as product_name,t2.*,t3.vendor_code,t3.name as vendor_name,t3.address as vendor_address,t3.gstin,t4.name as brand_name,t5.is_parent')
                ->from('shop_inventory_logs t1')       
                ->join('products_subcategory t2', 't2.id = t1.product_id') 
                ->join('products_category t5','t2.parent_cat_id = t5.id')
                ->join('vendors t3', 't3.id = t1.vendor_id')       
                ->join('brand_master t4', 't4.id = t2.brand_id','left')    
                ->where('t1.action','LATEST_UPDATE')
                ->where('t1.action!=','DELETED')
                ->where('t1.shop_id',$shop_id)
                ->where(['DATE(t1.invoice_date) >='=>$from_date , 'DATE(t1.invoice_date) <='=>$to_date])
                ->order_by('t1.invoice_date','asc');
                // ->where_in('t1.id',$arr_ids);
                if($vendor!='null')
                {
                    $this->db->where('t1.vendor_id',$vendor);
                } 
                if ($search!='null') {
                    $this->db->group_start();
                    $this->db->like('t1.invoice_no', $search);
                    $this->db->or_like('t2.product_code', $search);
                    $this->db->or_like('t2.name', $search);
                    $this->db->or_like('t2.sku', $search);
                    $this->db->group_end();
                }     
                if ($brand_id!='null') {
                    $this->db->where('t2.brand_id' , $brand_id);
                }
                if ($parent_cat_id!='null') {
                    $this->db->where('t2.parent_cat_id' , $parent_cat_id);
                }
                if ($child_cat_id!='null') {
                    $this->db->where('t2.sub_cat_id' , $child_cat_id);
                }
                if($limit!=null)
                    return $this->db->get()->result();
                else
                    return $this->db->get()->num_rows();
    }
public function get_purchase_result($shop_id,$from_date,$to_date,$vendor,$search,$brand_id,$parent_cat_id,$child_cat_id)
    {
        $this->db->select('sum(t1.total_value) as total_value,sum(t1.total_tax) as total_tax,t2.*')
                ->from('shop_inventory_logs t1') 
                ->join('products_subcategory t2', 't2.id = t1.product_id')    
                ->where('t1.action','LATEST_UPDATE')
                ->where('t1.action!=','DELETED')
                ->where('t1.shop_id',$shop_id)
                ->where(['DATE(t1.invoice_date) >='=>$from_date,'DATE(t1.invoice_date) <='=>$to_date]);
                // ->where_in('t1.id',$arr_ids);
                if($vendor!='null')
                {
                    $this->db->where('t1.vendor_id',$vendor);
                    $this->db->where('t1.shop_id',$shop_id);
                    $this->db->where('t1.action !=','DELETED');
                    $this->db->where('t1.action','LATEST_UPDATE');
                }      
                if ($search!='null') {
                    $this->db->group_start();
                    $this->db->like('t2.product_code', $search);
                    $this->db->or_like('t2.name', $search);
                    $this->db->or_like('t1.invoice_no', $search);
                    $this->db->or_like('t2.sku', $search);
                    $this->db->group_end();
                }   
                if ($brand_id!='null') {
                    $this->db->where('t2.brand_id' , $brand_id);
                }
                if ($parent_cat_id!='null') {
                    $this->db->where('t2.parent_cat_id' , $parent_cat_id);
                }
                if ($child_cat_id!='null') {
                    $this->db->where('t2.sub_cat_id' , $child_cat_id);
                } 
                return $this->db->get()->row();
    }
public function export_purchase_report($shop_id,$from_date,$to_date,$vendor,$search,$brand_id,$parent_id,$parent_cat_id,$child_cat_id,$limit=null,$start=null)
    {
        $this->db->select('t1.*,t2.id as prod_id,t2.name as product_name,t2.*,t3.vendor_code,t3.name as vendor_name,t3.address as vendor_address,t3.gstin,t4.name as brand_name,t5.is_parent')
                ->from('shop_inventory_logs t1')       
                ->join('products_subcategory t2', 't2.id = t1.product_id') 
                ->join('products_category t5','t2.parent_cat_id = t5.id')
                ->join('vendors t3', 't3.id = t1.vendor_id') 
                ->join('brand_master t4', 't4.id = t2.brand_id','left')  
                ->where('t1.action','LATEST_UPDATE')
                ->where('t1.action!=','DELETED')
                ->where('t1.shop_id',$shop_id)
                ->where(['DATE(t1.invoice_date) >='=>$from_date , 'DATE(t1.invoice_date) <='=>$to_date])
                ->order_by('t1.invoice_date','asc');
                if($vendor!='null')
                {
                    $this->db->where('t1.vendor_id',$vendor);
                    $this->db->where('t1.shop_id',$shop_id);
                    $this->db->where('t1.action !=','DELETED');
                    $this->db->where('t1.action','LATEST_UPDATE');
                }
                if ($search!='null') {
                    $this->db->group_start();
                    $this->db->like('t2.product_code', $search);
                    $this->db->or_like('t2.name', $search);
                    $this->db->or_like('t1.invoice_no', $search);
                    $this->db->or_like('t2.sku', $search);
                    $this->db->group_end();
                }   
                if ($brand_id!='null') {
                    $this->db->where('t2.brand_id' , $brand_id);
                }
                if ($parent_cat_id!='null') {
                    $this->db->where('t2.parent_cat_id' , $parent_cat_id);
                }
                if ($child_cat_id!='null') {
                    $this->db->where('t2.sub_cat_id' , $child_cat_id);
                } 
        return $this->db->get()->result();
    }
    public function get_sales_report($shop_id,$from_date,$to_date,$payment_mode,$search,$status_id,$brand_id,$parent_cat_id,$child_cat_id,$product_id,$subscription,$plan_type_id,$limit=null,$start=null)
    {
        if ($limit!=null) {
            $this->db->limit($limit, $start);
        }
        $this->db
        ->select('t1.id as order_id,t1.*,t2.*,t3.*,t4.product_code,t4.name as product_name,t4.sku,t4.parent_cat_id,t4.sub_cat_id,t4.id as prod_id,t1.added as order_date,t5.name as brand_name')
        ->from('orders t1')       
        ->join('order_items t2', 't2.order_id = t1.id') 
        ->join('customers t3', 't3.id = t1.user_id') 
        ->join('products_subcategory t4', 't4.id = t2.product_id') 
        ->join('brand_master t5', 't5.id = t4.brand_id','left') 
        // ->join('subscriptions t6', 't6.id = t1.subscription_id','left') 
		->where('t1.shop_id',$shop_id)
		->where(['DATE(t1.added) >='=>$from_date , 'DATE(t1.added) <='=>$to_date])
        ->order_by('t1.added','asc');
		// ->group_by('DATE(t1.added)');
        if($payment_mode!='null')
        {
            if ($payment_mode == 'cod') {
                $this->db->where('t1.payment_method' , 'cod');
                $this->db->where('t1.shop_id',$shop_id);
                $this->db->where(['DATE(t1.added) >='=>$from_date , 'DATE(t1.added) <='=>$to_date]);
            }
            else if($payment_mode == 'online')
            {
                $this->db->where('t1.payment_method!=' , 'cod');
                $this->db->where('t1.shop_id',$shop_id);
                $this->db->where(['DATE(t1.added) >='=>$from_date , 'DATE(t1.added) <='=>$to_date]);
            }
        }
        if ($search!='null') {
            $this->db->group_start();
            $this->db->where('t4.product_code', $search);
            $this->db->or_where('t1.orderid',$search);
            $this->db->or_where('t4.sku', $search);
            $this->db->group_end();
        }  
        if ($status_id!='null') {
            $this->db->where('t1.status' , $status_id);
        }
        if ($brand_id!='null') {
            $this->db->where('t4.brand_id' , $brand_id);
        }
        if ($parent_cat_id!='null') {
            $this->db->where('t4.parent_cat_id' , $parent_cat_id);
        }
        if ($child_cat_id!='null') {
            $this->db->where('t4.sub_cat_id' , $child_cat_id);
        }
        if ($product_id!='null') {
            $this->db->where('t4.id' , $product_id);
        }
        if ($subscription=='true') {
            $this->db->where('t1.subscription_id!=' , NULL);
        }
        if ($plan_type_id!='null') {
            $this->db->where('t6.plan_type_id' , $plan_type_id);
        }
            if($limit!=null)
                return $this->db->get()->result();
            else
                return $this->db->get()->num_rows();

    }
    public function calculate_sales_report($shop_id,$from_date,$to_date,$payment_mode,$search,$status_id,$brand_id,$parent_cat_id,$child_cat_id,$product_id,$subscription,$plan_type_id)
    {
        $this->db
        ->select('sum(t1.tax) as total_tax,sum(t1.total_value) as total_value')
        ->from('orders t1')       
        ->join('order_items t2', 't2.order_id = t1.id') 
        ->join('products_subcategory t4', 't4.id = t2.product_id')
        // ->join('subscriptions t6', 't6.id = t1.subscription_id','left')
		->where('t1.shop_id',$shop_id)
		->where(['DATE(t1.added) >='=>$from_date , 'DATE(t1.added) <='=>$to_date])
        ->order_by('t2.qty','desc');
		// ->group_by('DATE(t1.added)');
        if($payment_mode!='null')
        {
            if ($payment_mode == 'cod') {
                $this->db->where('t1.payment_method' , 'cod');
                $this->db->where('t1.shop_id',$shop_id);
                $this->db->where(['DATE(t1.added) >='=>$from_date , 'DATE(t1.added) <='=>$to_date]);
            }
            else if($payment_mode == 'online')
            {
                $this->db->where('t1.payment_method!=' , 'cod');
                $this->db->where('t1.shop_id',$shop_id);
                $this->db->where(['DATE(t1.added) >='=>$from_date , 'DATE(t1.added) <='=>$to_date]);
            }
        }
        if ($search!='null') {
            $this->db->group_start();
            $this->db->where('t4.product_code', $search);
            $this->db->or_where('t1.orderid', $search);
            $this->db->or_where('t4.sku', $search);
            $this->db->group_end();
        } 
        if ($status_id!='null') {
            $this->db->where('t1.status' , $status_id);
        } 
        if ($brand_id!='null') {
            $this->db->where('t4.brand_id' , $brand_id);
        }
        if ($parent_cat_id!='null') {
            $this->db->where('t4.parent_cat_id' , $parent_cat_id);
        }
        if ($child_cat_id!='null') {
            $this->db->where('t4.sub_cat_id' , $child_cat_id);
        }
        if ($product_id!='null') {
            $this->db->where('t4.id' , $product_id);
        }
        if ($subscription=='true') {
            $this->db->where('t1.subscription_id!=' , NULL);
        }
        if ($plan_type_id!='null') {
            $this->db->where('t6.plan_type_id' , $plan_type_id);
        }
                return $this->db->get()->row();

    }
    public function export_sales_report($shop_id,$from_date,$to_date,$payment_mode,$status_id,$search,$brand_id,$parent_id,$parent_cat_id,$child_cat_id,$product_id,$subscription,$plan_type_id)
    {
        $this->db
        ->select('t1.id as order_id,t1.*,t2.*,t3.*,t4.product_code,t4.name as product_name,t4.sku,t4.parent_cat_id,t4.sub_cat_id,t1.added as order_date,t5.name as brand_name')
        ->from('orders t1')       
        ->join('order_items t2', 't2.order_id = t1.id') 
        ->join('customers t3', 't3.id = t1.user_id') 
        ->join('products_subcategory t4', 't4.id = t2.product_id') 
        ->join('brand_master t5', 't5.id = t4.brand_id','left') 
		->where('t1.shop_id',$shop_id)
		->where(['DATE(t1.added) >='=>$from_date , 'DATE(t1.added) <='=>$to_date])
        ->order_by('t1.added','asc');
        if($payment_mode!='null')
        {
            if ($payment_mode == 'cod') {
                $this->db->where('t1.payment_method' , 'cod');
            }
            else if($payment_mode == 'online')
            {
                $this->db->where('t1.payment_method!=' , 'cod');
            }
        }
        if ($search!='null') {
            $this->db->group_start();
            $this->db->where('t4.product_code', $search);
            $this->db->or_where('t1.orderid', $search);
            $this->db->or_where('t4.sku', $search);
            $this->db->group_end();
        } 
        if ($status_id!='null') {
            $this->db->where('t1.status' , $status_id);
        }
        if ($brand_id!='null') {
            $this->db->where('t4.brand_id' , $brand_id);
        }
        if ($parent_cat_id!='null') {
            $this->db->where('t4.parent_cat_id' , $parent_cat_id);
        }
        if ($child_cat_id!='null') {
            $this->db->where('t4.sub_cat_id' , $child_cat_id);
        }
        if ($product_id!='null') {
            $this->db->where('t4.id' , $product_id);
        }
        if ($subscription=='true') {
            $this->db->where('t1.subscription_id!=' , NULL);
        }
        if ($plan_type_id!='null') {
            $this->db->where('t6.plan_type_id' , $plan_type_id);
        }
		return $this->db->get()->result();

    }


















    public function get_pos_sales_report($shop_id,$limit=null,$start=null)
    {
        $post = $this->input->post();

        if ($limit!=null) {
            $this->db->limit($limit, $start);
        }
        $this->db
        ->select('t1.id as order_id,t1.*,t2.*,t3.*,t4.product_code,t4.name as product_name,t4.sku,t4.parent_cat_id,t4.sub_cat_id,t4.id as prod_id,t1.added as order_date,t5.name as brand_name')
        ->from('pos_orders t1')       
        ->join('pos_order_items t2', 't2.order_id = t1.id') 
        ->join('vendors t3', 't3.id = t1.user_id') 
        ->join('products_subcategory t4', 't4.id = t2.product_id') 
        ->join('brand_master t5', 't5.id = t4.brand_id','left') 
        ->where('t1.shop_id',$shop_id)
        ->order_by('t1.datetime','asc');
        if (@$post['from_date'] && @$post['to_date']) {
            $this->db->where(['DATE(t1.datetime) >='=>$post['from_date'], 'DATE(t1.datetime) <='=>$post['to_date']]);
        }
        
        if (@$post['tb-search']) {
            $search = $post['tb-search'];
            $this->db->group_start();
            $this->db->like('t4.product_code', $search);
            $this->db->or_like('t1.orderid',$search);
            $this->db->or_like('t4.sku', $search);
            $this->db->group_end();
        }  
        if (@$post['status_id']) {
            $this->db->where('t1.status' , $post['status_id']);
        }
         if (@$post['customer_id']) {
            $this->db->where('t1.user_id' , $post['customer_id']);
        }
        if (@$post['brand_id']) {
            $this->db->where('t4.brand_id' , $post['brand_id']);
        }
        if (@$_POST['parent_cat_id']) {
            $this->db->where('t4.parent_cat_id',$_POST['parent_cat_id']);
        }
        if (@$_POST['sub_cat_id']) {
            $this->db->where('t4.sub_cat_id',$_POST['sub_cat_id']);
        }
        if (@$_POST['product_id']) {
            $this->db->where('t4.id' ,$_POST['product_id']);
        }
       
        if($limit!=null)
            return $this->db->get()->result();
        else
            return $this->db->get()->num_rows();

    }
    public function calculate_pos_sales_report($shop_id)
    {
        $post = $this->input->post();
        $this->db
        ->select('sum(t2.tax) as total_tax,sum(t2.total_price) as total_value')
        ->from('pos_orders t1')       
        ->join('pos_order_items t2', 't2.order_id = t1.id') 
        ->join('products_subcategory t4', 't4.id = t2.product_id')
        ->where('t1.shop_id',$shop_id);
        // ->group_by('t1.orderid');
        if (@$post['from_date'] && @$post['to_date']) {
            $this->db->where(['DATE(t1.datetime) >='=>$post['from_date'], 'DATE(t1.datetime) <='=>$post['to_date']]);
        }
        
        if (@$post['tb-search']) {
            $search = $post['tb-search'];
            $this->db->group_start();
            $this->db->like('t4.product_code', $search);
            $this->db->or_like('t1.orderid',$search);
            $this->db->or_like('t4.sku', $search);
            $this->db->group_end();
        }  
        if (@$post['status_id']) {
            $this->db->where('t1.status' , $post['status_id']);
        }
        if (@$post['customer_id']) {
            $this->db->where('t1.user_id' , $post['customer_id']);
        }
        if (@$post['brand_id']) {
            $this->db->where('t4.brand_id' , $post['brand_id']);
        }
        if (@$_POST['parent_cat_id']) {
            $this->db->where('t4.parent_cat_id',$_POST['parent_cat_id']);
        }
        if (@$_POST['sub_cat_id']) {
            $this->db->where('t4.sub_cat_id',$_POST['sub_cat_id']);
        }
        if (@$_POST['product_id']) {
            $this->db->where('t4.id' ,$_POST['product_id']);
        }
        $data = $this->db->get()->row();
        // echo $this->db->last_query();
        return $data;

    }
    public function export_pos_sales_report($filter)
    {

        $post = $this->input->post();
        $this->db
        ->select('t1.id as order_id,t1.*,t2.*,t3.*,t4.product_code,t4.name as product_name,t4.sku,t4.parent_cat_id,t4.sub_cat_id,t4.id as prod_id,t1.datetime as order_date,t5.name as brand_name')
        ->from('pos_orders t1')       
        ->join('pos_order_items t2', 't2.order_id = t1.id') 
        ->join('vendors t3', 't3.id = t1.user_id') 
        ->join('products_subcategory t4', 't4.id = t2.product_id') 
        ->join('brand_master t5', 't5.id = t4.brand_id','left') 
        ->where('t1.shop_id',$filter['shop_id'])
        ->order_by('t1.datetime','asc');
        if (@$filter['from_date']!='null' && @$filter['to_date']!='null') {
            $this->db->where(['DATE(t1.datetime) >='=>$filter['from_date'], 'DATE(t1.datetime) <='=>$filter['to_date']]);
        }
        
        if (@$filter['tb_search']!='null') {
            $search = $filter['tb_search'];
            $this->db->group_start();
            $this->db->like('t4.product_code', $search);
            $this->db->or_like('t1.orderid',$search);
            $this->db->or_like('t4.sku', $search);
            $this->db->group_end();
        }  
        if (@$filter['status_id']!='null') {
            $this->db->where('t1.status' , $filter['status_id']);
        }
         if (@$filter['customer_id']!='null') {
            $this->db->where('t1.user_id' , $filter['customer_id']);
        }
        if (@$filter['brand_id']!='null') {
            $this->db->where('t4.brand_id' , $filter['brand_id']);
        }
        if (@$filter['parent_cat_id']!='null') {
            $this->db->where('t4.parent_cat_id',$filter['parent_cat_id']);
        }
        if (@$filter['sub_cat_id']!='null') {
            $this->db->where('t4.sub_cat_id',$filter['sub_cat_id']);
        }
        if (@$filter['product_id']!='null') {
            $this->db->where('t4.id' ,$filter['product_id']);
        }
        return $this->db->get()->result();
    }


    public function products_aging_report()
    {
        $f_date = "'".$_POST['f_date']."'";
        $t_date = "'".$_POST['t_date']."'";
        $query = "SELECT
                        mtb.invoice_no, 
                        mtb.invoice_date,
                        CONCAT(v.name ,' (', IFNULL(v.vendor_code,''),') ') as vendor
                                             
                    FROM shops_inventory mtb
                    LEFT JOIN vendors v on v.id = mtb.vendor_id
                    WHERE mtb.is_deleted = 'NOT_DELETED'
                    AND mtb.status = 1
                    AND mtb.qty != 0
                    AND CAST(`mtb`.`invoice_date` AS DATE) BETWEEN $f_date AND $t_date
                    GROUP BY mtb.invoice_no
                    ORDER BY mtb.invoice_date ASC
                    ";

        $result = $this->db->query($query)->result();

        foreach ($result as $key => $value) {
            $invoice_no = "'".$value->invoice_no."'";
            $query = "SELECT
                        CONCAT(p.name ,' (', IFNULL(p.product_code,''),') ') as product,
                        mtb.qty,
                        mtb.purchase_rate,
                        mtb.total_value                       
                    FROM shops_inventory mtb
                    LEFT JOIN products_subcategory p on p.id = mtb.product_id
                    WHERE mtb.is_deleted = 'NOT_DELETED'
                    AND mtb.status = 1
                    AND mtb.qty != 0
                    AND mtb.invoice_no = $invoice_no
                    ORDER BY mtb.qty DESC
                    ";

        $result2 = $this->db->query($query)->result();
            // echo $this->db->last_query();

            $value->products = $result2;
        }


        // echo _prx($result);
        return $result;
    }

    public function products_aging_report_new($products)
    {
        $return = [];
        $tmp_return = [];
        $date = date('Y-m-d',strtotime(($_POST['year']).'-04-01'));
        if (@$_POST['product_id']) {
           foreach ($products as $key => $value) {
                if ($value->id!=$_POST['product_id']) {
                    unset($products[$key]);
                }
           }
        }
        foreach ($products as $key => $value) {
            $OStock = [];
            $tmp_return['id']           = $value->id;
            $tmp_return['Product Name'] = $value->name .'('.$value->product_code.')';
            $tmp_return['Category']     = $value->Category;
            $tmp_return['Unit Type']    = $value->unit_type;
            for ($i=0; $i <= 11; $i++) { 
                $start_date = date('Y-m-d 00:00:00',strtotime(" + $i month ",strtotime($date)));
                $end_date = date('Y-m-t 23:59:59',strtotime(" + $i month ",strtotime($date)));
                $month = date('F',strtotime($start_date));

                if ($start_date >= date('Y-m-d')) {
                    continue;
                }
                $salePurc = $this->sale_purchase($value->id,$start_date,$end_date);
                
                $opening_stock  = (@$OStock[$value->id]) ? $OStock[$value->id] : 0;
                $purchase       = (@$salePurc['purchase']) ? $salePurc['purchase'] : 0;
                $sale           = (@$salePurc['sale']) ? $salePurc['sale'] : 0;
                $closing_stock  = ($purchase + $opening_stock) - $sale;
                $OStock[$value->id] = $closing_stock;
        
                $tmp_return['months'][$month]['Opening Stock'] = $opening_stock;
                $tmp_return['months'][$month]['Purchase']      = $purchase;
                $tmp_return['months'][$month]['Sale']          = $sale;
                $tmp_return['months'][$month]['Closing Stock'] = $closing_stock;
            }
            $return[] = $tmp_return;
            reset($tmp_return);
            if (@$_SESSION['inventory_ids'][$value->id]) {
                unset($_SESSION['inventory_ids'][$value->id]);
            }
            
        }
        return $return;
    }


    public function sale_purchase($product_id,$start_date,$end_date)
    {
        $vendorCond = '';
        if (@$_POST['vendor_id']) {
            $vendor_id = $_POST['vendor_id'];
            $vendorCond =" AND mtb.vendor_id = {$vendor_id} ";
        }

        $brandCond = '';
        if (@$_POST['brand_id']) {
            $brand_id = $_POST['brand_id'];
            $brandCond =" AND b.id = {$brand_id} ";
        }
        $query = "SELECT '' as 'Sr. No', mtb.product_id, mtb.shops_inventory_id,p.unit_type,i.purchase_rate,
                            CONCAT(p.name, ' ' ,
                                IF(p.product_code != '', '(' , ''),' ',
                                IF(p.product_code != '', p.product_code , ''),' ',
                                IF(p.product_code != '', ')' , '')
                                ) as 'Product Name',
                            CONCAT(pc.name, ' ' ,
                                IF(psc.name IS NULL , '' , ' / '),
                                IF(psc.name IS NULL , '', psc.name)
                                ) as 'Category',
                            mtb.qty as 'Total Quantity'

                    FROM shop_inventory_logs mtb 
                    LEFT JOIN products_subcategory p on p.id = mtb.product_id 
                    LEFT JOIN products_category pc on pc.id = p.parent_cat_id 
                    LEFT JOIN products_category psc on psc.id = p.sub_cat_id 
                    LEFT JOIN shops_inventory i on i.id = mtb.shops_inventory_id 
                    LEFT JOIN brand_master b on b.id =  p.brand_id
                    WHERE (mtb.invoice_date BETWEEN '{$start_date}' AND '{$end_date}')
                        AND (mtb.action = 'LATEST_UPDATE' OR mtb.action = 'SALES_RETURN')
                        AND mtb.product_id = {$product_id} 
                        $vendorCond $brandCond
                    -- GROUP BY mtb.product_id
                    ORDER BY p.name ASC
                    ";
        $inventory = $this->db->query($query)->result_array();
        $total_purchase = $total_sale = 0;
        if (@$inventory) {


            
            foreach ($inventory as $key => $value) {
                // echo _prx($value['shops_inventory_id']);
                if (@$_SESSION['inventory_ids'][$product_id]) {
                    $session_array = $_SESSION['inventory_ids'][$product_id];
                }
                else{
                   $session_array = ''; 
                }
                $_SESSION['inventory_ids'][$product_id] = $value['shops_inventory_id'].', '.$session_array;


                $total_purchase         += $value['Total Quantity'];
                // $total_sale             += $sale;
            }


           
       }

       if (@$_SESSION['inventory_ids'][$product_id]) {
            $inventory_ids  = $_SESSION['inventory_ids'][$product_id];
            $inventory_ids  = trim($inventory_ids,', ');
            $inventory_ids  = explode(', ', $inventory_ids);
            $inventory_ids  = implode(', ', $inventory_ids);
       }
       
        if (@$inventory_ids) {
            $query = "SELECT IFNULL(SUM(mtb.qty),0) as sale
                    FROM pos_order_items mtb  
                    INNER JOIN pos_orders o on o.id = mtb.order_id
                    WHERE (o.datetime BETWEEN '{$start_date}' AND '{$end_date}')
                        AND o.status = 17
                        AND mtb.product_id = {$product_id}
                        AND mtb.inventory_id IN ({$inventory_ids})
                    -- GROUP BY mtb.product_id , mtb.inventory_id
                    ";
            $return2 = $this->db->query($query)->result_array();
            // echo _prx($return2);

        }
        
        
        // echo _prx($_SESSION['inventory_ids'][$product_id]);
        $sale = (@$return2) ? $return2[0]['sale'] : 0 ;

        $return['purchase']          = $total_purchase;
        $return['sale']              = $sale;
        // echo _prx($return);
        // echo _prx($inventory);
        return $return;
       // else{
       //  return false;
       // }
        // $return = []; 
        
    }

    public function date_wise_product_stock_report($products)
    {
        $date = $_POST['date'];

        $product_ids = '';
        foreach ($products as $key => $value) {
            $product_ids .= $value->id.', ';
        }
        if (@$_POST['product_id']) {
            $product_ids = '';
            $product_ids .= $_POST['product_id'].', ';
        }
        $product_ids = trim($product_ids,', ');
        $productCond = '';
        if ($product_ids!='') {
            $productCond =" AND mtb.product_id IN ({$product_ids}) ";
        }

        $vendorCond = '';
        if (@$_POST['vendor_id']) {
            $vendor_id = $_POST['vendor_id'];
            $vendorCond =" AND mtb.vendor_id = {$vendor_id} ";
        }

        $brandCond = '';
        if (@$_POST['brand_id']) {
            $brand_id = $_POST['brand_id'];
            $brandCond =" AND b.id = {$brand_id} ";
        }

        $query = "SELECT 
        '' as 'Sr. No', mtb.product_id, mtb.shops_inventory_id,mtb.action,mtb.purchase_rate,mtb.total_value,p.unit_type,
                            CONCAT(p.name, ' ' ,
                                IF(p.product_code != '', '(' , ''),' ',
                                IF(p.product_code != '', p.product_code , ''),' ',
                                IF(p.product_code != '', ')' , '')
                                ) as 'Product Name',
                            CONCAT(pc.name, ' ' ,
                                IF(psc.name IS NULL , '' , ' / '),
                                IF(psc.name IS NULL , '', psc.name)
                                ) as 'Category',
                            IFNULL(mtb.qty,0) as 'Total Quantity'
                            

                    FROM shop_inventory_logs mtb 
                    LEFT JOIN products_subcategory p on p.id = mtb.product_id 
                    LEFT JOIN products_category pc on pc.id = p.parent_cat_id 
                    LEFT JOIN products_category psc on psc.id = p.sub_cat_id 
                    LEFT JOIN shops_inventory i on i.id = mtb.shops_inventory_id 
                    LEFT JOIN brand_master b on b.id =  p.brand_id
                    WHERE mtb.invoice_date <= '{$date}'
                        AND mtb.action = 'LATEST_UPDATE' 
                        $productCond $vendorCond $brandCond
                    GROUP BY mtb.product_id , mtb.shops_inventory_id
                    ORDER BY p.name ASC
                    ";
        $inventory = $this->db->query($query)->result_array();

        // echo _prx(['inventory' => $inventory]);
        // die();  
      
        $i = 0;
        foreach ($inventory as $key => $value) {
            $product_id     = $value['product_id'];
            $inventory_id   = $value['shops_inventory_id'];
            $query = "SELECT    
                            SUM(mtb.qty) as sale_qty, 
                            SUM(mtb.total_price) as total_sale
                        FROM pos_order_items mtb  
                        INNER JOIN pos_orders o on o.id = mtb.order_id
                        WHERE o.datetime <= '{$date}'
                            AND o.status = 17
                            AND mtb.product_id = {$product_id}
                            AND mtb.inventory_id = {$inventory_id}
                        GROUP BY mtb.product_id , mtb.inventory_id
                        ";
            $sales = $this->db->query($query)->result_array();
            // echo _prx(['sales' => $sales]);

            $query = "SELECT IFNULL(SUM(mtb.qty),0) as 'return', IFNULL(SUM(mtb.total_value),0) as total_return
                        FROM shop_inventory_logs mtb
                        WHERE mtb.product_id = $product_id
                            AND mtb.shops_inventory_id = $inventory_id
                            AND mtb.action = 'SALES_RETURN'
                        GROUP BY mtb.product_id , mtb.shops_inventory_id";
            $sale_return = $this->db->query($query)->result_array();
            // echo _prx($value);
            // echo _prx(['sales' => $sales]);

            $sale_qty   = (@$sales) ? $sales[0]['sale_qty'] : 0 ;
            $total_sale = (@$sales) ? $sales[0]['total_sale'] : 0 ;
            

            if (@$sale_return) {
                $sale_qty   = $sale_qty -  $sale_return[0]['return'];
                $total_sale = $total_sale -  $sale_return[0]['total_return'];
            }

            $inventory[$key]['Sr. No']      = ++$i;
            $inventory[$key]['Sale']        = $sale_qty;
            $inventory[$key]['total_sale']  = $total_sale;
            $inventory[$key]['In Stock']    = $value['Total Quantity'] - $sale_qty;  
            // echo "string";
        }
        // die();

        
            // echo _prx(['inventory' => $inventory]);
            // die();
        $new_array = [];
        foreach ($inventory as $key => $value) {
            $new_array[$value['product_id']][] = $value;
        }

            // echo _prx(['new_array' => $new_array]); die();


        $n=0;
        $return =[];
        $t_Purchase=$t_AmountIn=$t_Sale=$t_AmountOut=$t_ClosingQty=$t_ClosinAmount=0;
        foreach ($new_array as $key => $value) {
            $TotalQuantity = $Sale = $InStock= $TotalPurchase = $TotalSale = 0;
            foreach ($value as $vkey => $row) {
                $TotalQuantity  += $row['Total Quantity'];
                $Sale           += $row['Sale'];
                $InStock        += $row['In Stock'];
                $TotalPurchase  += $row['total_value'];
                $TotalSale      += $row['total_sale'];
            }



            // $sap = $Amount_Out = 0;
            // if ($TotalSaleRate != 0 && $Sale != 0) {
            //     $sap = _nf($TotalSaleRate/count($value));
            //     $Amount_Out = _nf($Sale*$sap);
            // }

            $return[$n]['Sr. No']               = $n+1;
            $return[$n]['Product Name']         = $value[0]['Product Name'];
            $return[$n]['Parent Group']         = $value[0]['Category'];
            $return[$n]['Unit']                 = $value[0]['unit_type'];

            $return[$n]['Opening Qty']          = _nf(0);
            $return[$n]['Avg. Price']           = _nf(0);
            $return[$n]['Opening Amount']       = _nf(0);

            $return[$n]['Purchase']             = $TotalQuantity;
            $return[$n]['Purc. Avg. Price']     = $pap =_nf($TotalPurchase/$TotalQuantity);
            $return[$n]['Amount In']            = _nf($TotalPurchase);

            $return[$n]['Sale']                 = $Sale;
            $return[$n]['Sale Avg. Price']      = (@$Sale) ? _nf($TotalSale/$Sale) : _nf(0);
            $return[$n]['Amount Out']           = (@$Sale) ? _nf($TotalSale) : _nf(0);

            $return[$n]['Closing Qty']          = $InStock;
            $return[$n]['Closing Price']        = $pap;
            $return[$n]['Closing Amount']       = (@$InStock) ? _nf($InStock*$pap) : _nf(0);

            // $return[$n]['Avg. PurchaseRate']    = _nf($TotalPurchaseRate/count($value));
            // $return[$n]['Total Quantity']       = $TotalQuantity;
            // $return[$n]['Sale']                 = $Sale;
            // $return[$n]['In Stock']             = $InStock;
           
            $t_Purchase     += $return[$n]['Purchase'];
            $t_AmountIn     += $return[$n]['Amount In'];
            $t_Sale         += $return[$n]['Sale'];
            $t_AmountOut    += $return[$n]['Amount Out'];
            $t_ClosingQty   += $return[$n]['Closing Qty'];
            $t_ClosinAmount += $return[$n]['Closing Amount'];

            $n++;
        }

        if (@$return) {
            $return[$n]['Sr. No']               = '';
            // $n_return[$n]['product_id']          = $value[0]['product_id'];
            $return[$n]['Product Name']         = '';
            $return[$n]['Parent Group']         = '';
            $return[$n]['Unit']                 = '<strong>Total</strong>';

            $return[$n]['Opening Qty']          = _nf(0);
            $return[$n]['Avg. Price']           = _nf(0);
            $return[$n]['Opening Amount']       = _nf(0);

            $return[$n]['Purchase']             = $t_Purchase;
            $return[$n]['Purc. Avg. Price']     = '';
            $return[$n]['Amount In']            = _nf($t_AmountIn);

            $return[$n]['Sale']                 = $t_Sale;
            $return[$n]['Sale Avg. Price']      = '';
            $return[$n]['Amount Out']           = _nf($t_AmountOut);

            $return[$n]['Closing Qty']          = $t_ClosingQty;
            $return[$n]['Closing Price']        = '';
            $return[$n]['Closing Amount']       = _nf($t_ClosinAmount);

        }

        

        // echo _prx(['return' => $return]);

       
        return $return;
    }
    
}
?>