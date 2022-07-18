<?= $this->extend('layout/admin/admin_layout') ?>

<?= $this->section('content') ?>

<form action="" method="post" id="text-editor">
    <input type="hidden" name="id" value="<?= $news['id'] ?>" />
    <div class="form-group">
        <label for="title">Title</label>
        <input type="text" name="title" class="form-control" 
            placeholder="News title" value="<?= $news['title'] ?>" required>
    </div>
    <div class="form-group">
        <textarea name="content" id="editor" class="form-control" 
        placeholder="Tulis berita disini"><?= $news['content'] ?>
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
var cb = function() { return (new Date()).getTime() }
    ClassicEditor
        .create( document.querySelector( '#editor' ),
        { 
           
            toolbar: {
                
            },
            simpleUpload: {
            // The URL that the images are uploaded to.
            uploadUrl: '<?= base_url() ?>/admin/news/uploadimage/',

                // Enable the XMLHttpRequest.withCredentials property.
                // withCredentials: true,

                // // Headers sent along with the XMLHttpRequest to the upload server.
                // headers: {
                //     'X-CSRF-TOKEN': 'CSRF-Token',
                //     Authorization: 'Bearer <JSON Web Token>'
                // }
            }
            // removePlugins: ['ImageInsert', 'ImageUpload'],
            // ckfinder: {
            //     // Upload the images to the server using the CKFinder QuickUpload command.
            //     uploadUrl: '/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images&responseType=json'
            // }
            
           
           
        } )

        .catch( error => {
            //console.error( error );
        } );
</script>
<?= $this->endSection() ?>