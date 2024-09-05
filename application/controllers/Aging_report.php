<?php 
defined('BASEPATH') or exit('No direct script access allowed');

class Aging_report extends CI_Controller
{
		public function __construct()
    {
        parent::__construct();

        $this->isLoggedIn();
        $this->load->model('reports_model');
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

    public function products($menu_id,$action=null,$p1=null,$p2=null)
    {
        $shop_id     = $_SESSION['user_data']['id'];
        $this->load->helper('form');
    	switch ($action) {
    		case null:
    			$data['title'] = 'Products Aging Report';
    			 $data['brands'] = $this->master_model->get_brands($shop_id);
                $data['vendors'] = $this->master_model->get_vendors($shop_id);
        		$data['tb_url']     = base_url() . 'products-aging-report/'.$menu_id.'/list';
		        $page = 'shop/reports/aging_report/products_index';
		        $this->header_and_footer($page, $data);

    			break;

    		case 'list':
                $products = $this->master_model->fill_products();
    			if (@$_POST['year']) {
    				$data['rows']=$this->reports_model->products_aging_report_new($products);
                    // echo _prx($data['rows'][0]);
                    // die();
	    			$page = 'shop/reports/aging_report/products_list';
			        $this->load->view($page, $data);
    			}
    			
    			break;
    		
    		default:
    			// code...
    			break;
    	}
    }
}

?>