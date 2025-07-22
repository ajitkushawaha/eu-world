<div class="content ">
    <div class="page-content">
        <div class="table_title">
            <div class="sale_bar">
                <div class="row">
                    <div class="col-md-4">
                        <h5 class="m-0">Refund List</h5>
                    </div>
                </div>
            </div>
            <div class="page-content-area">
                <div class="card-body">

                    <!----------Start Search Bar ----------------->
                    <form class="row g-3 mb-3" action="<?php echo site_url('visa/refunds'); ?>" method="GET"
                        class="tts-dis-content" name="markup-search" onsubmit="return searchvalidateForm()">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="form-label">Select key to search by *</label>
                                <select name="key" class="form-select" onchange="tts_searchkey(this,'markup-search')"
                                    tts-validatation="Required" tts-error-msg="Please select search key">
                                    <option value="">Please select</option>


                                    <option value="booking_ref_number" <?php if (isset($search_bar_data['key']) && $search_bar_data['key'] == '=booking_ref_number') {
                                        echo "selected";
                                    } ?>>Booking Ref. No.
                                    </option>


                                    <option value="amendment_type" <?php if (isset($search_bar_data['key']) && $search_bar_data['key'] == 'amendment_type') {
                                        echo "selected";
                                    } ?>>Amendment Type
                                    </option>


                                    <option value=" booking_status" <?php if (isset($search_bar_data['key']) && $search_bar_data['key'] == 'booking_status') {
                                        echo "selected";
                                    } ?>>Booking Status
                                    </option>
                                    <option value="amendment_status" <?php if (isset($search_bar_data['key']) && $search_bar_data['key'] == 'amendment_status') {
                                        echo "selected";
                                    } ?>>Amendment Status
                                    </option>

                                    <option value="id" <?php if (isset($search_bar_data['key']) && $search_bar_data['key'] == 'id') {
                                        echo "selected";
                                    } ?>>Amendment Id
                                    </option>

                                    <option value="date-range" <?php if (isset($search_bar_data['key']) && $search_bar_data['key'] == 'date-range') {
                                        echo "selected";
                                    } ?>>Date Range
                                    </option>
                                </select>
                            </div>
                            <input type="hidden" name="key-text" value="<?php if (isset($search_bar_data['key-text'])) {
                                echo trim($search_bar_data['key-text']);
                            } ?>">
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="form-label">
                                    <?php if (isset($search_bar_data['key']) && $search_bar_data['key'] != 'date-range') {
                                        echo $search_bar_data['key-text'] . " *";
                                    } else {
                                        echo "Value";
                                    } ?>
                                </label>
                                <input type="text" name="value" placeholder="Value" value="<?php if (isset($search_bar_data['value'])) {
                                    echo $search_bar_data['value'];
                                } ?>" class="form-control" <?php if (isset($search_bar_data['key']) && $search_bar_data['key'] == 'date-range') {
                                     echo "disabled";
                                 } ?> <?php if (isset($search_bar_data['key']) && $search_bar_data['key'] == 'date-range') {
                                   } else {
                                       echo 'tts-validatation="Required"';
                                   } ?> tts-error-msg="Please enter value"/>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="form-label">From Date</label><input type="text" data-searchbar-from="true"
                                    name="from_date" value="<?php if (isset($search_bar_data['from_date'])) {
                                        echo $search_bar_data['from_date'];
                                    } ?>" placeholder="Select From Date"
                                    class="form-control" tts-error-msg="Please select from date" readonly />
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="form-label">To Date</label><input type="text" data-searchbar-to="true"
                                    name="to_date" value="<?php if (isset($search_bar_data['to_date'])) {
                                        echo $search_bar_data['to_date'];
                                    } ?>" placeholder="Select To Date"
                                    class="form-control" tts-error-msg="Please select to date" readonly />
                            </div>
                        </div>
                        <div class="col-md-2 align-self-end">
                            <div class="form-group">
                                <button type="submit" class="badge badge-md badge-primary badge_search">Search <i
                                        class="fa-solid fa-search"></i></button>
                            </div>
                        </div>
                        <? if (isset($search_bar_data['key'])): ?>
                        <div class="col-md-2">
                            <div class="search-reset-btn">
                                <a href="<?php echo site_url('visa/refunds'); ?>">Reset Search</a>
                            </div>
                        </div>
                        <? endif ?>
                    </form>

                    <!----------End Search Bar ----------------->
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="table-active">
                                <tr>

                                    <?php if (permission_access("Visa", "visa_booking_detail")) { ?>
                                    <th>Booking Ref. No.</th>
                                    <?php } ?>
                                    <th>Booking Source</th>
                                    <?php if (permission_access("Visa", "visa_amendment")) { ?>
                                    <th>Amendment Id</th>
                                    <?php } ?>
                                    <th>Refund Type</th>
                                    <th>Refund Amount</th>
                                    <?php if (permission_access("Visa", "refund_close")) { ?>
                                    <th>Refund Status</th>
                                    <?php } ?>
                                    <th>Country</th>
                                    <th>Type</th>
                                    <th>Travel Date</th>
                                    <th>Remark</th>
                                    <th>Created</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if (!empty($list) && is_array($list)) {
                                    foreach ($list as $data) {
                                        $class = getStatusClass($data['refund_status']);


                                        ?>
                                <tr>
                                    <?php if (permission_access("Visa", "visa_booking_detail")) { ?>
                                    <td>
                                        <a href="<?php echo site_url('/visa/visa-booking-details/') . $data['booking_ref_number']; ?>"
                                            target="<?php echo target ?>">
                                            <?php echo $data['booking_ref_number']; ?>
                                        </a>
                                    </td>
                                    <?php } ?>
                                    <td class="text-center">
                                        <?php if ($data['booking_source'] == "Wl_b2b"): ?>
                                        <span>
                                            <?php echo service_booking_source($data['booking_source'] ?? "") . ' - ' . $data['company_id']; ?>
                                        </span><br />
                                        <a href="javascript:void(0);" class="txt_led_clr" view-data-modal="true"
                                            data-controller='agent'
                                            data-id="<?php echo dev_encode($data['wl_agent_id']); ?>"
                                            data-href="<?php echo site_url('agent/agent-details/') . dev_encode($data['wl_agent_id']); ?>">
                                            <?php echo (isset($data['company_name']) && !empty($data['company_name'])) ? $data['company_name'] : 'NA' ?>
                                        </a>
                                        <?php else: ?>
                                        <a href="javascript:void(0);" class="txt_led_clr" view-data-modal="true"
                                            data-controller='customer'
                                            data-id="<?php echo dev_encode($data['wl_customer_id']); ?>"
                                            data-href="<?php echo site_url('customer/customer-details/') . dev_encode($data['wl_customer_id']); ?>">
                                            <span>
                                                <?php echo service_booking_source($data['booking_source'] ?? ""); ?>
                                            </span></a>
                                        <?php endif; ?>
                                    </td>

                                    <?php if (permission_access("Visa", "visa_amendment")) { ?>
                                    <td>
                                        <a href="<?php echo site_url('/visa/amendments-details/') . $ticketData = dev_encode($data['id']); ?>"
                                            target="<?php echo target ?>"><i class="tts-icon eye">
                                                <?php echo ucfirst($data['id']); ?>
                                            </i></a>
                                    </td>
                                    <?php } ?>
                                    <td>
                                        <?php echo ucfirst($data['amendment_type']); ?>
                                    </td>
                                    <td> ₹
                                        <?php echo ucfirst($data['refund_amount']); ?>
                                    </td>
                                    <?php if (permission_access("Visa", "refund_close")) { ?>
                                 

                                    <td>
                                        <span class="<?php echo $class; ?>"  <?php if ($data['refund_status'] == 'Open') { ?> onclick='flight_refund_close_modal("<?php echo dev_encode($data["id"]); ?>","<?php echo ucfirst($data["company_name"]) ?>")' <?php } ?>> <?php echo ucfirst($data['refund_status']); ?></span>
                                    </td>

                                    <?php } ?>
 

                                    <td>
                                        <?php echo ucwords($data['visa_country']); ?>
                                    </td>
                                    <td>
                                        <?php echo ucwords($data['visa_type']); ?>
                                    </td>
                                    <td>
                                        <?php echo ($data['date_of_journey']); ?>
                                    </td>

                                    <td>
                                        <?php echo ucfirst($data['account_remark']); ?>
                                    </td>

                                    <td>
                                        <?php echo date_created_format($data['created']); ?>
                                    </td>
                                </tr>
                                <?php }
                                } else {
                                    echo "<tr> <td colspan='14' class='text_center'><b>No Refund Found</b></td></tr>";
                                } ?>
                            </tbody>
                        </table>

                    </div>
                    <div class="row pagiantion_row align-items-center">
                        <div class="col-md-6">
                            <p class="pagiantion_text">Page
                                <?= $pager->getCurrentPage() ?>
                                of
                                <?= $pager->getPageCount() ?>, total
                                <?= $pager->getTotal() ?> records
                                found
                            </p>
                        </div>
                        <div class="col-md-6">
                            <?php if ($pager): ?>
                            <?= $pager->links() ?>
                            <?php endif ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="flight_refund_close" class="modal fade" tabindex="1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Close Refund Status</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="<?php echo site_url('visa/refund-close'); ?>" method="post" tts-form="true"
                    name="flight_refund_close">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group form-mb-20">
                                    <p>Agency Name : <strong class="company_name tts_agent_company"></strong></p>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Refund Status</label>
                                        <select class="form-control" name="status">
                                            <option value="Close">Close</option>
                                        </select>
                                    </div>
                                </div>
                                <input type="hidden" name="amendment_id" class="amendment_id">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Remark*</label>
                                        <textarea class="form-control" name="account_remark" rows="3"
                                            cols="15"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary" type="submit">Refund</button>
                    </div>
                </form>
            </div>
        </div>
    </div>