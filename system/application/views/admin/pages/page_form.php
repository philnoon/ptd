<script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
<script>
tinymce.init({
selector: 'textarea',theme: 'modern',plugins: ['advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker',
'searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking',
'save table contextmenu directionality emoticons template paste textcolor'
],toolbar: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | print preview media fullpage | forecolor backcolor emoticons'}); 
</script>
<div class="container-fluid wrapper">
    <form class="form-horizontal" id="form" method="post" enctype="multipart/form-data">
        <fieldset>
            <legend>
                Edit: <strong><?php echo $page->pagename; ?></strong>
            </legend>
            <input type="hidden" name="id" id="id" value="<?php echo $page->id;?>">

            <div class="form-group">
                <div class="col-xs-12">					
					<textarea rows="30" name="pagecontent" class="form-control" id="pagecontent"><?php echo $page->pagecontent; ?></textarea>				
                </div>
            </div>

            <div class="form-group">
				<div class="col-xs-9">
					<button type="submit" class="btn btn-primary" name="submit" value="1"><?php echo lang('msg_save');?></button>
				</div>
			</div>
			
        </fieldset>
    </form>
</div>