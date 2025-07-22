<div class="page-content">
    <div class="table_title">
        <section class="cart_information p0">
            <?php pr($getTicketData);
            pr($visaInfo); ?>
            <div class="container-fluid p0">
                <div class="sale_bar">
                    <div class="row align-items-center">
                        <div class="col-md-4 mb-3 mb-lg-0">
                            <h5 class="m0"> Visa Booking Details </h5>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 col-12 col-lg-12">
                        <div class="cart_info">
                            <div class="accordion" id="accordionExample">
                                <div class="accordion-item">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                       
                                    </button>

                                    <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                        <div class="row">
                                                    <div class="col-md-4 col-xs-6 col-6">
                                                        <div class="cart_info-field">
                                                            <p class="cart_info-field--title">Agent Name :<span class="cart_info-field--detail"><span> &nbsp;<?php echo ucwords($getTicketData['agent_info']); ?></span></span>
                                                            </p>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4 col-xs-6 col-6">
                                                        <div class="cart_info-field">
                                                            <p class="cart_info-field--title">Company Name :<span class="cart_info-field--detail"><span> &nbsp;₹&nbsp;<?php //echo ucwords($visaInfo['AgentInfo']['company_name']); ?></span></span>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                        </div>
                                    </div>
                                </div>
                                <?php if ($visaInfo['AgentInfo'] && !empty($visaInfo['AgentInfo'])) { ?>
                                    <div class="accordion-item">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                                            <span class="acordian_heading">Agent Info : <?php echo ucwords($getTicketData['agent_info']); ?></span>
                                        </button>
                                        <div id="collapseTwo" class="accordion-collapse collapse show" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                                            <div class="accordion-body cart-details-borderline">
                                                <div class="row">
                                                    <div class="col-md-4 col-xs-6 col-6">
                                                        <div class="cart_info-field">
                                                            <p class="cart_info-field--title">Agent Name :<span class="cart_info-field--detail"><span> &nbsp;<?php echo ucwords($getTicketData['agent_info']); ?></span></span>
                                                            </p>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4 col-xs-6 col-6">
                                                        <div class="cart_info-field">
                                                            <p class="cart_info-field--title">Company Name :<span class="cart_info-field--detail"><span> &nbsp;₹&nbsp;<?php echo ucwords($visaInfo['AgentInfo']['company_name']); ?></span></span>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                                <?php if ($visaInfo['CustomerInfo'] && !empty($visaInfo['CustomerInfo'])) { ?>
                                    <div class="accordion-item">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                            <span class="acordian_heading">Customer Info : <?php echo ucwords($getTicketData['customer_info']); ?></span>
                                        </button>
                                        <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                            <div class="accordion-body cart-details-borderline">
                                                <div class="row">
                                                    <div class="col-md-4 col-xs-6 col-6">
                                                        <div class="cart_info-field">
                                                            <p class="cart_info-field--title">Agent Name :<span class="cart_info-field--detail"><span> &nbsp;<?php echo ucwords($getTicketData['customer_info']); ?></span></span>
                                                            </p>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4 col-xs-6 col-6">
                                                        <div class="cart_info-field">
                                                            <p class="cart_info-field--title">Customer Email :<span class="cart_info-field--detail"><span> &nbsp;₹&nbsp;<?php echo ucwords($visaInfo['CustomerInfo']['email_id']); ?></span></span>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                                <div class="accordion-item">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                        <span class="acordian_heading">Booking Details</span>
                                    </button>
                                    <div id="collapseThree" class="accordion-collapse collapse show" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                                        <div class="accordion-body cart-details-borderline">
                                            <div class="row">
                                                <div class="col-lg-12 col-md-12 col-12">
                                                    <div class="tts-holiday-review-details">
                                                        <div class="my-3">
                                                            <ul class="d-flex align-items-center justify-content-between">
                                                                <li>
                                                                    <h6>Visa Country</h6>
                                                                    <h6><?php echo  ucwords($getTicketData['destinations']); ?> </h6>
                                                                </li>
                                                                <li>
                                                                    <h6>Visa Type</h6>
                                                                    <h6><?php echo ucwords($getTicketData['visa_type']); ?> </h6>
                                                                </li>
                                                                <li>
                                                                    <h6>No. of Travellers</h6>
                                                                    <h6><?php echo  count($getTicketData['pax_details']); ?> </h6>
                                                                </li>
                                                                <li>
                                                                    <h6>Travel Date</h6>
                                                                    <h6><?php echo  $getTicketData['travel_date']; ?> </h6>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                                <hr />
                                                <div class="col-md-12 travelimp__thanku--panelHeadwrap">
                                                    <div class="table-responsive travelimp__thanku--responsivewrap">
                                                        <h6>Passenger Details</h6>
                                                        <table class="table table-bordered table-hover travelimp__thanku--tablewrap">
                                                            <thead class="table-active">
                                                                <tr>
                                                                    <th>Sr.</th>
                                                                    <th>Name</th>
                                                                    <th>Dob</th>
                                                                    <th>Document</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php
                                                                if ($getTicketData['pax_details']) {
                                                                    foreach ($getTicketData['pax_details'] as $key => $traveller) {

                                                                ?>
                                                                        <tr>
                                                                            <td><?php echo $key; ?></td>
                                                                            <td>
                                                                                <?php echo $traveller['title'] . ' ' . $traveller['first_name'] . ' ' . $traveller['last_name']; ?>
                                                                            </td>
                                                                            <td>
                                                                                <?php echo $traveller['dob'];
                                                                                ?>
                                                                            </td>
                                                                            <td>
                                                                                <?php foreach ($traveller['document'] as $key => $doc) { ?>
                                                                                    <span class="item-text-value"><a href="<?php echo root_url . "uploads/visa_documents/" . $doc; ?>" target="_blank"><?php echo str_replace('_', ' ', ucwords($key)); ?></a></span>
                                                                                <?php  }  ?>
                                                                            </td>
                                                                        </tr>
                                                                <?php }
                                                                }
                                                                ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="accordion-item">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSeven" aria-expanded="false" aria-controls="collapseSeven">
                                        <span class="acordian_heading">Fare Breakup </span>
                                    </button>
                                    <div id="collapseSeven" class="accordion-collapse collapse show" aria-labelledby="headingSeven" data-bs-parent="#accordionExample">
                                        <div class="accordion-body cart-details-borderline">
                                            <div class="table-responsive">
                                                <?php //$FareBreakUp = $bookingDetail['FareBreakUp'];
                                                //if ($FareBreakUp) { 
                                                ?>
                                                <table class="table table-bordered table-hover">
                                                    <tr>
                                                        <th scope="row"><?php //echo $FareBreakUp['WebPMarkUp']['LabelText']; 
                                                                        ?>:</th>
                                                        <td>₹ <?php //echo $FareBreakUp['WebPMarkUp']['Value']; 
                                                                ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row"><?php // echo $FareBreakUp['WebPDiscount']['LabelText']; 
                                                                        ?>:</th>
                                                        <td>₹ <?php // echo $FareBreakUp['WebPDiscount']['Value']; 
                                                                ?></td>
                                                    </tr>
                                                </table>
                                            </div>
                                            <div class="table-responsive">
                                                <table class="table table-bordered table-hover">
                                                    <?php // foreach ($FareBreakUp['FareBreakup'] as $fare) { 
                                                    ?>
                                                    <tr>
                                                        <th><?php // echo $fare['LabelText']; 
                                                            ?>:</th>
                                                        <td>₹ <?php // echo $fare['Value']; 
                                                                ?></td>
                                                    </tr>
                                                    <?php // } 
                                                    ?>
                                                    <tr>
                                                        <th scope="row"><?php // echo $FareBreakUp['TotalAmount']['LabelText']; 
                                                                        ?>:</th>
                                                        <td>₹ <?php // echo $FareBreakUp['TotalAmount']['Value']; 
                                                                ?></td>
                                                    </tr>
                                                </table>
                                            </div>
                                            <div class="table-responsive">
                                                <?php // if (isset($FareBreakUp['GSTDetails']) && $FareBreakUp['GSTDetails']) { 
                                                ?>
                                                <table class="table table-bordered table-hover">
                                                    <tr>
                                                        <th>Service Charges</th>
                                                        <th>Taxable Value</th>
                                                        <th>CGST @ <?php // echo $FareBreakUp['GSTDetails']['CGSTRate']; 
                                                                    ?> %</th>
                                                        <th>SGST @ <?php // echo $FareBreakUp['GSTDetails']['SGSTRate']; 
                                                                    ?>%</th>
                                                        <th>IGST @<?php // echo $FareBreakUp['GSTDetails']['IGSTRate']; 
                                                                    ?> %</th>
                                                        <th>Total</th>
                                                    </tr>
                                                    <tr>
                                                        <th>Service Charges</th>
                                                        <th><?php // echo $FareBreakUp['GSTDetails']['TaxableAmount']; 
                                                            ?></th>
                                                        <th><?php // echo $FareBreakUp['GSTDetails']['CGSTAmount']; 
                                                            ?></th>
                                                        <th> <?php // echo $FareBreakUp['GSTDetails']['SGSTAmount']; 
                                                                ?></th>
                                                        <th> <?php // echo $FareBreakUp['GSTDetails']['IGSTAmount']; 
                                                                ?></th>
                                                        <th> <?php // echo $FareBreakUp['GSTDetails']['CGSTAmount'] + $FareBreakUp['GSTDetails']['SGSTAmount'] + $FareBreakUp['GSTDetails']['IGSTAmount']; 
                                                                ?></th>
                                                    </tr>
                                                </table>
                                                <?php // }
                                                //} 
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="accordion-item">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSix" aria-expanded="false" aria-controls="collapseSix">
                                        <span class="acordian_heading">User Information </span>
                                    </button>
                                    <div id="collapseSix" class="accordion-collapse collapse show" aria-labelledby="headingSix" data-bs-parent="#accordionExample">
                                        <div class="accordion-body cart-details-borderline">

                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="cart_info-field">
                                                        <p class="cart_info-field--title">Contact's Email:<span class="cart_info-field--detail">
                                                                <span><?php //echo $bookingDetail['email']; 
                                                                        ?></span></span>
                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="cart_info-field">
                                                        <p class="cart_info-field--title">Pax contact:<span class="cart_info-field--detail"><span> <?php //echo $bookingDetail['mobile_no']; 
                                                                                                                                                    ?></span></span>
                                                        </p>
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
        </section>
    </div>
</div>