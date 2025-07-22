<?php
/**
 * Define Visa Routes Created by Abhay BDSDTechnology.com
 */
$routes->group("visa-upload", ["filter" => "auth"], function ($routes) {
    $routes->match(['get'], '/', '\Modules\Visa\Controllers\VisaUpload::index');
    $routes->post( 'visa-upload-data-store', '\Modules\Visa\Controllers\VisaUpload::visa_upload_data_store');
    $routes->match(['get'], 'visa-passenger-detail', '\Modules\Visa\Controllers\VisaUpload::visa_passenger_detail');
    $routes->post( 'traveller-pax-details', '\Modules\Visa\Controllers\VisaUpload::validate_travellers');
    $routes->post( 'passenger-details', '\Modules\Visa\Controllers\VisaUpload::passenger_details');
    $routes->match(['get'], 'visa-review-detail', '\Modules\Visa\Controllers\VisaUpload::visa_review_detail');
});
  