<?php

defined('BASEPATH') OR exit('No direct script access allowed');
error_reporting(0);
class Orders extends Admin_Controller 
{
	var $currency_code = '';

	public function __construct()
	{
		parent::__construct();

		$this->not_logged_in();

		$this->data['page_title'] = 'ZEON ERP';

		$this->load->model('model_orders');
		$this->load->model('model_tables');
		$this->load->model('model_products');
		$this->load->model('model_company');
		$this->load->model('model_stores');
		$this->load->model('model_gst');
		$this->load->model('model_waiter');
		$this->load->model('model_salestype');
		$this->load->model('model_paymentor');
		$this->load->model('model_users');
		

		$this->currency_code = $this->company_currency();
	}
	
		public function viewOrder($order_id)
		{
		    if(!in_array('viewOrder', $this->permission)) {
                redirect('dashboard', 'refresh');
            }
    
    		$this->data['page_title'] = 'View Orders';
    
            $data['product'] = $this->model_orders->viewData($order_id);
		    $data['productData'] = $this->model_orders->viewProductData($order_id);
            // print_r($data['product']);exit;
    		$this->render_template('orders/viewOrder', $this->data);
		}

	/* 
	* It only redirects to the manage order page
	*/
	public function index()
	{
		if(!in_array('viewOrder', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

		$this->data['page_title'] = 'Manage Orders';

        $this->data['ordersData'] = $this->model_orders->fecthAllOrderData();          	

		$this->render_template('orders/index', $this->data);		
	}

	/*
	* Fetches the orders data from the orders table 
	* this function is called from the datatable ajax function
	*/
	public function fetchOrdersData()
	{
		if(!in_array('viewOrder', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

		$result = array('data' => array());

		$data = $this->model_orders->getOrdersData();
        // echo "<pre>"; print_r($data); exit();
        $no = 1;
		foreach ($data as $key => $value) {

			$store_data = $this->model_stores->getStoresData($value['store_id']);

			$count_total_item = $this->model_orders->countOrderItem($value['id']);
			$date = date('d-m-Y', $value['date_time']);
// 			$time = date('h:i a', $value['date_time']);

// 			$date_time = $date . ' ' . $time;

			if($value['paid_status'] == 1) {
				$paid_status = '<span class="label label-success">Paid</span>';
				$disabled = "disabled";
			}
			else {
				$paid_status = '<span class="label label-warning">Not Paid</span>';
				$disabled = "";
			}

			if($value['ordertype'] == 'tb')
			{
				$table_data = $this->model_tables->getTableData($value['table_id']);
				$type = $table_data['table_name'];
			}
			else
			{
				$type = "Parcel";
			}

			if($value['waiter'] != 0)
			{
				$waiterData = $this->model_waiter->fecthAllDataById($value['waiter']);
				$waiterName = $waiterData['name'];
			}
			else
			{
				$waiterName = "None";
			}

			if($value['sales_type'] != 0)
			{
				$salesTypeData = $this->model_salestype->fecthDataByID($value['sales_type']);
				$sales_type = $salesTypeData['name'];
			}
			else
			{
				$sales_type = "None";
			}



			$waiter = 

			// button 
			$buttons = '';


			if(in_array('updateOrder', $this->permission)) {

				if($value['ordertype'] == 'tb')
				{
					if($value['paid_status'] == 1)
					{
						$buttons .= ' <a href="'.base_url('order/confirmTable/'.$value['id']).'" class="btn btn-sm btn-info"><i class="fa fa-pencil"></i></a>';
					}
					else
					{
						$buttons .= ' <a href="'.base_url('order/updateTableOrder/'.$value['id']).'" class="btn btn-sm btn-info"><i class="fa fa-pencil"></i></a>';
					}
				}
				else
				{
					if($value['paid_status'] == 1)
					{
						$buttons .= ' <a href="'.base_url('order/confirmParcel/'.$value['id']).'" class="btn btn-sm btn-info"><i class="fa fa-pencil"></i></a>';
					}
					else
					{
						$buttons .= ' <a href="'.base_url('order/updateParcel/'.$value['id']).'" class="btn btn-sm btn-info"><i class="fa fa-pencil"></i></a>';
					}
				}
			}

			if(in_array('deleteOrder', $this->permission)) {
				$buttons .= ' <button type="button" class="btn btn-sm btn-danger" onclick="removeFunc('.$value['id'].')" data-toggle="modal" data-target="#removeModal"><i class="fa fa-trash"></i></button>';
			}
            
            if($value['paid_status'] == 1) {
			    $buttons .= '&nbsp;<a target="__blank" href="'.base_url().'orders/printDiv/'.$value['id'].'" class="btn btn-sm btn-warning"><i class="fa fa-print"></i></a>';
            }
            else
            {
                $buttons .= '';
            }
// 			$buttons .= '&nbsp;<a target="__blank" href="'.base_url().'orders/printKot/'.$value['id'].'" class="btn btn-sm btn-success '.$disabled.' ">Print KOT</a>';

			$result['data'][$key] = array(
				$value['bill_no'],
				$date,
				$type,
				$waiterName,
				$sales_type,
				$value['gross_amount'],
				$value['discount'],
				$value['totalgst'],
				$value['fnetamt'],
				$paid_status,
				$buttons
			);
			$no++;
		} // /foreach

		echo json_encode($result);
	}

	public function newCreate()
	{
		if(!in_array('createOrder', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $this->data['page_title'] = 'Add Order';
        $this->data['table_data'] = $this->model_tables->getActiveTable();
    	$company = $this->model_company->getCompanyData(1);
    	$this->data['company_data'] = $company;
    	$this->data['is_vat_enabled'] = ($company['vat_charge_value'] > 0) ? true : false;
    	$this->data['is_service_enabled'] = ($company['service_charge_value'] > 0) ? true : false;

    	$this->data['products'] = $this->model_products->getActiveProductData();      	
    	$this->data['gst'] = $this->model_gst->fecthAllData(); 

        $this->render_template('orders/newCreate', $this->data);
    }

	/*
	* If the validation is not valid, then it redirects to the create page.
	* If the validation for each input field is valid then it inserts the data into the database 
	* and it stores the operation message into the session flashdata and display on the manage group page
	*/

	public function create()
	{
		if(!in_array('createOrder', $this->permission)) {
            redirect('dashboard', 'refresh');
        }  
        
		$this->data['page_title'] = 'Add Order';

		$this->form_validation->set_rules('product[]', 'Product name', 'trim|required');
		
		// echo "Successfully";exit();
        if ($this->form_validation->run() == TRUE) {        	
        	
        	$order_id = $this->model_orders->create();
        	// print_r($order_id);exit();
        	if($order_id) {	 
			
        		$this->session->set_flashdata('success', 'Successfully created');
        		// redirect('orders/index', 'refresh');
        		$this->data['order_id'] = $order_id;
        		$this->data['data'] = $this->model_orders->viewData($order_id);
				$this->data['productData'] = $this->model_orders->viewProductData($order_id);

        		$this->render_template('orders/confirmOrder', $this->data);
        	}
        	else {
        		$this->session->set_flashdata('errors', 'Error occurred!!');
        		redirect('orders', 'refresh');
        	}
        }
        else {

            // false case
            $this->data['table_data'] = $this->model_tables->getActiveTable();
        	$company = $this->model_company->getCompanyData(1);
        	$this->data['company_data'] = $company;
        	$this->data['is_vat_enabled'] = ($company['vat_charge_value'] > 0) ? true : false;
        	$this->data['is_service_enabled'] = ($company['service_charge_value'] > 0) ? true : false;

        	$this->data['products'] = $this->model_products->getActiveProductData();      	
        	$this->data['gst'] = $this->model_gst->fecthAllData();

        	$this->data['ordersData'] = $this->model_orders->fecthAllOrderData();          	

            $this->render_template('orders/create', $this->data);
        }	
	}

	/*
	* It gets the product id passed from the ajax method.
	* It checks retrieves the particular product data from the product id 
	* and return the data into the json format.
	*/
	public function getProductValueById()
	{
		$product_id = $this->input->post('product_name');
		if($product_id) {
			$product_data = $this->model_products->getProductGstData($product_id);
			echo json_encode($product_data);
		}
	}	

	/*
	* It gets the all the active product inforamtion from the product table 
	* This function is used in the order page, for the product selection in the table
	* The response is return on the json format.
	*/
	public function getTableProductRow()
	{
		$products = $this->model_products->getActiveProductData();
		echo json_encode($products);
	}

	/*
	* If the validation is not valid, then it redirects to the edit orders page 
	* If the validation is successfully then it updates the data into the database 
	* and it stores the operation message into the session flashdata and display on the manage group page
	*/
	public function update($id)
	{
		if(!in_array('updateOrder', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

		if(!$id) {
			redirect('dashboard', 'refresh');
		}

		$this->data['page_title'] = 'Update Order';

		$this->form_validation->set_rules('product[]', 'Product name', 'trim|required');
	
        if ($this->form_validation->run() == TRUE) {     	

        	$update = $this->model_orders->update($id);	
        	
        	if($update == true) {

        		$this->session->set_flashdata('success', 'Successfully updated');
			

        		$this->data['order_id'] = $id;
        		$this->data['data'] = $this->model_orders->viewData($id);
				$this->data['productData'] = $this->model_orders->viewProductData($id);

        		$this->render_template('orders/confirmOrder', $this->data);



        		// redirect('orders/updateOrderFromDashboard/'.$id, 'refresh');
				
        	
        	}else {
        		$this->session->set_flashdata('errors', 'Error occurred!!');
        		redirect('orders', 'refresh');
        	}
        }
        else {
            // false case
            // echo "False"; exit();
        	$this->data['table_data'] = $this->model_tables->getActiveTable();

        	$company = $this->model_company->getCompanyData(1);
        	$this->data['company_data'] = $company;
        	$this->data['is_vat_enabled'] = ($company['vat_charge_value'] > 0) ? true : false;
        	$this->data['is_service_enabled'] = ($company['service_charge_value'] > 0) ? true : false;

        	$result = array();
        	$orders_data = $this->model_orders->getOrdersData($id);
        	// echo "<pre>"; print_r($orders_data); echo "</pre>"; exit();
        	if(empty($orders_data)) {

        		$this->session->set_flashdata('errors', 'The request data does not exists');
        		redirect('orders', 'refresh');
        	}

    		$result['order'] = $orders_data;
    		$orders_item = $this->model_orders->getOrdersItemData($orders_data['id']);

    		foreach($orders_item as $k => $v) {
    			$result['order_item'][] = $v;
    		}

    		$table_id = $result['order']['table_id'];
    		$table_data = $this->model_tables->getTableData($table_id);

    		$result['order_table'] = $table_data;

    		$this->data['order_data'] = $result;

        	$this->data['products'] = $this->model_products->getActiveProductData();      	

            $this->render_template('orders/edit', $this->data);
        }
	}

	/*
	* It removes the data from the database
	* and it returns the response into the json format
	*/
	public function remove()
	{
		if(!in_array('deleteOrder', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

		$order_id = $this->input->post('order_id');

		$orderData = $this->model_orders->fecthOrderDataByID($order_id);
		$orderItemData = $this->model_orders->getOrdersItemData($order_id);

		$orderItemData[0]['product_id'];

		// $productData = $this->model_products->getProductData($orderItemData[0]['product_id']);
		// $tableData = $this->model_tables->getTableData($orderData['table_id']);
		// $waiterData = $this->model_waiter->fecthAllDataById($orderData['waiter']);
		// $salesTypeData = $this->model_salestype->fecthDataByID($orderData['sales_type']);
		// $paymentTypeData = $this->model_paymentor->fecthAllDataById($orderData['payment_term']);

		// if($productData['id'] != '')
		// {
		// 	$response['success'] = false;
  //           $response['messages'] = "Data Available in Another Records";
  //       	echo json_encode($response); 
		// }
		// else if($tableData['id'] != '')
		// {
		// 	$response['success'] = false;
  //           $response['messages'] = "Data Available in Another Records";
  //       	echo json_encode($response); 
		// }
		// else if($waiterData['id'] != '')
		// {
		// 	$response['success'] = false;
  //           $response['messages'] = "Data Available in Another Records";
  //       	echo json_encode($response); 
		// }
		// else if($salesTypeData['id'] != '')
		// {
		// 	$response['success'] = false;
  //           $response['messages'] = "Data Available in Another Records";
  //       	echo json_encode($response); 
		// }
		// else if($paymentTypeData['id'] != '')
		// {
		// 	$response['success'] = false;
  //           $response['messages'] = "Data Available in Another Records";
  //       	echo json_encode($response); 
		// }
		// else
		// {
			$response = array();
	        if($order_id) {
	            $delete = $this->model_orders->remove($order_id);
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
		// }
	}

	/*
	* It gets the product id and fetch the order data. 
	* The order print logic is done here 
	*/
	public function printDiv($id)
	{
		if(!in_array('viewOrder', $this->permission)) {
          	redirect('dashboard', 'refresh');
  		}
        
		if($id) {
			$order_data = $this->model_orders->getOrdersInvoiceData($id);
			$orders_items = $this->model_orders->ordersItemInvoice($id);
			$company_info = $this->model_company->getCompanyData(1);
			$store_data = $this->model_stores->getStoresData($order_data['store_id']);

			$order_date = date('d/m/Y H:i:s A', $order_data['date_time']);
			
			$dateTime = $order_data['created'];//exit();
			
			$paid_status = ($order_data['paid_status'] == 1) ? "Paid" : "Unpaid";

			$table_data = $this->model_tables->getTableData($order_data['table_id']);

			if ($order_data['discount'] > 0) {
				// $discount = $this->currency_code . ' ' .$order_data['discount'];
				$discount = $order_data['discount'];
			}
			else {
				$discount = '0';
			}
			
// 			echo $discount; exit;
// 			print_r($order_data);exit();
    
            //<span>   <span style="font-size: 19px;"><sup>THE</sup></span> <span style="font-size: 20px;font-weight:bold">'.$company_info['company_name'].'</span>
        			         //   <span style="font-size: 15px;">RESTAURANT</span> </span>
        			         
        			         //<hr style="border: 1px solid #000">
            //   <span><b>Invoice Number: </b>'.$order_data['bill_no'].'</span><br>
            
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
			<style>
			    
			    .topBorder
			    {
			        border-top: 2px dotted #000;
			    }
			    .bottomBorder
			    {
			        border-bottom: 2px dotted #000;
			    }
			    
			</style>
			<body onload="window.print();">
			<div>
			  <section class="invoice">
    			 <div class="row invoice-info">
			        <div>
			            <center>
        			         <img src="'.base_url('assets/images/companyimg/'.$this->session->userdata['companyImg']).'" alt="'.$company_info['company_name'].'" style="width="100px"; height="70px;" />
        			         <br>
        			         <span>'.$company_info['company_name'].'</span>
        			    </center>
        			 </div>
			        <div>
			            <center>'.ucwords($company_info['address']).','.ucwords($company_info['city']).'</center>
			            <center>'.ucwords($company_info['phone']).'</center>
			            <center><span>PAN Number :- AAMFT6388C </span></center>
			            <center>Dine In</center>
			            <hr style="border: 1px dotted #000">
			        </div>
			        <div style="padding-left:15px">
    			        <span><b>Bill No : </b> '.$order_data['bill_no'].'</span><br>
    			        <span><b>Invoice Date: </b>'.$dateTime.'</span><br>
    			        <span><b>Table Name: </b>'.$order_data['table_name'].'</span>
			        </div>
			    </div>
                
			    <div class="row">
			      <div class="col-md-3">
			        <table id="orderTable" width="100%" cellpadding="0px" cellspacing="0px" border="0">
			          <thead>
			          <tr class="topBorder">
			            <th class="bottomBorder">Items</th>
			            <th class="bottomBorder">Price</th>
			            <th class="bottomBorder">Qty</th>
			            <th class="bottomBorder">Amount</th>
			          </tr>
			          </thead>
			          <tbody>'; 
			          foreach ($orders_items as $k => $v) {

                        $product = $this->model_products->getDataByid($v['product_id']);

                        // echo "<pre>"; print_r($v);

			          	$html .= '<tr>
				            <td>'.$product['name'].'</td>
				            <td>'.$v['rate'].'</td>
				            <td>'.$v['sumQty'].'</td>
				            <td>'.$v['sumNetAmt'].'</td>
			          	</tr>';
			          }
			          
			          $html .= '</tbody>
			        </table>
			      </div>
			    </div>
			    <div class="row">
			      <div class="col-md-3">
			        <div>
			        <br>
			          <table width="100%" cellpadding="0px" cellspacing="0px">
			          <tr class="topBorder">
			              <th style="width:50%">Gross Amount:</th>
			              <td>'.$order_data['gross_amount'].'</td>
			            </tr>
			            <tr>
			                <td style="width:50%"><b>Discount</b></td>
			                <td><span>'.$discount.'</span</td>
			            </tr>
			            <tr>
			                <td style="width:50%"><b>GST</b></td>
			                <td><span>'.$order_data['totalgst'].'</span</td>
			            </tr>
			            <tr>
			                <td style="width:50%"><b>Adjustment</b></td>
			                <td><span>'.$order_data['adj'].'</span</td>
			            </tr>
			            <tr>
			                <td style="width:50%"><b>Net Amount</b></td>
			                <td><span>'.$order_data['fnetamt'].'</span</td>
			            </tr>';

			            if($order_data['service_charge_amount'] > 0) {
			            	$html .= '<tr>
				              <th>Service Charge ('.$order_data['service_charge_rate'].'%)</th>
				              <td>'.$order_data['service_charge_amount'].'</td>
				            </tr>';
			            }

			            if($order_data['vat_charge_amount'] > 0) {
			            	$html .= '<tr>
				              <th>Vat Charge ('.$order_data['vat_charge_rate'].'%)</th>
				              <td>'.$order_data['vat_charge_amount'].'</td>
				            </tr>';
			            }
			            
			            $html .='
        			          </table>
			          <div>
			            <br>
			            <center><p>**THANK YOU PLEASE DO VISIT US AGAIN**</p></center>
			            <hr style="border: 1px dotted #000">
			          </div>
			          
			        </div>
			      </div>
			      <!-- /.col -->
			    </div>
			    <!-- /.row -->
			  </section>
			  <!-- /.content -->
			</div>
		</body>
	</html>';

			  echo $html;
		}
	}
	
	public function printKot($id)
	{
		if(!in_array('viewOrder', $this->permission)) {
          	redirect('dashboard', 'refresh');
  		}
        
		if($id) {
			$order_data = $this->model_orders->getOrdersInvoiceData($id);
			$orders_items = $this->model_orders->getKOTItemData($id);
			$company_info = $this->model_company->getCompanyData(1);
			$store_data = $this->model_stores->getStoresData($order_data['store_id']);
			
			$dateTime = $order_data['created'];

			$order_date = date('d/m/Y H:i:s A', $order_data['date_time']);
			$paid_status = ($order_data['paid_status'] == 1) ? "Paid" : "Unpaid";

			$table_data = $this->model_tables->getTableData($order_data['table_id']);

			if ($order_data['discount'] > 0) {
				$discount = $this->currency_code . ' ' .$order_data['discount'];
			}
			else {
				$discount = '0';
			}

			// <body onload="window.print();">

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
			  <script src="'.base_url('assets/bower_components/jquery/dist/jquery.min.js').'"></script>
			</head>
			<body>
			<div id="kotData">
			  <section class="invoice">
    			 <div class="row invoice-info">
			        <div style="padding-left:15px">
			            <center>KOT</center>
    			        <span><b>Invoice Number: </b>'.$order_data['bill_no'].'</span><br>
    			        <b>Invoice Date: </b>'.$dateTime.'</span><br>
    			        <b>Table Name: </b>'.$order_data['table_name'].'</span>
			        </div>
			    </div>
                
                <br>
			    <div class="row">
			      <div class="col-md-3">
			        <table width="100%" cellpadding="0px" cellspacing="0px">
			          <thead>
			          <tr>
			            <th>Items</th>
			            <th>Qty</th>
			          </tr>
			          </thead>
			          <tbody>'; 
			          foreach ($orders_items as $k => $v) {
			              
			             // For KOT
    			         //   if($v['kot_status'] != '2')
    			         //  {
    			                  $product_data = $this->model_products->getKotDataBySrNo($v['product_id']); 
    			                  
    			                  $html .= '<tr>
        				            <td>'.$product_data['name'].'</td>
        				            <td>'.$v['qty'].'</td>
        			          	</tr>';
        			          	
        			          	// // // for kot
				          		// $kotStatus = $this->model_orders->setKotStatus($v['id']);
			            //   }
			          }
			          
			          $html .= '</tbody>
			        </table>
			      </div>
			    </div>
			    <hr style="border: 1px dotted #000">
			    <!-- /.row -->
			  </section>
			  <!-- /.content -->
			</div>
			<div style="margin-top: -50px;">
				<section class="invoice">
					<button id="cancelKOT">Cancel</button>
					<button id="printKOT">Print</button>
				</section>
			</div>
		</body>
	</html>';
			  echo $html;

			  echo "<script language=\"javascript\">

			  			$('#cancelKOT').on('click', function(){

			  				var base_url = '".base_url()."';
			  				window.location = base_url + 'orders/update/' + '".$id."';
			  				window.close();
			  			});

						$('#printKOT').on('click', function(){

							var kotContent = document.getElementById('kotData');
							// alert(kotContent);
							// newWin= window.open('');
							window.document.write(kotContent.outerHTML);
							window.print();

							// window.close();
							var base_url = '".base_url()."';
							// alert(base_url);
							// alert(base_url + 'orders/KotStatus/' + '".$id."');
							window.location = base_url + 'orders/KotStatus/' + '".$id."';
							// window.close();
						});
			</script>";
		}
	}

	public function KotStatus($order_id='')
	{
		// print_r($order_id);
		$orders_items = $this->model_orders->getKOTItemData($order_id);
		// echo "<pre>"; print_r($orders_items); echo "</pre>";
		foreach ($orders_items as $k => $v) {

			$this->model_orders->setKotStatus($v['id']);

			echo "<script language=\"javascript\">
					
					window.close();
				</script>";
		}
	}

	// my code
	public function getAllOrderData()
	{
		if(!in_array('createOrder', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $orderData = $this->model_orders->getAllOrderData();
        // print_r($orderData); exit();
        echo json_encode($orderData);
	}

	public function addOrderWithGst()
	{
		print_r($this->input->post()); exit();
	}

	public function updateOrder()
	{
		$id = $this->input->get('id');

		$this->data['table_data'] = $this->model_tables->getActiveTable();

        	$company = $this->model_company->getCompanyData(1);
        	$this->data['company_data'] = $company;
        	$this->data['is_vat_enabled'] = ($company['vat_charge_value'] > 0) ? true : false;
        	$this->data['is_service_enabled'] = ($company['service_charge_value'] > 0) ? true : false;

        	$result = array();
        	$orders_data = $this->model_orders->getOrdersData($id);

        	if(empty($orders_data)) {
        		$this->session->set_flashdata('errors', 'The request data does not exists');
        		redirect('orders', 'refresh');
        	}

    		$result['order'] = $orders_data;
    		$orders_item = $this->model_orders->getOrdersItemData($orders_data['id']);

    		foreach($orders_item as $k => $v) {
    			$result['order_item'][] = $v;
    		}

    		$table_id = $result['order']['table_id'];
    		$table_data = $this->model_tables->getTableData($table_id);

    		$result['order_table'] = $table_data;

    		$this->data['order_data'] = $result;

        	$this->data['products'] = $this->model_products->getActiveProductData();      	

            $this->render_template('orders/edit', $this->data);
	}

	public function deleteOrder()
	{
		$order_id = $this->input->get('id');
		$delete = $this->model_orders->remove($order_id);

		$this->session->set_flashdata('feedback','Data Delete Successfully');
		$this->session->set_flashdata('feedback_class','alert alert-danger');

		$this->render_template('orders/index', $this->data);
	}

	public function createFromDashboard()
	{
		$lastRecord = $this->db->order_by('id',"desc")
					            ->limit(1)
					            ->get('orders')
					            ->row();
		$lastRecord->bill_no;
		
		if($lastRecord == '')
		{
			$lastRecord = 1;
			$bill_no = str_pad($lastRecord, 5, "0", STR_PAD_LEFT); //exit();
		}
		else
		{
// 			echo "increase";//exit();
			$lastRecord = $lastRecord->bill_no + 1;
			
			$bill_no = str_pad($lastRecord, 5, "0", STR_PAD_LEFT);
		}

		$this->data['bill_no'] = $bill_no;

		$this->data['id'] = $this->input->get('id');
		$this->data['name'] = $this->input->get('name');
        $this->data['tran_type']=$this->input->get('tran_type');
		$this->data['table_data'] = $this->model_tables->getActiveTable();
    	$company = $this->model_company->getCompanyData(1);
    	$this->data['company_data'] = $company;
    	$this->data['is_vat_enabled'] = ($company['vat_charge_value'] > 0) ? true : false;
    	$this->data['is_service_enabled'] = ($company['service_charge_value'] > 0) ? true : false;

    	$this->data['products'] = $this->model_products->getActiveProductData();      	
    	$this->data['gst'] = $this->model_gst->fecthAllData();

    	$this->data['waiter'] = $this->model_waiter->fecthActiveWaiterData();
    	$this->data['sales_type'] = $this->model_salestype->fecthActiveSalesTypeData();
    	$this->data['payment_type'] = $this->model_paymentor->fecthActivePaymentorData();
    	// echo "<pre>"; print_r($waiter); exit();

    	$this->data['ordersData'] = $this->model_orders->fecthAllOrderData(); 

		$this->render_template('orders/pages/torder', $this->data);
	}

	public function updateOrderFromDashboard()
	{
		$id = $this->input->get('id');
		// exit();
		$this->data['table_data'] = $this->model_tables->getActiveTable();

        	$company = $this->model_company->getCompanyData(1);
        	$this->data['company_data'] = $company;
        	$this->data['is_vat_enabled'] = ($company['vat_charge_value'] > 0) ? true : false;
        	$this->data['is_service_enabled'] = ($company['service_charge_value'] > 0) ? true : false;

        	$result = array();
        	$orders_data = $this->model_orders->getOrdersData($id);

        	if(empty($orders_data)) {
        		$this->session->set_flashdata('errors', 'The request data does not exists');
        		redirect('orders', 'refresh');
        	}

    		$result['order'] = $orders_data;
    		$orders_item = $this->model_orders->getOrdersAndProductItemData($orders_data['id']);
    // 		print_r($orders_item); exit;
if(!isset($orders_data['id'])){
	
	redirect('orders', 'refresh');
}
    		foreach($orders_item as $k => $v) {
    			$result['order_item'][] = $v;
    		}

    		$table_id = $result['order']['table_id'];
    		$table_data = $this->model_tables->getTableData($table_id);

    		$result['order_table'] = $table_data;

    		$this->data['order_data'] = $result;
			$this->data['id'] = $id;

        	$this->data['products'] = $this->model_products->getActiveProductData();    

        	$this->data['table_id'] = $this->input->get('table_id');
        	$this->data['table_name'] = $this->input->get('name');
        	
        	$this->data['tableDetails'] = $this->model_tables->getTableDataByOrderID($id);

            $this->render_template('orders/pages/torderEdit', $this->data);
	}

	public function displayData()
	{
	    $order_id = $this->input->post('order_id');
		// $order_id = 11;

		$data[] = $this->model_orders->viewData($order_id);
		$data[] = $this->model_orders->viewProductData($order_id);
        echo json_encode($data);
	}
}