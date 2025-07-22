<style>

    .input-floating-label {
        font-size: 13px;
        padding: 0px 0;
        border: none;
        border-bottom: solid 1px #e5e5e5;
        width: 100%;
        box-sizing: border-box;
        transition: all 0.3s linear;
        color: #333;
        font-weight: 400;
        -webkit-appearance: none;
        -moz-appearance: none;
        -o-appearance: none;
        border-radius: 0;
        background: transparent;
    }
</style>
<div class="page-content">
    <div class="table_title">


        <section class="cart_information p0"> <?php //pr($amendmentDetail);?>
            <div class="container-fluid p0">
                <div class="sale_bar">
                    <div class="row align-items-center">
                        <div class="col-md-4 mb-3 mb-lg-0">
                            <h5 class="m0"> Amendment Details (<?php echo $amendmentDetail['id']; ?>)</h5>
                        </div>
                        <div class="col-md-8 text-md-right">
                            <a class="badge badge-wt"
                               href="<?php echo site_url('/cruise/confirmation/') . $ticketData = dev_encode(json_encode(array('BookingId'=>$amendmentDetail['Booking_id']))); ?>">Booking
                                Summary</a>
                        </div>
                    </div>
                </div>
                <div class="row">

                    <div class="col-md-12 col-12 col-lg-12">
                        <div class="cart_info">
                            <div class="accordion" id="accordionExample">
                                <div class="accordion-item">
                                    <div class="accordion-item">
                                        <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                                data-bs-target="#collapseamendment" aria-expanded="true"
                                                aria-controls="collapseamendment">
                                            <span class="acordian_heading">Amendment Information : <?php echo $amendmentDetail['id']; ?></span>
                                        </button>
                                        <div id="collapseamendment" class="accordion-collapse collapse show"
                                             aria-labelledby="headingamendment" data-bs-parent="#accordionExample">
                                            <div class="accordion-body cart-details-borderline">
                                               
                                                    <div class="row">
                                                        <div class="col-md-4 col-xs-6 col-6">
                                                            <div class="cart_info-field">
                                                                <p class="cart_info-field--title">Amendment Id :<span
                                                                            class="cart_info-field--detail"><span> &nbsp;<?php echo $amendmentDetail['id']; ?></span></span>
                                                                </p>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4 col-xs-6 col-6">
                                                            <div class="cart_info-field">
                                                                <p class="cart_info-field--title">Amendment Status :<span
                                                                            class="cart_info-field--detail"><span> &nbsp;&nbsp;<?php echo ucfirst($amendmentDetail['amendment_status']); ?></span></span>
                                                                </p>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4 col-xs-6 col-6">
                                                            <div class="cart_info-field">
                                                                <p class="cart_info-field--title">Amendment Type :<span
                                                                            class="cart_info-field--detail"><span> &nbsp;<?php echo ucfirst($amendmentDetail['amendment_type']); ?></span></span>
                                                                </p>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4 col-xs-6 col-6">
                                                            <div class="cart_info-field">
                                                                <p class="cart_info-field--title">Remark From Agent:<span
                                                                            class="cart_info-field--detail"><span> &nbsp;<?php echo $amendmentDetail['remark_from_web_partner']; ?></span></span>
                                                                </p>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4 col-xs-6 col-6">
                                                            <div class="cart_info-field">
                                                                <p class="cart_info-field--title">Remark From Company :<span
                                                                            class="cart_info-field--detail"><span> &nbsp;<?php echo $amendmentDetail['remark_from_super_admin']; ?></span></span>
                                                                </p>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4 col-xs-6 col-6">
                                                            <div class="cart_info-field">
                                                                <p class="cart_info-field--title">CreatedOn :<span
                                                                            class="cart_info-field--detail"><span> &nbsp;<?php echo date_created_format($amendmentDetail['created']); ?></span></span>
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                
                                            </div>
                                        </div>
                                    </div>





                                    <div class="accordion-item">
                                        <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                                data-bs-target="#collapseamendmentDetail" aria-expanded="true"
                                                aria-controls="collapseamendmentDetail">
                                            <span class="acordian_heading">Amendment Detail </span>

                                        </button>

                                        <div id="collapseamendmentDetail" class="accordion-collapse collapse show"
                                             aria-labelledby="headingamendmentDetail" data-bs-parent="#accordionExample">
                                            <div class="accordion-body cart-details-borderline">

                                                <div class="amend_details-passengers--list">
                                                    <form action="<?php echo site_url('cruise/amendment-cancellation-charge'); ?>"
                                                          method="post" tts-form="true" name="cancellation_charge_update">
                                                        <?php
                                                        $amendment_charges = array();
                                                        $charge = 0;
                                                        $service_charge = 0;

                                                        $refund = 0;
                                                        $service_charge_gst = 0;
                                                        $TDSReturnIdentifier = "no";
                                                        $TDSReturnIdentifierChecked = "";
                                                        if ($amendmentDetail['amendment_charges'] != Null) {
                                                            $amendment_charges = json_decode($amendmentDetail['amendment_charges'], true);
                                                            $charge = $amendment_charges['Charge'];
                                                            $service_charge = $amendment_charges['ServiceCharge'];
                                                            $refund = $amendment_charges['Refund'];
                                                            $TDSReturnIdentifier = isset($amendment_charges['TDSReturnIdentifier']) ? $amendment_charges['TDSReturnIdentifier'] : "no";
                                                            $TDSReturnIdentifierChecked = $TDSReturnIdentifier == "yes" ? "checked" : "";
                                                            $service_charge_gst = $amendment_charges['GST']['TotalGSTAmount'];
                                                        }



                                                        $offeredFare = $amendmentDetail['web_partner_fare_break_up']['TTSBreakup']['OfferedPrice'];



                                                        $publishedFare = $amendmentDetail['web_partner_fare_break_up']['TTSBreakup']['PublishedPrice'];

                                                        //$CommEarned=$amendmentDetail['web_partner_fare_break_up']['AgentCommission'];

                                                        $Discount= $amendmentDetail['web_partner_fare_break_up']['TTSBreakup']['Discount'];

                                                        $TDS = $amendmentDetail['web_partner_fare_break_up']['TDS'];
                                                        ?>


                                                        <div class="row">

                                                            <div class="col-sm-12 passenger_faredetail">
                                                                <div class="row">
                                                                    <div class="col-sm-2 col-xs-6 col-6 padd-left-amendment">
                                                                        <p class="m0">Offered Fare</p>
                                                                        <p class="price-width-left"
                                                                           id="offeredFare"
                                                                           agentOfferedFare="<?php echo $offeredFare; ?>">
                                                                            ₹ <?php echo $offeredFare; ?></p>
                                                                    </div>

                                                                    <div class="col-sm-2 col-xs-6 col-6 padd-left-amendment">
                                                                        <p class="m0">Published Fare</p>
                                                                        <p class="price-width-left"
                                                                           id="publishedFare">
                                                                            ₹ <?php echo $publishedFare; ?></p>
                                                                    </div>

                                                                   <!-- <div class="col-sm-2 col-xs-6 col-6 padd-left-amendment">
                                                                        <p class="m0">Agent
                                                                            Commission</p>
                                                                        <p class="price-width-left"
                                                                           id="agent_commission"
                                                                           AgentCommission="<?php /*echo $CommEarned; */?>">
                                                                            ₹ <?php /*echo $CommEarned; */?></p>
                                                                    </div>-->
                                                                    <div class="col-sm-2 col-xs-6 col-6 padd-left-amendment">
                                                                        <p class="m0">Discount</p>
                                                                        <p class="price-width-left"
                                                                           id="discount"
                                                                           Discount="<?php echo $Discount; ?>">
                                                                            ₹ <?php echo $Discount; ?></p>
                                                                    </div>
                                                                    <!--<div class="col-sm-2 col-xs-6 col-6 padd-left-amendment">
                                                                                <p class="m0">GST Amount</p>
                                                                                <p class="price-width-left"
                                                                                   id="airline_gst_amount"
                                                                                   airlineGSTAmount="<?php /*echo $GSTAmount; */?>">
                                                                                    ₹ <?php /*echo $GSTAmount; */?></p>
                                                                            </div>
                                                                            -->
                                                                    <div class="col-sm-2 col-xs-6 col-6 padd-left-amendment">
                                                                        <p class="m0">TDS</p>
                                                                        <p class="price-width-left"
                                                                           id="tds"
                                                                           TDS="<?php echo $TDS; ?>">
                                                                            ₹ <?php echo $TDS; ?></p>
                                                                    </div>





                                                                    <input type="hidden" name="amendment_id"
                                                                           value="<?php echo dev_encode($amendmentDetail['id']); ?>">

                                                                    <?php if ($amendmentDetail['amendment_type'] == "cancellation" || $amendmentDetail['amendment_type'] == "full_refund") {
                                                                        ?>
                                                                        <div class="col-sm-4 col-xs-6 col-6 padd-left-amendment">
                                                                            <p class="m0">Cancellation
                                                                                Charge</p>
                                                                            <p class="price-width-left">
                                                                                <input class="input-floating-label"
                                                                                       type="text"
                                                                                       name="charge"
                                                                                       value="<?php echo $charge; ?>"
                                                                                       id="charge"
                                                                                       oninput="getVisaRefundCharges(event)">
                                                                            </p>
                                                                        </div>
                                                                        <div class="col-sm-4 col-xs-6 col-6 padd-left-amendment">
                                                                            <p class="m0">Cancellation
                                                                                Service Charge</p>
                                                                            <p class="price-width-left">
                                                                                <input class="input-floating-label"
                                                                                       type="text"
                                                                                       name="service_charge"
                                                                                       value="<?php echo $service_charge; ?>"
                                                                                       id="service_charge"
                                                                                       oninput="getVisaRefundCharges(event)">
                                                                            </p>
                                                                        </div>

                                                                        <div class="col-sm-4 col-xs-6 col-6 padd-left-amendment">
                                                                            <p class="m0">Cancellation
                                                                                Charge GST</p>
                                                                            <p class="price-width-left">
                                                                                <input class="input-floating-label"
                                                                                       type="text"
                                                                                       name="service_charge_gst"
                                                                                       value=""
                                                                                       id="service_charge_gst"
                                                                                       readonly></p>
                                                                        </div>
                                                                        <div class="col-sm-4 col-xs-6 col-6 padd-left-amendment">
                                                                            <p class="m0">Refund
                                                                                Amount</p>
                                                                            <p class="price-width-left">
                                                                                <input class="input-floating-label"
                                                                                       type="text"
                                                                                       name="refund"
                                                                                       value="<?php echo $refund; ?>"
                                                                                       id="refund"
                                                                                       readonly></p>
                                                                        </div>
                                                                        <div class="col-sm-4 col-xs-6 col-6 padd-left-amendment">
                                                                            <label class="price-width-left "><input
                                                                                        class=""
                                                                                        type="checkbox"
                                                                                        name="tdsreturn"
                                                                                        value="yes"
                                                                                        id="tdsreturn"
                                                                                        onclick='getVisaRefundCharges(event)' <?php echo $TDSReturnIdentifierChecked; ?>>TDS
                                                                                Return</label>
                                                                        </div>
                                                                    <?php } ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <?php if ($amendmentDetail['refund_status'] != "Close" && ($amendmentDetail['amendment_type'] == "cancellation" || $amendmentDetail['amendment_type'] == "full_refund")) { ?>
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <button class="btn btn-info pull-right" type="submit">
                                                                        Update
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        <?php } ?>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>





                                    <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapseOne" aria-expanded="true"
                                            aria-controls="collapseOne">
                                        <span class="acordian_heading">Cart Information : <?php echo $amendmentDetail['booking_ref_number']; ?></span>
                                    </button>

                                    <div id="collapseOne" class="accordion-collapse collapse show"
                                         aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                        <div class="accordion-body cart-details-borderline">
                                           
                                                <div class="row">
                                                    <div class="col-md-4 col-xs-6 col-6">
                                                        <div class="cart_info-field">
                                                            <p class="cart_info-field--title">Booking Ref Number :<span
                                                                        class="cart_info-field--detail"><span> &nbsp;<?php echo $amendmentDetail['booking_ref_number']; ?></span></span>
                                                            </p>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4 col-xs-6 col-6">
                                                        <div class="cart_info-field">
                                                            <p class="cart_info-field--title">Amount :<span
                                                                        class="cart_info-field--detail"><span> &nbsp;₹&nbsp;<?php echo $amendmentDetail['total_price']; ?></span></span>
                                                            </p>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4 col-xs-6 col-6">
                                                        <div class="cart_info-field">
                                                            <p class="cart_info-field--title">Booking Status :<span
                                                                        class="cart_info-field--detail"><span> &nbsp;<?php echo $amendmentDetail['booking_status']; ?></span></span>
                                                            </p>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4 col-xs-6 col-6">
                                                        <div class="cart_info-field">
                                                            <p class="cart_info-field--title">Payment Status :<span
                                                                        class="cart_info-field--detail"><span> &nbsp;<?php echo $amendmentDetail['payment_status']; ?></span></span>
                                                            </p>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4 col-xs-6 col-6">
                                                        <div class="cart_info-field">
                                                            <p class="cart_info-field--title">Channel Type :<span
                                                                        class="cart_info-field--detail"><span> &nbsp;<?php echo (isset($amendmentDetail['booking_channel']))?$amendmentDetail['booking_channel']:'Desktop'; ?></span></span>
                                                            </p>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4 col-xs-6 col-6">
                                                        <div class="cart_info-field">
                                                            <p class="cart_info-field--title">CreatedOn :<span
                                                                        class="cart_info-field--detail"><span> &nbsp;<?php echo date_created_format($amendmentDetail['booking_created']); ?></span></span>
                                                            </p>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4 col-xs-6 col-6">
                                                        <div class="cart_info-field">
                                                            <p class="cart_info-field--title">Booking User :<span
                                                                        class="cart_info-field--detail"><span> &nbsp;<a
                                                                                href="#"
                                                                                class=""><?php echo $amendmentDetail['staff_name']; ?></a></span></span>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                           
                                        </div>
                                    </div>
                                </div>


                                <div class="accordion-item">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                        <span class="acordian_heading">Booking Details</span>

                                    </button>
                                    <div id="collapseFour" class="accordion-collapse collapse show" aria-labelledby="headingFour" data-bs-parent="#accordionExample">
                                        <div class="accordion-body cart-details-borderline">
                                            <div class="row">
                                                <div class="col-lg-12 col-md-12 col-12">
                                                    <div class="tts-holiday-review-details">
                                                        <div class="my-3">
                                                            <ul class="d-flex align-items-center justify-content-between">
                                                                <li>
                                                                    <h6>Cruise Line</h6>
                                                                    <h6><?php echo $amendmentDetail['cruise_line_name']?> </h6>
                                                                </li>

                                                                <li>
                                                                    <h6>Ship Name</h6>
                                                                    <h6><?php echo $amendmentDetail['ship_name'] ?> </h6>
                                                                </li>
                                                                <li>
                                                                    <h6>No. of Travellers</h6>
                                                                    <h6><?php echo $amendmentDetail['no_of_travellers']?> </h6>
                                                                </li>
                                                                <li>
                                                                    <h6>Travel Date</h6>
                                                                    <h6><?php echo $amendmentDetail['sailing_date']?> </h6>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                                <hr/>
                                                <div class="col-md-12 travelimp__thanku--panelHeadwrap">
                                                    <div class="table-responsive travelimp__thanku--responsivewrap">
                                                        <h6>Passenger Details</h6>
                                                        <table class="table table-bordered travelimp__thanku--tablewrap">
                                                            <thead>
                                                            <tr>
                                                                <th>Sr.</th>
                                                                <th>Name</th>
                                                                <th>Dob</th>
                                                                <th>Gender</th>
                                                                <th>Passport Number</th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            <?php if ($amendmentDetail['travelersInfo']) {

                                                                foreach ($amendmentDetail['travelersInfo'] as $key => $traveller) {
                                                                    if ($traveller['lead_pax'] == 1) {
                                                                        $amendmentDetail['email'] = $traveller['email_id'];
                                                                        $amendmentDetail['mobile_no'] = $traveller['mobile_number'];
                                                                    }
                                                                    ?>
                                                                    <tr>
                                                                        <th scope="row"><?php echo $key + 1; ?></th>
                                                                        <td>
                                                                            <?php echo $traveller['title'] . ' ' . $traveller['first_name'] . ' ' . $traveller['last_name'] ?>
                                                                        </td>
                                                                        <td>
                                                                            <?php echo $traveller['dob']; ?>
                                                                        </td>
                                                                        <td>
                                                                           <?php echo $traveller['gendar']; ?>
																	    </td>
                                                                        <td>
                                                                            <?php echo $traveller['passport_no']; ?>
                                                                        </td>
                                                                    </tr>
                                                                <?php }
                                                            } ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapseSix" aria-expanded="false"
                                            aria-controls="collapseSix">
                                        <span class="acordian_heading">User Information </span>
                                    </button>
                                    <div id="collapseSix" class="accordion-collapse collapse show"
                                         aria-labelledby="headingSix" data-bs-parent="#accordionExample">
                                        <div class="accordion-body cart-details-borderline">
                                            
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="cart_info-field">
                                                            <p class="cart_info-field--title">Contact's Email:<span
                                                                        class="cart_info-field--detail">
																	<span><?php echo $amendmentDetail['email']; ?></span></span>
                                                            </p>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="cart_info-field">
                                                            <p class="cart_info-field--title">Pax contact:<span
                                                                        class="cart_info-field--detail"><span> <?php echo $amendmentDetail['mobile_no']; ?></span></span>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapseFive" aria-expanded="false"
                                            aria-controls="collapseFive">
                                        <span class="acordian_heading">Payment Process</span>
                                        <span class="ball__mainwrapper"><span
                                                    class="ball__border info_length-green"><span
                                                        class="numbering-section"><?php echo count($amendmentDetail['paymentInfo']); ?></span></span></span>
                                    </button>
                                    <div id="collapseFive" class="accordion-collapse collapse show"
                                         aria-labelledby="headingFive" data-bs-parent="#accordionExample">
                                        <div class="accordion-body cart-details-borderline">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="table-responsive">
                                                        <table class="table table-bordered ">
                                                            <thead>
                                                            <tr>
                                                                <th>Ref. Number</th>
                                                                <th>Remark</th>
                                                                <th>Credit</th>
                                                                <th>Debit</th>
                                                                <th>Type</th>
                                                                <th>Created</th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>

                                                            <?php
                                                            if (!empty($amendmentDetail['paymentInfo']) && is_array($amendmentDetail['paymentInfo'])) {
                                                                foreach ($amendmentDetail['paymentInfo'] as $data) {
                                                                    ?>
                                                                    <tr>
                                                                        <td> <?php echo $data['acc_ref_number']; ?></td>
                                                                        <td><?php echo $data['remark']; ?></td>
                                                                        <td> ₹ <?php echo $data['credit']; ?></td>
                                                                        <td> ₹ <?php echo $data['debit']; ?></td>
                                                                        <td><?php echo ucfirst($data['action_type']); ?></td>
                                                                        <td>
                                                                            <?php echo date_created_format($data['created']); ?>
                                                                        </td>
                                                                    </tr>
                                                                <?php }
                                                            } else {
                                                                echo "<tr> <td colspan='6' class='text_center'><b>No Data Found</b></td></tr>";
                                                            } ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="accordion-item">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapseSeven" aria-expanded="false"
                                            aria-controls="collapseSeven">
                                        <span class="acordian_heading">Fare Breakup </span>

                                    </button>
                                    <div id="collapseSeven" class="accordion-collapse collapse show"
                                         aria-labelledby="headingSeven" data-bs-parent="#accordionExample">
                                        <div class="accordion-body cart-details-borderline">
                                            <div class="table-responsive">
                                                <?php $FareBreakUp = $amendmentDetail['FareBreakUp'];
                                                if ($FareBreakUp) { ?>
                                                    <table class="table table-bordered table-hover">
                                                        <tr>
                                                            <th scope="row"><?php echo $FareBreakUp['MarkUp']['LabelText']; ?> : </th scopr="roh">
                                                            <td>₹ <?php echo $FareBreakUp['MarkUp']['Value']; ?></td>
                                                        </tr>
                                                        <tr>
                                                            <th scope="row"><?php echo $FareBreakUp['Discount']['LabelText']; ?> :</th scopr="roh">
                                                            <td>₹ <?php echo $FareBreakUp['Discount']['Value']; ?></td>
                                                        </tr>
                                                    </table>
                                                </div>  
                                                <div class="table-responsive">  
                                                    <table class="table table-bordered table-hover">


                                                        <?php foreach ($FareBreakUp['FareBreakup'] as $fare) { ?>
                                                            <tr>
                                                                <th scopr="roh"><?php echo $fare['LabelText']; ?> :</th>
                                                                <td>₹ <?php echo $fare['Value']; ?></td>
                                                            </tr>
                                                        <?php } ?>
                                                        <tr>
                                                            <th scopr="roh"><?php echo $FareBreakUp['TotalAmount']['LabelText']; ?>
                                                                :
                                                            </th>
                                                            <td> ₹ <?php echo $FareBreakUp['TotalAmount']['Value']; ?></td>
                                                        </tr>
                                                    </table>
                                                </div> 
                                                 <div class="table-responsive">   
                                                    <?php if (isset($FareBreakUp['GSTDetails']) && $FareBreakUp['GSTDetails']) { ?>
                                                        <table class="table table-bordered table-hover">

                                                            <tr>
                                                                <th>Service Charges</th>
                                                                <th>Taxable Value</th>
                                                                <th>CGST @ <?php echo $FareBreakUp['GSTDetails']['CGSTRate']; ?> %</th>
                                                                <th>SGST@ <?php echo $FareBreakUp['GSTDetails']['SGSTRate']; ?> %
                                                                </th>
                                                                <th>IGST@<?php echo $FareBreakUp['GSTDetails']['IGSTRate']; ?> %</th>
                                                                <th>Total</th>
                                                            </tr>


                                                            <tr>
                                                                <th>Service Charges</th>
                                                                <th><?php echo $FareBreakUp['GSTDetails']['TaxableAmount']; ?></th>
                                                                <th><?php echo $FareBreakUp['GSTDetails']['CGSTAmount']; ?></th>
                                                                <th> <?php echo $FareBreakUp['GSTDetails']['SGSTAmount']; ?></th>
                                                                <th> <?php echo $FareBreakUp['GSTDetails']['IGSTAmount']; ?></th>
                                                                <th> <?php echo $FareBreakUp['GSTDetails']['CGSTAmount'] + $FareBreakUp['GSTDetails']['SGSTAmount'] + $FareBreakUp['GSTDetails']['IGSTAmount']; ?></th>
                                                            </tr>

                                                        </table>
                                                    <?php }
                                                } ?>
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
        </section>
    </div>
</div>


<div id="holiday-raise-amendment" class="modal">
    <div class="top-model-content">
        <form action="<?php echo site_url('cruise/raise-amendment'); ?>" method="post" tts-form="true"
              name="form_change_status">
            <div class="modal-header">
                <span class="close" onclick="ttsclosemodel(this)">&times;</span>
                <h5>AMENDMENTS</h5>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="tts-col-12">
                        <div class="form-group">
                            <select class="form-control" name="amendment_status">
                                <option value="">Amendment Status</option>
                                <option value="rejected">Rejected</option>
                                <option value="success">Success</option>
                            </select>
                        </div>
                        <input type="hidden" name="booking_ref_number"
                               value="<?php echo $amendmentDetail['booking_ref_number']; ?>">

                        <input type="hidden" name="amendment_id" id="amendment-id">

                    </div>
                    <div class="tts-col-12">
                        <div class="form-group">
                            <label>Remark</label>
                            <textarea class="form-control" name="remark" rows="3" cols="15"></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="top-model-footer">
                <div class="row">
                    <div class="tts-col-12">
                        <button class="badge badge-md badge-primary" type="submit" value="Save">Save</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>


<script>

    function getVisaRefundCharges(evt) {
        var flightgst = 18;
        evt = (evt) ? evt : window.event;
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        /*  if ((charCode > 31) && (charCode <= 48 || charCode > 57)) { */
        var charge = parseFloat(document.getElementById("charge").value);
        var serviceCharge = parseFloat(document.getElementById("service_charge").value);




        var tds = 0;
        if ($("#tdsreturn").prop('checked') == true) {
            var tds = parseFloat(document.getElementById("tds").getAttribute('TDS'));
        }
        var offeredFare = parseFloat(document.getElementById("offeredFare").getAttribute('agentOfferedFare'));

        var agent_commission = 0;//parseFloat(document.getElementById("agent_commission").getAttribute('AgentCommission'));
        var agent_discount = parseFloat(document.getElementById("discount").getAttribute('Discount'));


        var TotalpaxFare = parseFloat((offeredFare + tds)).toFixed(2);
        var serviceChargeGst = calculate_hotel_gst(serviceCharge, flightgst);
        var totalRefundAmount = parseFloat((charge + serviceCharge + serviceChargeGst));



        var refund = (TotalpaxFare - totalRefundAmount).toFixed(2);

        if (!isNaN(serviceChargeGst)) {
            document.getElementById("service_charge_gst").value = serviceChargeGst;
        } else {
            document.getElementById("service_charge_gst").value = 0;
        }
        if (!isNaN(refund)) {
            if (refund < 0) {
                $("[data-message]").addClass('error_popup').html("Please check refund amount value is negative.");
            } else {
                $("[data-message]").removeClass('error_popup').html("");
            }
            document.getElementById("refund").value = parseFloat(refund);
        } else {
            document.getElementById("refund").value = 0;
        }
        /* } */
    }

    function calculate_hotel_gst(serviceCharge, flightgst) {
        var returnval = Math.round(((serviceCharge * flightgst) / 100), 2);
        return returnval;
    }
</script>

