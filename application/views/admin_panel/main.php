<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="<?php echo base_url();?>assets/images/favicon.ico">

    <title>Panel de Administración</title>

    <!-- Bootstrap core CSS -->
    <?php
    	//Del 0 al 18, es decir 19 opciones
    	$themeOptions = [
    		'cerulean',	'cosmo', 'custom',
    		'cyborg', 'darkly', 'default',
    		'flatly', 'journal', 'lumen',
    		'paper', 'readable', 'sandstone',
    		'simplex', 'slat', 'solar',
    		'spacelab', 'superhero', 'united',
    		'yeti'
    	];
    	$selectedTheme = ( (isset($theme) && is_numeric($theme))? $themeOptions[$theme]: $themeOptions[5]);
    	//Por defecto si no se envia ninguno seleccionado, se elige el 5 => 'default' que es boostrap tal cual.
    	echo '<link href="'.base_url().'assets/bootstrap/bootstrap.theme.'.$selectedTheme.'.3.3.7.min.css" rel="stylesheet">';
    ?>

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <link href="<?php echo base_url();?>assets/admin_panel/ie10-viewport-bug-workaround.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="<?php echo base_url();?>assets/admin_panel/dashboard.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->


    <!-- Other useful css files -->
    <?php
    	if(isset($css_files) && is_array($css_files))
    	{
	    	foreach ($css_files as $file)
	    	{
	    		echo '<link href="'.base_url()."assets/".$file.'" rel="stylesheet">';
	    	}
	    }
    ?>

  </head>

  <body>

	<?php require_once "header.php"; ?>

    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-3 col-md-2 sidebar">
        	<?php require_once "menu.php"; ?> 
        </div>
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
        	<?php 
        		if(!isset($contentView) || (isset($contentView) && $contentView == ''))
        			require_once "defaultContent.php";
        		else
        			$this->load->view($contentView,$data);
        	?>
        </div>
      </div>
    </div>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="<?php echo base_url();?>assets/jquery/jquery.1.12.4.min.js"><\/script>')</script>
    <script src="<?php echo base_url();?>assets/bootstrap/bootstrap.3.3.7.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="<?php echo base_url();?>assets/admin_panel/ie10-viewport-bug-workaround.js"></script>

    <script>var base_url ="<?php echo base_url();?>";</script>

    <!-- Other useful js files -->
    <?php
    	if(isset($js_files) && is_array($js_files))
    	{
	    	foreach ($js_files as $file)
	    	{
	    		echo '<script src="'.base_url().'assets/'.$file.'"></script>';
	    	}
	    }
    ?>

  </body>
</html>