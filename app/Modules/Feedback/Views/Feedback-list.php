
<div class="content ">
    <div class="page-content">
        <div class="table_title">
            <div class="sale_bar">
                <div class="row align-items-center">
                    <div class="col-md-4 mb-lg-0">
                        <h5 class="m0">  <?php echo $title.' ';?>List</h5>
                    </div>
                    <div class="col-md-8 text-md-end">
                        <?php if (permission_access_error("Feedback", "add_feedback")) { ?>
                        <button class="badge badge-wt" view-data-modal="true" data-controller='feedback'  data-href="<?php echo site_url('feedback/add-feedback-template')?>"> <i class="fa fa-add"></i> Add Feedback </button>
                        <?php }?>
                        <?php if (permission_access_error("Feedback", "feedback_status")) { ?>
                        <button class="badge badge-wt" onclick="confirm_change_status('status_change')"> <i class="fa-solid fa-exchange"></i> Change Status</button>
                        <?php }?>
                        <?php if (permission_access_error("Feedback", "delete_feedback")) { ?>
                        <button class="badge badge-danger badge-wt danger disable_badge" tts-disable_badge onclick="confirm_delete('formbloglist')"> <i class="fa fa-trash"></i> Delete </button>
                        <?php }?>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">

                <div class="row ">
                <!----------Start Search Bar ----------------->
                <form action="<?php echo site_url('feedback'); ?>" method="GET" class="tts-dis-content row mb-3" name="feedback-search" onsubmit="return searchvalidateForm()">
                    <div class="col-md-3">
                        <div class="form-group form-mb-20">
                            <label>Select key to search by *</label>
                            <select name="key" class="form-select" onchange="tts_searchkey(this,'feedback-search')" tts-validatation="Required" tts-error-msg="Please select search key">
                                <option value="">Please select</option>
                                <option value="name" <?php if(isset($search_bar_data['key']) && $search_bar_data['key']=='name'){ echo "selected";} ?>>Name</option>
                                <option value="email" <?php if(isset($search_bar_data['key']) && $search_bar_data['key']=='email'){ echo "selected";} ?>  >Email ID</option>
                                <option value="date-range" <?php if(isset($search_bar_data['key']) && $search_bar_data['key']=='date-range'){ echo "selected";} ?>>Date Range</option>
                            </select>
                        </div>
                        <input type="hidden" name="key-text" value="<?php if(isset($search_bar_data['key-text'])){ echo trim($search_bar_data['key-text']); } ?>">
                    </div>
                    <div class="col-md-3">
                        <div class="form-group form-mb-20">
                            <label><?php if(isset($search_bar_data['key']) && $search_bar_data['key']!='date-range') { echo $search_bar_data['key-text']. " *"; } else { echo "Value"; } ?> </label>
                            <input type="text" name="value" placeholder="Value"  value="<?php if(isset($search_bar_data['value'])){ echo $search_bar_data['value']; } ?>" class="form-control" <?php if(isset($search_bar_data['key']) && $search_bar_data['key']=='date-range') { echo "disabled"; } ?> <?php if(isset($search_bar_data['key']) && $search_bar_data['key']=='date-range') {  } else { echo 'tts-validatation="Required"'; } ?>   tts-error-msg="Please enter value" />
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group form-mb-20">
                            <label>From Date</label><input type="text" data-searchbar-from="true" name="from_date" value="<?php if(isset($search_bar_data['from_date'])){ echo $search_bar_data['from_date']; } ?>" placeholder="Select From Date" class="form-control" tts-error-msg="Please select from date" readonly/>
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
                         <div class="col-md-3 mb-3">
                            <div class="search-reset-btn">
                                <a href="<?php echo site_url('feedback');?>">Reset Search</a>
                            </div>
                         </div>
                    <? endif ?>
                   
                </form>
            </div>
            <!----------End Search Bar ----------------->
                <div class="table-responsive">
                    <?php $trash_uri = "feedback/remove-feedback"; ?>
                    <form action="<?php echo site_url($trash_uri); ?>" method="POST" tts-form="true" id="formbloglist">
                        <table class="table table-bordered table-hover">
                            <thead class="table-active">
                            <tr>
                                <?php if (permission_access_error("Feedback", "delete_feedback") || permission_access_error("Feedback", "feedback_status")) { ?>
                                <th><label><input type="checkbox" name="check_all" id="selectall" /></label>
                                </th>
                                <?php }?>
                                <th>User Image</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Status</th>
                                <th>Feedback Date</th>
                                <th>Created Date</th>
                                <?php if (permission_access_error("Feedback", "edit_feedback")) { ?>
                                <th>Action</th>
                                <?php }?>

                            </tr>
                            </thead>
                            <tbody>
                            <?php

                            if (!empty($list) && is_array($list)) {
                                foreach ($list as $data) {
                                    if($data['status'] =='active'){
                                        $status_class ='active-status';
                                    }else{
                                        $status_class ='inactive-status';
                                    }
                                    ?>

                                    <tr>
                                        <td>
                                            <label><input type="checkbox" name="checklist[]" class="checkbox" value="<?php echo $data['id']; ?>" /></label>
                                        </td>
                                        <td> <img src="<?php echo root_url . "uploads/feedback/thumbnail/" . $data['image']; ?>"alt="<?php echo $data['image']; ?>"  class="tts-blog-image"></td>

                                        <td>
                                            <a href="javascript:void(0);" class="txt_led_clr" view-data-modal="true" data-controller='feedback' data-id="<?php echo dev_encode($data['id']); ?>" data-href="<?php echo site_url('feedback/feedback-details/') . dev_encode($data['id']); ?>"><?php echo ucfirst($data['name']); ?></a>
                                        </td>

                                        <td><?php echo ($data['email']); ?></td>
                                        <td><?php echo ($data['phone']); ?></td>
                                        <td>

                                            <span class="<?php echo $status_class?>">
                                            <?php echo ucfirst($data['status']); ?>
                                            </span>

                                        </td>
                                        <td><?php echo ($data['feedback_date']); ?></td>

                                        <td><?php echo date_created_format($data['created']); ?></td>
                                        <?php if (permission_access_error("Feedback", "edit_feedback")) { ?>
                                        <td>
                                            <a href="javascript:void(0);" view-data-modal="true" data-controller='feedback' data-id="<?php echo dev_encode($data['id']); ?>" data-href="<?php echo site_url('/feedback/edit-feedback-template/') . dev_encode($data['id']); ?>"><i class="fa fa-edit"></i></a>
                                        </td>
                                        <?php }?>
                                    </tr>
                                <?php }
                            } else {
                                echo "<tr> <td colspan='11' class='text-center'><b>No Feedback Found</b></td></tr>";
                            } ?>
                            </tbody>
                        </table>

                    </form>

                   
                </div>
                <div class="row pagiantion_row align-items-center">
                            <div class="col-md-6 mb-3 mb-lg-0">
                                <p class="pagiantion_text">Page  <?= $pager->getCurrentPage() ?> of <?= $pager->getPageCount() ?>, total <?= $pager->getTotal() ?> records found </p>
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



<!-- status status change content -->
<div id="status_change" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Change Status</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?php echo site_url('feedback/feedback-status-change'); ?>" method="post" tts-form="true" name="form_change_status">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group form-mb-20">

                                <select class="form-control" name="status">
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
