    <style>
        .carousel-control-prev,
        .carousel-control-next {
            background: #2e8c9d;
            opacity: 1;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            top: 50%;
            transform: translateY(-50%);
            border: 0;
        }

        .carousel-control-prev span,
        .carousel-control-next span {
            width: 1rem;
            height: 1rem;
        }
    </style>

    <div class="content">
        <div class="page-content">
            <?php echo view('\Modules\Setting\Views\top_menu_bar'); ?>
            <div class="container-fluid p-0 mt-3">
                <div class="settings-panel">
                    <div class="page-actions-panel">
                        <div class="row">
                            <div class="col-md-6">
                                <h5 class="m0"> Settings </h5>
                            </div>
                        </div>
                    </div>
                    <!-- Add Edit Settings Modal content -->

                    <?php $country_codes = get_countary_code();
                    $email_setting = json_decode($company_details['email_setting'], true);
                    ?>

                    <form class="setting-content" name="formlead" action="<?php echo site_url('setting/update_company_setting/' . dev_encode($company_details['id'])); ?>" method="POST" tts-form='true' enctype="multipart/form-data">
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group form-mb-20">
                                        <label class="form-label">Company Name </label>
                                        <input class="form-control" type="text" value="<?php echo $company_details['company_name']; ?>" name="company_name" placeholder="Company Name">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group form-mb-20">
                                        <label class="form-label">Company GST No</label>
                                        <input class="form-control" type="text" value="<?php echo $company_details['company_gst_no']; ?>" name="company_gst_no" placeholder="Company GST No">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group form-mb-20">
                                        <label class="form-label">Company CIN No</label>
                                        <input class="form-control" type="text" value="<?php echo $company_details['company_ci_no']; ?>" name="company_ci_no" placeholder="Company CIN  No">
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group form-mb-20">
                                        <label class="form-label">Support No. </label>
                                        <input class="form-control" type="text" value="<?php echo $company_details['support_no']; ?>" name="support_no" placeholder="Support No.">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group form-mb-20">
                                        <label class="form-label">Tollfree No. </label>
                                        <input class="form-control" type="text" value="<?php echo $company_details['tollfree_no']; ?>" name="tollfree_no" placeholder="Tollfree No.">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group form-mb-20">
                                        <label class="form-label">Whatsapp No. </label>
                                        <input class="form-control" type="text" value="<?php echo $company_details['whatsapp_no']; ?>" name="whatsapp_no" placeholder="Whatsapp No.">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group form-mb-20">
                                        <label class="form-label">Support Email </label>
                                        <input class="form-control" type="text" value="<?php echo $company_details['support_email']; ?>" name="support_email" placeholder="Support Email">
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group form-mb-20">
                                        <label class="form-label">Pan Name</label>
                                        <input class="form-control" type="text" value="<?php echo $company_details['pan_name']; ?>" name="pan_name" placeholder="Pan Name">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group form-mb-20">
                                        <label class="form-label">Pan Number</label>
                                        <input class="form-control" type="text" value="<?php echo $company_details['pan_number']; ?>" name="pan_number" placeholder="Pan Number">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group form-mb-20">
                                        <label class="form-label"> Street / Address</label>
                                        <input class="form-control" type="text" value="<?php echo $company_details['address']; ?>" name="address" placeholder="Street">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group form-mb-20">
                                        <label class="form-label">Country</label>
                                        <select class="form-select" name="country">
                                            <?php if ($country_codes) {
                                                foreach ($country_codes as $country_code) { ?>
                                                    <option value="<?php echo $country_code['countryname']; ?>" <?php if ($country_code['countryname'] == $company_details['country']) {
                                                                                                                    echo "Selected";
                                                                                                                } ?>>

                                                        <?php echo $country_code['countryname']; ?>
                                                    </option>
                                            <?php }
                                            } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group form-mb-20">
                                        <label class="form-label">State</label>
                                        <input class="form-control" type="text" value="<?php echo $company_details['state']; ?>" name="state" placeholder=" State">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group form-mb-20">
                                        <label class="form-label">City</label>
                                        <input class="form-control" type="text" value="<?php echo $company_details['city']; ?>" name="city" placeholder="City">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group form-mb-20">
                                        <label class="form-label">Zip Code</label>
                                        <input class="form-control" type="text" value="<?php echo $company_details['pincode']; ?>" name="pincode" placeholder="Zip Code">
                                    </div>
                                </div>


                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="form-label">Copyright </label>
                                        <input class="form-control" type="text" name="copyright" value="<?php echo isset($company_details['copyright']) ? $company_details['copyright'] : ''; ?>" placeholder="Copyright">
                                    </div>

                                </div>

                              

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Google Analytics For Head / Chat Code & Others </label>
                                        <textarea class="form-control" name="google_analytics" rows="2"><?php echo isset($company_details['google_analytics']) ? $company_details['google_analytics'] : ''; ?> </textarea>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Google Analytics For Body </label>
                                        <textarea class="form-control" name="google_analytics_body" rows="2"><?php echo isset($company_details['google_analytics_body']) ? $company_details['google_analytics_body'] : ''; ?> </textarea>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group form-mb-20">
                                        <label class="form-label">Google Place API Key</label>
                                        <input class="form-control" type="text" name="google_places_api_key" value="<?php echo $company_details['google_places_api_key']; ?>" placeholder="Google Place API Key">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Google Map (Embed URL)</label>
                                        <textarea class="form-control" name="google_map" rows="2"><?php echo isset($company_details['google_map']) ? $company_details['google_map'] : ''; ?> </textarea>
                                    </div>
                                </div>


                            </div>


                            
                            <div class="row pb-3">
                                <div class="col-md-12 ">
                                    <h6 class="view_head"><?php echo ucwords('social media authentication credential'); ?></h6>
                                </div> 
                                <div class="col-md-6">
                                     <div class="form-group form-mb-20">
                                        <label class="form-label">Login With Google API Key</label>
                                        <input class="form-control" type="text" name="google_login_auth_key" value="<?php echo isset($company_details['google_login_auth_key']) ? $company_details['google_login_auth_key'] : ""; ?>" placeholder="Google auth api key">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                     <div class="form-group form-mb-20">
                                        <label class="form-label">Login With Facebook API Key</label>
                                        <input class="form-control" type="text" name="facebook_login_auth_key" value="<?php echo isset($company_details['facebook_login_auth_key']) ? $company_details['facebook_login_auth_key'] : ''; ?>" placeholder="Facebook auth api key">
                                    </div>
                                
                                </div>
                            </div> 



                            <?php if (isset($whitelable_setting['is_direct_website']) && $whitelable_setting['is_direct_website'] == 'active') : ?>
                                <div class="row">
                                    <div class="col-md-12 ">
                                        <h6 class="view_head">Pre Fix Setting </h6>
                                    </div>

                                    <?php if ($whitelable_setting['b2b_business'] == 'active') { ?>
                                        <div class="col-md-3">
                                            <div class="form-group form-mb-20">
                                                <label class="form-label">Agent Pre Fix </label>
                                                <input class="form-control" type="text" value="<?php echo $company_details['agent_pre_fix']; ?>" name="agent_pre_fix" placeholder="Agent Pre Fix">
                                            </div>
                                        </div>
                                    <?php } ?>

                                    <?php if ($whitelable_setting['b2c_business'] == 'active') { ?>
                                        <div class="col-md-3">
                                            <div class="form-group form-mb-20">
                                                <label class="form-label">Customer Pre Fix </label>
                                                <input class="form-control" type="text" value="<?php echo $company_details['customer_pre_fix']; ?>" name="customer_pre_fix" placeholder="Customer Pre Fix">
                                            </div>
                                        </div>
                                    <?php } ?>

                                    <?php if ($whitelable_setting['splr_business'] == 'active') { ?>
                                        <div class="col-md-3">
                                            <div class="form-group form-mb-20">
                                                <label class="form-label">Supplier Pre Fix </label>
                                                <input class="form-control" type="text" value="<?php echo $company_details['supplier_pre_fix']; ?>" name="supplier_pre_fix" placeholder="Supplier Pre Fix">
                                            </div>
                                        </div>
                                    <?php } ?>

                                    <?php if ($whitelable_setting['dist_business'] == 'active') { ?>
                                        <div class="col-md-3">
                                            <div class="form-group form-mb-20">
                                                <label class="form-label">Distributor Pre Fix </label>
                                                <input class="form-control" type="text" value="<?php echo $company_details['distributor_pre_fix']; ?>" name="distributor_pre_fix" placeholder="Distributor Pre Fix">
                                            </div>
                                        </div>
                                    <?php } ?>

                                    <?php $activeservices = get_active_whitelable_service();
                                    if ($activeservices) {
                                        foreach ($activeservices as $activeservice) {
                                            
                                            $name = $activeservice != "Flight" ? strtolower($activeservice) . "_pre_fix" : 'pre_fix';
                                            $placeholder = ucfirst($activeservice) . " Pre Fix";
                                    ?>

                                            <div class="col-md-3">
                                                <div class="form-group form-mb-20">
                                                    <label class="form-label">
                                                        <?php echo $placeholder; ?>
                                                    </label>
                                                    <input class="form-control" type="text" value="<?php echo $company_details[$name]; ?>" name="<?php echo $name; ?>" placeholder="<?php echo $placeholder; ?>">
                                                </div>
                                            </div>
                                    <?php }
                                    } ?>

                                </div>
                            <?php endif ?>
                            <div class="row pb-3">
                                <div class="col-md-12 ">
                                    <h6 class="view_head">Logo and Favicon Setting </h6>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="form-label">Logo</label>
                                        <input class="form-control" type="file" name="company_logo" placeholder="Logo">
                                    </div>

                                    <?php if ($company_details['company_logo']) { ?>
                                        <a href="<?php echo root_url . 'uploads/logo/'; ?><?php echo $company_details['company_logo']; ?>" target="_blank">
                                            <img src="<?php echo root_url . 'uploads/logo/'; ?><?php echo $company_details['company_logo']; ?>" class="img-thumbnail w-100">
                                        </a>
                                    <?php } ?>

                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="form-label">Favicon ( Favicon Icon Size 128 * 128 )</label>
                                        <input class="form-control" type="file" name="company_favicon" placeholder="Favicon">
                                    </div> 
                                    <?php if ($company_details['company_favicon']) { ?>
                                        <a href="<?php echo root_url . 'uploads/favicon/'; ?><?php echo $company_details['company_favicon']; ?>" target="_blank">
                                            <img src="<?php echo root_url . 'uploads/favicon/'; ?><?php echo $company_details['company_favicon']; ?>" class="img-thumbnail" style="height: 50px;object-fit: cover;width: 50px;">
                                        </a>
                                    <?php } ?>
                                </div> 
                            </div>  

                            
                            <?php if (!empty($Website_theme_setting)) :  ?>
                                <?php $path = str_replace('/home/nexes/public_html/', 'https://www.', str_replace('whitelabel', '', $_SERVER['DOCUMENT_ROOT'])); ?>
                                <div class="row gy-2 mb-4">
                                    <div class="col-md-12 ">
                                        <h6 class="view_head">Design Settings </h6>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-check">
                                            <label class="mt20">
                                                <input type="checkbox" name="default_theme" value="0" class="Lead form-check-input" <?php if($whitelable_setting['selected_template'] == 0){ echo "checked" ;} ?> >Default Theme 
                                            </label>
                                        </div>
                                    </div>
                                     
                                    <div class="col-xl-12">
                                        <div id="headertemplate" class="carousel slide" data-ride="carousel" data-interval="false">
                                            <div class="carousel-inner">
                                                <?php for ($i = 0; $i < ceil(count($Website_theme_setting) / 4); $i++) : ?>
                                                    <div class="carousel-item <?php if ($i == 0) echo 'active'; ?>">
                                                        <div class="row">
                                                            <?php for ($x = $i * 4; $x < min(count($Website_theme_setting), ($i + 1) * 4); $x++) : ?> <?php  $selectedThemes = array($whitelable_setting['selected_template']); ?>
                                                                <div class="col-lg-3 col-md-6 col-sm-12">
                                                                    <div class="card custom-card overflow-hidden <?php if (in_array($Website_theme_setting[$x]['id'], $selectedThemes)) echo 'bg-success bg-opacity-50 text-white shadow'; ?> ">
                                                                        <div class="card-body p-0">
                                                                            <div class="p-4">
                                                                                <a href="javascript:void(0);" view-data-modal="true" data-controller='webpartner' data-id="<?php echo dev_encode($Website_theme_setting[$x]['id']); ?>" data-href="<?php echo site_url('/setting/website-layout-template-details/') . dev_encode($Website_theme_setting[$x]['id']); ?>">
                                                                                    <img src="<?php echo $path . "uploads/website_template/" . $Website_theme_setting[$x]['image']; ?>" class="card-img mb-3" alt="<?php echo $Website_theme_setting[$x]['title']; ?>" height="200px">
                                                                                </a>
                                                                                <h6 class="card-title fw-semibold"><?php echo $Website_theme_setting[$x]['title']; ?></h6>
                                                                                <div class="form-check form-check-md">
                                                                                    <input class="form-check-input" type="radio" value="<?php echo $Website_theme_setting[$x]['id']; ?>" name="theme_template" id="theme-template<?php echo $x + 1; ?>" <?php if (in_array($Website_theme_setting[$x]['id'], $selectedThemes)) echo 'checked'; ?>>
                                                                                    <label class="form-check-label" for="theme-template<?php echo $x + 1; ?>">Selecte Theme</label>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div> 
                                                            <?php endfor; ?> 
                                                        </div> 
                                                    </div> 
                                                <?php endfor; ?>
                                            </div>
                                           
                                            <button class="carousel-control-prev" type="button" data-bs-target="#headertemplate" data-bs-slide="prev">
                                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                <span class="visually-hidden">Previous</span>
                                            </button>
                                            <button class="carousel-control-next" type="button" data-bs-target="#headertemplate" data-bs-slide="next">
                                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                                <span class="visually-hidden">Next</span>
                                            </button> 
                                        </div>
                                    </div>
                                </div>  
                            <?php endif ?>



                            <div class="row">
                                <div class="col-md-12 ">
                                    <h6 class="view_head">Social Link Setting</h6>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group form-mb-20">
                                        <label class="form-label">Facebook Link</label>
                                        <input class="form-control" type="text" name="facebook_link" value="<?php echo $company_details['facebook_link']; ?>" placeholder="Facebook Link">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group form-mb-20">
                                        <label class="form-label">Linkedin Link</label>
                                        <input class="form-control" type="text" name="linkedin_link" value="<?php echo $company_details['linkedin_link']; ?>" placeholder="Linkedin Link">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group form-mb-20">
                                        <label class="form-label">Instagram Link</label>
                                        <input class="form-control" type="text" name="instagram_link" value="<?php echo $company_details['instagram_link']; ?>" placeholder="Instagram Link">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group form-mb-20">
                                        <label class="form-label">Twitter Link</label>
                                        <input class="form-control" type="text" name="twitter_link" value="<?php echo $company_details['twitter_link']; ?>" placeholder="Twitter Link">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group form-mb-20">
                                        <label class="form-label">Youtube Link</label>
                                        <input class="form-control" type="text" name="youtube_link" value="<?php echo $company_details['youtube_link']; ?>" placeholder="Youtube Link">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 ">
                                    <h6 class="view_head">Email Settings </h6>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group form-mb-20">
                                        <label class="form-label">Mailer</label>
                                        <select class="form-select" name="email_setting[mailer]">
                                            <option value="G-Mail" <?php if ($email_setting['mailer'] == 'G-Mail') {
                                                                        echo "Selected";
                                                                    } ?>>G-Mail</option>
                                            <option value="G-Suite" <?php if ($email_setting['mailer'] == 'G-Suite') {
                                                                        echo "Selected";
                                                                    } ?>>G-Suite</option>
                                            <option value="Amazon" <?php if ($email_setting['mailer'] == 'Amazon') {
                                                                        echo "Selected";
                                                                    } ?>>Amazon</option>
                                            <option value="Outlook" <?php if ($email_setting['mailer'] == 'Outlook') {
                                                                        echo "Selected";
                                                                    } ?>>Outlook</option>
                                            <option value="Yahoo" <?php if ($email_setting['mailer'] == 'Yahoo') {
                                                                        echo "Selected";
                                                                    } ?>>Yahoo</option>
                                            <option value="ICloud" <?php if ($email_setting['mailer'] == 'ICloud') {
                                                                        echo "Selected";
                                                                    } ?>>ICloud</option>
                                            <option value="Other" <?php if ($email_setting['mailer'] == 'Other') {
                                                                        echo "Selected";
                                                                    } ?>>Other SMTP</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group form-mb-20">
                                        <label class="form-label">SMTP Server</label>
                                        <input class="form-control" type="text" name="email_setting[mail_server]" value="<?php echo $email_setting['mail_server']; ?>" placeholder="SMTP Server">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group form-mb-20">
                                        <label class="form-label">Port Number</label>
                                        <input class="form-control" type="text" name="email_setting[port]" value="<?php echo $email_setting['port']; ?>" placeholder="Port Number">
                                    </div>
                                </div>


                                <div class="col-md-3">
                                    <div class="form-group form-mb-20">
                                        <label class="form-label">From E-Mail ID</label>
                                        <input class="form-control" type="text" name="email_setting[from_email]" value="<?php echo $email_setting['from_email']; ?>" placeholder="From E-Mail ID">
                                    </div>
                                </div>


                                <div class="col-md-3">
                                    <div class="form-group form-mb-20">
                                        <label class="form-label">E-Mail ID</label>
                                        <input class="form-control" type="text" name="email_setting[email_id]" value="<?php echo $email_setting['email_id']; ?>" placeholder="E-Mail ID">
                                    </div>
                                </div>


                                <div class="col-md-3">
                                    <div class="form-group form-mb-20">
                                        <label class="form-label">E-Mail ID Password </label>
                                        <input class="form-control" type="password" name="email_setting[mail_password]" value="<?php echo $email_setting['mail_password']; ?>" placeholder="E-Mail ID Password">
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group form-mb-20">
                                        <label class="form-label">CC Email </label>
                                        <input class="form-control" type="text" name="cc_email" value="<?php echo $company_details['cc_email']; ?>" placeholder="CC Email">
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group form-mb-20">
                                        <label class="form-label">BCC Email </label>
                                        <input class="form-control" type="text" name="bcc_email" value="<?php echo $company_details['bcc_email']; ?>" placeholder="BCC Email">
                                    </div>
                                </div>



                                <div class="col-md-12">
                                    <div class="form-group form-mb-20">
                                        <label class="form-label">Type of Encryption</label>
                                        <input class="" type="radio" name="email_setting[encrypt_type]" placeholder="SSl" value="SSL" <?php if ($email_setting['encrypt_type'] == 'SSL') {
                                                                                                                                            echo "Checked";
                                                                                                                                        } ?>> SSL
                                        <input class="" type="radio" name="email_setting[encrypt_type]" placeholder="TLS" value="TLS" <?php if ($email_setting['encrypt_type'] == 'TLS') {
                                                                                                                                            echo "Checked";
                                                                                                                                        } ?>> TLS
                                    </div>
                                </div>
                            </div>
                        
                            



                            <div class="row">
                                <div class="col-md-12 ">
                                    <h6 class="view_head">App URL Setting </h6>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group form-mb-20">
                                        <label class="form-label">Android App URL</label>
                                        <input class="form-control" type="text" name="android_app_url" value="<?php echo $company_details['android_app_url']; ?>" placeholder="Android App Url">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group form-mb-20">
                                        <label class="form-label">IOS App URL</label>
                                        <input class="form-control" type="text" name="ios_app_url" value="<?php echo $company_details['ios_app_url']; ?>" placeholder="IOS App Url">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12 ">
                                    <h6 class="view_head">SEO Stting</h6>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group form-mb-20">
                                        <label class="form-label">Meta Robots </label>
                                        <select class="form-select" name="meta_robots" placeholder="Meta Robots">
                                            <option value="INDEX, FOLLOW" <?php echo $company_details['meta_robots'] == "INDEX, FOLLOW" ? "selected" : ""; ?>>
                                                INDEX, FOLLOW</option>
                                            <option value="NOINDEX, FOLLOW" <?php echo $company_details['meta_robots'] == "NOINDEX, FOLLOW" ? "selected" : ""; ?>>
                                                NOINDEX, FOLLOW</option>
                                            <option value="INDEX, NOFOLLOW" <?php echo $company_details['meta_robots'] == "INDEX, NOFOLLOW" ? "selected" : ""; ?>>
                                                INDEX, NOFOLLOW</option>
                                            <option value="NOINDEX, NOFOLLOW" <?php echo $company_details['meta_robots'] == "NOINDEX, NOFOLLOW" ? "selected" : ""; ?>>
                                                NOINDEX, NOFOLLOW</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group form-mb-20">
                                        <label class="form-label"> Meta Title </label>
                                        <input class="form-control" type="text" name="meta_title" placeholder="Meta Title" value="<?php echo $company_details['meta_title']; ?>">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group form-mb-20">
                                        <label class="form-label"> Meta Keyword </label>
                                        <textarea class="form-control" type="text" name="meta_keyword" placeholder="Meta Keyword" rows="2" value="<?php echo $company_details['meta_keyword']; ?>"><?php echo $company_details['meta_keyword']; ?></textarea>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group form-mb-20">
                                        <label class="form-label"> Meta Description </label>
                                        <textarea class="form-control" type="text" name="meta_description" placeholder="Meta Description" rows="2" value="<?php echo $company_details['meta_description']; ?>"><?php echo $company_details['meta_description']; ?></textarea>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <?php if (permission_access("Setting", "edit_company_setting")) { ?>
                                <button type="submit" class="btn btn-primary">Save</button>
                            <?php } ?>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>