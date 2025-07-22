

<?php

/**
 * Define Visa Routes
 */
$routes->group("visa", ["filter" => "auth"], function ($routes) {

    /** visa Booking routes start*/
    $routes->match(['get'], '/', '\Modules\Visa\Controllers\Visa::index');
    $routes->get('get-invoice-ticket/(:any)', '\Modules\Visa\Controllers\Visa::get_invoice_ticket');
    $routes->get('error', '\Modules\Visa\Controllers\Visa::error');
    /** visa Booking routes end*/


    $routes->match(['get', 'post'], 'get-invoice-ticket', '\Modules\Visa\Controllers\Visa::get_invoice_ticket');
    $routes->get('booking-list', '\Modules\Visa\Controllers\Visa::booking_list');
    $routes->get('confirmation/(:any)', '\Modules\Visa\Controllers\Visa::confirmation');
    $routes->get('visa-booking-details/(:any)', '\Modules\Visa\Controllers\Visa::visa_booking_detail');


    $routes->get('amendments-details/(:any)', '\Modules\Visa\Controllers\Visa::amendments_details');
    $routes->get('amendments', '\Modules\Visa\Controllers\Visa::amendment_lists');
    $routes->get('refunds', '\Modules\Visa\Controllers\Visa::refund_lists');
    $routes->post('refund-close', '\Modules\Visa\Controllers\Visa::refund_close');
    $routes->get('get-credit-note', '\Modules\Visa\Controllers\Visa::getCreditNote');

    $routes->get('visa-settings', '\Modules\Visa\Controllers\Visa::visa_country_list');
    $routes->post('add-visa-country-template', '\Modules\Visa\Controllers\Visa::add_visa_country_view');
    $routes->post('add-visa-country', '\Modules\Visa\Controllers\Visa::add_visa_country');
    $routes->post('edit-visa-country-template/(:any)', '\Modules\Visa\Controllers\Visa::edit_visa_country_view');
    $routes->post('edit-visa-country/(:any)', '\Modules\Visa\Controllers\Visa::edit_visa_country');
    $routes->post('country-status-change', '\Modules\Visa\Controllers\Visa::country_status_change');
    $routes->post('remove-visa-country', '\Modules\Visa\Controllers\Visa::remove_visa_country');

    $routes->get('visa-country-list', '\Modules\Visa\Controllers\Visa::visa_country_list');
    $routes->get('visa-types-list', '\Modules\Visa\Controllers\Visa::visa_type_list');
    $routes->post('add-visa-type-template', '\Modules\Visa\Controllers\Visa::add_visa_type_view');
    $routes->post('add-visa-type', '\Modules\Visa\Controllers\Visa::add_visa_type');
    $routes->post('edit-visa-type-template/(:any)', '\Modules\Visa\Controllers\Visa::edit_visa_type_view');
    $routes->post('edit-visa-type/(:any)', '\Modules\Visa\Controllers\Visa::edit_visa_type');
    $routes->post('remove-visa-type', '\Modules\Visa\Controllers\Visa::remove_visa_type');


    $routes->get('document-type', '\Modules\Visa\Controllers\Visa::document_type_view');
    $routes->post('add-document-type-template', '\Modules\Visa\Controllers\Visa::add_document_type_view');
    $routes->post('add-document-type', '\Modules\Visa\Controllers\Visa::add_document_type');
    $routes->post('remove-document-type', '\Modules\Visa\Controllers\Visa::remove_document_type');


    $routes->match(['get'], 'visa-list', '\Modules\Visa\Controllers\Visa::visa_list');
    $routes->get('add-visa-details-template', '\Modules\Visa\Controllers\Visa::add_visa_details_view');
    $routes->post('add-visa-details', '\Modules\Visa\Controllers\Visa::add_visa_details');
    $routes->get('edit-visa-details-template/(:any)', '\Modules\Visa\Controllers\Visa::edit_visa_details_view');
    $routes->post('edit-visa-details/(:any)', '\Modules\Visa\Controllers\Visa::edit_visa_details');
    $routes->post('details-status-change', '\Modules\Visa\Controllers\Visa::details_status_change');
    $routes->post('remove-visa-details', '\Modules\Visa\Controllers\Visa::remove_visa_details');


    /** visa  markup routes start */
    $routes->get('visa-markup-list', '\Modules\Visa\Controllers\Visa::visa_markup_list');
    $routes->post('visa-markup-view', '\Modules\Visa\Controllers\Visa::visa_markup_view');
    $routes->post('get-visa-list-select-markup', '\Modules\Visa\Controllers\Visa::get_visa_list_select_markup');
    $routes->post('get-visa-list-select', '\Modules\Visa\Controllers\Visa::get_visa_list_select');
    $routes->post('add-visa-markup', '\Modules\Visa\Controllers\Visa::add_visa_markup');
    $routes->post('visa-markup-status-change', '\Modules\Visa\Controllers\Visa::visa_markup_status_change');
    $routes->post('remove-visa-markup', '\Modules\Visa\Controllers\Visa::remove_visa_markup');
    $routes->post('edit-admin-visa-markup-template/(:any)', '\Modules\Visa\Controllers\Visa::edit_admin_visa_markup_template');
    $routes->post('edit-admin-visa-markup/(:any)', '\Modules\Visa\Controllers\Visa::edit_admin_visa_markup');
    /** end visa  markup routes*/

    /** visa  discount routes start */
    $routes->get('visa-discount-list', '\Modules\Visa\Controllers\Visa::visa_discount_list');
    $routes->post('visa-discount-view', '\Modules\Visa\Controllers\Visa::visa_discount_view');
    $routes->post('add-visa-discount', '\Modules\Visa\Controllers\Visa::add_visa_discount');
    $routes->post('visa-discount-status-change', '\Modules\Visa\Controllers\Visa::visa_discount_status_change');
    $routes->post('remove-visa-discount', '\Modules\Visa\Controllers\Visa::remove_visa_discount');
    $routes->post('edit-admin-visa-discount-template/(:any)', '\Modules\Visa\Controllers\Visa::edit_admin_visa_discount_template');
    $routes->post('edit-admin-visa-discount/(:any)', '\Modules\Visa\Controllers\Visa::edit_admin_visa_discount');
    /** end visa  discount routes*/

    $routes->get('assign-update-visa-ticket/(:any)', '\Modules\Visa\Controllers\Visa::AssignUpdateVisaTicket');
    $routes->get('get-update-visa-voucher-info/(:any)', '\Modules\Visa\Controllers\Visa::getUpdatevisaVoucherInfo');
    $routes->post('visa-update-voucher-info', '\Modules\Visa\Controllers\Visa::UpdateVisaVoucherInfo');

    $routes->post('amendment-status-change', '\Modules\Visa\Controllers\Visa::amendmentStatusChange');
    $routes->post('amendment-cancellation-charge', '\Modules\Visa\Controllers\Visa::amendment_cancellation_charge');


    $routes->get('visa-query-list', '\Modules\Visa\Controllers\Visa::VisaQueryList');

    // $routes->get('/', '\Modules\Holiday\Controllers\Holiday::index');
    $routes->post('remove-visa-query', '\Modules\Visa\Controllers\Visa::remove_visa_Query_list');


    $routes->match(['GET'], 'faq/(:any)', '\Modules\Visa\Controllers\FAQ::index');
    $routes->get('add-faq-view/(:any)', '\Modules\Visa\Controllers\FAQ::faqListView');
    $routes->post('add-faq-saved/(:any)', '\Modules\Visa\Controllers\FAQ::add_faq_Saved');
    $routes->post('removed-faq', '\Modules\Visa\Controllers\FAQ::remove_faq_List');
    $routes->post('faq-change-status', '\Modules\Visa\Controllers\FAQ::faq_status_change');
    $routes->get('edit-faq-template/(:any)', '\Modules\Visa\Controllers\FAQ::edit_faq_view');
    $routes->post('edit-faq-seved/(:any)', '\Modules\Visa\Controllers\FAQ::edit_faq_Seved');
});





require_once('VisaUploadRoutes.php');
