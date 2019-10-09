<?php 

class Paymentor extends Admin_Controller 
{
	public function __construct()
	{
		parent::__construct();

		$this->not_logged_in();
		
		$this->data['page_title'] = 'ZEON ERP';
		$this->load->model('model_paymentor');
		$this->load->model('model_orders');
		$this->load->model('model_users');
		
	}

	public function fecthActivePaymentorData()
	{
		$data = $this->model_paymentor->fecthActivePaymentorData();
        echo json_encode($data);

	}

	public function index()
	{
		if(!in_array('viewStore', $this->permission)) {
            redirect('dashboard', 'refresh');
        }
        
        $this->data['allData'] = $this->model_paymentor->fecthAllData();

		$this->render_template('settings/paymentor', $this->data);
	}

	public function create()
	{
		// if(!in_array('createStore', $this->permission)) {
		// 	redirect('dashboard', 'refresh');
		// }

		// $response = array();
		// print_r($this->input->post());exit();
		$this->form_validation->set_rules('name', 'Paymentor Name', 'trim|required|is_unique[paymentor.name]');
		$this->form_validation->set_rules('active', 'Active', 'trim|required');

		// $this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');

        if ($this->form_validation->run() == TRUE) {
        	$data = array(
        		'name' => $this->input->post('name'),
        		'active' => $this->input->post('active'),	
        	);
        	// print_r($data); exit();
        	$create = $this->model_paymentor->create($data);

        	if($create == true) {
        		
        		$this->session->set_flashdata('feedback','Data Saved Successfully');
				$this->session->set_flashdata('feedback_class','alert alert-success');
				return redirect('paymentor');
        	}
        	else {
        		
        		$this->session->set_flashdata('feedback','Unable to Saved Data');
				$this->session->set_flashdata('feedback_class','alert alert-danger');
				return redirect('paymentor');
        	}
        }
	}

	public function updatePaymentor()
	{
		$this->form_validation->set_rules('name_edit', 'Paymentor Name', 'trim|required');
		$this->form_validation->set_rules('active_edit', 'Active', 'trim|required');

		// $this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');

        if ($this->form_validation->run() == TRUE) {
        	$data = array(
        		'id' => $this->input->post('id_edit'),
        		'name' => $this->input->post('name_edit'),
        		'active' => $this->input->post('active_edit'),	
        	);
        	// print_r($data); exit();
        	$create = $this->model_paymentor->update($data);

        	if($create == true) {
        		
        		$this->session->set_flashdata('feedback','Data Saved Successfully');
				$this->session->set_flashdata('feedback_class','alert alert-success');
				return redirect('paymentor');
        	}
        	else {
        		
        		$this->session->set_flashdata('feedback','Unable to Saved Data');
				$this->session->set_flashdata('feedback_class','alert alert-danger');
				return redirect('paymentor');
        	}
        }
	}

	public function deletePaymentor()
	{
		$id = $this->input->post('id_edit');

		$orderData = $this->model_orders->fecthOrderDataByField('payment_term', $id);

		if($orderData['id'] != '')
		{
			$this->session->set_flashdata('feedback','Data Available in Another Records');
			$this->session->set_flashdata('feedback_class','alert alert-danger');
			return redirect('paymentor');
		}
		else
		{
			$delete = $this->model_paymentor->deletePaymentor($id);	

			if($delete == true) {

	    		$this->session->set_flashdata('feedback','Record Deleted Successfully');
				$this->session->set_flashdata('feedback_class','alert alert-success');
				return redirect('paymentor');
	    	}
	    	else{

	    		$this->session->set_flashdata('feedback','Unable to Delete Record');
				$this->session->set_flashdata('feedback_class','alert alert-danger');
				return redirect('paymentor');
	    	}
		}
	}

	public function statusWaiter()
	{
		$id = $this->input->post('id_edit');
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

		$changeStatus = $this->model_paymentor->statusWaiter($data);	

		if($changeStatus == true) {

    		$this->session->set_flashdata('feedback','Record Deleted Successfully');
			$this->session->set_flashdata('feedback_class','alert alert-success');
			return redirect('paymentor');
    	}
    	else{

    		$this->session->set_flashdata('feedback','Unable to Delete Record');
			$this->session->set_flashdata('feedback_class','alert alert-danger');
			return redirect('paymentor');
    	}
	}

	
}