<div class="content">
    <div class="page-content">
        <div class="page-content-area"> 
            <div class="card">
                <div class="card-header text-white">Visa Ticket Upload</div>
                <div class="card-body">
                <form name="visa-upload" tts-form="true" action="<?php echo site_url('visa-upload/visa-upload-data-store') ?>" method="POST" id="visa-upload">
                    <div class="row">
                        <div class="col-md-12 ">
                            <h6 class="view_head">Basic Information</h6>
                        </div>  
                        <!--  add by Abhay this line start -->
                        <?php $markup_used_for = get_active_whitelable_business();  ?>
                        <?php if ($markup_used_for) : ?>
                            <div class="col-md-3">
                                <div class="form-group form-mb-20">
                                    <label>Business Type *</label>
                                    <select class="form-control" agent-customer="true" name="bussiness_type">
                                        <?php
                                        $LoopOutSite = array(); // Initialize
                                        foreach ($markup_used_for as $key => $data) {
                                            $LoopOutSite[] = $key; ?>
                                            <option value="<?php echo $key ?>" <?php if(isset($getVisaInfo['bussiness_type']) && $getVisaInfo['bussiness_type']== $key){ echo "selected"; } ?>><?php echo $key ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div> 
                        <?php endif ?>
                       
                        <?php if (isset($LoopOutSite)) : ?>
                            <div class="col-md-3" agent-customer-show<?= (isset($LoopOutSite[0]) && $LoopOutSite[0] == "B2B") ? '' : '=""' ?>>
                                <div class="form-group form-mb-20">
                                    <label><?= (isset($LoopOutSite[0]) && $LoopOutSite[0] == "B2B") ? 'Agent' : 'Customer' ?> Name *</label>
                                    <?php
                                        $nameValue = isset($getVisaInfo['agent_info']) ? trim($getVisaInfo['agent_info']) : (isset($getVisaInfo['customer_info']) ? $getVisaInfo['customer_info'] : "");
                                        $idValue = isset($getVisaInfo['tts_agent_info_id']) ? trim($getVisaInfo['tts_agent_info_id']) : (isset($getVisaInfo['tts_customer_info_id']) ? $getVisaInfo['tts_customer_info_id'] : "");
                                        $ttsValue = isset($getVisaInfo['tts_agent_info']) ? trim($getVisaInfo['tts_agent_info']) : (isset($getVisaInfo['tts_customer_info']) ? $getVisaInfo['tts_customer_info'] : "");
                                    ?>
                                    <input type="text" class="form-control" name="<?= (isset($LoopOutSite[0]) && $LoopOutSite[0] == "B2B") ? 'agent' : 'customer' ?>_info" value="<?= $nameValue ?>" tts-get-<?= (isset($LoopOutSite[0]) && $LoopOutSite[0] == "B2B") ? 'agent' : 'customer' ?>-info="true" tts-error-msg="Please enter search type" placeholder="<?= (isset($LoopOutSite[0]) && $LoopOutSite[0] == "B2B") ? 'Agent' : 'Customer' ?> Name" autocomplete="off">
                                    <input type="hidden" name="tts_<?= (isset($LoopOutSite[0]) && $LoopOutSite[0] == "B2B") ? 'agent' : 'customer' ?>_info_id" tts-<?= (isset($LoopOutSite[0]) && $LoopOutSite[0] == "B2B") ? 'agent' : 'customer' ?>-info-id="true" value="<?= $idValue ?>">
                                    <input type="hidden" name="tts_<?= (isset($LoopOutSite[0]) && $LoopOutSite[0] == "B2B") ? 'agent' : 'customer' ?>_info" tts-<?= (isset($LoopOutSite[0]) && $LoopOutSite[0] == "B2B") ? 'agent' : 'customer' ?>-info="true" value="<?= $ttsValue ?>">
                                    <span class="success" <?= (isset($LoopOutSite[0]) && $LoopOutSite[0] == "B2B") ? 'agent' : 'customer' ?>info="true"><?= $ttsValue ?></span>
                                </div>
                            </div>
                        <?php endif  ?> 
                    <!--  add by Abhay this line End -->
                    <?php $issueSupplier =  explode("#",isset($getVisaInfo['supplier']) ? $getVisaInfo['supplier'] : ""); ?>
                    <?php if($offline_supplier) : ?>
                        <div class="col-md-3">
                            <div class="form-group form-mb-20">
                                <label>Issue Supplier *</label>
                                <select class="form-control" name="supplier">
                                    <option value="" selected="">Select</option>
                                    <?php foreach($offline_supplier as $item) {  ?>
                                        <option value="<?php echo $item['id'];?>#<?php echo $item['supplier_name'];?>" <?php if($issueSupplier[0] == $item['id']){ echo "selected"; } ?> ><?php echo $item['supplier_name'];?></option>
                                     <?php } ?>
                                </select>
                            </div>
                        </div>    
                    <?php endif ?>


                    </div>
                    <div class="row">
                        <div class="col-md-12 ">
                                <h6 class="view_head">Visa Information</h6>
                        </div>
                    <div class="col-md-3">
                            <div class="form-group form-mb-20">
                                <label>Destinations *</label>
                                <input class="form-control" type="text" name="destinations" value="<?php if (isset($getVisaInfo['destinations'])) {  echo trim($getVisaInfo['destinations']); } ?>" placeholder="Destinations Name">
                            </div>
                        </div> 
                        <div class="col-md-3">
                            <div class="form-group form-mb-20">
                                <label>Visa Type *</label>
                                <select name="visa_type" class="form-select">
                                    <option value="">Please select Markup</option>
                                    <?php foreach ($VisaTypes as $visaitem) : ?>
                                        <option value="<?php echo $visaitem['visa_title_slug']; ?>" <?php echo (isset($getVisaInfo['visa_type']) ==  $visaitem['visa_title_slug']) ? ' selected="selected"' : '';?> ><?php echo $visaitem['visa_title']; ?> </option>
                                    <?php endforeach ?>

                                </select>
                            </div>
                        </div>
                        
                        <div class="col-md-3">
                            <div class="form-group form-mb-20">
                                <label>Travel Date *</label>
                                <input class="form-control" type="text" name="travel_date" placeholder="Travel Date" value="<?php if (isset($getVisaInfo['travel_date'])) {  echo trim($getVisaInfo['travel_date']); } ?>" readonly travel-date-calendor='true'>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group form-mb-20">
                                <label>Conformation *</label>
                                <input class="form-control" type="text" name="conformation" value="<?php if (isset($getVisaInfo['conformation'])) {  echo trim($getVisaInfo['conformation']); } ?>" placeholder="Conformation">
                            </div>
                        </div> 
                        <div class="col-md-3">  
                            <?php
                                foreach ($document_type as $ductype) {
                                    $isChecked = isset($getVisaInfo['document']) && in_array($ductype['key_source'], $getVisaInfo['document']);
                                ?>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" value="<?php echo $ductype['key_source'] ?>" <?php echo $isChecked ? 'checked' : ''; ?> name="document[]">
                                        <label class="form-check-label"><?php echo $ductype['value']; ?></label>
                                    </div>
                                <?php
                                }
                                ?>   


                        </div>
                        
                    </div>
                    <div class="row">
                    <div class="col-md-12 ">
                            <h6 class="view_head">Base Fare Information</h6>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group form-mb-20">
                                <label>Base Fare *</label>
                                <input class="form-control" type="number" name="basefare" value="<?php if (isset($getVisaInfo['basefare'])) {  echo trim($getVisaInfo['basefare']); } ?>" placeholder="Base Fare">
                            </div>
                        </div> 
                        <div class="col-md-3">
                            <div class="form-group form-mb-20">
                                <label>Tax </label>
                                <input class="form-control" type="number" name="tax" value="<?php if (isset($getVisaInfo['tax'])) {  echo trim($getVisaInfo['tax']); } ?>" placeholder="Tax">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group form-mb-20">
                                <label>Display Markup *</label>
                                <select name="markup_type" class="form-select">
                                    <option value="">Please select Markup</option>
                                    <option value="in_tax" <?php if(isset($getVisaInfo['markup_type']) == 'in_tax') echo"selected"; ?>>In Tax</option>
                                    <option value="in_service_charge"  <?php if(isset($getVisaInfo['markup_type']) == 'in_service_charge') echo"selected"; ?>>In Service Charge</option>

                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group form-mb-20">
                                <label>Markup (Per Pax) </label>
                                <input class="form-control" type="number" name="mark_per_pax" value="<?php if (isset($getVisaInfo['mark_per_pax'])) {  echo trim($getVisaInfo['mark_per_pax']); } ?>" placeholder="Markup Per Pax">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group form-mb-20">
                                <label>Discount </label>
                                <input class="form-control" type="number" name="discount" value="<?php if (isset($getVisaInfo['discount'])) {  echo trim($getVisaInfo['discount']); } ?>" placeholder="Discount ">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group form-mb-20">
                                <label>Visa Details * </label>
                                <textarea class="form-control tts-editornote" type="textarea" name="visa_details" rows="3" placeholder="Visa Details"> <?php if (isset($getVisaInfo['visa_details'])) {  echo trim($getVisaInfo['visa_details']); } ?></textarea>
                            </div>
                        </div>
                        <?php if(isset($_GET['visainfokey']) && $_GET['visainfokey']!="") { ?>
                            <input type="hidden" name="visainfokey" value="<?php echo $_GET['visainfokey'] ?>">
                        <?php } ?>
                        <div class="row">
                        <div class="col-md-12 text-end">
                            <button class="btn btn-primary" type="submit">Save </button> 
                        </div>
                    </div>
                    </div>
                </form>
            </div>
            </div>
            
        </div>
    </div>
</div>

<script>
$(document ).ready(function() {
    setTimeout(() => {
        $('.note-editable').height(120);
    }, 50);
});
</script>