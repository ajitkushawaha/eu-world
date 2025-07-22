<div class="content ">
    <div class="page-content">
        <div class="table_title">
            <div class="sale_bar">
                <div class="row align-items-center">
                    <div class="col-md-4">
                        <h5 class="m-0"> Customer Travelers List</h5>
                    </div>
                    <div class="col-md-8 text-md-end">
                        <?php if (permission_access("Customer", "delete_customerfff")) { ?>
                            <button class="badge badge-danger badge-wt danger disable_badge" tts-disable_badge
                                onclick="confirm_delete('formcustomerlist')"><i class="fa-solid fa-trash"></i> Delete
                            </button>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">

            <div class="card-body">

                <!----------Start Search Bar ----------------->
                <form class="row g-3 mb-3" action="<?php echo site_url('/customer/customer-travelers-list/') . dev_encode($wl_customer_id); ?>" method="GET" class="tts-dis-content"
                    name="customer-search" onsubmit="return searchvalidateForm()">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="form-label">Select key to search by *</label>
                            <select name="key" class="form-select" onchange="tts_searchkey(this,'customer-search')"
                                tts-validatation="Required" tts-error-msg="Please select search key">
                                <option value="">Please select</option>
                                <option value="first_name" <?php if (isset($search_bar_data['key']) && $search_bar_data['key'] == 'first_name') {
                                                                echo "selected";
                                                            } ?>>First Name
                                </option>
                                <option value="email" <?php if (isset($search_bar_data['key']) && $search_bar_data['key'] == 'email') {
                                                            echo "selected";
                                                        } ?>>Email ID
                                </option>
                                <option value="	mobile_number" <?php if (isset($search_bar_data['key']) && $search_bar_data['key'] == '	mobile_number') {
                                                                        echo "selected";
                                                                    } ?>>Mobile No
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
                            <label class="form-label"><?php if (isset($search_bar_data['key']) && $search_bar_data['key'] != 'date-range') {
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
                                                                    echo 'tts-validatation="Required"';
                                                                } ?> tts-error-msg="Please enter value" />
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label class="form-label">From Date</label>
                            <input type="text" data-searchbar-from="true" name="from_date"
                                value="<?php if (isset($search_bar_data['from_date'])) {
                                            echo $search_bar_data['from_date'];
                                        } ?>" placeholder="Select From Date" class="form-control"
                                tts-error-msg="Please select from date" readonly />
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label class="form-label">To Date</label>
                            <input type="text" data-searchbar-to="true" name="to_date"
                                value="<?php if (isset($search_bar_data['to_date'])) {
                                            echo $search_bar_data['to_date'];
                                        } ?>" placeholder="Select To Date" class="form-control"
                                tts-error-msg="Please select to date" readonly />
                        </div>
                    </div>
                    <div class="col-md-2 align-self-end">
                        <div class="form-group">
                            <button type="submit" class="badge badge-md badge-primary badge_search">Search <i class="fa-solid fa-search"></i></button>
                        </div>
                    </div>
                    <? if (isset($search_bar_data['key'])): ?>
                        <div class="col-md-2">
                            <div class="search-reset-btn">
                                <a href="<?php echo site_url('/customer/customer-travelers-list/') . dev_encode($wl_customer_id); ?>">Reset Search</a>
                            </div>
                        </div>
                    <? endif ?>
                </form>


                <!----------End Search Bar ----------------->

                <div class="table-responsive">
                    <?php $trash_uri = "customer/remove-customer"; ?>
                    <form action="<?php echo site_url($trash_uri); ?>" method="POST" tts-form="true"
                        id="formcustomerlist">
                        <table class="table table-bordered table-hover">
                            <thead class="table-active">
                                <tr>
                                    <?php if (permission_access("Customer", "delete_customerfff")) { ?>
                                        <th><label><input type="checkbox" name="check_all" id="selectall" /></label>
                                        </th>
                                    <?php } ?>
                                    <th>ID</th>
                                    <th>Customer ID</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Mobile</th>
                                    <th>Created Date</th>
                                    <th>Modified Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php

                                if (!empty($list) && is_array($list)) {
                                    foreach ($list as $data) { ?>
                                        <tr>
                                            <?php if (permission_access("Customer", "delete_customerfff")) { ?>
                                                <td>
                                                    <label><input type="checkbox" name="checklist[]" class="checkbox"
                                                            value="<?php echo $data['id']; ?>" /></label>
                                                </td>
                                            <?php } ?>
                                            <td>
                                                <?php echo $data['id']; ?>
                                            </td>

                                            <td> <a href="javascript:void(0);" class="txt_led_clr" view-data-modal="true"
                                                    data-controller='customer'
                                                    data-id="<?php echo dev_encode($data['wl_customer_id']); ?>"
                                                    data-href="<?php echo site_url('customer/customer-details/') . dev_encode($data['wl_customer_id']); ?>"><?php echo $data['wl_customer_id']; ?> </a>

                                            </td>
                                            <td>
                                                <?php
                                                $name = ucfirst($data['first_name'] . ' ' . $data['last_name']);
                                                $full_name = $name;

                                                ?>
                                                <a href="javascript:void(0);" class="txt_led_clr" view-data-modal="true"
                                                    data-controller="customer"
                                                    data-id="<?php echo dev_encode($data['id']); ?>"
                                                    data-href="<?php echo site_url('customer/customer-travelers-details/') . dev_encode($data['id']) . '/' . dev_encode($wl_customer_id); ?>">
                                                    <?php echo $full_name; ?>
                                                </a>


                                            </td>
                                            <td>
                                                <?php echo $data['email']; ?>
                                            </td>

                                            <td>
                                                <?php echo $data['mobile_number']; ?>

                                            </td>
                                            <td><?php echo date_created_format($data['created']); ?></td>
                                            <td><?php
                                                if (isset($data['modified'])) {
                                                    echo date_created_format($data['modified']);
                                                } else {
                                                    echo '-';
                                                }
                                                ?>
                                            </td>

                                        </tr>
                                <?php }
                                } else {
                                    echo "<tr> <td colspan='11' class='text-center'><b>No Customer Found</b></td></tr>";
                                } ?>
                            </tbody>
                        </table>

                    </form>
                </div>

                <div class="row pagiantion_row align-items-center">
                    <div class="col-md-6">
                        <p class="pagiantion_text">Page <?= $pager->getCurrentPage() ?>
                            of <?= $pager->getPageCount() ?>, total <?= $pager->getTotal() ?> records found </p>
                    </div>
                    <div class="col-md-6">
                        <?php if ($pager) : ?>
                            <?= $pager->links() ?>
                        <?php endif ?>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
</div>