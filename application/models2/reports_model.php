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
    public function get_product_stock_report($parent_id,$cat_id,$shop_id,$search,$limit=null,$start=null)
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
        if ($search!='null') {
			$data['search'] = $search;
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

    }
    public function get_product_stock_report_result($cat_id,$shop_id,$search)
    {
        $this->db
        ->select('sum(t2.purchase_rate*t2.qty) as total_purchase,sum(t2.qty) as total_stock')
        ->from('products_subcategory t1')       
        ->join('shops_inventory t2', 't2.product_id = t1.id')  
        ->join('products_category t3', 't3.id = t1.parent_cat_id')  
		->where(['t2.shop_id'=>$shop_id,'t2.is_deleted'=>'NOT_DELETED'])
        ->order_by('t1.name','asc');
        if ($search!='null') {
			$data['search'] = $search;
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
    
    public function export_product_stock_report($shop_id,$cat_id,$search)
    {
        $this->db
        ->select('t1.id as prod_id,t1.name as prod_name,t1.product_code,t1.unit_type,t1.unit_value,t2.qty,t2.selling_rate,t2.purchase_rate,t2.invoice_no,t3.id as cat_id,t3.name as cat_name')
        ->from('products_subcategory t1')       
        ->join('shops_inventory t2', 't2.product_id = t1.id')  
        ->join('products_category t3', 't3.id = t1.parent_cat_id')  
		->where(['t2.shop_id'=>$shop_id,'t2.is_deleted'=>'NOT_DELETED'])
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
                    $this->db->where('t2.product_code', $search);
                    $this->db->or_where('t1.invoice_no', $_POST['search']);
                    $this->db->or_where('t2.sku', $_POST['search']);
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
                    $this->db->where('t2.product_code', $search);
                    $this->db->or_where('t1.invoice_no', $_POST['search']);
                    $this->db->or_where('t2.sku', $_POST['search']);
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
                    $this->db->where('t2.product_code', $search);
                    $this->db->or_where('t1.invoice_no', $_POST['search']);
                    $this->db->or_where('t2.sku', $_POST['search']);
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
        ->join('subscriptions t6', 't6.id = t1.subscription_id','left') 
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
        ->join('subscriptions t6', 't6.id = t1.subscription_id','left')
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
    
}
?>