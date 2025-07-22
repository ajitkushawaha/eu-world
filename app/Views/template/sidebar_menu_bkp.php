<?php
if (isset (admin_cookie_data()['admin_comapny_detail']['whitelabel_user']) && admin_cookie_data()['admin_comapny_detail']['whitelabel_user'] == "active") {
    $whitelabel_user_status = "active";
} else {
    $whitelabel_user_status = "inactive";
}
$whitelabel_setting_data = admin_cookie_data()['whitelabel_setting_data'];

?>
<nav class="sidebar">
    <div class="sidebar-header">
        <a href="<?php echo site_url("dashboard"); ?>" class="sidebar-brand">
            Admin<span></span>
        </a>
        <div class="sidebar-toggler not-active">
            <span></span>
            <span></span>
            <span></span>
        </div>
    </div>


    <div class="sidebar-body ps">
        <ul class="nav" id="navigation">
            <li class="nav-item p_active <?php echo active_nav('Dashboard') ?>">
                <a href="<?php echo site_url("dashboard"); ?>" class="nav-link">
                    <i class="fa fa-dashboard"></i>
                    <span class="link-title">Dashboard</span>
                </a>
            </li>
            <? if ($whitelabel_user_status == "active"): ?>
                <?php if (permission_access("Setting", "Setting_Module")): ?>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="collapse" href="#settings" role="button" aria-expanded="false"
                            aria-controls="settings">
                            <i class="fa fa-cog"></i>
                            <span class="link-title">Settings</span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                class="feather feather-chevron-down link-arrow">
                                <polyline points="6 9 12 15 18 9"></polyline>
                            </svg>
                        </a>
                        <div class="collapse" id="settings">
                            <ul class="nav sub-menu">
                                <li class="nav-item">
                                    <a href="<?php echo site_url("setting"); ?>" class="nav-link"><i class="fa fa-circle"></i>
                                        Company Settings</a>
                                </li>

                                <?php if (permission_access("Setting", "user_list")): ?>
                                    <li class="nav-item">
                                        <a href="<?php echo site_url("setting/user-management"); ?>" class="nav-link"><i
                                                class="fa fa-circle"></i> User Management</a>
                                    </li>
                                <?php endif; ?>

                                <?php if (permission_access("Setting", "convenience_fee_list")): ?>
                                    <li class="nav-item">
                                        <a href="<?php echo site_url("convenience-fee"); ?>" class="nav-link"><i
                                                class="fa fa-circle"></i> Convenience Fee</a>
                                    </li>
                                <?php endif; ?>

                                <? if (isset ($whitelabel_setting_data['b2b_business']) && $whitelabel_setting_data['b2b_business'] == "active"): ?>
                                    <?php if (permission_access("Setting", "bank_account_list")): ?>
                                        <li class="nav-item">
                                            <a href="<?php echo site_url("bankaccounts"); ?>" class="nav-link"><i
                                                    class="fa fa-circle"></i> Bank Account</a>
                                        </li>
                                    <?php endif; ?>
                                <?php endif; ?>

                                <?php if (permission_access("Setting", "offline_supplier_list")): ?>
                                    <li class="nav-item">
                                        <a href="<?php echo site_url("offline-issue-supplier"); ?>" class="nav-link"><i
                                                class="fa fa-circle"></i> Offline Supplier</a>
                                    </li>
                                <?php endif; ?>

                                <? if (isset ($whitelabel_setting_data['is_direct_website']) && $whitelabel_setting_data['is_direct_website'] == "active"): ?>
                                    <?php if (permission_access("Setting", "airport_list")): ?>
                                        <li class="nav-item">
                                            <a href="<?php echo site_url("flightsettings"); ?>" class="nav-link"><i
                                                    class="fa fa-circle"></i> Flight Airport List</a>
                                        </li>
                                    <?php endif; ?>

                                    <?php if (permission_access("Setting", "airlines_list")): ?>
                                        <li class="nav-item">
                                            <a href="<?php echo site_url("flightsettings/flight-airlines-list"); ?>" class="nav-link"><i
                                                    class="fa fa-circle"></i> Flight Airline List</a>
                                        </li>
                                    <?php endif; ?>

                                    <?php if ($whitelabel_setting_data['multi_currency'] == 'active') { ?>
                                        <?php if (permission_access("Currency", "currency_list")): ?>
                                            <li class="nav-item">
                                                <a href="<?php echo site_url("currency"); ?>" class="nav-link"><i class="fa fa-circle"></i>
                                                    Currency</a>
                                            </li>
                                        <?php endif; ?>
                                    <?php } ?>

                                    <?php if (permission_access("Setting", "flight_fare_type_list")): ?>
                                        <li class="nav-item">
                                            <a href="<?php echo site_url("flightfaretype"); ?>" class="nav-link"><i
                                                    class="fa fa-circle"></i> Flight Fare Type</a>
                                        </li>
                                    <?php endif; ?>

                                <?php endif; ?>



                                <li class="nav-item">
                                    <a href="<?php echo site_url("notification"); ?>" class="nav-link"><i
                                            class="fa fa-circle"></i> Notification</a>
                                </li>


                            </ul>
                        </div>
                    </li>
                <?php endif; ?>
            <? endif; ?>

            <?php if ($whitelabel_user_status == "active" && ((isset ($whitelabel_setting_data['b2c_business']) && $whitelabel_setting_data['b2c_business'] == "active") || (isset ($whitelabel_setting_data['b2b_business']) && $whitelabel_setting_data['b2b_business'] == "active"))): ?>

                <? if (permission_access("Accounts", "Accounts_Module")): ?>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="collapse" href="#accounts" role="button" aria-expanded="false"
                            aria-controls="accounts">
                            <i class="fa fa-user"></i>
                            <span class="link-title">Accounts Management</span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                class="feather feather-chevron-down link-arrow">
                                <polyline points="6 9 12 15 18 9"></polyline>
                            </svg>
                        </a>
                        <div class="collapse" id="accounts">
                            <ul class="nav sub-menu">
                                <li class="nav-item">
                                    <a href="<?php echo site_url("accounts/wl-payment-history"); ?>" class="nav-link"><i
                                            class="fa fa-circle"></i> Payment History</a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?php echo site_url("sale-result"); ?>" class="nav-link"><i
                                            class="fa fa-circle"></i> Sales Report</a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?php echo site_url("webpartneraccounts/credit-notes"); ?>" class="nav-link"><i
                                            class="fa fa-circle"></i>Credit Notes</a>
                                </li>
                            </ul>
                        </div>
                    </li>
                <? endif; ?>
            <? endif; ?>
            <!-- <li class="nav-item nav-category">Services</li> -->
            <? if ($whitelabel_user_status == "active" && isset ($whitelabel_setting_data['flight_module']) && $whitelabel_setting_data['flight_module'] == "active"): ?>
                <? if (permission_access("Flight", "Flight_Module")): ?>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="collapse" href="#flight" role="button" aria-expanded="false"
                            aria-controls="flight">
                            <i class="fa fa-plane"></i>
                            <span class="link-title">Flight Management</span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                class="feather feather-chevron-down link-arrow">
                                <polyline points="6 9 12 15 18 9"></polyline>
                            </svg>
                        </a>
                        <div class="collapse" id="flight">
                            <ul class="nav sub-menu">
                                <li class="nav-item">
                                    <a href="<?php echo site_url("flight/flight-markup"); ?>" class="nav-link"><i
                                            class="fa fa-circle"></i> Flight Markup</a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?php echo site_url("flight/flight-discount"); ?>" class="nav-link"><i
                                            class="fa fa-circle"></i> Flight Discount</a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?php echo site_url("flight/bookings"); ?>" class="nav-link"><i
                                            class="fa fa-circle"></i> Flight Booking List</a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?php echo site_url("flight/booking-calender"); ?>" class="nav-link"><i
                                            class="fa fa-circle"></i> Flight Booking Calender</a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?php echo site_url("flight/flight-amendments"); ?>" class="nav-link"><i
                                            class="fa fa-circle"></i> Amendment List</a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?php echo site_url("flight/flight-refunds"); ?>" class="nav-link"><i
                                            class="fa fa-circle"></i> Flight Refund List</a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?php echo site_url("flight-ticket-upload"); ?>" class="nav-link"><i
                                            class="fa fa-circle"></i> Flight Upload Ticket</a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?php echo site_url("coupon/flight-coupon"); ?>" class="nav-link"><i
                                            class="fa fa-circle"></i>Flight Coupon List</a>
                                </li>


                                <li class="nav-item">
                                    <a href="<?php echo site_url("flight-top-routes"); ?>" class="nav-link"><i
                                            class="fa fa-circle"></i> Flight Top Routes</a>
                                </li>
                                <? if (isset ($whitelabel_setting_data['is_direct_website']) && $whitelabel_setting_data['is_direct_website'] == "active"): ?>

                                    <li class="nav-item">
                                        <a href="<?php echo site_url("flightoffline"); ?>" class="nav-link"><i
                                                class="fa fa-circle"></i> Offline Flight</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="<?php echo site_url("supplier-management"); ?>" class="nav-link"><i
                                                class="fa fa-circle"></i> Supplier Management </a>
                                    </li>

                                    <li class="nav-item">
                                        <a href="<?php echo site_url("flight-ticket-import"); ?>" class="nav-link"><i
                                                class="fa fa-circle"></i> Import PNR </a>
                                    </li>
                                <?php endif; ?>
                            </ul>
                        </div>
                    </li>
                <?php endif; ?>
            <?php endif; ?>

            <? if ($whitelabel_user_status == "active" && isset ($whitelabel_setting_data['flight_extranet_module']) && $whitelabel_setting_data['flight_extranet_module'] == "active"): ?>
                <? if (permission_access("FlightExtranet", "FlightExtranet_Module")): ?>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="collapse" href="#private-fare" role="button" aria-expanded="false"
                            aria-controls="FlightExtranet">
                            <i class="fa fa-plane"></i>
                            <span class="link-title">Flight Extranet Management</span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                class="feather feather-chevron-down link-arrow">
                                <polyline points="6 9 12 15 18 9"></polyline>
                            </svg>
                        </a>
                        <div class="collapse" id="private-fare">
                            <ul class="nav sub-menu">
                                <li class="nav-item">
                                    <a href="<?php echo site_url("private-fare/add-private-fare-page"); ?>" class="nav-link"><i
                                            class="fa fa-circle"></i> Add Private Fare </a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?php echo site_url("private-fare/private-fare-list"); ?>" class="nav-link"><i
                                            class="fa fa-circle"></i> Private Fare List</a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?php echo site_url("private-fare/fare-rule"); ?>" class="nav-link"><i
                                            class="fa fa-circle"></i> Add Fare Rule</a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?php echo site_url("private-fare/fare-rule-list"); ?>" class="nav-link"><i
                                            class="fa fa-circle"></i> Fare Rule List</a>
                                </li>

                            </ul>
                        </div>
                    </li>
                <?php endif; ?>
            <?php endif; ?>

            <? if ($whitelabel_user_status == "active" && isset ($whitelabel_setting_data['hotel_module']) && $whitelabel_setting_data['hotel_module'] == "active"): ?>
                <? if (permission_access("Hotel", "Hotel_Module")): ?>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="collapse" href="#hotel" role="button" aria-expanded="false"
                            aria-controls="hotel">
                            <i class="fa fa-building"></i>
                            <span class="link-title">Hotel Management</span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                class="feather feather-chevron-down link-arrow">
                                <polyline points="6 9 12 15 18 9"></polyline>
                            </svg>
                        </a>
                        <div class="collapse" id="hotel">
                            <ul class="nav sub-menu">
                                <li class="nav-item">
                                    <a href="<?php echo site_url("hotel/hotel-markup-list"); ?>" class="nav-link"><i
                                            class="fa fa-circle"></i> Hotel Markup</a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?php echo site_url("hotel/hotel-discount-list"); ?>" class="nav-link"><i
                                            class="fa fa-circle"></i> Hotel Discount</a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?php echo site_url("hotel/bookings"); ?>" class="nav-link"><i
                                            class="fa fa-circle"></i> Hotel Booking List</a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?php echo site_url("hotel/hotel-amendments"); ?>" class="nav-link"><i
                                            class="fa fa-circle"></i> Hotel Amendment
                                        List</a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?php echo site_url("hotel/hotel-refunds"); ?>" class="nav-link"><i
                                            class="fa fa-circle"></i> Hotel Refund
                                        List</a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?php echo site_url("hotel-upload"); ?>" class="nav-link"><i
                                            class="fa fa-circle"></i> Hotel Upload</a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?php echo site_url("coupon/hotel-coupon"); ?>" class="nav-link"><i
                                            class="fa fa-circle"></i>Hotel Coupon List</a>
                                </li>
                            </ul>
                        </div>
                    </li>
                <?php endif; ?>
            <?php endif; ?>

            <? if ($whitelabel_user_status == "active" && isset ($whitelabel_setting_data['hotel_extranet_module']) && $whitelabel_setting_data['hotel_extranet_module'] == "active"): ?>
                <? if (permission_access("HotelExtranet", "HotelExtranet_Module")): ?>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="collapse" href="#Hotel_extranet" role="button" aria-expanded="false"
                            aria-controls="Hotel_extranet">
                            <i class="fa fa-hotel"></i>
                            <span class="link-title">Hotel Extranet Management</span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                class="feather feather-chevron-down link-arrow">
                                <polyline points="6 9 12 15 18 9"></polyline>
                            </svg>
                        </a>
                        <div class="collapse" id="Hotel_extranet">
                            <ul class="nav sub-menu">
                                <li class="nav-item">
                                    <a href="<?php echo site_url("hotel-extranet/add-hotel"); ?>" class="nav-link"><i
                                            class="fa fa-circle"></i> Add Hotel</a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?php echo site_url("hotel-extranet/hotel-list"); ?>" class="nav-link"><i
                                            class="fa fa-circle"></i> Hotel List</a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?php echo site_url("hotel-extranet/hotel-extranet-settings"); ?>"
                                        class="nav-link"><i class="fa fa-circle"></i> Hotel Settings</a>
                                </li>
                            </ul>
                        </div>
                    </li>
                <?php endif; ?>
            <?php endif; ?>

            <? if ($whitelabel_user_status == "active" && isset ($whitelabel_setting_data['bus_module']) && $whitelabel_setting_data['bus_module'] == "active"): ?>
                <? if (permission_access("Bus", "Bus_Module")): ?>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="collapse" href="#bus-all" role="button" aria-expanded="false"
                            aria-controls="bus">
                            <i class="fa fa-bus"></i>
                            <span class="link-title">Bus Management</span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                class="feather feather-chevron-down link-arrow">
                                <polyline points="6 9 12 15 18 9"></polyline>
                            </svg>
                        </a>
                        <div class="collapse" id="bus-all">
                            <ul class="nav sub-menu">
                                <li class="nav-item">
                                    <a href="<?php echo site_url("bus/bus-markup-list"); ?>" class="nav-link"><i
                                            class="fa fa-circle"></i> Bus Markup</a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?php echo site_url("bus/bus-discount-list"); ?>" class="nav-link"><i
                                            class="fa fa-circle"></i> Bus Discount</a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?php echo site_url("bus/bus-booking-list"); ?>" class="nav-link"><i
                                            class="fa fa-circle"></i> Bus Booking List</a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?php echo site_url("bus/amendments"); ?>" class="nav-link"><i
                                            class="fa fa-circle"></i> Amendment List</a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?php echo site_url("bus/refunds"); ?>" class="nav-link"><i
                                            class="fa fa-circle"></i> Refund List</a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?php echo site_url("bus-upload-list"); ?>" class="nav-link"><i
                                            class="fa fa-circle"></i> Bus Upload</a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?php echo site_url("coupon/bus-coupon"); ?>" class="nav-link"><i
                                            class="fa fa-circle"></i>Bus Coupon List</a>
                                </li>
                            </ul>
                        </div>
                    </li>
                <?php endif; ?>
            <?php endif; ?>

            <? if ($whitelabel_user_status == "active" && isset ($whitelabel_setting_data['holiday_module']) && $whitelabel_setting_data['holiday_module'] == "active"): ?>
                <? if (permission_access("Holiday", "Holiday_Module")): ?>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="collapse" href="#holiday" role="button" aria-expanded="false"
                            aria-controls="holiday">
                            <i class="fa fa-umbrella"></i>
                            <span class="link-title">Holiday Management</span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                class="feather feather-chevron-down link-arrow">
                                <polyline points="6 9 12 15 18 9"></polyline>
                            </svg>
                        </a>
                        <div class="collapse" id="holiday">
                            <ul class="nav sub-menu">
                                <li class="nav-item">
                                    <a href="<?php echo site_url("holiday/holiday-markup-list"); ?>" class="nav-link"><i
                                            class="fa fa-circle"></i> Holiday Markup</a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?php echo site_url("holiday/holiday-discount-list"); ?>" class="nav-link"><i
                                            class="fa fa-circle"></i> Holiday Discount</a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?php echo site_url("holiday/add-holiday-list"); ?>" class="nav-link"><i
                                            class="fa fa-circle"></i> Add Holiday List</a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?php echo site_url("holiday"); ?>" class="nav-link"><i
                                            class="fa fa-circle"></i>Holiday List</a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?php echo site_url("holiday/booking-list"); ?>" class="nav-link"><i
                                            class="fa fa-circle"></i> Holiday Booking List </a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?php echo site_url("holiday/amendments"); ?>" class="nav-link"><i
                                            class="fa fa-circle"></i> Holiday Amendments List </a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?php echo site_url("holiday/refunds"); ?>" class="nav-link"><i
                                            class="fa fa-circle"></i> Holiday Refunds List </a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?php echo site_url("holiday/settings"); ?>" class="nav-link"><i
                                            class="fa fa-circle"></i> Holiday Settings</a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?php echo site_url("holiday/query-list"); ?>" class="nav-link"><i
                                            class="fa fa-circle"></i> Holiday Query List</a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?php echo site_url("coupon/holiday-coupon"); ?>" class="nav-link"><i
                                            class="fa fa-circle"></i>Holiday Coupon List</a>
                                </li>
                            </ul>
                        </div>
                    </li>
                <?php endif; ?>
            <?php endif; ?>

            <? if ($whitelabel_user_status == "active" && isset ($whitelabel_setting_data['cruise_module']) && $whitelabel_setting_data['cruise_module'] == "active"): ?>
                <? if (permission_access("Cruise", "Cruise_Module")): ?>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="collapse" href="#cruise" role="button" aria-expanded="false"
                            aria-controls="cruise">
                            <i class="fa-solid fa-ship"></i>
                            <span class="link-title"> Cruise Management</span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                class="feather feather-chevron-down link-arrow">
                                <polyline points="6 9 12 15 18 9"></polyline>
                            </svg>
                        </a>
                        <div class="collapse" id="cruise">
                            <ul class="nav sub-menu">
                                <li class="nav-item">
                                    <a href="<?php echo site_url("cruise/cruise-markup-list"); ?>" class="nav-link"><i
                                            class="fa fa-circle"></i>Cruise Markup</a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?php echo site_url("cruise/cruise-discount-list"); ?>" class="nav-link"><i
                                            class="fa fa-circle"></i>Cruise Discount</a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?php echo site_url("cruise/cruise-list"); ?>" class="nav-link"><i
                                            class="fa fa-circle"></i>Cruise List </a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?php echo site_url("cruise"); ?>" class="nav-link"><i
                                            class="fa fa-circle"></i>Cruise Booking List </a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?php echo site_url("cruise/amendments"); ?>" class="nav-link"><i
                                            class="fa fa-circle"></i>Amendments List </a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?php echo site_url("cruise/refunds"); ?>" class="nav-link"><i
                                            class="fa fa-circle"></i>Refunds List </a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?php echo site_url("cruise/cruise-settings"); ?>" class="nav-link"><i
                                            class="fa fa-circle"></i>Cruise Settings </a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?php echo site_url("coupon/cruise-coupon"); ?>" class="nav-link"><i
                                            class="fa fa-circle"></i>Cruise Coupon List</a>
                                </li>
                            </ul>
                        </div>
                    </li>
                <?php endif; ?>
            <?php endif; ?>

            <? if ($whitelabel_user_status == "active" && isset ($whitelabel_setting_data['car_module']) && $whitelabel_setting_data['car_module'] == "active"): ?>
                <? if (permission_access("CarExtranet", "CarExtranet_Module")): ?>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="collapse" href="#car" role="button" aria-expanded="false"
                            aria-controls="car">
                            <i class="fa fa-car"></i>
                            <span class="link-title">Car Management</span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                class="feather feather-chevron-down link-arrow">
                                <polyline points="6 9 12 15 18 9"></polyline>
                            </svg>
                        </a>
                        <div class="collapse" id="car">
                            <ul class="nav sub-menu">
                                <li class="nav-item">
                                    <a href="<?php echo site_url("car-extranet/car-info-list"); ?>" class="nav-link"><i
                                            class="fa fa-circle"></i> Car Info List</a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?php echo site_url("car-extranet/car-settings"); ?>" class="nav-link"><i
                                            class="fa fa-circle"></i> Car Setting</a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?php echo site_url("car/car-markup-list"); ?>" class="nav-link"><i
                                            class="fa fa-circle"></i> Car Markup</a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?php echo site_url("car/car-discount-list"); ?>" class="nav-link"><i
                                            class="fa fa-circle"></i> Car Discount</a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?php echo site_url("car/booking-list"); ?>" class="nav-link"><i
                                            class="fa fa-circle"></i> Car Booking List</a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?php echo site_url("car/amendments"); ?>" class="nav-link"><i
                                            class="fa fa-circle"></i> Amendment List</a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?php echo site_url("car/refunds"); ?>" class="nav-link"><i
                                            class="fa fa-circle"></i> Refund List</a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?php echo site_url("coupon/car-coupon"); ?>" class="nav-link"><i
                                            class="fa fa-circle"></i>Car Coupon List</a>
                                </li>
                                <!-- <li class="nav-item">
                                    <a href="<?php echo site_url("car-ticket-upload"); ?>" class="nav-link"><i class="fa fa-circle"></i> Car Ticket Upload</a>
                                </li> -->
                            </ul>
                        </div>
                    </li>
                <?php endif; ?>
            <?php endif; ?>

            <? if ($whitelabel_user_status == "active" && isset ($whitelabel_setting_data['visa_module']) && $whitelabel_setting_data['visa_module'] == "active"): ?>
                <? if (permission_access("Visa", "Visa_Module")): ?>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="collapse" href="#visa" role="button" aria-expanded="false"
                            aria-controls="visa">
                            <i class="fa-brands fa-cc-visa"></i>
                            <span class="link-title">Visa Management</span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                class="feather feather-chevron-down link-arrow">
                                <polyline points="6 9 12 15 18 9"></polyline>
                            </svg>
                        </a>
                        <div class="collapse" id="visa">
                            <ul class="nav sub-menu">
                                <li class="nav-item">
                                    <a href="<?php echo site_url("visa/visa-markup-list"); ?>" class="nav-link"><i
                                            class="fa fa-circle"></i> Visa Markup</a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?php echo site_url("visa/visa-discount-list"); ?>" class="nav-link"><i
                                            class="fa fa-circle"></i> Visa Discount</a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?php echo site_url("visa/visa-list"); ?>" class="nav-link"><i
                                            class="fa fa-circle"></i> Visa List</a>
                                </li>

                                <li class="nav-item">
                                    <a href="<?php echo site_url("visa/booking-list"); ?>" class="nav-link"><i
                                            class="fa fa-circle"></i> Visa Booking List</a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?php echo site_url("visa/amendments"); ?>" class="nav-link"><i
                                            class="fa fa-circle"></i> Amendment List</a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?php echo site_url("visa/refunds"); ?>" class="nav-link"><i
                                            class="fa fa-circle"></i> Refund List</a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?php echo site_url("visa-upload"); ?>" class="nav-link"><i
                                            class="fa fa-circle"></i> Visa Upload </a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?php echo site_url("visa/visa-settings"); ?>" class="nav-link"><i
                                            class="fa fa-circle"></i> Visa Setting List</a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?php echo site_url("visa/visa-query-list"); ?>" class="nav-link"><i
                                            class="fa fa-circle"></i> Visa Query List</a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?php echo site_url("coupon/visa-coupon"); ?>" class="nav-link"><i
                                            class="fa fa-circle"></i>Visa Coupon List</a>
                                </li>
                            </ul>
                        </div>
                    </li>
                <?php endif; ?>
            <?php endif; ?>

            <? if ($whitelabel_user_status == "active" && isset ($whitelabel_setting_data['activities_module']) && $whitelabel_setting_data['activities_module'] == "active"): ?>
                <? if (permission_access("Activities", "Activities_Module")): ?>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="collapse" href="#activities" role="button" aria-expanded="false"
                            aria-controls="activities">
                            <i class="fa fa-tasks"></i>
                            <span class="link-title">Activities Management</span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                class="feather feather-chevron-down link-arrow">
                                <polyline points="6 9 12 15 18 9"></polyline>
                            </svg>
                        </a>
                        <div class="collapse" id="activities">
                            <ul class="nav sub-menu">
                                <li class="nav-item">
                                    <a href="<?php echo site_url("activities/activities-markup-list"); ?>" class="nav-link"><i
                                            class="fa fa-circle"></i> Activities Markup</a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?php echo site_url("activities/activities-discount-list"); ?>" class="nav-link"><i
                                            class="fa fa-circle"></i> Activities Discount</a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?php echo site_url("activities/add-activities-show-page"); ?>" class="nav-link"><i
                                            class="fa fa-circle"></i>Add Activities </a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?php echo site_url("activities/activities-added-list"); ?>" class="nav-link"><i
                                            class="fa fa-circle"></i>Activities List </a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?php echo site_url("activities/activities-settings"); ?>" class="nav-link"><i
                                            class="fa fa-circle"></i>Activities Settings</a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?php echo site_url("activities/activities-booking-list"); ?>" class="nav-link"><i
                                            class="fa fa-circle"></i>Activities Booking List </a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?php echo site_url("activities/get-amendment-lists"); ?>" class="nav-link"><i
                                            class="fa fa-circle"></i>Activities Amendment List </a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?php echo site_url("activities/refunds"); ?>" class="nav-link"><i
                                            class="fa fa-circle"></i>Activities Refunds List </a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?php echo site_url("activities/activities-query"); ?>" class="nav-link"><i
                                            class="fa fa-circle"></i>Activities Query List </a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?php echo site_url("coupon/activities-coupon"); ?>" class="nav-link"><i
                                            class="fa fa-circle"></i>Activities Coupon List</a>
                                </li>

                            </ul>
                        </div>
                    </li>
                <?php endif; ?>
            <?php endif; ?>

            <? if ($whitelabel_user_status == "active" && isset ($whitelabel_setting_data['tourguide_module']) && $whitelabel_setting_data['tourguide_module'] == "active"): ?>
                <? if (permission_access("TourGuide", "TourGuide_Module")): ?>

                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="collapse" href="#tourguide" role="button" aria-expanded="false"
                            aria-controls="tourguide">
                            <i class="fa-brands fa-glide-g"></i>
                            <span class="link-title">Tour Guide Management</span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                class="feather feather-chevron-down link-arrow">
                                <polyline points="6 9 12 15 18 9"></polyline>
                            </svg>
                        </a>
                        <div class="collapse" id="tourguide">
                            <ul class="nav sub-menu">
                                <li class="nav-item">
                                    <a href="<?php echo site_url("tourguide/tourguide-markup-list"); ?>" class="nav-link"><i
                                            class="fa fa-circle"></i>Tour Guide Markup List </a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?php echo site_url("tourguide/tourguide-discount-list"); ?>" class="nav-link"><i
                                            class="fa fa-circle"></i>Tour Guide Discount List </a>
                                </li>


                                <li class="nav-item">
                                    <a href="<?php echo site_url("tourguide"); ?>" class="nav-link"><i class="fa fa-circle"></i>
                                        Tour Guide Management</a>
                                </li>

                                <li class="nav-item">
                                    <a href="<?php echo site_url("tourguide/booking-list"); ?>" class="nav-link"><i
                                            class="fa fa-circle"></i>Tour Guide Booking List </a>
                                </li>

                                <li class="nav-item">
                                    <a href="<?php echo site_url("tourguide/amendment-list"); ?>" class="nav-link"><i
                                            class="fa fa-circle"></i>Tour Guide Amendment List </a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?php echo site_url("tourguide/refunds"); ?>" class="nav-link"><i
                                            class="fa fa-circle"></i>Tour Guide Refund List </a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?php echo site_url("tourguide/tourguide-query-list"); ?>" class="nav-link"><i
                                            class="fa fa-circle"></i>Tour Guide Query List </a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?php echo site_url("coupon/tour-guide-coupon"); ?>" class="nav-link"><i
                                            class="fa fa-circle"></i>TourGuide Coupon List</a>
                                </li>


                            </ul>
                        </div>
                    </li>
                <?php endif; ?>
            <?php endif; ?>

            <? if ($whitelabel_user_status == "active" && isset ($whitelabel_setting_data['b2c_business']) && $whitelabel_setting_data['b2c_business'] == "active"): ?>
                <? if (permission_access("Coupon", "Coupon_Module")): ?>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="collapse" href="#coupon" role="button" aria-expanded="false"
                            aria-controls="coupon">
                            <i class="fa-solid fa-tag"></i>
                            <span class="link-title"> Coupon Management</span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                class="feather feather-chevron-down link-arrow">
                                <polyline points="6 9 12 15 18 9"></polyline>
                            </svg>
                        </a>
                        <div class="collapse" id="coupon">
                            <ul class="nav sub-menu">
                                <!-- <li class="nav-item">
                                    <a href="<?php echo site_url("coupon/flight-coupon"); ?>" class="nav-link"><i class="fa fa-circle"></i>Flight Coupon List</a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?php echo site_url("coupon/hotel-coupon"); ?>" class="nav-link"><i class="fa fa-circle"></i>Hotel Coupon List</a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?php echo site_url("coupon/bus-coupon"); ?>" class="nav-link"><i class="fa fa-circle"></i>Bus Coupon List</a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?php echo site_url("coupon/holiday-coupon"); ?>" class="nav-link"><i class="fa fa-circle"></i>Holiday Coupon List</a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?php echo site_url("coupon/tour-guide-coupon"); ?>" class="nav-link"><i class="fa fa-circle"></i>TourGuide Coupon List</a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?php echo site_url("coupon/activities-coupon"); ?>" class="nav-link"><i class="fa fa-circle"></i>Activities Coupon List</a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?php echo site_url("coupon/visa-coupon"); ?>" class="nav-link"><i class="fa fa-circle"></i>Visa Coupon List</a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?php echo site_url("coupon/car-coupon"); ?>" class="nav-link"><i class="fa fa-circle"></i>Car Coupon List</a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?php echo site_url("coupon/cruise-coupon"); ?>" class="nav-link"><i class="fa fa-circle"></i>Cruise Coupon List</a>
                                </li> -->
                                <li class="nav-item">
                                    <a href="<?php echo site_url("coupon/coupon-log"); ?>" class="nav-link"><i
                                            class="fa fa-circle"></i>Coupon Log</a>
                                </li>
                            </ul>
                        </div>
                    </li>
                <?php endif; ?>
            <?php endif; ?>

            <? if ($whitelabel_user_status == "active" && isset ($whitelabel_setting_data['b2b_business']) && $whitelabel_setting_data['b2b_business'] == "active"): ?>
                <? if (permission_access("Agent", "Agent_Module")): ?>
                    <li class="nav-item">
                        <a href="<?php echo site_url("agent"); ?>" class="nav-link">
                            <i class="fa-solid fa-users"></i>
                            <span class="link-title">Agent Management</span>
                        </a>
                    </li>
                <?php endif; ?>
            <?php endif; ?>

            <? if ($whitelabel_user_status == "active" && isset ($whitelabel_setting_data['splr_business']) && $whitelabel_setting_data['splr_business'] == "active"): ?>
                <? if (permission_access("Supplier", "Supplier_Module")): ?>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="collapse" href="#supplier_list" role="button" aria-expanded="false"
                            aria-controls="supplier_list">
                            <i class="fa-solid fa-handshake"></i>
                            <span class="link-title"> Supplier Management</span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                class="feather feather-chevron-down link-arrow">
                                <polyline points="6 9 12 15 18 9"></polyline>
                            </svg>
                        </a>
                        <div class="collapse" id="supplier_list">
                            <ul class="nav sub-menu">
                                <li class="nav-item">
                                    <a href="<?php echo site_url("suppliers/add-supplier-view"); ?>" class="nav-link"><i
                                            class="fa fa-circle"></i> Add Supplier</a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?php echo site_url("suppliers"); ?>" class="nav-link"><i class="fa fa-circle"></i>
                                        Supplier List</a>
                                </li>
                            </ul>
                        </div>
                    </li>
                <?php endif; ?>
            <?php endif; ?>

            <? if ($whitelabel_user_status == "active" && isset ($whitelabel_setting_data['dist_business']) && $whitelabel_setting_data['dist_business'] == "active"): ?>
                <? if (permission_access("Distributors", "Distributors_Module")): ?>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="collapse" href="#distributors_list" role="button"
                            aria-expanded="false" aria-controls="distributors_list">
                            <i class="fa-solid fa-handshake"></i>
                            <span class="link-title"> Distributor Management</span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                class="feather feather-chevron-down link-arrow">
                                <polyline points="6 9 12 15 18 9"></polyline>
                            </svg>
                        </a>
                        <div class="collapse" id="distributors_list">
                            <ul class="nav sub-menu">
                                <li class="nav-item">
                                    <a href="<?php echo site_url("distributor/add-distributor-view"); ?>" class="nav-link"><i
                                            class="fa fa-circle"></i> Add Distributor</a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?php echo site_url("distributor"); ?>" class="nav-link"><i
                                            class="fa fa-circle"></i> Distributor List</a>
                                </li>
                            </ul>
                        </div>
                    </li>
                <?php endif; ?>
            <?php endif; ?>

            <? if ($whitelabel_user_status == "active" && isset ($whitelabel_setting_data['b2c_business']) && $whitelabel_setting_data['b2c_business'] == "active"): ?>
                <? if (permission_access("Customer", "Customer_Module")): ?>
                    <li class="nav-item">
                        <a href="<?php echo site_url("customer"); ?>" class="nav-link">
                            <i class="fa fa-user-circle"></i>
                            <span class="link-title">Customer Management</span>
                        </a>
                    </li>
                <?php endif; ?>
            <?php endif; ?>

            <? if ($whitelabel_user_status == "active"): ?>
                <? if (permission_access("Slider", "Slider_Module")): ?>
                    <li class="nav-item">
                        <a href="<?php echo site_url("slider"); ?>" class="nav-link">
                            <i class="fa-solid fa-images"></i>
                            <span class="link-title">Slider Management</span>
                        </a>
                    </li>
                <? endif; ?>
            <? endif; ?>

            <? if ($whitelabel_user_status == "active"): ?>
                <? if (permission_access("Offers", "Offers_Module")): ?>
                    <li class="nav-item">
                        <a href="<?php echo site_url("offers"); ?>" class="nav-link">
                            <i class="fa fa-gift"></i>
                            <span class="link-title">Offers Management</span>
                        </a>
                    </li>
                <? endif; ?>
            <? endif; ?>

            <? if ($whitelabel_user_status == "active"): ?>
                <? if (permission_access("Page", "Page_Module")): ?>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="collapse" href="#PageManagement" role="button" aria-expanded="false"
                            aria-controls="PageManagement">
                            <i class="fa fa-tasks" aria-hidden="true"></i>
                            <span class="link-title">Page Management</span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                class="feather feather-chevron-down link-arrow">
                                <polyline points="6 9 12 15 18 9"></polyline>
                            </svg>
                        </a>
                        <div class="collapse" id="PageManagement">
                            <ul class="nav sub-menu">
                                <li class="nav-item">
                                    <a href="<?php echo site_url("pages"); ?>" class="nav-link"><i class="fa fa-circle"></i>
                                        <span>Page List</span></a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?php echo site_url("pages/menu-list"); ?>" class="nav-link"><i
                                            class="fa fa-circle"></i> <span>Menu</span></a>
                                </li>
                            </ul>
                        </div>
                    </li>
                <? endif; ?>
            <? endif; ?>

            <? if ($whitelabel_user_status == "active"): ?>
                <? if (permission_access("Query", "Query_Module")): ?>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="collapse" href="#Querymanagement" role="button"
                            aria-expanded="false" aria-controls="Querymanagement">
                            <i class="fa fa-tasks" aria-hidden="true"></i>
                            <span class="link-title">Query Management</span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                class="feather feather-chevron-down link-arrow">
                                <polyline points="6 9 12 15 18 9"></polyline>
                            </svg>
                        </a>
                        <div class="collapse" id="Querymanagement">
                            <ul class="nav sub-menu">
                                <li class="nav-item">
                                    <a href="<?php echo site_url("query"); ?>" class="nav-link"><i class="fa fa-circle"></i>
                                        <span>Contact us List</span></a>
                                </li>
                            </ul>
                        </div>
                    </li>
                <? endif; ?>
            <? endif; ?>

            <? if ($whitelabel_user_status == "active" && isset ($whitelabel_setting_data['b2c_business']) && $whitelabel_setting_data['b2c_business'] == "active"): ?>
                <? if (permission_access("Blog", "Blog_Module")): ?>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="collapse" href="#blog" role="button" aria-expanded="false"
                            aria-controls="blog">
                            <i class="fa fa-blog"></i>
                            <span class="link-title">Blog Management</span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                class="feather feather-chevron-down link-arrow">
                                <polyline points="6 9 12 15 18 9"></polyline>
                            </svg>
                        </a>
                        <div class="collapse" id="blog">
                            <ul class="nav sub-menu">
                                <? if (permission_access("Blog", "blog_category_list")): ?>
                                    <li class="nav-item">
                                        <a href="<?php echo site_url("blog/blog-category-list"); ?>" class="nav-link"><i
                                                class="fa fa-circle"></i> Blog Category List</a>
                                    </li>
                                <? endif; ?>
                                <li class="nav-item">
                                    <a href="<?php echo site_url("blog"); ?>" class="nav-link"><i class="fa fa-circle"></i> Blog
                                        List</a>
                                </li>
                            </ul>
                        </div>
                    </li>
                <? endif; ?>
            <? endif; ?>
            <? if ($whitelabel_user_status == "active" && isset ($whitelabel_setting_data['b2c_business']) && $whitelabel_setting_data['b2c_business'] == "active"): ?>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="collapse" href="#bike" role="button" aria-expanded="false"
                        aria-controls="bike">
                        <i class="fa fa-motorcycle" aria-hidden="true"></i>
                        <span class="link-title">Bike Renter Management</span>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="feather feather-chevron-down link-arrow">
                            <polyline points="6 9 12 15 18 9"></polyline>
                        </svg>
                    </a>
                    <div class="collapse" id="bike">
                        <ul class="nav sub-menu">
                            <li class="nav-item">
                                <a href="<?php echo site_url("bike-renter/add-bike-renter-view"); ?>" class="nav-link"><i
                                        class="fa fa-circle"></i> Add Bike Renter</a>
                            </li>
                            <li class="nav-item">
                                <a href="<?php echo site_url("bike-renter"); ?>" class="nav-link"><i
                                        class="fa fa-circle"></i>Bike Rrenter List</a>
                            </li>
                        </ul>
                    </div>
                </li>
            <? endif; ?>

            <? if ($whitelabel_user_status == "active"): ?>
                <? if (permission_access("Feedback", "Feedback_Module")): ?>
                    <li class="nav-item">
                        <a href="<?php echo site_url("feedback"); ?>" class="nav-link"> <i class="fa fa-comments"
                                aria-hidden="true"></i><span class="link-title"> Feedback Management</span></a>
                    </li>
                <? endif; ?>
            <? endif; ?>

            <? if ($whitelabel_user_status == "active"): ?>
                <? if (permission_access("Career", "Career_Module")): ?>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="collapse" href="#career" role="button" aria-expanded="false"
                            aria-controls="career">
                            <i class="fa-solid fa-graduation-cap"></i>
                            <span class="link-title">Career Management</span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                class="feather feather-chevron-down link-arrow">
                                <polyline points="6 9 12 15 18 9"></polyline>
                            </svg>
                        </a>
                        <div class="collapse" id="career">
                            <ul class="nav sub-menu">


                                <li class="nav-item">
                                    <a href="<?php echo site_url("career/career-categories-list"); ?>" class="nav-link"><i
                                            class="fa fa-circle"></i> Career Categories List</a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?php echo site_url("career"); ?>" class="nav-link"><i class="fa fa-circle"></i>
                                        Career List</a>
                                </li>

                                <li class="nav-item">
                                    <a href="<?php echo site_url("career/job-applications-list"); ?>" class="nav-link"><i
                                            class="fa fa-circle"></i> Career Job Applications List</a>
                                </li>
                            </ul>
                        </div>
                    </li>
                <? endif; ?>
            <? endif; ?>

            <? if ($whitelabel_user_status == "active"): ?>
                <? if (permission_access("Newsletter", "Newsletter_Module")): ?>
                    <li class="nav-item">
                        <a href="<?php echo site_url("newsletter"); ?>" class="nav-link"> <i class="fa fa-newspaper"
                                aria-hidden="true"></i> <span class="link-title">Newsletter List</span> </a>
                    </li>
                <? endif; ?>
            <? endif; ?>

            <? if ($whitelabel_user_status == "active"): ?>
                <? if (permission_access("Logs", "Logs_Module")): ?>
                    <li class="nav-item <?php echo active_nav('logs') ?>">
                        <a href="<?php echo site_url("logs"); ?>" class="nav-link"> <i class="fa-solid fa-history"></i> <span
                                class="link-title">Logs Management</span></a>
                    </li>
                <? endif; ?>
            <? endif; ?>
        </ul>
        <br /><br /><br /><br /><br /><br /><br /><br /><br /><br />
    </div>
</nav>