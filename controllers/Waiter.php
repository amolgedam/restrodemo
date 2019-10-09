<?php 

class Waiter extends Admin_Controller 
{
	public function __construct()
	{
		parent::__construct();

		$this->not_logged_in();
		
		$this->data['page_title'] = 'ZEON ERP';
		
		$this->load->model('model_waiter');
		$this->load->model('model_users');
		$this->load->model('model_expences');
		
	}

	public function fecthActiveWaiterData()
	{
		$data = $this->model_waiter->fecthActiveWaiterData();
        echo json_encode($data);
	}

	public function getDataByName()
	{
		$name = $_POST['empname'];
		$data = $this->model_waiter->getDataByName($name);
        echo json_encode($data);
	}

	public function index()
	{
		if(!in_array('viewStore', $this->permission)) {
            redirect('dashboard', 'refresh');
        }
        
        $this->data['allData'] = $this->model_waiter->fecthAllData();

		$this->render_template('settings/waiter', $this->data);
	}

	public function create()
	{
		// if(!in_array('createStore', $this->permission)) {
		// 	redirect('dashboard', 'refresh');
		// }

		// $response = array();
		// print_r($this->input->post());exit();
		$this->form_validation->set_rules('waiter_name', 'Name', 'trim|required|is_unique[waiter.name]');
// 		$this->form_validation->set_rules('mobile', 'Mobile Number', 'trim|max_length[10]|min_length[10]|required');
// 		$this->form_validation->set_rules('address', 'Waiter Address', 'trim|required');
// 		$this->form_validation->set_rules('active', 'Active', 'trim|required');

		// $this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');
    
        if ($this->form_validation->run() == TRUE) {

        	$config['upload_path'] = './assets/images/profile/';
            $config['allowed_types'] = 'jpeg|jpg|png|';
            $config['max_size'] = 1024 * 8;

            $this->load->library('upload', $config);
            $this->upload->initialize($config);

            $this->upload->do_upload('img');

            $img = $this->upload->data();

	        if($img['file_name'] == '')
	        {
	        	$img = '';
	        }
	        else
	        {
	        	$img = $img['file_name'];
	        }

	        $data = array(
        		'name' => $this->input->post('waiter_name'),
        		'gender' => $this->input->post('gender'),
        		'mobile' => $this->input->post('mobile'),
        		'address' => $this->input->post('address'),
        		'active' => $this->input->post('active'),
        		'img' => $img	
        	);
			
			// echo "<pre>"; print_r($_POST);
   //      	echo "<pre>"; print_r($data); exit();

        	$create = $this->model_waiter->create($data);

        	if($create == true) {
        		
        		$this->session->set_flashdata('feedback','Data Saved Successfully');
				$this->session->set_flashdata('feedback_class','alert alert-success');
				return redirect('waiter');
        	}
        	else {
        		
        		$this->session->set_flashdata('feedback','Unable to Saved Data');
				$this->session->set_flashdata('feedback_class','alert alert-danger');
				return redirect('waiter');
        	}
        }
        else
        {
        	$this->data['allData'] = $this->model_waiter->fecthAllData();

			$this->render_template('settings/waiter', $this->data);
        }
	}

	public function updateWaiter()
	{
		$this->form_validation->set_rules('waiter_name_edit', 'Waiter Name', 'trim|required');
		// $this->form_validation->set_rules('mobile_edit', 'Mobile Number', 'trim|max_length[10]|min_length[10]|required');
		// $this->form_validation->set_rules('address_edit', 'Waiter Address', 'trim|required');
		// $this->form_validation->set_rules('active_edit', 'Active', 'trim|required');

		// $this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');

        if ($this->form_validation->run() == TRUE) {
        	$data = array(
        		'id' => $this->input->post('waiter_id_edit'),
        		'name' => $this->input->post('waiter_name_edit'),
        		'gender' => $this->input->post('gender_edit'),
        		'mobile' => $this->input->post('mobile_edit'),
        		'address' => $this->input->post('address_edit'),
        		'active' => $this->input->post('active_edit'),	
        	);

        	$create = $this->model_waiter->update($data);

        	if($create == true) {

        		if($this->input->post('active_edit') == 2)
	        	{
	        		$userData = $this->model_users->getDataByEmpID($this->input->post('waiter_id_edit'));

	        		$userUpdateData = array(
	        						'id' => $userData['id'],
	        						'loginstatus' => 0
	        					);

	        		$this->model_users->update($userUpdateData);
	        	}
        		
        		$this->session->set_flashdata('feedback','Data Saved Successfully');
				$this->session->set_flashdata('feedback_class','alert alert-success');
				return redirect('waiter');
        	}
        	else {
        		
        		$this->session->set_flashdata('feedback','Unable to Saved Data');
				$this->session->set_flashdata('feedback_class','alert alert-danger');
				return redirect('waiter');
        	}
        }
        else
        {
        	$this->data['allData'] = $this->model_waiter->fecthAllData();

			$this->render_template('settings/waiter', $this->data);
        }
	}

	public function deleteWaiter()
	{
		$id = $this->input->post('waiter_id_edit');

		$expData = $this->model_expences->fecthDataByUserId($id);
		// echo "<pre>"; print_r($expData); exit();

		if($expData['id'] == '')
		{
			$delete = $this->model_waiter->deleteWaiter($id);	

			if($delete == true) {

	    		$this->session->set_flashdata('feedback','Record Deleted Successfully');
				$this->session->set_flashdata('feedback_class','alert alert-success');
				return redirect('waiter');
	    	}
	    	else{

	    		$this->session->set_flashdata('feedback','Unable to Delete Record');
				$this->session->set_flashdata('feedback_class','alert alert-danger');
				return redirect('waiter');
	    	}
		}
		else
		{
			$this->session->set_flashdata('feedback','Data Available in Another Records');
			$this->session->set_flashdata('feedback_class','alert alert-danger');
			return redirect('waiter');
		}
	}

	public function statusWaiter()
	{
		$id = $this->input->post('waiter_id_edit');
		$active = $this->input->post('active_edit');

		if($active == 1)
		{
			$status = 2;
		}
		else
		{
			$status = 1;
		}
		
		$data = array(
        		'id' => $id,
        		'active' => $status
        	);
		// print_r($data);exit();

		$changeStatus = $this->model_waiter->statusWaiter($data);	

		if($changeStatus == true) {

    		$this->session->set_flashdata('feedback','Record Deleted Successfully');
			$this->session->set_flashdata('feedback_class','alert alert-success');
			return redirect('waiter');
    	}
    	else{

    		$this->session->set_flashdata('feedback','Unable to Delete Record');
			$this->session->set_flashdata('feedback_class','alert alert-danger');
			return redirect('waiter');
    	}
	}

	
}