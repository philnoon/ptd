<script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
<script>
tinymce.init({
selector: 'textarea',
theme: 'modern',
menubar: false,
plugins: ['autolink link image lists charmap print preview hr anchor',
'wordcount visualchars code fullscreen insertdatetime media nonbreaking',
'save table emoticons paste textcolor'],
toolbar: 'bold italic | alignleft aligncenter alignright alignjustify | bullist numlist | link image | print preview media | forecolor emoticons'}); 
</script>

<?php echo form_open($this->uri->uri_string(), array('class' => 'form-horizontal')); ?>
    <div class="form-group <?php echo form_error('price')?'has-error':''; ?>">
        <label class="control-label col-xs-3">Price</label>
        <div class="col-xs-9">
            <input type="text" name="price" class="form-control" id="price" min="20" placeholder="Minimum is $10" value="<?php echo set_value('price'); ?>"/>
            <?php echo form_error('price'); ?>       
        </div>
    </div>
    
    <div class="form-group <?php echo form_error('address')?'has-error':''; ?>">
        <label class="control-label col-xs-3">Address</label>
        <div class="col-xs-9">
            <input type="text" name="address" class="form-control" id="address" value="<?php echo set_value('address'); ?>"/>
            <?php echo form_error('address'); ?>       
        </div>
    </div>
    
    <!--
    put in tiny mce
    -->
    <div class="form-group <?php echo form_error('message')?'has-error':''; ?>">
        <label class="control-label col-xs-3">Message</label>
        <div class="col-xs-9">
            <textarea rows="5" name="message" class="form-control" id="message"><?php echo set_value('message'); ?></textarea>
            <?php echo form_error('message'); ?>       
            <p>Word limit is 240</p>
        </div>
    </div>
    
    <?php
    //echo $current_user->trainer_status_paid;
	//echo $vcount; 
    ?>
        
    <!-- this sends payment to paypal -->
    <!-- hide this is not verified -->    
    <div class="form-group">
        <label class="control-label col-xs-3"></label>
        <div class="col-xs-9">
            <?php 
            if ($verified == 'verified' && $current_user->trainer_status_paid == 'Y'){
            echo '<button class="btn btn-default" type="submit" name="submit" value="1">Quote</button>';
            }
            ?>
            <a href="<?php echo site_url('trainer/requests'); ?>" class="btn btn-default">Back</a>
        </div>
    </div>
<?php echo form_close(); ?>