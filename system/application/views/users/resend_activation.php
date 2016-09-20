<div class="row form-wrapper pin">

<div class="page-header"><h3><?php echo lang('us_activate_resend'); ?></h3></div>
<div class="well shallow-well">
    <?php echo lang('us_activate_resend_note'); ?>
</div>

<?php echo form_open($this->uri->uri_string(), array('class' => "form-login", 'autocomplete' => 'off')); ?>
    <p>Please input your account email address. We will send link so that you can reset your password.</p>
    <div class="form-group <?php echo form_error('email')?'has-error':''; ?>">
        <label>Email</label>
        <input type="text" id="email" name="email" class="form-control" value="<?php echo set_value('email');?>" placeholder="Email">
        <?php echo form_error('email'); ?>       
    </div>

    <button class="btn btn-default" type="submit" name="submit"><?php echo lang('us_activate_code_send') ?></button>
<?php echo form_close(); ?>

</div>