<?php 

class Gst extends Admin_Controller 
{
	public function __construct()
	{
		parent::__construct();

		$this->not_logged_in();


		$this->data['page_title'] = 'ZEON ERP';
		
		$this->load->model('model_gst');
		$this->load->model('model_products');
		// $this->load->model('model_orders');
		$this->load->model('model_users');
		// $this->load->model('model_stores');
	}

	public function fecthAllData()
	{
		$data = $this->model_gst->fecthAllData();
        echo json_encode($data);
	}

	public function fecthAllDataByID()
	{
		$id = $_POST['gst_id'];
		$data = $this->model_gst->fecthAllDataByID($id);
        echo json_encode($data);
	}

	public function fecthSgstData()
	{
		$data = $this->model_gst->fecthfecthSgst();
        echo json_encode($data);
	}

	

	public function fecthCgstData()
	{
		$data = $this->model_gst->fecthfecthCgst();
        echo json_encode($data);
	}

	public function index()
	{
		// $this->data['total_products'] = $this->model_products->countTotalProducts();
		// $this->data['total_paid_orders'] = $this->model_orders->countTotalPaidOrders();
		// $this->data['total_users'] = $this->model_users->countTotalUsers();
		// $this->data['total_stores'] = $this->model_stores->countTotalStores();


		$this->data['allData'] = $this->model_gst->fecthAllData();

		
		$user_id = $this->session->userdata('id');
		$is_admin = ($user_id == 1) ? true :false;	
		// echo "hi";exit();
		$this->render_template('gst/index', $this->data);
	}

	public function create()
	{ 
		// print_r($this->input->post());
	    $this->form_validation->set_rules('gst_name', 'Gst Name;', 'trim|required|is_unique[gst.name]');

		if($this->form_validation->run()){	

			$data = array(
							'name' => $this->input->post('gst_name'),
							'hsn' => $this->input->post('hsn'),
							'sgst' => $this->input->post('sgst'),
							'cgst' => $this->input->post('cgst'),
							'igst' => $this->input->post('igst'),
							'total_gst' => $this->input->post('sgst') + $this->input->post('cgst') + $this->input->post('igst')
						);
			// print_r($data);	exit();
			$create = $this->model_gst->createGst($data);

			if($create == true) {

        		$this->session->set_flashdata('feedback','Data Saved Successfully');
				$this->session->set_flashdata('feedback_class','alert alert-success');
				return redirect('gst');
        	}
        	else{

        		$this->session->set_flashdata('feedback','Unable to Saved Data');
				$this->session->set_flashdata('feedback_class','alert alert-danger');
				return redirect('gst');
        	}
		}
		else
		{
			$this->data['allData'] = $this->model_gst->fecthAllData();

			$user_id = $this->session->userdata('id');
			$is_admin = ($user_id == 1) ? true :false;	

			$this->render_template('gst/index', $this->data);
		}
	}

	public function updateGst()
	{
	    $this->form_validation->set_rules('gst_name_edit', 'GST Name', 'trim|required');

		if($this->form_validation->run('updateGst')){
			$data = array(
							'gst_id' => $this->input->post('gst_id_edit'),
							'name' => $this->input->post('gst_name_edit'),
							'hsn' => $this->input->post('hsn_name_edit'),
							'sgst' => $this->input->post('sgst_edit'),
							'cgst' => $this->input->post('cgst_edit'),
							'igst' => $this->input->post('igst_edit'),
							'total_gst' => $this->input->post('sgst_edit') + $this->input->post('cgst_edit') + $this->input->post('igst_edit')
						);

			// print_r($data); exit();
			$update = $this->model_gst->updateGst($data);

			if($update == true) {

        		$this->session->set_flashdata('feedback','Record Update Successfully');
				$this->session->set_flashdata('feedback_class','alert alert-success');
				return redirect('gst', 'refresh');
        	}
        	else{

        		$this->session->set_flashdata('feedback','Unable to Update Record');
				$this->session->set_flashdata('feedback_class','alert alert-danger');
				return redirect('gst', 'refresh');
        	}
		}
		else
		{
			$this->data['allData'] = $this->model_gst->fecthAllData();

			$user_id = $this->session->userdata('id');
			$is_admin = ($user_id == 1) ? true :false;	

			$this->render_template('gst/index', $this->data);
		}
	}

	public function deleteGst()
	{
		$gst_id = $this->input->post('gst_id_edit');

		$productData  = $this->model_products->existInGstinProduct($gst_id);
		// echo "<pre>"; print_r($productData); exit();

		if($productData > 0)
		{
			$this->session->set_flashdata('feedback','Data Available in Another Records');
			$this->session->set_flashdata('feedback_class','alert alert-danger');
			return redirect('gst', 'refresh');
		}
		else
		{
			$delete = $this->model_gst->deleteGst($gst_id);	

			if($delete == true) {

	    		$this->session->set_flashdata('feedback','Record Deleted Successfully');
				$this->session->set_flashdata('feedback_class','alert alert-success');
				return redirect('gst', 'refresh');
	    	}
	    	else{

	    		$this->session->set_flashdata('feedback','Unable to Delete Record');
				$this->session->set_flashdata('feedback_class','alert alert-danger');
				return redirect('gst', 'refresh');
	    	}
		}
	}



}