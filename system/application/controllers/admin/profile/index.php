<ul id="tabs" class="nav nav-tabs" data-tabs="tabs">
    <li class="active"><a href="<?php echo admin_url('profile'); ?>">Profile</a></li>
</ul>
<div id="my-tab-content" class="tab-content">
    <div class="tab-pane active">
        <div class="page-header"><h3>Personal Info</h3></div>
        
        <?php echo form_open_multipart($this->uri->uri_string(), array('class' => "form-horizontal", 'autocomplete' => 'off')); ?>
        <div class="col-xs-12 col-md-6 col-sm-6">
            <div class="form-group">
                <label class="control-label col-xs-3">Avatar</label>
                <div class="col-xs-9">
                    <img src="<?php echo user_photo($user->avt); ?>" width="100" height="100">
                </div>
            </div>
            
            <div class="form-group">
                <label class="control-label col-xs-3" for="txtName"><?php echo lang('msg_upload_avatar');?></label>
                <div class="col-xs-9">
                    <input type="file" id="avt" class="" name="avt">
                    <span style="margin-top:5px;display:block">JPEG|JPN|PNG 5MB</span>
                    
                    <?php if($user->avt!=null) { ?>
                    <input type="submit" name="delete_photo" class="btn btn-danger" value="Remove"/>
                    <?php } ?>
                </div>
            </div>
            
            <div class="form-group <?php echo form_error('full_name')?'has-error':''; ?>">
                <label class="control-label col-sm-3" for="full_name">Full Name</label>
                <div class="col-sm-9">
                    <input type="text" id="full_name" name="full_name" class="form-control" value="<?php echo set_value('full_name', $user->full_name);?>" placeholder="Full Name">
                    <?php echo form_error('full_name'); ?>       
                </div>
            </div>
            
            <div class="form-group <?php echo form_error('email')?'has-error':''; ?>">
                <label class="control-label col-sm-3" for="email">Email</label>
                <div class="col-sm-9">
                    <input type="text" id="email" name="email" class="form-control" value="<?php echo set_value('email', $user->email);?>" placeholder="Email">
                    <?php echo form_error('email'); ?>       
                </div>
            </div>
            
            <div class="form-group <?php echo form_error('phone')?'has-error':''; ?>">
                <label class="control-label col-sm-3" for="phone">Phone</label>
                <div class="col-sm-9">
                    <input type="text" id="phone" name="phone" class="form-control" value="<?php echo set_value('phone', $user->phone);?>" placeholder="Phone">
                    <?php echo form_error('phone'); ?>       
                </div>
            </div>
            
            <div class="form-group <?php echo form_error('address')?'has-error':''; ?>">
                <label class="control-label col-sm-3" for="address">Address</label>
                <div class="col-sm-9">
                    <input type="text" id="address" name="address" class="form-control" value="<?php echo set_value('address', $user->address);?>" placeholder="Address">
                    <?php echo form_error('address'); ?>       
                </div>
            </div>
            
            <?php if($current_user->user_type == USER_TRAINER) { ?>
            <div class="form-group <?php echo form_error('paypal_email')?'has-error':''; ?>">
                <label class="control-label col-sm-3" for="paypal_email">Paypal Email</label>
                <div class="col-sm-9">
                    <input type="text" id="paypal_email" name="paypal_email" class="form-control" value="<?php echo set_value('paypal_email', $user->paypal_email);?>" placeholder="Paypal Email">
                    <?php echo form_error('paypal_email'); ?>       
                </div>
            </div>
            <?php } ?>
            
            <div class="form-group">
                <label class="control-label col-sm-3"></label>
                <div class="col-sm-9">
                    <button class="btn btn-primary" type="submit" name="submit" value="1">Update</button>
                    <button class="btn btn-warning" type="reset">Reset</button>
                </div>
            </div>
        </div>
        <?php echo form_close(); ?>
    </div>
</div>