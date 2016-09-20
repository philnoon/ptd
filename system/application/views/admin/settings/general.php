<div class="container wrapper">
	
    <?php echo form_open($this->uri->uri_string(), array('class' => 'form-horizontal', 'id' => 'form')); ?>
		<fieldset>
		
			<legend>
				<?php echo lang('msg_settings');?>&nbsp;-&nbsp;<?php echo lang('msg_general');?>
			</legend>
			
            <div class="form-group">
                <label class="control-label col-xs-3" for="title">Site Title</label>
                <div class="controls col-xs-9">
                    <input type="text" class="form-control" name="title" id="title" value="<?php echo set_value('author', $settings['site.title']); ?>">
                </div>
            </div>
            
            <div class="form-group">
                <label class="control-label col-xs-3" for="system_email">Contact Email</label>
                <div class="controls col-xs-9">
                    <input type="text" class="form-control" name="system_email" id="system_email" value="<?php echo set_value('system_email', $settings['site.system_email']); ?>">
                </div>
            </div>
            
            <div class="form-group">
                <label class="control-label col-xs-3" for="list_limit">Page Limit</label>
                <div class="controls col-xs-9">
                    <input type="text" class="form-control" name="list_limit" id="list_limit" value="<?php echo set_value('list_limit', $settings['site.list_limit']); ?>">
                </div>
            </div>
            
            <div class="form-group">
                <label class="control-label col-xs-3" for="address">Address</label>
                <div class="controls col-xs-9">
                    <input type="text" class="form-control" name="address" id="address" value="<?php echo set_value('address', $settings['site.address']); ?>">
                </div>
            </div>
            
			<div class="form-group">
				<label class="control-label col-xs-3" for="author"><?php echo lang('msg_author');?></label>
				<div class="controls col-xs-9">
					<input type="text" class="form-control" name="author" id="author" value="<?php echo set_value('author', $settings['site.author']); ?>">
				</div>
			</div>

			<div class="form-group">
				<label class="control-label col-xs-3" for="description"><?php echo lang('msg_description');?></label>
				<div class="controls col-xs-9">
					<input type="text" class="form-control" name="description" id="description" value="<?php echo set_value('description', $settings['site.description']); ?>">
				</div>
			</div>

			<div class="form-group">
				<label class="control-label col-xs-3" for="keywords"><?php echo lang('msg_keywords');?></label>
				<div class="controls col-xs-9">
					<input type="text" class="form-control" name="keywords" id="keywords" value="<?php echo set_value('keywords', $settings['site.keywords']); ?>">
				</div>
			</div>
            
            <div class="form-group">
                <label class="control-label col-xs-3" for="copyright"><?php echo lang('msg_copyright');?></label>
                <div class="controls col-xs-9">
                    <input type="text" class="form-control" name="copyright" id="copyright" value="<?php echo set_value('copyright', $settings['site.copyright']); ?>">
                </div>
            </div>
            
			<div class="form-group">
				<div class="col-xs-9 col-xs-offset-3">
					<button type="submit" class="btn btn-primary" name="submit" value="1">
						<?php echo lang('msg_save');?>
					</button>
				</div>
			</div>
		</fieldset>
	<?php echo form_close(); ?>
</div>
</div>