<div class="content ">
<div class="page-content">
   <div class="table_title">
      <div class="sale_bar">
         <div class="row align-items-center">
            <div class="col-md-4">
               <h5 class="m-0"> Visa Booking List</h5>
            </div>
            <div class="col-md-8 text-md-right">
            </div>
         </div>
      </div>
      <div class="card">
         <div class="card-body">
            <div class="row mb_10">
               <!----------Start Search Bar ----------------->
               <form class="row" action="<?php echo site_url('visa/booking-list'); ?>" method="GET" name="markup-search" onsubmit="return searchvalidateForm()">
               
                  <?php $markup_used_for = get_active_whitelable_business();  ?>
                  <?php if ($markup_used_for) : ?>
                        <div class="col-md-2">
                           <div class="form-group">
                              <label class="form-label">Business Type </label>
                              <select class="form-select" agent-customer="true" name="booking_source" onchange ='checkbookingSource(this.value)'>
                              <option value="">Select</option>
                        
                                    <?php
                                    $LoopOutSite = array(); // Initialize
                                    foreach ($markup_used_for as $key => $data) {
                                       $LoopOutSite[] = $key; ?>
                                       <option value="<?php echo $key ?>" <?php if(isset($search_bar_data['booking_source'])) { if($search_bar_data['booking_source']==$key) { echo "selected"; } } ?>><?php echo $key ?></option>
                                    <?php } ?>
                              </select>
                           </div>
                        </div>
                  <?php endif ?>
                     <div class="col-md-2">
                        <div class="form-group">
                           <label class="form-label">Select key to search by *</label>
                           <select name="key" class="form-select" onchange="tts_searchkey(this,'markup-search')" tts-validatation="Required" tts-error-msg="Please select search key">
                              <option value="">Please select</option>
                              <option value="booking_ref_number" <?php if (isset($search_bar_data['key']) && $search_bar_data['key'] == 'booking_ref_number') {
                                 echo "selected";
                                 } ?>>Booking Ref Number</option>
                              <option value="first_name" <?php if (isset($search_bar_data['key']) && $search_bar_data['key'] == 'first_name') {
                                 echo "selected";
                                 } ?>>First Name</option>
                              <option value="last_name" <?php if (isset($search_bar_data['key']) && $search_bar_data['key'] == 'last_name') {
                                 echo "selected";
                                 } ?>>Last Name</option> 
                              <option value="booking_status" <?php if (isset($search_bar_data['key']) && $search_bar_data['key'] == 'booking_status') {
                                 echo "selected";
                                 } ?>>Booking Status</option>
                              <option value="payment_status" <?php if (isset($search_bar_data['key']) && $search_bar_data['key'] == 'payment_status') {
                                 echo "selected";
                                 } ?>>Payment Status</option>
                              <option value="date-range" <?php if (isset($search_bar_data['key']) && $search_bar_data['key'] == 'date-range') {
                                 echo "selected";
                                 } ?>>Date Range</option>
                           </select>
                        </div>
                     <input type="hidden" name="key-text" value="<?php if (isset($search_bar_data['key-text'])) {
                        echo trim($search_bar_data['key-text']);
                        } ?>">
                  </div>
                  <div class="col-md-2">
                     <div class="form-group">
                        <label class="form-label"><?php if (isset($search_bar_data['key']) && $search_bar_data['key'] != 'date-range') {
                           echo $search_bar_data['key-text'] . " *";
                           } else {
                           echo "Value";
                           } ?> 
                        </label>
                        <input type="text" name="value" placeholder="Value" value="<?php if (isset($search_bar_data['value'])) {
                           echo $search_bar_data['value'];
                           } ?>" class="form-control" <?php if (isset($search_bar_data['key']) && $search_bar_data['key'] == 'date-range') {
                           echo "disabled";
                           } ?> <?php if (isset($search_bar_data['key']) && $search_bar_data['key'] == 'date-range') {
                           } else {
                               echo 'tts-validatation="Required"';
                           } ?> tts-error-msg="Please enter value" />
                     </div>
                  </div>
                  <div class="col-md-2">
                     <div class="form-group">
                        <label class="form-label">From Date</label><input type="text" data-searchbar-from="true" name="from_date" value="<?php if (isset($search_bar_data['from_date'])) {
                           echo $search_bar_data['from_date'];
                           } ?>" placeholder="Select From Date" class="form-control" tts-error-msg="Please select from date" readonly />
                     </div>
                  </div>
                  <div class="col-md-2">
                     <div class="form-group">
                        <label class="form-label">To Date</label><input type="text" data-searchbar-to="true" name="to_date" value="<?php if (isset($search_bar_data['to_date'])) {
                           echo $search_bar_data['to_date'];
                           } ?>" placeholder="Select To Date" class="form-control" tts-error-msg="Please select to date" readonly />
                     </div>
                  </div>
                  <div class="col-md-2 align-self-end">
                     <div class="form-group">
                      
                        <button type="submit" class="badge badge-md badge-primary badge_search">Search <i class="fa-solid fa-search"></i></button>
                     </div>
                  </div>
                  

                  <? if (isset($search_bar_data['key'])) : ?>
                  <div class="col-md-2 align-self-center">
                                <div class="search-reset-btn">
                                <a href="<?php echo site_url('visa/booking-list'); ?>">Reset Search</a>
                                </div>
                            </div>
                            <? endif ?>
               </form>
            </div>
            <!----------End Search Bar ----------------->
            <div class="table-responsive">
               <table class="table table-bordered table-hover">
                  <thead class="table-active">
                     <tr>
                     <?php if (permission_access("Visa", "visa_booking_detail")) { ?>
                        <th>Ref No.</th>
                        <?php }?>
                        <th>Booking Source</th> 
                        <th>Country</th>
                        <th>Visa Type</th>
                        <th>Departure Date</th>
                        <th>Booking Status</th>
                        <th>Price</th>
                        <th>Payment Status</th> 
                        <th>Type</th> 
                        <?php if (permission_access("Visa", "assign_user_booking")) { ?>
                        <th>Assign</th>
                        <?php }?> 
                        <th>Created</th>
                        <?php if (permission_access("Visa", "visa_booking_detail") || permission_access("Visa", "assign_user_booking") || permission_access("Visa", "update_booking_ticket")) { ?>
                        <th>Action</th>
                        <?php }?>
                     </tr>
                  </thead>
                  <tbody>
                     <?php
                        if (!empty($list) && is_array($list)) {
                           $count=1;
                            foreach ($list as $data) {  
                              $class = getStatusClass($data['booking_status']);
                              $payment_class = getStatusClass($data['payment_status']); 
                              $ticketData = dev_encode(json_encode(array("BookingId" => $data['id'], "BookingToken" => $data['tts_search_token'])));
                               
                     ?>
                     <tr>
                        <?php if (permission_access("Visa", "visa_booking_detail")) { ?>
                           <td><a href="<?php echo site_url('visa/visa-booking-details/').$data['booking_ref_number']?>"><?php echo $data['booking_ref_number']; ?></a> </td>
                        <?php }?>
                        <td class="text-center">
                           <?php if ($data['booking_source'] == "Wl_b2b") : ?>
                              <span><?php echo service_booking_source($data['booking_source'] ?? "") . ' - ' . $data['company_id']; ?> </span><br />
                              <a href="javascript:void(0);" class="txt_led_clr" view-data-modal="true" data-controller='agent' data-id="<?php echo dev_encode($data['wl_agent_id']); ?>" data-href="<?php echo site_url('agent/agent-details/') . dev_encode($data['wl_agent_id']); ?>"> <?php echo (isset($data['company_name']) && !empty($data['company_name'])) ? $data['company_name'] : 'NA' ?></a>
                           <?php else : ?>
                              <a href="javascript:void(0);" class="txt_led_clr" view-data-modal="true" data-controller='customer' data-id="<?php echo dev_encode($data['wl_customer_id']); ?>" data-href="<?php echo site_url('customer/customer-details/') . dev_encode($data['wl_customer_id']); ?>"> <span><?php echo service_booking_source($data['booking_source'] ?? ""); ?> </span></a>
                           <?php endif; ?>
                        </td>
                        
                        <td>
                           <?php echo $data['visa_country']?>
                        </td>
                        <td>
                        <?php echo $data['visa_type']?>
                        </td>
                        <td><?php echo date("d M Y", $data['date_of_journey']); ?></td>
                        <td>
                           <span class="<?php echo $class ?>">
                           <?php echo ucfirst($data['booking_status']); ?>
                           </span>
                        </td>
                        <td><?php echo $data['total_price']; ?></td>
                        <td>
                           <span class="<?php echo $payment_class ?>">
                           <?php echo ucfirst($data['payment_status']); ?>
                           </span>
                        </td>

                        <td>
                           <span><?php echo isset($data['is_manual']) && $data['is_manual'] == 1 ? "" : "Online"; ?></span>
                           <br/>
                           <?php 
                           if (isset($data['is_manual']) && $data['is_manual'] == 1 && isset($data['update_ticket_by']) && $data['update_ticket_by'] != null) {
                              $updateByinfo = json_decode($data['update_ticket_by'], true);
                              
                              if (is_array($updateByinfo)) {
                                    echo "Manual <br/>" . $updateByinfo['first_name'] . " " . $updateByinfo['last_name'];
                              }
                           }
                           ?>
                        </td>

 


                       
                        <?php if (permission_access("Visa", "assign_user_booking")) { ?>
                        <td>
                           <?php  if ($data['webpartner_assign_user'] != NULL && $data['webpartner_assign_user'] != '' && $data['webpartner_assign_user'] == admin_cookie_data()['admin_user_details']['id']) { ?>
                              <?php echo $data['assign_user_name']; ?><br/>
                              <?php } else if ($data['webpartner_assign_user'] != NULL && $data['webpartner_assign_user'] != '' && $data['webpartner_assign_user'] != admin_cookie_data()['admin_user_details']['id']) { ?>
                              <?php echo $data['assign_user_name']; ?><br/>
                              <?php  if ($data['booking_status'] == "Failed" || $data['booking_status'] == "Processing") { ?>
                              <a class="lead_assignbtn re_aassign"
                                 href="<?php echo site_url('/visa/assign-update-visa-ticket/') . $ticketData = dev_encode($data['booking_ref_number']); ?>"
                                 > ReAssign</a>
                              <?php } ?>
                              <?php } else {
                                 if ($data['booking_status'] == "Failed" || $data['booking_status'] == "Processing") { ?>
                              <a class="lead_assignbtn aassign flightdisablelinks"
                                 href="<?php echo site_url('/visa/assign-update-visa-ticket/') . $ticketData = dev_encode($data['booking_ref_number']); ?>"
                                 id='countdown<?php echo $count;?>'> Assign</a>
                                 <?php $timer_info=checkbookingflighttime($data['created'],'Visa');  //pr($timer_info); ?>
                                 <script>setTimeout(() => { countdown('countdown<?php echo $count;?>', <?php echo $timer_info['Minute'];?>, <?php echo $timer_info['Second'];?>); }, 100);</script>
                              <div ></div>
                              <?php }
                                 } ?>
                              <?php $count++;?>
                        </td>
                        <?php } ?>
                        <td>
                           <?php echo date_created_format($data['created']); ?>
                        </td>
                        <?php if (permission_access("Visa", "visa_booking_detail") || permission_access("Visa", "assign_user_booking") || permission_access("Visa", "update_booking_ticket")) { ?>
                        <td>
                           <?php if (permission_access("Visa", "visa_booking_detail")) { ?>
                              <a href="<?php echo site_url('visa/confirmation/' . dev_encode(json_encode(array("BookingId" => $data['id'], "BookingToken" => $data['tts_search_token'])))); ?>">View</a>
                              <?php } ?>
                              <?php if (permission_access("Visa", "update_booking_ticket")) { ?>
                           <?php if (($data['webpartner_assign_user'] != NULL && $data['webpartner_assign_user'] != '' && $data['webpartner_assign_user'] == admin_cookie_data()['admin_user_details']['id'] && $data['webpartner_assign_user'] == admin_cookie_data()['admin_user_details']['id']) || admin_cookie_data()['admin_user_details']['primary_user'] == 1) { ?>
                           <a href="<?php echo site_url('/visa/get-update-visa-voucher-info/') . $ticketData = $data['booking_ref_number']; ?>"
                              target="<?php echo target ?>"><i class="tts-icon eye"> Edit <br/></i></a>
                           <?php } ?>
                           <?php } ?>
                        </td>
                        <?php }?>
                     </tr>
                     <?php }
                        } else {
                        
                            echo "<tr> <td colspan='12' class='text-center'><b>No Booking Found</b></td></tr>";
                        
                        } ?>
                  </tbody>
               </table>
            </div>
            <div class="row pagiantion_row align-items-center">
               <div class="col-md-6 mb-3 mb-lg-0">
                  <p class="pagiantion_text">Page <?= $pager->getCurrentPage() ?>
                     of <?= $pager->getPageCount() ?>, total <?= $pager->getTotal() ?> records found 
                  </p>
               </div>
               <div class="col-md-6">
                  <?php if ($pager) : ?>
                  <?= $pager->links() ?>
                  <?php endif ?>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>