<div class="modal-header">
    <h5 class="modal-title">Virtual Debit Amount</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<form action="<?php echo site_url('customer/virtual-debit/' . dev_encode($details['id'])); ?>" method="post"
    tts-form="true" name="add_debit">
    <div class="modal-body">
        <div class="row">
            <div class="col-md-3">
                <div class="vi_mod_dsc">
                    <span>Name</span>
                    <span class="primary">
                        <b>
                            <?php echo $details['title'] . ' ' . $details['first_name'] . ' ' . $details['last_name']; ?>
                        </b>
                    </span>
                </div>
            </div>
            <div class="col-md-4">
                <div class="vi_mod_dsc">
                    <span>Email </span>
                    <span class="primary">
                        <b>
                            <?php echo $details['email_id'] ?>
                        </b>
                    </span>
                </div>
            </div>
            <div class="col-md-3">
                <div class="vi_mod_dsc">
                    <span>Mobile No</span>
                    <span class="primary">
                        <b>
                            <?php echo $details['mobile_no']; ?>
                        </b>
                    </span>
                </div>
            </div>
            <div class="col-md-2">
                <div class="vi_mod_dsc">
                    <span>Balance</span>
                    <span class="primary">
                        <b>
                            <?php
                            if (isset($details['balance'])) {
                                echo custom_money_format($details['balance']);
                            }
                            ?>
                        </b>
                    </span>
                </div>
            </div>
        </div>
        <hr />
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label>Debit Amount*</label>
                    <input class="form-control" type="text" name="debit" placeholder="Debit Amount">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>Action Type *</label>
                    <select name="action_type" class="form-select" tts-validatation="Required"
                        tts-error-msg="Please select action type">
                        <option value="">Please select</option>
                        <option value="deduct">Deduct</option>
                    </select>
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group">
                    <label>Service</label>
                    <?php $active_service = get_active_whitelable_service(); ?>
                    <select name="service" class="form-select" tts-error-msg="Please select service">
                        <option value="">Please select</option>
                        <?php if ($active_service) {
                            foreach ($active_service as $service) { ?>
                                <option value="<?php echo strtolower($service); ?>"><?php echo $service; ?></option>
                            <?php }
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>Service Booking Reference Number</label>
                    <input class="form-control" type="text" name="booking_reference_number"
                        placeholder="Service booking reference number">
                </div>
            </div>
            <div class="col-md-8">
                <div class="form-group">
                    <label>Remark* </label>
                    <textarea class="form-control" name="remark" placeholder="Remark" rows="1"
                        spellcheck="false"></textarea>
                </div>
            </div>
        </div>
    </div>

    <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Update</button>
    </div>
</form>