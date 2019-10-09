<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Company extends Admin_Controller 
{
	public function __construct()
	{
		parent::__construct();

		$this->not_logged_in();

		$this->data['page_title'] = 'ZEON ERP';

		$this->load->model('model_company');
        $this->load->model('model_users');
        
	}

    /* 
    * It redirects to the company page and displays all the company information
    * It also updates the company information into the database if the 
    * validation for each input field is successfully valid
    */
	public function index()
	{  
        if(!in_array('updateCompany', $this->permission)) {
            redirect('dashboard', 'refresh');
        }
        
		$this->form_validation->set_rules('company_name', 'Company name', 'trim|required');
// 		$this->form_validation->set_rules('service_charge_value', 'Charge Amount', 'trim|integer');
// 		$this->form_validation->set_rules('vat_charge_value', 'Vat Charge', 'trim|integer');
		$this->form_validation->set_rules('address', 'Address', 'trim|required');
// 		$this->form_validation->set_rules('message', 'Message', 'trim|required');
	
	
        if ($this->form_validation->run() == TRUE) {
            // true case
            
            
            $config['upload_path'] = './assets/images/companyimg/';
            $config['allowed_types'] = 'jpeg|jpg|png|';
            $config['max_size'] = 1024 * 8;

            $this->load->library('upload', $config);
            $this->upload->initialize($config);

            $this->upload->do_upload('img');

            $img = $this->upload->data();
            

        if($img['file_name'] == '')
            {
                $data = array(
                    'company_name' => $this->input->post('company_name'),
                    // 'service_charge_value' => $this->input->post('service_charge_value'),
                    // 'vat_charge_value' => $this->input->post('vat_charge_value'),
                    'email' => $this->input->post('email'),
                    'address' => $this->input->post('address'),
                    'state' => $this->input->post('state'),
                    'city' => $this->input->post('city'),
                    'postal_code' => $this->input->post('postal_code'),
                    'gstin' => $this->input->post('gstin'),
                    'pan' => $this->input->post('pan'),
                    'phone' => $this->input->post('phone'),
                    // 'country' => $this->input->post('country'),
                    // 'message' => $this->input->post('message'),
                    // 'img' =>  $img['file_name'],
                    // 'currency' => $this->input->post('currency'),
                );
            }
            else
            {
                $data = array(
                    'company_name' => $this->input->post('company_name'),
                    // 'service_charge_value' => $this->input->post('service_charge_value'),
                    // 'vat_charge_value' => $this->input->post('vat_charge_value'),
                    'email' => $this->input->post('email'),
                    'address' => $this->input->post('address'),
                    'state' => $this->input->post('state'),
                    'city' => $this->input->post('city'),
                    'postal_code' => $this->input->post('postal_code'),
                    'gstin' => $this->input->post('gstin'),
                    'pan' => $this->input->post('pan'),
                    'phone' => $this->input->post('phone'),
                    // 'country' => $this->input->post('country'),
                    // 'message' => $this->input->post('message'),
                    'img' =>  $img['file_name'],
                    // 'currency' => $this->input->post('currency'),
                );
            }
            
            // echo "<pre>"; print_r($data); exit();

            $this->session->set_userdata('companyImg', $img['file_name']);
            $this->session->set_userdata('company_name', $this->input->post('company_name'));

        	$update = $this->model_company->update($data, 1);
        	if($update == true) {
        		$this->session->set_flashdata('success', 'Successfully created');
        		redirect('dashboard/', 'refresh');
        	}
        	else {
        		$this->session->set_flashdata('errors', 'Error occurred!!');
        		redirect('company/index', 'refresh');
        	}
        }
        else {

            // false case
            $this->data['currency_symbols'] = $this->currency();
        	$this->data['company_data'] = $this->model_company->getCompanyData(1);
			$this->render_template('company/index', $this->data);			
        }	

		
	}

}