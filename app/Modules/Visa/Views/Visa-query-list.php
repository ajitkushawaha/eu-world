<div class="content ">
    <div class="page-content">
        <div class="table_title">
            <div class="sale_bar">
                <div class="row align-items-center">
                    <div class="col-md-4">
                        <h5 class="m0">Visa Query List</h5>
                    </div>
                    <div class="col-md-8 text-end"> 

                        <?php  if (permission_access("Visa", "delete_visa_query")) { ?>
                            <button class="badge badge-danger badge-wt danger disable_badge" tts-disable_badge onclick="confirm_delete('formlist')"><i class="fa-solid fa-trash"></i> Delete
                            </button>
                        <?php } ?>

                    </div>
                </div>
            </div>
        </div>   
        <div class="card"> 
            <div class="card-body">

                <!----------Start Search Bar ----------------->
                <div class="row">
                <form action="<?php echo site_url('visa/visa-query-list'); ?>" method="GET" class="tts-dis-content row mb-3" name="markup-search" onsubmit="return searchvalidateForm()">
                        <div class="col-md-2">
                            <div class="form-group form-mb-20">
                                <label>Select key to search by *</label>
                                <select name="key" class="form-select" onchange="tts_searchkey(this,'markup-search')" tts-validatation="Required" tts-error-msg="Please select search key">
                                    <option value="">Please select</option>

                                    <option value="name" <?php if (isset($search_bar_data['key']) && $search_bar_data['key'] == 'name') {
                                            echo "selected";
                                        } ?>>Name
                                        </option>
                                        <option value="email" <?php if (isset($search_bar_data['key']) && $search_bar_data['key'] == 'email') {
                                            echo "selected";
                                        } ?> >Email
                                        </option>
                                        <option value="mobile" <?php if (isset($search_bar_data['key']) && $search_bar_data['key'] == 'mobile') {
                                            echo "selected";
                                        } ?> >Mobile No.
                                        </option>
                                        <option value="visa_type" <?php if (isset($search_bar_data['key']) && $search_bar_data['key'] == 'visa_type') {
                                            echo "selected";
                                        } ?> >Visa Type
                                        </option>
                                        <option value="date-range" <?php if (isset($search_bar_data['key']) && $search_bar_data['key'] == 'date-range') {
                                            echo "selected";
                                        } ?>>Date Range
                                </select>
                            </div>
                            <input type="hidden" name="key-text" value="<?php if (isset($search_bar_data['key-text'])) {
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
                                <label>From Date</label><input type="text" data-searchbar-from="true" name="from_date" value="<?php if (isset($search_bar_data['from_date'])) {
                                                                                                                                    echo $search_bar_data['from_date'];
                                                                                                                                } ?>" placeholder="Select From Date" class="form-control" tts-error-msg="Please select from date" readonly />
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group form-mb-20">
                                <label>To Date</label><input type="text" data-searchbar-to="true" name="to_date" value="<?php if (isset($search_bar_data['to_date'])) {
                                                                                                                            echo $search_bar_data['to_date'];
                                                                                                                        } ?>" placeholder="Select To Date" class="form-control" tts-error-msg="Please select to date" readonly />
                            </div>
                        </div>
                        <div class="col-md-1 align-self-end">
                            <div class="form-group form-mb-20">

                                <button type="submit" class="badge badge-md badge-primary badge_search">Search <i class="fa fa-search"></i></button>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <? if (isset($search_bar_data['key'])) : ?>

                                <div class="search-reset-btn">
                                    <a href="<?php echo site_url('visa/visa-query-list'); ?>">Reset
                                        Search</a>
                                </div>
                            <? endif ?>
                        </div>
                    </form>
                    
                </div>
                <!----------End Search Bar ----------------->

                <div class="table-responsive">
                    <?php $trash_uri = "visa/remove-visa-query"; ?>
                    <form action="<?php echo site_url($trash_uri); ?>" method="POST" tts-form="true" id="formlist">
                        <table class="table table-bordered table-hover">
                            <thead class="table-active">
                                <tr>
                                    <?php if (permission_access("Visa", "delete_visa_query")) { ?>
                                        <th><label><input type="checkbox" name="check_all" id="selectall" /></label> </th>
                                    <?php } ?>
                                    <th>Name</th>
                                    <th>Email id</th>
                                    <th>Mobile Number</th> 
                                    <th>Travel Date</th> 
                                    <th>Passenger</th> 
                                    <th>Visa Country</th>
                                    <th>Visa Type</th> 
                                    <th>Created Date</th>
                                  
                                  
                                </tr>
                            </thead>
                            <tbody>
                                <?php

                                if (!empty($list) && is_array($list)) {
                                    foreach ($list as $data) {

                                      
                                ?>

                                        <tr>
                                            <?php if (permission_access("Visa", "delete_visa_query") ) { ?>
                                                <td>
                                                    <label><input type="checkbox" name="checklist[]" class="checkbox" value="<?php echo $data['id']; ?>" /></label>
                                                </td>
                                            <?php } ?>
                                            <td>  <?php echo $data['name']; ?> </td>
                                            <td>  <?php echo $data['email']; ?> </td>
                                            <td>  <?php echo $data['mobile']; ?> </td>
                                            <td>  <?php echo $data['travel_date']; ?> </td>
                                            <td>  <?php echo $data['no_of_travellers']; ?> Passenger </td>
                                            <td>  <?php echo $data['country_name']; ?> </td>
                                            <td>  <?php echo $data['visa_type']; ?> </td>
                                             
 

                                            <td><?php echo date_created_format($data['created']); ?></td>
                                            

                                        </tr>
                                <?php }
                                } else {
                                    echo "<tr> <td colspan='11' class='text-center'><b>!! Visa Query Found !!</b></td></tr>";
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
 
 