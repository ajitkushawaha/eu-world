<div class="content ">
    <div class="page-content">
        <div class="table_title">
            <div class="sale_bar">
                <div class="row align-items-center">
                    <div class="col-md-4">
                        <h5 class="m-0">Visa Discount</h5>
                    </div>
                    <div class="col-md-8 text-end">
                        <?php if (permission_access("Visa", "add_visa_discount")) { ?>
                        <button class="badge badge-wt" view-data-modal="true" data-controller='flight'
                                data-href="<?php echo site_url('visa/visa-discount-view') ?>"><i
                                    class="fa-solid fa-add"></i> Add Visa Discount
                        </button>
                        <?php }?>
                        <?php if (permission_access("Visa", "visa_discount_status")) { ?>
                        <button class="badge badge-wt" onclick="confirm_change_status('status_change')"><i
                                    class="fa-solid fa-exchange"></i> Change Status
                        </button>
                        <?php }?>
                        <?php if (permission_access("Visa", "delete_visa_discount")) { ?>
                        <button class="badge badge-danger badge-wt danger disable_badge" tts-disable_badge
                                onclick="confirm_delete('formmarkuplist')"><i class="fa-solid fa-trash"></i> Delete
                        </button>
                        <?php }?>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="row ">
                    <!----------Start Search Bar ----------------->
                    <form action="<?php echo site_url('visa/visa-discount-list'); ?>" method="GET" class="row mb-3" name="markup-search" onsubmit="return searchvalidateForm()">
                        <div class="col-md-2">
                            <div class="form-group form-mb-20">
                                <label>Select key to search by *</label>
                                <select name="key" class="form-select" onchange="tts_searchkey(this,'markup-search')" tts-validatation="Required" tts-error-msg="Please select search key">
                                    <option value="">Please select</option>
                                    <option value="discount_for" <?php if(isset($search_bar_data['key']) && $search_bar_data['key']=='discount_for'){ echo "selected";} ?>  >Discount For</option>
                                    <option value="visa_country_id" <?php if(isset($search_bar_data['key']) && $search_bar_data['key']=='visa_country_id'){ echo "selected";} ?>>Visa Country</option>
                                    <option value="visa_type_id" <?php if(isset($search_bar_data['key']) && $search_bar_data['key']=='visa_type_id'){ echo "selected";} ?>  >Visa Type</option>

                                    <option value="discount_type" <?php if(isset($search_bar_data['key']) && $search_bar_data['key']=='discount_type'){ echo "selected";} ?>  >Discount Type</option>
                                    <option value="date-range" <?php if(isset($search_bar_data['key']) && $search_bar_data['key']=='date-range'){ echo "selected";} ?>>Date Range</option>
                                </select>
                            </div>
                            <input type="hidden" name="key-text" value="<?php if(isset($search_bar_data['key-text'])){ echo trim($search_bar_data['key-text']); } ?>">
                        </div>
                        <div class="col-md-2">
                            <div class="form-group form-mb-20">
                                <label><?php if(isset($search_bar_data['key']) && $search_bar_data['key']!='date-range') { echo $search_bar_data['key-text']. " *"; } else { echo "Value"; } ?> </label>
                                <input type="text" name="value" placeholder="Value"  value="<?php if(isset($search_bar_data['value'])){ echo $search_bar_data['value']; } ?>" class="form-control" <?php if(isset($search_bar_data['key']) && $search_bar_data['key']=='date-range') { echo "disabled"; } ?> <?php if(isset($search_bar_data['key']) && $search_bar_data['key']=='date-range') {  } else { echo 'tts-validatation="Required"'; } ?>   tts-error-msg="Please enter value" />
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group form-mb-20">
                                <label>From Date</label><input type="text" data-searchbar-from="true" name="from_date" value="<?php if(isset($search_bar_data['from_date'])){ echo $search_bar_data['from_date']; } ?>" placeholder="Select From Date" class="form-control" tts-error-msg="Please select from date" readonly />
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group form-mb-20">
                                <label>To Date</label><input type="text" data-searchbar-to="true" name="to_date" value="<?php if(isset($search_bar_data['to_date'])){ echo $search_bar_data['to_date']; } ?>" placeholder="Select To Date" class="form-control" tts-error-msg="Please select to date" readonly/>
                            </div>
                        </div>
                        <div class="col-md-2 align-self-end">
                            <div class="form-group form-mb-20">
                                <button type="submit" class="badge badge-md badge-primary badge_search">Search <i class="fa fa-search"></i></button>
                            </div>
                        </div>
                         
                        <? if(isset($search_bar_data['key'])): ?>
                            <div class="col-md-2 align-self-center">
                                <div class="search-reset-btn">
                                    <a href="<?php echo site_url('visa/visa-discount-list');?>">Reset Search</a>
                                </div>
                            </div>
                        <? endif ?>
                        
                    </form>
                </div>

                <!----------End Search Bar ----------------->

                
                    <?php
                    $trash_uri = "visa/remove-visa-discount";
                    ?>
                <form action="<?php echo site_url($trash_uri); ?>" method="POST" tts-form="true" id="formmarkuplist">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="table-active">
                            <tr>
                                <?php if (permission_access("Visa", "delete_visa_discount") || permission_access("Visa", "visa_discount_status")) { ?>

                                <th><label><input type="checkbox" name="check_all" id="selectall"/></label>
                                </th>
                                <?php }?>
                                <th>Discount For</th>
                                <th>Agent Class</th>
                                <th>Visa Country</th>
                                <th>Visa Type</th>
                                <th>Value</th>
                                <th>Max Limit</th>
                                <th>Discount Type</th>
                                <th>Status</th>
                                <th>Created</th>
                                <th>Modified</th>
                                <?php if (permission_access("Visa", "edit_visa_discount")) { ?>
                                <th>Action</th>
                                <?php }?>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            if (!empty($list) && is_array($list)) {
                                foreach ($list as $data) {
                                // Add This line Abhay Start 
                                    $class = ($data['status'] == 'active') ? 'active-status' : 'inactive-status';
                                    $class_id = explode(',', $data['agent_class']);
                                    $partner_class = implode(', ', array_map('ucfirst', array_intersect_key($agent_class_list, array_flip($class_id))));

                                    $visa_type_id = explode(',', $data['visa_type_id']);

                                    $visa_title = implode(', ', array_map('ucfirst', array_intersect_key($visa_type_list, array_flip($visa_type_id))));

                                // Add This line Abhay End 

                                    ?>
                                    <tr>
                                        <?php if (permission_access("Visa", "delete_visa_discount") || permission_access("Visa", "visa_discount_status")) { ?>

                                        <td>
                                            <label><input type="checkbox" name="checklist[]" class="checkbox"
                                                          value="<?php echo $data['id']; ?>"/></label>
                                        </td>
                                        <?php }?>
                                        <td><?php echo $data['discount_for']; ?></td>
                                        <td><?php echo $partner_class; ?></td>
                                        <td>
                                            <?php echo $data['country_name']; ?>
                                        </td>
                                        <td>
                                            <?php echo $visa_title; ?>
                                        </td>
                                        <td><?php echo $data['value']; ?></td>
                                        <td><?php echo $data['max_limit']; ?></td>
                                        <td>
                                            <?php echo ucfirst($data['discount_type']); ?>
                                        </td>

                                        <td>
                                            <span class="<?php echo $class ?>">
                                            <?php echo ucfirst($data['status']); ?>
                                            </span>
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
                                        <?php if (permission_access("Visa", "edit_visa_discount")) { ?>
                                        <td>
                                            <a href="javascript:void(0);" view-data-modal="true" data-controller='visa' data-id="<?php echo dev_encode($data['id']); ?>" data-href="<?php echo site_url('/visa/edit-admin-visa-discount-template/') . dev_encode($data['id']); ?>"><i class="fa fa-edit"></i></a>
                                        </td>
                                        <?php }?>
                                    </tr>
                                <?php }
                            } else {
                                echo "<tr> <td colspan='11' class='text-center'><b>No Visa Discount Found</b></td></tr>";
                            } ?>
                            </tbody>
                        </table>
                     </div>    
                </form>

                    
               
                <div class="row pagiantion_row align-items-center">
                            <div class="col-md-6 mb-3 mb-lg-0">
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


<!-- status status change content -->
<div id="status_change" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">    
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Change Status</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?php echo site_url('visa/visa-discount-status-change'); ?>" method="post" tts-form="true"
                  name="form_change_status">
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

<!-- Show  status Modal content -->

