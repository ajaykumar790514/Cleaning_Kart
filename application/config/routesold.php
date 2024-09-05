<?php
defined('BASEPATH') OR exit('No direct script access allowed');


$route['default_controller'] = 'welcome';
$route['logout'] = 'welcome/logout';
$route['stocks'] = 'stocks/stock_category';
$route['stocks/(:num)'] = 'stocks/stock_sub_category/$1';
$route['stocks/category/(:num)'] = 'stocks/show_stocks/$1';
$route['coupons-offers'] = 'Coupons_offers/index';
$route['coupons-offers/(:num)'] = 'Coupons_offers/detailsPage/$1';

$route['orders'] = 'orders/index';
$route['orders/print/bill/(:num)'] = 'orders/orderPrintBill/$1';
$route['orders/(:num)'] = 'orders/orderDetails/$1';

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
$route['master-data'] = 'master';

// ankit
$route['categories'] 								= 'master/categories';
$route['categories/(:any)'] 						= 'master/categories/$1';
$route['categories/(:any)/(:num)'] 				= 'master/categories/$1/$2';
$route['categories/(:any)/(:num)/(:num)'] 		= 'master/categories/$1/$2/$3';
$route['categories/(:any)/(:num)/(:num)/(:num)'] 	= 'master/categories/$1/$2/$3/$4';
// ankit

$route['categories'] 				= 'master/categories';
$route['add-category'] 				= 'master/add_category';
$route['edit-category/(:num)'] 		= 'master/edit_category';
$route['delete-category/(:num)'] 	= 'master/delete_category';

$route['remote/(:any)'] 		= 'master/remote/$1';
$route['remote/(:any)/(:any)'] 	= 'master/remote/$1/$2';
$route['remote/(:any)/(:any)/(:any)'] = 'master/remote/$1/$2/$3';

$route['adminremote/(:any)'] 		= 'admin/adminremote/$1';
$route['adminremote/(:any)/(:any)'] 	= 'admin/adminremote/$1/$2';
$route['adminremote/(:any)/(:any)/(:any)'] = 'admin/adminremote/$1/$2/$3';


$route['society_remote/(:any)'] 		= 'master/society_remote/$1';
$route['society_remote/(:any)/(:any)'] 	= 'master/society_remote/$1/$2';
$route['society_remote/(:any)/(:any)/(:any)'] = 'master/society_remote/$1/$2/$3';

// ankit
$route['products'] 								= 'master/products';
$route['products/(:any)'] 						= 'master/products/$1';
$route['products/(:any)/(:num)'] 				= 'master/products/$1/$2';
$route['products/(:any)/(:num)/(:num)'] 		= 'master/products/$1/$2/$3';
$route['products/(:any)/(:num)/(:num)/(:num)'] 	= 'master/products/$1/$2/$3/$4';
// ankit

$route['products'] = 'master/products';
$route['products/(:any)'] = 'master/products/$1';
$route['add-product'] = 'master/add_product';
$route['edit-product/(:num)'] = 'master/edit_product';
$route['delete-product/(:num)'] = 'master/delete_product';
$route['add-property-value/(:num)'] = 'master/add_property_value';


$route['unit-master'] = 'master/unit_master';
$route['add-unit'] = 'master/add_unit';
$route['edit-unit/(:num)'] = 'master/edit_unit';
$route['delete-unit/(:num)'] = 'master/delete_unit';

$route['product-property'] = 'master/product_property';
$route['add-product-property'] = 'master/add_product_property';
$route['edit-product-property/(:num)'] = 'master/edit_product_property';
$route['delete-product-property/(:num)'] = 'master/delete_product_property';

$route['tax-slab'] = 'master/tax_slab';
$route['add-tax-slab'] = 'master/add_tax_slab';
$route['edit-tax-slab/(:num)'] = 'master/edit_tax_slab';
$route['delete-tax-slab/(:num)'] = 'master/delete_tax_slab';

$route['pincodes-criteria'] = 'master/pincodes_criteria';
$route['add-pincode-criteria'] = 'master/add_pincodes_criteria';
$route['edit-pincode-criteria/(:num)'] = 'master/edit_pincodes_criteria';
$route['delete-pincode-criteria/(:num)'] = 'master/delete_pincodes_criteria';

$route['booking-slots'] = 'master/booking_slots';
$route['add-booking-slot'] = 'master/add_booking_slot';
$route['edit-booking-slot/(:num)'] = 'master/edit_booking_slot';
$route['delete-booking-slot/(:num)'] = 'master/delete_booking_slot';

$route['society'] = 'master/society';
$route['add-society'] = 'master/add_society';
$route['edit-society/(:num)'] = 'master/edit_society';
$route['delete-society/(:num)'] = 'master/delete_society';

$route['home-banners'] 				= 'master/home_banners';
$route['add-home-banner'] 				= 'master/add_home_banner';
$route['edit-home-banner/(:num)'] 		= 'master/edit_home_banner';
$route['delete-home-banner/(:num)'] 	= 'master/delete_home_banner';

$route['home-header'] 				= 'master/home_header';
$route['add-home-header'] 				= 'master/add_home_header';
$route['edit-home-header/(:num)'] 		= 'master/edit_home_header';
$route['delete-home-header/(:num)'] 	= 'master/delete_home_header';
$route['product-headers-mapping/(:num)'] 	= 'master/product_headers_mapping';
$route['delete-header-mapping/(:num)'] 	= 'master/delete_header_mapping';
$route['cat-headers-mapping/(:num)'] 	= 'master/cat_headers_mapping';
$route['delete-cat-header-mapping/(:num)'] 	= 'master/delete_cat_header_mapping';
