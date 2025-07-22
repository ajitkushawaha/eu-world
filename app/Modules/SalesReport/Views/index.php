<style>
    .error-message {
        top: unset !important;
    }

    .query-followup {
        text-align: center;
        background: #fff;
        border-bottom: 1px solid #e4e4e4;
    }

    .lm_navigation {
        position: relative;
        display: inline-flex;
        padding: 0 10px;
        text-align: center;
    }

    .lm_navLst.active:before {
        content: "";
        width: 100%;
        position: absolute;
        left: 0;
        bottom: 0;
        height: 3px;
        background: #0167ff;
    }

    .lm_navLst a {
        padding: 15px 15px;
        font-weight: 600;
        font-size: 15px;
    }
</style>

<?php
if (isset(admin_cookie_data()['admin_comapny_detail']['whitelabel_user']) && admin_cookie_data()['admin_comapny_detail']['whitelabel_user'] == "active") {
    $whitelabel_user_status = "active";
} else {
    $whitelabel_user_status = "inactive";
}
$whitelabel_setting_data = admin_cookie_data()['whitelabel_setting_data'];


?>

<div class="content ">
    <div class="page-content">
        <div class="page-content-area">
            <div class="query-followup">
                <ul class="lm_navigation ">
                   
                    <? if ($whitelabel_user_status == "active" && isset($whitelabel_setting_data['visa_module']) && $whitelabel_setting_data['visa_module'] == "active") : ?>
                        <?php if (permission_access("Accounts", "visa_report_list")) { ?>
                            <li class="lm_navLst active">
                                <a href="<?php echo site_url("sale-result?q=Visa"); ?>">
                                    <span> Visa Report</span>
                                </a>
                            </li>
                        <?php } ?>
                    <?php endif; ?>

                </ul>
            </div>
            <?php echo $html_view; ?>
        </div>
    </div>
</div>