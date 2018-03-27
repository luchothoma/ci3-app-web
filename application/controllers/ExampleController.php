<?php defined('BASEPATH') OR exit('No direct script access allowed');

class ExampleController extends OWN_Controller {

	public function __construct()
	{
		parent::__construct();
	}

	public function Index()
	{
		$this->panel('welcome_message');
	}
}