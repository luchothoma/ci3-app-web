<div class="row">
  <div class="col-md-offset-3 col-md-6">

		<h1><?php echo lang('create_group_heading');?></h1>
		<p><?php echo lang('create_group_subheading');?></p>

		<?php echo ($message != ''? '<div class="alert alert-danger">'.$message.'</div>': ''); ?>

		<?php echo form_open("auth/create_group");?>

		<p>
		    <?php echo lang('create_group_name_label', 'group_name');?> <br />
		    <?php echo form_input($group_name, '', ["class"=>"form-control"]);?>
		</p>

		<p>
		    <?php echo lang('create_group_desc_label', 'description');?> <br />
		    <?php echo form_input($description, '', ["class"=>"form-control"]);?>
		</p>

	    <div class="btn-group" role="group" aria-label="...">
	      <?php echo form_submit('submit', lang('create_group_submit_btn'), ["class"=>"btn btn-primary"]);?>
	      <?php echo form_button('cancel', 'Cancelar', ["onclick"=>"window.location.href = base_url+'auth/';", "class"=>"btn btn-danger"]);?>
	    </div>

	  	<?php echo form_close();?>

  	</div><!--Div COLUMN -->
</div><!--Div ROW -->