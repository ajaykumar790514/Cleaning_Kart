<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Reports extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->isLoggedIn();
        $this->check_role_menu();
    }

    public function isLoggedIn()
    {
        $is_logged_in = $this->session->userdata('shop_logged_in');
        if (!isset($is_logged_in) || $is_logged_in !== TRUE) {
            redirect(base_url());
            exit;
        }
    }
    public function check_role_menu()
    {
        $shop_role_id = $_SESSION['shop_role_id'];
        $uri = $this->uri->segment(1);
        $role_menus = $this->admin_model->all_role_menu_data($shop_role_id);
        $url_array = array();
        if (!empty($role_menus)) {
            foreach ($role_menus as $menus) {
                array_push($url_array, $menus->url);
            }
            if (!in_array($uri, $url_array)) {
                redirect(base_url());
            }
        } else {
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
        $data['title'] = 'Master';
        $menu_id = $this->uri->segment(2);
        $data['menu_id'] = $menu_id;
        $role_id = $_SESSION['shop_role_id'];
        $data['sub_menus'] = $this->admin_model->get_submenu_data($menu_id, $role_id);
        $page = 'shop/reports/reports_data';
        $this->header_and_footer($page, $data);
    }

    public function stock_report($action = null, $p1 = null, $p2 = null, $p3 = null, $p4 = null)
    {
        switch ($action) {
            case null:
                $data['title']          = 'Low Stock Report';
                $data['tb_url']         = base_url() . 'stock-report/tb';
                $page                   = 'shop/reports/stocks_report/index';
                $this->header_and_footer($page, $data);
                break;

            case 'tb':

                $data['cat_id'] = 'null';
                $data['parent_id'] = '';
                $data['search'] = 'null';
                //below variable section used for models and other places
                $cat_id = 'null';
                $parent_id = 'null';
                $search = 'null';
                //get section intiliazation
                if ($p2 != null) {
                    $data['parent_id'] = $p1;
                    $data['cat_id'] = $p2;
                    $parent_id = $p1;
                    $cat_id = $p2;
                    $data['sub_cat'] = $this->db->get_where('products_category', ['is_parent' => $p1, 'is_deleted' => 'NOT_DELETED'])->result();
                }
                if ($p3 != null) {
                    $data['search'] = $p3;
                    $search = $p3;
                }
                //end of section
                if (@$_POST['search']) {
                    $data['search'] = $_POST['search'];
                    $search = $_POST['search'];
                }
                if (@$_POST['cat_id']) {
                    $data['cat_id'] = $_POST['cat_id'];
                    $data['parent_id'] = $_POST['parent_id'];
                    $cat_id = $_POST['cat_id'];
                    $parent_id = $_POST['parent_id'];
                    $data['sub_cat'] = $this->db->get_where('products_category', ['is_parent' => $_POST['parent_id'], 'is_deleted' => 'NOT_DELETED'])->result();
                }

                $this->load->library('pagination');
                $config = array();

                $shop_id     = $_SESSION['user_data']['id'];
                $config["base_url"]         = base_url() . "stock-report/tb/" . $parent_id . "/" . $cat_id . "/" . $search;
                $config["total_rows"]       = $this->reports_model->get_stock_report($parent_id, $cat_id, $shop_id, $search);
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
                $data['page']               = $page = ($p4 != null) ? $p4 : 0;
                $data['per_page']           = $config["per_page"];
                $data['parent_cat'] = $this->master_model->get_data('products_category', 'is_parent', '0');
                $data['stock_report']           = $this->reports_model->get_stock_report($parent_id, $cat_id, $shop_id, $search, $config["per_page"], $page);
                $data['low_stock_result']           = $this->reports_model->get_stock_report_result($cat_id, $shop_id, $search);
                $page                       = 'shop/reports/stocks_report/tb';
                $this->load->view($page, $data);
                break;

            case 'export_to_excel':

                $shop_id     = $_SESSION['user_data']['id'];
                $productData = $this->reports_model->export_stock_report($shop_id, $p1, $p2);

                $spreadsheet = new Spreadsheet();
                $sheet = $spreadsheet->getActiveSheet();
                $sheet->setCellValue('A1', 'S.No.');
                $sheet->setCellValue('B1', 'Product Name');
                $sheet->setCellValue('C1', 'Purchase Rate');
                $sheet->setCellValue('D1', 'Sale Price');
                $sheet->setCellValue('E1', 'Product Code');
                $sheet->setCellValue('F1', 'Invoice No');
                $sheet->setCellValue('G1', 'Pack Size');
                $sheet->setCellValue('H1', 'Stock');
                $count = 2;
                $i = 1;
                foreach ($productData as $pData) {
                    $sheet->setCellValue('A' . $count, $i++);
                    $sheet->setCellValue('B' . $count, $pData->prod_name);
                    $sheet->setCellValue('C' . $count, $pData->purchase_rate);
                    $sheet->setCellValue('D' . $count, $pData->selling_rate);
                    $sheet->setCellValue('E' . $count, $pData->product_code);
                    $sheet->setCellValue('F' . $count, $pData->invoice_no);
                    $sheet->setCellValue('G' . $count, $pData->unit_value . ' ' . $pData->unit_type);
                    $sheet->setCellValue('H' . $count, $pData->qty . ' ' . $pData->unit_type);
                    $count++;
                }
                $writer = new Xlsx($spreadsheet);
                $filename = 'Low_Stock_Report';
                header('Content-Type: application/vnd.ms-excel');
                header('Content-Disposition: attachment;filename="' . $filename . '.xls"');
                header('Cache-Control: max-age=0');
                $writer->save('php://output'); // download file
                break;

            default:
                # code...
                break;
        }
    }

    public function product_stock_report($action = null, $p1 = null, $p2 = null, $p3 = null, $p4 = null,$p5=null,$p6=null)
    {
        $shop_id     = $_SESSION['user_data']['id'];
        switch ($action) {
            case null:
                $data['title']          = 'Stock Report Left';
                $data['tb_url']         = base_url() . 'product-stock-report/tb';
                $data['parent_cat'] = $this->master_model->get_data('products_category', 'is_parent', '0');
                $data['brands'] = $this->master_model->get_brands($shop_id);
                $data['vendors'] = $this->master_model->get_vendors($shop_id);
                $page                   = 'shop/reports/product_stocks_report/index';
                $this->header_and_footer($page, $data);
                break;

            case 'tb':
                
                

                // echo _prx($_POST);
                // die();
                // $data['cat_id'] = 'null';
                // $data['parent_id'] = '';
                // $data['search'] = 'null';
                // //below variable section used for models and other places
                // $cat_id = 'null';
                // $parent_id = 'null';
                // $search = 'null';
                // //get section intiliazation
                // if ($p2 != null) {
                //     $data['parent_id'] = $p1;
                //     $data['cat_id'] = $p2;
                //     $parent_id = $p1;
                //     $cat_id = $p2;
                //     $data['sub_cat'] = $this->db->get_where('products_category', ['is_parent' => $p1, 'is_deleted' => 'NOT_DELETED'])->result();
                // }
                // if ($p3 != null) {
                //     $data['search'] = $p3;
                //     $search = $p3;
                // }
                // //end of section
                // if (@$_POST['search']) {
                //     $data['search'] = $_POST['search'];
                //     $search = $_POST['search'];
                // }
                // if (@$_POST['cat_id']) {
                //     $data['cat_id'] = $_POST['cat_id'];
                //     $data['parent_id'] = $_POST['parent_id'];
                //     $cat_id = $_POST['cat_id'];
                //     $parent_id = $_POST['parent_id'];
                //     $data['sub_cat'] = $this->db->get_where('products_category', ['is_parent' => $_POST['parent_id'], 'is_deleted' => 'NOT_DELETED'])->result();
                // }

                $p = $this->input->post();
                $data['vendor_id']      = (@$p['vendor_id']) ? $p['vendor_id'] : 'null';
                $data['parent_id']      = (@$p['parent_id']) ? $p['parent_id'] : 'null';
                $data['parent_cat_id']  = (@$p['parent_cat_id']) ? $p['parent_cat_id'] : 'null';
                $data['product_id']     = (@$p['product_id']) ? $p['product_id'] : 'null';
                $data['brand_id']       = (@$p['brand_id']) ? $p['brand_id'] : 'null';
                $data['tb_search']       = (@$p['tb-search']) ? $p['tb-search'] : 'null';


                $this->load->library('pagination');
                $config = array();

                $shop_id     = $_SESSION['user_data']['id'];
                $config["base_url"]         = base_url() . "product-stock-report/tb/";
                $config["total_rows"]       = $this->reports_model->get_product_stock_report($shop_id);
                $data['total_rows']         = $config["total_rows"];
                $config["per_page"]         = 10;
                $config["uri_segment"]      = 3;
                $config['attributes']       = array('class' => 'pag-link');
                $config['full_tag_open']    = "<div class='pag'>";
                $config['full_tag_close']   = "</div>";
                $config['first_link']       = '&lt;&lt;';
                $config['last_link']        = '&gt;&gt;';
                $this->pagination->initialize($config);
                $data["links"]              = $this->pagination->create_links();
                $data['page']               = $page = ($p1 != null) ? $p1 : 0;
                $data['per_page']           = $config["per_page"];
                // $data['parent_cat'] = $this->master_model->get_data('products_category', 'is_parent', '0');
                // $data['brands'] = $this->master_model->get_brands();
                $data['stock_report']           = $this->reports_model->get_product_stock_report($shop_id,$config["per_page"], $page);

                 // echo _prx($data['stock_report']);
                 // die();
                $data['stock_result']           = $this->reports_model->get_product_stock_report_result($shop_id);
                $page                       = 'shop/reports/product_stocks_report/tb';
                $this->load->view($page, $data);
                break;

            case 'export_to_excel':

                $filter['vendor_id']        = $p1;
                $filter['parent_id']        = $p2;
                $filter['parent_cat_id']    = $p3;
                $filter['product_id']       = $p4;
                $filter['brand_id']         = $p5;
                $filter['tb_search']        = $p6;
                $filter['shop_id']          = $_SESSION['user_data']['id'];

                // echo _prx($filter);
                $shop_id     = $_SESSION['user_data']['id'];
                $productData = $this->reports_model->export_product_stock_report($filter);

                $spreadsheet = new Spreadsheet();
                $sheet = $spreadsheet->getActiveSheet();
                $sheet->setCellValue('A1', 'S.No');
                $sheet->setCellValue('B1', 'Product Code');
                $sheet->setCellValue('C1', 'Product Name');
                $sheet->setCellValue('D1', 'Purchase Rate');
                $sheet->setCellValue('E1', 'Sale Price ( Online Sale Price )');
                $sheet->setCellValue('F1', 'Invoice No.');
                $sheet->setCellValue('G1', 'Pack Size');
                $sheet->setCellValue('H1', 'Stock');
                $count = 2;
                $i = 1;
                foreach ($productData as $pData) {
                    $sheet->setCellValue('A' . $count, $i++);
                    $sheet->setCellValue('B' . $count, $pData->product_code);
                    $sheet->setCellValue('C' . $count, $pData->prod_name);
                    $sheet->setCellValue('D' . $count, $pData->purchase_rate);
                    $sheet->setCellValue('E' . $count, $pData->selling_rate);
                    $sheet->setCellValue('F' . $count, $pData->invoice_no);
                    $sheet->setCellValue('G' . $count, $pData->unit_value . ' ' . $pData->unit_type);
                    $sheet->setCellValue('H' . $count, $pData->qty . ' ' . $pData->unit_type);
                    $count++;
                }
                $writer = new Xlsx($spreadsheet);
                $filename = 'Stock_Report';
                header('Content-Type: application/vnd.ms-excel');
                header('Content-Disposition: attachment;filename="' . $filename . '.xls"');
                header('Cache-Control: max-age=0');
                $writer->save('php://output'); // download file
                break;

            default:
                # code...
                break;
        }
    }

    public function date_wise_product_stock_report($action=null,$p1=null,$p2=null)
    {
        $shop_id     = $_SESSION['user_data']['id'];
        switch($action){
            case null:
                $data['title']          = 'Product Stoct Report';
                $data['tb_url']         = base_url() . 'date-wise-stock-report/tb';
                $data['brands'] = $this->master_model->get_brands($shop_id);
                $data['vendors'] = $this->master_model->get_vendors($shop_id);
                $page                   = 'shop/reports/date_wise_product_stock_report/index';
                $this->header_and_footer($page, $data);
                break;

            case 'tb':

                $products = $this->master_model->fill_products();
                $rows = $this->reports_model->date_wise_product_stock_report($products);
              
                // echo _prx($rows);
                // die();

                $this->load->library('table');
                $template = array(
                        'table_open'  => '<div class="table-responsive"><table class="table table-bordered table-striped table-hover table-sm products-wise-stock-report">',
                        'table_close'  => '</table></div>',
                    );

                $this->table->set_template($template);
                    
                
                if (@$rows) {
                    $this->table->set_heading(array_keys($rows[0]));
                    foreach ($rows as $key => $value) {
                        $this->table->add_row(array_values($value));
                    }
                }
                else{
                    $cell = array('data' => 'Data Not Found!', 'class' => 'text-center text-danger', 'colspan' => 5);
                    $this->table->add_row($cell);
                }
                

                echo $this->table->generate();
                

                break;
        }
    }

    public function sales_report_accounting($action = null, $p1 = null, $p2 = null, $p3 = null, $p4 = null, $p5 = null)
    {
        switch ($action) {
            case null:
                $data['title']          = 'Sales Report Accounting';
                $data['tb_url']         = base_url() . 'sales-report-accounting/tb';
                $page                   = 'shop/reports/sales_report_accounting/index';
                $this->header_and_footer($page, $data);
                break;

            case 'tb':

                $data['from_date'] = '';
                $data['to_date'] = '';
                $data['group_by'] = 'Days';
                $data['status_id'] = '';
                //below variable section used for models and other places
                $from_date = 'null';
                $to_date = 'null';
                $group_by = 'null';
                $status_id = 'null';

                //get section intiliazation
                if ($p2 != null) {
                    $data['from_date'] = $p1;
                    $data['to_date'] = $p2;
                    $data['group_by'] = $p3;
                    $data['status_id'] = $p4;
                    $from_date = $p1;
                    $to_date = $p2;
                    $group_by = $p3;
                    $status_id = $p4;
                }
                if ($p3 != null) {
                    $data['group_by'] = $p3;
                    $group_by = $p3;
                }
                if ($p4 != null) {
                    $data['status_id'] = $p4;
                    $status_id = $p4;
                }
                //end of section

                if (@$_POST['to_date']) {
                    $data['from_date'] = $_POST['from_date'];
                    $data['to_date'] = $_POST['to_date'];
                    $from_date = $_POST['from_date'];
                    $to_date = $_POST['to_date'];
                }
                if (@$_POST['group_by']) {
                    $data['group_by'] = $_POST['group_by'];
                    $group_by = $_POST['group_by'];
                }
                if (@$_POST['status_id']) {
                    $data['status_id'] = $_POST['status_id'];
                    $status_id = $_POST['status_id'];
                }
                if ($data['to_date'] != '') {
                    $this->load->library('pagination');
                    $config = array();

                    $shop_id     = $_SESSION['user_data']['id'];
                    $config["base_url"]         = base_url() . "sales-report-accounting/tb/" . $from_date . "/" . $to_date . "/" . $group_by . "/" . $status_id;
                    $config["total_rows"]       = $this->reports_model->get_sales_report_accounting($shop_id, $from_date, $to_date, $group_by, $status_id);

                    $data['total_rows']         = $config["total_rows"];
                    $config["per_page"]         = 10;
                    $config["uri_segment"]      = 7;
                    $config['attributes']       = array('class' => 'pag-link');
                    $config['full_tag_open']    = "<div class='pag'>";
                    $config['full_tag_close']   = "</div>";
                    $config['first_link']       = '&lt;&lt;';
                    $config['last_link']        = '&gt;&gt;';
                    $this->pagination->initialize($config);
                    $data["links"]              = $this->pagination->create_links();
                    $data['page']               = $page = ($p5 != null) ? $p5 : 0;
                    $data['per_page']           = $config["per_page"];
                    $data['sales_report']           = $this->reports_model->get_sales_report_accounting($shop_id, $from_date, $to_date, $group_by, $status_id, $config["per_page"], $page);
                }
                $data['order_status'] = $this->master_model->get_data1('order_status_master', 'active', '1');
                $data['empty'] = "";
                $page                       = 'shop/reports/sales_report_accounting/tb';
                $this->load->view($page, $data);
                break;
            case 'export_to_excel':
                $from_date = $p1;
                $to_date = $p2;

                $shop_id     = $_SESSION['user_data']['id'];
                $result = $this->reports_model->export_sales_report_accounting($shop_id, $from_date, $to_date, $p3, $p4);

                $spreadsheet = new Spreadsheet();
                $sheet = $spreadsheet->getActiveSheet();
                $sheet->setCellValue('A1', 'Date Start');
                $sheet->setCellValue('B1', 'Date End');
                $sheet->setCellValue('C1', 'No. Orders');
                $sheet->setCellValue('D1', 'No. Products');
                $sheet->setCellValue('E1', 'Tax');
                $sheet->setCellValue('F1', 'Total');
                $count = 2;
                foreach ($result as $row) {
                    $sheet->setCellValue('A' . $count, date_format_func($row->min_date));
                    $sheet->setCellValue('B' . $count, date_format_func($row->max_date));
                    $sheet->setCellValue('C' . $count, $row->order_count);
                    $sheet->setCellValue('D' . $count, $row->total_products);
                    $sheet->setCellValue('E' . $count, $row->total_tax);
                    $sheet->setCellValue('F' . $count, $row->total);
                    $count++;
                }
                $writer = new Xlsx($spreadsheet);
                $filename = 'Sales_Report_Accounting';
                header('Content-Type: application/vnd.ms-excel');
                header('Content-Disposition: attachment;filename="' . $filename . '.xls"');
                header('Cache-Control: max-age=0');
                $writer->save('php://output'); // download file
                break;

            default:
                # code...
                break;
        }
    }

    public function product_purchased_report($action = null, $p1 = null, $p2 = null, $p3 = null)
    {
        switch ($action) {
            case null:
                $data['title']          = 'Product Sales Report';
                $data['tb_url']         = base_url() . 'product-purchased-report/tb';
                $page                   = 'shop/reports/product_purchased_report/index';
                $this->header_and_footer($page, $data);
                break;

            case 'tb':

                $data['from_date'] = '';
                $data['to_date'] = '';
                //below variable section used for models and other places
                $from_date = 'null';
                $to_date = 'null';
                //get section intiliazation
                if ($p2 != null) {
                    $data['from_date'] = $p1;
                    $data['to_date'] = $p2;
                    $from_date = $p1;
                    $to_date = $p2;
                }
                //end of section
                if (@$_POST['to_date']) {
                    $data['from_date'] = $_POST['from_date'];
                    $data['to_date'] = $_POST['to_date'];
                    $from_date = $_POST['from_date'];
                    $to_date = $_POST['to_date'];
                }

                $this->load->library('pagination');
                $config = array();

                $shop_id     = $_SESSION['user_data']['id'];
                $config["base_url"]         = base_url() . "product-purchased-report/tb/" . $from_date . "/" . $to_date;
                $config["total_rows"]       = $this->reports_model->get_product_purchased_report($shop_id, $from_date, $to_date);
                $data['total_rows']         = $config["total_rows"];
                $config["per_page"]         = 10;
                $config["uri_segment"]      = 5;
                $config['attributes']       = array('class' => 'pag-link');
                $config['full_tag_open']    = "<div class='pag'>";
                $config['full_tag_close']   = "</div>";
                $config['first_link']       = '&lt;&lt;';
                $config['last_link']        = '&gt;&gt;';
                $this->pagination->initialize($config);
                $data["links"]              = $this->pagination->create_links();
                $data['page']               = $page = ($p3 != null) ? $p3 : 0;
                $data['per_page']           = $config["per_page"];
                $data['product_purchased_report']           = $this->reports_model->get_product_purchased_report($shop_id, $from_date, $to_date, $config["per_page"], $page);
                $data['order_status'] = $this->master_model->get_data1('order_status_master', 'active', '1');
                $page                       = 'shop/reports/product_purchased_report/tb';
                $this->load->view($page, $data);
                break;

            case 'export_to_excel':
                $shop_id     = $_SESSION['user_data']['id'];
                $result = $this->reports_model->export_product_purchased_report($shop_id, $p1, $p2);

                $spreadsheet = new Spreadsheet();
                $sheet = $spreadsheet->getActiveSheet();
                $sheet->setCellValue('A1', 'Product Name');
                $sheet->setCellValue('B1', 'Model');
                $sheet->setCellValue('C1', 'Quantity');
                $sheet->setCellValue('D1', 'Total');
                $count = 2;
                foreach ($result as $row) {
                    $sheet->setCellValue('A' . $count, $row->prod_name);
                    $sheet->setCellValue('B' . $count, $row->product_code);
                    $sheet->setCellValue('C' . $count, $row->quantity . ' ' . $row->unit_type);
                    $sheet->setCellValue('D' . $count, $row->total);
                    $count++;
                }
                $writer = new Xlsx($spreadsheet);
                $filename = 'Product_Purchased_Report';
                header('Content-Type: application/vnd.ms-excel');
                header('Content-Disposition: attachment;filename="' . $filename . '.xls"');
                header('Cache-Control: max-age=0');
                $writer->save('php://output'); // download file
                break;
            default:
                # code...
                break;
        }
    }

    public function tax_report($action = null, $p1 = null, $p2 = null, $p3 = null, $p4 = null, $p5 = null)
    {
        switch ($action) {
            case null:
                $data['title']          = 'Tax Report';
                $data['tb_url']         = base_url() . 'tax-report/tb';
                $page                   = 'shop/reports/tax_report/index';
                $this->header_and_footer($page, $data);
                break;

            case 'tb':

                $data['from_date'] = '';
                $data['to_date'] = '';
                $data['status_id'] = '';
                //below variable section used for models and other places
                $from_date = 'null';
                $to_date = 'null';
                $status_id = 'null';

                //get section intiliazation
                if ($p2 != null) {
                    $data['from_date'] = $p1;
                    $data['to_date'] = $p2;
                    $data['status_id'] = $p3;
                    $from_date = $p1;
                    $to_date = $p2;
                    $status_id = $p3;
                }
                if ($p3 != null) {
                    $data['status_id'] = $p3;
                    $status_id = $p3;
                }
                //end of section

                if (@$_POST['to_date']) {
                    $data['from_date'] = $_POST['from_date'];
                    $data['to_date'] = $_POST['to_date'];
                    $data['status_id'] = $_POST['status_id'];
                    $from_date = $_POST['from_date'];
                    $to_date = $_POST['to_date'];
                    // $status_id = $_POST['status_id'];
                }
                if (@$_POST['status_id']) {
                    $data['status_id'] = $_POST['status_id'];
                    $status_id = $_POST['status_id'];
                }
                if ($data['to_date'] != '') {
                    $this->load->library('pagination');
                    $config = array();

                    $shop_id     = $_SESSION['user_data']['id'];
                    $config["base_url"]         = base_url() . "tax-report/tb/" . $from_date . "/" . $to_date . "/" . $status_id;
                    $config["total_rows"]       = $this->reports_model->get_tax_report($shop_id, $from_date, $to_date, $status_id);
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
                    $data['page']               = $page = ($p4 != null) ? $p4 : 0;
                    $data['per_page']           = $config["per_page"];
                    $data['tax_report']           = $this->reports_model->get_tax_report($shop_id, $from_date, $to_date, $status_id, $config["per_page"], $page);
                }
                $data['order_status'] = $this->master_model->get_data1('order_status_master', 'active', '1');
                $data['empty'] = "";
                $page                       = 'shop/reports/tax_report/tb';
                $this->load->view($page, $data);
                break;

            case 'export_to_excel':
                $from_date = $p1;
                $to_date = $p2;

                $shop_id     = $_SESSION['user_data']['id'];
                $result = $this->reports_model->export_tax_report($shop_id, $from_date, $to_date, $p3);

                $spreadsheet = new Spreadsheet();
                $sheet = $spreadsheet->getActiveSheet();
                $sheet->setCellValue('A1', 'Date Start');
                $sheet->setCellValue('B1', 'Date End');
                $sheet->setCellValue('C1', 'Tax Title(IGST)');
                $sheet->setCellValue('D1', 'Tax Title(CGST)');
                $sheet->setCellValue('E1', 'Tax Title(SGST)');
                $sheet->setCellValue('F1', 'No. Orders');
                $sheet->setCellValue('G1', 'Total');
                $count = 2;
                $igst = 0;
                $cgst = 0;
                $sgst = 0;
                $totaligst = 0;
                $totalcgst = 0;
                $totalsgst = 0;
                $totalvalue = 0;
                $totalorders = 0;
                foreach ($result as $value) {

                    if ($value->is_igst == 1) {
                        $igst = $igst + $value->order_tax;
                        $totaligst = $totaligst + $igst;
                    } else if ($value->is_igst == 0) {
                        $cgst = $cgst + ($value->order_tax / 2);
                        $sgst = $sgst + ($value->order_tax / 2);
                        $totalcgst = $totalcgst + $cgst;
                        $totalsgst = $totalsgst + $sgst;
                    }
                    $totalorders = $totalorders + $value->order_count;
                    $totalvalue = $totalvalue + $value->total;

                    $sheet->setCellValue('A' . $count, date_format_func($value->min_date));
                    $sheet->setCellValue('B' . $count, date_format_func($value->max_date));
                    $sheet->setCellValue('C' . $count, round($igst, 2));
                    $sheet->setCellValue('D' . $count, round($cgst, 2));
                    $sheet->setCellValue('E' . $count, round($sgst, 2));
                    $sheet->setCellValue('F' . $count, $value->order_count);
                    $sheet->setCellValue('G' . $count, $value->total);
                    $count++;
                }

                $writer = new Xlsx($spreadsheet);
                $filename = 'Tax_Report';
                header('Content-Type: application/vnd.ms-excel');
                header('Content-Disposition: attachment;filename="' . $filename . '.xls"');
                header('Cache-Control: max-age=0');
                $writer->save('php://output'); // download file
                break;
            default:
                # code...
                break;
        }
    }

    public function purchase_report($action = null, $p1 = null, $p2 = null, $p3 = null, $p4 = null, $p5 = null, $p6 = null, $p7 = null, $p8 = null, $p9 = null)
    {
        //this function accepts data in two ways 1:through post 2:through get using pagination links

        switch ($action) {
            case null:
            $this->load->model('cash_register_model'); 
                $data['title']          = 'Purchase Report';
                $data['tb_url']         = base_url() . 'purchase-report/tb';
                $data['vendor_list'] = $this->cash_register_model->getvendor();
                $data['brands'] = $this->master_model->get_data('brand_master', 'active', '1');
                $data['parent_cat'] = $this->master_model->get_data('products_category', 'is_parent', '0');
                $page                   = 'shop/reports/purchase_report/index';
                $this->header_and_footer($page, $data);
                break;

            case 'tb':

                //first need to initialize all varibale to null string which we are going to use in query and 
                // wants to reverts back to filters through data array
                $_POST['child_cat_id'] = (@$_POST['sub_cat_id']) ? $_POST['sub_cat_id'] : false;
                //below variable section used for filters
                $data['from_date'] = '';
                $data['to_date'] = '';
                $data['vendor_id'] = 'null';
                $data['search'] = 'null';
                $data['brand_id'] = 'null';
                $data['parent_id'] = 'null';
                $data['parent_cat_id'] = 'null';
                $data['child_cat_id'] = 'null';

                //below variable section used for models and other places
                $from_date = 'null';
                $to_date = 'null';
                $vendor_id = 'null';
                $search = 'null';
                $brand_id = 'null';
                $parent_cat_id = 'null';
                $parent_id = 'null';
                $child_cat_id = 'null';

                //get section intiliazation
                if ($p2 != null) {
                    $data['from_date'] = $p1;
                    $data['to_date'] = $p2;
                    $from_date = $p1;
                    $to_date = $p2;
                }
                if ($p3 != null) {
                    $data['vendor_id'] = $p3;
                    $vendor_id = $p3;
                }
                if ($p4 != null) {
                    $data['search'] = $p4;
                    $search = $p4;
                }
                if ($p5 != null) {
                    $data['brand_id'] = $p5;
                    $brand_id = $p5;
                }
                if ($p6 != null) {

                    $data['parent_id'] = $p6;
                    $parent_id = $p6;
                }
                if ($p7 != null) {
                    $data['parent_cat_id'] = $p7;
                    $parent_cat_id = $p7;
                    $data['sub_cat'] = $this->db->get_where('products_category', ['is_parent' => $parent_id, 'is_deleted' => 'NOT_DELETED'])->result();
                }
                if ($p8 != null) {
                    $data['child_cat_id'] = $p8;
                    $child_cat_id = $p8;
                    $data['child_cat'] = $this->db->get_where('products_category', ['is_parent' => $p7, 'is_deleted' => 'NOT_DELETED'])->result();
                }
                //end of section


                //post section intiliazation
                if (@$_POST['from_date']) {

                    $data['from_date'] = $_POST['from_date'];
                    $data['to_date'] = $_POST['to_date'];
                    $from_date = $_POST['from_date'];
                    $to_date = $_POST['to_date'];
                }
                if (@$_POST['vendor_id']) {
                    $data['vendor_id'] = $_POST['vendor_id'];
                    $vendor_id = $_POST['vendor_id'];
                }
                if (@$_POST['brand_id']) {
                    $data['brand_id'] = $_POST['brand_id'];
                    $brand_id = $_POST['brand_id'];
                }
                if (@$_POST['parent_cat_id']) {
                    $data['parent_cat_id'] = $_POST['parent_cat_id'];
                    $parent_cat_id = $_POST['parent_cat_id'];
                    $data['parent_id'] = $_POST['parent_id'];
                    $parent_id = $_POST['parent_id'];
                    $data['sub_cat'] = $this->db->get_where('products_category', ['is_parent' => $parent_id, 'is_deleted' => 'NOT_DELETED'])->result();
                }
                if (@$_POST['child_cat_id']) {
                    $data['child_cat_id'] = $_POST['child_cat_id'];
                    $child_cat_id = $_POST['child_cat_id'];
                    $data['child_cat'] = $this->db->get_where('products_category', ['is_parent' => $parent_cat_id, 'is_deleted' => 'NOT_DELETED'])->result();
                }
                if (@$_POST['tb-search']) {
                    $data['search'] = $_POST['tb-search'];
                    $search = $_POST['tb-search'];
                }
                //end of section    


                if ($data['to_date'] != '') {
                    $this->load->library('pagination');
                    $config = array();

                    $shop_id     = $_SESSION['user_data']['id'];


                    $config["base_url"]         = base_url() . "purchase-report/tb/" . $from_date . "/" . $to_date . "/" . $vendor_id . "/" . $search . "/" . $brand_id . "/" . $parent_id . "/" . $parent_cat_id . "/" . $child_cat_id;
                    $config["total_rows"]       = $this->reports_model->get_purchase_report($shop_id, $from_date, $to_date, $vendor_id, $search, $brand_id, $parent_cat_id, $child_cat_id);
                    $data['total_rows']         = $config["total_rows"];
                    $config["per_page"]         = 10;
                    $config["uri_segment"]      = 11;
                    $config['attributes']       = array('class' => 'pag-link');
                    $config['full_tag_open']    = "<div class='pag'>";
                    $config['full_tag_close']   = "</div>";
                    $config['first_link']       = '&lt;&lt;';
                    $config['last_link']        = '&gt;&gt;';
                    $this->pagination->initialize($config);
                    $data["links"]              = $this->pagination->create_links();
                    $data['page']               = $page = ($p9 != null) ? $p9 : 0;
                    $data['per_page']           = $config["per_page"];
                    $data['purchase_report']    = $this->reports_model->get_purchase_report($shop_id, $from_date, $to_date, $vendor_id, $search, $brand_id, $parent_cat_id, $child_cat_id, $config["per_page"], $page);
                    $data['categories']     = $this->reports_model->view_data('products_category');
                    $data['purchase_result']    = $this->reports_model->get_purchase_result($shop_id, $from_date, $to_date, $vendor_id, $search, $brand_id, $parent_cat_id, $child_cat_id);
                }
                
                $data['empty'] = "";
                $page                       = 'shop/reports/purchase_report/tb';
                $this->load->view($page, $data);
                break;
            case 'export_to_excel':
                $from_date = $p1;
                $to_date = $p2;
                $shop_id     = $_SESSION['user_data']['id'];
                $result = $this->reports_model->export_purchase_report($shop_id, $from_date, $to_date, $p3, $p4, $p5, $p6, $p7, $p8);
                $categories     = $this->reports_model->view_data('products_category');
                $spreadsheet = new Spreadsheet();
                $sheet = $spreadsheet->getActiveSheet();
                $sheet->setCellValue('A1', 'S.No.');
                $sheet->setCellValue('B1', 'Purchase Date');
                $sheet->setCellValue('C1', 'Invoice no');
                $sheet->setCellValue('D1', 'Product Code');
                $sheet->setCellValue('E1', 'Brand');
                $sheet->setCellValue('F1', 'Product Name');
                $sheet->setCellValue('G1', 'Hsn/Sac');
                $sheet->setCellValue('H1', 'Vendor Name');
                $sheet->setCellValue('I1', 'Vendor Code');
                $sheet->setCellValue('J1', 'Quantity');
                $sheet->setCellValue('K1', 'Unit Type');
                $sheet->setCellValue('L1', 'Expiry Date');
                $sheet->setCellValue('M1', 'MRP');
                $sheet->setCellValue('N1', 'Total MRP Value');
                $sheet->setCellValue('O1', 'Unit Price without tax');
                $sheet->setCellValue('P1', 'Total without tax');
                $sheet->setCellValue('Q1', 'UP/EXUP');
                $sheet->setCellValue('R1', 'Tax rate');
                $sheet->setCellValue('S1', 'Igst rate');
                $sheet->setCellValue('T1', 'Cgst rate');
                $sheet->setCellValue('U1', 'Sgst rate');
                $sheet->setCellValue('V1', 'Igst value');
                $sheet->setCellValue('W1', 'Cgst value');
                $sheet->setCellValue('X1', 'Sgst value');
                $sheet->setCellValue('Y1', 'Total tax');
                $sheet->setCellValue('Z1', 'Total value with tax');
                $sheet->setCellValue('AA1', 'Product Price / Piece');
                $sheet->setCellValue('AB1', 'Additional Discount');
                $sheet->setCellValue('AC1', 'GSTIN');
                $sheet->setCellValue('AD1', 'Address');
                $sheet->setCellValue('AE1', 'Software Parent Category');
                $sheet->setCellValue('AF1', 'Software Sub-Category');
                $sheet->setCellValue('AG1', 'Product Category');
                $sheet->setCellValue('AH1', 'Purchase Type');
                $count = 2;
                $i = 1;
                foreach ($result as $value) {

                    $purchase_rate = $value->purchase_rate;
                    $tax =  $value->tax_value;
                    $inclusive_tax = $purchase_rate - ($purchase_rate * (100 / (100 + $tax)));
                    $unit_price_without_tax =  $purchase_rate - $inclusive_tax;
                    $total_without_tax = $unit_price_without_tax * $value->qty;

                    if ($value->is_igst == 1) {
                        $igst = $value->tax_value;
                        $cgst = 0;
                        $sgst = 0;
                        $cgst_val = 0;
                        $sgst_val = 0;
                        $igst_val = $inclusive_tax;
                        $up_exup = 'EXUP';
                    } else if ($value->is_igst == 0) {
                        $cgst = $value->tax_value / 2;
                        $sgst = $value->tax_value / 2;
                        $cgst_val = $inclusive_tax / 2;
                        $sgst_val = $inclusive_tax / 2;
                        $igst = 0;
                        $igst_val = 0;
                        $up_exup = 'UP';
                    }
                    $cat_name = "";
                    $subcat_name = "";
                    $Parent_cat_name = "";
                    foreach ($categories as $cat) {
                        if ($cat->id == $value->parent_cat_id) {
                            $cat_name = $cat->name;
                        }
                    }
                    foreach ($categories as $cat) {
                        if ($cat->id == $value->sub_cat_id) {
                            $subcat_name = $cat->name;
                        }
                    }
                    foreach ($categories as $cat) {
                        if ($cat->id == $value->parent_cat_id) {
                            $Parent_cat_name = $cat->name;
                        }
                    }
                    $total_tax = $inclusive_tax * $value->qty;
                    $total_value_with_tax = $total_without_tax + $total_tax;

                    $sheet->setCellValue('A' . $count, $i++);
                    $sheet->setCellValue('B' . $count, date_format_func($value->invoice_date));
                    $sheet->setCellValue('C' . $count, $value->invoice_no);
                    $sheet->setCellValue('D' . $count, $value->product_code);
                    $sheet->setCellValue('E' . $count, $value->brand_name);
                    $sheet->setCellValue('F' . $count, $value->product_name);
                    $sheet->setCellValue('G' . $count, $value->sku);
                    $sheet->setCellValue('H' . $count, $value->vendor_name);
                    $sheet->setCellValue('I' . $count, $value->vendor_code);
                    $sheet->setCellValue('J' . $count, $value->qty);
                    $sheet->setCellValue('K' . $count, $value->unit_type);
                    $sheet->setCellValue('L' . $count, $value->expiry_date);
                    $sheet->setCellValue('M' . $count, $value->mrp);
                    $sheet->setCellValue('N' . $count, ($value->mrp*$value->qty));
                    $sheet->setCellValue('O' . $count, round($unit_price_without_tax,2));
                    $sheet->setCellValue('P' . $count, round($total_without_tax,2));
                    $sheet->setCellValue('Q' . $count, $up_exup);
                    $sheet->setCellValue('R' . $count, round($value->tax_value, 2));
                    $sheet->setCellValue('S' . $count, round($igst, 2));
                    $sheet->setCellValue('T' . $count, round($cgst, 2));
                    $sheet->setCellValue('U' . $count, round($sgst, 2));
                    $sheet->setCellValue('V' . $count, round($igst_val, 2));
                    $sheet->setCellValue('W' . $count, round($cgst_val, 2));
                    $sheet->setCellValue('X' . $count, round($sgst_val, 2));
                    $sheet->setCellValue('Y' . $count, round($total_tax,2));
                    $sheet->setCellValue('Z'. $count, round($total_value_with_tax,2));
                    $sheet->setCellValue('AA'. $count, $value->purchase_rate);
                    $sheet->setCellValue('AB'. $count, $value->AdditionalDiscount);
                    $sheet->setCellValue('AC'. $count, $value->gstin);
                    $sheet->setCellValue('AD'. $count, $value->vendor_address);
                    $sheet->setCellValue('AE'. $count, $cat_name);
                    $sheet->setCellValue('AF'. $count, $subcat_name);
                    $sheet->setCellValue('AG'. $count, $Parent_cat_name);
                    $sheet->setCellValue('AH'. $count, 'Bill');
                    $count++;
                }
                $writer = new Xlsx($spreadsheet);
                $filename = 'Purchase_Report';
                header('Content-Type: application/vnd.ms-excel');
                header('Content-Disposition: attachment;filename="' . $filename . '.xls"');
                header('Cache-Control: max-age=0');
                $writer->save('php://output'); // download file
                break;
            default:
                # code...
                break;
        }
    }
    public function sales_report($action = null, $p1 = null, $p2 = null, $p3 = null, $p4 = null, $p5 = null, $p6 = null, $p7 = null, $p8 = null, $p9 = null, $p10 = null, $p11 = null, $p12 = null, $p13 = null)
    {
        switch ($action) {
            case null:
                $data['title']          = 'Sales Report';
                $data['tb_url']         = base_url() . 'sales-report/tb';
                $page                   = 'shop/reports/sales_report/index';
                $this->header_and_footer($page, $data);
                break;

            case 'tb':



                $data['from_date'] = '';
                $data['to_date'] = '';
                $data['pmid'] = 'null';
                $data['search'] = 'null';
                $data['status_id'] = 'null';
                $data['brand_id'] = 'null';
                $data['parent_id'] = 'null';
                $data['parent_cat_id'] = 'null';
                $data['child_cat_id'] = 'null';
                $data['product_id'] = 'null';
                $data['subscription'] = 'null';
                $data['plan_type_id'] = 'null';

                //below variable section used for models and other places
                $from_date = 'null';
                $to_date = 'null';
                $pm_id = 'null';
                $search = 'null';
                $status_id = 'null';
                $brand_id = 'null';
                $parent_cat_id = 'null';
                $parent_id = 'null';
                $child_cat_id = 'null';
                $product_id = 'null';
                $subscription = 'null';
                $plan_type_id = 'null';

                //get section intiliazation
                if ($p2 != null) {
                    $data['from_date'] = $p1;
                    $data['to_date'] = $p2;
                    $from_date = $p1;
                    $to_date = $p2;
                }
                if ($p3 != null) {
                    $data['pmid'] = $p3;
                    $pm_id = $p3;
                }
                if ($p4 != null) {
                    $data['search'] = $p4;
                    $search = $p4;
                }
                if ($p5 != null) {
                    $data['status_id'] = $p5;
                    $status_id = $p5;
                }
                if ($p6 != null) {
                    $data['brand_id'] = $p6;
                    $brand_id = $p6;
                }
                if ($p7 != null) {

                    $data['parent_id'] = $p7;
                    $parent_id = $p7;
                }
                if ($p8 != null) {
                    $data['parent_cat_id'] = $p8;
                    $parent_cat_id = $p8;
                    $data['sub_cat'] = $this->db->get_where('products_category', ['is_parent' => $parent_id, 'is_deleted' => 'NOT_DELETED'])->result();
                }
                if ($p9 != null) {
                    $data['child_cat_id'] = $p9;
                    $child_cat_id = $p9;
                    $data['child_cat'] = $this->db->get_where('products_category', ['is_parent' => $p8, 'is_deleted' => 'NOT_DELETED'])->result();
                }
                if ($p10 != null) {
                    $data['product_id'] = $p10;
                    $product_id = $p10;
                }
                if ($p11 != null) {
                    $data['subscription'] = $p11;
                    $subscription = $p11;
                }
                if ($p12 != null) {
                    $data['plan_type_id'] = $p12;
                    $plan_type_id = $p12;
                }

                //end of section

                //post section intiliazation
                if (@$_POST['from_date']) {

                    $data['from_date'] = $_POST['from_date'];
                    $data['to_date'] = $_POST['to_date'];
                    $from_date = $_POST['from_date'];
                    $to_date = $_POST['to_date'];
                }
                if (@$_POST['pm_id']) {
                    $data['pmid'] = $_POST['pm_id'];
                    $pm_id = $_POST['pm_id'];
                }
                if (@$_POST['search']) {
                    $data['search'] = $_POST['search'];
                    $search = $_POST['search'];
                }
                if (@$_POST['status_id']) {
                    $data['status_id'] = $_POST['status_id'];
                    $status_id = $_POST['status_id'];
                }
                if (@$_POST['brand_id']) {
                    $data['brand_id'] = $_POST['brand_id'];
                    $brand_id = $_POST['brand_id'];
                }
                if (@$_POST['parent_cat_id']) {
                    $data['parent_cat_id'] = $_POST['parent_cat_id'];
                    $parent_cat_id = $_POST['parent_cat_id'];
                    $data['parent_id'] = $_POST['parent_id'];
                    $parent_id = $_POST['parent_id'];
                    $data['sub_cat'] = $this->db->get_where('products_category', ['is_parent' => $parent_id, 'is_deleted' => 'NOT_DELETED'])->result();
                }
                if (@$_POST['child_cat_id']) {
                    $data['child_cat_id'] = $_POST['child_cat_id'];
                    $child_cat_id = $_POST['child_cat_id'];
                    $data['child_cat'] = $this->db->get_where('products_category', ['is_parent' => $parent_cat_id, 'is_deleted' => 'NOT_DELETED'])->result();
                }
                if (@$_POST['product_id']) {
                    $data['product_id'] = $_POST['product_id'];
                    $product_id = $_POST['product_id'];
                }
                if (@$_POST['subscription']) {
                    $data['subscription'] = $_POST['subscription'];
                    $subscription = $_POST['subscription'];
                }
                if (@$_POST['plan_type_id']) {
                    $data['plan_type_id'] = $_POST['plan_type_id'];
                    $plan_type_id = $_POST['plan_type_id'];
                }
                if ($data['to_date'] != '') {
                    $this->load->library('pagination');
                    $config = array();

                    $shop_id     = $_SESSION['user_data']['id'];
                    $config["base_url"]         = base_url() . "sales-report/tb/" . $from_date . "/" . $to_date . "/" . $pm_id . "/" . $search . "/" . $status_id . "/" . $brand_id . "/" . $parent_id . "/" . $parent_cat_id . "/" . $child_cat_id . "/" . $product_id . "/" . $subscription . "/" . $plan_type_id;
                    $config["total_rows"]       = $this->reports_model->get_sales_report($shop_id, $from_date, $to_date, $pm_id, $search, $status_id, $brand_id, $parent_cat_id, $child_cat_id, $product_id, $subscription, $plan_type_id);

                    $data['total_rows']         = $config["total_rows"];
                    $config["per_page"]         = 10;
                    $config["uri_segment"]      = 15;
                    $config['attributes']       = array('class' => 'pag-link');
                    $config['full_tag_open']    = "<div class='pag'>";
                    $config['full_tag_close']   = "</div>";
                    $config['first_link']       = '&lt;&lt;';
                    $config['last_link']        = '&gt;&gt;';
                    $this->pagination->initialize($config);
                    $data["links"]              = $this->pagination->create_links();


                    $data['page']               = $page = ($p13 != null) ? $p13 : 0;
                    $data['per_page']           = $config["per_page"];

                    $data['sales_report']           = $this->reports_model->get_sales_report($shop_id, $from_date, $to_date, $pm_id, $search, $status_id, $brand_id, $parent_cat_id, $child_cat_id, $product_id, $subscription, $plan_type_id, $config["per_page"], $page);
                    $data['categories']     = $this->reports_model->view_data('products_category');
                    $data['sales_result'] = $this->reports_model->calculate_sales_report($shop_id, $from_date, $to_date, $pm_id, $search, $status_id, $brand_id, $parent_cat_id, $child_cat_id, $product_id, $subscription, $plan_type_id);
                }
                $data['order_status'] = $this->master_model->get_data1('order_status_master', 'active', '1');
                $data['brands'] = $this->master_model->get_data('brand_master', 'active', '1');
                $data['payment_mode'] = $this->master_model->view_data1('payment_mode_master');
                $data['empty'] = "";
                $data['parent_cat'] = $this->master_model->get_data('products_category', 'is_parent', '0');
                $data['plan_types'] = $this->reports_model->get_data1('subscriptions_plan_types', 'active', '1');
                // $data['child_cat'] = $this->db->get_where('products_category',['is_parent' => $parent_cat_id , 'is_deleted' => 'NOT_DELETED'])->result();
                $page                       = 'shop/reports/sales_report/tb';
                $this->load->view($page, $data);
                break;
            case 'export_to_excel':

                $from_date = $p1;
                $to_date = $p2;

                $shop_id     = $_SESSION['user_data']['id'];
                $result = $this->reports_model->export_sales_report($shop_id, $from_date, $to_date, $p3, $p4, $p5, $p6, $p7, $p8, $p9, $p10, $p11, $p12);
                $categories     = $this->reports_model->view_data('products_category');

                $spreadsheet = new Spreadsheet();
                $sheet = $spreadsheet->getActiveSheet();
                $sheet->setCellValue('A1', 'S.No.');
                $sheet->setCellValue('B1', 'Order date');
                $sheet->setCellValue('C1', 'Category');
                $sheet->setCellValue('D1', 'Product Category');
                $sheet->setCellValue('E1', 'Product code');
                $sheet->setCellValue('F1', 'Product name');
                $sheet->setCellValue('G1', 'Customer name');
                $sheet->setCellValue('H1', 'Customer number');
                $sheet->setCellValue('I1', 'Invoice No.');
                $sheet->setCellValue('J1', 'Brand');
                $sheet->setCellValue('K1', 'Hsn/Sac');
                $sheet->setCellValue('L1', 'Qty');
                $sheet->setCellValue('M1', 'Unit Price without tax');
                $sheet->setCellValue('N1', 'Unit Price with tax');
                $sheet->setCellValue('O1', 'UP/EXUP');
                $sheet->setCellValue('P1', 'Tax rate');
                $sheet->setCellValue('Q1', 'Igst rate');
                $sheet->setCellValue('R1', 'Cgst rate');
                $sheet->setCellValue('S1', 'Sgst rate');
                $sheet->setCellValue('T1', 'Igst value');
                $sheet->setCellValue('U1', 'Cgst value');
                $sheet->setCellValue('V1', 'Sgst value');
                $sheet->setCellValue('W1', 'Total without tax');
                $sheet->setCellValue('X1', 'Total tax');
                $sheet->setCellValue('Y1', 'Total value with tax');
                $sheet->setCellValue('Z1', 'Payment Method');
                $sheet->setCellValue('AA1', 'Bank Name');
                $sheet->setCellValue('AB1', 'Razorpay Order ID');
                $count = 2;
                $i = 1;
                foreach ($result as $value) {

                    $sale_rate = $value->price_per_unit;
                    $tax =  $value->tax_value;
                    $inclusive_tax = $sale_rate - ($sale_rate * (100 / (100 + $tax)));

                    $unit_price_without_tax =  $sale_rate - $inclusive_tax;
                    $total_without_tax = $unit_price_without_tax * $value->qty;


                    if ($value->is_igst == 1) {
                        $igst = $value->tax_value;
                        $cgst = 0;
                        $sgst = 0;
                        $cgst_val = 0;
                        $sgst_val = 0;
                        $igst_val = $inclusive_tax;
                    } else if ($value->is_igst == 0) {
                        $cgst = $value->tax_value / 2;
                        $sgst = $value->tax_value / 2;
                        $cgst_val = $inclusive_tax / 2;
                        $sgst_val = $inclusive_tax / 2;
                        $igst = 0;
                        $igst_val = 0;
                    }

                    $total_tax = $inclusive_tax * $value->qty;
                    $total_value_with_tax = $total_without_tax + $total_tax;
                    // print_r($cgst_val);
                    if ($value->payment_method == 'cod') {
                        $payment_method = 'COD';
                    } else {
                        $payment_method = 'Razorpay';
                    }
                    $cat_name = "";
                    $subcat_name = "";
                    foreach ($categories as $cat) {
                        if ($cat->id == $value->parent_cat_id) {
                            $cat_name = $cat->name;
                        }
                    }
                    foreach ($categories as $cat) {
                        if ($cat->id == $value->sub_cat_id) {
                            $subcat_name = $cat->name;
                        }
                    }
                    $sheet->setCellValue('A' . $count, $i++);
                    $sheet->setCellValue('B' . $count, date_format_func($value->order_date));
                    $sheet->setCellValue('C' . $count, $cat_name);
                    $sheet->setCellValue('D' . $count, $subcat_name);
                    $sheet->setCellValue('E' . $count, $value->product_code);
                    $sheet->setCellValue('F' . $count, $value->product_name);
                    $sheet->setCellValue('G' . $count, $value->fname . ' ' . $value->lname);
                    $sheet->setCellValue('H' . $count, $value->mobile);
                    $sheet->setCellValue('I' . $count, $value->orderid);
                    $sheet->setCellValue('J' . $count, $value->brand_name);
                    $sheet->setCellValue('K' . $count, $value->sku);
                    $sheet->setCellValue('L' . $count, $value->qty);
                    $sheet->setCellValue('M' . $count, round($unit_price_without_tax, 2));
                    $sheet->setCellValue('N' . $count, round($value->price_per_unit, 2));
                    $sheet->setCellValue('O' . $count, 'UP');
                    $sheet->setCellValue('P' . $count, round($value->tax_value, 2));
                    $sheet->setCellValue('Q' . $count, round($igst, 2));
                    $sheet->setCellValue('R' . $count, round($cgst, 2));
                    $sheet->setCellValue('S' . $count, round($sgst, 2));
                    $sheet->setCellValue('T' . $count, round($igst_val, 2));
                    $sheet->setCellValue('U' . $count, round($cgst_val, 2));
                    $sheet->setCellValue('V' . $count, round($sgst_val, 2));
                    $sheet->setCellValue('W' . $count, round($total_without_tax, 2));
                    $sheet->setCellValue('X' . $count, round($total_tax, 2));
                    $sheet->setCellValue('Y' . $count, round($total_value_with_tax, 2));
                    $sheet->setCellValue('Z' . $count, $payment_method);
                    $sheet->setCellValue('AA' . $count, $value->bank_name);
                    $sheet->setCellValue('AB' . $count, $value->razorpay_order_id);
                    $count++;
                }

                // die();
                $writer = new Xlsx($spreadsheet);
                $filename = 'Sales_Report';
                header('Content-Type: application/vnd.ms-excel');
                header('Content-Disposition: attachment;filename="' . $filename . '.xls"');
                header('Cache-Control: max-age=0');
                $writer->save('php://output'); // download file
                break;

            default:
                # code...
                break;
        }
    }

    //Ankit Verma

    public function pos_sales_report($action = null, $p1 = null, $p2 = null, $p3 = null, $p4 = null, $p5 = null, $p6 = null, $p7 = null, $p8 = null, $p9 = null, $p10 = null, $p11 = null, $p12 = null, $p13 = null)
    {
         $shop_id     = $_SESSION['user_data']['id'];

        // echo _prx([
        //     'action'=>$action,
        //     'p1'=>$p1,
        //     'p2'=>$p2,
        //     'p3'=>$p3,
        //     'p4'=>$p4,
        //     'p5'=>$p5,
        //     'p6'=>$p6,
        //     'p7'=>$p7,
        //     'p8'=>$p8,
        //     'p9'=>$p9,
        //     'p10'=>$p10,
        //     'p11'=>$p11,
        //     'p12'=>$p12,
        //     'p13'=>$p13
        // ]);
        $uri = $this->uri->segment_array();
        // echo _prx($uri);
        switch ($action) {
            case null:
                $data['title']          = 'Pos-Sales Report';
                $data['tb_url']         = base_url() . 'pos-sales-report/tb';
                $data['parent_cat'] = $this->master_model->get_data('products_category', 'is_parent', '0');
                $data['brands'] = $this->master_model->get_brands($shop_id);
                $data['customers'] = $this->master_model->get_customers($shop_id);
                $data['order_status'] = $this->master_model->get_data1('order_status_master', 'active', '1');
                $page                   = 'shop/reports/pos_sales_report/index';
                $this->header_and_footer($page, $data);
                break;

            case 'tb':


            // echo _prx($_POST);
            // die();



                // $data['from_date'] = '';
                // $data['to_date'] = '';
                // $data['pmid'] = 'null';
                // $data['search'] = 'null';
                // $data['status_id'] = 'null';
                // $data['brand_id'] = 'null';
                // $data['parent_id'] = 'null';
                // $data['parent_cat_id'] = 'null';
                // $data['child_cat_id'] = 'null';
                // $data['product_id'] = 'null';
                // $data['subscription'] = 'null';
                // $data['plan_type_id'] = 'null';

                // //below variable section used for models and other places
                // $from_date = 'null';
                // $to_date = 'null';
                // $pm_id = 'null';
                // $search = 'null';
                // $status_id = 'null';
                // $brand_id = 'null';
                // $parent_cat_id = 'null';
                // $parent_id = 'null';
                // $child_cat_id = 'null';
                // $product_id = 'null';
                // $subscription = 'null';
                // $plan_type_id = 'null';

                // //get section intiliazation
                // if ($p2 != null) {
                //     $data['from_date'] = $p1;
                //     $data['to_date'] = $p2;
                //     $from_date = $p1;
                //     $to_date = $p2;
                // }
                // if ($p3 != null) {
                //     $data['pmid'] = $p3;
                //     $pm_id = $p3;
                // }
                // if ($p4 != null) {
                //     $data['search'] = $p4;
                //     $search = $p4;
                // }
                // if ($p5 != null) {
                //     $data['status_id'] = $p5;
                //     $status_id = $p5;
                // }
                // if ($p6 != null) {
                //     $data['brand_id'] = $p6;
                //     $brand_id = $p6;
                // }
                // if ($p7 != null) {

                //     $data['parent_id'] = $p7;
                //     $parent_id = $p7;
                // }
                // if ($p8 != null) {
                //     $data['parent_cat_id'] = $p8;
                //     $parent_cat_id = $p8;
                //     $data['sub_cat'] = $this->db->get_where('products_category', ['is_parent' => $parent_id, 'is_deleted' => 'NOT_DELETED'])->result();
                // }
                // if ($p9 != null) {
                //     $data['child_cat_id'] = $p9;
                //     $child_cat_id = $p9;
                //     $data['child_cat'] = $this->db->get_where('products_category', ['is_parent' => $p8, 'is_deleted' => 'NOT_DELETED'])->result();
                // }
                // if ($p10 != null) {
                //     $data['product_id'] = $p10;
                //     $product_id = $p10;
                // }
              

                // //end of section

                // //post section intiliazation
                // if (@$_POST['from_date']) {

                //     $data['from_date'] = $_POST['from_date'];
                //     $data['to_date'] = $_POST['to_date'];
                //     $from_date = $_POST['from_date'];
                //     $to_date = $_POST['to_date'];
                // }
                // if (@$_POST['pm_id']) {
                //     $data['pmid'] = $_POST['pm_id'];
                //     $pm_id = $_POST['pm_id'];
                // }
                // if (@$_POST['search']) {
                //     $data['search'] = $_POST['search'];
                //     $search = $_POST['search'];
                // }
                // if (@$_POST['status_id']) {
                //     $data['status_id'] = $_POST['status_id'];
                //     $status_id = $_POST['status_id'];
                // }
                // if (@$_POST['brand_id']) {
                //     $data['brand_id'] = $_POST['brand_id'];
                //     $brand_id = $_POST['brand_id'];
                // }
                // if (@$_POST['parent_cat_id']) {
                //     $data['parent_cat_id'] = $_POST['parent_cat_id'];
                //     $parent_cat_id = $_POST['parent_cat_id'];
                //     $data['parent_id'] = $_POST['parent_id'];
                //     $parent_id = $_POST['parent_id'];
                //     $data['sub_cat'] = $this->db->get_where('products_category', ['is_parent' => $parent_id, 'is_deleted' => 'NOT_DELETED'])->result();
                // }
                // if (@$_POST['child_cat_id']) {
                //     $data['child_cat_id'] = $_POST['child_cat_id'];
                //     $child_cat_id = $_POST['child_cat_id'];
                //     $data['child_cat'] = $this->db->get_where('products_category', ['is_parent' => $parent_cat_id, 'is_deleted' => 'NOT_DELETED'])->result();
                // }
                // if (@$_POST['product_id']) {
                //     $data['product_id'] = $_POST['product_id'];
                //     $product_id = $_POST['product_id'];
                // }
                // if (@$_POST['subscription']) {
                //     $data['subscription'] = $_POST['subscription'];
                //     $subscription = $_POST['subscription'];
                // }
                // if (@$_POST['plan_type_id']) {
                //     $data['plan_type_id'] = $_POST['plan_type_id'];
                //     $plan_type_id = $_POST['plan_type_id'];
                // }
                // if ($data['to_date'] != '') {

                $p = $this->input->post();
                $data['from_date']      = (@$p['from_date']) ? $p['from_date'] : 'null';  
                $data['to_date']        = (@$p['to_date']) ? $p['to_date'] : 'null';  
                $data['customer_id']    = (@$p['customer_id']) ? $p['customer_id'] : 'null';  
                $data['parent_id']      = (@$p['parent_id']) ? $p['parent_id'] : 'null';  
                $data['parent_cat_id']  = (@$p['parent_cat_id']) ? $p['parent_cat_id'] : 'null';  
                $data['sub_cat_id']     = (@$p['sub_cat_id']) ? $p['sub_cat_id'] : 'null';  
                $data['product_id']     = (@$p['product_id']) ? $p['product_id'] : 'null';  
                $data['brand_id']       = (@$p['brand_id']) ? $p['brand_id'] : 'null';  
                $data['status_id']      = (@$p['status_id']) ? $p['status_id'] : 'null';  
                $data['tb_search']      = (@$p['tb_search']) ? $p['tb_search'] : 'null'; 
                    $this->load->library('pagination');
                    $config = array();

                    $shop_id     = $_SESSION['user_data']['id'];
                    $config["base_url"]         = base_url() . "pos-sales-report/tb/";
                    $config["total_rows"]       = $this->reports_model->get_pos_sales_report($shop_id);

                    $data['total_rows']         = $config["total_rows"];
                    $config["per_page"]         = 10;
                    $config["uri_segment"]      = 3;
                    $config['attributes']       = array('class' => 'pag-link');
                    $config['full_tag_open']    = "<div class='pag'>";
                    $config['full_tag_close']   = "</div>";
                    $config['first_link']       = '&lt;&lt;';
                    $config['last_link']        = '&gt;&gt;';
                    $this->pagination->initialize($config);
                    $data["links"]              = $this->pagination->create_links();


                    $data['page']               = $page = ($p1 != null) ? $p1 : 0;
                    $data['per_page']           = $config["per_page"];

                    $data['sales_report']           = $this->reports_model->get_pos_sales_report($shop_id,$config["per_page"], $page);

                    // echo _prx($data['sales_report']);
                    // die();
                    $data['categories']     = $this->reports_model->view_data('products_category');
                    $data['sales_result'] = $this->reports_model->calculate_pos_sales_report($shop_id,);

                    //  echo _prx($data['sales_result']);
                    // die();
                // }
                // $data['order_status'] = $this->master_model->get_data1('order_status_master', 'active', '1');
                // $data['brands'] = $this->master_model->get_data('brand_master', 'active', '1');
                // $data['payment_mode'] = $this->master_model->view_data1('payment_mode_master');
                // $data['empty'] = "";
                // $data['parent_cat'] = $this->master_model->get_data('products_category', 'is_parent', '0');
                // $data['plan_types'] = $this->reports_model->get_data1('subscriptions_plan_types', 'active', '1');
                // $data['child_cat'] = $this->db->get_where('products_category',['is_parent' => $parent_cat_id , 'is_deleted' => 'NOT_DELETED'])->result();
                $page                       = 'shop/reports/pos_sales_report/tb';
                $this->load->view($page, $data);
                break;
            case 'export_to_excel':

                $filter['from_date']      = $p1;
                $filter['to_date']        = $p2;
                $filter['customer_id']    = $p3;
                $filter['parent_id']      = $p4;
                $filter['parent_cat_id']  = $p5;
                $filter['sub_cat_id']     = $p6;
                $filter['product_id']     = $p7;
                $filter['brand_id']       = $p8;
                $filter['status_id']      = $p9;
                $filter['tb_search']      = $p10;
                $filter['shop_id']          = $_SESSION['user_data']['id'];

                $result = $this->reports_model->export_pos_sales_report($filter);

                // echo _prx($result);

                // die();




                $categories     = $this->reports_model->view_data('products_category');

                $spreadsheet = new Spreadsheet();
                $sheet = $spreadsheet->getActiveSheet();
                $sheet->setCellValue('A1', 'S.No.');
                $sheet->setCellValue('B1', 'Invoice Date');
                $sheet->setCellValue('C1', 'Invoice No.');
                $sheet->setCellValue('D1', 'Product Code');
                $sheet->setCellValue('E1', 'Brand');
                $sheet->setCellValue('F1', 'Product Name');
                $sheet->setCellValue('G1', 'Hsn/Sac');
                $sheet->setCellValue('H1', 'Customer name');
                $sheet->setCellValue('I1', 'Customer Code');
                $sheet->setCellValue('J1', 'Qty');
                $sheet->setCellValue('K1', 'Mrp');
                $sheet->setCellValue('L1', 'Sche');
                $sheet->setCellValue('M1', 'Ad Sche');
                $sheet->setCellValue('N1', 'Free');
                $sheet->setCellValue('O1', 'Unit Price without tax');
                $sheet->setCellValue('P1', 'Unit Price with tax');
                $sheet->setCellValue('Q1', 'UP/EXUP');
                $sheet->setCellValue('R1', 'Tax rate');
                $sheet->setCellValue('S1', 'Igst rate');
                $sheet->setCellValue('T1', 'Cgst rate');
                $sheet->setCellValue('U1', 'Sgst rate');
                $sheet->setCellValue('V1', 'Igst value');
                $sheet->setCellValue('W1', 'Cgst value');
                $sheet->setCellValue('X1', 'Sgst value');
                $sheet->setCellValue('Y1', 'Total without tax');
                $sheet->setCellValue('Z1', 'Total tax');
                $sheet->setCellValue('AA1', 'Total value with tax');
                $sheet->setCellValue('AB1', 'Category');
                $sheet->setCellValue('AC1', 'Product Category');
                $sheet->setCellValue('AD1', 'Customer number');
                $count = 2;
                $i = 1;
                foreach ($result as $value) {

                    $sale_rate = $value->mrp;
                    $tax =  $value->tax_value;
                    $inclusive_tax = $sale_rate - ($sale_rate * (100 / (100 + $tax)));

                    $unit_price_without_tax =  $sale_rate - $inclusive_tax;
                    $total_without_tax = $unit_price_without_tax * $value->qty;


                    if ($value->is_igst == 1) {
                        $igst = $value->tax_value;
                        $cgst = 0;
                        $sgst = 0;
                        $cgst_val = 0;
                        $sgst_val = 0;
                        $igst_val = $inclusive_tax;
                    } else if ($value->is_igst == 0) {
                        $cgst = $value->tax_value / 2;
                        $sgst = $value->tax_value / 2;
                        $cgst_val = $inclusive_tax / 2;
                        $sgst_val = $inclusive_tax / 2;
                        $igst = 0;
                        $igst_val = 0;
                    }

                    $total_tax = $inclusive_tax * $value->qty;
                    $total_value_with_tax = $total_without_tax + $total_tax;
                    // print_r($cgst_val);
                    if ($value->payment_method == 'cod') {
                        $payment_method = 'COD';
                    } else {
                        $payment_method = 'Razorpay';
                    }
                    $cat_name = "";
                    $subcat_name = "";
                    foreach ($categories as $cat) {
                        if ($cat->id == $value->parent_cat_id) {
                            $cat_name = $cat->name;
                        }
                    }
                    foreach ($categories as $cat) {
                        if ($cat->id == $value->sub_cat_id) {
                            $subcat_name = $cat->name;
                        }
                    }
                    $sheet->setCellValue('A' . $count, $i++);
                    $sheet->setCellValue('B' . $count, date_format_func($value->order_date));
                    $sheet->setCellValue('C' . $count, $value->orderid);
                    $sheet->setCellValue('D' . $count, $value->product_code);
                    $sheet->setCellValue('E' . $count, $value->brand_name);
                    $sheet->setCellValue('F' . $count, $value->product_name);
                    $sheet->setCellValue('G' . $count, $value->sku);
                    $sheet->setCellValue('H' . $count, $value->name);
                    $sheet->setCellValue('I' . $count, $value->vendor_code);
                    $sheet->setCellValue('J' . $count, $value->qty);
                    $sheet->setCellValue('K' . $count, $value->price_per_unit);

                    $offer_type1_1 = ($value->discount_type==0) ? '%' : '';
                    $offer_type1_2 = ($value->discount_type==1) ? '₹' : '';
                    $sheet->setCellValue('L' . $count, $offer_type1_2.' '.$value->offer_applied.' '.$offer_type1_1);

                    $offer_type2_1 = ($value->discount_type2==0) ? '%' : '';
                    $offer_type2_2 = ($value->discount_type2==1) ? '₹' : '';
                    $sheet->setCellValue('M' . $count, $offer_type2_2.' '.$value->offer_applied2.' '.$offer_type2_1);

                    $sheet->setCellValue('N' . $count, $value->free);
                    $sheet->setCellValue('O' . $count, round($unit_price_without_tax, 2));
                    $sheet->setCellValue('P' . $count, round($value->price_per_unit, 2));
                    $sheet->setCellValue('Q' . $count, 'UP');
                    $sheet->setCellValue('R' . $count, round($value->tax_value, 2));
                    $sheet->setCellValue('S' . $count, round($igst, 2));
                    $sheet->setCellValue('T' . $count, round($cgst, 2));
                    $sheet->setCellValue('U' . $count, round($sgst, 2));
                    $sheet->setCellValue('V' . $count, round($igst_val, 2));
                    $sheet->setCellValue('W' . $count, round($cgst_val, 2));
                    $sheet->setCellValue('X' . $count, round($sgst_val, 2));
                    $sheet->setCellValue('Y' . $count, round($total_without_tax, 2));
                    $sheet->setCellValue('Z' . $count, round($total_tax, 2));
                    $sheet->setCellValue('AA' . $count, round($total_value_with_tax, 2));
                    $sheet->setCellValue('AB' . $count, $cat_name);
                    $sheet->setCellValue('AC' . $count, $subcat_name);
                    $sheet->setCellValue('AD' . $count, $value->mobile);
                    $count++;
                }

                // die();
                $writer = new Xlsx($spreadsheet);
                $filename = 'Pos_Sales_Report';
                header('Content-Type: application/vnd.ms-excel');
                header('Content-Disposition: attachment;filename="' . $filename . '.xls"');
                header('Cache-Control: max-age=0');
                $writer->save('php://output'); // download file
                break;

            default:
                # code...
                break;
        }
    }
    public function fetch_category()
    {
        
        $pid = $this->input->get_post('parent_id');
        if (@$pid) {
            $this->master_model->fetch_category($pid);
        }
        else{
            echo "<option value=''>Select Parent Category First</option>";
        }
    }
   

    public function fill_products()
    {
        $data = $this->master_model->fill_products();

        // echo _prx($data);
        if (@$data) {
            echo "<option value=''>Select Product</option>";
            foreach($data as $val)
            {
                echo "<option value='" . $val->id . "'>" . $val->name . "</option>";
            }
        }
        else{
            echo "<option value=''>Select Category/Vendor First</option>";
        }
    }
}

