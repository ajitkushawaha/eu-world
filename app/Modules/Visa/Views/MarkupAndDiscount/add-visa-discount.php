<div class="modal-header">
    <h5 class="modal-title">Add <?php echo 'Visa Discount '; ?></h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<form action="<?php echo site_url('visa/add-visa-discount'); ?>" method="post" tts-form="true" name="add_visa_markup">
    <div class="modal-body">
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label>Markup For *</label>
                    <select class="form-select" name="discount_for" tts-markup-used-for="true">
                        <option value="">Please Select</option>
                        <?php $markup_used_for = get_active_whitelable_business();
                        foreach ($markup_used_for as $key => $data) {
                        ?>
                            <option value="<?php echo $key ?>"><?php echo $key ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>


            <div class="col-md-4 d-none" tts-agent-class="true">
                <div class="form-group">
                    <label>Agent Class *</label>
                    <select class="form-select select_search" name="agent_class[]" placeholder="Flight Type" multiple="multiple">

                        <?php foreach ($agent_class as $key => $data) {  ?>
                            <option value="<?php echo $data['id'] ?>"><?php echo $data['class_name'] ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group form-mb-20">
                    <label>Select Visa Country *</label>
                    <select class="form-select tts_select_search" tts-method-name="visa/get-visa-list-select-markup" name="visa_country_id" tts-call-select="true">
                        <option value="" selected>Select Visa Country</option>
                        <?php if ($country) {
                            foreach ($country as $data) { ?>
                                <option value="<?php echo $data['CountryId'] ?>">
                                    <?php echo $data['CountryName']; ?>
                                </option>
                        <?php }
                        } ?>
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group form-mb-20">
                    <label>Select Visa Type*</label>
                    <select class="form-control select_search" name="visa_type_id[]" tts-call-put-html="true" multiple="multiple">

                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group form-mb-20">
                    <label>Discount Type *</label>
                    <select class="form-select" name="discount_type" placeholder="Discount Type">
                        <option value="fixed" selected>Fixed</option>
                        <option value="percent">Percent</option>
                    </select>
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group form-mb-20">
                    <label>Value *</label>
                    <input class="form-control" type="text" name="value" placeholder="Value">
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group form-mb-20">
                    <label>Extra Discount </label>
                    <input class="form-control" type="text" name="extra_discount" value="0" placeholder="Extra Discount">
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group form-mb-20">
                    <label>Max Limit </label>
                    <input class="form-control" type="text" name="max_limit" placeholder="Max Limit">
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group form-mb-20">
                    <label>Status *</label>
                    <select class="form-select" name="status" placeholder="Status">
                        <option value="active" selected>Active</option>
                        <option value="inactive"> Inactive</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <div class="row">
            <div class="tts-col-12">
                <button class="btn btn-primary" type="submit">Save</button>
            </div>
        </div>
    </div>
</form>