<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pos_orders extends CI_Controller {
	public function __construct()
    {
        parent::__construct();

        $this->isLoggedIn();
        // $this->check_role_menu();
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
	public function index(){
		if($this->session->has_userdata('logged_in') && $this->session->logged_in === TRUE){
            $shop_id     = $_SESSION['user_data']['id'];
            $shop_role_id     = $_SESSION['user_data']['role_id'];
            $data['shop_menus'] = $this->admin_model->get_role_menu_data($shop_role_id);
            $data['all_menus'] = $this->admin_model->get_data1('tb_admin_menu','status','1');
		    $shop_details = $this->shops_model->get_shop_data($shop_id);
            $viewData = array(
                                'orderStatus'=>$this->order_status_master_model->getRows(),
                                'orderPaymentStatusMaster'=>$this->payment_mode_master_model->getRows(),
                                'customers'=>$this->pos_orders_model->select_customer($shop_id),
                            );
			$template_data = array(
									'menu'=>$this->load->view('template/menu',$data,TRUE),
                                    'main_body_data'=>$this->load->view('shop/pos/orders-table',$viewData,TRUE),
                                    'shop_photo'=>$shop_details->logo
								);
			$this->load->view('template/main_template',$template_data);
		}else{
			redirect(base_url());
		}
    }
    public function getOrderStatus(){
        
        if(isset($_POST)){
            $arrayCond = array_merge($_POST,array('active'=>'1'));
        }else{
            $arrayCond = array('active'=>'1');
        }

        $getData = $this->order_status_master_model->getRows(array('conditions'=>$arrayCond));
        $array = array(array('id'=>"0",'name'=>"Select Status"));
        foreach($getData as $data){
            $temp_array = array(
                                'id' => $data['id'],
                                'name' => $data['name']
            );
            array_push($array,$temp_array);
        }
        echo json_encode($array);
    }
    public function getOrders() {
        $array_cond_like=array();
        // $array_cond['shop_id'] = $_GET['shop_id'];
        $array_cond=array();
        $array_cond_in=array();
        $array_cond_join=array();
        $date=array();
        $mobile = 'null';
        $orderid = null;
        $payment_mode = 'null';
        if(isset($_GET['shop_id']) && $_GET['shop_id']!==''){
            $array_cond['shop_id']=$_GET['shop_id'];
        }

        if(isset($_SESSION['order_table_filters']['from_date']) && $_SESSION['order_table_filters']['from_date']!==''){
            // $date['start_date'] = '01-07-2021';
            $date['start_date'] = $_SESSION['order_table_filters']['from_date'];
        }
        if(isset($_SESSION['order_table_filters']['to_date']) && $_SESSION['order_table_filters']['to_date']!==''){
            // $date['end_date'] = '30-10-2021';
            $date['end_date'] = $_SESSION['order_table_filters']['to_date'];
        }
        // if(isset($_SESSION['order_table_filters']['from_date']) && $_SESSION['order_table_filters']['from_date']!==''){
        //     $array_cond['datetime >='] = $_SESSION['order_table_filters']['from_date'];
        // }
        // if(isset($_SESSION['order_table_filters']['to_date']) && $_SESSION['order_table_filters']['to_date']!==''){
        //     $array_cond['datetime <='] = $_SESSION['order_table_filters']['to_date'];
        // }
        if(isset($_SESSION['order_table_filters']['status_ids']) && $_SESSION['order_table_filters']['status_ids']!==''){
            $array_cond_in['status'] = $_SESSION['order_table_filters']['status_ids'];
        }
        if(isset($_SESSION['order_table_filters']['payment_method']) && $_SESSION['order_table_filters']['payment_method']!==''){
            $payment_mode = $_SESSION['order_table_filters']['payment_method'];
        }
        if(isset($_SESSION['order_table_filters']['customer_mobile']) && $_SESSION['order_table_filters']['customer_mobile']!==''){
            $mobile = $_SESSION['order_table_filters']['customer_mobile'];
        }
        if(isset($_SESSION['order_table_filters']['orderid']) && $_SESSION['order_table_filters']['orderid']!==''){
            $orderid = $_SESSION['order_table_filters']['orderid'];
        }
        if(isset($_GET['filter']['total_value']) && $_GET['filter']['total_value']!==''){
            $array_cond['total_value'] = $_GET['filter']['total_value'];
        }
       
        if(isset($_GET['filter']['customer_name']) && $_GET['filter']['customer_name']!==''){
            $array_cond_join['mobile'] = $_GET['filter']['customer_name'];
        }
        if(isset($_GET['filter']['status']) && $_GET['filter']['status']!=='0'){
            $array_cond['status'] = $_GET['filter']['status'];
        }
        $arrayQuery = array(
                                'conditions'=>$array_cond,
                                'conditions_like'=>$array_cond_like,
                                'conditions_in'=>$array_cond_in,
                                'conditions_join'=>$array_cond_join,
                                'limit'=>$_GET['filter']['pageSize'],
                                'offset'=>$_GET['filter']['pageSize']*($_GET['filter']['pageIndex']-1),
                                'order_date'=>$date,
                            );
        if(isset($_GET['filter']['sortField']) && isset($_GET['filter']['sortOrder'])){
            if($_GET['filter']['sortField']==='order_id'){
                $arrayQuery['order_field']='orderid';
            }else{
                $arrayQuery['order_field']=$_GET['filter']['sortField'];
            }
            $arrayQuery['order']=$_GET['filter']['sortOrder'];
        }
        $getData = $this->pos_orders_model->getOrdersData($arrayQuery,$mobile,$payment_mode,$orderid);
        $array =array();
        $item_count=0;
        if($getData!==FALSE){
            $i=0;
            foreach($getData as $data){
                $due_date = (@$data['due_date'] && $data['due_date']!='0000-00-00') ? $data['due_date'] : '';
                $array[$i] = array(
                                    'id' => $data['id'],
                                    'order_id' => array('order'=>$data['id'],'row_id'=>$data['id']),
                                    'invoice_no' => $data['invoice_no'],
                                    'shop_name' => $data['shop_name'],
                                    'customer_name' => $data['v_name'].'<br>( '.$data['mobile']. ')',
                                    'datetime' => $data['datetime'],
                                    'order_date' => date_format_func($data['added']),
                                    // 'delivery_slot'=> $data['delivery_slot'],
                                    'random_address' => $data['random_address'],
                                    'total_value' => '₹ '.$data['total_value'],
                                    'total_savings' => '₹ '.$data['total_savings'],
                                    'payment_method' => $data['payment_method'],
                                    'status' => $data['status'],
                                    'status_name' => $data['status_name'],
                                    'orderid' => array('orderid'=>$data['orderid'],'row_id'=>$data['id']),
                                    'due_date' => $due_date
                );
                if ($data['status']==='1') {
                    $array[$i]['print_bill'] = array('order'=>'0','row_id'=>'0');
                }else{
                    $array[$i]['print_bill'] = array('order'=>$data['id'],'row_id'=>$data['id']);    
                }
                
                $i++;
            }
            unset($arrayQuery['limit'],$arrayQuery['offset'],$arrayQuery['order_field'],$arrayQuery['order']);
            $item_count = count($this->pos_orders_model->getOrdersData($arrayQuery,$mobile,$payment_mode));
        }
        // echo json_encode(array('data'=>$array));
        echo json_encode(array('data'=>$array,'itemsCount'=>$item_count));
    }
    public function setOrderSessionFilters(){
        if(isset($_POST['start_date']) && $_POST['start_date']!==''){
            $_SESSION['order_table_filters']['from_date'] = $_POST['start_date'];
        }
        if(isset($_POST['end_date']) && $_POST['end_date']!==''){
            $_SESSION['order_table_filters']['to_date'] = $_POST['end_date'];
        }
        if(isset($_POST['status']) && $_POST['status']!==''){
            $_SESSION['order_table_filters']['status_ids'] = array($_POST['status']);
        }
        if(isset($_POST['payment_method']) && $_POST['payment_method']!==''){
            $_SESSION['order_table_filters']['payment_method'] = $_POST['payment_method'];
        }
        if(isset($_POST['customer_mobile']) && $_POST['customer_mobile']!==''){
            $_SESSION['order_table_filters']['customer_mobile'] = $_POST['customer_mobile'];
        }
        if(isset($_POST['orderid']) && $_POST['orderid']!==''){
            $_SESSION['order_table_filters']['orderid'] = $_POST['orderid'];
        }
    }
    public function clearOrderSessionFilters(){
        unset($_SESSION['order_table_filters']);
    }
    public function orderDetails($order_id){
        if($this->session->has_userdata('logged_in') && $this->session->logged_in === TRUE){
            $shop_id     = $_SESSION['user_data']['id'];
            $shop_role_id     = $_SESSION['user_data']['role_id'];
            $data['shop_menus'] = $this->admin_model->get_role_menu_data($shop_role_id);
            $data['all_menus'] = $this->admin_model->get_data1('tb_admin_menu','status','1');
            $shop_details = $this->shops_model->get_shop_data($shop_id);
            $viewData = array(
                                'orderStatus'=>$this->order_status_master_model->getRows(),
                                'orderData'=>$this->pos_orders_model->getRows(array('conditions'=>array('id'=>$order_id))),
                                'orderItems'=>$this->pos_order_items_model->getRows(array('conditions'=>array('order_id '=>$order_id))),
                                'orderAssign'=>$this->order_assign_deliver_model->getRows(array('conditions'=>array('order_id '=>$order_id))),
                            );

            // echo _prx($viewData); die();
            $viewData['orderStatusData'] = $this->order_status_master_model->getRows(array('conditions'=>array('id'=>@$viewData['orderData'][0]['status'])));
            if(@$viewData['orderData'][0]['address_id']!==''){
                $customerData = $this->customers_model->getRows(array('conditions'=>array('id'=>@$viewData['orderData'][0]['user_id'])));
                $viewData['customerAddress'] = $this->customers_address_model->getRows(array('conditions'=>array('customer_id '=>@$customerData[0]['mobile'],'is_default'=>'1'))); 
            }
			$template_data = array(
									'menu'=>$this->load->view('template/menu',$data,TRUE),
									'main_body_data'=>$this->load->view('shop/pos/orders-details',$viewData,TRUE),
                                    'shop_photo'=>$shop_details->logo
								);
			$this->load->view('template/main_template',$template_data);
		}else{
			redirect(base_url());
		}
    }
    public function updateOrderStatus(){
        $checkExisting = $this->pos_orders_model->getRows(array('conditions'=>array('id'=>$_POST['item']['id'])));
        if($checkExisting!==FALSE){
            if($this->pos_orders_model->updateRow($_POST['item']['id'],array('status'=>$_POST['item']['status']))){
              
            }

        }
        return TRUE;
    }
    public function getNewOrders(){
        $newOrders = $this->orders_model->getNewOrdersRows(array('conditions'=>array('status'=>'17','id >'=>$_SESSION['orders_notification_last_id'])));
        $html = '';
        $count=1;
        $cur_last_id = $_SESSION['orders_notification_last_id'];
        if($newOrders!==FALSE){
            $_SESSION['orders_notification_last_id'] = $newOrders[0]['id'];
            foreach($newOrders as $orders){
                if($count <= 5){
                    $html.= '<a href="orders/'.$orders['id'].'">
                        <div class="mail-contnet">
                            <h5>'.$orders['customer_name'].' - <small>New Order</small></h5>
                            <span class="mail-desc"></span>
                            <span class="time">'.date('M j, Y g:i a',strtotime($orders['added'])).'</span>
                        </div>
                    </a>';
                    $count++;
                }
            }
            $data['status']=TRUE;
            $data['message']= $html;
        }else{
            $data['status']=FALSE;
        }
        if($cur_last_id===0 && $cur_last_id!==$_SESSION['orders_notification_last_id']){
            $data['icon_status'] = TRUE;
        }else{
            $data['icon_status'] = FALSE;
        }
        echo json_encode($data);    
    }
    public function orderPrintBill($orderId) {
        $invoice = $this->pos_orders_model->invoice_details($orderId);

        $data['order']  = $invoice['order'];
        $data['vendor'] = $invoice['vendor'];
        $data['shop']   = $invoice['shop'];
        $data['items']  = $invoice['items'];

        // echo _prx($data);
        // die();

        $this->load->view('template/pos_order_bill_print_layout',$data);
    }

     public function proforma_invoice() {

        // echo _prx($_POST);
        $invoice = $this->pos_orders_model->proforma_invoice_details();

        $data['order']  = $invoice['order'];
        $data['vendor'] = $invoice['vendor'];
        $data['shop']   = $invoice['shop'];
        $data['items']  = $invoice['items'];

        // echo _prx($data);
        // die();

        $this->load->view('template/pos_po_print_layout',$data);
    }

    public function updateOrderBillNo(){
        if (isset($_POST['id']) && isset($_POST['bill_no'])) {
            $this->orders_model->updateRow($_POST['id'],array('invoice_no'=>$_POST['bill_no']));
        }
    }

   
}