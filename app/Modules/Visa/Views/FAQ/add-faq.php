<style>
   .tab-content.current {
      display: inherit;
   }

   .tab-content {
      display: none;
      background: #ffffff;
      padding: 30px 30px;
      border: 2px solid #d0d062;
      margin-top: -2px;
   }

   ul.tabs {
      margin: 0;
      padding: 0;
      list-style: none;
      display: flex;
   }

   ul.tabs li {
      color: #fff;
      text-transform: uppercase;
      letter-spacing: 0.44px;
      font-weight: bold;
      display: inline-block;
      padding: 10px 20px;
      display: block;
      text-decoration: none;
      transition: 0.5s all;
      background: #d0d062;
      border: 2px solid #d0d062;
      border-bottom: 0;
      cursor: pointer;
   }
</style>
<div class="content">
   <div class="page-content">
      <div class="table_title">
         <div class="sale_bar">
            <div class="row align-items-center">
               <div class="col-md-4 mb-3 mb-lg-0">
                  <h5>Add FAQ Page</h5>
               </div>
               <div class="col-md-8 text-end">
                  <a href="<?php echo site_url('visa/faq/') . dev_encode($visa_detail_id); ?>">
                     <button class="badge badge-wt">FAQ List</button></a>
               </div>
            </div>
         </div>
      </div>
      <div class="page-content-area">
         <form action="<?php echo site_url('visa/add-faq-saved/') . dev_encode($visa_detail_id); ?>" method="post" tts-form="true" name="add_faq">
            <div class="card-body">
               <div id="faq" class="tab-content current ">
                  <div class="row mt-4">
                     <div class="col-md-4">
                        <div class="form-group form-mb-20">
                           <label>Title *</label>
                           <input class="form-control" type="text" name="title" placeholder="title" />
                        </div>
                     </div>
                     <div class="col-md-4">
                        <div class="form-group form-mb-20">
                           <label> Faq Status *</label>
                           <select class="form-select" name="status" placeholder=" Status">
                              <option value="active" selected>Active</option>
                              <option value="inactive"> Inactive</option>
                           </select>
                        </div>
                     </div>
                     <div class="col-md-4">
                        <div class="form-group form-mb-20">
                           <label>Select Visa Country *</label>
                           <select class="form-select abhay_select_search" name="visa_country_code">
                              <option value='' selected="selected">Select Visa Country</option>
                              <?php if ($country) {
                                 foreach ($country as $data) { ?>
                                    <option value="<?php echo $data['CountryId'] ?>">
                                       <?php echo $data['CountryName']; ?>
                                    </option>
                              <?php }
                              } ?>
                           </select>
                        </div>
                     </div>
                  </div>

                  <div class="row mb-4">
                     <div class="col-md-12">
                        <button class="badge badge-wt" onclick="add_more_items(event,'faq-question',15)"><i class="fa-solid fa-add"></i> Add Question</button>
                     </div>
                  </div>
                  <div style="display: contents;" id="faq-question">
                     <div class="row tts-itinerary-row align-items-center">
                        <div class="col-md-6">
                           <div class="row align-items-center">
                              <div class="col-md-2 text-center">
                                 <span class="text-bold count text_wrap" get-text="" style="background: #dddddd; width: 40px; display: block; border-radius: 50%; height: 40px; line-height: 40px;">1</span>
                              </div>
                              <div class="col-md-10">
                                 <div class="form-group form-mb-20">
                                    <label>Question*</label>
                                    <input class="form-control" type="text" name="faq_question[]" placeholder="question" />
                                 </div>
                              </div>
                           </div>
                        </div>
                        <div class="col-md-5">
                           <div class="row align-items-center">
                              <div class="col-11">
                                 <div class="form-group form-mb-20">
                                    <label>Answer *</label>
                                    <textarea class="form-control" type="textarea" name="faq_answer[]" rows="1" placeholder="answer"></textarea>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <div class="col-md-1">
                           <button class="action btn-close fa fa-close" onclick="remove_more_items(this,'faq-question')"></button>
                        </div>

                     </div>
                  </div>
                  <div class="row mt-3 text-end">
                     <div class="col-md-12">
                        <input class="btn btn-primary" type="submit" value="Save">
                     </div>
                  </div>
               </div>
            </div>
         </form>
      </div>
   </div>
</div>