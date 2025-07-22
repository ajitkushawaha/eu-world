

<div class="modal-header">
        <h5 class="modal-title">Add Visa Type</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>



    <form action="<?php echo site_url('visa/add-visa-type'); ?>" method="post" tts-form="true" name="add_visa_country" enctype="multipart/form-data">

        <div class="modal-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group form-mb-20">
                        <label> Title *</label>
                        <input class="form-control" type="text" name="visa_title" placeholder="Title" onblur='tts_slug_url(this.value,"visa-type-slug")'>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group form-mb-20">
                        <label>Slug *</label>
                        <input class="form-control" type="text" name="visa_title_slug" placeholder="Slug" id ="visa-type-slug">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group form-mb-20">
                        <label> Image * </label>
                        <input class="form-control" type="file" name="image" placeholder=" Image">
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
             <button class="btn btn-primary" type="submit">Save</button>
        </div>
    </form>

