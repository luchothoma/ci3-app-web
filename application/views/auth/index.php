<h1><?php echo lang('index_heading');?></h1>
<p><?php echo lang('index_subheading');?></p>

<div id="infoMessage"><?php echo $message;?></div>

<table id="tableUsers">
	<thead>
	<tr>
		<th><?php echo lang('index_fname_th');?></th>
		<th><?php echo lang('index_lname_th');?></th>
		<th><?php echo lang('index_email_th');?></th>
		<th><?php echo lang('index_groups_th');?></th>
		<th><?php echo lang('index_status_th');?></th>
		<th><?php echo lang('index_action_th');?></th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($users as $user):?>
		<tr>
            <td><?php echo htmlspecialchars($user->first_name,ENT_QUOTES,'UTF-8');?></td>
            <td><?php echo htmlspecialchars($user->last_name,ENT_QUOTES,'UTF-8');?></td>
            <td><?php echo htmlspecialchars($user->email,ENT_QUOTES,'UTF-8');?></td>
			<td>
				<?php foreach ($user->groups as $group):?>
					<?php echo anchor("auth/edit_group/".$group->id, htmlspecialchars($group->name,ENT_QUOTES,'UTF-8'), ["class"=>"btn btn-primary btn-xs"]) ;?><br />
                <?php endforeach?>
			</td>
			<td><?php echo ($user->active) ? anchor("auth/deactivate/".$user->id, lang('index_active_link'), ["class"=>"btn btn-primary btn-xs"]) : anchor("auth/activate/". $user->id, lang('index_inactive_link'), ["class"=>"btn btn-warning btn-xs"]);?></td>
			<td><?php echo anchor("auth/edit_user/".$user->id, 'Edit', ["class"=>"btn btn-primary btn-xs"]) ;?></td>
		</tr>
	<?php endforeach;?>
	</tbody>
</table>

<div>
	<div class="btn-group" role="group" aria-label="...">
	<?php echo anchor('auth/create_user', '<span class="glyphicon glyphicon-user" aria-hidden="true"></span> '.lang('index_create_user_link'), ['class'=>"btn btn-default btn-sm"]) ?>
	<?php echo anchor('auth/create_group', '<span class="glyphicon glyphicon-plus" aria-hidden="true"></span> '.lang('index_create_group_link'), ['class'=>"btn btn-primary btn-sm"]) ?>
	</div>		
</div>