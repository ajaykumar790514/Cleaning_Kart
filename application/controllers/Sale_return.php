<?php 

/**
 * 
 */
class Sale_return extends CI_Controller
{
	
	public function __construct()
    {
        parent::__construct();

        $this->isLoggedIn();
        $this->load->model('return_model');
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

    public function header_and_footer($page, $data)
    {
        $shop_id     = $_SESSION['user_data']['id'];
        $shop_role_id     = $_SESSION['user_data']['role_id'];
        $data['shop_menus'] = $this->admin_model->get_role_menu_data($shop_role_id);
        $data['all_menus'] = $this->admin_model->get_data1('tb_admin_menu', 'status', '1');
        $shop_details = $this->shops_model->get_shop_data($shop_id);
        $template_data = array(
            'menu' => $this->load->view('template/menu', $data, TRUE),
            'main_body_data' => $this->load->view($page, $data, TRUE),
            'shop_photo' => $shop_details->logo
        );
        $this->load->view('template/main_template', $template_data);
    }

    public function index()
    {
    	$shop_id     	= $_SESSION['user_data']['id'];
    	$shop_role_id   = $_SESSION['user_data']['role_id'];
		
		$data['shop_menus'] = $this->admin_model->get_role_menu_data($shop_role_id);
        $data['all_menus']  = $this->admin_model->get_data1('tb_admin_menu','status','1');
        $data['tb_url']     = base_url() . 'sale_return/list';
        $data['parent_cat'] = $this->master_model->get_data('products_category', 'is_parent', '0');
        $data['customers']  = $this->master_model->get_customers($shop_id);
	    $shop_details = $this->shops_model->get_shop_data($shop_id);
        $viewData = array(
                        'orderStatus'=>$this->order_status_master_model->getRows(),
                        'orderPaymentStatusMaster'=>$this->payment_mode_master_model->getRows(),
                        'customers'=>$this->pos_orders_model->select_customer($shop_id),
                        );
		$template_data = array(
						'menu'=>$this->load->view('template/menu',$data,TRUE),
                        'main_body_data'=>$this->load->view('shop/sale_return/index',$viewData,TRUE),
                        'shop_photo'=>$shop_details->logo
							);
		$this->load->view('template/main_template',$template_data);
    		  	
    }

    public function list($value='')
    {
        $shop_id      = $_SESSION['user_data']['id'];

        $data['rows'] = $this->return_model->get_sales_return();
        $this->load->view('shop/sale_return/list',$data);

        // echo _prx($data['rows']);
        // echo _prx($_POST);
        // echo "string";
    }

    public function return()
    {
    	$shop_id       = $_SESSION['user_data']['id'];
    	$this->load->view('shop/sale_return/return');
    }

    public function store()
    {
        $shop_id            = $_SESSION['user_data']['id'];
        $response['res']    = 'error';
        $response['msg']    = 'Error!';
        // echo _prx($_POST);

        if (@$_POST['customer_id'] && @$_POST['product_id'] && @$_POST['return_qty'] && @$_POST['return_rate'] && @$_POST['return_total'] && @$_POST['stock_id'] ) {
            $post = $this->input->post();

            $qty = (int)$_POST['return_qty'] + (int)$_POST['free'];

            $insertArray = array(
                'customer_id'   => $post['customer_id'],
                'product_id'    => $post['product_id'],
                'qty'           => $qty,
                'rate'          => $post['return_rate'],
                'total'         => $post['return_total'],
                'invoice_no'    => '',
                'remark'        => $post['remark'],
                'inventory_id'  => $post['stock_id'],
                'date'          => $post['return_date'],
                'free'          => $post['free'],
                'discount'      => $post['discount'],
                'created_at'    => date('Y-m-d H:i:s'),
            );

            $TransArray = array(
                'customer_id'       => $post['customer_id'],
                'dr'                => $post['return_total'],
                'inventory_id'      => $post['stock_id'],
                'product_id'        => $post['product_id'],
                'reference_no'      => '',
                'txn_type'          => 5,
                'PaymentDate'       => $post['return_date'],
                'narration'         => $post['remark'],
                'shop_id'           => $shop_id,
                'updated'           => '',
                'type'              => 'Sale Return',
            );

            $inventory_update_query = "UPDATE `shops_inventory` SET qty = qty + ".$qty." WHERE `id` = ".$post['stock_id'];

            // $inventory_log_update_query = "UPDATE `shop_inventory_logs` SET action = 'UPDATE' WHERE `shops_inventory_id` = ".$post['stock_id']." AND action = 'LATEST_UPDATE'";

            // $this->db->set('qty', 'qty + '.$post['return_qty'], FALSE);
            // $this->db->where('id', $post['stock_id']);
            // $this->db->update('shops_inventory');

            $log   = $this->shop_inventory_logs_model->getMaxRow($post['stock_id']);

            $logArray = array(
                'product_id' => $post['product_id'],
                'qty' =>  $qty,
                'selling_rate' =>  $post['return_rate'],
                'shop_id' =>  $shop_id,
                'action' => 'SALES_RETURN',
                'shops_inventory_id' =>  $post['stock_id'],
                'total_value' =>  $post['return_total'],
                'vendor_id' => $log->vendor_id,
                'invoice_no' =>  '',
                'invoice_date' =>  $post['return_date'],
            );

            // echo _prx($log);
            $this->db->trans_begin();

            $this->db->insert('sales_return',$insertArray);
            $insert_id = $this->db->insert_id();
            $updateArray['invoice_no'] = _sale_return_invoice_no($insert_id);
            $this->db->where('id',$insert_id);
            $this->db->update('sales_return',$updateArray);

            $TransArray['return_id']    = $insert_id;
            $TransArray['reference_no'] = $updateArray['invoice_no'];
            $this->db->insert('cash_register',$TransArray);
            $this->db->query($inventory_update_query);
            // $this->db->query($inventory_log_update_query);
            $logArray['invoice_no'] = $updateArray['invoice_no'];
            $this->db->insert('shop_inventory_logs',$logArray);

            if ($this->db->trans_status() === FALSE)
            {
                $this->db->trans_rollback();
            }
            else
            {
                $this->db->trans_commit();
                $response['res']    = 'success';
                $response['msg']    = 'Saved';
            }

        }
        else{
            $response['res']    = 'warning';
            $response['msg']    = 'Fill all required fields and select Stock!';
        }
        echo json_encode($response);
    }

    public function get_stocks($pro_id)
    {
       $shop_id         = $_SESSION['user_data']['id'];
       if ($_SEVER['HTTP_REFERER'] = base_url('sale_return')) {
           if($stocks = $this->return_model->get_stocks($shop_id,$pro_id)):
                $data['stocks'] = $stocks;
                $this->load->view('shop/sale_return/stocks',$data);
           else:
            echo "<h2 class='text-center text-danger w-100'>Stock Not Available!</h2>";
           endif;
       }
    }

    public function report($action=null)
    {
        $this->load->model('cash_register_model');
        switch ($action) {
            case null:
                $data['menu_id']        = $this->uri->segment(2);
                $data['title']          = 'Sale Purchase Return Report';
                $data['vendor']         = $this->cash_register_model->getvendor();
                $data['customer']       = $this->cash_register_model->getcustomer();
                $data['tb_url']         = base_url().'sale-purchase-return-report-tb';

                $page                   = 'shop/sale_return/report/index';
                $this->header_and_footer($page, $data);
                break;

            case 'tb':

                $data['rows'] = $this->return_model->report();
                // echo _prx($data);
                // echo _prx($_POST); 

                // $data['opening'] = $this->ladger_m->party_opening();
                // $data['rows']    = $this->ladger_m->party();
                // echo _prx($data['rows']); die;
                $this->load->model('ladger_model','ladger_m');
                $data['shop']    = $this->ladger_m->shop_details();
                if (@$_POST['is_Customer']=='on') {
                    $this->load->view('shop/sale_return/report/tb_sales_return',$data);
                }
                else{
                    $this->load->view('shop/sale_return/report/tb_purchase_return',$data);
                }
                
                break;
            
            default:
                // code...
                break;
        }
    }



}


 ?>