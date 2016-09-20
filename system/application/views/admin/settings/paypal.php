<div class="container wrapper">
	
	<form class="form-horizontal" id="form" method="post" action="" enctype="multipart/form-data">
		<fieldset>
			<legend>
				<?php echo lang('msg_settings');?>&nbsp;-&nbsp;<?php echo lang('msg_paypal');?>
			</legend>

			<div class="form-group">
				<label class="control-label col-xs-3" for="username"><?php echo lang('msg_user_name');?></label>
				<div class="controls col-xs-9">
					<input type="text" class="form-control" name="username" id="username" value="<?php echo set_value('username', $settings['paypal.username']); ?>">
				</div>
			</div>

			<div class="form-group">
				<label class="control-label col-xs-3" for="password"><?php echo lang('msg_pwd');?></label>
				<div class="controls col-xs-9">
					<input type="password" class="form-control" name="password" id="password" value="<?php echo set_value('password', $settings['paypal.password']); ?>">
				</div>
			</div>

			<div class="form-group">
				<label class="control-label col-xs-3" for="signature"><?php echo lang('msg_signature');?></label>
				<div class="controls col-xs-9">
					<input type="text" class="form-control" name="signature" id="signature" value="<?php echo set_value('signature', $settings['paypal.signature']); ?>">
				</div>
			</div>

			<div class="form-group">
				<label class="control-label col-xs-3" for=""><?php echo lang('msg_test') ?></label>
				<div class="col-xs-9">
					<div class="checkbox">
						<label>
							<input type="radio"  class="position" name="test_mode" value="0" <?php if($settings['paypal.test_mode']=='0' || $this->input->post('test_mode')=='0'){echo 'checked="checked"';} ?>>&nbsp;<?php echo lang('msg_false'); ?></label>
						</div>
						<div class="checkbox">
							<label>
								<input type="radio" class="position" name="test_mode" value="1" <?php if($settings['paypal.test_mode']=='1' || $this->input->post('test_mode')=='1'){echo 'checked="checked"';} ?>>&nbsp;<?php echo lang('msg_true'); ?></label>
							</div>
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
			</form>
		</div>
	</div>