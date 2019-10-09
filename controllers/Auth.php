<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends Admin_Controller 
{

	public function __construct()
	{
		parent::__construct();

	    $this->load->model('model_auth');
		$this->load->model('model_company');
		$this->load->model('model_users');
		
	}

	/* 
		Check if the login form is submitted, and validates the user credential
		If not submitted it redirects to the login page
	*/
	public function login()
	{

		$this->logged_in();

		$this->form_validation->set_rules('email', 'Email', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');

        if ($this->form_validation->run() == TRUE) {
            // true case
           	$email_exists = $this->model_auth->check_email($this->input->post('email'));

           	if($email_exists == TRUE) {
           		$login = $this->model_auth->login($this->input->post('email'), $this->input->post('password'));

           		// echo "<pre>"; print_r($login); exit();
           		
           		if($login)
           		{
           			$companyImg = $this->model_company->getCompanyData(1);

	           		if($login['loginstatus'] != 0) {

	           			$logged_in_sess = array(
	           				'id' => $login['id'],
					        'username'  => $login['username'],
					        'email'     => $login['email'],
					        'firstname' => $login['firstname'],
					        'img' => $login['img'],
					        'parent_id' => $login['parent_id'],
					        'role' => $login['isSuperadmin'],
					        'logged_in' => TRUE,
					        'company_name' => $companyImg['company_name'],
					        'companyImg' => $companyImg['img']
						);
						
	           			// print_r($logged_in_sess); exit();
						$this->session->set_userdata($logged_in_sess);
	           			redirect('dashboard', 'refresh');
	           		}
	           		else {
	           			$this->data['errors'] = 'Account is Inactive, Contact Admin';

	           			$id = 1;
	            		$this->data['companyInfo'] = $this->model_company->getCompanyData($id);
	           			$this->load->view('login', $this->data);
	           		}
           		}
           		else
           		{
           			$this->data['errors'] = 'Incorrect username/password';

           			$id = 1;
            		$this->data['companyInfo'] = $this->model_company->getCompanyData($id);
           			$this->load->view('login', $this->data);
           		}
           		
           	}
           	else {
           		$this->data['errors'] = 'Email does not exists';

           		$id = 1;
            $this->data['companyInfo'] = $this->model_company->getCompanyData($id);

           		$this->load->view('login', $this->data);
           	}	
        }
        else {
            // false case

        	$id = 1;
            $this->data['companyInfo'] = $this->model_company->getCompanyData($id);
            $this->load->view('login', $this->data);
        }	
	}

	/*
		clears the session and redirects to login page
	*/
	public function logout()
	{
		$this->session->sess_destroy();
		redirect('auth/login', 'refresh');
	}

}
