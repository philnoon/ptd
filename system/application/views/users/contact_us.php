<div class="page-header">
<h3>Contact Us</h3>
</div>
	
    <?php echo form_open($this->uri->uri_string(), array('class' => 'form-horizontal')); ?>
    <div class="form-group <?php echo form_error('name')?'has-error':''; ?>">
        <label class="control-label col-xs-3">Name</label>
        <div class="col-xs-9">
            <input type="text" name="name" class="form-control" id="name" value="<?php echo set_value('name'); ?>"/>
            <?php echo form_error('name'); ?>       
        </div>
    </div>
    
    <div class="form-group <?php echo form_error('emailaddress')?'has-error':''; ?>">
        <label class="control-label col-xs-3">Email Address</label>
        <div class="col-xs-9">
            <input type="text" name="emailaddress" class="form-control" id="emailaddress" value="<?php echo set_value('emailaddress'); ?>"/>
            <?php echo form_error('emailaddress'); ?>       
        </div>
    </div>
    
    <div class="form-group <?php echo form_error('message')?'has-error':''; ?>">
        <label class="control-label col-xs-3">Message</label>
        <div class="col-xs-9">
            <textarea rows="5" name="message" class="form-control" id="message"><?php echo set_value('message'); ?></textarea>
            <?php echo form_error('message'); ?>       
        </div>
    </div>
    
    <div class="form-group">
        <label class="control-label col-xs-3"></label>
        <div class="col-xs-9">
            <button class="btn btn-default" type="submit" name="submit" value="1">Send</button>
        </div>
    </div>
<?php echo form_close(); ?>
</div>