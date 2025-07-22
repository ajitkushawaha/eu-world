<div class="content ">
    <div class="page-content p-0 m-0">
        <div class="table_title">
            <div class="sale_bar">
                <div class="row align-items-center">
                    <div class="col-md-4">
                        <h5 class="m-0"> Visa Sales Report</h5>
                    </div>
                    <div class="col-md-8 text-md-right">
                    </div>
                </div>
            </div>

            <form action="<?php echo site_url('sale-result'); ?>" method="GET" class="mb-3 tts-dis-content" id="sales-export" name="markup-search" onsubmit="return searchvalidateForm()">
                <input type="hidden" name="q" value="Visa">
                <div class="row mt-3">
                    <div class="col-md-2">
                        <div class="form-group form-mb-20">
                            <label>Select key to search by *</label>
                            <select name="key" class="form-select"
                                onchange="tts_searchkey(this,'markup-search')"
                                tts-error-msg="Please select search key">
                                <option value="">Please select</option>
                                <option value="booking_ref_number" <?php if (isset($search_bar_data['key']) && $search_bar_data['key'] == 'booking_ref_number') {
                                                                        echo "selected";
                                                                    } ?>>Booking Ref Number
                                </option>
                                <option value="first_name" <?php if (isset($search_bar_data['key']) && $search_bar_data['key'] == 'first_name') {
                                                                echo "selected";
                                                            } ?>>First Name
                                </option>
                                <option value="last_name" <?php if (isset($search_bar_data['key']) && $search_bar_data['key'] == 'last_name') {
                                                                echo "selected";
                                                            } ?>>Last Name
                                </option>

                                <option value="booking_status" <?php if (isset($search_bar_data['key']) && $search_bar_data['key'] == 'booking_status') {
                                                                    echo "selected";
                                                                } ?>>Booking Status
                                </option>
                                <option value="payment_status" <?php if (isset($search_bar_data['key']) && $search_bar_data['key'] == 'payment_status') {
                                                                    echo "selected";
                                                                } ?>>Payment Status
                                </option>
                                <option value="date-range" <?php if (isset($search_bar_data['key']) && $search_bar_data['key'] == 'date-range') {
                                                                echo "selected";
                                                            } ?>>Date Range
                                </option>
                            </select>
                        </div>
                        <input type="hidden" name="key-text"
                            value="<?php if (isset($search_bar_data['key-text'])) {
                                        echo trim($search_bar_data['key-text']);
                                    } ?>">
                    </div>
                    <div class="col-md-2">
                        <div class="form-group form-mb-20">
                            <label><?php if (isset($search_bar_data['key']) && $search_bar_data['key'] != 'date-range') {
                                        echo $search_bar_data['key-text'] . " *";
                                    } else {

                                        echo "Value";
                                    } ?> </label>
                            <input type="text" name="value" placeholder="Value"
                                value="<?php if (isset($search_bar_data['value'])) {
                                            echo $search_bar_data['value'];
                                        } ?>"
                                class="form-control" <?php if (isset($search_bar_data['key']) && $search_bar_data['key'] == 'date-range') {
                                                            echo "disabled";
                                                        } ?> <?php if (isset($search_bar_data['key']) && $search_bar_data['key'] == 'date-range') {
                                                                } else {

                                                                    echo '';
                                                                } ?> tts-error-msg="Please enter value" />
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group form-mb-20">
                            <label>From Date</label><input type="text" data-searchbar-from="true"
                                name="from_date" id="from_date"
                                value="<?php if (isset($search_bar_data['from_date'])) {
                                            echo $search_bar_data['from_date'];
                                        } else {
                                            echo date('d M Y');
                                        } ?>" placeholder="Select From Date"
                                class="form-control"
                                tts-error-msg="Please select from date" readonly />
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group form-mb-20">
                            <label>To Date</label><input type="text" data-searchbar-to="true" name="to_date"
                                id="to_date"
                                value="<?php if (isset($search_bar_data['to_date'])) {
                                            echo $search_bar_data['to_date'];
                                        } else {
                                            echo date('d M Y');
                                        } ?>" placeholder="Select To Date" class="form-control"
                                tts-error-msg="Please select to date" readonly />
                        </div>
                    </div>
                    <div class="col-md-2 align-self-end">
                        <div class="form-group form-mb-20">
                            <button type="submit" data-url="<?php echo site_url('sale-result'); ?>"
                                praveen-method="get"
                                class="badge badge-md badge-primary export-praveen badge_search">Search <i
                                    class="fa fa-search"></i></button>
                        </div>
                    </div>
                    <div class="col-md-1">
                        <? if (isset($search_bar_data['key'])) : ?>
                            <div class="search-reset-btn">
                                <a href="<?php echo site_url('sale-result?q=Visa'); ?>">Reset Search</a>
                            </div>
                        <? endif ?>
                    </div>
                    <div class="col-md-1 text-md-right align-self-end">
                        <div class="form-group form-mb-20">
                            <button type="submit" data-url="<?php echo site_url('sale-result/get-report'); ?>"
                                praveen-method="post" id="export-data-btn"
                                class="btn_excel export-praveen">
                                <img src="<?php echo site_url('webroot/img/excel.svg'); ?>" class="img_fluid">
                            </button>
                        </div>
                    </div>
                    <input type="hidden" name="service" value="Visa">
            </form>
        </div>
        <!----------End Search Bar ----------------->
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="table-active">
                    <tr>
                        <th>Ref No.</th>
                        <th>Country</th>
                        <th>Visa Type</th>
                        <th>Departure Date</th>
                        <th>Price</th>
                        <th>Discount</th>
                        <th>GST</th>
                        <th>Booking Status</th>
                        <th>Payment Status</th>
                        <th>Web Partner</th>
                        <th>Created</th>
                        <th>Action</th>

                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (!empty($list) && is_array($list)) {
                        $count = 1;
                        foreach ($list as $data) {

                            if ($data['booking_status'] == 'Confirmed') {

                                $class = 'tts-text-success';
                            } else {

                                $class = 'tts-text-danger';
                            }


                            if ($data['payment_status'] == 'Successful') {

                                $payment_class = 'tts-text-success';
                            } else {

                                $payment_class = 'tts-text-danger';
                            }

                            $ticketData = dev_encode(json_encode(array("BookingId" => $data['id'], "BookingToken" => $data['tts_search_token'])));

                            $fareBreakupArray = json_decode($data['web_partner_fare_break_up'], true);

                            $FareBreakUp = array(

                                "FareBreakup" => array(

                                    "BasePrice" => array("Value" => $fareBreakupArray['BasePrice'], "LabelText" => "Base Price"),

                                    "Taxes" => array("Value" => $fareBreakupArray['Tax'], "LabelText" => "Taxes"),

                                    "ServiceAndOtherCharge" => array("Value" => $fareBreakupArray['ServiceCharges'], "LabelText" => "Other & Service Charges"),


                                    /*"CommEarned" => array("Value" => $fareBreakupArray['AgentCommission'], "LabelText" => "Comm Earned (-)"),*/

                                    "Discount" => array("Value" => $fareBreakupArray['Discount'], "LabelText" => "Discount (-)"),

                                    "TDS" => array("Value" => $fareBreakupArray['TDS'], "LabelText" => "TDS (+)")

                                ),

                                "TotalAmount" => array("Value" => $fareBreakupArray['TDS'] + $fareBreakupArray['OfferedPrice'], "LabelText" => "Total Amount"),

                                "GSTDetails" => $fareBreakupArray['GST']

                            );

                    ?>
                            <tr>
                                <td>
                                    <a href="<?php echo site_url('visa/visa-booking-details/') . $data['booking_ref_number'] ?>"><?php echo $data['booking_ref_number']; ?></a>
                                </td>
                                <td>
                                    <?php echo $data['visa_country'] ?>
                                </td>
                                <td>
                                    <?php echo $data['visa_type'] ?>
                                </td>
                                <td><?php echo date_created_format($data['date_of_journey']); ?></td>

                                <td>
                                    <?php foreach ($FareBreakUp['FareBreakup'] as $fare) {
                                        if ($fare['LabelText'] != 'Comm Earned (-)' && $fare['LabelText'] != 'Discount (-)'  && $fare['LabelText'] != 'TDS (+)') { ?>
                                            <b><?php echo $fare['LabelText']; ?>:</b>
                                            <i class="fa fa-inr" aria-hidden="true"></i> <?php echo custom_money_format($fare['Value']); ?>
                                            <br />
                                        <?php }
                                        ?>
                                    <?php } ?>
                                    <b><?php echo $FareBreakUp['TotalAmount']['LabelText']; ?>:</b>
                                    <i class="fa fa-inr" aria-hidden="true"></i> <?php echo custom_money_format($FareBreakUp['TotalAmount']['Value']); ?>
                                </td>
                                <td>
                                    <?php foreach ($FareBreakUp['FareBreakup'] as $fare) {
                                        if ($fare['LabelText'] == 'Comm Earned (-)' || $fare['LabelText'] == 'Discount (-)'  || $fare['LabelText'] == 'TDS (+)') { ?>
                                            <b><?php echo $fare['LabelText']; ?>:</b>
                                            <i class="fa fa-inr" aria-hidden="true"></i> <?php echo custom_money_format($fare['Value']); ?>
                                            <br />
                                        <?php }
                                        ?>
                                    <?php } ?>
                                </td>
                                <td>
                                    <b>Taxable
                                        Value:<i class="fa fa-inr" aria-hidden="true"></i> <?php echo custom_money_format($FareBreakUp['GSTDetails']['TaxableAmount']); ?></b> </br>
                                    <b>CGST @ <?php echo $FareBreakUp['GSTDetails']['CGSTRate']; ?>
                                        %:</b><i class="fa fa-inr" aria-hidden="true"></i> <?php echo custom_money_format($FareBreakUp['GSTDetails']['CGSTAmount']); ?> <br />
                                    <b>SGST @ <?php echo $FareBreakUp['GSTDetails']['SGSTRate']; ?>
                                        %:</b><i class="fa fa-inr" aria-hidden="true"></i> <?php echo custom_money_format($FareBreakUp['GSTDetails']['SGSTAmount']); ?> <br />
                                    <b>IGST @<?php echo $FareBreakUp['GSTDetails']['IGSTRate']; ?>
                                        %:</b><i class="fa fa-inr" aria-hidden="true"></i> <?php echo custom_money_format($FareBreakUp['GSTDetails']['IGSTAmount']); ?> <br />
                                    <b>Total:</b><i class="fa fa-inr" aria-hidden="true"></i> <?php echo custom_money_format($FareBreakUp['GSTDetails']['CGSTAmount'] + $FareBreakUp['GSTDetails']['SGSTAmount'] + $FareBreakUp['GSTDetails']['IGSTAmount']); ?>
                                    <br />
                                </td>
                                <td>
                                    <span class="<?php echo $class ?>">
                                        <?php echo ucfirst($data['booking_status']); ?>
                                    </span>
                                </td>

                                <td>
                                    <span class="<?php echo $payment_class ?>">
                                        <?php echo ucfirst($data['payment_status']); ?>
                                    </span>
                                </td>
                                <td><?php echo ucfirst($data['company_name']); ?>
                                    (<?php echo $data['company_id']; ?>)
                                </td>
                               

                                <td>
                                    <?php echo date_created_format($data['created']); ?>
                                </td>
                                <?php if (permission_access("CarExtranet", "edit_car_discount")) { ?>
                                    <td>
                                        <a href="<?php echo site_url('visa/confirmation/' . $ticketData); ?>">View</a>

                                    </td>
                                <?php } ?>
                            </tr>
                    <?php }
                    } else {

                        echo "<tr> <td colspan='11' class='text-center'><b>No Booking Found</b></td></tr>";
                    } ?>
                </tbody>
            </table>
        </div>
        <div class="row pagiantion_row align-items-center">
            <div class="col-md-6 mb-3 mb-lg-0">
                <p class="pagiantion_text">Page <?= $pager->getCurrentPage() ?>
                    of <?= $pager->getPageCount() ?>, total <?= $pager->getTotal() ?> records found
                </p>
            </div>
            <div class="col-md-6">
                <?php if ($pager) : ?>
                    <?= $pager->links() ?>
                <?php endif ?>
            </div>
        </div>


    </div>
</div>