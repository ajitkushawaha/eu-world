<?php
$country_codes = get_countary_code();
?>

    <div class="modal-header">
        <h5 class="modal-title">Add Visa Country</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> 
      </div>


    <form action="<?php echo site_url('visa/add-visa-country'); ?>" method="post" tts-form="true" name="add_visa_country" enctype="multipart/form-data">

        <div class="modal-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group form-mb-20">
                        <label>Country Name *</label>
                        <select class="form-control tts_select_search" name="country_name">
                            <option value="" selected="selected">Select Visa Country </option>
                            <?php if ($country_codes) {
                                foreach ($country_codes as $country_code) { ?>
                                    <option value="<?php echo $country_code['countryname'].'-'.$country_code['countrycode'] ?>">
                                        <?php echo $country_code['countryname']; ?>
                                    </option>
                                <?php }
                            } ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group form-mb-20">
                        <label>  Image * </label>
                        <input class="form-control" type="file" name="country_image" placeholder=" Image">
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group form-mb-20">
                        <label>Processing Time *</label>
                        <input class="form-control" type="text" name="processing_time" placeholder="Processing Time" >
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group form-mb-20">
                        <label>Starting Price (Per Person) *</label>
                        <input class="form-control" type="text" name="starting_price" placeholder="Starting Price" >
                    </div>
                </div>

                <div class="col-md-4">
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

    
