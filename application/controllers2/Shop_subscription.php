<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
class Shop_subscription extends CI_Controller {

	public function __construct()
    {
        parent::__construct();

        $this->isLoggedIn();
        $this->check_role_menu();
    }

    public function isLoggedIn(){
        $is_logged_in = $this->session->userdata('shop_logged_in');
        if(!isset($is_logged_in) || $is_logged_in!==TRUE)
        {
            redirect(base_url());
            exit;
        }
    } 
    public function check_role_menu(){
        $shop_role_id = $_SESSION['shop_role_id'];
        $uri = $this->uri->segment(1);
        $role_menus = $this->admin_model->all_role_menu_data($shop_role_id);
        $url_array = array();
        if(!empty($role_menus))
        {
            foreach($role_menus as $menus)
            {
                array_push($url_array,$menus->url);
            }
            if(!in_array($uri,$url_array))
            {
                redirect(base_url());
            }
        }
        else
        {
            redirect(base_url());
            exit;
        }      
    } 
    public function header_and_footer($page, $data)
    {
        $shop_id     = $_SESSION['user_data']['id'];
        $shop_role_id     = $_SESSION['user_data']['role_id'];
        $data['shop_menus'] = $this->admin_model->get_role_menu_data($shop_role_id);
        $data['all_menus'] = $this->admin_model->get_data1('tb_admin_menu','status','1');
		$shop_details = $this->shops_model->get_shop_data($shop_id);
        $template_data = array(
        'menu'=> $this->load->view('template/menu',$data,TRUE),
        'main_body_data'=> $this->load->view($page,$data,TRUE),
        'shop_photo'=>$shop_details->logo
        );
            $this->load->view('template/main_template',$template_data);
    }

    public function subscription_data($action=null,$p1=null,$p2=null,$p3=null,$p4=null,$p5=null,$p6=null,$p7=null)
    {
        switch ($action) {
            case null:
                $data['title']          = 'Subscriptions';
                $data['tb_url']         = base_url().'subscriptions/tb';
                $page                   = 'shop/subscription/index';
                $this->header_and_footer($page, $data);
                break;

                case 'tb':
                    $data['to_date'] = '';
                    $to_date='null';
                    $plan_type_id='null';
                    $data['plan_type_id']='null';
                    $time_slot_id='null';
                    $data['time_slot_id']='null';
                    $user_id='null';
                    $data['user_id']='null';
                    $product_id='null';
                    $data['product_id']='null';
                    $status_id='null';
                    $data['status_id']='null';
                    $address_id='null';
                    $data['address_id']='null';
                    //get section intiliazation
                    if (@$_POST['to_date']) {
                        $data['to_date'] = $_POST['to_date'];
                        $to_date = $_POST['to_date'];
                    }
                    if (@$_POST['plan_type_id']) {
                        $data['plan_type_id'] = $_POST['plan_type_id'];
                        $plan_type_id = $_POST['plan_type_id'];
                    }
                    if (@$_POST['time_slot_id']) {
                        $data['time_slot_id'] = $_POST['time_slot_id'];
                        $time_slot_id = $_POST['time_slot_id'];
                    }
                    if (@$_POST['user_id']) {
                        $data['user_id'] = $_POST['user_id'];
                        $user_id = $_POST['user_id'];
                    }
                    if (@$_POST['product_id']) {
                        $data['product_id'] = $_POST['product_id'];
                        $product_id = $_POST['product_id'];
                    }
                    if (@$_POST['status_id']) {
                        $data['status_id'] = $_POST['status_id'];
                        $status_id = $_POST['status_id'];
                    }
                    if (@$_POST['address_id']) {
                        $data['address_id'] = $_POST['address_id'];
                        $address_id = $_POST['address_id'];
                    }
             
                    $this->load->library('pagination');
                    $config = array();
                    $all_subscriptions_data = array();
                    $all_subscriptions_result = array();
                    $shop_id = $_SESSION['user_data']['id'];
                    $config["base_url"]         = base_url()."subscriptions/tb/";
                    $config["total_rows"]       = count($this->subscription_model->daily_subscription_data($shop_id,$to_date,$plan_type_id,$time_slot_id,$user_id,$product_id,$status_id,$address_id));
                    $data['total_rows']         = $config["total_rows"];
                    $config["per_page"]         = 10;
                    $config["uri_segment"]      = 6;
                    $config['attributes']       = array('class' => 'pag-link');
                    $config['full_tag_open']    = "<div class='pag'>";
                    $config['full_tag_close']   = "</div>";
                    $config['first_link']       = '&lt;&lt;';
                    $config['last_link']        = '&gt;&gt;';
                    $this->pagination->initialize($config);
                    $data["links"]              = $this->pagination->create_links();
                    $data['page']               = $page = ($p4!=null) ? $p4 : 0;
                    $data['per_page']           = $config["per_page"];
                    $data['plan_types'] = $this->subscription_model->get_data1('subscriptions_plan_types','active','1');
                    $data['delivery_slots'] = $this->subscription_model->get_delivery_slots($shop_id);
                    $data['update_status_url']         = base_url().'subscriptions/order_status/';
                    $data['order_status'] = $this->master_model->get_data1('order_status_master','active','1');
                    $data['all_subs'] = $this->master_model->get_data1('subscriptions','active','1');
                    $data['vacations'] = $this->master_model->view_data1('vacations');
                    // $data['subscriptions']           = $this->subscription_model->daily_subscription_data($shop_id,$to_date,$config["per_page"],$page);
                    $daily_subscriptions           = $this->subscription_model->daily_subscription_data($shop_id,$to_date,$plan_type_id,$time_slot_id,$user_id,$product_id,$status_id,$address_id,$config["per_page"],$page);
                    $monthly_subscriptions           = $this->subscription_model->monthly_subscription_data($shop_id,$to_date,$plan_type_id,$time_slot_id,$user_id,$product_id,$status_id,$address_id,$config["per_page"],$page);
                    $onetime_subscriptions           = $this->subscription_model->onetime_subscription_data($shop_id,$to_date,$plan_type_id,$time_slot_id,$user_id,$product_id,$status_id,$address_id,$config["per_page"],$page);
                    $alternate_subscriptions           = $this->subscription_model->alternate_subscription_data($shop_id,$to_date,$plan_type_id,$time_slot_id,$user_id,$product_id,$status_id,$address_id,$config["per_page"],$page);
                    $custom_subscriptions           = $this->subscription_model->custom_subscription_data($shop_id,$to_date,$plan_type_id,$time_slot_id,$user_id,$product_id,$status_id,$address_id,$config["per_page"],$page);

                    //calculate subscription result
                    $daily_subscription_result = $this->subscription_model->calculate_daily_subscription_data($shop_id,$to_date,$plan_type_id,$time_slot_id,$user_id,$product_id,$status_id,$address_id);
                    $monthly_subscription_result = $this->subscription_model->calculate_monthly_subscription_data($shop_id,$to_date,$plan_type_id,$time_slot_id,$user_id,$product_id,$status_id,$address_id);
                    $onetime_subscription_result = $this->subscription_model->calculate_onetime_subscription_data($shop_id,$to_date,$plan_type_id,$time_slot_id,$user_id,$product_id,$status_id,$address_id);
                    $alternate_subscription_result = $this->subscription_model->calculate_alternate_subscription_data($shop_id,$to_date,$plan_type_id,$time_slot_id,$user_id,$product_id,$status_id,$address_id);
                    $custom_subscription_result = $this->subscription_model->calculate_custom_subscription_data($shop_id,$to_date,$plan_type_id,$time_slot_id,$user_id,$product_id,$status_id,$address_id);
                    $data['order_details'] = $this->subscription_model->order_details();
                    // print_r($daily_subscriptions);
                    if(!empty($daily_subscription_result))
                    {
                        array_push($all_subscriptions_result,$daily_subscription_result);
                    }
                    if(!empty($monthly_subscription_result))
                    {
                        array_push($all_subscriptions_result,$monthly_subscription_result);
                    }
                    if(!empty($onetime_subscription_result))
                    {
                        array_push($all_subscriptions_result,$onetime_subscription_result);
                    }
                    if(!empty($alternate_subscription_result))
                    {
                        array_push($all_subscriptions_result,$alternate_subscription_result);
                    }
                    if(!empty($custom_subscription_result))
                    {
                        array_push($all_subscriptions_result,$custom_subscription_result);
                    }
                    $total_quantity = 0;
                    foreach($all_subscriptions_result as $result)
                    {
                        $total_quantity = $total_quantity +$result->total_quantity;
                    }
                    $data['total_quantity'] = $total_quantity;
                    if(!empty($daily_subscriptions))
                    {
                        array_push($all_subscriptions_data,$daily_subscriptions);
                    }
                    if(!empty($monthly_subscriptions))
                    {
                        array_push($all_subscriptions_data,$monthly_subscriptions);
                    }
                    if(!empty($onetime_subscriptions))
                    {
                        array_push($all_subscriptions_data,$onetime_subscriptions);
                    }
                    if(!empty($alternate_subscriptions))
                    {
                        array_push($all_subscriptions_data,$alternate_subscriptions);
                    }
                    if(!empty($custom_subscriptions))
                    {
                        array_push($all_subscriptions_data,$custom_subscriptions);
                    }
                    $data['subscriptions'] = $all_subscriptions_data;
                   
                    $page                       = 'shop/subscription/tb';
                    $this->load->view($page, $data);
                    break;
                    case 'order_status':
                        $data['sid'] = $p1;
                        $data['order_status_id'] = $p2;
                        
                        $data['orderStatus'] = $this->subscription_model->get_data1('order_status_master','active','1');
                        $page                       = 'shop/subscription/order_status';
                        
                       
                        $this->load->view($page, $data);
                        break;
                    case 'update_order_status':
                        $sid = $this->input->post('sid');
                        $order_status_id = $this->input->post('order_status_id');
                        $update_data['status'] = $order_status_id;
                        $date = $_POST['to_date'];
                        $updated_status = $this->subscription_model->get_row_data1('order_status_master','id',$order_status_id);
                        if ($this->subscription_model->update_order_status($date,$sid,$update_data)) {
                            // // echo $updated_status->name;
                            // $data['sid'] = $sid;
                            // $data['status_id'] = $status_id;
                            // // $data['order_status'] = $updated_status->name;
                            // $data['update_status_url']         = base_url().'subscriptions/order_status/';
                            // $page                       = 'shop/subscription/tb_action';
                            // $this->load->view($page, $data);








                            $data['to_date'] = '';
                            $to_date='null';
                            $plan_type_id='null';
                            $data['plan_type_id']='null';
                            $time_slot_id='null';
                            $data['time_slot_id']='null';
                            $user_id='null';
                            $data['user_id']='null';
                            $product_id='null';
                            $data['product_id']='null';
                            $status_id='null';
                            $data['status_id']='null';
                            $address_id='null';
                            $data['address_id']='null';
                            //get section intiliazation
                            if (@$_POST['to_date']) {
                                $data['to_date'] = $_POST['to_date'];
                                $to_date = $_POST['to_date'];
                            }
                            if (@$_POST['plan_type_id']) {
                                $data['plan_type_id'] = $_POST['plan_type_id'];
                                $plan_type_id = $_POST['plan_type_id'];
                            }
                            if (@$_POST['time_slot_id']) {
                                $data['time_slot_id'] = $_POST['time_slot_id'];
                                $time_slot_id = $_POST['time_slot_id'];
                            }
                            if (@$_POST['user_id']) {
                                $data['user_id'] = $_POST['user_id'];
                                $user_id = $_POST['user_id'];
                            }
                            if (@$_POST['product_id']) {
                                $data['product_id'] = $_POST['product_id'];
                                $product_id = $_POST['product_id'];
                            }
                            if (@$_POST['status_id']) {
                                $data['status_id'] = $_POST['status_id'];
                                $status_id = $_POST['status_id'];
                            }
                            if (@$_POST['address_id']) {
                                $data['address_id'] = $_POST['address_id'];
                                $address_id = $_POST['address_id'];
                            }
                     
                            $this->load->library('pagination');
                            $config = array();
                            $all_subscriptions_data = array();
                            $all_subscriptions_result = array();
                            $shop_id = $_SESSION['user_data']['id'];
                            $config["base_url"]         = base_url()."subscriptions/tb/";
                            $config["total_rows"]       = count($this->subscription_model->daily_subscription_data($shop_id,$to_date,$plan_type_id,$time_slot_id,$user_id,$product_id,$status_id,$address_id));
                            $data['total_rows']         = $config["total_rows"];
                            $config["per_page"]         = 10;
                            $config["uri_segment"]      = 6;
                            $config['attributes']       = array('class' => 'pag-link');
                            $config['full_tag_open']    = "<div class='pag'>";
                            $config['full_tag_close']   = "</div>";
                            $config['first_link']       = '&lt;&lt;';
                            $config['last_link']        = '&gt;&gt;';
                            $this->pagination->initialize($config);
                            $data["links"]              = $this->pagination->create_links();
                            $data['page']               = $page = ($p4!=null) ? $p4 : 0;
                            $data['per_page']           = $config["per_page"];
                            $data['plan_types'] = $this->subscription_model->get_data1('subscriptions_plan_types','active','1');
                            $data['delivery_slots'] = $this->subscription_model->get_delivery_slots($shop_id);
                            $data['update_status_url']         = base_url().'subscriptions/order_status/';
                            $data['order_status'] = $this->master_model->get_data1('order_status_master','active','1');
                            $data['all_subs'] = $this->master_model->get_data1('subscriptions','active','1');
                            $data['vacations'] = $this->master_model->view_data1('vacations');
                            // $data['subscriptions']           = $this->subscription_model->daily_subscription_data($shop_id,$to_date,$config["per_page"],$page);
                            $daily_subscriptions           = $this->subscription_model->daily_subscription_data($shop_id,$to_date,$plan_type_id,$time_slot_id,$user_id,$product_id,$status_id,$address_id,$config["per_page"],$page);
                            $monthly_subscriptions           = $this->subscription_model->monthly_subscription_data($shop_id,$to_date,$plan_type_id,$time_slot_id,$user_id,$product_id,$status_id,$address_id,$config["per_page"],$page);
                            $onetime_subscriptions           = $this->subscription_model->onetime_subscription_data($shop_id,$to_date,$plan_type_id,$time_slot_id,$user_id,$product_id,$status_id,$address_id,$config["per_page"],$page);
                            $alternate_subscriptions           = $this->subscription_model->alternate_subscription_data($shop_id,$to_date,$plan_type_id,$time_slot_id,$user_id,$product_id,$status_id,$address_id,$config["per_page"],$page);
                            $custom_subscriptions           = $this->subscription_model->custom_subscription_data($shop_id,$to_date,$plan_type_id,$time_slot_id,$user_id,$product_id,$status_id,$address_id,$config["per_page"],$page);
        
                            //calculate subscription result
                            $daily_subscription_result = $this->subscription_model->calculate_daily_subscription_data($shop_id,$to_date,$plan_type_id,$time_slot_id,$user_id,$product_id,$status_id,$address_id);
                            $monthly_subscription_result = $this->subscription_model->calculate_monthly_subscription_data($shop_id,$to_date,$plan_type_id,$time_slot_id,$user_id,$product_id,$status_id,$address_id);
                            $onetime_subscription_result = $this->subscription_model->calculate_onetime_subscription_data($shop_id,$to_date,$plan_type_id,$time_slot_id,$user_id,$product_id,$status_id,$address_id);
                            $alternate_subscription_result = $this->subscription_model->calculate_alternate_subscription_data($shop_id,$to_date,$plan_type_id,$time_slot_id,$user_id,$product_id,$status_id,$address_id);
                            $custom_subscription_result = $this->subscription_model->calculate_custom_subscription_data($shop_id,$to_date,$plan_type_id,$time_slot_id,$user_id,$product_id,$status_id,$address_id);
                            $data['order_details'] = $this->subscription_model->order_details();
                            // print_r($daily_subscriptions);
                            if(!empty($daily_subscription_result))
                            {
                                array_push($all_subscriptions_result,$daily_subscription_result);
                            }
                            if(!empty($monthly_subscription_result))
                            {
                                array_push($all_subscriptions_result,$monthly_subscription_result);
                            }
                            if(!empty($onetime_subscription_result))
                            {
                                array_push($all_subscriptions_result,$onetime_subscription_result);
                            }
                            if(!empty($alternate_subscription_result))
                            {
                                array_push($all_subscriptions_result,$alternate_subscription_result);
                            }
                            if(!empty($custom_subscription_result))
                            {
                                array_push($all_subscriptions_result,$custom_subscription_result);
                            }
                            $total_quantity = 0;
                            foreach($all_subscriptions_result as $result)
                            {
                                $total_quantity = $total_quantity +$result->total_quantity;
                            }
                            $data['total_quantity'] = $total_quantity;
                            if(!empty($daily_subscriptions))
                            {
                                array_push($all_subscriptions_data,$daily_subscriptions);
                            }
                            if(!empty($monthly_subscriptions))
                            {
                                array_push($all_subscriptions_data,$monthly_subscriptions);
                            }
                            if(!empty($onetime_subscriptions))
                            {
                                array_push($all_subscriptions_data,$onetime_subscriptions);
                            }
                            if(!empty($alternate_subscriptions))
                            {
                                array_push($all_subscriptions_data,$alternate_subscriptions);
                            }
                            if(!empty($custom_subscriptions))
                            {
                                array_push($all_subscriptions_data,$custom_subscriptions);
                            }
                            $data['subscriptions'] = $all_subscriptions_data;
                           
                            $page                       = 'shop/subscription/tb';
                            $this->load->view($page, $data);








                            
                        }
                        break;
                        case 'export_to_excel':
                            $shop_id = $_SESSION['user_data']['id'];
                            $all_subscriptions_data = array();
                            $daily_subscriptions           = $this->subscription_model->daily_subscription_data($shop_id,$p1,$p2,$p3,$p4,$p5,$p6,$p7);
                            $monthly_subscriptions           = $this->subscription_model->monthly_subscription_data($shop_id,$p1,$p2,$p3,$p4,$p5,$p6,$p7);
                            $onetime_subscriptions           = $this->subscription_model->onetime_subscription_data($shop_id,$p1,$p2,$p3,$p4,$p5,$p6,$p7);
                            $alternate_subscriptions           = $this->subscription_model->alternate_subscription_data($shop_id,$p1,$p2,$p3,$p4,$p5,$p6,$p7);
                            $custom_subscriptions           = $this->subscription_model->custom_subscription_data($shop_id,$p1,$p2,$p3,$p4,$p5,$p6,$p7);


                            if(!empty($daily_subscriptions))
                            {
                                array_push($all_subscriptions_data,$daily_subscriptions);
                            }
                            if(!empty($monthly_subscriptions))
                            {
                                array_push($all_subscriptions_data,$monthly_subscriptions);
                            }
                            if(!empty($onetime_subscriptions))
                            {
                                array_push($all_subscriptions_data,$onetime_subscriptions);
                            }
                            if(!empty($alternate_subscriptions))
                            {
                                array_push($all_subscriptions_data,$alternate_subscriptions);
                            }
                            if(!empty($custom_subscriptions))
                            {
                                array_push($all_subscriptions_data,$custom_subscriptions);
                            }
                            // print_r($all_subscriptions_data);
                            // die();
        
                            $spreadsheet = new Spreadsheet();
                            $sheet = $spreadsheet->getActiveSheet();
                            $sheet->setCellValue('A1', 'S.No.');
                            $sheet->setCellValue('B1', 'Customer name/number');
                            $sheet->setCellValue('C1', 'Address');
                            $sheet->setCellValue('D1', 'Product Name');
                            $sheet->setCellValue('E1', 'Quantity');
                            $sheet->setCellValue('F1', 'Delivery Slot');
                            $sheet->setCellValue('G1', 'Plan type');
                            $sheet->setCellValue('H1', 'Order Status');
                            $count = 2;$i=1;
                            foreach($all_subscriptions_data as $subscription){
                            foreach($subscription as $value){
        
                                $sheet->setCellValue('A'.$count, $i++);
                                $sheet->setCellValue('B'.$count, $value->fname .' '.$value->lname.'('.$value->mobile.')');
                                $sheet->setCellValue('C'.$count, $value->house_no.','.$value->address.','.$value->pincode);
                                $sheet->setCellValue('D'.$count, $value->product_name);
                                $sheet->setCellValue('E'.$count, $value->qty);
                                $sheet->setCellValue('F'.$count, date('h:i a',strtotime($value->timestart)).'-'.date('h:i a',strtotime($value->timeend)));
                                $sheet->setCellValue('G'.$count, $value->plan);
                                $sheet->setCellValue('H'.$count, $value->order_status);
                                $count++;
                            }
                         }
                            
                            $writer = new Xlsx($spreadsheet);
                            $filename = 'Subscription Data';
                            header('Content-Type: application/vnd.ms-excel');
                            header('Content-Disposition: attachment;filename="'. $filename .'.xls"');
                            header('Cache-Control: max-age=0');
                            $writer->save('php://output'); // download file
                            break;
                            case 'create_subscription_order':
                                $sid = $this->input->post('sid');
                                $status_id = $this->input->post('status_id');
                                $subtotal=0;
                                $subscription_data = $this->subscription_model->get_subscription_data($sid);
                                $product_id = $subscription_data->product_id;
                                $subscription_items = $this->subscription_model->product_details($product_id);
                                //calculate selling rate
                                if($subscription_items->discount_type=='0') //0->rupee
                                {
                                    $selling_rate = ($subscription_data->qty*$subscription_items->selling_rate) - $subscription_items->offer_upto;
                                }
                                else if($subscription_items->discount_type=='1') //1->%
                                {
                                    $selling_per = ($subscription_data->qty*$subscription_items->selling_rate * $subscription_items->offer_upto)/100;
                                    $selling_rate = ($subscription_data->qty*$subscription_items->selling_rate) - $selling_per;
                                }
                                else
                                {
                                    $selling_rate = $subscription_data->qty*$subscription_items->selling_rate;
                                }
                                //end of calculate selling rate
                                $subtotal = $subtotal + ($selling_rate);
                                $product_detail = $this->subscription_model->get_ordered_product_detail($product_id);
                                $cutting_price = $subscription_data->qty *$subscription_items->mrp;
                                $savings = $cutting_price - $subtotal;
                                $inclusive_tax = $subtotal - ($subtotal * (100/ (100 + $product_detail->tax_value)));
                                
                                $orders_data = array(
                                    'orderid'    => '',
                                    'shop_id'    => $subscription_data->shop_id,
                                    'user_id'    => $subscription_data->user_id,
                                    'status'    => '17',
                                    'total_value'    => $subtotal,
                                    'total_savings' => $savings,
                                    'tax' => round($inclusive_tax,2),
                                    'subscription_id' => $sid,
                                    'datetime' => $this->input->post('selected_date'),
                                    'address_id' => $subscription_data->address_id,
                                    'time_slot_id' => $subscription_data->time_slot_id,
                                    'timeslot_starttime' => $subscription_data->timestart,
                                    'timeslot_endtime' => $subscription_data->timeend,
                                );
                                $this->db->insert('orders', $orders_data);
                                $insert_id = $this->db->insert_id();
                                $date = strtotime("now");
                                $mon=date('M', $date);
                                //generate unique orderid 
                                $num_padded = sprintf("%05d", $insert_id);
                                $code="CK".strtoupper($mon).$num_padded;
                                $oid['orderid'] = $code;
                                $this->subscription_model->update_data('orders','id',$insert_id,$oid);
                                $item_data = array(
                                    'product_id' => $product_id,
                                    'qty' => $subscription_data->qty,
                                    'order_id' => $insert_id,
                                    'price_per_unit' => $product_detail->selling_rate,
                                    'purchase_rate' => $product_detail->purchase_rate,
                                    'mrp' => $product_detail->mrp   ,
                                    'total_price' => $product_detail->selling_rate*$subscription_data->qty  ,
                                    'tax_value' => $product_detail->tax_value,
                                    'offer_applied' => $product_detail->offer_upto,
                                    // 'discount_type' => $product_detail->discount_type,
                                );
                                // print_r($item_data);
                                if($this->db->insert('order_items', $item_data))
                                {
                                    $data['sid'] = $sid;
                                    $data['status_id'] = '17';
                                    $data['update_status_url']         = base_url().'subscriptions/order_status/';
                                    $page                       = 'shop/subscription/tb_action';
                                    $this->load->view($page, $data);
                                }
                                break;

                                        default:
                                        # code...
                                        break;
                                }
    }

}

?>