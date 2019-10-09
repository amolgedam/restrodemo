<?php 

defined('BASEPATH') OR exit('No direct script access allowed');


class Compose extends Admin_Controller 
{
	public function __construct()
	{
		parent::__construct();

		$this->not_logged_in();

		$this->data['page_title'] = 'ZEON ERP';
		$this->load->model('model_company');
		$this->load->model('model_users');
		
		
	}

	public function index()
	{
		$this->render_template('compose/composeEmailSms/index', $this->data);
	}

	public function configEmail()
	{
		$this->render_template('compose/configEmail/index', $this->data);
	}

	public function configSms()
	{
		$this->render_template('compose/configSms/index', $this->data);
	}



}