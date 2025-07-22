<style>
    .back-praveen-danger {
        border-bottom: 3px solid #af0909 !important;
    }

    .card-body {
        padding: 10px !important;
    }

    .praveen-border {
        border: solid #af0909 2px !important;
        border-radius: 5px;
    }

    .tab-content {
        display: none;
    }
</style>
<div class="content">
    <div class="page-content">
        <div class="table_title">
            <div class="sale_bar">
                <div class="row align-items-center">
                    <div class="col-md-4 mb-3 mb-lg-0">
                        <h5>Edit Page</h5>
                    </div>
                </div>
            </div>
        </div>
        <div class="page-content-area">
            <form action="<?php echo site_url('pages/edit-pages/' . dev_encode($id)); ?>" method="post" tts-form="true" name="edit_pages">
                <div class="card-body">
                    <ul class="tabs mb-3">
                        <li class="tab-link current btn " data-tab="content">Visa Details</li>
                        <li class="tab-link btn " data-tab="faq">FAQ</li>
                    </ul>
                    <div id="content" class="tab-content current ">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group form-mb-20">
                                    <label class="form-label">Title *</label>
                                    <input class="form-control" type="text" name="title" placeholder="Title" value="<?php echo $details['title']; ?>" onblur='tts_slug_url(this.value,"page-slug")'>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group form-mb-20">
                                    <label class="form-label">Page Slug *</label>
                                    <input class="form-control" type="text" name="slug_url" placeholder="Page Slug" id="page-slug" value="<?php echo $details['slug_url']; ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group form-mb-20">
                                    <label class="form-label">Visa categories *</label>
                                    <select class  =  "form-control" name  =  "visa_categories">
                                        <option value  = "">Please Select Vist Type</option>
                                        <option value  = "Tourist_Visa" <?php if ($details['visa_categories'] == "Tourist_Visa") {
                                                                    echo "selected";
                                                                } ?>>Tourist Visa</option>
                                        <option value  = "Student_Visa" <?php if ($details['visa_categories'] == "Student_Visa") {
                                                                    echo "selected";
                                                                } ?>>Student Visa</option>
                                        <option value  = "Business_Visa" <?php if ($details['visa_categories'] == "Business_Visa") {
                                                                    echo "selected";
                                                                } ?>>Business Visa</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group form-mb-20">
                                    <label class="form-label">Banner Image * </label>
                                    <input class="form-control" type="file" name="banner_image" placeholder="Banner Image">
                                    <span>
                                        <?php
                                        $package_img = root_url . 'uploads/pagesimage/thumbnail/' . $details['banner_image'];
                                        ?>
                                        <img src="<?= $package_img; ?>" alt="<?= $details['title']; ?>"
                                            class="tts-blog-image">
                                    </span>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group form-mb-20">
                                    <label class="form-label">Custom Url </label>
                                    <input class="form-control" type="text" name="custom_url" placeholder="Custom Url" value="<?php echo $details['custom_url']; ?>">
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group form-mb-20">
                                    <label class="form-label">Page Content *</label>
                                    <textarea class="form-control tts-editornote" type="textarea" name="content" rows="3" placeholder="Content"><?php echo $details['content']; ?></textarea>
                                </div>
                            </div>
 <!--                            <div class="col-md-12">
    <div class="form-group form-mb-20">
        <label class="form-label">Feature Content1 </label>
        <input class="form-control" type="text" name="feature_content1[]" placeholder="Feature Content 1">
        <br/>
        <input class="form-control" type="text" name="feature_content1[]" placeholder="Feature Content 1">
        <br/>
        <input class="form-control" type="text" name="feature_content1[]" placeholder="Feature Content 1">
        <br/>
        <input class="form-control" type="text" name="feature_content1[]" placeholder="Feature Content 1">
        <br/>
        <input class="form-control" type="text" name="feature_content1[]" placeholder="Feature Content 1">
             </div>
</div>
         -->                   

         <div class="col-md-12">
                            <div class="form-group form-mb-20">
                                <label class="form-label">Feature Content 1 </label>
                                <?php  $i= 5;$feature_content1 = ($details['feature_content1']!="" &&!empty($details['feature_content1'])) ? json_decode($details['feature_content1'],true):[];  if(!empty($details['feature_content1'])){
                                    $totalCount  =  count($feature_content1);
                                    $i  =  $i-$totalCount;
                                } ?>
                                <?php if(!empty($feature_content1)) {  foreach($feature_content1 as $feature_content) { ?>
                                
                                    <input class="form-control" type="text" name="feature_content1[]" placeholder="Feature Content " value  = "<?php echo $feature_content;  ?>">
                                    <br/>
                                    <?php } } ?>
                               
                                <?php  for($j=$i;$j>=1;$j--) { ?>
                                <input class="form-control" type="text" name="feature_content1[]" placeholder="Feature Content">
                                <br/>
                                <?php } ?>
                                    </div>
                                </div>

         <div class="col-md-12">
                                <div class="form-group form-mb-20">
                                    <label class="form-label">Feature Content2 </label>
                                    <textarea class="form-control tts-editornote" type="textarea" name="feature_content2" rows="3" placeholder="Content"><?php echo $details['feature_content2']; ?></textarea>
                                </div>
                            </div>
                            <div class="col-md-6 dnone">
                                <div class="form-group form-mb-20">
                                    <label class="form-label"> Status *</label>
                                    <select class="form-select" name="status" placeholder="Blog Status">
                                        <option value="active" <?php if ($details['status'] == "active") {
                                                                    echo "selected";
                                                                } ?>>Active
                                        </option>
                                        <option value="inactive" <?php if ($details['status'] == "inactive") {
                                                                        echo "selected";
                                                                    } ?>> Inactive
                                        </option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group form-mb-20">
                                    <label class="form-label">Meta Robots *</label>
                                    <select class="form-select" name="meta_robots" placeholder="Meta Robots">
                                        <option value="INDEX, FOLLOW" <?php if ($details['status'] == "INDEX, FOLLOW") {
                                                                            echo "selected";
                                                                        } ?>>INDEX, FOLLOW
                                        </option>
                                        <option value="NOINDEX, FOLLOW" <?php if ($details['status'] == "NOINDEX, FOLLOW") {
                                                                            echo "selected";
                                                                        } ?>>NOINDEX, FOLLOW
                                        </option>
                                        <option value="INDEX, NOFOLLOW" <?php if ($details['status'] == "INDEX, NOFOLLOW") {
                                                                            echo "selected";
                                                                        } ?>>INDEX, NOFOLLOW
                                        </option>
                                        <option value="NOINDEX, NOFOLLOW" <?php if ($details['status'] == "NOINDEX, NOFOLLOW") {
                                                                                echo "selected";
                                                                            } ?>>NOINDEX, NOFOLLOW
                                        </option>
                                    </select>
                                </div>
                            </div>


                            <div class="col-md-12">
                                <div class="form-group form-mb-20">
                                    <label class="form-label"> Meta Title * </label>
                                    <input class="form-control" type="text" name="meta_title" placeholder="Meta Title" value="<?php echo $details['meta_title']; ?>">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group form-mb-20">
                                    <label class="form-label"> Meta Keyword* </label>
                                    <textarea class="form-control" type="file" name="meta_keyword" placeholder="Meta Keyword" rows="2"><?php echo $details['meta_keyword']; ?></textarea>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group form-mb-20">
                                    <label class="form-label"> Meta Description* </label>
                                    <textarea class="form-control" type="file" name="meta_description" placeholder="Meta Description" rows="2"><?php echo $details['meta_description']; ?></textarea>
                                </div>
                            </div>


                        </div>
                    </div>

                    <div id="faq" class="tab-content ">
                        <div class="row mt-4">
                            <div class="col-md-6">
                                <div class="form-group form-mb-20">
                                    <label>Title *</label>
                                    <input class="form-control" type="text" name="faq_title" placeholder="title" value="<?php echo $details['faq_title']; ?>" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group form-mb-20">
                                    <label> Faq Status *</label>
                                    <select class="form-control" name="faq_status" placeholder="Flight Routes Status">
                                        <option value="active" <?php if ($details['faq_status'] == "active") {
                                                                    echo "selected";
                                                                } ?>>Active
                                        </option>
                                        <option value="inactive" <?php if ($details['faq_status'] == "inactive") {
                                                                        echo "selected";
                                                                    } ?>> Inactive
                                        </option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div style="display: contents;" id="faq-question">
                            <?php $faq_data = json_decode($details['faq_question_answer'], true);
                            if (!empty($faq_data)) {
                                for ($i = 0; $i < count($faq_data); $i++) { ?>
                                    <div class="row tts-itinerary-row">
                                        <div class="col-md-5">
                                            <div class="row align-items-center">
                                                <div class="col-md-2 text-center">
                                                    <span class="text-bold count text_wrap" get-text="" style="background: #dddddd; width: 40px; display: block; border-radius: 50%; height: 40px; line-height: 40px;"><?php echo $i + 1 ?></span>
                                                </div>
                                                <div class="col-md-10">
                                                    <div class="form-group form-mb-20">
                                                        <label>Question*</label>
                                                        <input class="form-control" type="text" name="faq_question[]" placeholder="question" value="<?php echo  $faq_data[$i]['question']; ?>" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="row align-items-center">
                                                <div class="col-11">
                                                    <div class="form-group form-mb-20">
                                                        <label>Answer *</label>
                                                        <textarea class="form-control " type="textarea" name="faq_answer[]" rows="1" placeholder="answer"><?php echo  $faq_data[$i]['answer']; ?></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-1 align-items-center">
                                            <button class="action btn-close fa fa-close" type="button" style="width: 40px; display: block;  height: 51px; line-height: 51px;" onclick="remove_more_items(this,'faq-question')"></button>
                                        </div>
                                    </div>
                                <?php }
                            } else { ?>
                                <div class="row tts-itinerary-row">
                                    <div class="col-md-5">
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
                                    <div class="col-md-6">
                                        <div class="row align-items-center">
                                            <div class="col-11">
                                                <div class="form-group form-mb-20">
                                                    <label>Answer *</label>
                                                    <textarea class="form-control" type="textarea" name="faq_answer[]" rows="1" placeholder="answer"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-1 align-items-center">
                                        <button class="action btn-close fa fa-close" type="button" style="width: 40px; display: block;  height: 51px; line-height: 51px;" onclick="remove_more_items(this,'faq-question')"></button>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                        <div class="row mb-4">
                            <div class="col-md-12 text-end">
                                <button class="badge badge-wt" onclick="add_more_items(event,'faq-question',15)"><i class="fa-solid fa-add"></i> Add Question</button>
                            </div>
                        </div>
                        
                    </div>
                    
                    <div class="row">
                        <div class="col-md-12">
                            <input class="btn btn-primary" type="submit" value="Save">
                        </div>
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const tabs = document.querySelectorAll(".tab-link");

        tabs.forEach(tab => {
            tab.addEventListener("click", function() {
                const tabId = this.getAttribute("data-tab");
                tabs.forEach(t => t.classList.remove("current"));
                this.classList.add("current");
                document.querySelectorAll(".tab-content").forEach(content => {
                    content.style.display = "none";
                });
                document.getElementById(tabId).style.display = "block";
            });
        });
        document.getElementById("content").style.display = "block";
    });
</script>