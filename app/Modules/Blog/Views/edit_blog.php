<div class="modal-header">
   <h1 class="modal-title fs-5"><?php echo 'Edit Blog Category'; ?></h1>
   <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="vewmodelhed">
    <form action="<?php echo site_url('blog/edit-blogs/' . dev_encode($blog_id)); ?>" method="post" tts-form="true" name="add_blogs" enctype="multipart/form-data">
        <div class="modal-body">
            <div class="row">
                <div class="col-6">
                    <div class="form-group">
                        <label>Blog Title *</label>
                        <input class="form-control" type="text" name="post_title" placeholder="Blog Title" onblur='tts_slug_url(this.value,"blog-slug")'
                               value="<?php echo $blog_details['post_title']; ?>">
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label>Blog Slug *</label>
                        <input class="form-control" type="text" name="post_slug" placeholder="Blog Slug" id="blog-slug" value  = "<?php echo  $blog_details['post_slug']; ?>">
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label>Blog Category *</label>
                        <select class="form-control select_search" name="category_id" placeholder="Category Name">
                            <option value="">Select Category</option>
                            <?php if ($blog_category_list) {
                                foreach ($blog_category_list as $blog_category_data) { ?>

                                    <option value="<?php echo $blog_category_data['id']; ?>" <?php if ($blog_details['category_id'] == $blog_category_data['id']) {
                                        echo "selected";
                                    } ?>> <?php echo $blog_category_data['category_name']; ?></option>
                                <?php }
                            } ?>
                        </select>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label> Blog Image * </label>
                        <input class="form-control" type="file" name="post_images" placeholder="Post Image">
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-group">
                        <label> Blog Post Description *</label>
                        <textarea class="form-control tts-editornote" type="textarea" name="post_desc" rows="3"
                                  placeholder="Blog Post Description"><?php echo $blog_details['post_desc']; ?></textarea>
                    </div>
                </div>

                <div class="col-6">
                    <div class="form-group">
                        <label>Blog Status *</label>
                        <select class="form-select" name="status" placeholder="Blog Status">
                            <option value="active" <?php if ($blog_details['status'] == "active") {
                                echo "selected";
                            } ?>>Active
                            </option>
                            <option value="inactive" <?php if ($blog_details['status'] == "inactive") {
                                echo "selected";
                            } ?>> Inactive
                            </option>
                        </select>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label>Posted By *</label>
                        <input class="form-control" type="text" value="<?php echo $blog_details['posted_by']; ?>" name="posted_by" placeholder="Posted By" >
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label>Meta Robots *</label>
                        <select class="form-select" name="meta_robots" placeholder="Meta Robots">
                            <option value="INDEX, FOLLOW" <?php if ($blog_details['status'] == "INDEX, FOLLOW") {
                                echo "selected";
                            } ?>>INDEX, FOLLOW
                            </option>
                            <option value="NOINDEX, FOLLOW" <?php if ($blog_details['status'] == "NOINDEX, FOLLOW") {
                                echo "selected";
                            } ?>>NOINDEX, FOLLOW
                            </option>
                            <option value="INDEX, NOFOLLOW" <?php if ($blog_details['status'] == "INDEX, NOFOLLOW") {
                                echo "selected";
                            } ?>>INDEX, NOFOLLOW
                            </option>
                            <option value="NOINDEX, NOFOLLOW" <?php if ($blog_details['status'] == "NOINDEX, NOFOLLOW") {
                                echo "selected";
                            } ?>>NOINDEX, NOFOLLOW
                            </option>
                        </select>
                    </div>
                </div>


                <div class="col-6">
                    <div class="form-group">
                        <label> Meta Title * </label>
                        <input class="form-control" type="text" name="meta_title" placeholder="Meta Title"
                               value="<?php echo $blog_details['meta_title']; ?>">
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-group">
                        <label> Meta Keyword* </label>
                        <textarea class="form-control" type="file" name="meta_keyword" placeholder="Meta Keyword"
                                  rows="2"><?php echo $blog_details['meta_keyword']; ?></textarea>
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-group">
                        <label> Meta Description* </label>
                        <textarea class="form-control" type="file" name="meta_description" placeholder="Meta Description" rows="2"><?php echo $blog_details['meta_description']; ?></textarea>
                    </div>
                </div>
            </div>


        </div>
        <div class="modal-footer">
            <button class="btn btn-primary" type="submit">Save</button>
        </div>
    </form>
</div>







 