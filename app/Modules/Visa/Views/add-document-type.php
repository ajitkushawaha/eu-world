
<div class="modal-header">
        <h5 class="modal-title">Add Document Type</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> 
      </div>


    <form action="<?php echo site_url('visa/add-document-type')?>" method="post" tts-form="true" name="add_document_type" enctype="multipart/form-data">

        <div class="modal-body">
            <div class="row">
                
                <div class="col-md-5">
                    <div class="form-group form-mb-20">
                        <label>Document Name *</label>
                        <input class="form-control" type="text" name="document_name" placeholder="Enter Document Name" >
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button class="btn btn-primary" type="submit">Save</button>
        </div>
    </form>

