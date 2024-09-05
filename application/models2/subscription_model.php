<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class subscription_model extends CI_Model
{
    public function get_subscription_slots()
	{
		$query = $this->db
        ->select('t1.*,t2.shop_name,t2.business_id')
        ->from('subscriptions_slots t1')
        ->join('shops t2', 't2.id = t1.shop_id')        
        ->where(['t1.is_deleted' => 'NOT_DELETED'])
        ->get();
		return $query->result();
	}
    public function add_product_plan_type($product_id,$shop_id,$plan_ids)
	{
        if (!empty($plan_ids))
        {     
            foreach ($plan_ids as $pids) {
                $data = array(
                    'product_id' => $product_id,
                    'shop_id' => $shop_id,
                    'plan_id' => $pids,
                );
                $query = $this->db->insert('product_subscription_plan_type', $data);
            }
            return $query;
        }
	}
    public function edit_product_plan_type($product_id,$shop_id,$plan_ids)
	{
    
            //code for updating shop categories in shop_deals table
        // $all_plans  = $this->db->where(['product_id' => $product_id, 'shop_id' => $shop_id])->get('product_subscription_plan_type');
        $all_plans  = $this->subscription_model->get_all_plans($product_id,$shop_id);;

        $all_plan_type = [];
        foreach ($all_plans as $plan) {
            $all_plan_type[] = $plan->plan_id;
        }
        if (!empty($plan_ids))
        {     
            //Insert newly added plans
            foreach ($plan_ids as $pids) 
            {
                if(!in_array($pids,$all_plan_type))
                {
                    $plan_data = array(
                        'plan_id' => $pids,
                        'shop_id' => $shop_id,
                        'product_id' => $product_id
                    );
                    $this->db->insert('product_subscription_plan_type', $plan_data);
                }
            }
            // if(!empty($add_query))
            // {
            //     return $add_query;
            // }
            //Delete added plans
            foreach ($all_plan_type as $ptype) 
            {
                if(!in_array($ptype,$plan_ids))
                {
                    $delete_data = array(
                        'plan_id' => $ptype,
                        'shop_id' => $shop_id,
                        'product_id' => $product_id
                    );
                    $this->db->delete('product_subscription_plan_type',$delete_data);
                }
            }
            // if(!empty($delete_query))
            // {
            //     return $delete_query;
            // }
            return true;
        }
        
	}
    public function get_plan_data($pid,$shop_id)
    {
        $query = $this->db
        ->select('t1.*,t2.shop_name,t2.id as shop_id,t2.business_id')
        ->from('product_subscription_plan_type t1')
        ->join('shops t2', 't2.id = t1.shop_id')  
        ->where(['product_id' => $pid, 'shop_id' => $shop_id])
        ->get();
        return $query->result_array();
    }

    public function get_all_plans($product_id,$shop_id)
    {
        $query = $this->db->where(['product_id' => $product_id, 'shop_id' => $shop_id])->get('product_subscription_plan_type');
        return $query->result();
    }

    public function daily_subscription_data($shop_id,$to_date,$plan_type_id,$time_slot_id,$user_id,$product_id,$status_id,$address_id,$limit=null,$start=null)
    {
        if ($limit!=null) {
            $this->db->limit($limit, $start);
        }
        $query = $this->db
        ->select('t1.*,t1.id as sid,t2.product_code,t2.name as product_name,t2.id as product_id,t3.fname,t3.lname,t3.mobile,t3.id as customer_id,t4.plan,t5.timestart,t5.timeend,t6.shop_name,t7.subscription_id as order_sid,t7.datetime as order_date,t8.house_no,t8.address,t8.house_no,t8.pincode,t8.id as address_id,t8.contact_name as address_contact_name,t8.contact as address_contact,t8.nickname,t9.name as order_status,t9.id as status_id')
        ->from('subscriptions t1')
        ->join('products_subcategory t2', 't2.id = t1.product_id')  
        ->join('customers t3', 't3.id = t1.user_id')  
        ->join('subscriptions_plan_types t4', 't4.id = t1.plan_type_id')  
        ->join('subscriptions_slots t5', 't5.id = t1.time_slot_id')  
        ->join('shops t6', 't6.id = t1.shop_id')
        ->join('orders t7', 't7.subscription_id = t1.id','left')
        ->join('customers_address t8', 't8.id = t1.address_id')
        ->join('order_status_master t9', 't9.id = t7.status','left')
        // ->distinct('t7.subscription_id')
        ->group_by('t7.subscription_id') 
        ->where(['t1.active' => '1', 't1.shop_id' => $shop_id]);

        if ($to_date!='null') {
			$this->db->where(['DATE(t1.date) <=' => $to_date , 't1.plan_type_id' => '1']);
			// $this->db->where('DATE(t1.date) >=' , $to_date);
		}
        if ($plan_type_id!='null') {
			$this->db->where(['t4.id' => $plan_type_id]);
		}
        if ($time_slot_id!='null') {
			$this->db->where(['t5.id' => $time_slot_id]);
		}
        if ($user_id!='null') {
			$this->db->where(['t3.id' => $user_id]);
		}
        if ($product_id!='null') {
			$this->db->where(['t2.id' => $product_id]);
		}
        if ($status_id!='null') {
			$this->db->where(['t7.status' => $status_id]);
		}
        if ($address_id!='null') {
			$this->db->where(['t1.address_id' => $address_id]);
		}
        // if($limit!=null)
            return $this->db->get()->result();
        // else
        //     return $this->db->get()->num_rows();
    }
    public function order_details()
    {
        $query = $this->db
        ->select('t1.subscription_id as order_sid,t1.datetime as order_date,t1.status,t2.name as order_status,t2.id as status_id,t2.name as status_name')
        ->from('orders t1')
        ->join('order_status_master t2', 't2.id = t1.status','left')
        ->where('t1.subscription_id!=' , '0');
        return $this->db->get()->result();
    }
    public function monthly_subscription_data($shop_id,$to_date,$plan_type_id,$time_slot_id,$user_id,$product_id,$status_id,$address_id,$limit=null,$start=null)
    {
        if ($limit!=null) {
            $this->db->limit($limit, $start);
        }
        $query = $this->db
        ->select('t1.*,t1.id as sid,t2.product_code,t2.name as product_name,t2.id as product_id,t3.fname,t3.lname,t3.mobile,t3.id as customer_id,t4.plan,t5.timestart,t5.timeend,t6.shop_name,t7.subscription_id as order_sid,t7.datetime as order_date,t8.house_no,t8.address,t8.house_no,t8.pincode,t8.id as address_id,t8.contact_name as address_contact_name,t8.contact as address_contact,t8.nickname,t9.name as order_status,t9.id as status_id')
        // ->select('t1.id')
        ->from('subscriptions t1')
        ->join('products_subcategory t2', 't2.id = t1.product_id')  
        ->join('customers t3', 't3.id = t1.user_id')  
        ->join('subscriptions_plan_types t4', 't4.id = t1.plan_type_id')  
        ->join('subscriptions_slots t5', 't5.id = t1.time_slot_id')  
        ->join('shops t6', 't6.id = t1.shop_id')
        ->join('orders t7', 't7.subscription_id = t1.id','left')
        ->join('customers_address t8', 't8.id = t1.address_id')
        ->join('order_status_master t9', 't9.id = t7.status','left')
        ->group_by('t7.subscription_id') 
        ->where(['t1.active' => '1', 't1.shop_id' => $shop_id]);

        if ($to_date!='null') {
			$this->db->where(['DAY(t1.date) =' => DATE("d",strtotime($to_date)), 't1.plan_type_id' => '5']);
		}
        if ($plan_type_id!='null') {
			$this->db->where(['t4.id' => $plan_type_id]);
		}
        if ($time_slot_id!='null') {
			$this->db->where(['t5.id' => $time_slot_id]);
		}
        if ($user_id!='null') {
			$this->db->where(['t3.id' => $user_id]);
		}
        if ($product_id!='null') {
			$this->db->where(['t2.id' => $product_id]);
		}
        if ($status_id!='null') {
			$this->db->where(['t7.status' => $status_id]);
		}
        if ($address_id!='null') {
			$this->db->where(['t1.address_id' => $address_id]);
		}
        // if($limit!=null)
            return $this->db->get()->result();
        // else
        //     return $this->db->get()->num_rows();
    }
    public function onetime_subscription_data($shop_id,$to_date,$plan_type_id,$time_slot_id,$user_id,$product_id,$status_id,$address_id,$limit=null,$start=null)
    {
        if ($limit!=null) {
            $this->db->limit($limit, $start);
        }
        $query = $this->db
        ->select('t1.*,t1.id as sid,t2.product_code,t2.name as product_name,t2.id as product_id,t3.fname,t3.lname,t3.mobile,t3.id as customer_id,t4.plan,t5.timestart,t5.timeend,t6.shop_name,t7.subscription_id as order_sid,t7.datetime as order_date,t8.house_no,t8.address,t8.house_no,t8.pincode,t8.id as address_id,t8.contact_name as address_contact_name,t8.contact as address_contact,t8.nickname,t9.name as order_status,t9.id as status_id')
        // ->select('t1.id')
        ->from('subscriptions t1')
        ->join('products_subcategory t2', 't2.id = t1.product_id')  
        ->join('customers t3', 't3.id = t1.user_id')  
        ->join('subscriptions_plan_types t4', 't4.id = t1.plan_type_id')  
        ->join('subscriptions_slots t5', 't5.id = t1.time_slot_id')  
        ->join('shops t6', 't6.id = t1.shop_id')
        ->join('orders t7', 't7.subscription_id = t1.id','left')
        ->join('customers_address t8', 't8.id = t1.address_id')
        ->join('order_status_master t9', 't9.id = t7.status','left')
        ->group_by('t7.subscription_id') 
        ->where(['t1.active' => '1', 't1.shop_id' => $shop_id]);

        if ($to_date!='null') {
			$this->db->where(['DATE(t1.date) =' => $to_date , 't1.plan_type_id' => '3']);
		}
        if ($plan_type_id!='null') {
			$this->db->where(['t4.id' => $plan_type_id]);
		}
        if ($time_slot_id!='null') {
			$this->db->where(['t5.id' => $time_slot_id]);
		}
        if ($user_id!='null') {
			$this->db->where(['t3.id' => $user_id]);
		}
        if ($product_id!='null') {
			$this->db->where(['t2.id' => $product_id]);
		}
        if ($status_id!='null') {
			$this->db->where(['t7.status' => $status_id]);
		}
        if ($address_id!='null') {
			$this->db->where(['t1.address_id' => $address_id]);
		}
        // if($limit!=null)
            return $this->db->get()->result();
        // else
        //     return $this->db->get()->num_rows();
    }
    public function alternate_subscription_data($shop_id,$to_date,$plan_type_id,$time_slot_id,$user_id,$product_id,$status_id,$address_id,$limit=null,$start=null)
    {
        if ($limit!=null) {
            $this->db->limit($limit, $start);
        }
        $query = $this->db
        ->select('t1.*,t1.id as sid,t2.product_code,t2.name as product_name,t2.id as product_id,t3.fname,t3.lname,t3.mobile,t3.id as customer_id,t4.plan,t5.timestart,t5.timeend,t6.shop_name,t7.subscription_id as order_sid,t7.datetime as order_date,t8.house_no,t8.address,t8.house_no,t8.pincode,t8.id as address_id,t8.contact_name as address_contact_name,t8.contact as address_contact,t8.nickname,t9.name as order_status,t9.id as status_id')
        // ->select('DAY(t1.date) % 2 as day')
        ->from('subscriptions t1')
        ->join('products_subcategory t2', 't2.id = t1.product_id')  
        ->join('customers t3', 't3.id = t1.user_id')  
        ->join('subscriptions_plan_types t4', 't4.id = t1.plan_type_id')  
        ->join('subscriptions_slots t5', 't5.id = t1.time_slot_id')  
        ->join('shops t6', 't6.id = t1.shop_id')
        ->join('orders t7', 't7.subscription_id = t1.id','left')
        ->join('customers_address t8', 't8.id = t1.address_id')
        ->join('order_status_master t9', 't9.id = t7.status','left')
        ->group_by('t7.subscription_id') 
        ->where(['t1.active' => '1', 't1.shop_id' => $shop_id]);

        if ($to_date!='null') {
            $this->db->where(['DATE(t1.date) <=' => $to_date,'DAY(t1.date) % 2 =' => DATE("d",strtotime($to_date))%2, 't1.plan_type_id' => '2']);
        }
        if ($plan_type_id!='null') {
            $this->db->where(['t4.id' => $plan_type_id]);
        }
        if ($time_slot_id!='null') {
            $this->db->where(['t5.id' => $time_slot_id]);
        }
        if ($user_id!='null') {
            $this->db->where(['t3.id' => $user_id]);
        }
        if ($product_id!='null') {
			$this->db->where(['t2.id' => $product_id]);
		}
        if ($status_id!='null') {
			$this->db->where(['t7.status' => $status_id]);
		}
        if ($address_id!='null') {
			$this->db->where(['t1.address_id' => $address_id]);
		}
        // if($limit!=null)
            return $this->db->get()->result();
        // else
        //     return $this->db->get()->num_rows();
    }
    public function custom_subscription_data($shop_id,$to_date,$plan_type_id,$time_slot_id,$user_id,$product_id,$status_id,$address_id,$limit=null,$start=null)
    {
        if ($limit!=null) {
            $this->db->limit($limit, $start);
        }
        $query = $this->db
        ->select('t1.*,t1.id as sid,t2.product_code,t2.name as product_name,t2.id as product_id,t3.fname,t3.lname,t3.mobile,t3.id as customer_id,t4.plan,t5.timestart,t5.timeend,t6.shop_name,t7.subscription_id as order_sid,t7.datetime as order_date,t8.house_no,t8.address,t8.house_no,t8.pincode,t8.id as address_id,t8.contact_name as address_contact_name,t8.contact as address_contact,t8.nickname,t9.name as order_status,t9.id as status_id')
        ->from('subscriptions t1')
        ->join('products_subcategory t2', 't2.id = t1.product_id')  
        ->join('customers t3', 't3.id = t1.user_id')  
        ->join('subscriptions_plan_types t4', 't4.id = t1.plan_type_id')  
        ->join('subscriptions_slots t5', 't5.id = t1.time_slot_id')  
        ->join('shops t6', 't6.id = t1.shop_id')
        ->join('orders t7', 't7.subscription_id = t1.id','left')
        ->join('customers_address t8', 't8.id = t1.address_id')
        ->join('order_status_master t9', 't9.id = t7.status','left')
        ->group_by('t7.subscription_id') 
        ->where(['t1.active' => '1', 't1.shop_id' => $shop_id]);

        if ($to_date!='null') {
			$this->db->where(['DATE(t1.date) <=' => $to_date, 't1.plan_type_id' => '4','t1.'.strtolower(DATE("D",strtotime($to_date))) =>'1']);
		}
        if ($plan_type_id!='null') {
			$this->db->where(['t4.id' => $plan_type_id]);
		}
        if ($time_slot_id!='null') {
			$this->db->where(['t5.id' => $time_slot_id]);
		}
        if ($user_id!='null') {
			$this->db->where(['t3.id' => $user_id]);
		}
        if ($product_id!='null') {
			$this->db->where(['t2.id' => $product_id]);
		}
        if ($status_id!='null') {
			$this->db->where(['t7.status' => $status_id]);
		}
        if ($address_id!='null') {
			$this->db->where(['t1.address_id' => $address_id]);
		}
        // if($limit!=null)
            return $this->db->get()->result();
        // else
        //     return $this->db->get()->num_rows();
    }
    public function calculate_daily_subscription_data($shop_id,$to_date,$plan_type_id,$time_slot_id,$user_id,$product_id,$status_id,$address_id)
    {
        $query = $this->db
        ->select('sum(DISTINCT(t1.qty)) as total_quantity')
        // ->select('t1.strtolower(DATE("D",strtotime(01-02-2022))) as day')
        ->from('subscriptions t1')
        ->join('products_subcategory t2', 't2.id = t1.product_id')  
        ->join('customers t3', 't3.id = t1.user_id')  
        ->join('subscriptions_plan_types t4', 't4.id = t1.plan_type_id')  
        ->join('subscriptions_slots t5', 't5.id = t1.time_slot_id')  
        ->join('shops t6', 't6.id = t1.shop_id')
        ->join('orders t7', 't7.subscription_id = t1.id','left')
        ->join('customers_address t8', 't8.id = t1.address_id')
        ->join('order_status_master t9', 't9.id = t7.status','left')
        ->where(['t1.active' => '1', 't1.shop_id' => $shop_id]);

        if ($to_date!='null') {
			$this->db->where(['DATE(t1.date) <=' => $to_date , 't1.plan_type_id' => '1']);
		}
        if ($plan_type_id!='null') {
			$this->db->where(['t4.id' => $plan_type_id]);
		}
        if ($time_slot_id!='null') {
			$this->db->where(['t5.id' => $time_slot_id]);
		}
        if ($user_id!='null') {
			$this->db->where(['t3.id' => $user_id]);
		}
        if ($product_id!='null') {
			$this->db->where(['t2.id' => $product_id]);
		}
        if ($status_id!='null') {
			$this->db->where(['t7.status' => $status_id]);
		}
        if ($address_id!='null') {
			$this->db->where(['t1.address_id' => $address_id]);
		}
        return $this->db->get()->row();
    }
    public function calculate_monthly_subscription_data($shop_id,$to_date,$plan_type_id,$time_slot_id,$user_id,$product_id,$status_id,$address_id)
    {
        $query = $this->db
        ->select('sum(DISTINCT(t1.qty)) as total_quantity')
        ->from('subscriptions t1')
        ->join('products_subcategory t2', 't2.id = t1.product_id')  
        ->join('customers t3', 't3.id = t1.user_id')  
        ->join('subscriptions_plan_types t4', 't4.id = t1.plan_type_id')  
        ->join('subscriptions_slots t5', 't5.id = t1.time_slot_id')  
        ->join('shops t6', 't6.id = t1.shop_id')
        ->join('orders t7', 't7.subscription_id = t1.id','left')
        ->join('customers_address t8', 't8.id = t1.address_id')
        ->join('order_status_master t9', 't9.id = t7.status','left')
        ->where(['t1.active' => '1', 't1.shop_id' => $shop_id]);

        if ($to_date!='null') {
			$this->db->where(['DAY(t1.date) =' => DATE("d",strtotime($to_date)), 't1.plan_type_id' => '5']);
		}
        if ($plan_type_id!='null') {
			$this->db->where(['t4.id' => $plan_type_id]);
		}
        if ($time_slot_id!='null') {
			$this->db->where(['t5.id' => $time_slot_id]);
		}
        if ($user_id!='null') {
			$this->db->where(['t3.id' => $user_id]);
		}
        if ($product_id!='null') {
			$this->db->where(['t2.id' => $product_id]);
		}
        if ($status_id!='null') {
			$this->db->where(['t7.status' => $status_id]);
		}
        if ($address_id!='null') {
			$this->db->where(['t1.address_id' => $address_id]);
		}
        return $this->db->get()->row();
    }
    public function calculate_onetime_subscription_data($shop_id,$to_date,$plan_type_id,$time_slot_id,$user_id,$product_id,$status_id,$address_id)
    {
        $query = $this->db
        ->select('sum(DISTINCT(t1.qty)) as total_quantity')
        ->from('subscriptions t1')
        ->join('products_subcategory t2', 't2.id = t1.product_id')  
        ->join('customers t3', 't3.id = t1.user_id')  
        ->join('subscriptions_plan_types t4', 't4.id = t1.plan_type_id')  
        ->join('subscriptions_slots t5', 't5.id = t1.time_slot_id')  
        ->join('shops t6', 't6.id = t1.shop_id')
        ->join('orders t7', 't7.subscription_id = t1.id','left')
        ->join('customers_address t8', 't8.id = t1.address_id')
        ->join('order_status_master t9', 't9.id = t7.status','left')
        ->where(['t1.active' => '1', 't1.shop_id' => $shop_id]);

        if ($to_date!='null') {
			$this->db->where(['DATE(t1.date) =' => $to_date , 't1.plan_type_id' => '3']);
		}
        if ($plan_type_id!='null') {
			$this->db->where(['t4.id' => $plan_type_id]);
		}
        if ($time_slot_id!='null') {
			$this->db->where(['t5.id' => $time_slot_id]);
		}
        if ($user_id!='null') {
			$this->db->where(['t3.id' => $user_id]);
		}
        if ($product_id!='null') {
			$this->db->where(['t2.id' => $product_id]);
		}
        if ($status_id!='null') {
			$this->db->where(['t7.status' => $status_id]);
		}
        if ($address_id!='null') {
			$this->db->where(['t1.address_id' => $address_id]);
		}
        return $this->db->get()->row();
    }
    public function calculate_alternate_subscription_data($shop_id,$to_date,$plan_type_id,$time_slot_id,$user_id,$product_id,$status_id,$address_id)
    {
        $query = $this->db
        ->select('sum(DISTINCT(t1.qty)) as total_quantity')
        ->from('subscriptions t1')
        ->join('products_subcategory t2', 't2.id = t1.product_id')  
        ->join('customers t3', 't3.id = t1.user_id')  
        ->join('subscriptions_plan_types t4', 't4.id = t1.plan_type_id')  
        ->join('subscriptions_slots t5', 't5.id = t1.time_slot_id')  
        ->join('shops t6', 't6.id = t1.shop_id')
        ->join('orders t7', 't7.subscription_id = t1.id','left')
        ->join('customers_address t8', 't8.id = t1.address_id')
        ->join('order_status_master t9', 't9.id = t7.status','left')
        ->where(['t1.active' => '1', 't1.shop_id' => $shop_id]);

        if ($to_date!='null') {
			$this->db->where(['DATE(t1.date) <=' => $to_date,'DAY(t1.date) % 2 =' => DATE("d",strtotime($to_date))%2, 't1.plan_type_id' => '2']);
		}
        if ($plan_type_id!='null') {
			$this->db->where(['t4.id' => $plan_type_id]);
		}
        if ($time_slot_id!='null') {
			$this->db->where(['t5.id' => $time_slot_id]);
		}
        if ($user_id!='null') {
			$this->db->where(['t3.id' => $user_id]);
		}
        if ($product_id!='null') {
			$this->db->where(['t2.id' => $product_id]);
		}
        if ($status_id!='null') {
			$this->db->where(['t7.status' => $status_id]);
		}
        if ($address_id!='null') {
			$this->db->where(['t1.address_id' => $address_id]);
		}
        return $this->db->get()->row();
    }
    public function calculate_custom_subscription_data($shop_id,$to_date,$plan_type_id,$time_slot_id,$user_id,$product_id,$status_id,$address_id)
    {
        $query = $this->db
        ->select('sum(DISTINCT(t1.qty)) as total_quantity')
        // ->select('t1.strtolower(DATE("D",strtotime(01-02-2022))) as day')
        ->from('subscriptions t1')
        ->join('products_subcategory t2', 't2.id = t1.product_id')  
        ->join('customers t3', 't3.id = t1.user_id')  
        ->join('subscriptions_plan_types t4', 't4.id = t1.plan_type_id')  
        ->join('subscriptions_slots t5', 't5.id = t1.time_slot_id')  
        ->join('shops t6', 't6.id = t1.shop_id')
        ->join('orders t7', 't7.subscription_id = t1.id','left')
        ->join('customers_address t8', 't8.id = t1.address_id')
        ->join('order_status_master t9', 't9.id = t7.status','left')
        ->where(['t1.active' => '1', 't1.shop_id' => $shop_id]);

        if ($to_date!='null') {
			$this->db->where(['DATE(t1.date) <=' => $to_date, 't1.plan_type_id' => '4','t1.'.strtolower(DATE("D",strtotime($to_date))) =>'1']);
		}
        if ($plan_type_id!='null') {
			$this->db->where(['t4.id' => $plan_type_id]);
		}
        if ($time_slot_id!='null') {
			$this->db->where(['t5.id' => $time_slot_id]);
		}
        if ($user_id!='null') {
			$this->db->where(['t3.id' => $user_id]);
		}
        if ($product_id!='null') {
			$this->db->where(['t2.id' => $product_id]);
		}
        if ($status_id!='null') {
			$this->db->where(['t7.status' => $status_id]);
		}
        if ($address_id!='null') {
			$this->db->where(['t1.address_id' => $address_id]);
		}
        return $this->db->get()->row();
    }


    public function get_delivery_slots($shop_id)
	{
		$query = $this->db->get_where('subscriptions_slots', ['shop_id' => $shop_id, 'active' => '1']);
		return $query->result();
	}
    	//product details for cart items
	public function product_details($pid)
	{
		$query = $this->db
        ->select('t1.selling_rate,t1.mrp,t1.tax_value,t2.name as product_name,t2.rating,t3.img,t4.offer_upto,t4.discount_type')
        ->from('shops_inventory t1')      
        ->join('products_subcategory t2', 't2.id = t1.product_id','left')        
		->join('products_photo t3', 't3.item_id = t2.id','left')  
        ->join('shops_coupons_offers t4', 't2.id=t4.product_id','left')
        // ->join('cart t5', 't2.id=t5.product_id','left')
        ->where(['t1.is_deleted' => 'NOT_DELETED','t3.is_cover' =>'1','t1.product_id' =>$pid])  
		->get();   
		return $query->row();
	}
    public function get_ordered_product_detail($pid)
    {
        $query = $this->db
        ->select('t1.*,t2.offer_upto,t2.discount_type')
        ->from('shops_inventory t1')
        ->join('shops_coupons_offers t2', 't2.shop_id = t1.shop_id AND t2.product_id =t1.product_id','left')    
        ->where(['t1.product_id'=>$pid])  
		->get();   
		return $query->row();
    }
    public function get_subscription_data($sid)
    {
        $query = $this->db
        ->select('t1.*,t2.timestart,t2.timeend,t2.id as slot_id')
        ->from('subscriptions t1')
        ->join('subscriptions_slots t2', 't2.id = t1.time_slot_id')    
        ->where(['t1.id'=>$sid])  
		->get();   
		return $query->row();
    }
    public function update_order_status($date,$sid,$data)
	{
		return $this->db->where(['subscription_id'=>$sid,'datetime'=>$date])->update('orders', $data);
	}
}
?>