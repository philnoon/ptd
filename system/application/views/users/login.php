<div class="row form-wrapper pin">

<div class="page-header"><h3>Login with Email</h3></div>

<?php echo form_open($this->uri->uri_string(), array('class' => "form-login", 'autocomplete' => 'off')); ?>

    <div class="form-group">
        <label>Email</label>
        <input type="text" name="username" id="username" class="form-control" placeholder="Email" size="50" value="<?php echo set_value('username'); ?>">
        <?php echo form_error('username')?>
    </div>

    <div class="form-group">
        <label>Password</label>
        <input type="password" name="password" id="password" class="form-control" placeholder="Password" size="50" value="<?php echo set_value('password'); ?>">
        <?php echo form_error('password')?>
    </div>

    <div class="checkbox">
        <label><input type="checkbox" name="remember_me" value="1" <?php echo $this->input->post('remember_me') ? "checked='checked'" : ''; ?>>Remember me</label>
    </div>

    <button class="btn btn-default" type="submit" name="submit" value="1">Login</button> 
    <span class="create-account"><a href="<?php echo site_url('forgot_password') ?>">Forgot Password</a></span>
        
<?php echo form_close(); ?>

</div>