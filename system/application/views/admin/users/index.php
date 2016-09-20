<div class="admin-box">
	<h3><?php echo lang('bf_users'). ' ('.$total_users.')'; ?></h3>
	<p>This shows active or inactive accounts. Users with inactive accounts cant login.</p>
	<ul class="nav nav-tabs" >
		<li <?php echo $filter=='' ? 'class="active"' : ''; ?>><a href="<?php echo $current_url; ?>">All Users</a></li>
		<li <?php echo $filter=='inactive' ? 'class="active"' : ''; ?>><a href="<?php echo $current_url .'?filter=inactive'; ?>">Inactive</a></li>
		<li <?php echo $filter=='deleted' ? 'class="active"' : ''; ?>><a href="<?php echo $current_url .'?filter=deleted'; ?>">Deleted</a></li>
		<li class="<?php echo $filter=='role' ? 'active ' : ''; ?>dropdown">
			<a href="#" class="drodown-toggle" data-toggle="dropdown">
				By Role <?php echo isset($filter_role) ? ": $filter_role" : ''; ?>
				<b class="caret light-caret"></b>
			</a>
			<ul class="dropdown-menu">
				<li><a href="<?php e(admin_url('users?filter=role&role_id='.USER_ADMIN)) ?>">Admin</a></li>
                <li><a href="<?php e(admin_url('users?filter=role&role_id='.USER_TRAINER)) ?>">Trainer</a></li>
                <li><a href="<?php e(admin_url('users?filter=role&role_id='.USER_MEMBER)) ?>">Member</a></li>
			</ul>
		</li>
	</ul>

	<?php echo form_open($current_url .'?'. htmlentities($_SERVER['QUERY_STRING'], ENT_QUOTES, 'UTF-8')); ?>

	<table class="table table-bordered">
		<thead>
			<tr>
				<th class="column-check"><input class="check-all" type="checkbox" /></th>
				<th style="width: 3em"><?php echo lang('bf_id'); ?></th>
				<th><?php echo lang('bf_full_name'); ?></th>
				<th>Type</th>
				<th><?php echo lang('bf_email'); ?></th>
				<th style="width: 11em"><?php echo lang('us_last_login'); ?></th>
				<th style="width: 10em"><?php echo lang('us_status'); ?></th>
			</tr>
		</thead>
		<?php if (isset($users) && is_array($users) && count($users)) : ?>
		<tfoot>
			<tr>
				<td colspan="8">
					<?php echo lang('bf_with_selected') ?>
					<?php if($filter == 'deleted'):?>
					<input type="submit" name="restore" class="btn" value="<?php echo lang('bf_action_restore') ?>">
					<input type="submit" name="purge" class="btn btn-danger" value="<?php echo lang('bf_action_purge') ?>" onclick="return confirm('<?php echo lang('us_purge_del_confirm'); ?>')">
					<?php else: ?>
					<input type="submit" name="activate" class="btn" value="<?php echo lang('bf_action_activate') ?>">
					<input type="submit" name="deactivate" class="btn" value="<?php echo lang('bf_action_deactivate') ?>">
					<input type="submit" name="delete" class="btn btn-danger" id="delete-me" value="<?php echo lang('bf_action_delete') ?>" onclick="return confirm('<?php echo lang('us_delete_account_confirm'); ?>')">
					<?php endif;?>
				</td>
			</tr>
		</tfoot>
		<?php endif; ?>
		<tbody>

		<?php if (isset($users) && is_array($users) && count($users)) : ?>
			<?php foreach ($users as $user) : ?>
			<tr>
				<td>
					<input type="checkbox" name="checked[]" value="<?php echo $user->id ?>" />
				</td>
				<td><?php echo $user->id ?></td>
				<td>
					<a href="<?php echo admin_url('users/edit/'. $user->id); ?>"><?php echo $user->full_name; ?></a>
				</td>
				
				<td>
					<?php //echo $user->user_type; ?>
					
					<? 
					$type = '';
					
					if($user->user_type === 'a'){
					$type = 'Admin';
					}					
					
					if($user->user_type === 'm'){
					$type = 'Member';
					}
					
					if($user->user_type === 't'){
					$type = 'Trainer';
					}
					
					echo $type;
					?>
				</td>
				
				<td>
					<a href="mailto:<?php echo $user->email ?>"><?php echo $user->email ?></a>
				</td>
				<td>
					<?php
						if ($user->last_login != '0000-00-00 00:00:00')
						{
							echo date('M j, y g:i A', strtotime($user->last_login));
						}
						else
						{
							echo '---';
						}
					?>
				</td>
				<td><?php
					$class = '';
					switch ($user->active)
					{
						case 1:
							$class = " label-success";
							break;
						case 0:
						default:
							$class = " label-warning";
							break;

					}
					?>
					<span class="label<?php echo($class); ?>">
					<?php
						if ($user->active == 1)
						{
							echo(lang('us_active'));
						}
						else
						{
							echo(lang('us_inactive'));
						}
						?>
					</span>
				</td>
			</tr>
			<?php endforeach; ?>
		<?php else: ?>
			<tr>
				<td colspan="8">No users found that match your selection.</td>
			</tr>
		<?php endif; ?>
		</tbody>
	</table>
	<?php echo form_close(); ?>

	<?php echo $this->pagination->create_links(); ?>

</div>
