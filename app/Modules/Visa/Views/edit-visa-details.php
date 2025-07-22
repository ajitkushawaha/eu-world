<div class="content">
    <div class="page-content">
        <div class="table_title">
            <div class="sale_bar">
                <div class="row align-items-center">
                    <div class="col-md-4 mb-3 mb-lg-0">
                        <h5>Edit Visa Details Page</h5>
                    </div>
                </div>
            </div>
        </div>
        <div class="page-content-area">
            <form action="<?php echo site_url('visa/edit-visa-details/') . dev_encode($id); ?>" method="post" tts-form="true" name="edit_visa_details" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group form-bm-20">
                                <label>Select Visa Country *</label>
                                <select class="form-select abhay_select_search" tts-method-name="visa/get-visa-list-select" name="visa_country_id">
                                    <option selected="selected">Select Visa Country</option>
                                    <?php if ($country) {
                                        foreach ($country as $data) { ?>
                                            <option value="<?php echo $data['CountryId'] ?>" <?php if ($details['visa_country_id'] == $data['CountryId']) {
                                                                                                    echo "selected";
                                                                                                } ?>>
                                                <?php echo $data['CountryName']; ?>
                                            </option>
                                    <?php }
                                    } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group form-bm-20">
                                <label>Select Visa Type*</label>
                                <select class="form-select abhay_select_search" name="visa_list_id" tts-call-put-html="true">
                                    <option value='' selected="selected">Select Visa Type</option>
                                    <?php
                                    if ($visa_list) {
                                        foreach ($visa_list as  $item) { ?>
                                            <option value=<?php echo $item['id'] ?> <?php if ($details['visa_list_id'] == $item['id']) {
                                                                                        echo "selected";
                                                                                    } ?>><?php echo $item['visa_title'] ?></option>
                                    <?php }
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group form-bm-20">
                                <label>Adult Price (Per Person) *</label>
                                <input class="form-control" type="text" name="adult_price" value="<?php echo $details['adult_price'] ?>" placeholder="Embassy Fee">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group form-bm-20">
                                <label>Child Price (Per Person) *</label>
                                <input class="form-control" type="text" name="child_price" value="<?php echo $details['child_price'] ?>" placeholder="Child Price">
                            </div>
                        </div>



                        <div class="col-md-3">
                            <div class="form-group form-bm-20">
                                <label>Status *</label>
                                <select class="form-select" name="status" placeholder="Status">
                                    <option value="active" <?php if ($details['status'] == "active") {
                                                                echo "selected";
                                                            } ?>>Active
                                    </option>
                                    <option value="inactive" <?php if ($details['status'] == "inactive") {
                                                                    echo "selected";
                                                                } ?>> Inactive
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group form-bm-20">
                                <label>Processing Time Days/Weeks *</label>
                                <select class="form-select" name="processing_time_D/W" placeholder="Processing Time Days/Weeks">
                                    <option value="">Select Processing Time Days/Weeks</option>
                                    <option value="In Days" <?php if ($details['processing_time_D/W'] == "In Days") {
                                                                echo "selected";
                                                            } ?>>In Days
                                    </option>
                                    <option value="In Weeks" <?php if ($details['processing_time_D/W'] == "In Weeks") {
                                                                    echo "selected";
                                                                } ?>> In Weeks
                                    </option>
                                    <option value="Other" <?php if ($details['processing_time_D/W'] == "Other") {
                                                                echo "selected";
                                                            } ?>> Other
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group form-mb-20">
                                <label>Processing Time Value *</label>
                                <input class="form-control" type="text" name="processing_time_value" value="<?php echo $details['processing_time_value'] ?>" placeholder="Processing Time Value">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group form-bm-20">
                                <label>Processing Time Quode *</label>
                                <input class="form-control" type="text" name="processing_time" value="<?php echo $details['processing_time'] ?>" placeholder="Processing Time Quode">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group form-bm-20">
                                <label>Stay Period *</label>
                                <input class="form-control" type="text" name="stay_period" value="<?php echo $details['stay_period'] ?>" placeholder="Stay Period">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group form-mb-20">
                                <label>Validity *</label>
                                <input class="form-control" type="text" name="validity" value="<?php echo $details['validity'] ?>" placeholder="Validity">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group form-mb-20">
                                <label>E-Visa *</label>
                                <select class="form-select" name="e_visa" placeholder="E-Visa">
                                    <option value="">Select E-Visa</option>
                                    <option value="true" <?php if ($details['e_visa'] == true) {
                                                                echo "selected";
                                                            } ?>>True
                                    </option>
                                    <option value="false" <?php if ($details['e_visa'] == false) {
                                                                echo "selected";
                                                            } ?>> False
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group form-mb-20">
                                <label>Category *</label>
                                <select class="form-select" name="category" placeholder="Category">
                                    <option value="">Select Category</option>
                                    <option value="Standard" <?php if ($details['category'] == "Standard") {
                                                                    echo "selected";
                                                                } ?>>Standard
                                    </option>
                                    <option value="Express" <?php if ($details['category'] == "Express") {
                                                                echo "selected";
                                                            } ?>>Express
                                    </option>

                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group form-mb-20">
                                <label>Hot Listed *</label>
                                <select class="form-select" name="hot_listed" placeholder="Hot Listed">
                                    <option value="true" <?php if ($details['hot_listed'] == "true") {
                                                                echo "selected";
                                                            } ?>>True
                                    </option>
                                    <option value="false" <?php if ($details['hot_listed'] == "false") {
                                                                echo "selected";
                                                            } ?>> False
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group form-mb-20">
                                <label>Occupancy Type *</label>
                                <select class="form-select" name="entry_type" placeholder="Occupancy Type">
                                    <option value="Single" <?php if ($details['entry_type'] == 'Single') {
                                                                echo "selected";
                                                            } ?>>Single</option>
                                    <option value="Double" <?php if ($details['entry_type'] == 'Double') {
                                                                echo "selected";
                                                            } ?>>Double</option>
                                    <option value="Triple" <?php if ($details['entry_type'] == 'Triple') {
                                                                echo "selected";
                                                            } ?>>Triple</option>
                                    <option value="Quad" <?php if ($details['entry_type'] == 'Quad') {
                                                                echo "selected";
                                                            } ?>>Quad</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group form-mb-20">
                                <label>Embass Visa Schedule TimeVisa Schedule Time (No.fo.Days) *</label>
                                <input class="form-control" type="number" name="visa_schedule_time" value="<?php echo $details['visa_schedule_time'] ?>" placeholder="Visa Schedule Time">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group form-mb-20">
                                <label>Company Schedule Time (No.fo.Days) *</label>
                                <input class="form-control" type="number" name="company_schedule_time" value="<?php echo $details['company_schedule_time'] ?>" placeholder="Company Schedule Time">
                            </div>
                        </div>
                        <?php $type = json_decode($details['documentType'], true); ?>
                        <?php if ($document_type) {
                            foreach ($document_type as $key => $document) { ?>
                                <div class="col-md-2">
                                    <div class="form-group form-mb-20">
                                        <label class="mt20">
                                            <input type="checkbox" name="documentType[<?= $key ?>][<?= $document['key_source'] ?>]" value="1" class="Lead" <?= (isset($type[$document['key_source']]) && $type[$document['key_source']] == 1) ? 'checked' : '' ?>>
                                            <?= $document['value'] ?>
                                        </label>
                                    </div>
                                </div>
                        <?php }
                        }
                        ?>


                        <div class="row">
                            <div class="col-md-12 ">
                                <h6 class="view_head">Other information</h6>
                            </div>
                            <div class="col-12">
                                <div id="tabs">
                                    <ul>
                                        <li><a href="#tts-visa-detail">Visa Detail</a></li>
                                        <li><a href="#tts-documentation">Visa Document</a></li>
                                        <li><a href="#tts-plan-disclaimer">Plan Disclaimer</a></li>
                                        <li><a href="#tts-visa-inclusions">Inclusions</a></li>
                                        <li><a href="#tts-important-information">Important Information</a></li>

                                    </ul>
                                    <div id="tts-visa-detail">
                                        <div class="col-md-12">
                                            <div class="form-group form-bm-20">
                                                <label>Visa Detail *</label>

                                                <textarea class="form-control tts-editornote" type="textarea" name="visa_detail" rows="3" placeholder="Visa Detail"><?php echo $details['visa_detail'] ?></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="tts-documentation">
                                        <div class="col-md-12">
                                            <div class="form-group form-bm-20">
                                                <label>Visa Document *</label>
                                                <textarea class="form-control tts-editornote" type="textarea" name="visa_document" rows="3" placeholder="Visa Document"><?php echo $details['visa_document'] ?></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="tts-plan-disclaimer">
                                        <div class="col-md-12">
                                            <div class="form-group form-bm-20">
                                                <label>Plan Disclaimer *</label>
                                                <textarea class="form-control tts-editornote" type="textarea" name="plan_disclaimer" rows="3" placeholder="Plan Disclaimer"><?php echo $details['plan_disclaimer'] ?></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="tts-visa-inclusions">
                                        <div class="col-12">
                                            <div class="d-flex align-items-center justify-content-between mb-2">
                                                <h5>Inclusion</h5>
                                                <button class="badge badge-wt" onclick="add_more_items(event,'visa-inclusion-html',15)">
                                                    <i class="fa-solid fa-add"></i> Add Inclusion
                                                </button>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="row" id="visa-inclusion-html">
                                                <?php $inclusions =  explode(",", $details['inclusions']); ?>
                                                <?php if (!empty($inclusions) && is_array($inclusions)) {
                                                    foreach ($inclusions as $inclusionKey => $inclusion) { ?>
                                                        <div class="col-md-12 tts-itinerary-row">
                                                            <div class="row align-items-center">
                                                                <div class="col-md-1 text-center">
                                                                    <div class="form-group form-mb-20">
                                                                        <div class="bg-dark w-100 text-white rounded-4 p-2 count text_wrap" get-text=""><?php echo ($inclusionKey + 1); ?></div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-10">
                                                                    <div class="form-group form-mb-20">
                                                                        <input class="form-control" type="text" name="inclusions[]" value="<?php echo $inclusion;  ?>" placeholder="Inclusions">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-1">
                                                                    <div class="form-group form-mb-20">
                                                                        <span class="action fa fa-close" onclick="remove_more_items_visa(this,'visa-inclusion-html')"></span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                <?php  }
                                                } ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="tts-important-information">
                                        <div class="col-12">
                                            <div class="d-flex align-items-center justify-content-between mb-2">
                                                <h5>Important Information</h5>
                                                <button class="badge badge-wt" onclick="add_more_items(event,'visa-information-html',15)">
                                                    <i class="fa-solid fa-add"></i> Add Important Information
                                                </button>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="row" id="visa-information-html">
                                                <?php $important_information =  explode(",", $details['important_information']); ?>
                                                <?php if (!empty($important_information) && is_array($important_information)) {
                                                    foreach ($important_information as $informationKey => $information) { ?>
                                                        <div class="col-md-12 tts-itinerary-row">
                                                            <div class="row align-items-center">
                                                                <div class="col-md-1 text-center">
                                                                    <div class="form-group form-mb-20">
                                                                        <div class="bg-dark w-100 text-white rounded-4 p-2 count text_wrap" get-text=""><?php echo ($informationKey + 1); ?></div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-10">
                                                                    <div class="form-group form-mb-20">
                                                                        <input class="form-control" type="text" name="important_information[]" value="<?php echo $information;  ?>" placeholder="Important Information">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-1">
                                                                    <div class="form-group form-mb-20">
                                                                        <span class="action fa fa-close" onclick="remove_more_items_information(this,'visa-information-html')"></span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                <?php  }
                                                } ?>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label>Meta Robots *</label>
                                    <select class="form-select" name="meta_robots" placeholder="Meta Robots">
                                        <option value="INDEX, FOLLOW" <?php if ($details['meta_robots'] == "INDEX, FOLLOW") {
                                                                            echo "selected";
                                                                        } ?>>INDEX, FOLLOW
                                        </option>
                                        <option value="NOINDEX, FOLLOW" <?php if ($details['meta_robots'] == "NOINDEX, FOLLOW") {
                                                                            echo "selected";
                                                                        } ?>>NOINDEX, FOLLOW
                                        </option>
                                        <option value="INDEX, NOFOLLOW" <?php if ($details['meta_robots'] == "INDEX, NOFOLLOW") {
                                                                            echo "selected";
                                                                        } ?>>INDEX, NOFOLLOW
                                        </option>
                                        <option value="NOINDEX, NOFOLLOW" <?php if ($details['meta_robots'] == "NOINDEX, NOFOLLOW") {
                                                                                echo "selected";
                                                                            } ?>>NOINDEX, NOFOLLOW
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label> Meta Title * </label>
                                    <input class="form-control" type="text" name="meta_title" placeholder="Meta Title" value="<?php echo $details['meta_title']; ?>">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label> Meta Keyword* </label>
                                    <textarea class="form-control" type="text" name="meta_keyword" placeholder="Meta Keyword" rows="2"><?php echo $details['meta_keyword']; ?></textarea>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label> Meta Description* </label>
                                    <textarea class="form-control" type="text" name="meta_description" placeholder="Meta Description" rows="2"><?php echo $details['meta_description']; ?></textarea>
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