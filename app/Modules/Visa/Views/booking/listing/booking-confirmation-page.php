<div class="content">
	<div class="page-content">
		<div class="travelimp__thanku">
			<div class="container-fluid p-0">
				<div class="row">
					<div class="travelimp__thanku--bookingSuccess d-flex align-items-center">
						<div class="travelimp__thanku--statuscontent">
							Booking<span class="travelimp__thanku--statussize"><?php echo $booking['bookingStatus'] ?></span>
							<p class="travelimp__thanku--bookingIdShow">
								<a href="<?php echo site_url('visa/visa-booking-details/') . $booking['bookingRefNumber'] ?>" class="travelimp__thanku--redirectid">Booking Ref Number : <?php echo $booking['bookingRefNumber'] ?></a>
							</p>
						</div>
					</div>
				</div>
			</div>
		</div>

		<section class="flight-confirmation" ng-app="holidayDetailApp" ng-controller="holidayDetailCtrl">
			<div class="container-fluid p-0">
				<div class="row">
					<div class="col-md-9">
						<div class="travelimp__thanku--leftside">
							<div class="travelimp__thanku--panelHeadwrap">
								<div class="travelimp__thanku--flightFlex">
									<div class="travelimp__thanku--flightFlex">
										<div class="travelimp__thanku--panelHeading travelimp__thanku--panelHeading-positionHandle"><?php echo $booking['visa_country'] ?>
											<span class="travelimp__thanku--tripdate travelimp__thanku--tripdate-positionHandle"> <?php echo  date("d M Y", $booking['ConfirmationBookingData']['date_of_journey']); ?></span>
										</div>
									</div>
								</div>
								<div class="travelimp__thanku--tripdate travelimp__thanku--tripdate-positionHandle"> <?php echo $booking['visa_type'] ?></div>
								<div class="travelimp__thanku--tripdate travelimp__thanku--tripdate-positionHandle"> <?php echo $booking['ConfirmationBookingData']['processing_time'] ?></div>
							</div>
							<div class="travelimp__thanku--panelHeadwrap">
								<div class="travelimp__thanku--flightFlex">
									<div class="travelimp__thanku--flightFlex">
										<div class="travelimp__thanku--panelHeading travelimp__thanku--panelHeading-positionHandle">Visa Detail
										</div>
									</div>
								</div>
								<div class="travelimp__thanku--tripdate mb-2 travelimp__thanku--tripdate-positionHandle"> <?php echo $booking['ConfirmationBookingData']['visa_detail'] ?></div>
							</div>
							<div class="travelimp__thanku--panelHeadwrap">
								<div class="travelimp__thanku--flightFlex">
									<div class="travelimp__thanku--flightFlex">
										<div class="travelimp__thanku--panelHeading travelimp__thanku--panelHeading-positionHandle">Visa Document
										</div>
									</div>
								</div>
								<div class="travelimp__thanku--tripdate mb-2 travelimp__thanku--tripdate-positionHandle"> <?php echo $booking['ConfirmationBookingData']['visa_document'] ?></div>
							</div>
							<div class="col-md-12 travelimp__thanku--panelHeadwrap">
								<div class="travelimp__thanku--panelHeading">Passenger Details</div>
								<div class="travelimp__thanku--panelbody">
									<div class="table-responsive travelimp__thanku--responsivewrap">
										<table class="table table-bordered travelimp__thanku--tablewrap">
											<thead>
												<tr>
													<th>Sr.</th>
													<th>Name</th>
													<th>DOB</th>
													<th>Document</th>

												</tr>
											</thead>
											<tbody>
												<?php if ($booking['ConfirmationBookingData']['travellers']) {

													foreach ($booking['ConfirmationBookingData']['travellers'] as $key => $traveller) {
												?>
														<tr>
															<td><?php echo $key + 1; ?></td>
															<td>
																<?php echo $traveller['title'] . ' ' . $traveller['first_name'] . ' ' . $traveller['last_name'] ?>
															</td>
															<td>
																<?php echo date("d M Y", $traveller['dob']); ?>
															</td>
															<td>
																<?php
																$document = json_decode($traveller['document'], true);
																if (!empty($document)) {
																	foreach ($document as $key => $doc) { ?>
																		<span class="item-text-value"><a href="<?php echo root_url . "uploads/visa_documents/" . $doc; ?>" target="_blank"><?php echo str_replace('_', ' ', ucwords($key)); ?></a></span>
																<?php }
																}
																?>
															</td>
														</tr>
												<?php }
												} ?>
											</tbody>
										</table>
									</div>
								</div>
							</div>
							<div class="d-none" faredetailview="true">
								<div class="col-md-12 travelimp__thanku--panelHeadwrap">
									<div class="col-md-12 travelimp__thanku--panelHeadwrap" ng-if="Farelength > 0 ">
										<div class="travelimp__thanku--panelHeading ">Fare Summary</div>
										<ul class="travelimp__thanku--fareul ">
											<li class="travelimp__thanku--fareulborder" ng-repeat="(Farekey, Fare) in FareBreakup.FareBreakup">
												<p class="travelimp__thanku--fareullist" ng-if="Farekey=='ServiceAndOtherCharge'">
													<span>{{ Fare.LabelText}}</span> <span> ₹ {{Fare.Value }}</span>
												</p>
												<p class="travelimp__thanku--fareullist" ng-if="Farekey!='ServiceAndOtherCharge'">
													<span>{{ Fare.LabelText}}</span> <span> ₹ {{Fare.Value }}</span>
												</p>
												<div class="pos-rel row m0 d-none" markup-option-OB="true" ng-if="Farekey=='ServiceAndOtherCharge'">
													<div class="row">
														<div class="col-sm-12">
															<span class="position-absolute end-0" style="cursor:pointer" ng-click="hideMarkupOption('OB')">×</span>
														</div>
														<div class="col-sm-9 ">
															<div class="floating-label">
																<label for="markupPrice_feild" class="">Markup Price</label><input type="number" class="form-control" placeholder="Markup Price" ng-model="onwardWebPartnerMarkupModal" get-markup-value-OB="true">
															</div>
															<div class="floating-label">
																<label>Discount Price</label><input type="number" class="form-control" placeholder="Discount Price" get-discount-value-OB="true" ng-model="onwardWebPartnerDiscountModal">
															</div>
														</div>
														<div class="col-sm-3">
															<button type="button" class="btn btn-sm btn-info mt-5" ng-click="getMarkupValue('OB',FareInfoOB.BookingId)">Update
															</button>
														</div>

													</div>
												</div>
											</li>
											<li class="travelimp__thanku--fareulborder">
												<p class="travelimp__thanku--fareullist">
													<span><span>{{FareBreakup.TotalAmount.LabelText}} </span></span><span>₹ {{FareBreakup.TotalAmount.Value}}</span>
												</p>
											</li>
										</ul>
									</div>
								</div>
							</div>
							<div class="col-md-12 travelimp__thanku--panelHeadwrap">
								<div class="travelimp__thanku--panelHeading ">Important Information</div>
								<ul class="travelimp__termswrap--termsul">
									<li class="travelimp__termswrap--termslist">1. You should carry a print-out of your booking and present for check-in.</li>
									<li class="travelimp__termswrap--termslist">2. Date &amp; Time is calculated based on the local time of city/destination.</li>
									<li class="travelimp__termswrap--termslist">3. Use the Reference Number for all Correspondence with us.</li>
									<li class="travelimp__termswrap--termslist">4. Use the Airline PNR for all Correspondence directly with the Airline</li>
									<li class="travelimp__termswrap--termslist">5. For departure terminal please check with airline first.</li>
									<li class="travelimp__termswrap--termslist">6. Please CheckIn atleast 2 hours prior to the departure for domestic flight and 3 hours prior to the departure of international flight.</li>
									<li class="travelimp__termswrap--termslist">7. For rescheduling/cancellation within 4 hours of departure time contact the airline directly</li>
								</ul>
							</div>
						</div>
					</div>

					<?php if ($booking['bookingStatus'] != "Processing" && $booking['bookingStatus'] != "Failed") { ?>

						<div class="col-md-3">
							<div class="travelimp__thanku--rightside">
								<ul class="travelimp__thanku--moreoptions">
									<!--   <li class="travelimp__thanku--morelist">
										<span class="travelimp__thanku--morecontent" ng-click="getTicketInvoiceModel('DownloadPdfTicket')"> Download as PDF</span>
										<span class="travelimp__thanku--moreicons fa fa-download"></span>
									</li> -->
									<li class="travelimp__thanku--morelist" ng-click="getTicketInvoiceModel('PrintTicket')">
										<span class="travelimp__thanku--morecontent">Print Ticket</span>
										<span class="travelimp__thanku--moreicons fa fa-print"></span>
									</li>
									<li class="travelimp__thanku--morelist">
										<span class="travelimp__thanku--morecontent" ng-click="getTicketInvoiceModel('EmailTicket')"> Email Ticket</span>
										<span class="travelimp__thanku--moreicons fa fa-envelope"></span>
									</li>
									<!--  <li class="travelimp__thanku--morelist">
										<span class="travelimp__thanku--morecontent"  ng-click="getTicketInvoiceModel('SmsTicket')"> SMS Ticket </span>
										<span class="travelimp__thanku--moreicons fa fa-envelope-open"></span>
									</li> -->
									<?php if (0) { ?>
										<?php if (empty($booking['TicketOption'])) { ?>
											<li class="travelimp__thanku--morelist">
												<a class="travelimp__thanku--anchorlink" href="<?php echo site_url('visa/get-invoice-ticket?type=AgencyInvoice&booking_ref_number=' . $booking['bookingRefNumber']) ?>">
													<span class="travelimp__thanku--morecontent"> Invoice For Agency</span>
													<span class="travelimp__thanku--moreicons fa fa-file-alt"></span> </a>
											</li>
										<?php } else { ?>
											<li class="travelimp__thanku--morelist">
												<span class="travelimp__thanku--morecontent" ng-click="getTicketInvoiceModel('AgencyInvoice')"> Invoice For Agency</span>
												<span class="travelimp__thanku--moreicons fa fa-file-alt"></span>
											</li>
										<?php } ?>
									<?php } ?>
									<?php if (empty($booking['InvoiceOption'])) { ?>
										<li class="">
											<a class="travelimp__thanku--morelist travelimp__thanku--anchorlink" href="<?php echo site_url('visa/get-invoice-ticket?type=CustomerInvoice&booking_ref_number=' . $booking['bookingRefNumber']) ?>">
												<span class="travelimp__thanku--morecontent"> Invoice For Customer</span>
												<span class="travelimp__thanku--moreicons fa fa-file-alt"></span> </a>
										</li>
									<?php } else { ?>
										<li class="travelimp__thanku--morelist">
											<span class="travelimp__thanku--morecontent" ng-click="getTicketInvoiceModel('CustomerInvoice')"> Invoice For Customer</span>
											<span class="travelimp__thanku--moreicons fa fa-file-alt"></span>
										</li>
									<?php } ?>
									<!--<li class="travelimp__thanku--morelist">
										<a class="travelimp__thanku--anchorlink" href="#">
											<span class="travelimp__thanku--morecontent">Go to Cart Details</span>
											<span class="travelimp__thanku--moreicons fa fa-shopping-cart"></span> </a>
										</li>-->
								</ul>
							</div>
						</div>
					<?php } ?>
				</div>


				<div class="modal fade" id="FlightUpdateMarkupDiscountModel" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
					<div class="modal-dialog">
						<div class="modal-content modal_content">
							<div class="modal-header modal_header">
								<h5 class="modal-title">Please Wait</h5>
								<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
							</div>
							<div class="modal-body">
								<div class="hotel-main">
									<!----- start loading ---->
									<div class="row" ng-if="flightUpdateMarkupDiscountLoading==true">
										<div class="col-md-12">
											<div class="text-center">
												<div class="loader mt-3 mb-3">
													<div role="status" class="spinner-grow text-primary">
														<span class="sr-only">Loading...</span>
													</div>
													<div role="status" class="spinner-grow text-secondary">
														<span class="sr-only">Loading...</span>
													</div>
													<div role="status" class="spinner-grow text-danger">
														<span class="sr-only">Loading...</span>
													</div>
													<div role="status" class="spinner-grow text-dark">
														<span class="sr-only">Loading...</span>
													</div>
												</div>
												<h5> Please Wait... </h5>
											</div>
										</div>
									</div>
									<!----- end loading -->
									<div class="row" ng-if="flightUpdateMarkupDiscountLoading==false">
										<div class="col-md-12">
											<div class="text-center">
												<h5 class="mt-4"> {{errormessage}}</h5>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>

				<?php if ($booking['bookingStatus'] != "Processing" && $booking['bookingStatus'] != "Failed") { ?>
					<div class="modal fade " id="FlighTicketVoucherOptionModelModel" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
						<div class="modal-dialog modal-dialog-centered ">
							<div class="modal-content modal-content_confirmation ">
								<div class="modal-header modal-header_confirmation">
									<h5 class="modal-title modal-title_confirmation">{{FlighTicketVoucherTitle}}</h5>
									<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
								</div>
								<div class="modal-body modal-body_confirmation">
									<form action="<?php echo site_url('visa/get-invoice-ticket') ?>" method="get" name="printTicketInvoiceForm">
										<input type="hidden" name="booking_ref_number" value="<?php echo $booking['bookingRefNumber']; ?>">
										<input type="hidden" name="type" value="{{type}}">
										<div class="form-check form-check-inline" ng-if="PrintTicket==1">
											<input class="form-check-input form-check-input_confirmation" type="checkbox" value="1" checked name="price">
											<label class="form-check-label" for="inlineCheckbox1"> With Price</label>
										</div>
										<div class="form-check form-check-inline" ng-if="PrintTicket==1">
											<input class="form-check-input form-check-input_confirmation" type="checkbox" value="1" checked name="agency_detail">
											<label class="form-check-label" for="inlineCheckbox2">With Agency</label>
										</div>
										<div class="form-check" ng-if="EmailTicket==1">
											<label class="form-check-label">Enter Email</label>
											<input class="form-control" type="text" placeholder="Enter Email" name="email">
										</div>
										<div class="form-check" ng-if="SmsTicket==1">
											<label class="form-check-label">Enter Mobile Number</label>
											<input class="form-control" type="text" placeholder="Enter Mobile Number" name="mobile_number">
										</div>
										<div class="form-check">
											<div class="text-center print-ticket-button">
												<button type="submit" class="btn btn-success">Submit</button>
											</div>
										</div>
									</form>
								</div>
							</div>
						</div>
					</div>
				<?php } ?>
			</div>

		</section>

	</div>
</div>




<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.8.3/angular.min.js"></script>

<script>
	let url = "<?php echo site_url(); ?>";

	var appHolidayDetail = angular.module('holidayDetailApp', []);
	appHolidayDetail.controller('holidayDetailCtrl', function($scope, $http) {

		$scope.ConfirmationBookingFareBreakUpData = '<?php echo json_encode($booking['FareBreakUpData']); ?>';
		$scope.ConfirmationBookingFareBreakUpData = angular.fromJson($scope.ConfirmationBookingFareBreakUpData);
		$scope.FareBreakup = $scope.ConfirmationBookingFareBreakUpData;
		$scope.BookingId = $scope.FareBreakup.BookingId;

		$scope.Farelength = Object.keys($scope.ConfirmationBookingFareBreakUpData).length;


		$scope.onwardWebPartnerMarkupModal = Number($scope.FareBreakup.WebPMarkUp);
		$scope.onwardWebPartnerDiscountModal = Number($scope.FareBreakup.WebPDiscount);


		let faredetailview = document.querySelector('[faredetailview]');

		if (faredetailview.classList.contains('d-none')) {
			faredetailview.classList.remove('d-none');
		}

		$scope.showMarkupOption = function(rtype) {
			let markupoptionView = document.querySelector('[markup-option-' + rtype + ']');
			if (markupoptionView.classList.contains('d-none')) {
				markupoptionView.classList.remove('d-none');
			}
		}
		$scope.hideMarkupOption = function(rtype) {
			let markupoptionView = document.querySelector('[markup-option-' + rtype + ']');
			if (!markupoptionView.classList.contains('d-none')) {
				markupoptionView.classList.add('d-none');
			}
		}



		$scope.type = ""
		$scope.getTicketInvoiceModel = function(type) {
			var collection = document.getElementsByName("printTicketInvoiceForm");
			for (var i = 0; i < collection.length; i++) {
				collection[i].removeAttribute("tts-form");
				collection[i].setAttribute("method", "get");
			}
			$scope.type = type;
			$scope.FlighTicketVoucherTitle = "";
			$scope.CustomerInvoice = 0;
			$scope.AgencyInvoice = 0;
			$scope.SmsTicket = 0;
			$scope.EmailTicket = 0;
			$scope.PrintTicket = 0;
			$scope.DownloadPdfTicket = 0;
			var FlighTicketVoucherOptionModelModel = document.getElementById("FlighTicketVoucherOptionModelModel");
			if (FlighTicketVoucherOptionModelModel !== null) {
				new bootstrap.Modal(FlighTicketVoucherOptionModelModel).show();
			}
			if (type == 'DownloadPdfTicket') {
				$scope.DownloadPdfTicket = 1;
				$scope.FlighTicketVoucherTitle = "Download PDF";
			} else if (type == 'PrintTicket') {
				$scope.PrintTicket = 1;
				$scope.FlighTicketVoucherTitle = "Print Ticket";
			} else if (type == 'CustomerInvoice') {
				$scope.CustomerInvoice = 1;
				$scope.FlighTicketVoucherTitle = "Invoice For Customer";
			} else if (type == 'AgencyInvoice') {
				$scope.AgencyInvoice = 1;
				$scope.FlighTicketVoucherTitle = "Invoice For Agency";
			} else if (type == 'SmsTicket') {
				$scope.SmsTicket = 1;
				$scope.FlighTicketVoucherTitle = "Sms Ticket";
			} else if (type == 'EmailTicket') {
				var setcollection = document.getElementsByName("printTicketInvoiceForm");
				for (var i = 0; i < collection.length; i++) {
					setcollection[i].setAttribute("tts-form", true);
					setcollection[i].setAttribute("method", "post");
				}
				$scope.EmailTicket = 1;
				$scope.FlighTicketVoucherTitle = "Email Ticket";
			}
		}
	});
</script>