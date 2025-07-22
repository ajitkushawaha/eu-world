<?php
if ($Visa_details['Error']['ErrorCode'] == 0) {
	$details = $Visa_details['Result'];

	if(isset($details['PriceBreakup']['WebPMarkUp']) && $details['PriceBreakup']['WebPMarkUp']['DisplayFormat'] == 'in_tax'){
		$details['PriceBreakup']['PublishedPrice'] += $details['PriceBreakup']['WebPMarkUp']['value'];
		$details['PriceBreakup']['Tax'] += $details['PriceBreakup']['WebPMarkUp']['value'];
	}
	
	if(isset($details['PriceBreakup']['WebPMarkUp']) && $details['PriceBreakup']['WebPMarkUp']['DisplayFormat']  == 'in_service_charge'){
		$details['PriceBreakup']['PublishedPrice'] += $details['PriceBreakup']['WebPMarkUp']['value'];
		$details['PriceBreakup']['ServiceCharges'] += $details['PriceBreakup']['WebPMarkUp']['value'];
	}

	?>
	<div class="flightDetailWrapper">
		<div class="container">

			<div class="row">
				<?php echo view('Modules/Visa/Views\booking\modify-search.php'); ?>
				<div class="col-lg-9 col-md-12 col-12">
					<div class="flightLeftWrapper">
						<div class="flightHeadWrap d-flex align-items-center">
							<p>Review Your Visa Details</p>
						</div>

						<div class="flightBookDetail">
							<div class="flightPoint">
								<div class="row align-items-center">
									<div class="col-lg-8 col-md-8 col-12">
										<h4>
											<span><?php echo $details['CountryName'] ?></span>
										</h4>
									</div>
									<div class="col-lg-4 col-md-4 col-12 d-flex">
										<p class="partialRef">
											<?php echo $details['VisaType'] ?>
										</p>
									</div>
								</div>
							</div>

							<div class="flightTypeDetail">
								<?php echo $details['VisaDetail'] ?>
							</div>

							<div class="flightVaccineDet">
								<p>
									<span class="vaccineInfo">Info</span><i class=""><?php echo $details['ProcessingTime'] ?></i>
								</p>
							</div>
						</div>


						<form action="<?php echo site_url('visa/validate-travellers'); ?>" method="post" tts-form="true" name="visa_booking" enctype="multipart/form-data">
							<div class="flightRefundableWrapper mt-4">
								<h6>Document Details</h6>
								<div class="flightRefundContent">
									<div class="flightCovidSafe">
										<img src="<?php echo site_url('webroot/img/svg_icon') ?>/flight-detail-shield.svg" class="flightShield" alt=""/>
										<p>
											Covid-19 Infection & Isolation
											<!--<a href="javascript:void(0);">- See Details </a>-->
										</p>
									</div>

									<div class="flightTerms mt-3">
										<p>
											<?php echo $details['VisaDocument'] ?>
										</p>
									</div>
								</div>
							</div>
							<div class="flightTraveller mt-4 mb-4">
								<p>Traveller Details</p>

								<div class="flightTravellerDetail">
									<p>
										Please make sure you enter the Name as per your Government photo id. </p>
									<input type="hidden" name="DateOfJourney" value="<?php echo dev_encode($Visa_details['search_data']['travel_date']); ?>">
									<input type="hidden" name="SearchTokenId" value="<?php echo $Visa_details['SearchTokenId']; ?>">
									<input type="hidden" name="ResultIndex" value="<?php echo $Visa_details['Result']['ResultIndex']; ?>">
									<?php for ($i = 0; $i <= $Visa_details['search_data']['NoOfTravellers'] - 1; $i++) { ?>
										<div class="pax-repeat-div my-3">
											<div class="card">
												<div class="card-header card_header">
													<span class="title ps-0">Travellers <?php echo $i + 1; ?> </span>
												</div>

												<div class="card-body">
													<div class="row">
														<div class="col-lg-2 col-md-2 col-12">
															<select class="form-select form-control" name="pax[<?php echo $i; ?>][Title]" data-validation="required" data-validation-error-msg="Title is required">
																<option value="Mr" selected="">Mr.</option>
																<option value="Ms">Ms.</option>
																<option value="Mrs">Mrs.</option>
															</select>
														</div>
														<div class="col-lg-3 col-md-3 col-12">
															<input type="text" class="form-control" placeholder="First Name" name="pax[<?php echo $i; ?>][FirstName]" data-validation="required alphanumeric" data-validation-error-msg-required="First Name is required" data-validation-error-msg-alphanumeric="Please enter a valid First Name">
														</div>
														<div class="col-lg-3 col-md-3 col-12">
															<input type="text" class="form-control" placeholder="Last Name" name="pax[<?php echo $i; ?>][LastName]" data-validation="required alphanumeric" data-validation-error-msg-required="Last Name is required" data-validation-error-msg-alphanumeric="Please enter a valid Last Name">
														</div>
														<div class="col-lg-2 col-md-3 col-12">
															<input type="text" class="form-control" placeholder="Date Of Birth" dob-calendor="true" name="pax[<?php echo $i; ?>][DOB]" data-validation="required" data-validation-error-msg="DOB is required" readonly>
														</div>
														<div class="col-lg-2 col-md-2 col-12">

															<select class="form-select form-control" name="pax[<?php echo $i; ?>][Gender]" data-validation="required" data-validation-error-msg="Gender is required">
																<option value="male" selected="">Male</option>
																<option value="female">Female</option>
															</select>

														</div>
													<?php $panRequire = 0; $passportRequire =0; $aadharRequire= 0; ?>
													<?php foreach($details['DocumentType'] as $key => $value): ?>
													<input type="hidden" name="<?=$key?>" value="<?php echo $value; ?>">
													<input type="hidden" name="requireDoc[]" value="<?php echo $key; ?>">
											        
													<?php if ($value) { ?>
															<?php if ($value == 1) { ?>
																<div class="col-lg-6 col-md-6 col-12 mt-2">
																	<div class="mb-3">
																		<label for="<?=$key?>" class="form-label"><?=str_replace('_',' ',ucwords($key))?></label>
																		<input class="form-control" name="pax[<?php echo $i; ?>][<?=$key?>]" type="file" id="<?=$key?>">
																	</div>
																</div>
															<?php } ?>
													<?php } ?>

													<?php endforeach; ?>
													</div>
												</div>
											</div>
										</div>
									<?php } ?>
								</div>
							</div>


							<div class="flightTravellerContact mb-4">
								<p>Contact Details</p>
								<div class="flightContactMail">
									<div class="mailHead">
										<img class="flightContactImg" src="<?php echo site_url('webroot/img/svg_icon') ?>/flight-detail-mail.svg" alt="mail"/>
										<p>Your ticket and bus information will be sent here.</p>
									</div>
									<div class="row mt-3">

										<div class="col-lg-2 col-md-4 col-12 mb-2">
											<select class="form-select form-control select_search" name="dial_code" data-validation="required" data-validation-error-msg="Dial Code is required">
												<option value="">Dial Code</option>
												<?php if ($dial_code) {
													foreach ($dial_code as $code) { ?>
														<option value="<?php echo $code['phonecode']; ?>" <?php if ($code['phonecode'] == 91) {
															echo "selected";
														} ?>><?php echo $code['name']; ?>
															( <?php echo $code['phonecode']; ?>)
														</option>
													<?php }
												} ?>

											</select>
										</div>

										<div class="col-lg-4 col-md-4 col-12 mb-2">
											<input type="text" class="form-control" name="mobile_number" placeholder="Mobile Number" data-validation="required number length" data-validation-length="7-15" value="<?php echo $web_partner_details['mobile_no'] ?>" data-validation-error-msg-required="Please enter Mobile Number" data-validation-error-msg-number="Please enter a valid Mobile Number" data-validation-error-msg-length="Please enter 7-15 digit mobile number."/>
										</div>
										<div class="col-lg-4 col-md-4 col-12">
											<input type="text" class="form-control" name="email" placeholder="Email" data-validation="required email" value="<?php echo $web_partner_details['login_email'] ?>" data-validation-error-msg-required="Please enter Email" data-validation-error-msg-email="Please enter a valid Email"/>
										</div>
									</div>
								</div>

								<div class="flightGstNumber mt-4 mb-2">
									<h6>
										Use GSTIN for this booking(Optional)
										<button class="btn btn-outline-danger float-end" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-bus-gst" aria-expanded="false" aria-controls="collapse-bus-gst" onclick="gst_detail(this,'add_gst_detail')">ADD
										</button>
									</h6>
									<span>Claim credit of GST charges. Your taxes may get updated post submitting your GST details.</span>
									<div class="collapse" id="collapse-bus-gst">
										<div class="card card-body">
											<div class="row mt-3">
												<input type="hidden" name="add_gst_detail" id="add_gst_detail" value="false">
												<div class="col-lg-4 col-md-4 col-12 mb-3">
													<input type="text" class="form-control" name="gst[number]" placeholder="GST Number" data-validation="required alphanumeric" data-validation-error-msg-required="Please enter GST Number" data-validation-error-msg-alphanumeric="Please enter a valid GST Number">
												</div>
												<div class="col-lg-4 col-md-4 col-12">
													<input type="text" class="form-control" name="gst[name]" placeholder="Registered Company Name" data-validation="required" data-validation-error-msg-required="Please enter Company Name"/>
												</div>
												<div class="col-lg-4 col-md-4 col-12">
													<input type="text" class="form-control" name="gst[phone]" placeholder="Registered Contact No" data-validation="required number" data-validation-length="7-15"

															data-validation-error-msg-required="Please enter Contact No" data-validation-error-msg-number="Please enter a valid Contact No" data-validation-error-msg-length="Please enter 7-15 digit mobile number."/>
												</div>
												<div class="col-lg-4 col-md-4 col-12">
													<input type="text" class="form-control" name="gst[email]" placeholder="Registered Email" data-validation="required email" data-validation-error-msg-required="Please enter Email" data-validation-error-msg-email="Please enter a valid Email"/>
												</div>
												<div class="col-lg-4 col-md-4 col-12">
													<input type="text" class="form-control" name="gst[address]" placeholder="Registered Address" data-validation="required" data-validation-error-msg-required="Please enter Address"/>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="continuePayment mb-4">
								<button type="submit" class="btn btn-link">Continue Payment</button>
							</div>
						</form>
					</div>
				</div>
				<div class="col-lg-3 col-md-12 col-12">
					<div class="flightRightWrapper">
						<p class="flightFare">Fare Summary</p>
						<div class="flightFareTypes">
							<div id="accordion">
								<div class="card card1">
									<div class="card-header card_header">
										<div class="row">
											<div class="col-md-12 d-flex align-items-center justify-content-between">
												<ul>
													<li>Published Price</li>
												</ul>
												<ul>
													<li>₹ <?php  echo $details['PriceBreakup']['PublishedPrice']; ?></li>
												</ul>
											</div>
										</div>
									</div>
									<div class="card-header card_header">
										<div class="row">
											<div class="col-md-12 d-flex align-items-center justify-content-between">
												<ul>
													<li>Offered Price</li>
												</ul>
												<ul>
													<li>₹ <?php echo $details['PriceBreakup']['OfferedPrice']; ?></li>
												</ul>
											</div>
										</div>
									</div>

									<div class="card-header card_header">
										<div class="row">
											<div class="col-md-12 d-flex align-items-center justify-content-between">
												<ul>
													<li>TDS (+)</li>
												</ul>
												<ul>
													<li>₹ <?php echo $details['PriceBreakup']['TDS']; ?></li>
												</ul>
											</div>
										</div>
									</div>
									<div class="card-header card_header">
										<div class="row">
											<div class="col-md-12 d-flex align-items-center justify-content-between">
												<ul>
													<li><strong>Total Amount</strong></li>
												</ul>
												<ul>
													<li>
														<span><strong>₹ <?php echo $details['PriceBreakup']['OfferedPrice'] + $details['PriceBreakup']['TDS']; ?></strong></span>
													</li>
												</ul>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

		</div>
	</div>
<?php } else { ?>
	<div class=" py-3">
		<div class="container">
			<div class="row">
				<div class="col-12 tts-api-error-msg">
					<img src="<?php echo site_url('webroot/img/generic-error.png'); ?>"  class="img-fluid">
					<h5 class="mt-4"><?php echo $Visa_details['Error']['ErrorMessage'] ?></h5>
					<p class="mb-2">No visa service available for the given country. Please change your search criteria</p>
					<a href="<?php echo site_url('visa'); ?>" class="btn btn-outline-danger">SEARCH AGAIN</a>
				</div>
			</div>
		</div>
	</div>
<?php } ?>
<script>
	function net_fare_toggle(data) {
		if (data.checked) {
			$('.ppk-net-fare').show();
		} else {
			$('.ppk-net-fare').hide();
		}
	}
</script>