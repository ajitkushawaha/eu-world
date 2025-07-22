<div class="content ">
    <div class="page-content">
       
        <div class="card">
                 <?php echo view('\Modules\Visa\Views\menu-bar'); ?>
            <div class="card-body">
                
                        <div class="page-actions-panel mb-3">            
                            <div class="row align-items-center">
                                <div class="col-md-4">
                                    <h5 class="m-0">Document Type List</h5>
                                </div>
                                <div class="col-md-8 text-md-end">

                                <?php if(permission_access("Visa", "add_visa_document_type")) {  ?>
                                    <button class="badge badge-wt" view-data-modal="true" data-controller='visa'
                                            data-href="<?php echo site_url('visa/add-document-type-template') ?>">
                                        <i class="fa-solid fa-add"></i> Add Document Type
                                    </button>
                                <?php } ?>

                                <?php if(permission_access("Visa", "delete_visa_document_type")) {  ?>
                                    <button class="badge badge-danger badge-wt danger disable_badge" tts-disable_badge
                                       onclick="confirm_delete('formdocumentlist')"><i class="fa-solid fa-trash"></i> Delete
                                  </button>
                                <?php } ?>

                                </div>
                            </div>
                        </div>
                       

                        

                                <div class="table-responsive">
                                    <?php $trash_uri = "visa/remove-document-type"; ?>
                                    <form action="<?php echo site_url($trash_uri); ?>" method="POST" tts-form="true" id="formdocumentlist">
                                        <table class="table table-bordered table-hover">
                                            <thead class="table-active">
                                                <tr>

                                                    <th><label><input type="checkbox" name="check_all" id="selectall" /></label>
                                                    </th>

                                                    <th>S.No.</th>
                                                    <th>Document Name</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php

                                                if (!empty($list) && is_array($list)) {
                                                    foreach ($list as $key => $data) {
                                                ?>

                                                        <tr>

                                                            <td>
                                                                <label><input type="checkbox" name="checklist[]" class="checkbox" value="<?php echo $data['id']; ?>" /></label>
                                                            </td>

                                                            <td>
                                                                <?php echo ($key + 1); ?>
                                                            </td>
                                                            <td>
                                                                <?php echo $data['value']; ?>
                                                            </td>

                                                        </tr>
                                                <?php }
                                                } else {
                                                    echo "<tr> <td colspan='11' class='text_center'><b>No Document Type Found</b></td></tr>";
                                                } ?>
                                            </tbody>
                                        </table>

                                    </form>

                                </div>


                                <div class="row pagiantion_row align-items-center">
                                    <div class="col-md-6 mb-3 mb-lg-0">
                                        <p class="pagiantion_text">Page <?= $pager->getCurrentPage() ?>
                                            of <?= $pager->getPageCount() ?>,
                                            total <?= $pager->getTotal() ?> records found </p>
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
</div>