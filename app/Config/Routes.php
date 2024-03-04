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
$routes->get('super_admin/order_filter_status/(:num)', 'Super_admin\Order::order_filter_status/$1');
$routes->get('super_admin/order_filter/(:num)', 'Super_admin\Order::order_filter/$1');
$routes->get('super_admin/order_filter_not_accepted', 'Super_admin\Order::order_filter_not_accepted');
$routes->post('super_admin/order_filter_shop', 'Super_admin\Order::order_filter_shop');
$routes->post('super_admin/order_filter_invoice', 'Super_admin\Order::order_filter_invoice');

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
$routes->post('super_admin/sellers_filter', 'Super_admin\Sellers::filter');
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
$routes->post('super_admin/delivery_boy_filter', 'Super_admin\Deliveryboy::filter');
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
$routes->post('super_admin/agent_filter', 'Super_admin\Agent::filter');
//super admin Agent

//super admin Globaladdress
$routes->get('super_admin/global_address', 'Super_admin\Globaladdress::index');
$routes->get('super_admin/global_address_create', 'Super_admin\Globaladdress::create');
$routes->post('super_admin/global_address_create_action', 'Super_admin\Globaladdress::create_action');
$routes->get('super_admin/global_address_update/(:num)', 'Super_admin\Globaladdress::update/$1');
$routes->post('super_admin/global_address_update_action', 'Super_admin\Globaladdress::update_action');
$routes->get('super_admin/global_address_delete/(:num)', 'Super_admin\Globaladdress::delete/$1');
$routes->post('super_admin/global_address_search', 'Super_admin\Globaladdress::search');
//super admin Globaladdress

//super admin demo product category
$routes->get('super_admin/demo_product_category', 'Super_admin\Demoproduccategory::index');
$routes->get('super_admin/demo_product_category_create', 'Super_admin\Demoproduccategory::create');
$routes->post('super_admin/demo_product_category_create_action', 'Super_admin\Demoproduccategory::create_action');
$routes->get('super_admin/demo_product_category_update/(:num)', 'Super_admin\Demoproduccategory::update/$1');
$routes->post('super_admin/demo_product_category_update_action', 'Super_admin\Demoproduccategory::update_action');
$routes->get('super_admin/demo_product_category_delete/(:num)', 'Super_admin\Demoproduccategory::delete/$1');
//super admin demo product category

//super admin demo product category
$routes->get('super_admin/demo_product', 'Super_admin\Demoproducts::index');
$routes->get('super_admin/demo_product_list', 'Super_admin\Demoproducts::product_list');
$routes->post('super_admin/demo_product_create_action', 'Super_admin\Demoproducts::create_action');
$routes->post('super_admin/demo_product_add_cart', 'Super_admin\Demoproducts::addCart');
$routes->post('super_admin/demo_product_remove_cart', 'Super_admin\Demoproducts::remove_cart');
$routes->post('super_admin/demo_product_clearCart', 'Super_admin\Demoproducts::clearCart');
$routes->post('super_admin/demo_product_get_sub_cat', 'Super_admin\Demoproducts::get_sub_cat');
$routes->get('super_admin/demo_product_update/(:num)', 'Super_admin\Demoproducts::update/$1');
$routes->post('super_admin/demo_product_update_action', 'Super_admin\Demoproducts::update_action');
$routes->post('super_admin/demo_product_photo_action', 'Super_admin\Demoproducts::photo_action');
$routes->get('super_admin/demo_product_delete/(:num)', 'Super_admin\Demoproducts::delete/$1');
$routes->post('super_admin/demo_product_search_by_key', 'Super_admin\Demoproducts::search_keyword');
$routes->post('super_admin/demo_product_search_by_cat', 'Super_admin\Demoproducts::search_category');
//super admin demo product category

//super admin demo product color
$routes->get('super_admin/product_color', 'Super_admin\Productcolor::index');
$routes->get('super_admin/product_color_create', 'Super_admin\Productcolor::create');
$routes->post('super_admin/product_color_create_action', 'Super_admin\Productcolor::create_action');
$routes->get('super_admin/product_color_update/(:num)', 'Super_admin\Productcolor::update/$1');
$routes->post('super_admin/product_color_update_action', 'Super_admin\Productcolor::update_action');
$routes->get('super_admin/product_color_delete/(:num)', 'Super_admin\Productcolor::delete/$1');
//super admin demo product color

//super admin demo Campaign
$routes->get('super_admin/campaign', 'Super_admin\Campaign::index');
$routes->post('super_admin/campaign_status_update', 'Super_admin\Campaign::status_update');
$routes->get('super_admin/campaign_update/(:num)', 'Super_admin\Campaign::update/$1');
$routes->post('super_admin/campaign_update_action', 'Super_admin\Campaign::update_action');
//super admin demo Campaign

//super admin demo Campaign
$routes->get('super_admin/group_post', 'Super_admin\Grouppost::index');
$routes->get('super_admin/group_post_update/(:num)', 'Super_admin\Grouppost::update/$1');
$routes->post('super_admin/group_post_update_action', 'Super_admin\Grouppost::update_action');
$routes->get('super_admin/group_post_delete/(:num)', 'Super_admin\Grouppost::delete/$1');
//super admin demo Campaign

//super admin Website settings
$routes->get('super_admin/website_settings/logo', 'Super_admin\Websitesettings::logo');
$routes->post('super_admin/website_settings/logo_action', 'Super_admin\Websitesettings::logo_action');
$routes->get('super_admin/website_settings/banner', 'Super_admin\Websitesettings::banner');
$routes->post('super_admin/website_settings/banner_action_left', 'Super_admin\Websitesettings::banner_action_left');
$routes->post('super_admin/website_settings/banner_action_right', 'Super_admin\Websitesettings::banner_action_right');
$routes->post('super_admin/website_settings/banner_action_top', 'Super_admin\Websitesettings::banner_action_top');
$routes->post('super_admin/website_settings/banner_action_bottom', 'Super_admin\Websitesettings::banner_action_bottom');
$routes->get('super_admin/website_settings/banner_product', 'Super_admin\Websitesettings::banner_product');
$routes->post('super_admin/website_settings/banner_product_action', 'Super_admin\Websitesettings::banner_product_action');
$routes->get('super_admin/website_settings/slider', 'Super_admin\Websitesettings::slider');
$routes->post('super_admin/website_settings/slider_action', 'Super_admin\Websitesettings::slider_action');
$routes->get('super_admin/website_settings/footer', 'Super_admin\Websitesettings::footer');
$routes->post('super_admin/website_settings/footer_action', 'Super_admin\Websitesettings::footer_action');
$routes->get('super_admin/website_settings/mobile_slider', 'Super_admin\Websitesettings::mobile_slider');
$routes->get('super_admin/website_settings/home_banner', 'Super_admin\Websitesettings::home_banner');
$routes->post('super_admin/website_settings/home_banner_action', 'Super_admin\Websitesettings::home_banner_action');
$routes->post('super_admin/website_settings/home_banner_small_action', 'Super_admin\Websitesettings::home_banner_small_action');
//super admin Website settings

//super admin Sms panel
$routes->get('super_admin/sms_panel', 'Super_admin\Smspanel::index');
$routes->post('super_admin/update_status', 'Super_admin\Smspanel::update_status');
//super admin Sms panel

//super admin Sms panel
$routes->get('super_admin/general_settings', 'Super_admin\Generalsettings::index');
$routes->post('super_admin/update_action', 'Super_admin\Generalsettings::update_action');

// shop admin login
$routes->get('shop_admin/login', 'Shop_admin\Login::index');
$routes->post('shop_admin/login_action', 'Shop_admin\Login::login_action');
$routes->get('shop_admin/logout', 'Shop_admin\Login::logout');
$routes->get('shop_admin/forgot_password', 'Shop_admin\Login::forgotPassword');
$routes->post('shop_admin/reset_link', 'Shop_admin\Login::reset_link');
$routes->get('shop_admin/otp', 'Shop_admin\Login::otp');
$routes->post('shop_admin/otp_action', 'Shop_admin\Login::otp_action');
$routes->get('shop_admin/otp_action', 'Shop_admin\Login::reset_password');
$routes->get('shop_admin/reset_password', 'Shop_admin\Login::reset_password');
$routes->post('shop_admin/reset_password_action', 'Shop_admin\Login::reset_password_action');
// shop admin login end

// shop admin Dashboard
$routes->get('shop_admin/dashboard', 'Shop_admin\Dashboard::index');
$routes->post('shop_admin/opening_status', 'Shop_admin\Dashboard::opening_status');
// shop admin Dashboard end

//shop admin Bakir hishab
$routes->get('shop_admin/bakir_hishab', 'Shop_admin\Bakir_hishab::index');
$routes->get('shop_admin/bakir_hishab/create','Shop_admin\Bakir_hishab::create');
$routes->post('shop_admin/bakir_hishab/create_action', 'Shop_admin\Bakir_hishab::create_action');
$routes->post('shop_admin/bakir_hishab/lonProvData', 'Shop_admin\Bakir_hishab::lonProvData');
// shop admin Dashboard end