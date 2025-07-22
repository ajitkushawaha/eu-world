<div class="row" passenger="<?php echo $passengerCounter; ?>">
   <div class="col-md-12 ">
      <h6 class="view_head">Traveller <?php echo $passengerCounter ?> </h6>
   </div>
   <div class="col-md-3">
      <div class="form-group form-mb-20">
         <label>Title *</label>
         <select name="pax_details[<?php echo $passengerCounter ?>][title]" class="form-select">
            <option value="" selected="">Select Title</option>
            <option value="Mr">Mr</option>
            <option value="Ms">Ms</option>
            <option value="Mrs">Mrs</option>
            <option value="Ms">Ms</option>
            <option value="Mstr">Mstr</option>
         </select>
      </div>
   </div>
   <div class="col-md-3">
      <div class="form-group form-mb-20">
         <label>First Name *</label>
         <input class="form-control" type="text" name="pax_details[<?php echo $passengerCounter ?>][first_name]" placeholder="First Name">
      </div>
   </div>
   <div class="col-md-3">
      <div class="form-group form-mb-20">
         <label>Last Name *</label>
         <input class="form-control" type="text" name="pax_details[<?php echo $passengerCounter ?>][last_name]" placeholder="Last Name">
      </div>
   </div>
   <div class="col-md-3">
      <div class="form-group form-mb-20">
         <label>Date of Birth *</label>
         <input class="form-control" type="text" name="pax_details[<?php echo $passengerCounter ?>][dob]" placeholder="Date of Birth" dob-calendor="true" readonly="">
      </div>
   </div>
   <div class="col-md-3">
      <div class="form-group form-mb-20">
         <label>Gender *</label>
         <select name="pax_details[<?php echo $passengerCounter ?>][gender]" class="form-select">
            <option value="" selected="">Select Gender</option>
            <option value="Male">Male</option>
            <option value="Female">Female</option>
            <option value="Other">Other</option>
         </select>
      </div>
   </div>
   <?php if(isset($document) && !empty($document)) :  ?>
    <?php foreach ($document as $documents) : ?>
    <div class="col-md-3">
        <div class="form-group form-mb-20">
            <?php
               $label = str_replace("_", " ", $documents); // Replace underscore with space
               $label = ucwords($label);  // Capitalize the first letter of each word
            ?>
            <label><?php echo $label ?> *</label>
            <input class="form-control" type="file" name="pax_details[<?php echo $passengerCounter ?>][<?php echo $documents ?>]" placeholder="file">
            <input class="form-control" type="hidden" name="pax_details[<?php echo $passengerCounter ?>][document][<?php echo $documents; ?>]">
        </div>
    </div>
    <?php endforeach; ?>  

    <?php endif; ?>

        

</div>