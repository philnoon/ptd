<ul id="tabs" class="nav nav-tabs" data-tabs="tabs">
    <li><a href="<?php echo site_url('profile'); ?>">Profile</a></li>
    <li class="active"><a href="<?php echo site_url('password'); ?>">Password</a></li>
</ul>
<div id="my-tab-content" class="tab-content">
    <div class="tab-pane active">
        <div class="page-header"><h3>Password</h3></div>
        
        <?php echo form_open($this->uri->uri_string(), array('class' => "form-horizontal", 'autocomplete' => 'off')); ?>
        <div class="col-xs-12 col-md-6 col-sm-6">
            <div class="form-group <?php echo form_error('old_password')?'has-error':''; ?>">
                <label class="control-label col-sm-3" for="old_password">Old Password</label>
                <div class="col-sm-9">
                    <input type="password" id="old_password" name="old_password" class="form-control" value="<?php echo set_value('old_password');?>" placeholder="Old Password">
                    <?php echo form_error('old_password'); ?>       
                </div>
            </div>
            
            <div class="form-group <?php echo form_error('password')?'has-error':''; ?>">
                <label class="control-label col-sm-3" for="password">Password</label>
                <div class="col-sm-9">
                    <input type="password" id="password" name="password" class="form-control" value="<?php echo set_value('password');?>" placeholder="Password">
                    <?php echo form_error('password'); ?>       
                </div>
            </div>
            
            <div class="form-group <?php echo form_error('pass_confirm')?'has-error':''; ?>">
                <label class="control-label col-sm-3" for="pass_confirm">Password Confirm</label>
                <div class="col-sm-9">
                    <input type="password" id="pass_confirm" name="pass_confirm" class="form-control" value="<?php echo set_value('pass_confirm');?>" placeholder="Password Confirm">
                    <?php echo form_error('pass_confirm'); ?>       
                </div>
            </div>
            
            <div class="form-group">
                <label class="control-label col-sm-3"></label>
                <div class="col-sm-9">
                    <button class="btn btn-default" type="submit" name="submit" value="1">Update</button>
                </div>
            </div>
        </div>
        <?php echo form_close(); ?>
    </div>
</div>