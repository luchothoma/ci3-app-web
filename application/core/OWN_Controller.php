<?php defined('BASEPATH') OR exit('No direct script access allowed');

class OWN_Controller extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->tienePermisos();
	}

	private function tienePermisos()
	{
		if (!$this->ion_auth->logged_in())
		{
			// redirect them to the login page
			redirect('auth/login', 'refresh');
		}
	}

	protected function panel($view, $data=null,$theme='')
	{
		$this->config->load('admin_panel',true);
		$this->load->view('admin_panel/main',
			[
				'contentView' => $view,
				'theme' => ( 
					$theme=='' || !is_numeric($theme)?
					$this->config->item('selected_theme', 'admin_panel'):
					$theme
				),
				'js_files' => (isset($data['js_files']) ? $data['js_files'] : []),
				'css_files' => (isset($data['css_files']) ? $data['css_files'] : []),
				'data' => $data
			]
		);
	}

}