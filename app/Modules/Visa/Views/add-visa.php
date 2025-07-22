
<div class="modal-header">
        <h5 class="modal-title">Add Visa</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

    <form action="<?php echo site_url('visa/add-visa'); ?>" method="post" tts-form="true" name="add_visa_country" enctype="multipart/form-data">

        <div class="modal-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group form-mb-20">
                        <label>Country Name *</label>
                        <select class="form-control tts_select_search" name="visa_country_id">
                            <option value="" selected="selected">Select Visa Country </option>
                            <?php if ($country) {
                                foreach ($country as $country_code) { ?>
                                    <option value="<?php echo $country_code['id'] ?>">
                                        <?php echo $country_code['country_name']; ?>
                                    </option>
                                <?php }
                            } ?>
                        </select>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group form-mb-20">
                        <label>Select Visa Type *</label>
                        <select class="form-control tts_select_search" name="visa_type_id">
                            <option value="" selected="selected">Select Visa Type</option>
                            <?php if ($visa_type) {
                                foreach ($visa_type as $data) { ?>
                                    <option value="<?php echo $data['id'] ?>">
                                        <?php echo $data['visa_title']; ?>
                                    </option>
                                <?php }
                            } ?>
                        </select>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group form-mb-20">
                        <label>Status *</label>
                        <select class="form-control" name="status" placeholder="Status"> 
                            <option value="active" selected>Active</option>
                            <option value="inactive"> Inactive</option>
                        </select>
                    </div>
                </div>


            </div>
        </div>
        <div class="modal-footer">
             <button class="btn btn-primary" type="submit">Save</button>
        </div>
    </form>

    
