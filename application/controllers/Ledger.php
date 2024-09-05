<?php 
/**
 * 
 */
class Ledger extends CI_Controller
{
	
	public function __construct()
    {
        parent::__construct();
        $this->isLoggedIn();
        $this->load->model('ladger_model','ladger_m');
        $this->load->model('cash_register_model');  
        // $this->check_role_menu();
    }

    public function isLoggedIn()
    {
        $is_logged_in = $this->session->userdata('shop_logged_in');
        if (!isset($is_logged_in) || $is_logged_in !== TRUE) {
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
    	
    }

    public function cash($action=null)
    {
    	switch ($action) {
    		case null:
    			$data['menu_id'] 		= $this->uri->segment(2);
                $data['title']          = 'Cash Report';
                $data['tb_url']			= base_url().'cash-report-tb';
                $page                   = 'shop/ledger/cash/index';
                $this->header_and_footer($page, $data);
    			break;

    		case 'tb':
                $data['rows'] = $this->ladger_m->cash();
                $data['shop'] = $this->ladger_m->shop_details();
                $data['cash_account']  = $this->ladger_m->cash_account();
    			$this->load->view('shop/ledger/cash/tb',$data);
    			break;
    		
    		default:
    			// code...
    			break;
    	}
    }


    public function bank($action=null)
    {
        $shop_id     = $_SESSION['user_data']['id'];    
    	switch ($action) {
            case null:
                $data['menu_id']        = $this->uri->segment(2);
                $data['title']          = 'Bank Report';
                $data['tb_url']         = base_url().'bank-report-tb';
                $data['bank_accounts']  = $this->shops_model->shop_bank_accounts($shop_id);
                $page                   = 'shop/ledger/bank/index';
                $this->header_and_footer($page, $data);
                break;

            case 'tb':
                $data['rows'] = $this->ladger_m->bank();
                $data['shop'] = $this->ladger_m->shop_details();
                $data['bank_account']  = $this->ladger_m->bank_account();
                // echo _prx($data['bank_account']); die;
                $this->load->view('shop/ledger/bank/tb',$data);
                break;
            
            default:
                // code...
                break;
        }
    }

    public function partywise($action=null)
    {
        switch ($action) {
            case null:
                $data['menu_id']        = $this->uri->segment(2);
                $data['title']          = 'Cash Report';
                $data['vendor']         = $this->cash_register_model->getvendor();
                $data['customer']       = $this->cash_register_model->getcustomer();
                $data['tb_url']         = base_url().'ledger-partywise-tb';

                $page                   = 'shop/ledger/partywise/index';
                $this->header_and_footer($page, $data);
                break;

            case 'tb':
                $data['opening'] = $this->ladger_m->party_opening();
                $data['rows']    = $this->ladger_m->party();
                // echo _prx($data['rows']); die;
                $data['shop']    = $this->ladger_m->shop_details();
                $this->load->view('shop/ledger/partywise/tb',$data);
                break;
            
            default:
                // code...
                break;
        }
    }

    public function monthly_report($action=null)
    {
        switch ($action) {
            case null:
                $data['menu_id']        = $this->uri->segment(2);
                $data['title']          = 'Monthly Ledger Report';
                $data['vendor']         = $this->cash_register_model->getvendor();
                $data['customer']       = $this->cash_register_model->getcustomer();
                $data['tb_url']         = base_url().'monthly-ledger-report-tb';

                $page                   = 'shop/ledger/monthly_report/index';
                $this->header_and_footer($page, $data);
                break;

            case 'tb':

                $_POST['from_date'] = date('Y-m-d',strtotime($_POST['month'].'-01'));
                $_POST['to_date'] = date('Y-m-t',strtotime($_POST['month'].'-01'));

                // echo _prx($_POST);
                // die();
                // $data['opening'] = $this->ladger_m->party_opening();
                $data['rows']    = $this->ladger_m->monthly_report();
                // echo _prx($data['rows']); die;
                $data['shop']    = $this->ladger_m->shop_details();
                $this->load->view('shop/ledger/monthly_report/tb',$data);
                break;
            
            default:
                // code...
                break;
        }
    }



}


 ?>