<?php
/**
 * Define SuperAdminMarkupDiscount Routes
 */

$routes->group("coupon", ["filter" => "auth"], function ($routes) {
    $routes->match(['get'], '/', '\Modules\Coupon\Controllers\SuperAdminFlightCoupon::index');
    $routes->get('get-airports', '\Modules\Coupon\Controllers\SuperAdminFlightCoupon::get_airports');
    $routes->get('get-airline', '\Modules\Coupon\Controllers\SuperAdminFlightCoupon::get_airline');


        /** SuperAdminVisaCoupon routes*/
        $routes->get('visa-coupon', '\Modules\Coupon\Controllers\SuperAdminVisaCoupon::visa_coupon'); 
        $routes->post('visa-coupon-view', '\Modules\Coupon\Controllers\SuperAdminVisaCoupon::add_visa_coupon_view');
        $routes->post('add-coupon-visa', '\Modules\Coupon\Controllers\SuperAdminVisaCoupon::add_coupon_visa');
        $routes->post('visa-coupon-status-change', '\Modules\Coupon\Controllers\SuperAdminVisaCoupon::visa_coupon_status_change');
        $routes->post('remove-visa-coupon', '\Modules\Coupon\Controllers\SuperAdminVisaCoupon::remove_visa_coupon');
        $routes->match(['post'], 'coupon-visa-details/(:any)', '\Modules\Coupon\Controllers\SuperAdminVisaCoupon::coupon_visa_details');
        /** SuperAdminActivitiesCoupon routes*/

    
      /** SuperAdminCouponLogs routes*/
      $routes->get('coupon-log', '\Modules\Coupon\Controllers\SuperAdminCouponLog::coupon_log');


});

