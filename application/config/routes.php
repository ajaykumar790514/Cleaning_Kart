<?php
defined('BASEPATH') OR exit('No direct script access allowed');


$route['default_controller'] = 'welcome';
$route['logout'] = 'welcome/logout';
$route['stocks'] = 'stocks/stock_category';
$route['stocks/(:num)'] = 'stocks/stock_sub_category/$1';
$route['stocks/category/(:num)'] = 'stocks/show_stocks/$1';



$route['orders'] = 'orders/index';
$route['orders/print/bill/(:num)'] = 'orders/orderPrintBill/$1';
$route['orders/(:num)'] = 'orders/orderDetails/$1';

$route['pos-orders'] = 'pos_orders/index';
$route['pos-orders/(:num)'] = 'pos_orders/index';
$route['pos_orders/print/bill/(:num)'] = 'pos_orders/orderPrintBill/$1';
$route['pos_orders/(:num)'] = 'pos_orders/orderDetails/$1';
$route['pos-return-items'] = 'pos_orders/return_items';

$route['pos_orders/proforma-invoice'] = 'pos_orders/proforma_invoice';
$route['select-customer']	=	'pos/select_customer';

$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

//Admin routes
$route['admin'] = 'admin';
$route['admin-login'] = 'admin/admin_login';
$route['admin-logout'] = 'admin/admin_logout';
$route['admin-dashboard'] = 'admin/admin_dashboard';
$route['admin-profile'] = 'admin/admin_profile';
$route['edit-admin-profile/(:num)'] = 'admin/edit_admin_profile';
$route['admin-change-password'] = 'admin/admin_change_password';
$route['update-admin-password'] = 'admin/update_admin_password';



//Master Routes
// $route['master-data/(:any)'] = 'master/check_role_menu';
$route['master-data/(:num)'] = 'master';
$route['master-data/(:any)'] = 'master/$1';
$route['master-data/(:any)/(:any)'] = 'master/$1/$2';
$route['master-data/(:any)/(:any)/(:any)'] = 'master/$1/$2/$3';
$route['master-data/(:any)/(:any)/(:any)/(:any)'] = 'master/$1/$2/$3/$4';

$route['categories/(:num)'] = 'master/categories';
$route['categories'] = 'master/categories';
$route['categories/(:any)'] 						= 'master/categories/$1';
$route['categories/(:any)/(:num)'] 				= 'master/categories/$1/$2';

// $route['add-category'] 				= 'master/add_category';
// $route['edit-category/(:num)'] 		= 'master/edit_category';
// $route['delete-category/(:num)'] 	= 'master/delete_category';

// $route['remote/(:any)'] 		= 'master/remote/$1';
// $route['remote/(:any)/(:any)'] 	= 'master/remote/$1/$2';
// $route['remote/(:any)/(:any)/(:any)'] = 'master/remote/$1/$2/$3';

$route['adminremote/(:any)'] 		= 'admin/adminremote/$1';
$route['adminremote/(:any)/(:any)'] 	= 'admin/adminremote/$1/$2';
$route['adminremote/(:any)/(:any)/(:any)'] = 'admin/adminremote/$1/$2/$3';

$route['society_remote/(:any)'] 		= 'master/society_remote/$1';
$route['society_remote/(:any)/(:any)'] 	= 'master/society_remote/$1/$2';
$route['society_remote/(:any)/(:any)/(:any)'] = 'master/society_remote/$1/$2/$3';

$route['subscription_remote/(:any)'] 		= 'Subscription/remote/$1';
$route['subscription_remote/(:any)/(:any)'] 	= 'Subscription/remote/$1/$2';
$route['subscription_remote/(:any)/(:any)/(:any)'] = 'Subscription/remote/$1/$2/$3';

// $route['acl_remote/(:any)'] 		= 'ACL/remote/$1';
// $route['acl_remote/(:any)/(:any)'] 	= 'ACL/remote/$1/$2';
// $route['acl_remote/(:any)/(:any)/(:any)'] = 'ACL/remote/$1/$2/$3';

$route['products/(:num)'] = 'master/products';
$route['products'] = 'master/products';
$route['products/(:any)'] 						= 'master/products/$1';
$route['products/(:any)/(:num)'] 				= 'master/products/$1/$2';
$route['products/(:any)/(:any)/(:num)'] 			= 'master/products/$1/$2/$3';
$route['products/(:any)/(:any)/(:any)'] 			= 'master/products/$1/$2/$3';
$route['products/(:any)/(:any)/(:any)/(:num)'] 	= 'master/products/$1/$2/$3/$4';
$route['products/(:any)/(:any)/(:any)/(:any)'] 	= 'master/products/$1/$2/$3/$4';
$route['products/(:any)/(:any)/(:any)/(:any)/(:num)'] 	= 'master/products/$1/$2/$3/$4/$5';
$route['products/(:any)/(:any)/(:any)/(:any)/(:any)'] 	= 'master/products/$1/$2/$3/$4/$5';
$route['products/(:any)/(:any)/(:any)/(:any)/(:any)/(:num)'] 	= 'master/products/$1/$2/$3/$4/$5/$6';
$route['products/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)'] 	= 'master/products/$1/$2/$3/$4/$5/$6';

$route['unit-master/(:num)'] = 'master/unit_master';
$route['product-property/(:num)'] = 'master/product_property';
$route['tax-slab/(:num)'] = 'master/tax_slab';
$route['pincodes-criteria/(:num)'] = 'master/pincodes_criteria';
$route['booking-slots/(:num)'] = 'master/booking_slots';
$route['society/(:num)'] = 'master/society';
$route['home-banners/(:num)'] 				= 'master/home_banners';

$route['home-header/(:num)'] 				= 'master/home_header';
// $route['add-home-header'] 				= 'master/add_home_header';
// $route['edit-home-header/(:num)'] 		= 'master/edit_home_header';
// $route['delete-home-header/(:num)'] 	= 'master/delete_home_header';

$route['product-headers-mapping/(:num)'] 	= 'master/product_headers_mapping';

$route['delete-header-mapping/(:num)'] 	= 'master/delete_header_mapping';
$route['cat-headers-mapping/(:num)'] 	= 'master/cat_headers_mapping';
$route['delete-cat-header-mapping/(:num)'] 	= 'master/delete_cat_header_mapping';

$route['shop-category/(:num)'] = 'master/shop_category';
$route['market-place-home-banners/(:num)'] 				= 'master/market_place_home_banners';
$route['cancellation-reason/(:num)'] = 'master/cancellation_reason';
$route['shop-social/(:num)'] = 'master/shop_social';

//Business Routes
$route['business-store/(:num)'] = 'business';
$route['business-store/(:any)'] = 'business/$1';
$route['business-store/(:any)/(:any)'] = 'business/$1/$2';
$route['business-store/(:any)/(:any)/(:any)'] = 'business/$1/$2/$3';
$route['business-store/(:any)/(:any)/(:any)/(:any)'] = 'business/$1/$2/$3/$4';

// $route['business_remote/(:any)'] 		= 'business/business_remote/$1';
// $route['business_remote/(:any)/(:any)'] 	= 'business/business_remote/$1/$2';
// $route['business_remote/(:any)/(:any)/(:any)'] = 'business/business_remote/$1/$2/$3';

// $route['businesses'] 								= 'business/businesses';
// $route['businesses/(:any)'] 						= 'business/businesses/$1';
// $route['businesses/(:any)/(:num)'] 				= 'business/businesses/$1/$2';
// $route['businesses/(:any)/(:any)/(:num)'] 		= 'business/businesses/$1/$2/$3';
// $route['businesses/(:any)/(:any)/(:any)'] 		= 'business/businesses/$1/$2/$3';
// $route['businesses/(:any)/(:any)/(:any)/(:num)'] 	= 'business/businesses/$1/$2/$3/$4';
// $route['businesses/(:any)/(:any)/(:any)/(:any)'] 	= 'business/businesses/$1/$2/$3/$4';
// $route['businesses/(:any)/(:any)/(:any)/(:any)/(:num)'] 	= 'business/businesses/$1/$2/$3/$4/$5';
// $route['businesses/(:any)/(:any)/(:any)/(:any)/(:any)'] 	= 'business/businesses/$1/$2/$3/$4/$5';
// $route['delete-business/(:any)'] 		= 'business/delete_business/';

$route['businesses'] = 'business/businesses';
$route['businesses/(:any)'] 						= 'business/businesses/$1';
$route['businesses/(:any)/(:num)'] 				= 'business/businesses/$1/$2';
$route['businesses/(:any)/(:any)/(:num)'] 			= 'business/businesses/$1/$2/$3';
$route['businesses/(:any)/(:any)/(:any)'] 			= 'business/businesses/$1/$2/$3';
$route['businesses/(:any)/(:any)/(:any)/(:num)'] 	= 'business/businesses/$1/$2/$3/$4';
$route['businesses/(:any)/(:any)/(:any)/(:any)'] 	= 'business/businesses/$1/$2/$3/$4';
$route['businesses/(:any)/(:any)/(:any)/(:any)/(:num)'] 	= 'business/businesses/$1/$2/$3/$4/$5';
$route['businesses/(:any)/(:any)/(:any)/(:any)/(:any)'] 	= 'business/businesses/$1/$2/$3/$4/$5';
$route['delete-business/(:any)'] 		= 'business/delete_business/';

//shops

$route['shops'] = 'business/shops';
$route['shops/(:num)'] = 'business/shops';
$route['shops/(:any)'] 						= 'business/shops/$1';
$route['shops/(:any)/(:num)'] 				= 'business/shops/$1/$2';
$route['shops/(:any)/(:any)/(:num)'] 			= 'business/shops/$1/$2/$3';
$route['shops/(:any)/(:any)/(:any)'] 			= 'business/shops/$1/$2/$3';
$route['shops/(:any)/(:any)/(:any)/(:num)'] 	= 'business/shops/$1/$2/$3/$4';
$route['shops/(:any)/(:any)/(:any)/(:any)'] 	= 'business/shops/$1/$2/$3/$4';
$route['shops/(:any)/(:any)/(:any)/(:any)/(:num)'] 	= 'business/shops/$1/$2/$3/$4/$5';
$route['shops/(:any)/(:any)/(:any)/(:any)/(:any)'] 	= 'business/shops/$1/$2/$3/$4/$5';
$route['shops/(:any)/(:any)/(:any)/(:any)/(:any)/(:num)'] 	= 'business/shops/$1/$2/$3/$4/$5/$6';
$route['shops/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)'] 	= 'business/shops/$1/$2/$3/$4/$5/$6';
$route['delete-shop/(:any)'] 		= 'business/delete_shop/';



//Offers & Coupons Routes
$route['offers-coupons/(:num)'] = 'offers_coupons_admin';
$route['offers-coupons/(:any)'] = 'offers_coupons_admin/$1';
$route['offers-coupons/(:any)/(:any)'] = 'offers_coupons_admin/$1/$2';
$route['offers-coupons/(:any)/(:any)/(:any)'] = 'offers_coupons_admin/$1/$2/$3';
$route['offers-coupons/(:any)/(:any)/(:any)/(:any)'] = 'offers_coupons_admin/$1/$2/$3/$4';

$route['offers/(:num)'] 								= 'offers_coupons_admin/offers';
$route['offers/(:any)'] 						= 'offers_coupons_admin/offers/$1';
$route['offers/(:any)/(:num)'] 				= 'offers_coupons_admin/offers/$1/$2';
$route['offers/(:any)/(:num)/(:num)'] 		= 'offers_coupons_admin/offers/$1/$2/$3';
$route['offers/(:any)/(:num)/(:num)/(:num)'] 	= 'offers_coupons_admin/offers/$1/$2/$3/$4';

//coupons

$route['coupons/(:num)'] 								= 'offers_coupons_admin/coupons';
$route['coupons/(:any)'] 						= 'offers_coupons_admin/coupons/$1';
$route['coupons/(:any)/(:num)'] 				= 'offers_coupons_admin/coupons/$1/$2';
$route['coupons/(:any)/(:num)/(:num)'] 		= 'offers_coupons_admin/coupons/$1/$2/$3';
$route['coupons/(:any)/(:num)/(:num)/(:num)'] 	= 'offers_coupons_admin/coupons/$1/$2/$3/$4';

$route['apply-offer/(:num)'] = 'offers_coupons_admin/apply_offer';

//Customer Acquisition

$route['customers-acquisition/(:num)'] = 'customers/customers_acquisition';
$route['customers-acquisition/(:any)'] 						= 'customers/customers_acquisition/$1';
$route['customers-acquisition/(:any)/(:num)'] 				= 'customers/customers_acquisition/$1/$2';
$route['customers-acquisition/(:any)/(:any)/(:num)'] 			= 'customers/customers_acquisition/$1/$2/$3';
$route['customers-acquisition/(:any)/(:any)/(:any)'] 			= 'customers/customers_acquisition/$1/$2/$3';
$route['customers-acquisition/(:any)/(:any)/(:any)/(:num)'] 	= 'customers/customers_acquisition/$1/$2/$3/$4';
$route['customers-acquisition/(:any)/(:any)/(:any)/(:any)'] 	= 'customers/customers_acquisition/$1/$2/$3/$4';
$route['customers-acquisition/(:any)/(:any)/(:any)/(:any)/(:num)'] 	= 'customers/customers_acquisition/$1/$2/$3/$4/$5';
$route['customers-acquisition/(:any)/(:any)/(:any)/(:any)/(:any)'] 	= 'customers/customers_acquisition/$1/$2/$3/$4/$5';


$route['vendors/(:num)'] 								= 'master/vendors';
$route['vendors/(:any)'] 						= 'master/vendors/$1';
$route['vendors/(:any)/(:num)'] 				= 'master/vendors/$1/$2';
$route['vendors/(:any)/(:num)/(:num)'] 		= 'master/vendors/$1/$2/$3';
$route['vendors/(:any)/(:num)/(:num)/(:num)'] 	= 'master/vendors/$1/$2/$3/$4';

$route['customer/(:num)'] 								= 'master/customer';
$route['customer/(:any)'] 						= 'master/customer/$1';
$route['customer/(:any)/(:num)'] 				= 'master/customer/$1/$2';
$route['customer/(:any)/(:num)/(:num)'] 		= 'master/customer/$1/$2/$3';
$route['customer/(:any)/(:num)/(:num)/(:num)'] 	= 'master/custoadmin-cash-registermer/$1/$2/$3/$4';

$route['brand-master/(:num)'] = 'master/brand_master';
$route['add-brand'] = 'master/add_brand';
$route['edit-brand/(:num)'] = 'master/edit_brand/$1';
$route['delete-brand/(:num)'] = 'master/delete_brand/$1';

//****************SHOP ROUTES******************//
$route['shop-change-password'] = 'welcome/shop_change_password';
$route['update-shop-password'] = 'welcome/update_shop_password';

//offer coupons
$route['coupons-offers/(:num)'] = 'Coupons_offers';
$route['coupons-offers/(:any)'] = 'Coupons_offers/$1';
$route['coupons-offers/(:any)/(:any)'] = 'Coupons_offers/$1/$2';
$route['coupons-offers/(:any)/(:any)/(:any)'] = 'Coupons_offers/$1/$2/$3';
$route['coupons-offers/(:any)/(:any)/(:any)/(:any)'] = 'Coupons_offers/$1/$2/$3/$4';
// $route['coupons-offers/(:num)'] = 'Coupons_offers/detailsPage/$1';

$route['coupons_offers_remote/(:any)'] 		= 'Coupons_offers/coupons_offers_remote/$1';
$route['coupons_offers_remote/(:any)/(:any)'] 	= 'Coupons_offers/coupons_offers_remote/$1/$2';
$route['coupons_offers_remote/(:any)/(:any)/(:any)'] = 'Coupons_offers/coupons_offers_remote/$1/$2/$3';

$route['shop-offers/(:num)'] 								= 'Coupons_offers/shop_offers';
$route['shop-offers/(:any)'] 						= 'Coupons_offers/shop_offers/$1';
$route['shop-offers/(:any)/(:num)'] 				= 'Coupons_offers/shop_offers/$1/$2';
$route['shop-offers/(:any)/(:num)/(:num)'] 		= 'Coupons_offers/shop_offers/$1/$2/$3';
$route['shop-offers/(:any)/(:num)/(:num)/(:num)'] 	= 'Coupons_offers/shop_offers/$1/$2/$3/$4';

//coupons

$route['shop-coupons/(:num)'] 								= 'Coupons_offers/shop_coupons';
$route['shop-coupons/(:any)'] 						= 'Coupons_offers/shop_coupons/$1';
$route['shop-coupons/(:any)/(:num)'] 				= 'Coupons_offers/shop_coupons/$1/$2';
$route['shop-coupons/(:any)/(:num)/(:num)'] 		= 'Coupons_offers/shop_coupons/$1/$2/$3';
$route['shop-coupons/(:any)/(:num)/(:num)/(:num)'] 	= 'Coupons_offers/shop_coupons/$1/$2/$3/$4';

$route['shop-apply-offer/(:num)'] = 'Coupons_offers/shop_apply_offer';

//Master routes
$route['shop-master-data/(:num)'] = 'master_shop';
$route['shop-master-data/(:any)'] = 'master_shop/$1';
$route['shop-master-data/(:any)/(:any)'] = 'master_shop/$1/$2';
$route['shop-master-data/(:any)/(:any)/(:any)'] = 'master_shop/$1/$2/$3';
$route['shop-master-data/(:any)/(:any)/(:any)/(:any)'] = 'master_shop/$1/$2/$3/$4';

$route['shop-home-banners/(:num)'] 				= 'master_shop/home_banners';

$route['shop-home-header/(:num)'] 				= 'master_shop/home_header';

$route['shop-booking-slots/(:num)'] = 'master_shop/booking_slots';

$route['shop-social-master/(:num)'] = 'master_shop/shop_social';
$route['bank-accounts-master/(:num)'] = 'master_shop/bank_accounts';
$route['cash-account/(:num)'] = 'master_shop/cash_account';

//Reports
$route['reports/(:num)'] = 'reports';

$route['stock-report'] = 'reports/stock_report';
$route['stock-report/(:num)'] = 'reports/stock_report';
$route['stock-report/(:any)'] 						= 'reports/stock_report/$1';
$route['stock-report/(:any)/(:num)'] 				= 'reports/stock_report/$1/$2';
$route['stock-report/(:any)/(:any)/(:num)'] 			= 'reports/stock_report/$1/$2/$3';
$route['stock-report/(:any)/(:any)/(:any)'] 			= 'reports/stock_report/$1/$2/$3';
$route['stock-report/(:any)/(:any)/(:any)/(:num)'] 	= 'reports/stock_report/$1/$2/$3/$4';
$route['stock-report/(:any)/(:any)/(:any)/(:any)'] 	= 'reports/stock_report/$1/$2/$3/$4';
$route['stock-report/(:any)/(:any)/(:any)/(:any)/(:num)'] 	= 'reports/stock_report/$1/$2/$3/$4/$5';
$route['stock-report/(:any)/(:any)/(:any)/(:any)/(:any)'] 	= 'reports/stock_report/$1/$2/$3/$4/$5';

$route['product-stock-report'] = 'reports/product_stock_report';
$route['product-stock-report/(:num)'] = 'reports/product_stock_report';
$route['product-stock-report/(:any)'] 						= 'reports/product_stock_report/$1';
$route['product-stock-report/(:any)/(:num)'] 				= 'reports/product_stock_report/$1/$2';
$route['product-stock-report/(:any)/(:any)/(:num)'] 			= 'reports/product_stock_report/$1/$2/$3';
$route['product-stock-report/(:any)/(:any)/(:any)'] 			= 'reports/product_stock_report/$1/$2/$3';
$route['product-stock-report/(:any)/(:any)/(:any)/(:num)'] 	= 'reports/product_stock_report/$1/$2/$3/$4';
$route['product-stock-report/(:any)/(:any)/(:any)/(:any)'] 	= 'reports/product_stock_report/$1/$2/$3/$4';
$route['product-stock-report/(:any)/(:any)/(:any)/(:any)/(:num)'] 	= 'reports/product_stock_report/$1/$2/$3/$4/$5';
$route['product-stock-report/(:any)/(:any)/(:any)/(:any)/(:any)'] 	= 'reports/product_stock_report/$1/$2/$3/$4/$5';
$route['product-stock-report/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)'] 	= 'reports/product_stock_report/$1/$2/$3/$4/$5/$6'; 

$route['date-wise-stock-report'] = 'reports/date_wise_product_stock_report';
$route['date-wise-stock-report/(:num)'] = 'reports/date_wise_product_stock_report';
$route['date-wise-stock-report/(:any)'] = 'reports/date_wise_product_stock_report/$1';


$route['sales-report-accounting/(:num)'] = 'reports/sales_report_accounting';
$route['sales-report-accounting/(:any)'] 						= 'reports/sales_report_accounting/$1';
$route['sales-report-accounting/(:any)/(:num)'] 				= 'reports/sales_report_accounting/$1/$2';
$route['sales-report-accounting/(:any)/(:any)/(:num)'] 			= 'reports/sales_report_accounting/$1/$2/$3';
$route['sales-report-accounting/(:any)/(:any)/(:any)/(:num)'] 	= 'reports/sales_report_accounting/$1/$2/$3/$4';
$route['sales-report-accounting/(:any)/(:any)/(:any)/(:any)'] 	= 'reports/sales_report_accounting/$1/$2/$3/$4';
$route['sales-report-accounting/(:any)/(:any)/(:any)/(:any)/(:num)'] 	= 'reports/sales_report_accounting/$1/$2/$3/$4/$5';
$route['sales-report-accounting/(:any)/(:any)/(:any)/(:any)/(:any)'] 	= 'reports/sales_report_accounting/$1/$2/$3/$4/$5';
$route['sales-report-accounting/(:any)/(:any)/(:any)/(:any)/(:any)/(:num)'] 	= 'reports/sales_report_accounting/$1/$2/$3/$4/$5/$6';

$route['product-purchased-report'] = 'reports/product_purchased_report';
$route['product-purchased-report/(:num)'] = 'reports/product_purchased_report';
$route['product-purchased-report/(:any)'] 						= 'reports/product_purchased_report/$1';
$route['product-purchased-report/(:any)/(:num)'] 				= 'reports/product_purchased_report/$1/$2';
$route['product-purchased-report/(:any)/(:any)/(:num)'] 			= 'reports/product_purchased_report/$1/$2/$3';
$route['product-purchased-report/(:any)/(:any)/(:any)'] 			= 'reports/product_purchased_report/$1/$2/$3';
$route['product-purchased-report/(:any)/(:any)/(:any)/(:num)'] 	= 'reports/product_purchased_report/$1/$2/$3/$4';
$route['product-purchased-report/(:any)/(:any)/(:any)/(:any)'] 	= 'reports/product_purchased_report/$1/$2/$3/$4';

$route['tax-report'] = 'reports/tax_report';
$route['tax-report/(:num)'] = 'reports/tax_report';
$route['tax-report/(:any)'] 						= 'reports/tax_report/$1';
$route['tax-report/(:any)/(:num)'] 				= 'reports/tax_report/$1/$2';
$route['tax-report/(:any)/(:any)/(:num)'] 			= 'reports/tax_report/$1/$2/$3';
$route['tax-report/(:any)/(:any)/(:any)/(:num)'] 	= 'reports/tax_report/$1/$2/$3/$4';
$route['tax-report/(:any)/(:any)/(:any)/(:any)'] 	= 'reports/tax_report/$1/$2/$3/$4';
$route['tax-report/(:any)/(:any)/(:any)/(:any)/(:num)'] 	= 'reports/tax_report/$1/$2/$3/$4/$5';
$route['tax-report/(:any)/(:any)/(:any)/(:any)/(:any)/(:num)'] 	= 'reports/tax_report/$1/$2/$3/$4/$5/$6';

$route['purchase-report'] = 'reports/purchase_report';
$route['purchase-report/(:num)'] = 'reports/purchase_report';
$route['purchase-report/(:any)'] 						= 'reports/purchase_report/$1';
$route['purchase-report/(:any)/(:num)'] 				= 'reports/purchase_report/$1/$2';
$route['purchase-report/(:any)/(:any)/(:num)'] 			= 'reports/purchase_report/$1/$2/$3';
$route['purchase-report/(:any)/(:any)/(:any)/(:num)'] 	= 'reports/purchase_report/$1/$2/$3/$4';
$route['purchase-report/(:any)/(:any)/(:any)/(:any)'] 	= 'reports/purchase_report/$1/$2/$3/$4';
$route['purchase-report/(:any)/(:any)/(:any)/(:any)/(:num)'] 	= 'reports/purchase_report/$1/$2/$3/$4/$5';
$route['purchase-report/(:any)/(:any)/(:any)/(:any)/(:any)'] 	= 'reports/purchase_report/$1/$2/$3/$4/$5';
$route['purchase-report/(:any)/(:any)/(:any)/(:any)/(:any)/(:num)'] 	= 'reports/purchase_report/$1/$2/$3/$4/$5/$6';
$route['purchase-report/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)'] 	= 'reports/purchase_report/$1/$2/$3/$4/$5/$6';
$route['purchase-report/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:num)'] 	= 'reports/purchase_report/$1/$2/$3/$4/$5/$6/$7';
$route['purchase-report/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)'] 	= 'reports/purchase_report/$1/$2/$3/$4/$5/$6/$7';
$route['purchase-report/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:num)'] 	= 'reports/purchase_report/$1/$2/$3/$4/$5/$6/$7/$8';
$route['purchase-report/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)'] 	= 'reports/purchase_report/$1/$2/$3/$4/$5/$6/$7/$8';
$route['purchase-report/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:num)'] 	= 'reports/purchase_report/$1/$2/$3/$4/$5/$6/$7/$8/$9';
$route['purchase-report/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)'] 	= 'reports/purchase_report/$1/$2/$3/$4/$5/$6/$7/$8/$9';
$route['purchase-report/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:num)'] 	= 'reports/purchase_report/$1/$2/$3/$4/$5/$6/$7/$8/$9/$10';
$route['purchase-report/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)'] 	= 'reports/purchase_report/$1/$2/$3/$4/$5/$6/$7/$8/$9/$10';


$route['sales-report'] = 'reports/sales_report';
$route['sales-report/(:num)'] = 'reports/sales_report';
$route['sales-report/(:any)'] 						= 'reports/sales_report/$1';
$route['sales-report/(:any)/(:num)'] 				= 'reports/sales_report/$1/$2';
$route['sales-report/(:any)/(:any)/(:num)'] 			= 'reports/sales_report/$1/$2/$3';
$route['sales-report/(:any)/(:any)/(:any)/(:num)'] 	= 'reports/sales_report/$1/$2/$3/$4';
$route['sales-report/(:any)/(:any)/(:any)/(:any)'] 	= 'reports/sales_report/$1/$2/$3/$4';
$route['sales-report/(:any)/(:any)/(:any)/(:any)/(:num)'] 	= 'reports/sales_report/$1/$2/$3/$4/$5';
$route['sales-report/(:any)/(:any)/(:any)/(:any)/(:any)'] 	= 'reports/sales_report/$1/$2/$3/$4/$5';
$route['sales-report/(:any)/(:any)/(:any)/(:any)/(:any)/(:num)'] 	= 'reports/sales_report/$1/$2/$3/$4/$5/$6';
$route['sales-report/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)'] 	= 'reports/sales_report/$1/$2/$3/$4/$5/$6';
$route['sales-report/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:num)'] 	= 'reports/sales_report/$1/$2/$3/$4/$5/$6/$7';
$route['sales-report/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)'] 	= 'reports/sales_report/$1/$2/$3/$4/$5/$6/$7';
$route['sales-report/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:num)'] 	= 'reports/sales_report/$1/$2/$3/$4/$5/$6/$7/$8';
$route['sales-report/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)'] 	= 'reports/sales_report/$1/$2/$3/$4/$5/$6/$7/$8';
$route['sales-report/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:num)'] 	= 'reports/sales_report/$1/$2/$3/$4/$5/$6/$7/$8/$9';
$route['sales-report/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)'] 	= 'reports/sales_report/$1/$2/$3/$4/$5/$6/$7/$8/$9';
$route['sales-report/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:num)'] 	= 'reports/sales_report/$1/$2/$3/$4/$5/$6/$7/$8/$9/$10';
$route['sales-report/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)'] 	= 'reports/sales_report/$1/$2/$3/$4/$5/$6/$7/$8/$9/$10';
$route['sales-report/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:num)'] 	= 'reports/sales_report/$1/$2/$3/$4/$5/$6/$7/$8/$9/$10/$11';
$route['sales-report/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)'] 	= 'reports/sales_report/$1/$2/$3/$4/$5/$6/$7/$8/$9/$10/$11';





$route['pos-sales-report'] = 'reports/pos_sales_report';
$route['pos-sales-report/(:num)'] = 'reports/pos_sales_report';
$route['pos-sales-report/(:any)'] 						= 'reports/pos_sales_report/$1';
$route['pos-sales-report/(:any)/(:any)'] 				= 'reports/pos_sales_report/$1/$2';
$route['pos-sales-report/(:any)/(:any)/(:any)'] 			= 'reports/pos_sales_report/$1/$2/$3';
$route['pos-sales-report/(:any)/(:any)/(:any)/(:any)'] 	= 'reports/pos_sales_report/$1/$2/$3/$4';
$route['pos-sales-report/(:any)/(:any)/(:any)/(:any)'] 	= 'reports/pos_sales_report/$1/$2/$3/$4';
$route['pos-sales-report/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)'] 	= 'reports/pos_sales_report/$1/$2/$3/$4/$5/$6';
$route['pos-sales-report/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)'] 	= 'reports/pos_sales_report/$1/$2/$3/$4/$5/$6/$7';
$route['pos-sales-report/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)'] 	= 'reports/pos_sales_report/$1/$2/$3/$4/$5/$6/$7/$8';
$route['pos-sales-report/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)'] 	= 'reports/pos_sales_report/$1/$2/$3/$4/$5/$6/$7/$8/$9';
$route['pos-sales-report/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)'] 	= 'reports/pos_sales_report/$1/$2/$3/$4/$5/$6/$7/$8/$9/$10';
$route['pos-sales-report/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)'] 	= 'reports/pos_sales_report/$1/$2/$3/$4/$5/$6/$7/$8/$9/$10/$11';

// $route['export-pos-sales-report'] = 'reports/pos_sales_report/export_to_excel';







$route['shop-vendors/(:num)'] 								= 'master_shop/vendors';
$route['shop-vendors/(:any)'] 						= 'master_shop/vendors/$1';
$route['shop-vendors/(:any)/(:num)'] 				= 'master_shop/vendors/$1/$2';
$route['shop-vendors/(:any)/(:num)/(:num)'] 		= 'master_shop/vendors/$1/$2/$3';
$route['shop-vendors/(:any)/(:num)/(:num)/(:num)'] 	= 'master_shop/vendors/$1/$2/$3/$4';

$route['shop-customer/(:num)'] 								= 'master_shop/customer';
$route['shop-customer/(:any)'] 						= 'master_shop/customer/$1';
$route['shop-customer/(:any)/(:num)'] 				= 'master_shop/customer/$1/$2';
$route['shop-customer/(:any)/(:num)/(:num)'] 		= 'master_shop/customer/$1/$2/$3';
$route['shop-customer/(:any)/(:num)/(:num)/(:num)'] 	= 'master_shop/customer/$1/$2/$3/$4';


$route['shop-product-flags/(:num)'] = 'master_shop/product_flags';
$route['shop-product-flags/(:any)'] 						= 'master_shop/product_flags/$1';
$route['shop-product-flags/(:any)/(:num)'] 				= 'master_shop/product_flags/$1/$2';
$route['shop-product-flags/(:any)/(:any)/(:num)'] 			= 'master_shop/product_flags/$1/$2/$3';
$route['shop-product-flags/(:any)/(:any)/(:any)'] 			= 'master_shop/product_flags/$1/$2/$3';
$route['shop-product-flags/(:any)/(:any)/(:any)/(:num)'] 	= 'master_shop/product_flags/$1/$2/$3/$4';
$route['shop-product-flags/(:any)/(:any)/(:any)/(:any)'] 	= 'master_shop/product_flags/$1/$2/$3/$4';
$route['shop-product-flags/(:any)/(:any)/(:any)/(:any)/(:num)'] 	= 'master_shop/product_flags/$1/$2/$3/$4/$5';
$route['shop-product-flags/(:any)/(:any)/(:any)/(:any)/(:any)'] 	= 'master_shop/product_flags/$1/$2/$3/$4/$5';
$route['shop-product-flags/(:any)/(:any)/(:any)/(:any)/(:any)/(:num)'] 	= 'master_shop/product_flags/$1/$2/$3/$4/$5/$6';
$route['shop-product-flags/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)'] 	= 'master_shop/product_flags/$1/$2/$3/$4/$5/$6';

$route['shop-profile'] = 'welcome/shop_profile';
$route['edit-shop-profile'] = 'welcome/edit_shop_profile';

//Subscription routes
$route['subscription-data/(:num)'] = 'Subscription';
$route['subscription-data/(:any)'] = 'Subscription/$1';
$route['subscription-data/(:any)/(:any)'] = 'Subscription/$1/$2';
$route['subscription-data/(:any)/(:any)/(:any)'] = 'Subscription/$1/$2/$3';
$route['subscription-data/(:any)/(:any)/(:any)/(:any)'] = 'Subscription/$1/$2/$3/$4';

$route['subscription-plan-types/(:num)'] = 'Subscription/subscription_plan_types';

$route['subscription-slots/(:num)'] = 'Subscription/subscription_slots';

$route['subscriptions'] = 'Shop_subscription/subscription_data';
$route['subscriptions/(:any)'] 						= 'Shop_subscription/subscription_data/$1';
$route['subscriptions/(:any)/(:num)'] 				= 'Shop_subscription/subscription_data/$1/$2';
$route['subscriptions/(:any)/(:any)/(:num)'] 			= 'Shop_subscription/subscription_data/$1/$2/$3';
$route['subscriptions/(:any)/(:any)/(:any)'] 			= 'Shop_subscription/subscription_data/$1/$2/$3';
$route['subscriptions/(:any)/(:any)/(:any)/(:num)'] 	= 'Shop_subscription/subscription_data/$1/$2/$3/$4';
$route['subscriptions/(:any)/(:any)/(:any)/(:any)'] 	= 'Shop_subscription/subscription_data/$1/$2/$3/$4';
$route['subscriptions/(:any)/(:any)/(:any)/(:any)/(:num)'] 	= 'Shop_subscription/subscription_data/$1/$2/$3/$4/$5';
$route['subscriptions/(:any)/(:any)/(:any)/(:any)/(:any)'] 	= 'Shop_subscription/subscription_data/$1/$2/$3/$4/$5';


//Shop Subscription routes
$route['shop-subscription-data/(:num)'] = 'Shop_subscription_master';
$route['shop-subscription-data/(:any)'] = 'Shop_subscription_master/$1';
$route['shop-subscription-data/(:any)/(:any)'] = 'Shop_subscription_master/$1/$2';


$route['shop-subscription-slots/(:num)'] = 'Shop_subscription_master/subscription_slots';

//Shopzone poratl routes

$route['shopzone-portal/(:num)'] = 'Shopzone_portal';
$route['shopzone-portal/(:any)'] = 'Shopzone_portal/$1';
$route['shopzone-portal/(:any)/(:any)'] = 'Shopzone_portal/$1/$2';
$route['shopzone-portal/(:any)/(:any)/(:any)'] = 'Shopzone_portal/$1/$2/$3';

$route['portal-news/(:num)'] = 'Shopzone_portal/portal_news';
$route['portal-news/(:any)'] 						= 'Shopzone_portal/portal_news/$1';
$route['portal-news/(:any)/(:num)'] 				= 'Shopzone_portal/portal_news/$1/$2';
$route['portal-news/(:any)/(:any)/(:num)'] 			= 'Shopzone_portal/portal_news/$1/$2/$3';


$route['portal-enquiry/(:num)'] = 'Shopzone_portal/portal_enquiry';
$route['portal-enquiry/(:any)'] 						= 'Shopzone_portal/portal_enquiry/$1';
$route['portal-enquiry/(:any)/(:num)'] 				= 'Shopzone_portal/portal_enquiry/$1/$2';
$route['portal-enquiry/(:any)/(:any)/(:num)'] 			= 'Shopzone_portal/portal_enquiry/$1/$2/$3';

$route['shop-enquiry'] = 'Welcome/shop_enquiry';
$route['shop-enquiry/(:any)'] 						= 'Welcome/shop_enquiry/$1';
$route['shop-enquiry/(:any)/(:num)'] 				= 'Welcome/shop_enquiry/$1/$2';
$route['shop-enquiry/(:any)/(:any)/(:num)'] 			= 'Welcome/shop_enquiry/$1/$2/$3';

$route['portal-recaptcha/(:num)'] = 'Shopzone_portal/portal_recaptcha';
$route['portal-recaptcha/(:any)'] 						= 'Shopzone_portal/portal_recaptcha/$1';
$route['portal-recaptcha/(:any)/(:num)'] 				= 'Shopzone_portal/portal_recaptcha/$1/$2';

$route['acl-data/(:num)'] = 'ACL';
$route['acl-data/(:any)'] = 'ACL/$1';
$route['acl-data/(:any)/(:any)'] = 'ACL/$1/$2';
$route['acl-data/(:any)/(:any)/(:any)'] = 'ACL/$1/$2/$3';
$route['acl-data/(:any)/(:any)/(:any)/(:any)'] = 'ACL/$1/$2/$3/$4';

$route['admin-menu/(:num)'] = 'ACL/admin_menu';
$route['admin-menu/(:any)'] = 'ACL/admin_menu/$1';
$route['admin-menu/(:any)'] 						= 'ACL/admin_menu/$1';
$route['admin-menu/(:any)/(:num)'] 				= 'ACL/admin_menu/$1/$2';

$route['users/(:num)'] = 'ACL/users';
$route['users/(:any)'] = 'ACL/users/$1';
$route['users/(:any)/(:num)'] = 'ACL/users/$1/$2';

$route['user-role/(:num)'] = 'ACL/user_role';
$route['user-role/(:any)'] = 'ACL/user_role/$1';
$route['user-role/(:any)'] 						= 'ACL/user_role/$1';
$route['user-role/(:any)/(:num)'] 				= 'ACL/user_role/$1/$2';

$route['transaction/(:num)'] = 'Cash_register';

$route['cash-register/(:num)'] 	= 'Cash_register/cash';
$route['cash/save/(:any)'] 	= 'Cash_register/cash/save';
$route['cash/edit/(:any)'] 	= 'Cash_register/cash/edit';
$route['cash/update/(:any)']		= 'Cash_register/cash/update';
$route['cash/delete/(:any)']		= 'Cash_register/cash/delete';
$route['cash/tb/(:any)'] 	= 'Cash_register/cash/tb/';
$route['cash_register/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:num)'] 	= 'Cash_register/cash/tb/$1/$2/$3/$4/$5/$6/$7/';

$route['bank-register/(:any)']		= 'Cash_register/bank';
$route['bank/save/(:any)'] 	= 'Cash_register/bank/save';
$route['bank/edit/(:any)'] 	= 'Cash_register/bank/edit';
$route['bank/update/(:any)']		= 'Cash_register/bank/update';
$route['bank/delete/(:any)']		= 'Cash_register/bank/delete';
$route['bank/tb/(:any)'] 	= 'Cash_register/bank/tb/';
$route['cash_register/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:num)'] 	= 'Cash_register/bank/tb/$1/$2/$3/$4/$5/$6/$7/';

$route['ref-no'] = 'Cash_register/checkref_no/';
$route['editref-no'] = 'Cash_register/editcheckref_no/';
$route['delete-data'] = 'Cash_register/multiple_delete/';

$route['shop-pos'] 	= 'pos/pos_data';
$route['shop-pos/(:num)'] 	= 'pos/pos_data';
$route['pos_data/getitem/(:any)'] 	= 'pos/pos_data/getitem';
$route['pos_data/getcustomer/(:any)'] 	= 'pos/pos_data/getcustomer';
$route['pos_data/getcustomer/(:any)'] 	= 'pos/pos_data/save';
$route['check-customer-code'] = 'pos/check_customer_code';
$route['check-order-id'] = 'pos/check_order_id';


$route['cash-report'] 	= 'ledger/cash';
$route['cash-report/(:any)'] 	= 'ledger/cash';
$route['cash-report-tb'] 		= 'ledger/cash/tb';
$route['bank-report'] 	= 'ledger/bank';
$route['bank-report/(:any)'] 	= 'ledger/bank';
$route['bank-report-tb'] 		= 'ledger/bank/tb';
$route['ledger-partywise'] 	= 'ledger/partywise';
$route['ledger-partywise/(:any)'] 	= 'ledger/partywise';
$route['ledger-partywise-tb'] 		= 'ledger/partywise/tb';
$route['monthly-ledger-report/(:num)'] 		= 'ledger/monthly_report';
$route['monthly-ledger-report-tb'] 		= 'ledger/monthly_report/tb';

$route['sales-purchase/(:num)'] = 'submenu/index/$1';
$route['sale-return']			= 'sale_return/index';
$route['purchase-return']		= 'purchase_return/index';

$route['sale-purchase-return-report']		= 'sale_return/report';
$route['sale-purchase-return-report/(:num)']		= 'sale_return/report';
$route['sale-purchase-return-report-tb']		    = 'sale_return/report/tb';

$route['products-aging-report'] 			= 'aging_report/products/1';
$route['products-aging-report/(:num)'] 			= 'aging_report/products/$1';
$route['products-aging-report/(:num)/(:any)'] 	= 'aging_report/products/$1/$2';


$route['submenu/(:num)'] = 'submenu/index/$1';
// $route['registers/(:num)'] = 'submenu/index/$1';
// $route['ledgers/(:num)'] = 'submenu/index/$1';
// $route['other-reports/(:num)'] = 'submenu/index/$1';

