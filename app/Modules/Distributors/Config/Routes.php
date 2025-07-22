<?php

/**
 * Define Distributors Routes
 */
$routes->group("distributor", ["filter" => "auth"], function ($routes) {
    $routes->match(['get'], '/', '\Modules\Distributors\Controllers\Distributors::index');
    $routes->post('distributors-class', '\Modules\Distributors\Controllers\Distributors::distributors_class');
    $routes->post('add-distributor-class', '\Modules\Distributors\Controllers\Distributors::add_distributors_class');
    $routes->post('edit-distributor-class/(:any)', '\Modules\Distributors\Controllers\Distributors::edit_distributors_class');
    $routes->get('remove-supplier-class/(:any)', '\Modules\Distributors\Controllers\Distributors::remove_supplier_class');

    $routes->get('add-distributor-view', '\Modules\Distributors\Controllers\Distributors::add_distributor_view');
    $routes->post('add-distributor-save', '\Modules\Distributors\Controllers\Distributors::add_distributor_save');
    $routes->get('edit-distributor-view/(:any)', '\Modules\Distributors\Controllers\Distributors::edit_distributors_view');
    $routes->post('edit-distributor-save/(:any)', '\Modules\Distributors\Controllers\Distributors::edit_distributor_save');
    $routes->post('remove-distributor', '\Modules\Distributors\Controllers\Distributors::remove_distributor');
    $routes->post('distributor-status-change', '\Modules\Distributors\Controllers\Distributors::distributors_status_change');
    $routes->match(['post'], 'distributor-details/(:any)', '\Modules\Distributors\Controllers\Distributors::distributors_details');
    $routes->post('change-password', '\Modules\Distributors\Controllers\Distributors::change_password');
    $routes->get('distributors-account-logs/(:any)', '\Modules\Distributors\Controllers\Distributors::distributors_account_logs');
    $routes->post('view-remark/(:any)', '\Modules\Distributors\Controllers\Distributors::view_remark');
    $routes->post('account-update-log-remark/(:any)', '\Modules\Distributors\Controllers\Distributors::accountUpdateLogRemark');
    $routes->post('export-distributor', '\Modules\Distributors\Controllers\Distributors::export_distributor');
    /** supplier  routes*/

    /** supplier wallet routes*/
    $routes->post('virtual-topup-template/(:any)', '\Modules\Distributors\Controllers\Distributors::virtual_topup_view');
    $routes->post('virtual-topup/(:any)', '\Modules\Distributors\Controllers\Distributors::virtual_topup');

    $routes->post('virtual-debit-template/(:any)', '\Modules\Distributors\Controllers\Distributors::virtual_debit_view');
    $routes->post('virtual-debit/(:any)', '\Modules\Distributors\Controllers\Distributors::virtual_debit');
});
