<div class="row form-wrapper pin">

<div class="page-header"><h3>Reset your password</h3></div>

<?php echo form_open($this->uri->uri_string(), array('class' => "form-login", 'autocomplete' => 'off')); ?>
    <input type="hidden" name="user_id" value="<?php echo $user->id; ?>"/>
    
    <div class="form-group <?php echo form_error('password')?'has-error':''; ?>">
        <label>Password</label>
        <input name="password" id="password" type="password" class="form-control" value="<?php echo set_value('password');?>" placeholder="Password" autofocus>
        <?php echo form_error('password')?>
    </div>

    <div class="form-group <?php echo form_error('pass_confirm')?'has-error':''; ?>">
        <label>Password Confirm</label>
        <input name="pass_confirm" id="pass_confirm" type="password" class="form-control" value="<?php echo set_value('pass_confirm');?>" placeholder="Password Confirm">
        <?php echo form_error('pass_confirm')?>
    </div>

    <button class="btn btn-default" type="submit" name="submit" value="1">Reset</button> 
        
<?php echo form_close(); ?>

</div>