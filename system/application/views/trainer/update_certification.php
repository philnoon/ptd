<div class="page-header"><h4>Update Certification</h4></div>

<?php $certs = $this->config->item('certification'); ?>

<form class="form-horizontal" id="form" method="post" action="" enctype="multipart/form-data">
    <fieldset>
    
        <?php foreach($certs as $key => $value) { ?>
        <div class="form-group">
            <label class="control-label col-xs-2" for="qual34"><?php echo $value; ?></label>
            <div class="col-xs-10">
                <input type="file" id="<?php echo $key; ?>" class="" name="<?php echo $key; ?>">
                <span style="margin-top:5px;display:block">JPEG|JPG|PNG|PDF 3MB</span>
                <!--
                <?php if($key != null) { ?><span class="label label-success">Already Exist</span><?php } ?>
            	-->
            </div>
        </div>
        <?php } ?>
        
        <div class="form-group">
            <label class="control-label col-xs-2"></label>
            <div class="col-xs-10">
                <button type="submit" class="btn btn-primary" name="submit" value="1">Update</button>                 
                <a href="<?php echo site_url('trainer/certification'); ?>" class="btn btn-warning">Back</a>
            </div>
        </div>
    </fieldset>
</form>