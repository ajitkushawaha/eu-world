<div class="content">
    <div class="page-content">
        <div class="page-content-area">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <p> <b>Bussiness Type :</b> <?php echo ucfirst($getVisaInfo['bussiness_type']); ?> </p>
                        </div>
                        <div class="col-md-3">
                            <p> <b>Destinations :</b> <?php echo ucfirst($getVisaInfo['destinations']); ?></p>
                        </div>

                        <div class="col-md-3">
                            <p><b>Visa Type :</b> <?php echo ucfirst($getVisaInfo['visa_type']); ?> </p>
                        </div>
                        <div class="col-md-3">
                            <p> <b>Travel Date :</b> <?php echo $getVisaInfo['travel_date']; ?> </p>
                        </div>
                    </div>

                    <form name="visa-upload" tts-form="true" action="<?php echo site_url('visa-upload/traveller-pax-details') ?>" method="POST" id="visa-upload" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="view_head">
                                    <div class="row align-items-center">
                                        <div class="col-md-2">
                                            <span>Passenger Details </span>
                                        </div>
                                        <div class="col-md-10 text-end">
                                            <button type="button" class="badge badge-wt" visa-upload-add-passenger-abhay="true" tts-visa-passenger-method-name="visa-upload/passenger-details" passenger-counter="<?php echo $passengerCounter ?>"><i class="fa-solid fa-add "></i> Add Passenger
                                            </button>
                                            <button class="badge badge-wt" type="button" visa-upload-remove-passenger-abhay="true"><i class="fa fa-trash"></i> Remove</button>
                                            </i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php $country_code = get_countary_code();  ?>
                            <div class="col-md-3">
                                <div class="form-group form-mb-20">
                                    <label>Dial code *</label>
                                    <select name="dial_code" class="form-select">
                                        <?php foreach ($country_code as $country_codes) {
                                            if ($country_codes['dialcode'] == 91) {
                                                echo "<option value=" . $country_codes['dialcode']  . " selected>" . $country_codes['countryname'] . "  (" . $country_codes['dialcode'] . " )</option>";
                                            } else {
                                                echo "<option value=" . $country_codes['dialcode'] . ">" . $country_codes['countryname'] . "(" . $country_codes['dialcode'] . " )</option>";
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group form-mb-20">
                                    <label>Phone Numner *</label>
                                    <input class="form-control" type="number" name="mobile_number" placeholder="Phone Numner">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group form-mb-20">
                                    <label>Email Address *</label>
                                    <input class="form-control" type="text" name="email" placeholder="Email Address">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 ">
                                <h6 class="view_head">Traveller 1</h6>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group form-mb-20">
                                    <label>Title *</label>
                                    <select name="pax_details[1][title]" class="form-select">
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
                                    <input class="form-control" type="text" name="pax_details[1][first_name]" placeholder="First Name">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group form-mb-20">
                                    <label>Last Name *</label>
                                    <input class="form-control" type="text" name="pax_details[1][last_name]" placeholder="Last Name">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group form-mb-20">
                                    <label>Date of Birth *</label>
                                    <input class="form-control" type="text" name="pax_details[1][dob]" placeholder="Date of Birth" dob-calendor="true" readonly>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group form-mb-20">
                                    <label>Gender *</label>
                                    <select name="pax_details[1][gender]" class="form-select">
                                        <option value="" selected="">Select Gender</option>
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                        <option value="Other">Other</option>
                                    </select>
                                </div>
                            </div>
                            <?php if (isset($getVisaInfo['document'])) : ?>
                                <?php foreach ($getVisaInfo['document'] as $document) : 
                                        ?>
                                    <div class="col-md-3">
                                        <div class="form-group form-mb-20">
                                            <?php
                                             $label = str_replace("_", " ", $document); // Replace underscore with space
                                            $label = ucwords($label);  // Capitalize the first letter of each word
                                            ?>
                                            <label><?php echo $label ?> *</label>
                                            <input class="form-control" type="file" name="pax_details[1][<?php echo $document; ?>]" placeholder="file" id="<?php echo $document; ?>">
                                            <input class="form-control" type="hidden" name="pax_details[1][document][<?php echo $document; ?>]">
                                        </div>
                                    </div>
                                <?php endforeach;  ?> 
                                 

                            <?php endif; ?>
                            
                           
                            <input type="hidden" name="visainfokey" value="<?php echo $visainfokey; ?>">
                        </div>
                       
                        <div class="row"  tts-call-put-passenger-html="true">
                            <?php //echo  $passengerDetailinfoView; 
                            ?>
                       
                        </div>
                       
                        <div class="row">
                            <div class="col-md-6">
                                <a class="btn btn-primary" href="<?php echo site_url('visa-upload?visainfokey=' . $visainfokey) ?>"> Previous</a>
                            </div>
                            <div class="col-md-6 text-md-end">
                                <input class="btn btn-primary" type="submit" value="Review Details">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>