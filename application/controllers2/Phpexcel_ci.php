<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Phpexcel_ci extends CI_Controller {

    public function __construct(){
        parent::__construct();
    }

	public function exportStockImportTemplate(){
        if(isset($_GET['parent_cat_id']) && $_GET['parent_cat_id']!=='' && isset($_GET['shop_id']) && $_GET['shop_id']!==''){
            $productData = $this->products_subcategory_model->getRows(array('conditions'=>array('parent_cat_id'=>$_GET['parent_cat_id'],'active'=>'1')));
            $productCategoryData = $this->products_category_model->getRows(array('conditions'=>array('id'=>$_GET['parent_cat_id'],'active'=>'0')));
            $shopData = $this->shops_model->getRows(array('conditions'=>array('id'=>$_GET['shop_id'],'isActive'=>'1')));
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            $sheet->setCellValue('A1', 'Shop ID');
            $sheet->setCellValue('B1', 'Shop Name');
            $sheet->setCellValue('C1', 'Category ID');
            $sheet->setCellValue('D1', 'Category Name');
            $sheet->setCellValue('E1', 'Product Id');
            $sheet->setCellValue('F1', 'Product Code');
            $sheet->setCellValue('G1', 'Product Name');
            $sheet->setCellValue('H1', 'New Stock Quantity');
            $sheet->setCellValue('I1', 'New Purchase Rate');
            $sheet->setCellValue('J1', 'New MRP');
            $sheet->setCellValue('K1', 'New Selling Rate');
            $count = 2;
            foreach($productData as $pData){
                $sheet->setCellValue('A'.$count, $shopData[0]['id']);
                $sheet->setCellValue('B'.$count, $shopData[0]['shop_name']);
                $sheet->setCellValue('C'.$count, $productCategoryData[0]['id']);
                $sheet->setCellValue('D'.$count, $productCategoryData[0]['name']);
                $sheet->setCellValue('E'.$count, $pData['id']);
                $sheet->setCellValue('F'.$count, $pData['product_code']);
                $sheet->setCellValue('G'.$count, $pData['name']);
                $sheet->setCellValue('H'.$count, '');
                $sheet->setCellValue('I'.$count, '');
                $sheet->setCellValue('J'.$count, '');
                $sheet->setCellValue('K'.$count, '');
                $count++;
            }
            $writer = new Xlsx($spreadsheet);
            $filename = $productCategoryData[0]['name'].'-upload';
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"');
            header('Cache-Control: max-age=0');
            $writer->save('php://output'); // download file
            redirect(base_url('stocks/category/'.$_GET['parent_cat_id']));
        }        
    }

    public function importStockdata(){
        $file_mimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        if(isset($_FILES['import_file']['name']) && in_array($_FILES['import_file']['type'], $file_mimes)) {
            $arr_file = explode('.', $_FILES['import_file']['name']);
            $extension = end($arr_file);
            if('csv' == $extension) {
                $reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
            } else {
                $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
            }
            $spreadsheet = $reader->load($_FILES['import_file']['tmp_name']);
            $sheetData = $spreadsheet->getActiveSheet()->toArray();
            $flag = TRUE;
            $newCount = $count=0;
            $returnData = array();
            foreach($sheetData as $data){
                if($count>0){
                    if(!empty($data[7]) && !empty($data[9]) && !empty($data[10])){
                        $insertArray = array(
                            'product_id' => $data[4],            
                            'purchase_rate' => is_null($data[8])?0.00:$data[8],
                            'selling_rate' => $data[10],
                            'mrp' => $data[9],
                            'shop_id' => $data[0]
                        );
                        $checkExistingData=$this->shops_inventory_model->getRows(array('conditions'=>$insertArray));
                        if($checkExistingData===FALSE){
                            $insertArray['qty'] = $data[7];
                            $this->shops_inventory_model->insertRow($insertArray);
                            //log generated
                            $insertArray['action']="BATCH INSERT";
                            $this->shop_inventory_logs_model->insertRow($insertArray);
                        }else{
                            $this->shops_inventory_model->updateRow($checkExistingData[0]['id'],array('qty'=>($data[7]+$checkExistingData[0]['qty'])));
                            $insertArray['qty'] = $data[7];
                            $insertArray['action']="BATCH UPDATE";
                            $this->shop_inventory_logs_model->insertRow($insertArray);
                        }
                        $newCount++;
                    }
                }
                $count++;
            }
            echo json_encode(array('status'=>TRUE,'message'=>$newCount.' rows has been affected.'));
        }
    }
    public function verifyStockUpload(){
        $file_mimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        if(isset($_FILES['import_file']['name']) && in_array($_FILES['import_file']['type'], $file_mimes)) {
            $arr_file = explode('.', $_FILES['import_file']['name']);
            $extension = end($arr_file);
            if('csv' == $extension) {
                $reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
            } else {
                $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
            }
            $spreadsheet = $reader->load($_FILES['import_file']['tmp_name']);
            $sheetData = $spreadsheet->getActiveSheet()->toArray();
            $flag = TRUE;
            $count=0;
            $returnData = array();
            foreach($sheetData as $data){
                if($count>0){
                    $checkShopData = $this->shops_model->getRows(array('conditions'=>array('id'=> $data[0],'shop_name'=>$data[1])));
                    if($checkShopData===FALSE){
                        $flag = FALSE;
                        $returnData['message'] = 'Error found in shop data at row #'.($count+1);
                        $returnData['status'] = FALSE ;
                        break;
                    }else{
                        $checkCategoryData = $this->products_category_model->getRows(array('conditions'=>array('id'=> $data[2],'name'=> $data[3])));
                        if($checkCategoryData === FALSE){
                            $flag = FALSE;
                            $returnData['message'] = 'Error found in category data at row #'.($count+1);
                            $returnData['status'] = FALSE ;
                            break;
                        }else{
                            $checkProductData = $this->products_subcategory_model->getRows(array('conditions'=>array('id'=> $data[4],'product_code'=> $data[5],'parent_cat_id'=> $data[2],'name'=> $data[6])));
                            if($checkProductData === FALSE){
                                $flag = FALSE;
                                $returnData['message'] = 'Error found in product data at row #'.($count+1);
                                $returnData['status'] = FALSE ;
                                break;
                            }else{
                                $returnData['message'] = 'Everything seems good from our end. Total row count excluding headers are '.$count;
                                $returnData['status'] = TRUE ;
                            }
                        }
                    }
                }
                $count++;
            }
            echo json_encode($returnData);
        }
    }
}
?>