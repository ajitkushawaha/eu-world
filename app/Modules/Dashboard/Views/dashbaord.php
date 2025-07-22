<div class="page-content">
   <!--    <div class="row">
      <div class="col-lg-12">
         <h2 class="dashboard_title">Welcome to Dashboard</h2>
      </div>
   </div> -->
   <?php
   if (isset(admin_cookie_data()['admin_comapny_detail']['whitelabel_user']) && admin_cookie_data()['admin_comapny_detail']['whitelabel_user'] == "active") {
      $whitelabel_user_status = "active";
   } else {
      $whitelabel_user_status = "inactive";
   }
   $whitelabel_setting_data = admin_cookie_data()['whitelabel_setting_data'];

   ?>
   <div class="row">


      <?php if ($whitelabel_user_status == "active" && isset($whitelabel_setting_data['visa_module']) && $whitelabel_setting_data['visa_module'] == "active"): ?>
         <?php if (permission_access("Visa", "Visa_Module")): ?>
            <?php if (isset($totle_booking_cont['Visa'])) { ?>
               <div class="col-md-2">
                  <div class="card tile-stats ">
                     <a href="<?php echo site_url('visa/booking-list?source=dashboard') ?>" class="tile-pink">
                        <div class="icon"><i class="fa-brands fa-cc-visa"></i></div>
                        <div class="card-body">
                           <h3 class="">
                              <?php echo isset($totle_booking_cont['Visa']) ? $totle_booking_cont['Visa'] : '0'; ?>
                           </h3>
                           <h5 class="card-title">Visa Bookings</h5>
                        </div>
                     </a>
                  </div>
               </div>
            <?php } ?>
         <?php endif; ?>
      <?php endif; ?>

      <?php if (isset($whitelabel_setting_data['is_direct_website']) && $whitelabel_setting_data['is_direct_website'] == "active"): ?>
         <?php if (isset($available_balance['balance'])) { ?>
            <div class="col-md-2">
               <div class="card tile-stats ">
                  <a href="<?php echo site_url('webpartneraccounts/get-web-partner-account-info') ?>" class="tile-black">
                     <div class="icon"><i class="fa fa-area-chart" aria-hidden="true"></i></div>
                     <div class="card-body">
                        <h3 class="">
                           <?php echo isset($available_balance['balance']) ? $available_balance['balance'] : '0'; ?>
                        </h3>
                        <h5 class="card-title">View Account ledger</h5>
                     </div>
                  </a>
               </div>
            </div>
         <?php } ?>
      <?php endif; ?>
   </div>

   <div class="row">
      <div class="col-md-6">
         <div class="page-content-area card p-0 mb-3 ">
            <div class="bg_white">
               <div class="card-header">
                  <div class="table_title">
                     <div class="topbardash">
                        <h5>Bookings</h5>
                     </div>
                  </div>
               </div>
               <div class="table-responsive">
                  <table class="table table-bordered table-striped ">
                     <thead>
                        <tr>
                           <th>#</th>
                           <th>All Bookings </th>
                           <th>Pending </th>
                           <th>Cancelled </th>
                        </tr>
                     </thead>
                     <tbody>

                        <?php if ($whitelabel_user_status == "active" && isset($whitelabel_setting_data['visa_module']) && $whitelabel_setting_data['visa_module'] == "active"): ?>
                           <?php if (permission_access("Visa", "Visa_Module")): ?>
                              <tr>
                                 <?php if (isset($totle_booking_cont['Visa'])) { ?>
                                    <th>Visa</th>
                                    <td><a href="<?php echo site_url('visa/booking-list?source=dashboard') ?>"
                                          class="txt_led_clr"><?php echo isset($totle_booking_cont['Visa']) ? $totle_booking_cont['Visa'] : '0'; ?></a>
                                    </td>
                                 <?php } ?>
                                 <?php if (isset($commonData['Visa'])) { ?>
                                    <td><a href="<?php echo site_url('visa/booking-list?source=dashboard&bookingtype=Processing') ?>"
                                          class="txt_led_clr">
                                          <?php echo isset($commonData['Visa']['Processing']) ? $commonData['Visa']['Processing'] : '0'; ?>
                                       </a></td>
                                    <td><a href="<?php echo site_url('visa/booking-list?source=dashboard&bookingtype=Cancelled') ?>"
                                          class="txt_led_clr">
                                          <?php echo isset($commonData['Visa']['Cancelled']) ? $commonData['Visa']['Cancelled'] : '0'; ?>
                                       </a></td>
                                 <?php } ?>
                              </tr>
                           <?php endif; ?>
                        <?php endif; ?>
                     </tbody>
                  </table>
               </div>
            </div>
         </div>
         <?php // pr($CommonDataAmendment['Flight']); 
         ?>
         <div class="page-content-area card p-0 mb-3 ">
            <div class="bg_white">
               <div class="card-header">
                  <div class="table_title">
                     <div class="topbardash">
                        <h5>Amendment</h5>
                     </div>
                  </div>
               </div>
               <div class="table-responsive ">
                  <table class="table table-bordered table-striped">
                     <thead>
                        <tr>
                           <th>#</th>
                           <th>All Amendment </th>
                           <th>Requested </th>
                           <th>Approved </th>
                           <th>Rejected </th>
                           <th>Processing </th>
                        </tr>
                     </thead>
                     <tbody>

                        <?php if ($whitelabel_user_status == "active" && isset($whitelabel_setting_data['visa_module']) && $whitelabel_setting_data['visa_module'] == "active"): ?>
                           <?php if (permission_access("Visa", "Visa_Module")): ?>
                              <tr>
                                 <?php if (isset($totle_amendment_cont['Visa'])) { ?>
                                    <th>Visa</th>
                                    <td><a href="<?php echo site_url('visa/amendments?source=dashboard') ?>" class="txt_led_clr">
                                          <?php echo isset($totle_amendment_cont['Visa']) ? $totle_amendment_cont['Visa'] : '0'; ?>
                                       </a></td>
                                 <?php } ?>
                                 <?php if (isset($CommonDataAmendment['Visa'])) { ?>
                                    <td><a href="<?php echo site_url('visa/amendments?key=amendment_status&key-text=Amendment+Status&value=requested') ?>"
                                          class="txt_led_clr">
                                          <?php echo isset($CommonDataAmendment['Visa']['requested']) ? $CommonDataAmendment['Visa']['requested'] : '0'; ?>
                                       </a></td>
                                    <td><a href="<?php echo site_url('visa/amendments?key=amendment_status&key-text=Amendment+Status&value=approved') ?>"
                                          class="txt_led_clr">
                                          <?php echo isset($CommonDataAmendment['Visa']['approved']) ? $CommonDataAmendment['Visa']['approved'] : '0'; ?>
                                       </a></td>
                                    <td><a href="<?php echo site_url('visa/amendments?key=amendment_status&key-text=Amendment+Status&value=rejected') ?>"
                                          class="txt_led_clr">
                                          <?php echo isset($CommonDataAmendment['Visa']['rejected']) ? $CommonDataAmendment['Visa']['rejected'] : '0'; ?>
                                       </a></td>
                                    <td>
                                       <a href="<?php echo site_url('visa/amendments?key=amendment_status&key-text=Amendment+Status&value=processing') ?>"
                                          class="txt_led_clr"><?php echo isset($CommonDataAmendment['Visa']['processing']) ? $CommonDataAmendment['Visa']['processing'] : '0'; ?>
                                       </a>
                                    </td>
                                 <?php } ?>
                              </tr>
                           <?php endif; ?>
                        <?php endif; ?>

                      
                     </tbody>
                  </table>
               </div>
            </div>
         </div>

      </div>

      <?php $whitelabel_setting_data = admin_cookie_data()['whitelabel_setting_data']; ?>

      <div class="col-md-6">
         <?php if ($whitelabel_setting_data['b2b_business'] == "active"): ?>
            <div class="page-content-area card p-0 mb-3">
               <div class="bg_white">
                  <div class="card-header">
                     <div class="table_title">
                        <div class="topbardash d-flex align-items-center justify-content-between">
                           <h5>Pending Payment List</h5>
                           <span class="pull-right"><a href="<?php echo site_url('accounts/wl-payment-history') ?>"
                                 target="_self">View More</a></span>
                        </div>
                     </div>
                  </div>
                  <div class="table-responsive">
                     <table class="table table-bordered table-striped">
                        <thead>
                           <tr>
                              <th>Company</th>
                              <th>Ref No</th>
                              <th>Mode</th>
                              <th>Amount</th>
                              <th>Date</th>
                           </tr>
                        </thead>
                        <tbody>
                           <?php
                           if (!empty($payment_history) && is_array($payment_history)) {
                              foreach ($payment_history as $key => $data) {
                                 if ($data['status'] == 'approved') {
                                    $class = 'active-status';
                                 } else if ($data['status'] == 'rejected') {
                                    $class = 'inactive-status';
                                 } else if ($data['status'] == 'pending') {
                                    $class = 'pending-status';
                                 }

                                 ?>
                                 <tr>
                                    <td>
                                       <?php echo $data['company_name']; ?>
                                    </td>
                                    <td>
                                       <?php echo $data['bank_transaction_id']; ?>
                                    </td>
                                    <td>
                                       <?php echo $data['payment_mode']; ?>
                                       <?php if ($data['file_name']) { ?> <br />

                                          <a href="<?php echo root_url . "uploads/make_payment/" . $data['file_name']; ?>"
                                             target="<?php echo target; ?>"><?php echo 'View ' . $data['payment_mode']; ?></a>

                                       <?php } ?>
                                    </td>
                                    <td>
                                       <a href="javascript:void(0);" view-data-modal="true" data-controller='accounts'
                                          data-id="<?php echo dev_encode($data['id']); ?>"
                                          data-href="<?php echo site_url('/accounts/wl-payment-history-detail/') . dev_encode($data['id']); ?>"><i
                                             class="fa fa-inr" aria-hidden="true"></i>
                                          <?php echo custom_money_format($data['amount']); ?>
                                       </a>

                                    </td>
                                    <td>
                                       <?php
                                       if (isset($data['created'])) {
                                          echo date_created_format($data['created']);
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

            <div class="page-content-area card p-0 mb-3 ">
               <div class="bg_white">
                  <div class="card-header">
                     <div class="table_title">
                        <div class="topbardash d-flex align-items-center justify-content-between">
                           <h5>Agent Activation List</h5>
                           <span class="pull-right"><a href="<?php echo site_url('agent') ?>" target="_self">View
                                 More</a></span>
                        </div>
                     </div>
                  </div>
                  <div class="table-responsive">
                     <table class="table table-bordered table-striped">
                        <thead>
                           <tr>
                              <th>Company </th>
                              <th>Region</th>
                              <th>Status</th>
                              <th>Date</th>
                           </tr>
                        </thead>
                        <tbody>
                           <?php

                           if (!empty($agent_registered_list) && is_array($agent_registered_list)) {
                              foreach ($agent_registered_list as $data) {
                                 if ($data['status'] == 'active') {
                                    $status_class = 'active-status';
                                 } else {
                                    $status_class = 'inactive-status';
                                 }
                                 ?>
                                 <tr>
                                    <td>
                                       <a href="javascript:void(0);" class="txt_led_clr" view-data-modal="true"
                                          data-controller='dashboard' data-id="<?php echo dev_encode($data['id']); ?>"
                                          data-href="<?php echo site_url('agent/agent-details/') . dev_encode($data['id']); ?>"><?php echo ucfirst($data['company_name']); ?></a>

                                    </td>

                                    <td>
                                       <?php echo $data['state']; ?> |
                                       <?php echo $data['city']; ?> |
                                       <?php echo $data['country']; ?>

                                    </td>

                                    <td>
                                       <div class="<?php echo $status_class ?>">
                                          <?php echo ucfirst($data['status']); ?>
                                       </div>
                                    </td>
                                    <td>
                                       <?php
                                       if (isset($data['created'])) {
                                          echo date_created_format($data['created']);
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
         <?php endif; ?>
         <div class="page-content-area card p-0 mb-3 ">
            <div class="bg_white">
               <div class="card-header">
                  <div class="table_title">
                     <div class="topbardash">
                        <h5>Refunds</h5>
                     </div>
                  </div>
               </div>
               <div class="table-responsive">
                  <table class="table table-bordered table-striped">
                     <thead>
                        <tr>
                           <th>#</th>
                           <th>All Refunds </th>
                           <th>Opened Refund </th>
                           <th>Closed Refund </th>
                        </tr>
                     </thead>
                     <tbody>


                        <?php if ($whitelabel_user_status == "active" && isset($whitelabel_setting_data['visa_module']) && $whitelabel_setting_data['visa_module'] == "active"): ?>
                           <?php if (permission_access("Visa", "Visa_Module")): ?>
                              <tr>
                                 <?php if (isset($totle_amendment_cont['Visa'])) { ?>
                                    <th>Visa</th>
                                    <td><a href="<?php echo site_url('visa/refunds?source=dashboard') ?>" class="txt_led_clr">
                                          <?php echo isset($totle_amendment_cont['Visa']) ? $totle_amendment_cont['Visa'] : '0'; ?>
                                       </a></td>
                                 <?php } ?>
                                 <?php if (isset($CommonDatarefund_status['Visa'])) { ?>
                                    <td><a href="<?php echo site_url('visa/refunds?key=refund_status&key-text=Refund+Status&value=Open') ?>"
                                          class="txt_led_clr">
                                          <?php echo isset($CommonDatarefund_status['Visa']['Open']) ? $CommonDatarefund_status['Visa']['Open'] : '0'; ?>
                                       </a></td>
                                    <td><a href="<?php echo site_url('visa/refunds?key=refund_status&key-text=Refund+Status&value=Close') ?>"
                                          class="txt_led_clr">
                                          <?php echo isset($CommonDatarefund_status['Visa']['Close']) ? $CommonDatarefund_status['Visa']['Close'] : '0'; ?>
                                       </a></td>
                                 <?php } ?>
                              </tr>
                           <?php endif; ?>
                        <?php endif; ?>

                     </tbody>
                  </table>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>