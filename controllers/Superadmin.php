<?php 

class Superadmin extends Admin_Controller 
{
	public function __construct()
	{
		parent::__construct();

		$this->data['page_title'] = 'ZEON ERP';
		
	    $this->load->model('model_auth');
	    $this->load->model('model_company');
	    $this->load->model('model_users');

	}

	public function login()
	{
		$this->form_validation->set_rules('email', 'Email', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');

        if ($this->form_validation->run() == TRUE) {

        	$email_exists = $this->model_auth->check_email($this->input->post('email'));

           	if($email_exists == TRUE) {
           		$login = $this->model_auth->login($this->input->post('email'), $this->input->post('password'));

           		// echo "<pre>"; print_r($login); exit();
           		
           		if($login['loginstatus'] != 0)
           		{
           			$companyImg = $this->model_company->getCompanyData(1);

	           		if($login) {

	           			$logged_in_sess = array(
	           				'id' => $login['id'],
					        'username'  => $login['username'],
					        'email'     => $login['email'],
					        'firstname' => $login['firstname'],
					        'img' => $login['img'],
					        'logged_in' => TRUE,
					        'company_name' => $companyImg['company_name'],
					        'companyImg' => $companyImg['img']
						);
						
	           			// print_r($logged_in_sess); exit();
						$this->session->set_userdata($logged_in_sess);
	           			redirect('superadmin/dashboard', 'refresh');
	           		}
	           		else {
	           			$this->data['errors'] = 'Incorrect username/password combination';

	           			$this->load->view('superadmin/login', $this->data);
	           		}
           		}
           		else
           		{
           			$this->data['errors'] = 'Your Account is Inactive, Contact To Admin';

           			$this->load->view('superadmin/login', $this->data);
           		}
           		
           	}
           	else {
           		$this->data['errors'] = 'Email does not exists';

           		$this->load->view('superadmin/login', $this->data);
           	}	
        }
        else
        {
			$this->load->view('superadmin/login', $this->data);
        }
	}

	public function dashboard()
	{
		$this->load->view('superadmin/templates/header', $this->data);
		$this->load->view('superadmin/templates/header_menu', $this->data);
		$this->load->view('superadmin/templates/side_menubar', $this->data);


		$this->load->view('superadmin/dashboard', $this->data);
		$this->load->view('superadmin/templates/footer', $this->data);
	}

	public function manageAdmin()
	{
		$this->data['allData'] = $this->model_users->getAllAdminData();

		// echo "<pre>"; print_r($allData); exit();

		$this->load->view('superadmin/templates/header', $this->data);
		$this->load->view('superadmin/templates/header_menu');
		$this->load->view('superadmin/templates/side_menubar');

		$this->load->view('superadmin/admin/index', $this->data);

		$this->load->view('superadmin/templates/footer');
	}

	public function createAdmin()
	{
		$this->form_validation->set_rules('fname', 'Name', 'trim|required');
		$this->form_validation->set_rules('phone', 'Phone', 'trim|required');
		$this->form_validation->set_rules('username', 'Username', 'trim|required|is_unique[users.username]');
		$this->form_validation->set_rules('password', 'Password', 'trim|required');
		$this->form_validation->set_rules('cpassword', 'Username', 'trim|required|matches[password]');

		if($this->form_validation->run()){

			$data = array(
							'isSuperadmin' => 2,
							'username' => $this->input->post('username'),
							'password' => md5($this->input->post('password')),
							'firstname' => $this->input->post('fname'),
							'phone' => $this->input->post('phone'),
							'loginstatus' => $this->input->post('status'),
							'store_id' => 2,
							'parent_id' => $this->session->userdata['id'],
							'validitystartdate' => $this->input->post('datefrom'),
							'validity' => $this->input->post('validity'),
						);

			// echo "<pre>"; print_r($data); exit();

        	$create = $this->model_users->create($data, 5);

        	if($create == true) {
        		$this->session->set_flashdata('success', 'Successfully created');
        		redirect('superadmin/manageAdmin/', 'refresh');
        	}
        	else {
        		$this->session->set_flashdata('errors', 'Error occurred!!');
        		redirect('superadmin/createAdmin/', 'refresh');
        	}
		}
		else{

			$this->load->view('superadmin/templates/header', $this->data);
			$this->load->view('superadmin/templates/header_menu', $this->data);
			$this->load->view('superadmin/templates/side_menubar', $this->data);

			$this->load->view('superadmin/admin/create', $this->data);
			$this->load->view('superadmin/templates/footer', $this->data);
		}	
	}

	public function editAdmin()
	{
		$id = $this->uri->segment(3);

		$this->form_validation->set_rules('fname', 'Name', 'trim|required');
		$this->form_validation->set_rules('phone', 'Phone', 'trim|required');
		// $this->form_validation->set_rules('username', 'Username', 'trim|required|is_unique[users.username]');
		if($this->form_validation->run()){

			if(empty($this->input->post('password')) && empty($this->input->post('cpassword')))
			{
				$data = array(
							'id' => $this->input->post('id'),
							// 'isSuperadmin' => 2,
							// 'username' => $this->input->post('username'),
							// 'password' => md5($this->input->post('password')),
							'firstname' => $this->input->post('fname'),
							'phone' => $this->input->post('phone'),
							'loginstatus' => $this->input->post('status'),
							// 'store_id' => 2,
							// 'parent_id' => $this->session->userdata['id'],
							'validitystartdate' => $this->input->post('datefrom'),
							'validity' => $this->input->post('validity'),
						);

				$create = $this->model_users->update($data);

	        	if($create == true) {

	        		if($this->input->post('status') == 0)
					{
						$updateChild = array(
												'parent_id' => $this->input->post('id'),
												'loginstatus' => 0
											);

						$this->model_users->updateChild($updateChild);
					}

	        		$this->session->set_flashdata('success', 'Successfully Update');
	        		redirect('superadmin/manageAdmin/'.$this->input->post('id'), 'refresh');
	        	}
	        	else {
	        		$this->session->set_flashdata('errors', 'Error occurred!!');
	        		redirect('superadmin/editAdmin/', 'refresh');
	        	}
			}
			else
			{
				$this->form_validation->set_rules('password', 'Password', 'trim|required');
				$this->form_validation->set_rules('cpassword', 'Username', 'trim|required|matches[password]');

				if($this->form_validation->run()){

					$data = array(
							'id' => $this->input->post('id'),
							// 'isSuperadmin' => 2,
							// 'username' => $this->input->post('username'),
							'password' => md5($this->input->post('password')),
							'firstname' => $this->input->post('fname'),
							'phone' => $this->input->post('phone'),
							'loginstatus' => $this->input->post('status'),
							// 'store_id' => 2,
							// 'parent_id' => $this->session->userdata['id'],
							'validitystartdate' => $this->input->post('datefrom'),
							'validity' => $this->input->post('validity'),
						);

					$create = $this->model_users->update($data);

		        	if($create == true) {

		        		if($this->input->post('status') == 0)
						{
							$updateChild = array(
													'parent_id' => $this->input->post('id'),
													'loginstatus' => 0
												);

							$this->model_users->updateChild($updateChild);
						}

		        		$this->session->set_flashdata('success', 'Successfully Update');
		        		redirect('superadmin/manageAdmin/'.$this->input->post('id'), 'refresh');
		        	}
		        	else {
		        		$this->session->set_flashdata('errors', 'Error occurred!!');
		        		redirect('superadmin/editAdmin/', 'refresh');
		        	}
				}
				else
				{
					$this->data['allData'] = $this->model_users->getUserData($id);

					$this->load->view('superadmin/templates/header', $this->data);
					$this->load->view('superadmin/templates/header_menu', $this->data);
					$this->load->view('superadmin/templates/side_menubar', $this->data);

					$this->load->view('superadmin/admin/update', $this->data);
					$this->load->view('superadmin/templates/footer', $this->data);
				}

			}

			// echo "<pre>"; print_r($data); exit();

        	
		}
		else{

			$this->data['allData'] = $this->model_users->getUserData($id);

			$this->load->view('superadmin/templates/header', $this->data);
			$this->load->view('superadmin/templates/header_menu', $this->data);
			$this->load->view('superadmin/templates/side_menubar', $this->data);

			$this->load->view('superadmin/admin/update', $this->data);
			$this->load->view('superadmin/templates/footer', $this->data);
		}	
	}


	public function deleteAdmin()
	{
		$id = $this->uri->segment(3);

		$delete = $this->model_users->delete($id);

		if($delete)
		{
			$this->model_users->deleteUsers($id);

			$this->session->set_flashdata('errors', 'Record Delete Successfully');
        	redirect('superadmin/manageAdmin/', 'refresh');
		}
		else
		{
			$this->session->set_flashdata('errors', 'Unable to Delete Record');
        	redirect('superadmin/manageAdmin/', 'refresh');
		}

	}


}