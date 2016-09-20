<div class="container-fluid wrapper">
    <form class="form-horizontal" id="form" method="post" enctype="multipart/form-data">
        <fieldset>
            <legend>
                <?php echo lang('msg_edit_users');?>
            </legend>
            <input type="hidden" name="id_post" id="id_post" value="<?php echo $user->id;?>">

            <div class="form-group">
                <label class="control-label col-xs-2" for="txtName"><?php echo lang('msg_full_name'); ?></label>
                <div class="col-xs-10">
                    <label class="control-label"><?php echo $user->full_name;?></label>
                </div>
            </div>


            <div class="form-group">
                <label class="control-label col-xs-2" for="txtName"><?php echo lang('msg_email'); ?></label>
                <div class="col-xs-10">
                    <label class="control-label"><?php echo $user->email;?></label>
                </div>
            </div>


            <div class="form-group">
                <label class="control-label col-xs-2" for="txtName"><?php echo lang('msg_phone');?></label>
                <div class="col-xs-10">
                    <label class="control-label"><?php echo $user->phone;?></label>                    
                </div>
            </div>
            
            <div class="form-group">
                <label class="control-label col-xs-2" for="txtName"><?php echo lang('msg_address'); ?></label>
                <div class="col-xs-10">
                    <label class="control-label"><?php echo $user->address;?></label>
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-xs-2" for="txtName"><?php echo lang('msg_perm');?></label>
                <div class="col-xs-10">
                    <label class="control-label"><?php echo get_user_type_name($user->user_type); ?></label>
                </div>
            </div>

            <div class="form-group">
                <div class="col-xs-10 col-xs-offset-2">
                    <a href="<?php echo admin_url('users'); ?>" class="btn btn-primary">Back</a>
                </div>
            </div>
        </fieldset>
    </form>
</div>
    