<div class="row form-wrapper pin">

<div class="page-header"><h3>Forgot Password</h3></div>

<?php echo form_open($this->uri->uri_string(), array('class' => "form-login", 'autocomplete' => 'off')); ?>
    <p>Please input your account email address. We will send link so that you can reset your password.</p>
    <div class="form-group <?php echo form_error('email')?'has-error':''; ?>">
        <label>Email</label>
        <input type="text" id="email" name="email" class="form-control" value="<?php echo set_value('email');?>" placeholder="<?php echo lang('msg_email');?>">
        <?php echo form_error('email'); ?>       
    </div>

    <button class="btn btn-default" type="submit" name="submit">Send</button>
<?php echo form_close(); ?>

</div>