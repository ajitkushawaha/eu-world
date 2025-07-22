<?php
if ($details && isset($details['email'])) { ?>
    <div class="modal-header">
        <h5 class="modal-title"><? echo $title . ' '; ?>Details</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="vewmodelhed">
        <div class="modal-body">
            <div class="col-md-12">
                <h6 class="viewld_h5"><?php echo 'Customer  Information'; ?></h6>
            </div>
            <div class="row mb-3">
                <div class="col-md-4">
                    <div class="vi_mod_dsc">
                        <span>Name</span>
                        <span class="primary"> <b><?php echo ucfirst($details['customerfirstname']) . ' ' . ucfirst($details['customerlastname']); ?></b> </span>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="vi_mod_dsc">
                        <span>Email </span>
                        <span class="primary"> <b><?php echo $details['customeremail'] ?> </b> </span>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="vi_mod_dsc">
                        <span>Mobile No</span>
                        <span class="primary"> <b><?php echo $details['customer_no']; ?> </b> </span>
                    </div>
                </div>
            </div>

            <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab" tabindex="0">
                    <div class="col-md-12">
                        <h6 class="viewld_h5"><?php echo 'Customer Travelers Information'; ?></h6>
                    </div>
                    <table class="table table-bordered">
                        <tbody class="lead_details">
                            <tr>
                                <td><span class=" item-text-head"><b>ID</b></span></td>
                                <td><span class="item-text-value"><?php echo $details['id']; ?></span></td>
                            </tr>
                            <tr>
                                <td><span class=" item-text-head"><b>Name</b></span></td>
                                <td><span class="item-text-value"><?php echo ucfirst($details['first_name']) . ' ' . ucfirst($details['last_name']); ?></span></td>
                            </tr>
                            <tr>
                                <td><span class=" item-text-head"><b>Email</b></span></td>
                                <td><span class="item-text-value"><?php echo $details['email']; ?></span></td>
                            </tr>
                            <tr>
                                <td><span class=" item-text-head"><b>Mobile No</b></span></td>
                                <td><span class="item-text-value"><?php echo $details['mobile_number']; ?></span></td>
                            </tr>
                            <tr>
                                <td><span class="item-text-head"><b>Gender</b> </span></td>
                                <td><span class="item-text-value"><?php echo ucfirst($details['gender']); ?></span>
                                </td>
                            </tr>
                            <tr>
                                <td><span class="item-text-head"><b>D O B</b> </span></td>
                                <td><span class="item-text-value"><?php echo date("d M Y", $details['date_of_birth']); ?></span>
                                </td>
                            </tr>
                            <tr>
                                <td><span class="item-text-head"><b>Occupation</b> </span></td>
                                <td><span class="item-text-value"><?php echo ucfirst($details['occupation']); ?></span>
                                </td>
                            </tr>
                            <tr>
                                <td><span class="item-text-head"><b>Category</b> </span></td>
                                <td><span class="item-text-value"><?php echo ucfirst($details['category']); ?></span>
                                </td>
                            </tr>

                            <tr>
                                <td><span class="item-text-head"><b>Passport Number</b> </span></td>
                                <td><span class="item-text-value"><?php echo $details['passport_number']; ?></span>
                                </td>
                            </tr>

                            <tr>
                                <td><span class="item-text-head"><b>Passport Expiry Date</b> </span></td>
                                <td><span class="item-text-value"><?php echo date("d M Y", $details['passport_expiry_date']); ?></span>
                                </td>
                            </tr>

                            <tr>
                                <td><span class="item-text-head"><b>Created</b> </span></td>
                                <td><span class="item-text-value"><?php echo date_created_format($details['created']); ?></span></td>
                            </tr>

                          

                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
<?php } else {
    echo "<p class='text_center'>No data is available. Please try again later</p>";
} ?>