<div class="modal-header">
    <h5 class="modal-title" >Edit <?php echo 'Visa Markup '; ?></h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>

   <form action="<?php echo site_url('visa/edit-admin-visa-markup/') . dev_encode($id); ?>" method="post" tts-form="true"
      name="edit_visa_markup">
      <div class="modal-body">
         <div class="row">
         <div class="col-md-4">
            <div class="form-group">
               <label>Markup For *</label>
               <select class="form-select" name="markup_for" tts-markup-used-for="true">
               <option value="">Please Select</option>
                     <?php $markup_used_for = get_active_whitelable_business();
                     foreach ($markup_used_for as $key => $data) {  ?>
                        <option value="<?php echo $key ?>" <?php if($key == $details['markup_for']){ echo "selected";} ?>><?php echo $key ?></option>
                     <?php } ?>
               </select>
            </div>
         </div>   
       
         <div class="col-md-4 <?php echo ($details['markup_for'] == 'B2B') ? '' : 'd-none'; ?>" tts-agent-class="true">
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
                  <label>Select Visa Country *</label>
                  <select class="form-select tts_select_search" tts-method-name="visa/get-visa-list-select" name="visa_country_id" tts-call-select="true">
                     <option value="" selected>Select Visa Country</option>
                     <?php if ($country) {
                        foreach ($country as $country_code) { ?>
                     <option value="<?php echo $country_code['CountryId'] ?>"
                        <?php if ( $country_code['CountryId'] == $details['visa_country_id']) {  echo "Selected";  } ?>>
                        <?php echo $country_code['CountryName']; ?>
                     </option>
                     <?php }
                        } ?>
                  </select>
               </div>
            </div>
            <div class="col-md-4">
               <div class="form-group form-mb-20">
                  <label>Select Visa Type*</label>
                  <select class="form-select select_search" name="visa_type_id[]" tts-call-put-html="true" multiple="multiple"> 
                     <?php
                        if ($visa_list){
                        
                        foreach ($visa_list as  $item){ ?>
                     <option value=<?php echo $item['id']?> <?php if (in_array($item['id'], $details['visa_type_id'])) {echo "selected";} ?>><?php echo $item['visa_title']?></option>
                     <?php }
                        } 
                        ?>
                  </select>
               </div>
            </div>
            <div class="col-md-4">
               <div class="form-group form-mb-20">
                  <label>Display Markup *</label>
                  <select class="form-select" name="display_markup" placeholder="Display Markup">
                     <option value="in_tax" <?php if ($details['display_markup'] == "in_tax") {
                        echo "selected";
                        
                        } ?>>In Tax</option>
                     <option value="in_service_charge" <?php if ($details['display_markup'] == "in_service_charge") {
                        echo "selected";
                        
                        } ?> >In Service Charge</option>
                  </select>
               </div>
            </div>
            <div class="col-md-4">
               <div class="form-group form-mb-20">
                  <label>Markup Type *</label>
                  <select class="form-select" name="markup_type" placeholder="Markup Type">
                     <option value="fixed" <?php if ($details['markup_type'] == "fixed") {
                        echo "selected";
                        
                        } ?>>Fixed</option>
                     <option value="percent" <?php if ($details['markup_type'] == "percent") {
                        echo "selected";
                        
                        } ?> >Percent</option>
                  </select>
               </div>
            </div>
            <div class="col-md-4">
               <div class="form-group form-mb-20">
                  <label>Value *</label>
                  <input class="form-control" type="text" value="<?php echo $details['value'];?>" name="value" placeholder="Value">
               </div>
            </div>
            <div class="col-md-4">
               <div class="form-group form-mb-20">
                  <label>Max Limit </label>
                  <input class="form-control" type="text" value="<?php echo $details['max_limit'];?>" name="max_limit" placeholder="Max Limit">
               </div>
            </div>
            <div class="col-md-4">
               <div class="form-group form-mb-20">
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
         </div>
      </div>
      <div class="modal-footer">
         <button class="btn btn-primary" type="submit">Save</button>
      </div>
   </form>
