<?php  

defined('BASEPATH') OR exit('No direct script access allowed');
error_reporting(0);
class Reports extends Admin_Controller 
{	
	public function __construct()
	{
		parent::__construct();
		$this->data['page_title'] = 'ZEON ERP';

		$this->load->model('model_reports');
		$this->load->model('model_stores');
		$this->load->model('model_waiter');
		$this->load->model('model_orders');
		$this->load->model('model_products');
		$this->load->model('model_tables');
		$this->load->model('model_users');
		$this->load->model('model_company');
		$this->load->model('model_salestype');
		$this->load->model('model_paymentor');
		$this->load->model('model_expences');
		$this->load->model('model_gst');
	
	}

	/* 
    * It redirects to the report page
    * and based on the year, all the orders data are fetch from the database.
    */
	public function index()
	{
		if(!in_array('viewReport', $this->permission)) {
            redirect('dashboard', 'refresh');
        }
		
		$today_year = date('Y');

		if($this->input->post('select_year')) {
			$today_year = $this->input->post('select_year');
		}

		$order_data = $this->model_reports->getOrderData($today_year);
		$this->data['report_years'] = $this->model_reports->getOrderYear();
		

		$final_order_data = array();
		foreach ($order_data as $k => $v) {
			
			if(count($v) > 1) {
				$total_amount_earned = array();
				foreach ($v as $k2 => $v2) {
					if($v2) {
						$total_amount_earned[] = $v2['net_amount'];						
					}
				}
				$final_order_data[$k] = array_sum($total_amount_earned);	
			}
			else {
				$final_order_data[$k] = 0;	
			}
			
		}
		
		$this->data['selected_year'] = $today_year;
		$this->data['company_currency'] = $this->company_currency();
		$this->data['results'] = $final_order_data;

		$this->render_template('reports/index', $this->data);
	}

	public function storewise()
	{
		if(!in_array('viewReport', $this->permission)) {
            redirect('dashboard', 'refresh');
        }
        
		$today_year = date('Y');


		$store_data = $this->model_stores->getStoresData();
		

		$store_id = $store_data[0]['id'];

		if($this->input->post('select_store')) {
			$store_id = $this->input->post('select_store');
		}

		if($this->input->post('select_year')) {
			$today_year = $this->input->post('select_year');
		}

		$order_data = $this->model_reports->getStoreWiseOrderData($today_year, $store_id);
		$this->data['report_years'] = $this->model_reports->getOrderYear();
		

		$final_parking_data = array();
		foreach ($order_data as $k => $v) {
			
			if(count($v) > 1) {
				$total_amount_earned = array();
				foreach ($v as $k2 => $v2) {
					if($v2) {
						$total_amount_earned[] = $v2['net_amount'];						
					}
				}
				$final_parking_data[$k] = array_sum($total_amount_earned);	
			}
			else {
				$final_parking_data[$k] = 0;	
			}
			
		}

		$this->data['selected_store'] = $store_id;
		$this->data['store_data'] = $store_data;
		$this->data['selected_year'] = $today_year;
		$this->data['company_currency'] = $this->company_currency();
		$this->data['results'] = $final_parking_data;
		
		$this->render_template('reports/storewise', $this->data);
	}

	public function waiterReport()
	{
		if(!in_array('viewReport', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

		$this->form_validation->set_rules('from', 'From Date', 'trim|required');
		$this->form_validation->set_rules('to', 'To Date', 'trim|required');
        
        if ($this->form_validation->run() == TRUE) {

        	$from =date('Y-m-d',strtotime($this->input->post('from')));
			$to = date('Y-m-d',strtotime($this->input->post('to')));

				// echo "<pre>"; print_r($_POST); exit();


			if($this->input->post('showWaiter') == 0)
			{
				$data = array(
        					'from' => $from, 
        					'to' => $to
        				);

				// echo "<pre>"; print_r($data); exit();

	        	$this->data['allData'] = $this->model_orders->getOrdersDataDateWise($data);
			}
			else
			{
				$data = array(
        					'from' => $from, 
        					'to' => $to,
        					'waiter' => $this->input->post('showWaiter'),
        					'field' => 'waiter'
        				);
				// echo "<pre>"; print_r($data); exit();


	        	$this->data['allData'] = $this->model_orders->getOrdersDataDateWise1($data);	
			}

			$this->render_template('reports/waiterwise', $this->data);
        	
        }
        else
        {
        	$this->data['waiterData'] = array();

			$this->data['allData'] = $this->model_orders->getOrdersData();
	        // echo "<pre>"; print_r($data); exit();

			$this->render_template('reports/waiterwise', $this->data);
        }
	}

	// public function waiterReportData()
	// {
	// 	$from =date('Y-m-d',strtotime($this->input->post('from')));
	// 	$to = date('Y-m-d',strtotime($this->input->post('to')));
 //        $showwaiter=$this->input->post('showWaiter');

	// 	$this->data['waiterData'] = $this->model_waiter->waiterReportData($from, $to ,$showwaiter);
		 
	// 	$this->render_template('reports/waiterwise', $this->data);
	// }

	public function dailyReport()
	{
		if(!in_array('viewReport', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

		$this->data['dailyData'] = array();

		$this->render_template('reports/dailyOrderReport', $this->data);
	}

	public function dailyReportData()
	{
		if(!in_array('viewReport', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

		$day = strtotime(date('Y-m-d'));
		// exit();
		$this->data['dailyData'] = $this->model_reports->dailyReportData($day);

		// print_r($dailyData); exit();

		$this->render_template('reports/dailyOrderReport', $this->data);
	}

	public function storeReport()
	{
		if(!in_array('viewReport', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

		$this->data['storeData'] = $this->model_reports->storeReportData();

		$this->render_template('reports/storeReport', $this->data);
	}

	public function tableReport()
	{
		if(!in_array('viewReport', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $this->form_validation->set_rules('from', 'From Date', 'trim|required');
		$this->form_validation->set_rules('to', 'To Date', 'trim|required');
        
        if ($this->form_validation->run() == TRUE) {

        	$from =date('Y-m-d',strtotime($this->input->post('from')));
			$to = date('Y-m-d',strtotime($this->input->post('to')));

			if($this->input->post('showWaiter') == 0)
			{
				$data = array(
        					'from' => $from, 
        					'to' => $to
        				);
				// echo "<pre>"; print_r($data); exit();


	        	$this->data['allData'] = $this->model_orders->getOrdersDataDateWise($data);
			}
			else if($this->input->post('showWaiter') == 1)
			{
				$data = array(
        					'from' => $from, 
        					'to' => $to,
        					'waiter' => "pb",
        					'field' => 'ordertype'
        				);
				// echo "<pre>"; print_r($data); exit();
	        	$this->data['allData'] = $this->model_orders->getOrdersDataDateWise1($data);	
			}
			else
			{
				$data = array(
        					'from' => $from, 
        					'to' => $to,
        					'waiter' => $this->input->post('showWaiter'),
        					'field' => 'table_id'
        				);
				// echo "<pre>"; print_r($data); exit();
	        	$this->data['allData'] = $this->model_orders->getOrdersDataDateWise1($data);	
			}
	        
	        $this->data['table_data'] = $this->model_tables->getTableData();

			$this->render_template('reports/tableReport', $this->data);
        }
        else
        {
        	// $this->data['tableData'] = $this->model_orders->tableWiseOrderReportData();
	        $this->data['table_data'] = $this->model_tables->getTableData();
	        // echo "<pre>"; print_r($table_data); exit();
	        // $this->data['waiterData'] = array();

			$this->data['allData'] = $this->model_orders->getOrdersData();

			$this->render_template('reports/tableReport', $this->data);
        }
	}
	
	public function tableReportData()
	{
	    $from =date('Y-m-d',strtotime($this->input->post('from')));
		$to = date('Y-m-d',strtotime($this->input->post('to')));
        $table_name = $this->input->post('table_name');
        // exit;
        
        $this->data['waiterData'] = $this->model_tables->tableReportData($from, $to, $table_name);
        $this->data['table_data'] = $this->model_tables->getActiveTable();
// 		 print_r($this->data['waiterData']); exit;
		$this->render_template('reports/tableReport', $this->data);
	}

	public function parcelReport()
	{
		if(!in_array('viewReport', $this->permission)) {
            redirect('dashboard', 'refresh');
        }
        
        $this->data['waiterData'] = array();

		$this->data['tableData'] = $this->model_orders->parcelWiseOrderReportData();
        // echo "<br>"; print_r($this->data['tableData']); echo "</br>"; exit;
		$this->render_template('reports/parcelReport', $this->data);
	}
	
	public function parcelReportData()
	{
	    $from =date('Y-m-d',strtotime($this->input->post('from')));
		$to = date('Y-m-d',strtotime($this->input->post('to')));
        
        $this->data['waiterData'] = $this->model_orders->parcelReportData($from, $to);
// 		 print_r($this->data['waiterData']); exit;
		$this->render_template('reports/parcelReport', $this->data);
	}

	public function productReport()
	{
		if(!in_array('viewReport', $this->permission)) {
            redirect('dashboard', 'refresh');
        }
        
        $this->data['waiterData'] = array();
        
		$this->data['productsData'] = $this->model_products->productsReportData();

		$this->render_template('reports/productReport', $this->data);
	}
	
	public function productReportData()
	{
	    $from =date('Y-m-d',strtotime($this->input->post('from')));
		$to = date('Y-m-d',strtotime($this->input->post('to')));
		$product_id = $this->input->post('showProduct');
		
		 $this->data['waiterData'] = $this->model_products->productReportDataDateWise($from, $to, $product_id);
// 		 print_r($this->data['waiterData']); exit;
		$this->render_template('reports/productReport', $this->data);
	}

	public function salesReport()
	{
		if(!in_array('viewReport', $this->permission)) {
            redirect('dashboard', 'refresh');
        }
        
        $this->form_validation->set_rules('from', 'From Date', 'trim|required');
		$this->form_validation->set_rules('to', 'To Date', 'trim|required');
        
        if ($this->form_validation->run() == TRUE) {

        	$from =date('Y-m-d',strtotime($this->input->post('from')));
			$to = date('Y-m-d',strtotime($this->input->post('to')));

			if($this->input->post('payment_term') == 0 && $this->input->post('sales_type') == 0)
			{
				$data = array(
        					'from' => $from, 
        					'to' => $to
        				);
				// echo "Date<pre>"; print_r($data); exit();

	        	$this->data['allData'] = $this->model_orders->getOrdersDataDateWise($data);
			}
			else if($this->input->post('payment_term') != 0 && $this->input->post('sales_type') == 0)
			{
				$data = array(
        					'from' => $from, 
        					'to' => $to,
        					'waiter' => $this->input->post('payment_term'),
        					'field' => 'payment_term'
        				);
				// echo "<pre>"; print_r($data); exit();
	        	$this->data['allData'] = $this->model_orders->getOrdersDataDateWise1($data);	
			}
			else if($this->input->post('payment_term') == 0 && $this->input->post('sales_type') != 0)
			{
				$data = array(
        					'from' => $from, 
        					'to' => $to,
        					'waiter' => $this->input->post('sales_type'),
        					'field' => 'sales_type'
        				);
				// echo "<pre>"; print_r($data); exit();
	        	$this->data['allData'] = $this->model_orders->getOrdersDataDateWise1($data);	
			}
			else
			{
				$data = array(
        					'from' => $from, 
        					'to' => $to,
        					'payment_term' => $this->input->post('payment_term'),
        					'sales_type' => $this->input->post('sales_type')
        				);
				// echo "<pre>"; print_r($data); exit();
	        	$this->data['allData'] = $this->model_orders->getOrdersDataDateWise2($data);	
			}

			$this->data['paymenttype'] = $this->model_paymentor->fecthAllData();
			$this->data['salestype'] = $this->model_salestype->fecthAllData();

			$this->render_template('reports/salesReport', $this->data);
		}
		else
		{
				$this->data['allData'] = $this->model_orders->getOrdersData();
				$this->data['paymenttype'] = $this->model_paymentor->fecthAllData();
				$this->data['salestype'] = $this->model_salestype->fecthAllData();

				$this->render_template('reports/salesReport', $this->data);
		}
	}

	public function expenseReport()
	{
		if(!in_array('viewReport', $this->permission)) {
            redirect('dashboard', 'refresh');
        }
        
        $this->form_validation->set_rules('from', 'From Date', 'trim|required');
		$this->form_validation->set_rules('to', 'To Date', 'trim|required');
        
        if ($this->form_validation->run() == TRUE) {

        	$from =date('Y-m-d',strtotime($this->input->post('from')));
			$to = date('Y-m-d',strtotime($this->input->post('to')));
			// echo "<pre>"; print_r($_POST); exit();
			if($this->input->post('expCat') == 0 && $this->input->post('payment_term') == 0)
			{
				$data = array(
        					'from' => $from, 
        					'to' => $to
        				);
				// echo "Date<pre>"; print_r($data); exit();

				$this->data['allData'] = $this->model_expences->fecthExpencesDataDateWise($data);
	        	
			}
			else if($this->input->post('expCat') != 0 && $this->input->post('payment_term') == 0)
			{
				$data = array(
        					'from' => $from, 
        					'to' => $to,
        					'expCat' => $this->input->post('expCat')
        				);
				// echo "<pre>"; print_r($data); exit();
	        	$this->data['allData'] = $this->model_expences->fecthExpencesDataDateWise1($data);	
			}
			else if($this->input->post('expCat') == 0 && $this->input->post('payment_term') != 0)
			{
				$data = array(
        					'from' => $from, 
        					'to' => $to,
        					'payment_term' => $this->input->post('payment_term'),
        				);
				// echo "<pre>"; print_r($data); exit();
	        	$this->data['allData'] = $this->model_expences->fecthExpencesDataDateWise2($data);	
			}
			else
			{
				$this->data['allData'] = $this->model_expences->fecthAllExpencesData();				
			}

			$this->data['expCat'] = $this->model_expences->fecthAllCategoryData();
			$this->data['paymenttype'] = $this->model_paymentor->fecthAllData();
			
			$this->render_template('reports/expenseReport', $this->data);
		}
		else
		{
			$this->data['allData'] = $this->model_expences->fecthAllExpencesData();

			$this->data['expCat'] = $this->model_expences->fecthAllCategoryData();
			$this->data['paymenttype'] = $this->model_paymentor->fecthAllData();

	
			$this->render_template('reports/expenseReport', $this->data);
		}
	}
    
    public function salesReportData()
    {
        $from =date('Y-m-d',strtotime($this->input->post('from')));
		$to = date('Y-m-d',strtotime($this->input->post('to')));
		
// 		echo $from; echo '<br>'; echo $to; exit();
        
        $this->data['waiterData'] = $this->model_orders->salesReportDataDateWise($from, $to);
        // print_r($this->data['waiterData']); exit;
		$this->render_template('reports/salesReport', $this->data);
    }


    public function incomeReport()
	{
		if(!in_array('viewReport', $this->permission)) {
            redirect('dashboard', 'refresh');
        }
        
        $this->form_validation->set_rules('from', 'From Date', 'trim|required');
		$this->form_validation->set_rules('to', 'To Date', 'trim|required');
        
        if ($this->form_validation->run() == TRUE) {

        	$from =date('Y-m-d',strtotime($this->input->post('from')));
			$to = date('Y-m-d',strtotime($this->input->post('to')));
			// echo "<pre>"; print_r($_POST); exit();
			// if($this->input->post('from') == 0 && $this->input->post('payment_term') == 0)
			// {
				$data = array(
        					'from' => $from, 
        					'to' => $to
        				);
				// echo "Date<pre>"; print_r($data); //exit();

				$expData = $this->model_expences->fecthAllExpencesReportCatWise1($data);
				$salesData = $this->model_orders->getOrdersReport1($from, $to);
				// echo "Exp <pre>"; print_r($expData); //exit();
				// echo "Sales <pre>"; print_r($salesData); exit();
				
				$this->data['expData'] = $expData;
				$this->data['salesData'] = $salesData;
				
				$this->render_template('reports/incomeReport', $this->data);

			// }
			
		}
		else
		{ 
			$expData = $this->model_expences->fecthAllExpencesReportCatWise();
			$salesData = $this->model_orders->getOrdersReport();
			
			$this->data['expData'] = $expData;
			$this->data['salesData'] = $salesData;
	
			$this->render_template('reports/incomeReport', $this->data);
		}
	}

	public function gstReport()
	{
		if(!in_array('viewReport', $this->permission)) {
            redirect('dashboard', 'refresh');
        }
        
        $this->form_validation->set_rules('from', 'From Date', 'trim|required');
		$this->form_validation->set_rules('to', 'To Date', 'trim|required');
        
        if ($this->form_validation->run() == TRUE) {

        	$from =date('Y-m-d',strtotime($this->input->post('from')));
			$to = date('Y-m-d',strtotime($this->input->post('to')));
			// echo "<pre>"; print_r($_POST); exit();
			if($this->input->post('gstidData') == 0)
			{
				$data = array(
        					'from' => $from, 
        					'to' => $to
        				);

				// echo "Date<pre>"; print_r($data); exit();

				$this->data['orderItemData'] = $this->model_orders->getOrdersItem1($data);
			}
			else if($this->input->post('gstidData') != 0)
			{
				$data = array(
        					'from' => $from, 
        					'to' => $to,
        					'gst' => $this->input->post('gstidData'),
        				);
				// echo "Date<pre>"; print_r($data); exit();
				

				$this->data['orderItemData'] = $this->model_orders->getOrdersItem2($data);
			}

			$this->data['gst'] = $this->model_gst->fecthAllData();

			$this->render_template('reports/gstReport', $this->data);				
		}
		else
		{
			$this->data['orderData'] = $this->model_orders->getOrdersData();
			// echo "<pre>"; print_r($orderData);

			// $this->data['orderItemData'] = $this->model_orders->getOrdersItem();
			$this->data['gst'] = $this->model_gst->fecthAllData();
			
			$this->render_template('reports/gstReport', $this->data);
		}		
	}

}	