<?php 

class Parcel extends Admin_Controller 
{
	public function __construct()
	{
		parent::__construct();

		$this->not_logged_in();
		
		$this->data['page_title'] = 'ZEON ERP';
		
		$this->load->model('model_tables');
		$this->load->model('model_parcel');
		$this->load->model('model_stores');
		$this->load->model('model_orders');
		$this->load->model('model_users');

	}

	public function index()
	{	
		$store_data = $this->model_stores->getActiveStore();
		$this->data['store_data'] = $store_data;
		$this->render_template('parcel/index', $this->data);	
	}

	public function fetchTableData()
	{
		if(!in_array('viewTable', $this->permission)) {
			redirect('dashboard', 'refresh');
		}
		
		$result = array('data' => array());

		$data = $this->model_parcel->getTableData();
		$no = 1;
		foreach ($data as $key => $value) {

			$store_data = $this->model_stores->getStoresData($value['store_id']);

			// button
			$buttons = '';

			if(in_array('updateTable', $this->permission)) {
				$buttons = '<button type="button" class="btn btn-sm btn-info" onclick="editFunc('.$value['id'].')" data-toggle="modal" data-target="#editModal"><i class="fa fa-pencil"></i> </button>';
			}

			if(in_array('deleteTable', $this->permission)) {
				$buttons .= ' <button type="button" class="btn btn-sm btn-danger" onclick="removeFunc('.$value['id'].')" data-toggle="modal" data-target="#removeModal"><i class="fa fa-trash"></i> </button>';
			}

			$available = ($value['available'] == 1) ? '<span class="label label-success">Available</span>' : '<span class="label label-warning">Unavailable</span>';
			$status = ($value['active'] == 1) ? '<span class="label label-success">Active</span>' : '<span class="label label-warning">Inactive</span>';

			$result['data'][$key] = array(
				$no,
				$store_data['name'],
				$value['table_name'],
				$value['capacity'],
				$available,
				$status,
				$buttons
			);
			$no++;
		} // /foreach

		echo json_encode($result);
	}

	public function create()
	{
		if(!in_array('createTable', $this->permission)) {
			redirect('dashboard', 'refresh');
		}

		$response = array();

		$this->form_validation->set_rules('parcel_name', 'Table name', 'trim|required');
		$this->form_validation->set_rules('capacity', 'Capacity', 'trim|integer');
		$this->form_validation->set_rules('active', 'Active', 'trim|required');
		$this->form_validation->set_rules('store', 'Store', 'trim|required');

		$this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');

        if ($this->form_validation->run() == TRUE) {
        	$data = array(
        		'table_name' => $this->input->post('parcel_name'),
        		'available' => 1,
        		'capacity' => $this->input->post('capacity'),	
        		'active' => $this->input->post('active'),	
        		'store_id' => $this->input->post('store')
        	);

        	$create = $this->model_parcel->create($data);
        	
        	if($create == true) {
        		$response['success'] = true;
        		$response['messages'] = 'Succesfully created';
        	}
        	else {
        		$response['success'] = false;
        		$response['messages'] = 'Error in the database while creating the brand information';
        	}
        }
        else {
        	$response['success'] = false;
        	foreach ($_POST as $key => $value) {
        		$response['messages'][$key] = form_error($key);
        	}
        }

        echo json_encode($response);
	}

	public function fetchTableDataById($id = null)
	{
		if($id) {
			$data = $this->model_parcel->getTableData($id);
			echo json_encode($data);
		}
		
	}

	public function update($id)
	{
		if(!in_array('updateTable', $this->permission)) {
			redirect('dashboard', 'refresh');
		}

		$response = array();

		if($id) {
			$this->form_validation->set_rules('edit_table_name', 'Parcel name', 'trim|required');
			$this->form_validation->set_rules('edit_capacity', 'Capacity', 'trim|integer');
			$this->form_validation->set_rules('edit_active', 'Active', 'trim|required');
			$this->form_validation->set_rules('edit_store', 'Store', 'trim|required');

			$this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');

	        if ($this->form_validation->run() == TRUE) {
	        	$data = array(
	        		'table_name' => $this->input->post('edit_table_name'),
        			'capacity' => $this->input->post('edit_capacity'),	
        			'active' => $this->input->post('edit_active'),	
        			'store_id' => $this->input->post('edit_store'),	
	        	);

	        	$update = $this->model_parcel->update($id, $data);
	        	if($update == true) {
	        		$response['success'] = true;
	        		$response['messages'] = 'Succesfully updated';
	        	}
	        	else {
	        		$response['success'] = false;
	        		$response['messages'] = 'Error in the database while updated the brand information';			
	        	}
	        }
	        else {
	        	$response['success'] = false;
	        	foreach ($_POST as $key => $value) {
	        		$response['messages'][$key] = form_error($key);
	        	}
	        }
		}
		else {
			$response['success'] = false;
    		$response['messages'] = 'Error please refresh the page again!!';
		}

		echo json_encode($response);
	}

	public function remove()
	{
		if(!in_array('deleteTable', $this->permission)) {
			redirect('dashboard', 'refresh');
		}
		
		$table_id = $this->input->post('table_id');

		$orderData = $this->model_orders->existInParcelInorder($table_id);

		if($orderData > 0)
		{
			$response['success'] = false;
			$response['messages'] = "Data Available in Another Records";

			echo json_encode($response);
		}
		else
		{
			$response = array();
			if($table_id) {
				$delete = $this->model_parcel->remove($table_id);
				if($delete == true) {
					$response['success'] = true;
					$response['messages'] = "Successfully removed";	
				}
				else {
					$response['success'] = false;
					$response['messages'] = "Error in the database while removing the brand information";
				}
			}
			else {
				$response['success'] = false;
				$response['messages'] = "Refersh the page again!!";
			}

			echo json_encode($response);
		}
	}

}