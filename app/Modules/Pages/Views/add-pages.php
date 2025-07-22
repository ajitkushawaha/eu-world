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
                        <h5>Add New Page</h5>
                    </div>
                </div>
            </div>
        </div>
        <div class="page-content-area">
            <form action="<?php echo site_url('pages/add-pages'); ?>" method="post" tts-form="true" name="add_pages">
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
                                    <input class="form-control" type="text" name="title" placeholder="Title" onblur="tts_slug_url(this.value,'page-slug')">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group form-mb-20">
                                    <label class="form-label">Page Slug *</label>
                                    <input class="form-control" type="text" name="slug_url" placeholder="Page Slug" id="page-slug">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group form-mb-20">
                                    <label class="form-label">Banner Image *</label>
                                    <input class="form-control" type="file" name="banner_image" placeholder="Image">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group form-mb-20">
                                    <label class="form-label">Visa categories </label>
                                    <select class  =  "form-control" name  =  "visa_categories">
                                        <option value  = "">Please Select Vist Type</option>
                                        <option value  = "Tourist_Visa">Tourist Visa</option>
                                        <option value  = "Student_Visa">Student Visa</option>
                                        <option value  = "Business_Visa">Business Visa</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group form-mb-20">
                                    <label class="form-label">Custom Url </label>
                                    <input class="form-control" type="text" name="custom_url" placeholder="Custom Url">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group form-mb-20">
                                    <label class="form-label">Content </label>
                                    <textarea class="form-control tts-editornote" type="textarea" name="content" rows="3" placeholder="Content"></textarea>
                                </div>
                            </div>
                            <div class="col-md-12">
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

                            <div class="col-md-12">
                                <div class="form-group form-mb-20">
                                    <label class="form-label">Feature Content2 </label>
                                    <textarea class="form-control tts-editornote" type="textarea" name="feature_content2" rows="3" placeholder="Content"></textarea>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group form-mb-20">
                                    <label class="form-label">Status *</label>
                                    <select class="form-select" name="status" placeholder="Blog Status">
                                        <option value="active" selected>Active</option>
                                        <option value="inactive"> Inactive</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group form-mb-20">
                                    <label class="form-label">Meta Robots *</label>
                                    <select class="form-select" name="meta_robots" placeholder="Meta Robots">
                                        <option value="INDEX, FOLLOW" selected>INDEX, FOLLOW</option>
                                        <option value="NOINDEX, FOLLOW">NOINDEX, FOLLOW</option>
                                        <option value="INDEX, NOFOLLOW">INDEX, NOFOLLOW</option>
                                        <option value="NOINDEX, NOFOLLOW">NOINDEX, NOFOLLOW</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group form-mb-20">
                                    <label class="form-label"> Meta Title * </label>
                                    <input class="form-control" type="text" name="meta_title" placeholder="Meta Title">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group form-mb-20">
                                    <label class="form-label"> Meta Keyword* </label>
                                    <textarea class="form-control" type="text" name="meta_keyword" placeholder="Meta Keyword" rows="2"></textarea>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group form-mb-20">
                                    <label class="form-label"> Meta Description* </label>
                                    <textarea class="form-control" type="text" name="meta_description" placeholder="Meta Description" rows="2"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="faq" class="tab-content">
                        <div class="row mt-4">
                            <div class="col-md-6">
                                <div class="form-group form-mb-20">
                                    <label>Title *</label>
                                    <input class="form-control" type="text" name="faq_title" placeholder="title" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group form-mb-20">
                                    <label> Faq Status *</label>
                                    <select class="form-control" name="faq_status" placeholder="Status">
                                        <option value="active" selected>Active</option>
                                        <option value="inactive"> Inactive</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div style="display: contents;" id="faq-question">
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
                                                <textarea class="form-control " type="textarea" name="faq_answer[]" rows="1" placeholder="answer"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-1 align-items-center">
                                    <button class="action btn-close fa fa-close" style="width: 40px; display: block;  height: 51px; line-height: 51px;" onclick="remove_more_items(this,'faq-question')"></button>
                                </div>
                            </div>
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

    function isNumberKey(evt) {
        let charCode = evt.which ? evt.which : evt.keyCode;
        let checknumber = charCode >= 48 && charCode <= 57;

        if (!checknumber) {
            const inputElement = evt.target;
            if (inputElement) {
                let errorSpan = inputElement.nextElementSibling;

                if (!errorSpan || errorSpan.tagName.toLowerCase() !== 'span') {
                    errorSpan = document.createElement('span');
                    errorSpan.classList.add('error-message');
                    inputElement.parentNode.insertBefore(errorSpan, inputElement.nextSibling);
                }

                errorSpan.textContent = 'Please enter numeric value only';
                errorSpan.style.color = 'white';
                errorSpan.style.display = 'block';

                evt.preventDefault();
            }
        }
    }
</script>