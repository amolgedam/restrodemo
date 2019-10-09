<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Products extends Admin_Controller 
{
	public function __construct()
	{
		parent::__construct();

		$this->not_logged_in();

		$this->data['page_title'] = 'ZEON ERP';

		$this->load->model('model_products');
		$this->load->model('model_category');
		$this->load->model('model_stores');
		$this->load->model('model_gst');
        $this->load->model('model_unittype');
		$this->load->model('model_orders');
        $this->load->model('model_users');
        
	}

    /* 
    * It only redirects to the manage product page
    */
	public function index()
	{
        if(!in_array('viewProduct', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

		$this->render_template('products/index', $this->data);	
	}

    public function getDataByName()
    {
        $name = $_POST['product_name'];
        $data = $this->model_products->getProductDataByName($name);
        echo json_encode($data);
    }

    public function getDataByCode()
    {
        $pcode = $_POST['pcode'];
        $data = $this->model_products->getProductDataBySrNo($pcode);
        echo json_encode($data);
    }

    /*
    * It Fetches the products data from the product table 
    * this function is called from the datatable ajax function
    */
	public function fetchProductData()
	{
        if(!in_array('viewProduct', $this->permission)) {
            redirect('dashboard', 'refresh');
        }
        
		$result = array('data' => array());

		$data = $this->model_products->getProductData();
        // echo "<pre>"; print_r($data); exit();
        
        $no = 1;
		foreach ($data as $key => $value) {

            $store_ids = json_decode($value['store_id']);
            
            $store_name = array();
            foreach ($store_ids as $k => $v) {
                $store_data = $this->model_stores->getStoresData($v);
                $store_name[] = $store_data['name'];
            }


            $pcode = $value['sr_no'] == '' ? "None" : $value['sr_no'];

            $store_name = implode(', ', $store_name);
            
            $category_data = $this->model_category->getCategoryData($value['category_id']);
            
            $unit = $this->model_unittype->fecthAllDataByID($value['unit_id']);

            $gstdata = $this->model_gst->fecthAllDataByID($value['gst_id']);

            // $category_ids = json_decode($value['category_id']);
            
            // $category_name = array();
            // foreach ($category_ids as $k => $v) {
            //     $category_data = $this->model_category->getCategoryData($v);
            //     $category_name[] = $category_data['name'];
            // }

            // $category_name = implode(', ', $category_name);

			// button
            $buttons = '';
            if(in_array('updateProduct', $this->permission)) {
    			$buttons .= '<a href="'.base_url('products/update/'.$value['id']).'" class="btn btn-sm btn-info"><i class="fa fa-pencil"></i></a>';
            }

            if(in_array('deleteProduct', $this->permission)) { 
    			$buttons .= ' <button type="button" class="btn btn-sm btn-danger" onclick="removeFunc('.$value['id'].')" data-toggle="modal" data-target="#removeModal"><i class="fa fa-trash"></i></button>';
            }

			$img = '<img src="'.base_url($value['image']).'" alt="'.$value['name'].'" class="img-circle" width="50" height="50" />';

            $availability = ($value['active'] == 1) ? '<span class="label label-success">Active</span>' : '<span class="label label-warning">Inactive</span>';

			$result['data'][$key] = array(
				// $img,
				$no,
				$pcode,
				$value['name'],
				$category_data['name'],
                $unit['name'],
				$gstdata['name'],
				//$value['unit_id'],
                $value['price'],
                $availability,
				$buttons
			);
			$no++;
		} // /foreach

		echo json_encode($result);
        // echo "<pre>"; print_r($result); exit();
	}	
    
    /*
    * view the product based on the store 
    * the admin can view all the product information
    */
    public function viewproduct()
    {
        if(!in_array('viewProduct', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $company_currency = $this->company_currency();
        // get all the category 
        $category_data = $this->model_category->getCategoryData();

        $result = array();
        
        foreach ($category_data as $k => $v) {
            $result[$k]['category'] = $v;
            $result[$k]['products'] = $this->model_products->getProductDataByCat($v['id']);
        }

        // based on the category get all the products 

        $html = '<!-- Main content -->
                    <!DOCTYPE html>
                    <html>
                    <head>
                      <meta charset="utf-8">
                      <meta http-equiv="X-UA-Compatible" content="IE=edge">
                      <title>Invoice</title>
                      <!-- Tell the browser to be responsive to screen width -->
                      <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
                      <!-- Bootstrap 3.3.7 -->
                      <link rel="stylesheet" href="'.base_url('assets/bower_components/bootstrap/dist/css/bootstrap.min.css').'">
                      <!-- Font Awesome -->
                      <link rel="stylesheet" href="'.base_url('assets/bower_components/font-awesome/css/font-awesome.min.css').'">
                      <link rel="stylesheet" href="'.base_url('assets/dist/css/AdminLTE.min.css').'">
                    </head>
                    <body>
                    
                    <div class="wrapper">
                      <section class="invoice">

                        <div class="row">
                        ';
                            foreach ($result as $k => $v) {
                                $html .= '<div class="col-md-6">
                                    <div class="product-info">
                                        <div class="category-title">
                                            <h1>'.$v['category']['name'].'</h1>
                                        </div>';

                                        if(count($v['products']) > 0) {
                                            foreach ($v['products'] as $p_key => $p_value) {
                                                $html .= '<div class="product-detail">
                                                            <div class="product-name" style="display:inline-block;">
                                                                <h5>'.$p_value['name'].'</h5>
                                                            </div>
                                                            <div class="product-price" style="display:inline-block;float:right;">
                                                                <h5>'.$company_currency . ' ' . $p_value['price'].'</h5>
                                                            </div>
                                                        </div>';
                                            }
                                        }
                                        else {
                                            $html .= 'N/A';
                                        }        
                                    $html .='</div>
                                        
                                </div>';
                            }
                        

                        $html .='
                        </div>
                      </section>
                      <!-- /.content -->
                    </div>
                </body>
            </html>';

                      echo $html;
    }

    public function check_selctionoption($option)
    {
        if ($option === '0')  {
            $this->form_validation->set_message('check_selctionoption', 'Select Required Fields.');
            return FALSE;
        }
        else {
            return TRUE;
        }
    }


    /*
    * If the validation is not valid, then it redirects to the create page.
    * If the validation for each input field is valid then it inserts the data into the database 
    * and it stores the operation message into the session flashdata and display on the manage product page
    */


	public function create()
	{
		if(!in_array('createProduct', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $this->form_validation->set_rules('sr_no', 'Sr No.', 'trim|is_unique[products.sr_no]');
		$this->form_validation->set_rules('product_name', 'Product Name', 'trim|required|is_unique[products.name]');
		$this->form_validation->set_rules('price', 'Price', 'trim|required|numeric');
        // $this->form_validation->set_rules('category', '&nbsp;', 'trim|required|callback_check_selctionoption');
        // $this->form_validation->set_rules('store', '&nbsp;Store', 'trim|required|callback_check_selctionoption');
        $this->form_validation->set_rules('unit', 'Unit', 'trim|required|callback_check_selctionoption');
		$this->form_validation->set_rules('gst', 'GST', 'trim|required|callback_check_selctionoption');
		
	
        if ($this->form_validation->run() == TRUE) {
            // true case
        	// $upload_image = $this->upload_image();

        	$data = array(
        	    'sr_no' => $this->input->post('sr_no'),
        		'name' => $this->input->post('product_name'),
        		'price' => $this->input->post('price'),
        		// 'image' => $upload_image,
        		'description' => $this->input->post('description'),
                'gst_id' => $this->input->post('gst'),
				'unit_id' => $this->input->post('unit'),
				// 'sgst' => $this->input->post('sgst'),
        		'category_id' => $this->input->post('category'),
                'store_id' => json_encode($this->input->post('store')),
        		'active' => $this->input->post('active'),
        	); 
            // print_r($data);exit();
        	$create = $this->model_products->create($data);
        	if($create == true) {
        		$this->session->set_flashdata('success', 'Successfully created');
        		redirect('products/', 'refresh');
        	}
        	else {
        		$this->session->set_flashdata('errors', 'Error occurred!!');
        		redirect('products/create', 'refresh');
        	}
        }
        else {
            // false case

        	// attributes 
        	// $attribute_data = $this->model_attributes->getActiveAttributeData();


        	// $this->data['attributes'] = $attributes_final_data;
			// $this->data['brands'] = $this->model_brands->getActiveBrands();        	
			$this->data['category'] = $this->model_category->getActiveCategory();        	
			$this->data['stores'] = $this->model_stores->getActiveStore();        	
            $this->data['tsgst'] = $this->model_gst->fecthfecthSgst();
			$this->data['tcgst'] = $this->model_gst->fecthfecthCgst();

            $this->data['unit_type'] = $this->model_unittype->fecthAllData();
            $this->data['gst'] = $this->model_gst->fecthAllData();
            
            $this->render_template('products/create', $this->data);
        }	
	}

    /*
    * This function is invoked from another function to upload the image into the assets folder
    * and returns the image path
    */
	public function upload_image()
    {
    	// assets/images/product_image
        $config['upload_path'] = 'assets/images/product_image';
        $config['file_name'] =  uniqid();
        $config['allowed_types'] = 'gif|jpg|png';
        $config['max_size'] = '1000';

        // $config['max_width']  = '1024';s
        // $config['max_height']  = '768';

        $this->load->library('upload', $config);
        if ( ! $this->upload->do_upload('product_image'))
        {
            $error = $this->upload->display_errors();
            return $error;
        }
        else
        {
            $data = array('upload_data' => $this->upload->data());
            $type = explode('.', $_FILES['product_image']['name']);
            $type = $type[count($type) - 1];
            
            $path = $config['upload_path'].'/'.$config['file_name'].'.'.$type;
            return ($data == true) ? $path : false;            
        }
    }

    /*
    * If the validation is not valid, then it redirects to the edit product page 
    * If the validation is successfully then it updates the data into the database 
    * and it stores the operation message into the session flashdata and display on the manage product page
    */
	public function update($product_id)
	{      
        if(!in_array('updateProduct', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        if(!$product_id) {
            redirect('dashboard', 'refresh');
        }
        
        $this->form_validation->set_rules('product_name', 'Product Name', 'trim|required');
        $this->form_validation->set_rules('price', 'Price', 'trim|required');
        // $this->form_validation->set_rules('active', '', 'trim|required');
         $this->form_validation->set_rules('unit', 'Unit', 'trim|required|callback_check_selctionoption');
        $this->form_validation->set_rules('gst', 'GST', 'trim|required|callback_check_selctionoption');
        
        if ($this->form_validation->run() == TRUE) {
            // true case
            
            $data = array(
                'sr_no' => $this->input->post('sr_no'),
                'name' => $this->input->post('product_name'),
                'price' => $this->input->post('price'),
                'gst_id' => $this->input->post('gst'),
                'unit_id' => $this->input->post('unit'),
                'description' => $this->input->post('description'),
                'category_id' => $this->input->post('category'),
                'store_id' => json_encode($this->input->post('store')),
                'active' => $this->input->post('active'),
            );
            
            // if($_FILES['product_image']['size'] > 0) {
            //     $upload_image = $this->upload_image();
            //     $upload_image = array('image' => $upload_image);
                
            //     $this->model_products->update($upload_image, $product_id);
            // }

            $update = $this->model_products->update($data, $product_id);
            if($update == true) {
                $this->session->set_flashdata('success', 'Successfully updated');
                redirect('products/', 'refresh');
            }
            else {
                $this->session->set_flashdata('errors', 'Error occurred!!');
                redirect('products/update/'.$product_id, 'refresh');
            }
        }
        else {
                    
            $this->data['category'] = $this->model_category->getActiveCategory();           
            $this->data['stores'] = $this->model_stores->getActiveStore();          

            $product_data = $this->model_products->getProductData($product_id);
            $this->data['product_data'] = $product_data;

              $this->data['unit_type'] = $this->model_unittype->fecthAllData();
            $this->data['gst'] = $this->model_gst->fecthAllData();

            $this->render_template('products/edit', $this->data); 
        }   
	}

    /*
    * It removes the data from the database
    * and it returns the response into the json format
    */
	public function remove()
	{
        if(!in_array('deleteProduct', $this->permission)) {
            redirect('dashboard', 'refresh');
        }
        
        $product_id = $this->input->post('product_id');

        $productData = $this->model_orders->existInProductIdorder($product_id);

        if($productData > 0)
        {
            $response['success'] = false;
            $response['messages'] = "Data Available in Another Records";
            echo json_encode($response);
        }
        else
        {
            $response = array();
            if($product_id) {
                $delete = $this->model_products->remove($product_id);
                if($delete == true) {
                    $response['success'] = true;
                    $response['messages'] = "Successfully removed"; 
                }
                else {
                    $response['success'] = false;
                    $response['messages'] = "Error in the database while removing the product information";
                }
            }
            else {
                $response['success'] = false;
                $response['messages'] = "Refersh the page again!!";
            }

            echo json_encode($response);
        }

	}
	
	public function productData()
	{
	    $data = $this->model_products->getProductData();
	    echo json_encode($data);
	}

}