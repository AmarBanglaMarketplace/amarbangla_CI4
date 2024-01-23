<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
//$routes->setAutoRoute(true);

$routes->get('/', 'Home::index');


//super admin login
$routes->get('super_admin', 'Super_admin\Login::index');
$routes->post('super_admin/login_action', 'Super_admin\Login::login_action');
$routes->get('super_admin/logout', 'Super_admin\Login::logout');
$routes->get('super_admin/dashboard', 'Super_admin\Dashboard::index');
//super admin login

//super admin Shops
$routes->get('super_admin/shops', 'Super_admin\Shops::index');
$routes->get('super_admin/shops_create', 'Super_admin\Shops::create');
$routes->post('super_admin/shops_create_action', 'Super_admin\Shops::create_action');
$routes->get('super_admin/shops_view/(:num)', 'Super_admin\Shops::view/$1');
$routes->get('super_admin/shops_update/(:num)', 'Super_admin\Shops::update/$1');
$routes->post('super_admin/shops_general_update', 'Super_admin\Shops::general_update');
$routes->post('super_admin/shops_personal_update', 'Super_admin\Shops::personal_update');
$routes->post('super_admin/shops_photo_update', 'Super_admin\Shops::photo_update');
$routes->post('super_admin/shops_user_update', 'Super_admin\Shops::user_update');
$routes->post('super_admin/shops_category_update', 'Super_admin\Shops::category_update');
$routes->get('super_admin/shops_delete(:num)', 'Super_admin\Shops::delete/$1');

$routes->post('super_admin/shops_search', 'Super_admin\Shops::search');
$routes->post('super_admin/shops_sub_category', 'Super_admin\Shops::get_sub_category');

$routes->post('super_admin/search_district', 'Super_admin\Shops::search_district');
$routes->post('super_admin/search_upazila', 'Super_admin\Shops::search_upazila');
//super admin Shops

//super admin shop category
$routes->get('super_admin/shop_category', 'Super_admin\Shopcategory::index');
$routes->get('super_admin/shop_category_create', 'Super_admin\Shopcategory::create');
$routes->post('super_admin/shop_category_create_action', 'Super_admin\Shopcategory::create_action');
$routes->get('super_admin/shop_category_update/(:num)', 'Super_admin\Shopcategory::update/$1');
$routes->post('super_admin/shop_category_update_action', 'Super_admin\Shopcategory::update_action');
$routes->post('super_admin/shop_category_others_action', 'Super_admin\Shopcategory::others_action');
$routes->get('super_admin/shop_category_delete/(:num)', 'Super_admin\Shopcategory::delete/$1');
//super admin shop category

//super admin License
$routes->get('super_admin/license', 'Super_admin\License::index');
$routes->get('super_admin/license_create', 'Super_admin\License::create');
$routes->post('super_admin/license_create_action', 'Super_admin\License::create_action');
$routes->get('super_admin/license_update/(:num)', 'Super_admin\License::update/$1');
$routes->post('super_admin/license_update_action', 'Super_admin\License::update_action');
//super admin License

//super admin Settings
$routes->get('super_admin/settings', 'Super_admin\Settings::index');
$routes->get('super_admin/settings_update/(:num)', 'Super_admin\Settings::update/$1');
$routes->post('super_admin/settings_update_action', 'Super_admin\Settings::update_action');
$routes->post('super_admin/settings_personal_update', 'Super_admin\Settings::personal_action');
$routes->post('super_admin/settings_photo_update', 'Super_admin\Settings::photo_action');
//super admin Settings

//super admin Settings
$routes->get('super_admin/shops_commission', 'Super_admin\Shopscommission::index');
$routes->get('super_admin/shops_commission_unpaid_list/(:num)', 'Super_admin\Shopscommission::unpaid_list/$1');
$routes->get('super_admin/shops_commission_paid_list/(:num)', 'Super_admin\Shopscommission::paid_list/$1');
$routes->get('super_admin/shops_commission_pay_list/(:num)', 'Super_admin\Shopscommission::pay_list/$1');
$routes->get('super_admin/shops_commission_cancel/(:num)', 'Super_admin\Shopscommission::cancel/$1');
$routes->post('super_admin/shops_commission_confirm', 'Super_admin\Shopscommission::commission_confirm');
//super admin Settings

//super admin Ledger
$routes->get('super_admin/ledger', 'Super_admin\Ledger::index');
//super admin Ledger

//super admin Ledger
$routes->get('super_admin/customer_type', 'Super_admin\Customertype::index');
$routes->get('super_admin/customer_type_create', 'Super_admin\Customertype::create');
$routes->post('super_admin/customer_type_action', 'Super_admin\Customertype::create_action');
$routes->get('super_admin/customer_type_update/(:num)', 'Super_admin\Customertype::update/$1');
$routes->post('super_admin/customer_type_update_action', 'Super_admin\Customertype::update_action');
$routes->get('super_admin/customer_type_delete/(:num)', 'Super_admin\Customertype::delete/$1');
//super admin Ledger

//super admin customer
$routes->get('super_admin/customer', 'Super_admin\Customer::index');
$routes->get('super_admin/customer_create', 'Super_admin\Customer::create');
$routes->post('super_admin/customer_action', 'Super_admin\Customer::create_action');
$routes->get('super_admin/customer_update/(:num)', 'Super_admin\Customer::update/$1');
$routes->post('super_admin/customer_update_action', 'Super_admin\Customer::update_action');
$routes->post('super_admin/customer_personal_update', 'Super_admin\Customer::personal_update');
$routes->post('super_admin/customer_address_update', 'Super_admin\Customer::address_update');
$routes->post('super_admin/customer_photo_update', 'Super_admin\Customer::photo_update');
$routes->get('super_admin/customer_delete/(:num)', 'Super_admin\Customer::delete/$1');
$routes->get('super_admin/customer_order_list/(:num)', 'Super_admin\Customer::order_list/$1');
$routes->post('super_admin/customer_filter', 'Super_admin\Customer::filter');
//super admin customer

//super admin Order
$routes->get('super_admin/order', 'Super_admin\Order::index');
$routes->get('super_admin/order_invoice/(:num)', 'Super_admin\Order::invoice/$1');
//super admin Order

//super admin Calling request
$routes->get('super_admin/calling_request', 'Super_admin\Callingrequest::index');
$routes->post('super_admin/calling_status_update', 'Super_admin\Callingrequest::status_update');
//super admin Calling request

//super admin Sellers
$routes->get('super_admin/sellers', 'Super_admin\Sellers::index');
$routes->get('super_admin/sellers_create', 'Super_admin\Sellers::create');
$routes->post('super_admin/sellers_action', 'Super_admin\Sellers::create_action');
$routes->get('super_admin/sellers_update/(:num)', 'Super_admin\Sellers::update/$1');
$routes->post('super_admin/sellers_update_action', 'Super_admin\Sellers::update_action');
$routes->post('super_admin/sellers_personal_update_action', 'Super_admin\Sellers::personal_action');
$routes->post('super_admin/sellers_address_update_action', 'Super_admin\Sellers::address_action');
$routes->post('super_admin/sellers_photo_update_action', 'Super_admin\Sellers::photo_action');
$routes->get('super_admin/sellers_delete/(:num)', 'Super_admin\Sellers::delete/$1');
$routes->get('super_admin/sellers_ledger/(:num)', 'Super_admin\Sellers::ledger/$1');
$routes->get('super_admin/sellers_commission/(:num)', 'Super_admin\Sellers::commission/$1');
$routes->get('super_admin/sellers_order/(:num)', 'Super_admin\Sellers::sellers_order/$1');
$routes->post('super_admin/sellers_order_data', 'Super_admin\Sellers::sellers_order_data');
$routes->post('super_admin/commission_data', 'Super_admin\Sellers::commission_data');
$routes->post('super_admin/commission_data_total', 'Super_admin\Sellers::commission_data_total');
$routes->post('super_admin/commission_all', 'Super_admin\Sellers::commission_all');
//super admin Sellers

//super admin Delivery Boy
$routes->get('super_admin/delivery_boy', 'Super_admin\Deliveryboy::index');
$routes->get('super_admin/delivery_boy_create', 'Super_admin\Deliveryboy::create');
$routes->post('super_admin/delivery_boy_action', 'Super_admin\Deliveryboy::create_action');
$routes->get('super_admin/delivery_boy_update/(:num)', 'Super_admin\Deliveryboy::update/$1');
$routes->post('super_admin/delivery_boy_update_action', 'Super_admin\Deliveryboy::update_action');
$routes->post('super_admin/delivery_boy_personal_update', 'Super_admin\Deliveryboy::personal_update');
$routes->post('super_admin/delivery_boy_address_update', 'Super_admin\Deliveryboy::address_update');
$routes->post('super_admin/delivery_boy_photo_update', 'Super_admin\Deliveryboy::photo_update');
$routes->get('super_admin/delivery_boy_delete/(:num)', 'Super_admin\Deliveryboy::delete/$1');
$routes->get('super_admin/delivery_boy_ledger/(:num)', 'Super_admin\Deliveryboy::ledger/$1');
$routes->get('super_admin/delivery_boy_commission/(:num)', 'Super_admin\Deliveryboy::commission/$1');
$routes->get('super_admin/delivery_boy_order/(:num)', 'Super_admin\Deliveryboy::delivery_boy_order/$1');
$routes->post('super_admin/delivery_boy_commission_data', 'Super_admin\Deliveryboy::commission_data');
$routes->post('super_admin/delivery_boy_commission_data_total', 'Super_admin\Deliveryboy::commission_data_total');
$routes->post('super_admin/delivery_boy_commission_all', 'Super_admin\Deliveryboy::commission_all');
//super admin Delivery Boy

//super admin Agent
$routes->get('super_admin/agent', 'Super_admin\Agent::index');
$routes->get('super_admin/agent_create', 'Super_admin\Agent::create');
$routes->post('super_admin/agent_create_action', 'Super_admin\Agent::create_action');
$routes->get('super_admin/agent_update/(:num)', 'Super_admin\Agent::update/$1');
$routes->post('super_admin/agent_update', 'Super_admin\Agent::update_action');
$routes->post('super_admin/agent_address_update', 'Super_admin\Agent::address_update');
$routes->post('super_admin/agent_area_update', 'Super_admin\Agent::area_update');
$routes->get('super_admin/agent_delete/(:num)', 'Super_admin\Agent::delete/$1');
$routes->get('super_admin/agent_commission/(:num)', 'Super_admin\Agent::commission/$1');
$routes->get('super_admin/delete_area/(:num)/(:num)', 'Super_admin\Agent::delete_area/$1/$2');
//super admin Agent

//super admin Globaladdress
$routes->get('super_admin/global_address', 'Super_admin\Globaladdress::index');
$routes->get('super_admin/global_address_create', 'Super_admin\Globaladdress::create');
$routes->post('super_admin/global_address_create_action', 'Super_admin\Globaladdress::create_action');