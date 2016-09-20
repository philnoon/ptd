<div class="row form-wrapper pin">

<div class="page-header"><h3><?php echo lang('us_activate'); ?></h3></div>

<div class="well shallow-well">
    <?php echo lang('us_user_activate_note'); ?>
</div>

<?php echo form_open($this->uri->uri_string(), array('role' => "form", 'autocomplete' => 'off')); ?>
    <div class="form-group <?php echo iif( form_error('code') , 'has-error') ;?>">
        <input type="text" class="form-control input-lg" id="code" name="code" value="<?php echo set_value('code') ?>" placeholder="Activation Code"/>
    </div>
    
    <button type="submit" class="btn btn-lg btn-primary btn-block" name="submit" value="1"><?php echo lang('us_confirm_activate_code') ?></button>                
<?php echo form_close(); ?>
</div>