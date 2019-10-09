<?php

defined('BASEPATH') OR exit('No direct script access allowed');
// error_reporting(0);
class Order extends Admin_Controller 
{
	var $currency_code = '';

	public function __construct()
	{
		parent::__construct();

		$this->not_logged_in();

		$this->data['page_title'] = 'ZEON ERP';

		$this->load->model('model_orders');
		$this->load->model('model_tables');
		$this->load->model('model_parcel');
		$this->load->model('model_products');
		$this->load->model('model_company');
		$this->load->model('model_stores');
		$this->load->model('model_gst');
		$this->load->model('model_waiter');
		$this->load->model('model_salestype');
		$this->load->model('model_paymentor');
		$this->load->model('model_users');
		$this->load->model('model_unittype');
		

		$this->currency_code = $this->company_currency();
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
        $this->form_validation->set_rules('table_id', 'Table Name', 'trim|required');
        $this->form_validation->set_rules('table_name', 'Table Name', 'trim|required');
        $this->form_validation->set_rules('salestype', 'Sales Type', 'trim|required|callback_check_selctionoption');

	    if ($this->form_validation->run() == TRUE) {

	    	$user_id = $this->session->userdata('id');
			// get store id from user id 
			$user_data = $this->model_users->getUserData($user_id);
			$store_id = $user_data['store_id'];

	    	$date = date('Y-m-d H:i:s');
			$date_time = strtotime($date);

	    	$data = array(
	    					'bill_no' => $this->input->post('invoice'), 
	    					'date_time' => $date_time,
	    					'customername' => $this->input->post('cname'), 
	    					'mobile' => $this->input->post('mobile'), 
	    					'gross_amount' => $this->input->post('finalgprice'), 
	    					'totalgst' => $this->input->post('finalGst'), 
	    					'discount' => $this->input->post('finaldiscount'), 
	    					'net_amount' => $this->input->post('finalnetAmtAdj'), 
	    					'adj' => $this->input->post('adj'), 
	    					'fnetamt' => $this->input->post('finalnetAmt'), 
	    					'user_id' => $user_id, 
	    					'table_id' => $this->input->post('table_id'), 
	    					// 'parcel_id' => $this->input->post('finalnetAmt'), 
	    					'paid_status' => $this->input->post('billstatus'), 
	    					'store_id' => $store_id, 
	    					'waiter' => $this->input->post('emp'), 
	    					'payment_term' => $this->input->post('paymenttype'), 
	    					'sales_type' => $this->input->post('salestype'), 
	    					'ordertype' => $this->input->post('tran_type'),
	    				);

			$created = $this->model_orders->createOrder($data);
			// $created = 1;

			if($created)
			{
				// Update Table Status

	    		if($this->input->post('billstatus') == 1) {
	    		
		    		$this->model_tables->update($this->input->post('table_id'), array('available' => 1));	
		    	}
		    	else {
		    		$this->model_tables->update($this->input->post('table_id'), array('available' => 2));	
		    	}

				$count = count($this->input->post('product_id'));

				for ($i=0; $i < $count; $i++) { 
					
					$itemData = array(
										'order_id' => $created,
										'product_id' => $this->input->post('product_id')[$i],
										'qty' => $this->input->post('quantity')[$i],
										'rate' => $this->input->post('mrp')[$i],
										'discount' => $this->input->post('discount')[$i],
										'discountAmt' => $this->input->post('discountAmt')[$i],
										'grossprice' => $this->input->post('grossprice')[$i],
										'gstAmt' => $this->input->post('gstAmt')[$i],
										'netAmt' => $this->input->post('netAmt')[$i],
									);

					$this->model_orders->createOrderItem($itemData);
					// echo "<pre>"; print_r($itemData);
				}

				// $this->load->model('model_tables');
		    	// $this->model_tables->update($this->input->post('table_id'), array('available' => 2));

		    	// $this->db->set('available ', $this->input->post('paid_status'));
		    	$this->db->set('currentorder_id ', $created);
		    	$this->db->where('id', $this->input->post('table_id'));
		    	$this->db->update('tables');

		    	$this->session->set_flashdata('success', 'Successfully created');
        		// redirect('orders/index', 'refresh');
        		$this->data['order_id'] = $created;
        		$this->data['data'] = $this->model_orders->viewData($created);
				$this->data['productData'] = $this->model_orders->viewProductData($created);


				$this->data['products'] = $this->model_products->getActiveProductData();      	
		    	$this->data['gst'] = $this->model_gst->fecthAllData();

		    	$this->data['waiter'] = $this->model_waiter->fecthActiveWaiterData();
		    	$this->data['sales_type'] = $this->model_salestype->fecthActiveSalesTypeData();
		    	$this->data['payment_type'] = $this->model_paymentor->fecthActivePaymentorData();

        		$this->render_template('orders/pages/confirmOrder', $this->data);

				// $this->session->set_flashdata('feedback','Order Create Successfully');
				// $this->session->set_flashdata('feedback_class','alert alert-success');
				
				// return redirect('order/create');

			}
			else
			{
				$this->session->set_flashdata('feedback','Unable to Saved Data');
				$this->session->set_flashdata('feedback_class','alert alert-danger');
				
				return redirect('order/create');
			}

			// echo "<pre>"; print_r($_POST);

	    }
	    else
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
				$lastRecord = $lastRecord->bill_no + 1;
				
				$bill_no = str_pad($lastRecord, 5, "0", STR_PAD_LEFT);
			}

			$this->data['bill_no'] = $bill_no;

			// echo $this->input->get('id');; exit();

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
	}

	public function updateTableOrder()
	{
		$id = $this->uri->segment(3);

		$this->form_validation->set_rules('order_id', 'Table Order', 'trim|required');
		$this->form_validation->set_rules('table_id', 'Table Name', 'trim|required');
        $this->form_validation->set_rules('table_name', 'Table Name', 'trim|required');
        $this->form_validation->set_rules('salestype', 'Sales Type', 'trim|required|callback_check_selctionoption');

	    if ($this->form_validation->run() == TRUE) {

	    	$user_id = $this->session->userdata('id');
			// get store id from user id 
			$user_data = $this->model_users->getUserData($user_id);
			$store_id = $user_data['store_id'];

	    	$data = array(
	    					'id' => $this->input->post('order_id'), 
	    					'customername' => $this->input->post('cname'), 
	    					'mobile' => $this->input->post('mobile'), 
	    					'gross_amount' => $this->input->post('finalgprice'), 
	    					'totalgst' => $this->input->post('finalGst'), 
	    					'discount' => $this->input->post('finaldiscount'), 
	    					'net_amount' => $this->input->post('finalnetAmtAdj'), 
	    					'adj' => $this->input->post('adj'), 
	    					'fnetamt' => $this->input->post('finalnetAmt'), 
	    					'user_id' => $user_id, 
	    					'table_id' => $this->input->post('table_id'), 
	    					// 'parcel_id' => $this->input->post('finalnetAmt'), 
	    					'paid_status' => $this->input->post('billstatus'), 
	    					'store_id' => $store_id, 
	    					'waiter' => $this->input->post('emp'), 
	    					'payment_term' => $this->input->post('paymenttype'), 
	    					'sales_type' => $this->input->post('salestype'), 
	    					// 'ordertype' => $this->input->post('tran_type'), 
	    				);

	    	$update = $this->model_orders->updateOrder($data);

	    	if($update == true)
	    	{
	    		// Update Table Status

	    		if($this->input->post('billstatus') == 1) {
	    		
		    		$this->model_tables->update($this->input->post('table_id'), array('available' => 1));	
		    	}
		    	else {
		    		$this->model_tables->update($this->input->post('table_id'), array('available' => 2));	
		    	}

	    		// Delete Without KOT Order Item Data
	    		$this->model_orders->deletOrderItemNotKot($this->input->post('order_id'));

	    		$count = count($this->input->post('product_id'));

				for ($i=0; $i < $count; $i++) { 

					$this->input->post('kot_status')[$i];
					
					if($this->input->post('kot_status')[$i] == 1)
					{
						$itemData = array(
										'order_id' => $this->input->post('order_id'),
										'product_id' => $this->input->post('product_id')[$i],
										'qty' => $this->input->post('quantity')[$i],
										'rate' => $this->input->post('mrp')[$i],
										'discount' => $this->input->post('discount')[$i],
										'discountAmt' => $this->input->post('discountAmt')[$i],
										'grossprice' => $this->input->post('grossprice')[$i],
										'gstAmt' => $this->input->post('gstAmt')[$i],
										'netAmt' => $this->input->post('netAmt')[$i],
									);
						// echo "<pre>"; print_r($itemData);
						$this->model_orders->createOrderItem($itemData);
					}
					else
					{
						$itemData = array(
											'id' => $this->input->post('orderitem_id')[$i],
											// 'order_id' => $this->input->post('order_id'),
											// 'product_id' => $this->input->post('product_id')[$i],
											// 'qty' => $this->input->post('quantity')[$i],
											// 'rate' => $this->input->post('mrp')[$i],
											'discount' => $this->input->post('discount')[$i],
											'discountAmt' => $this->input->post('discountAmt')[$i],
											'grossprice' => $this->input->post('grossprice')[$i],
											'gstAmt' => $this->input->post('gstAmt')[$i],
											'netAmt' => $this->input->post('netAmt')[$i],
										);
						// echo "<pre>"; print_r($itemData);

						$this->model_orders->updateOrderItem($itemData);
					}
				}
				// exit();

				// $this->load->model('model_tables');
		 		// $this->model_tables->update($this->input->post('table_id'), array('available' => 2));

		    	// $this->db->set('available ', $this->input->post('paid_status'));
		    	$this->db->set('currentorder_id ', $this->input->post('order_id'));
		    	$this->db->where('id', $this->input->post('table_id'));
		    	$this->db->update('tables');

		    	$this->session->set_flashdata('success', 'Successfully created');
        		// redirect('orders/index', 'refresh');
        		
		    	redirect('order/confirmTable/'.$this->input->post('order_id'));
	    	}
	    	else
	    	{
	    		$this->session->set_flashdata('feedback','Unable to Update Order');
				$this->session->set_flashdata('feedback_class','alert alert-danger');
				
				return redirect('order/updateTableOrder');
	    	}
	    }
	    else
	    {
	    	$this->data['orderData'] = $this->model_orders->getOrdersData($id);
			$this->data['orderItemData'] = $this->model_orders->getOrdersItemData($id);

			$this->data['products'] = $this->model_products->getActiveProductData();      	
	    	$this->data['gst'] = $this->model_gst->fecthAllData();

	    	$this->data['waiter'] = $this->model_waiter->fecthActiveWaiterData();
	    	$this->data['sales_type'] = $this->model_salestype->fecthActiveSalesTypeData();
	    	$this->data['payment_type'] = $this->model_paymentor->fecthActivePaymentorData();

			$this->render_template('orders/pages/torderEdit', $this->data);
	    }
	}

	public function confirmTable()
	{
		$order_id = $this->uri->segment(3);

		$this->data['order_id'] = $order_id;
		$this->data['data'] = $this->model_orders->viewData($order_id);
		$this->data['productData'] = $this->model_orders->viewProductData($order_id);


		$this->data['products'] = $this->model_products->getActiveProductData();      	
    	$this->data['gst'] = $this->model_gst->fecthAllData();

    	$this->data['waiter'] = $this->model_waiter->fecthActiveWaiterData();
    	$this->data['sales_type'] = $this->model_salestype->fecthActiveSalesTypeData();
    	$this->data['payment_type'] = $this->model_paymentor->fecthActivePaymentorData();

		$this->render_template('orders/pages/confirmOrder', $this->data);
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
                              $product = $this->model_products->getDataByid($v['product_id']);
			          	// echo "<pre>"; print_r($product);
    			                  // $product_data = $this->model_products->getKotDataBySrNo($v['product_id']); 
    			                  
    			                  $html .= '<tr>
        				            <td>'.$product['name'].'</td>
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
			  				window.location = base_url + 'order/update/' + '".$id."';
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
							// alert(base_url + 'order/KotStatus/' + '".$id."');
							window.location = base_url + 'order/KotStatus/' + '".$id."';
							// window.close();
						});
			</script>";
		}
	}

	public function KotStatus($order_id='')
	{
		// print_r($order_id);
		$orders_items = $this->model_orders->getKOTItemData($order_id);
		// echo "<pre>"; print_r($orders_items); echo "</pre>"; exit();
		foreach ($orders_items as $k => $v) {

			$this->model_orders->setKotStatus($v['id']);

			echo "<script language=\"javascript\">
					
					window.close();
				</script>";
		}
	}



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


	public function createParcel()
	{
		$this->form_validation->set_rules('table_id', 'Table Name', 'trim|required');
        $this->form_validation->set_rules('table_name', 'Table Name', 'trim|required');
        $this->form_validation->set_rules('salestype', 'Sales Type', 'trim|required|callback_check_selctionoption');

	    if ($this->form_validation->run() == TRUE) {

	    	$user_id = $this->session->userdata('id');
			// get store id from user id 
			$user_data = $this->model_users->getUserData($user_id);
			$store_id = $user_data['store_id'];

	    	$date = date('Y-m-d H:i:s');
			$date_time = strtotime($date);

	    	$data = array(
	    					'bill_no' => $this->input->post('invoice'), 
	    					'date_time' => $date_time,
	    					'customername' => $this->input->post('cname'), 
	    					'mobile' => $this->input->post('mobile'), 
	    					'gross_amount' => $this->input->post('finalgprice'), 
	    					'totalgst' => $this->input->post('finalGst'), 
	    					'discount' => $this->input->post('finaldiscount'), 
	    					'net_amount' => $this->input->post('finalnetAmtAdj'), 
	    					'adj' => $this->input->post('adj'), 
	    					'fnetamt' => $this->input->post('finalnetAmt'), 
	    					'user_id' => $user_id, 
	    					'parcel_id' => $this->input->post('table_id'), 
	    					// 'parcel_id' => $this->input->post('finalnetAmt'), 
	    					'paid_status' => $this->input->post('billstatus'), 
	    					'store_id' => $store_id, 
	    					'waiter' => $this->input->post('emp'), 
	    					'payment_term' => $this->input->post('paymenttype'), 
	    					'sales_type' => $this->input->post('salestype'), 
	    					'ordertype' => $this->input->post('tran_type'), 
	    				);

	    	// echo "<pre>"; print_r($data); exit();
			$created = $this->model_orders->createOrder($data);
			// $created = 1;

			if($created)
			{

				// Update Table Status

	    		if($this->input->post('billstatus') == 1) {
	    		
		    		$this->model_parcel->update($this->input->post('table_id'), array('available' => 1));	
		    	}
		    	else {
		    		$this->model_parcel->update($this->input->post('table_id'), array('available' => 2));	
		    	}

				$count = count($this->input->post('product_id'));

				for ($i=0; $i < $count; $i++) { 
					
					$itemData = array(
										'order_id' => $created,
										'product_id' => $this->input->post('product_id')[$i],
										'qty' => $this->input->post('quantity')[$i],
										'rate' => $this->input->post('mrp')[$i],
										'discount' => $this->input->post('discount')[$i],
										'discountAmt' => $this->input->post('discountAmt')[$i],
										'grossprice' => $this->input->post('grossprice')[$i],
										'gstAmt' => $this->input->post('gstAmt')[$i],
										'netAmt' => $this->input->post('netAmt')[$i],
									);

					$this->model_orders->createOrderItem($itemData);
					// echo "<pre>"; print_r($itemData);
				}

				// exit();

				// $this->load->model('model_tables');
		  //   	$this->model_parcel->update($this->input->post('table_id'), array('available' => 2));

		    	// $this->db->set('available ', $this->input->post('paid_status'));
		    	$this->db->set('currentorder_id ', $created);
		    	$this->db->where('id', $this->input->post('table_id'));
		    	$this->db->update('table_parcel');

		    	$this->session->set_flashdata('success', 'Successfully created');
        		// redirect('orders/index', 'refresh');
        		$this->data['order_id'] = $created;
        		$this->data['data'] = $this->model_orders->viewData($created);
				$this->data['productData'] = $this->model_orders->viewProductData($created);


				$this->data['products'] = $this->model_products->getActiveProductData();      	
		    	$this->data['gst'] = $this->model_gst->fecthAllData();

		    	$this->data['waiter'] = $this->model_waiter->fecthActiveWaiterData();
		    	$this->data['sales_type'] = $this->model_salestype->fecthActiveSalesTypeData();
		    	$this->data['payment_type'] = $this->model_paymentor->fecthActivePaymentorData();

        		$this->render_template('orders/pages/confirmParcel', $this->data);

				// $this->session->set_flashdata('feedback','Order Create Successfully');
				// $this->session->set_flashdata('feedback_class','alert alert-success');
				
				// return redirect('order/create');

			}
			else
			{
				$this->session->set_flashdata('feedback','Unable to Saved Data');
				$this->session->set_flashdata('feedback_class','alert alert-danger');
				
				return redirect('order/createParcel');
			}

			// echo "<pre>"; print_r($_POST);

	    }
	    else
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
			// 	echo "increase";//exit();
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

			$this->render_template('orders/pages/porder', $this->data);
	    }	
	}


	public function updateParcel()
	{
		$id = $this->uri->segment(3);
		
		$this->form_validation->set_rules('order_id', 'Table Order', 'trim|required');
		$this->form_validation->set_rules('table_id', 'Table Name', 'trim|required');
        $this->form_validation->set_rules('table_name', 'Table Name', 'trim|required');
        $this->form_validation->set_rules('salestype', 'Sales Type', 'trim|required|callback_check_selctionoption');

	    if ($this->form_validation->run() == TRUE) {

	    	$user_id = $this->session->userdata('id');
			// get store id from user id 
			$user_data = $this->model_users->getUserData($user_id);
			$store_id = $user_data['store_id'];

	    	$data = array(
	    					'id' => $this->input->post('order_id'),
	    					'customername' => $this->input->post('cname'), 
	    					'mobile' => $this->input->post('mobile'),  
	    					'gross_amount' => $this->input->post('finalgprice'), 
	    					'totalgst' => $this->input->post('finalGst'), 
	    					'discount' => $this->input->post('finaldiscount'), 
	    					'net_amount' => $this->input->post('finalnetAmtAdj'), 
	    					'adj' => $this->input->post('adj'), 
	    					'fnetamt' => $this->input->post('finalnetAmt'), 
	    					'user_id' => $user_id, 
	    					'parcel_id' => $this->input->post('table_id'), 
	    					// 'parcel_id' => $this->input->post('finalnetAmt'), 
	    					'paid_status' => $this->input->post('billstatus'), 
	    					'store_id' => $store_id, 
	    					'waiter' => $this->input->post('emp'), 
	    					'payment_term' => $this->input->post('paymenttype'), 
	    					'sales_type' => $this->input->post('salestype'), 
	    					// 'ordertype' => $this->input->post('tran_type'), 
	    				);

	    	// echo "<pre>"; print_r($data);
	    	// echo "<pre>"; print_r($_POST);
	    	// exit();
	    	// $update = 1;
	    	$update = $this->model_orders->updateOrder($data);

	    	if($update)
	    	{
	    		// Update Table Status

	    		if($this->input->post('billstatus') == 1) {
	    		
		    		$this->model_parcel->update($this->input->post('table_id'), array('available' => 1));	
		    	}
		    	else {
		    		$this->model_parcel->update($this->input->post('table_id'), array('available' => 2));	
		    	}


	    		// Delete Without KOT Order Item Data
	    		$this->model_orders->deletOrderItemNotKot($this->input->post('order_id'));

	    		$count = count($this->input->post('product_id'));

				for ($i=0; $i < $count; $i++) { 

					$this->input->post('kot_status')[$i];
					
					if($this->input->post('kot_status')[$i] == 1)
					{
						$itemData = array(
										'order_id' => $this->input->post('order_id'),
										'product_id' => $this->input->post('product_id')[$i],
										'qty' => $this->input->post('quantity')[$i],
										'rate' => $this->input->post('mrp')[$i],
										'discount' => $this->input->post('discount')[$i],
										'discountAmt' => $this->input->post('discountAmt')[$i],
										'grossprice' => $this->input->post('grossprice')[$i],
										'gstAmt' => $this->input->post('gstAmt')[$i],
										'netAmt' => $this->input->post('netAmt')[$i],
									);
						// echo "<pre>"; print_r($itemData);
						$this->model_orders->createOrderItem($itemData);
					}
					else
					{
						$itemData = array(
											'id' => $this->input->post('orderitem_id')[$i],
											// 'order_id' => $this->input->post('order_id'),
											// 'product_id' => $this->input->post('product_id')[$i],
											// 'qty' => $this->input->post('quantity')[$i],
											// 'rate' => $this->input->post('mrp')[$i],
											'discount' => $this->input->post('discount')[$i],
											'discountAmt' => $this->input->post('discountAmt')[$i],
											'grossprice' => $this->input->post('grossprice')[$i],
											'gstAmt' => $this->input->post('gstAmt')[$i],
											'netAmt' => $this->input->post('netAmt')[$i],
										);
						// echo "<pre>"; print_r($itemData);

						$this->model_orders->updateOrderItem($itemData);
					}
				}
				// exit();

				// $this->load->model('model_tables');
		  //   	$this->model_parcel->update($this->input->post('table_id'), array('available' => 2));

		    	// $this->db->set('available ', $this->input->post('paid_status'));
		    	$this->db->set('currentorder_id ', $this->input->post('order_id'));
		    	$this->db->where('id', $this->input->post('table_id'));
		    	$this->db->update('table_parcel');

		    	$this->session->set_flashdata('success', 'Successfully created');
        		// redirect('orders/index', 'refresh');

        		redirect('order/confirmParcel/'.$this->input->post('order_id'));
	    	}
	    	else
	    	{
	    		$this->session->set_flashdata('feedback','Unable to Update Order');
				$this->session->set_flashdata('feedback_class','alert alert-danger');
				
				return redirect('order/updateParcel');
	    	}
	    }
	    else
	    {
	    	$this->data['orderData'] = $this->model_orders->getOrdersData($id);

			$this->data['orderItemData'] = $this->model_orders->getOrdersItemData($id);

			$this->data['products'] = $this->model_products->getActiveProductData();      	
	    	$this->data['gst'] = $this->model_gst->fecthAllData();

	    	$this->data['waiter'] = $this->model_waiter->fecthActiveWaiterData();
	    	$this->data['sales_type'] = $this->model_salestype->fecthActiveSalesTypeData();
	    	$this->data['payment_type'] = $this->model_paymentor->fecthActivePaymentorData();

			$this->render_template('orders/pages/porderEdit', $this->data);
	    }
	}

	public function confirmParcel()
	{
		$order_id = $this->uri->segment(3);

		$this->data['order_id'] = $order_id;
		$this->data['data'] = $this->model_orders->viewData($order_id);
		$this->data['productData'] = $this->model_orders->viewProductData($order_id);


		$this->data['products'] = $this->model_products->getActiveProductData();      	
    	$this->data['gst'] = $this->model_gst->fecthAllData();

    	$this->data['waiter'] = $this->model_waiter->fecthActiveWaiterData();
    	$this->data['sales_type'] = $this->model_salestype->fecthActiveSalesTypeData();
    	$this->data['payment_type'] = $this->model_paymentor->fecthActivePaymentorData();

		$this->render_template('orders/pages/confirmParcel', $this->data);
	}


}
?>