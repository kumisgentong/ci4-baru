<?php
$session = \Config\Services::session();
$session->set('id_user', 345);


?>

<?= $this->extend('layout/admin/admin_layout') ?>

<?= $this->section('content') ?>
   
    <form action="" method="post" id="text-editor">
    <div class="form-group">
        <label for="title">Title</label>
        <input type="text" name="title" class="form-control" placeholder="News title" required>
    </div>
    <div class="form-group">
    
    <textarea name="content" id="editor" placeholder="Tulis berita disini">
       
    </textarea>

    </div>
    <div class="form-group">
        <button type="submit" name="status" value="published" class="btn btn-primary">Publish</button>
        <button type="submit" name="status" value="draft" class="btn btn-secondary">Save to Draft</button>
    </div>
    
</form>

<script src="<?= base_url();?>/ckeditor5/build/ckeditor.js"></script>
<script src="https://ckeditor.com/apps/ckfinder/3.5.0/ckfinder.js"></script>
<script>

    ClassicEditor
        .create( document.querySelector( '#editor' ),
        { 
           
            toolbar: {
                
            },
            ckfinder: {
                // Upload the images to the server using the CKFinder QuickUpload command.
                uploadUrl: '<?= base_url() ?>/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images&responseType=json',
                option: {
                    pass: 'testVar',
                    testVar: 'nooice'
                }
            }
            
           
           
        } )

        .catch( error => {
            console.error( error );
        } );
</script>

<?= $this->endSection() ?>