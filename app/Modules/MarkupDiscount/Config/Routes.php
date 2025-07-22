<?php
/**
 * Define MarkupDiscount Routes
 */

$routes->group("markup-discount", ["filter" => "auth"], function ($routes) {
    $routes->match(['get'], '/', '\Modules\MarkupDiscount\Controllers\MarkupDiscount::index');
    $routes->get('get-airports', '\Modules\MarkupDiscount\Controllers\MarkupDiscount::get_airports');
    $routes->get('get-airline', '\Modules\MarkupDiscount\Controllers\MarkupDiscount::get_airline');




    /** visa  markup routes start */
    $routes->get('visa-markup-list', '\Modules\MarkupDiscount\Controllers\MarkupDiscount::visa_markup_list');
    $routes->post('visa-markup-view', '\Modules\MarkupDiscount\Controllers\MarkupDiscount::visa_markup_view');
   
    $routes->post('add-visa-markup', '\Modules\MarkupDiscount\Controllers\MarkupDiscount::add_visa_markup');
    $routes->post('visa-markup-status-change', '\Modules\MarkupDiscount\Controllers\MarkupDiscount::visa_markup_status_change');
    $routes->post('remove-visa-markup', '\Modules\MarkupDiscount\Controllers\MarkupDiscount::remove_visa_markup');
    $routes->post('edit-admin-visa-markup-template/(:any)', '\Modules\MarkupDiscount\Controllers\MarkupDiscount::edit_admin_visa_markup_template');
    $routes->post('edit-admin-visa-markup/(:any)', '\Modules\MarkupDiscount\Controllers\MarkupDiscount::edit_admin_visa_markup');
    /** end visa  markup routes*/


    /** visa  discount routes start */
    $routes->get('visa-discount-list', '\Modules\MarkupDiscount\Controllers\MarkupDiscount::visa_discount_list');
    $routes->post('visa-discount-view', '\Modules\MarkupDiscount\Controllers\MarkupDiscount::visa_discount_view');
    $routes->post('add-visa-discount', '\Modules\MarkupDiscount\Controllers\MarkupDiscount::add_visa_discount');
    $routes->post('visa-discount-status-change', '\Modules\MarkupDiscount\Controllers\MarkupDiscount::visa_discount_status_change');
    $routes->post('remove-visa-discount', '\Modules\MarkupDiscount\Controllers\MarkupDiscount::remove_visa_discount');
    $routes->post('edit-admin-visa-discount-template/(:any)', '\Modules\MarkupDiscount\Controllers\MarkupDiscount::edit_admin_visa_discount_template');
    $routes->post('edit-admin-visa-discount/(:any)', '\Modules\MarkupDiscount\Controllers\MarkupDiscount::edit_admin_visa_discount');
    /** end visa  discount routes*/



});

