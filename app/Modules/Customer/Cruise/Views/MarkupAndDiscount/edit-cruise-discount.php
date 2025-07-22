<div class="modal-header">
    <h5 class="modal-title">Add <?php echo 'Cruise Discount '; ?></h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

</div>



    <form action="<?php echo site_url('cruise/edit-cruise-discount/'.dev_encode($id)); ?>" method="post" tts-form="true"
          name="add_cruise_discount">

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
                                <option value="<?php echo $key ?>" <?=($key == $details['discount_for'])?'selected':''?>><?php echo $key ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-4 <?php echo ($details['discount_for'] == 'B2B') ? '' : 'd-none'; ?>" tts-agent-class="true">
                    <div class="form-group">
                    <label>Agent Class *</label>
                    <select class="form-select select_search" name="agent_class[]" placeholder="Flight Type" multiple="multiple">
                        
                            <?php  foreach ($agent_class_list as $key => $data) {  ?>  
                                <option value="<?php echo $data['id'] ?>" <?php if(in_array($data['id'], $details['agent_class'])){ echo "selected";} ?> ><?php echo $data['class_name'] ?></option>
                            <?php } ?>
                    </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group form-mb-20">
                        <label>Select Cruise Departure Port *</label>
                        <select class="form-select select_search" name="departure_port_id">
                            <option value=""  <?=("" == $details['departure_port_id'])?'selected':''?>>Select Departure Port</option>
                            <option value="ANY" <?=('ANY' == $details['departure_port_id'])?'selected':''?>>ANY Departure Port</option>
                            <?php if ($cruise_port) {
                                foreach ($cruise_port as $data) { ?>
                                    <option value="<?php echo $data['id'] ?>" <?=($data['id'] == $details['departure_port_id'])?'selected':''?>>
                                        <?php echo ucfirst($data['port_name']); ?>
                                    </option>
                                <?php }
                            } ?>
                        </select>
                    </div>
                </div>
              
                <div class="col-md-4">
                    <div class="form-group form-mb-20">
                        <label>Select Cruise Line *</label>
                        <select class="form-select select_search" tts-method-name="cruise/get-cruise-ship-id-select" name="cruise_line_id" tts-call-select="true">
                            <option value="" <?=("" == $details['cruise_line_id'])?'selected':''?>>Select Cruise Line</option>
                            <option value="ANY" <?=('ANY' == $details['cruise_line_id'])?'selected':''?>>ANY Cruise Line</option>
                            <?php if ($cruise_line) {
                                foreach ($cruise_line as $data) { ?>
                                    <option value="<?php echo $data['id'] ?>" <?=($data['id'] == $details['cruise_line_id'])?'selected':''?>>
                                        <?php echo $data['cruise_line_name']; ?>
                                    </option>
                                <?php }
                            } ?>
                        </select>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="form-group form-mb-20">
                        <label>Select Cruise Ship *</label>
                        <select class="form-select select_search" name="cruise_ship_id" tts-call-put-html="true" tts-method-name="cruise/get-cruise-cabin-id-select" tts-call-select="true">
                            <option value="" <?=("" == $details['cruise_ship_id'])?'selected':''?>>Select Cruise Ship</option>
                            <option value="ANY" <?=("ANY" == $details['cruise_ship_id'])?'selected':''?>>ANY Cruise Ship</option>
                            <?php if ($cruise_ship) {
                                foreach ($cruise_ship as $data) { ?>
                                    <option value="<?php echo $data['id'] ?>" <?=($data['id'] == $details['cruise_ship_id'])?'selected':''?>>
                                        <?php echo $data['ship_name']; ?>
                                    </option>
                                <?php }
                            } ?>
                        </select>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="form-group form-mb-20">
                        <label>Select Cruise Cabin *</label>
                        <select class="form-select select_search" name="cabin_id" tts-call-cruise-cabin-put-html="true">
                            <option value="" <?=("" == $details['cabin_id'])?'selected':''?>>Select Cruise Cabin</option>
                            <option value="ANY" <?=("ANY" == $details['cabin_id'])?'selected':''?>>ANY Cruise Cabin</option>
                            <?php if ($cruise_cabin) {
                                foreach ($cruise_cabin as $data) { ?>
                                    <option value="<?php echo $data['id'] ?>" <?=($data['id'] == $details['cabin_id'])?'selected':''?>>
                                        <?php echo $data['cabin_name']; ?>
                                    </option>
                                <?php }
                            } ?>
                        </select>
                    </div>
                </div>

                

                <div class="col-md-4">
                    <div class="form-group form-mb-20">
                        <label>Discount Type *</label>
                        <select class="form-select" name="discount_type" placeholder="Markup Type">
                            <option value="fixed" <?=('fixed' == $details['discount_type'])?'selected':''?>>Fixed</option>
                            <option value="percent" <?=('percent' == $details['discount_type'])?'selected':''?>>Percent</option>
                        </select>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group form-mb-20">
                        <label>Value *</label>
                        <input class="form-control" type="text" name="value"  value="<?php echo $details['value']; ?>" placeholder="Value">
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group form-mb-20">
                        <label>Max Limit </label>
                        <input class="form-control" type="text" name="max_limit" value="<?php echo $details['max_limit']; ?>" placeholder="Max Limit">
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group form-mb-20">
                        <label>Status *</label>
                        <select class="form-select" name="status" placeholder="Status">
                            <option value="active" <?=('active' == $details['status'])?'selected':''?>>Active</option>
                            <option value="inactive" <?=('inactive' == $details['status'])?'selected':''?>> Inactive</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button class="btn btn-primary" type="submit">Save</button>
        </div>
    </form>

