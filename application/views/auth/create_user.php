<div class="row">
  <div class="col-md-offset-3 col-md-6">

  <h1><?php echo lang('create_user_heading');?></h1>
  <p><?php echo lang('create_user_subheading');?></p>

  <?php 
    echo ($message != ''? '<div class="alert alert-danger">'.$message.'</div>': '');
  ?>

  <?php echo form_open("auth/create_user",['id'=>"nuevoUsuario"]);?>

    <p>
          <?php echo lang('create_user_fname_label', 'first_name');?> <br />
          <?php echo form_input($first_name, '', ["class"=>"form-control"]);?>
    </p>

    <p>
          <?php echo lang('create_user_lname_label', 'last_name');?> <br />
          <?php echo form_input($last_name, '', ["class"=>"form-control"]);?>
    </p>

    <?php
    if($identity_column!=='email') {
        echo '<p>';
        echo lang('create_user_identity_label', 'identity');
        if($identity['value'] != '')
          echo '<br />'.'<div class="alert alert-warning">'.lang('create_user_validation_identity_error_message').'</div>';
        echo form_input($identity, '', ["class"=>"form-control"]);
        echo '</p>';
    }
    ?>

    <p>
          <?php echo lang('create_user_company_label', 'company');?> <br />
          <?php echo form_input($company, '', ["class"=>"form-control"]);?>
    </p>

    <p>
          <?php echo lang('create_user_email_label', 'email');?> <br />
          <?php echo form_input($email, '', ["class"=>"form-control"]);?>
    </p>

    <p>
          <?php echo lang('create_user_phone_label', 'phone');?> <br />
          <?php echo form_input($phone, '', ["class"=>"form-control"]);?>
    </p>

    <p>
          <?php echo lang('create_user_password_label', 'password');?> <br />
          <?php echo form_input($password, '', ["class"=>"form-control"]);?>
    </p>

    <p>
          <?php echo lang('create_user_password_confirm_label', 'password_confirm');?> <br />
          <?php echo form_input($password_confirm, '', ["class"=>"form-control"]);?>
    </p>


    <div class="btn-group" role="group" aria-label="...">
      <?php echo form_submit('submit', lang('create_user_submit_btn'), ["class"=>"btn btn-primary"]);?>
      <?php echo form_button('cancel', 'Cancelar', ["onclick"=>"window.location.href = base_url+'auth/';", "class"=>"btn btn-danger"]);?>
    </div>

  <?php echo form_close();?>

  </div><!--Div COLUMN -->
</div><!--Div ROW -->