<?php 

class Unit_type extends Admin_Controller 
{
	public function __construct()
	{
		parent::__construct();

		$this->not_logged_in();
		
		$this->data['page_title'] = 'ZEON ERP';
		
		$this->load->model('model_unittype');
		$this->load->model('model_products');
		$this->load->model('model_users');
		
	}

	public function fecthAllData()
	{
		$data = $this->model_unittype->fecthActiveUnitTypeData();
        echo json_encode($data);
	}

	public function fecthActiveSalesTypeData()
	{
		$data = $this->model_salestype->fecthActiveSalesTypeData();
        echo json_encode($data);
	}

	public function index()
	{
		if(!in_array('viewStore', $this->permission)) {
            redirect('dashboard', 'refresh');
        }
        
        $this->data['allData'] = $this->model_unittype->fecthAllData();

		$this->render_template('settings/unitType', $this->data);
	}

	public function create()
	{
		// if(!in_array('createStore', $this->permission)) {
		// 	redirect('dashboard', 'refresh');
		// }

		// $response = array();
		// print_r($this->input->post());exit();
		$this->form_validation->set_rules('name', 'Unit Name', 'trim|required|is_unique[unit_type.name]');
		$this->form_validation->set_rules('active', 'Active', 'trim|required');

		// $this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');

        if ($this->form_validation->run() == TRUE) {
        	$data = array(
        		'name' => $this->input->post('name'),
        		'active' => $this->input->post('active'),	
        	);
        	// print_r($data); exit();
        	$create = $this->model_unittype->create($data);

        	if($create == true) {
        		
        		$this->session->set_flashdata('feedback','Data Saved Successfully');
				$this->session->set_flashdata('feedback_class','alert alert-success');
				return redirect('unit_type');
        	}
        	else {
        		
        		$this->session->set_flashdata('feedback','Unable to Saved Data');
				$this->session->set_flashdata('feedback_class','alert alert-danger');
				return redirect('unit_type');
        	}
        }
        else
        {
        	$this->data['allData'] = $this->model_unittype->fecthAllData();

			$this->render_template('settings/unitType', $this->data);
        }
	}

	public function updateUnit()
	{
		$this->form_validation->set_rules('name_edit', 'Unit Name', 'trim|required');
		$this->form_validation->set_rules('active_edit', 'Active', 'trim|required');

		// $this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');

        if ($this->form_validation->run() == TRUE) {
        	$data = array(
        		'id' => $this->input->post('id_edit'),
        		'name' => $this->input->post('name_edit'),
        		'active' => $this->input->post('active_edit'),	
        	);
        	// print_r($data); exit();
        	$create = $this->model_unittype->update($data);

        	if($create == true) {
        		
        		$this->session->set_flashdata('feedback','Data Saved Successfully');
				$this->session->set_flashdata('feedback_class','alert alert-success');
				return redirect('unit_type');
        	}
        	else {
        		
        		$this->session->set_flashdata('feedback','Unable to Saved Data');
				$this->session->set_flashdata('feedback_class','alert alert-danger');
				return redirect('unit_type');
        	}
        }
        else
        {
        	$this->data['allData'] = $this->model_unittype->fecthAllData();

			$this->render_template('settings/unitType', $this->data);
        }
	}

	public function deleteUnitType()
	{
		$id = $this->input->post('id_edit');

		$productData  = $this->model_products->existInUnitinProduct($id);

		if($productData > 0)
		{
			$this->session->set_flashdata('feedback','Data Available in Another Records');
			$this->session->set_flashdata('feedback_class','alert alert-danger');
			return redirect('unit_type');
		}
		else
		{
			$delete = $this->model_unittype->deleteUnitType($id);	

			if($delete == true) {

	    		$this->session->set_flashdata('feedback','Record Deleted Successfully');
				$this->session->set_flashdata('feedback_class','alert alert-success');
				return redirect('unit_type');
	    	}
	    	else{

	    		$this->session->set_flashdata('feedback','Unable to Delete Record');
				$this->session->set_flashdata('feedback_class','alert alert-danger');
				return redirect('unit_type');
	    	}
		}
	}

	public function statusChange()
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

		$changeStatus = $this->model_unittype->statusChange($data);	

		if($changeStatus == true) {

    		$this->session->set_flashdata('feedback','Record Deleted Successfully');
			$this->session->set_flashdata('feedback_class','alert alert-success');
			return redirect('unit_type');
    	}
    	else{

    		$this->session->set_flashdata('feedback','Unable to Delete Record');
			$this->session->set_flashdata('feedback_class','alert alert-danger');
			return redirect('unit_type');
    	}
	}

	
}