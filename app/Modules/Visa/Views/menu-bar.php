
<ul class="lm_navigation">
    <?php if (permission_access("Visa", "visa_country_list") ) {  ?>
    <li class="lm_navLst <?php echo active_list_mod("Visa", "visa_country_list"); ?>">
        <a href="<?php echo site_url('visa/visa-country-list'); ?>"><span>Visa Country</span></a>
    </li>
    <?php  } ?>
    <?php if (permission_access("Visa", "visa_type_list") ) {  ?>
    <li class="lm_navLst <?php echo active_list_mod("Visa", "visa_type_list"); ?>">
        <a href="<?php echo site_url('visa/visa-types-list'); ?>"><span>Visa Type</span></a>
    </li>
    <?php } ?>
    <?php if (permission_access("Visa", "visa_type_list") ) {  ?>
    <li class="lm_navLst <?php echo active_list_mod("Visa", "document_type_view"); ?>">
        <a href="<?php echo site_url('visa/document-type'); ?>"><span>Document Type</span></a>
    </li>
    <?php } ?>
</ul>

