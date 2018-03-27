<div class="row">
  <div class="col-md-offset-3 col-md-6">

		<h1><?php echo lang('deactivate_heading');?></h1>
		<p><?php echo sprintf(lang('deactivate_subheading'), $user->username);?></p>

		<?php echo form_open("auth/deactivate/".$user->id);?>

		<div class="checkbox">
			<label>
			<?php echo lang('deactivate_confirm_y_label', 'confirm');?>
			<input type="radio" name="confirm" value="yes" checked="checked" />
			</label>
		</div>
		<div class="checkbox">
			<label>
			<?php echo lang('deactivate_confirm_n_label', 'confirm');?>
			<input type="radio" name="confirm" value="no" />
			</label>
		</div>

		<?php echo form_hidden($csrf); ?>
		<?php echo form_hidden(array('id'=>$user->id)); ?>

	    <div class="btn-group" role="group" aria-label="...">
	      <?php echo form_submit('submit', lang('deactivate_submit_btn'), ["class"=>"btn btn-primary"]);?>
	      <?php echo form_button('cancel', 'Cancelar', ["onclick"=>"window.location.href = base_url+'auth/';", "class"=>"btn btn-danger"]);?>
	    </div>

	  	<?php echo form_close();?>

  	</div><!--Div COLUMN -->
</div><!--Div ROW -->