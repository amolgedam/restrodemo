<?php 

class Expences extends Admin_Controller 
{
	public function __construct()
	{
		parent::__construct();
		
		$this->not_logged_in();

		$this->data['page_title'] = 'ZEON ERP';

		$this->load->model('model_paymentor');
		$this->load->model('model_expences');
		$this->load->model('model_waiter');
        $this->load->model('model_users');
        
	}

	public function index()
	{
		// if(!in_array('viewManageExpences', $this->permission)){
  //           redirect('dashboard', 'refresh');
  //       }

		// $this->data['paymentmethod'] = $this->model_paymentor->fecthActivePaymentorData();
		$this->data['allData'] = $this->model_expences->fecthAllExpencesData();
		$this->render_template('expences/index', $this->data);
	}

    public function check_selctionoption($option)
    {
        if ($option === '0')  {
            $this->form_validation->set_message('check_selctionoption', 'Please Select Required Fields.');
            return FALSE;
        }
        else {
            return TRUE;
        }
    }

	public function create()
	{
		// if(!in_array('createManageExpences', $this->permission)){
  //           redirect('dashboard', 'refresh');
  //       }

        $this->data['paymentmethod'] = $this->model_paymentor->fecthActivePaymentorData();
        $this->data['exp_cat'] = $this->model_expences->fecthActiveCategoryData();
        $this->data['waiter'] = $this->model_waiter->fecthAllData();
		// $this->data['allData'] = $this->model_expences->fecthAllExpencesData();

        $this->form_validation->set_rules('expensename', 'Expences Name', 'trim|required');
		$this->form_validation->set_rules('expences_cat', 'Expences Category', 'trim|required|callback_check_selctionoption');
		$this->form_validation->set_rules('date', 'Expences Date', 'trim|required');
        $this->form_validation->set_rules('amount', 'Amount', 'trim|required');
		$this->form_validation->set_rules('pstatus', 'Paid Status', 'trim|required|callback_check_selctionoption');
		$this->form_validation->set_rules('payment_method', 'Payment Method', 'trim|required');

        // $this->form_validation->set_message('check_selctionoption', 'Select Required Fields');


        if ($this->form_validation->run() == TRUE) {

        	$config['upload_path'] = './assets/images/exp_img/';
	    	$config['allowed_types'] = 'jpeg|jpg|png|';
	    	$config['max_size'] = 1024 * 8;
	    	// echo "hi";exit();

	    	$this->load->library('upload', $config);
			$this->upload->initialize($config);

	    	$this->upload->do_upload('file');	

	    	$file = $this->upload->data();

        	$data = array(
        		'name' => $this->input->post('expensename'),
        		'users_id' => $this->input->post('emp'),
        		'date' => $this->input->post('date'),
        		'description' => $this->input->post('description'),	
                'amount' => $this->input->post('amount'),
                'pamt' => $this->input->post('paidamount'),
                'bamt' => $this->input->post('balamount'),
                'pstatus' => $this->input->post('pstatus'),
        		'pdate' => $this->input->post('pdate'),
        		'expcat_id' => $this->input->post('expences_cat'),	
        		'payment_method' => $this->input->post('payment_method'),	
        		'cheque_no' => $this->input->post('cheque_no'),	
        		'reference' => $this->input->post('reference'),	
        		'description' => $this->input->post('description'),	
        		'file' => $file['file_name']
        	);
        	// print_r($data);exit();

        	$create = $this->model_expences->createExpences($data);

        	if($create == true) {

        		$this->session->set_flashdata('feedback','Data Saved Successfully');
				$this->session->set_flashdata('feedback_class','alert alert-success');
				return redirect('expences');
        	}
        	else {
        		
        		$this->session->set_flashdata('feedback','Unable to Saved Data');
				$this->session->set_flashdata('feedback_class','alert alert-danger');
				return redirect('expences');
			}
        }
        else
        {
			$this->render_template('expences/create', $this->data);
        }
	}

	public function updateExpences()
	{
		// if(!in_array('updateManageExpences', $this->permission)){
  //           redirect('dashboard', 'refresh');
  //       }

        $this->data['paymentmethod'] = $this->model_paymentor->fecthActivePaymentorData();
        $this->data['exp_cat'] = $this->model_expences->fecthActiveCategoryData();
        $this->data['waiter'] = $this->model_waiter->fecthAllData();
        
		$this->data['allData'] = $this->model_expences->fecthAllExpencesData();

        $this->form_validation->set_rules('expensename', 'Expences Name', 'trim|required');
		$this->form_validation->set_rules('expences_cat', 'Expences Category', 'trim|required|callback_check_selctionoption');

        // $this->form_validation->set_rules('date', 'Expences Date', 'trim|required');
        $this->form_validation->set_rules('amount', 'Amount', 'trim|required');
        $this->form_validation->set_rules('pstatus', 'Paid Status', 'trim|required|callback_check_selctionoption');
        $this->form_validation->set_rules('payment_method', 'Payment Method', 'trim|required');

		
        if ($this->form_validation->run() == TRUE) {

            $config['upload_path'] = './assets/images/exp_img/';
	    	$config['allowed_types'] = 'jpeg|jpg|png|';
	    	$config['max_size'] = 1024 * 8;
	    	// echo "hi";exit();

	    	$this->load->library('upload', $config);
			$this->upload->initialize($config);

	    	$this->upload->do_upload('file');

	    	$file = $this->upload->data();

            $waiter = $this->model_waiter->getDataByName($this->input->post('empname')[0]);

            if($file['file_name'] != '')
            {
                $data = array(
                    'id' => $this->input->post('id'),
                    'name' => $this->input->post('expensename'),
                    'users_id' => $waiter['id'],
                    'date' => $this->input->post('date'),
                    'description' => $this->input->post('description'), 
                    'amount' => $this->input->post('amount'),
                    'pamt' => $this->input->post('paidamount'),
                    'bamt' => $this->input->post('balamount'),
                    'pstatus' => $this->input->post('pstatus'),
                    'pdate' => $this->input->post('pdate'),
                    'expcat_id' => $this->input->post('expences_cat'),
                    'payment_method' => $this->input->post('payment_method'),   
                    'cheque_no' => $this->input->post('cheque_no'), 
                    'reference' => $this->input->post('reference'),
                    'description' => $this->input->post('description'),     
                    'file' => $file['file_name']    
                );
            }
            else
            {
                $data = array(
                    'id' => $this->input->post('id'),
                    'name' => $this->input->post('expensename'),
                    'users_id' => $waiter['id'],
                    'date' => $this->input->post('date'),
                    'description' => $this->input->post('description'), 
                    'amount' => $this->input->post('amount'),
                    'pamt' => $this->input->post('paidamount'),
                'bamt' => $this->input->post('balamount'),
                    'pstatus' => $this->input->post('pstatus'),
                    'pdate' => $this->input->post('pdate'),
                    'expcat_id' => $this->input->post('expences_cat'),
                    'payment_method' => $this->input->post('payment_method'),   
                    'cheque_no' => $this->input->post('cheque_no'), 
                    'reference' => $this->input->post('reference'),
                    'description' => $this->input->post('description'),     
                );
            }

            // echo "<pre>"; print_r($data); exit();

        	$create = $this->model_expences->updateMyExpences($data);

        	if($create == true) {

        		$this->session->set_flashdata('feedback','Data Saved Successfully');
				$this->session->set_flashdata('feedback_class','alert alert-success');
				return redirect('expences');
        	}
        	else {
        		
        		$this->session->set_flashdata('feedback','Unable to Saved Data');
				$this->session->set_flashdata('feedback_class','alert alert-danger');
				return redirect('expences');
			}
        }
        else
        {
        	$supplier_id = $this->uri->segment(3);

        	$this->data['expencesData'] = $this->model_expences->fecthDataByID($supplier_id);
			
			$this->render_template('expences/update', $this->data);
        }
	}

	public function deleteExpences()
	{
		// if(!in_array('updateManageExpences', $this->permission)){
  //           redirect('dashboard', 'refresh');
  //       }

		$id = $this->input->post('id_edit');

        $expData = $this->model_expences->fecthDataByID($id);
        $expCatData = $this->model_expences->fecthCategoryDataByID($expData['expcat_id']);
        $paymentData = $this->model_paymentor->fecthAllDataById($expData['payment_method']);

        // if($expCatData['id'] != '')
        // {
        //     $this->session->set_flashdata('feedback','Data Available in Another Records');
        //     $this->session->set_flashdata('feedback_class','alert alert-danger');
        //     return redirect('expences');
        // }
        // else if($paymentData['id'] != '')
        // {
        //     $this->session->set_flashdata('feedback','Data Available in Another Records');
        //     $this->session->set_flashdata('feedback_class','alert alert-danger');
        //     return redirect('expences');
        // }
        // else
        // {
            $delete = $this->model_expences->deleteExpences($id);   
        
            if($delete == true) {

                $this->session->set_flashdata('feedback','Record Deleted Successfully');
                $this->session->set_flashdata('feedback_class','alert alert-success');
                return redirect('expences');
            }
            else{

                $this->session->set_flashdata('feedback','Unable to Delete Record');
                $this->session->set_flashdata('feedback_class','alert alert-danger');
                return redirect('expences');
            }
        // }
	}

	
	// #####################################################################
	//	Category 
	// #####################################################################

	public function category()
	{
		// if(!in_array('viewExpencesCategory', $this->permission)){
  //           redirect('dashboard', 'refresh');
  //       }

		$this->data['allData'] = $this->model_expences->fecthAllCategoryData();
        
		$this->render_template('expences/category', $this->data);
	}

	public function createExpencesCategory()
	{
		// if(!in_array('createExpencesCategory', $this->permission)){
  //           redirect('dashboard', 'refresh');
  //       }

		$this->form_validation->set_rules('name', 'Category', 'trim|required|is_unique[expences_category.name]');
		// $this->form_validation->set_rules('type', 'Expences Type Name', 'trim|required');
		$this->form_validation->set_rules('status', 'Active', 'trim|required');

        if ($this->form_validation->run() == TRUE) {

        	$data = array(
        		'name' => $this->input->post('name'),
        		// 'type' => $this->input->post('type'),
        		'status' => $this->input->post('status'),	
        	);
        	// print_r($data); exit();
        	$create = $this->model_expences->createExpencesCategory($data);

        	if($create == true) {
        		
        		$this->session->set_flashdata('feedback','Data Saved Successfully');
				$this->session->set_flashdata('feedback_class','alert alert-success');
				return redirect('expences/category');
        	}
        	else {
        		
        		$this->session->set_flashdata('feedback','Unable to Saved Data');
				$this->session->set_flashdata('feedback_class','alert alert-danger');
				return redirect('expences/category');
        	}
        }
        else
        {
            $this->data['allData'] = $this->model_expences->fecthAllCategoryData();
        
            $this->render_template('expences/category', $this->data);
        }
	}

	public function updateExpencesCategory()
	{
		// if(!in_array('updateExpencesCategory', $this->permission)){
  //           redirect('dashboard', 'refresh');
  //       }

		$this->form_validation->set_rules('edit_expname', 'Category', 'trim|required');
		// $this->form_validation->set_rules('edit_exptype', 'Expences Type Name', 'trim|required');
		$this->form_validation->set_rules('edit_expstatus', 'Active', 'trim|required');

		if ($this->form_validation->run() == TRUE) {
        	$data = array(
        		'id' => $this->input->post('edit_expid'),
        		'name' => $this->input->post('edit_expname'),
        		'status' => $this->input->post('edit_expstatus'),	
        	);
        	// print_r($data); exit();
        	$create = $this->model_expences->updateExpencesCategory($data);

        	if($create == true) {
        		
        		$this->session->set_flashdata('feedback','Data Saved Successfully');
				$this->session->set_flashdata('feedback_class','alert alert-success');
				return redirect('expences/category');
        	}
        	else {
        		
        		$this->session->set_flashdata('feedback','Unable to Saved Data');
				$this->session->set_flashdata('feedback_class','alert alert-danger');
				return redirect('expences/category');
        	}
        }
        else
        {
            $this->data['allData'] = $this->model_expences->fecthAllCategoryData();
        
            $this->render_template('expences/category', $this->data);
        }
	}

	public function deleteExpencesCategory()
	{
		// if(!in_array('deleteExpencesCategory', $this->permission)){
  //           redirect('dashboard', 'refresh');
  //       }
        
		$id = $this->input->post('id_edit');

        $expData  = $this->model_expences->fecthDataByExpCatId($id);
        // echo "<pre>"; print_r($expData); exit();

        if($expData['id'] == '')
        {
            $delete = $this->model_expences->deleteExpencesCategory($id);   
        
            if($delete == true) {

                $this->session->set_flashdata('feedback','Record Deleted Successfully');
                $this->session->set_flashdata('feedback_class','alert alert-success');
                return redirect('expences/category');
            }
            else{

                $this->session->set_flashdata('feedback','Unable to Delete Record');
                $this->session->set_flashdata('feedback_class','alert alert-danger');
                return redirect('expences/category');
            }
        }
        else
        {
            $this->session->set_flashdata('feedback','Data Available in Another Records');
            $this->session->set_flashdata('feedback_class','alert alert-danger');
            return redirect('expences/category');      
        }
		
	}


}	