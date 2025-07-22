<div class="content ">
    <div class="page-content">
        <div class="table_title">
            <div class="sale_bar">
                <div class="row align-items-center">
                    <div class="col-md-4 mb-3 mb-lg-0">
                        <h5 class="m0">FAQ Page list </h5>
                    </div>
                    <div class="col-md-8 text-end">
                        <a href="<?php echo site_url('visa/add-faq-view/') . dev_encode($visa_detail_id); ?>"><button
                                class="badge badge-wt">Add Page</button></a>
                        <button class="badge badge-wt" onclick="confirm_change_status('status_change')"><i
                                class="fa fa-exchange"></i> Change Status
                        </button>
                        <button class="badge badge-danger badge-wt danger disable_badge" tts-disable_badge
                            onclick="confirm_delete('formdiscountlist')"><i class="fa-solid fa-trash"></i> Delete
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <!----------Start Search Bar ----------------->
                <form action="<?php echo site_url('visa/faq/') . dev_encode($visa_detail_id); ?>" method="GET" class="tts-dis-content"
                    name="faq-search" onsubmit="return searchvalidateForm()">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group form-mb-20">
                                <label>Select key to search by *</label>
                                <select name="key" class="form-select"
                                    onchange="tts_searchkey(this,'faq-search')" tts-validatation="Required"
                                    tts-error-msg="Please select search key">
                                    <option value="">Please select</option>
                                    <option value="title" <?php if (isset($search_bar_data['key']) && $search_bar_data['key'] == 'title') {
                                                                echo "selected";
                                                            } ?>>Title
                                    </option>
                                    <option value="status" <?php if (isset($search_bar_data['key']) && $search_bar_data['key'] == 'status') {
                                                                echo "selected";
                                                            } ?>>Status
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
                            <div class="form-group form-mb-20">
                                <label>
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
                                                                                                                                } ?> tts-error-msg="Please enter value" />
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group form-mb-20">
                                <label>From Date</label><input type="text" data-searchbar-from="true" name="from_date"
                                    value="<?php if (isset($search_bar_data['from_date'])) {
                                                echo $search_bar_data['from_date'];
                                            } ?>" placeholder="Select From Date" class="form-control"
                                    tts-error-msg="Please select from date" />
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group form-mb-20">
                                <label>To Date</label><input type="text" data-searchbar-to="true" name="to_date" value="<?php if (isset($search_bar_data['to_date'])) {
                                                                                                                            echo $search_bar_data['to_date'];
                                                                                                                        } ?>" placeholder="Select To Date" class="form-control"
                                    tts-error-msg="Please select to date" />
                            </div>
                        </div>
                        <div class="col-md-2 align-self-end">
                            <div class="form-group form-mb-20">
                                <button type="submit" class="badge badge-md badge-primary badge_search">Search <i
                                        class="fa fa-search"></i></button>
                            </div>
                        </div>
                        <? if (isset($search_bar_data['key'])): ?>
                            <div class="col-md-3 mb-3">
                                <div class="search-reset-btn">
                                    <a href="<?php echo site_url('visa/faq/') . dev_encode($visa_detail_id); ?>">Reset Search</a>
                                </div>
                            </div>
                        <? endif ?>
                    </div>
                </form>
                <!----------End Search Bar ----------------->
                <?php $trash_uri = "visa/removed-faq"; ?>
                <form action="<?php echo site_url($trash_uri); ?>" method="POST" tts-form="true" id="formdiscountlist">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="table-active">
                                <tr>
                                    <th><label><input type="checkbox" name="check_all" id="selectall" /></label>
                                    </th>
                                    <th>Title</th>
                                    <th>Status</th>
                                    <th>Country Code</th>
                                    <th>Created Date</th>
                                    <th>Modified Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if (!empty($list) && is_array($list)) {

                                    foreach ($list as $data) {

                                        if ($data['status'] == 'active') {
                                            $class = 'active-status';
                                        } else {
                                            $class = 'inactive-status';
                                        }

                                ?>
                                        <tr>
                                            <td>
                                                <label><input type="checkbox" name="checklist[]" class="checkbox"
                                                        value="<?php echo $data['id']; ?>" /></label>
                                            </td>
                                            <td>
                                                <?php echo $data['title']; ?>
                                            </td>
                                            <td>
                                                <span class="<?php echo $class ?>">
                                                    <?php echo ucfirst($data['status']); ?>
                                                </span>
                                            </td>
                                            <td>

                                                <?php echo ucfirst($data['visa_country_code']); ?>

                                            </td>

                                            <td>
                                                <?php echo date_created_format($data['created']); ?>
                                            </td>
                                            <td>
                                                <?php
                                                if (isset($data['modified'])) {
                                                    echo date_created_format($data['modified']);
                                                } else {
                                                    echo '-';
                                                }
                                                ?>
                                            </td>
                                            <td>
                                                <a href="<?php echo site_url('/visa/edit-faq-template/') . dev_encode($data['id']); ?>"
                                                    data-id="<?php echo dev_encode($data['id']); ?>"><i
                                                        class="fa-solid fa-edit"></i></a>

                                            </td>
                                        </tr>
                                <?php }
                                } else {
                                    echo "<tr> <td colspan='11' class='text-center'><b>No FAQ Discount Found</b></td></tr>";
                                } ?>
                            </tbody>
                        </table>
                    </div>
                </form>
                <div class="row pagiantion_row align-items-center">
                    <div class="col-md-6 mb-3 mb-lg-0">
                        <p class="pagiantion_text">Page
                            <?= $pager->getCurrentPage() ?>
                            of
                            <?= $pager->getPageCount() ?>, total
                            <?= $pager->getTotal() ?> records found
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
<!-- status status change content -->
<div id="status_change" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Change Status</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?php echo site_url('visa/faq-change-status'); ?>" method="post"
                tts-form="true" name="form_change_status">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group form-mb-20">
                                <select class="form-select" name="status">
                                    <option value="" selected="selected">Select Status</option>
                                    <option value="active">Active</option>
                                    <option value="inactive">Inactive</option>
                                </select>
                                <input type="hidden" name="checkedvalue">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" type="submit">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>