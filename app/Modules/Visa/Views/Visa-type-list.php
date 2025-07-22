<div class="content">
    <div class="page-content">
        <div class="card">
        <?php echo view('\Modules\Visa\Views\menu-bar'); ?>
            <div class="card-body">
                
                        
                         <div class="page-actions-panel">
                            <div class="row align-items-center">
                                <div class="col-md-4">
                                    <h5 class="m-0">Visa Type List</h5>
                                </div>
                                <div class="col-md-8 text-end">

                                    <?php if(permission_access("Visa", "add_visa_type")) {  ?>
                                        <button class="badge badge-wt" view-data-modal="true" data-controller='visa'
                                                data-href="<?php echo site_url('visa/add-visa-type-template') ?>">
                                            <i class="fa-solid fa-add"></i> Add Visa Type
                                        </button>
                                    <?php } ?>

                                    <?php if(permission_access("Visa", "delete_visa_type")) {  ?>
                                    <button class="badge badge-danger badge-wt danger disable_badge" tts-disable_badge
                                            onclick="confirm_delete('formlist')"><i class="fa-solid fa-trash"></i> Delete
                                    </button>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                        

                        


                                <!----------Start Search Bar ----------------->
                                <form action="<?php echo site_url('visa/visa-types-list'); ?>" method="GET" class="row mt-3 mb-3"
                                      name="visa-types-search" onsubmit="return searchvalidateForm()">
                                    <div class="col-md-3">
                                        <div class="form-group form-mb-20">
                                            <label>Select key to search by *</label>
                                            <select name="key" class="form-select"
                                                    onchange="tts_searchkey(this,'visa-types-search')"
                                                    tts-validatation="Required" tts-error-msg="Please select search key">
                                                <option value="">Please select</option>
                                                <option value="visa_title" <?php if (isset($search_bar_data['key']) && $search_bar_data['key'] == 'visa_title') {
                                                    echo "selected";
                                                } ?>>Title
                                                </option>

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
                                                echo 'tts-validatation="Required"';
                                            } ?> tts-error-msg="Please enter value"/>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group form-mb-20">
                                            <label>From Date</label><input type="text" data-searchbar-from="true" name="from_date"
                                                                           value="<?php if (isset($search_bar_data['from_date'])) {
                                                                               echo $search_bar_data['from_date'];
                                                                           } ?>" placeholder="Select From Date" class="form-control"
                                                                           tts-error-msg="Please select from date" readonly/>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group form-mb-20">
                                            <label>To Date</label><input type="text" data-searchbar-to="true" name="to_date"
                                                                         value="<?php if (isset($search_bar_data['to_date'])) {
                                                                             echo $search_bar_data['to_date'];
                                                                         } ?>" placeholder="Select To Date" class="form-control"
                                                                         tts-error-msg="Please select to date" readonly/>
                                        </div>
                                    </div>
                                    <div class="col-md-2 align-self-end">
                                        <div class="form-group form-mb-20">
                                           
                                            <button type="submit" class="badge badge-md badge-primary badge_search">Search <i class="fa fa-search"></i></button>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                    <?php if (isset($search_bar_data['key'])): ?>
                                        
                                            <div class="search-reset-btn">
                                                <a href="<?php echo site_url('visa/visa-types-list'); ?>">Reset Search</a>
                                            </div>
                                        
                                    <?php endif ?>
                                    </div>
                                </form>
                            

                                <div class="table-responsive">
                                    <?php $trash_uri = "visa/remove-visa-type"; ?>
                                    <form action="<?php echo site_url($trash_uri); ?>" method="POST" tts-form="true" id="formlist">
                                        <table class="table table-bordered table-hover">
                                            <thead class="table-active">
                                            <tr>

                                                <?php if(permission_access("Visa", "delete_visa_type") ) {  ?>
                                                <th><label><input type="checkbox" name="check_all"
                                                                  id="selectall"/></label>
                                                </th>
                                                <?php } ?>
                                                <th>Image</th>
                                                <th>Title</th>
                                                <th>Slug</th>
                                                <th>Created Date</th>
                                                <th>Modified Date</th>
                                                <?php if (permission_access("Visa", "edit_visa_type")) {  ?>
                                                <th>Action</th>
                                                <?php }  ?>

                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php

                                            if (!empty($list) && is_array($list)) {
                                                foreach ($list as $data) {

                                                    ?>
                                                    <tr>
                                                        <?php if (permission_access("Visa", "delete_visa_type") ) {  ?>
                                                        <td>
                                                            <label><input type="checkbox" name="checklist[]" class="checkbox"
                                                                          value="<?php echo $data['id']; ?>"/></label>
                                                        </td>
                                                        <?php } ?>
                                                        <td>
                                                            <img src="<?php echo root_url . "uploads/visa_type/thumbnail/" . $data['image']; ?>"
                                                                 alt="<?php echo $data['visa_title']; ?>" class="tts-blog-image" width="100" height="60">
                                                        </td>
                                                        <td>
                                                            <?php echo $data['visa_title']; ?>
                                                        </td>
                                                        <td>
                                                            <?php echo $data['visa_title_slug']; ?>
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

                                                        <?php if (permission_access("Visa", "edit_visa_type")) {  ?>
                                                        <td>
                                                            <a href="javascript:void(0);" view-data-modal="true" data-controller='visa'
                                                               data-id="<?php echo dev_encode($data['id']); ?>"
                                                               data-href="<?php echo site_url('/visa/edit-visa-type-template/') . dev_encode($data['id']); ?>"><i
                                                                        class="fa-solid fa-edit"></i></a>
                                                        </td>
                                                        <?php } ?>

                                                    </tr>
                                                <?php }
                                            } else {
                                                echo "<tr> <td colspan='11' class='text-center'><b>No Visa Type Found</b></td></tr>";
                                            } ?>
                                            </tbody>
                                        </table>

                                    </form>

                                    
                                </div>
                                <div class="row pagiantion_row align-items-center">
                                            <div class="col-md-6 mb-3 mb-lg-0">
                                                <p class="pagiantion_text">Page <?= $pager->getCurrentPage() ?>
                                                    of <?= $pager->getPageCount() ?>,
                                                    total <?= $pager->getTotal() ?> records found </p>
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


