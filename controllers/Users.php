<?php 

class Users extends Admin_Controller 
{
	public function __construct()
	{
		parent::__construct();

		$this->not_logged_in();
		
		$this->data['page_title'] = 'ZEON ERP';

		$this->load->model('model_users');
		$this->load->model('model_groups');
		$this->load->model('model_stores');
		$this->load->model('model_waiter');
	}

	public function index()
	{

		if(!in_array('viewUser', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

		$user_data = $this->model_users->getManageUserData();

		$result = array();
		foreach ($user_data as $k => $v) {

			$result[$k]['user_info'] = $v;

			$group = $this->model_users->getUserGroup($v['id']);
			$result[$k]['user_group'] = $group;
		}

		// echo "<pre>"; print_r($result); exit();

		$this->data['user_data'] = $result;

		$this->render_template('users/index', $this->data);
	}

	public function create()
	{

		if(!in_array('createUser', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

		$this->form_validation->set_rules('emp', 'Employee', 'required');
		$this->form_validation->set_rules('groups', 'Group', 'required');
		$this->form_validation->set_rules('store', 'Store', 'trim|required');
		$this->form_validation->set_rules('username', 'Username', 'trim|required|min_length[5]|max_length[12]|is_unique[users.username]');
		// $this->form_validation->set_rules('email', 'Email', 'trim|required|is_unique[users.email]');
		$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[8]');
		$this->form_validation->set_rules('cpassword', 'Confirm password', 'trim|required|matches[password]');
		// $this->form_validation->set_rules('fname', 'First name', 'trim|required');
		

        if ($this->form_validation->run() == TRUE) {
            // true case
            // $password = $this->password_hash($this->input->post('password'));
            $password = md5($this->input->post('password'));

            $empdata = $this->model_waiter->fecthAllDataById($this->input->post('emp'));

        	$data = array(
        		'emp_id' => $this->input->post('emp'),
        		'username' => $this->input->post('username'),
        		'password' => $password,
        		// 'email' => $this->input->post('email'),
        		'firstname' => $empdata['name'],
        		// 'lastname' => $this->input->post('lname'),
        		'phone' => $empdata['mobile'],
        		// 'gender' => $this->input->pos()t('gender'),
        		'store_id' => $this->input->post('store'),
        		'img' => $empdata['img'],
        		'loginstatus' => $this->input->post('status'),
        		'parent_id' => $this->session->userdata('id'),
        	);
        	// echo "<pre>"; print_r($data); exit();

        	$create = $this->model_users->create($data, $this->input->post('groups'));
        	if($create == true) {
        		$this->session->set_flashdata('success', 'Successfully created');
        		redirect('users/', 'refresh');
        	}
        	else {
        		$this->session->set_flashdata('errors', 'Error occurred!!');
        		redirect('users/create', 'refresh');
        	}
        }
        else {
            // false case
            $this->data['store_data'] = $this->model_stores->getStoresData();
        	$group_data = $this->model_groups->getManageGroupData();
        	$this->data['group_data'] = $group_data;

        	$this->data['emp'] = $this->model_waiter->fecthActiveWaiterData();
        	// echo "<pre>"; print_r($emp); exit();

            $this->render_template('users/create', $this->data);
        }	

		
	}

	public function password_hash($pass = '')
	{
		if($pass) {
			$password = password_hash($pass, PASSWORD_DEFAULT);
			return $password;
		}
	}

	public function edit($id = null)
	{

		if(!in_array('updateUser', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

		if($id) {
			$this->form_validation->set_rules('groups', 'Group', 'required');
			$this->form_validation->set_rules('store', 'Store', 'trim|required');
			$this->form_validation->set_rules('username', 'Username', 'trim|required|min_length[5]|max_length[12]');
			// $this->form_validation->set_rules('email', 'Email', 'trim|required');
			// $this->form_validation->set_rules('fname', 'First name', 'trim|required');


			if ($this->form_validation->run() == TRUE) {
	            // true case
		        if(empty($this->input->post('password')) && empty($this->input->post('cpassword'))) {


            		$empdata = $this->model_waiter->fecthAllDataById($this->input->post('emp'));

		        	$data = array(
		        		'emp_id' => $this->input->post('emp'),
		        		'username' => $this->input->post('username'),
		        		// 'email' => $this->input->post('email'),
        				'firstname' => $empdata['name'],
        				'phone' => $empdata['mobile'],
						// 'lastname' => $this->input->post('lname'),
		        		// 'phone' => $this->input->post('phone'),
		        		// 'gender' => $this->input->post('gender'),
		        		'store_id' => $this->input->post('store'),
        				'loginstatus' => $this->input->post('status'),
		        	);

		        	// echo "<pre>"; print_r($data); exit();

		        	$update = $this->model_users->edit($data, $id, $this->input->post('groups'));
		        	if($update == true) {
		        		$this->session->set_flashdata('success', 'Successfully created');
		        		redirect('users/', 'refresh');
		        	}
		        	else {
		        		$this->session->set_flashdata('errors', 'Error occurred!!');
		        		redirect('users/edit/'.$id, 'refresh');
		        	}
		        }
		        else {
		        	$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[8]');
					$this->form_validation->set_rules('cpassword', 'Confirm password', 'trim|required|matches[password]');

					if($this->form_validation->run() == TRUE) {

						$password = md5($this->input->post('password'));

            			$empdata = $this->model_waiter->fecthAllDataById($this->input->post('emp'));

						$data = array(
			        		'emp_id' => $this->input->post('emp'),
			        		'username' => $this->input->post('username'),
			        		'password' => $password,
			        		'firstname' => $empdata['name'],
	        				'phone' => $empdata['mobile'],
			        		// 'email' => $this->input->post('email'),
			        		// 'firstname' => $this->input->post('fname'),
			        		// 'lastname' => $this->input->post('lname'),
			        		// 'phone' => $this->input->post('phone'),
			        		// 'gender' => $this->input->post('gender'),
			        		'store_id' => $this->input->post('store'),
			        	);

			        	$update = $this->model_users->edit($data, $id, $this->input->post('groups'));
			        	if($update == true) {
			        		$this->session->set_flashdata('success', 'Successfully updated');
			        		redirect('users/', 'refresh');
			        	}
			        	else {
			        		$this->session->set_flashdata('errors', 'Error occurred!!');
			        		redirect('users/edit/'.$id, 'refresh');
			        	}
					}
			        else {
			            // false case
			        	$user_data = $this->model_users->getUserData($id);
			        	$groups = $this->model_users->getUserGroup($id);

			        	$this->data['user_data'] = $user_data;
			        	$this->data['user_group'] = $groups;

			            $group_data = $this->model_groups->getGroupData();
			        	$this->data['group_data'] = $group_data;

						$this->render_template('users/edit', $this->data);	
			        }	

		        }
	        }
	        else {
	            // false case
	        	$user_data = $this->model_users->getUserData($id);
	        	$groups = $this->model_users->getUserGroup($id);

	        	$this->data['emp'] = $this->model_waiter->fecthActiveWaiterData();

	        	$this->data['store_data'] = $this->model_stores->getStoresData();

	        	$this->data['user_data'] = $user_data;
	        	$this->data['user_group'] = $groups;

	            $group_data = $this->model_groups->getManageGroupData();
	        	$this->data['group_data'] = $group_data;

				$this->render_template('users/edit', $this->data);	
	        }	
		}	
	}

	public function delete()
	{

		if(!in_array('deleteUser', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

		$id = $this->input->post('gst_id_edit');

		if($id) {
			// if($this->input->post('confirm')) {

					// echo "<pre>"; print_r($id); exit();
					$delete = $this->model_users->delete($id);
					if($delete == true) {

						$this->model_users->deleteUserGroup($id);

		        		$this->session->set_flashdata('success', 'Successfully removed');
		        		redirect('users/', 'refresh');
		        	}
		        	else {
		        		$this->session->set_flashdata('error', 'Error occurred!!');
		        		redirect('users/delete/'.$id, 'refresh');
		        	}

			// }	
			// else {
			// 	$this->data['id'] = $id;
			// 	$this->render_template('users/delete', $this->data);
			// }	
		}
	}

	public function profile()
	{

		if(!in_array('viewProfile', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

		$user_id = $this->session->userdata('id');

		$user_data = $this->model_users->getUserData($user_id);
		$this->data['user_data'] = $user_data;

		$user_group = $this->model_users->getUserGroup($user_id);
		$this->data['user_group'] = $user_group;

        $this->render_template('users/profile', $this->data);
	}

	public function setting()
	{
		if(!in_array('updateSetting', $this->permission)) {
            redirect('dashboard', 'refresh');
        }
        
		$id = $this->session->userdata('id');

		if($id) {
			$this->form_validation->set_rules('username', 'Username', 'trim|required|min_length[5]|max_length[12]');
			// $this->form_validation->set_rules('email', 'Email', 'trim|required');
			$this->form_validation->set_rules('fname', 'First name', 'trim|required');


			if ($this->form_validation->run() == TRUE) {
	            // true case
		        if(empty($this->input->post('password')) && empty($this->input->post('cpassword'))) {

		        	$userData = $this->model_users->getUserData($id);

		        	$data = array(
		        		'username' => $this->input->post('username'),
		        		// 'email' => $this->input->post('email'),
		        		'firstname' => $this->input->post('fname'),
		        		// 'lastname' => $this->input->post('lname'),
		        		'phone' => $this->input->post('phone'),
		        		'gender' => $this->input->post('gender'),
		        	);

		        	$update = $this->model_users->edit($data, $id, $this->input->post('groups'));
		        	if($update == true) {
		        		
		        		if($userData['emp_id'] != 0)
			        	{
			        		$empdata = $this->model_waiter->fecthAllDataById($userData['emp_id']);

			        		$data = array(
			        						'id' => $empdata['id'],
			        						'name' => $this->input->post('fname'),
			        						'gender' => $this->input->post('gender'),
			        						'mobile' => $this->input->post('phone'),
			        						'address' => $this->input->post('address'),
			        					);

			        		$this->model_waiter->updateAll($data);
			        	}

		        		$this->session->set_flashdata('success', 'Successfully updated');
		        		redirect('dashboard', 'refresh');
		        	}
		        	else {
		        		$this->session->set_flashdata('errors', 'Error occurred!!');
		        		redirect('users/setting/', 'refresh');
		        	}
		        }
		        else {
		        	$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[8]');
					$this->form_validation->set_rules('cpassword', 'Confirm password', 'trim|required|matches[password]');

					if($this->form_validation->run() == TRUE) {

						$password = $this->password_hash($this->input->post('password'));

						$data = array(
			        		'username' => $this->input->post('username'),
			        		'password' => $password,
			        		'email' => $this->input->post('email'),
			        		'firstname' => $this->input->post('fname'),
			        		'lastname' => $this->input->post('lname'),
			        		'phone' => $this->input->post('phone'),
			        		'gender' => $this->input->post('gender'),
			        	);

			        	$update = $this->model_users->edit($data, $id, $this->input->post('groups'));

			        	if($update == true) {

			        		if($userData['emp_id'] != 0)
				        	{
				        		$empdata = $this->model_waiter->fecthAllDataById($userData['emp_id']);

				        		$data = array(
				        						'id' => $empdata['id'],
				        						'name' => $this->input->post('fname'),
				        						'gender' => $this->input->post('gender'),
				        						'mobile' => $this->input->post('phone'),
				        						'address' => $this->input->post('address'),
				        					);

				        		$this->model_waiter->updateAll($data);
				        	}

			        		$this->session->set_flashdata('success', 'Successfully updated');
			        		redirect('dashboard', 'refresh');
			        	}
			        	else {
			        		$this->session->set_flashdata('errors', 'Error occurred!!');
			        		redirect('users/setting/', 'refresh');
			        	}
					}
			        else {
			            // false case
			        	$user_data = $this->model_users->getUserData($id);
			        	$groups = $this->model_users->getUserGroup($id);

			        	$this->data['user_data'] = $user_data;
			        	$this->data['user_group'] = $groups;

			            $group_data = $this->model_groups->getGroupData();
			        	$this->data['group_data'] = $group_data;

						$this->render_template('users/setting', $this->data);	
			        }	

		        }
	        }
	        else {
	            // false case
	        	$user_data = $this->model_users->getUserData($id);
	        	$groups = $this->model_users->getUserGroup($id);

	        	$this->data['user_data'] = $user_data;
	        	$this->data['user_group'] = $groups;

	            $group_data = $this->model_groups->getGroupData();
	        	$this->data['group_data'] = $group_data;

				$this->render_template('users/setting', $this->data);	
	        }	
		}
	}


}