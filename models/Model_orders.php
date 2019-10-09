<?php 

class Model_orders extends CI_Model
{
	public function __construct()
	{
		parent::__construct();

		$this->load->model('model_tables');
		$this->load->model('model_users');
	}

	public function createOrder($data = array())
	{
		if($data) {
			$this->db->set('created','NOW()', FALSE);
			$this->db->set('todate','NOW()', FALSE);

			$create = $this->db->insert('orders', $data);
// 			return ($create == true) ? true : false;
            return $this->db->insert_id();
		}
	}

	public function ordersItemInvoice($order_id = null)
	{
		if(!$order_id) {
			return false;
		}

		$sql = "SELECT SUM(qty) as sumQty, SUM(rate) as sumRate, SUM(netAmt) as sumNetAmt, order_items.* FROM order_items WHERE order_id = ? group by product_id";
		$query = $this->db->query($sql, array($order_id));
		return $query->result_array();
	}


	public function updateOrder($data = array())
	{
		if($data) {
		    $this->db->set('modified','NOW()', FALSE);
			$this->db->where('id', $data['id']);
			$update = $this->db->update('orders', $data);
			return ($update == true) ? true : false;
		}
	}

	public function getOrdersDataDateWise($data = array())
	{
				// echo "<pre>"; print_r($data); exit();

		$wh = "SELECT * FROM orders WHERE todate BETWEEN  ? AND ? ";
		$query = $this->db->query($wh, array($data['from'], $data['to']));
		return $query->result_array();
	}

	public function getOrdersDataDateWise1($data = array())
	{
		$wh = "SELECT * FROM orders WHERE ".$data['field']." = ? AND todate BETWEEN  ? AND ? ";
		$query = $this->db->query($wh, array($data['waiter'], $data['from'], $data['to']));
		return $query->result_array();
	}

	public function getOrdersDataDateWise2($data = array())
	{
		$wh = "SELECT * FROM orders WHERE payment_term = ? AND sales_type = ? AND created BETWEEN  ? AND ? ";
		$query = $this->db->query($wh, array($data['payment_term'], $data['sales_type'], $data['from'], $data['to']));
		return $query->result_array();
	}

	public function getOrdersReport()
	{
		$wh = "SELECT * FROM orders group by bill_no";
		$query = $this->db->query($wh);
		return $query->result_array();
	}

	public function getOrdersReport1($from='', $to='')
	{
		$wh="select * from orders where todate between '$from' and '$to' group by bill_no ";
		$query = $this->db->query($wh);
		return $query->result_array();


		// $wh = "SELECT * FROM orders where created BETWEEN ? AND group by bill_no ";
		// $query = $this->db->query($wh);
		// return $query->result_array();
	}

	public function countSalesVolume($today='')
	{
		$query = $this->db->select()
							->from('orders')
							->where('todate', $today)
							->get();
		return $query->num_rows();
	}

	public function countProductSales($today='')
	{
		$query = $this->db->select('SUM(qty) as sumQty')
							->from('order_items')
							->where('todate', $today)
							->join('orders', 'orders.id = order_items.order_id')
							->get();
		return $query->row_array();
	}



	public function countTodayOrder($today='', $field='', $value='')
	{
		$query = $this->db->select()
							->from('orders')
							->where('todate', $today)
							->where($field, $value)
							->get();
		return $query->num_rows();
	}

	public function countTodayParcel($today='')
	{
		$query = $this->db->select()
							->from('orders')
							->where('todate', $today)
							->where('ordertype', 'pb')
							->get();
		return $query->num_rows();
	}

	public function countTodaySalesAmt($today='')
	{
		$query = $this->db->select('SUM(fnetamt) as netamt')
							->from('orders')
							->where('todate', $today)
							->get();
		return $query->row_array();
	}

	public function countTodaySalesAmt1($today='', $field='', $value='')
	{
		$query = $this->db->select('SUM(fnetamt) as netamt')
							->from('orders')
							->where('todate', $today)
							->where($field, $value)
							->get();
		return $query->row_array();
	}

	public function updateOrderItem($data=array())
	{
		if($data) {
			$this->db->where('id', $data['id']);
			return $result = $this->db->update('order_items', $data);
		}
	}



	public function createOrderItem($data = array())
	{
		if($data) {
			$create = $this->db->insert('order_items', $data);
			return ($create == true) ? true : false;
            // return $this->db->insert_id();
		}
	}

	// Without KOT
	public function deletOrderItemNotKot($id='')
	{
		if($id) {
			$this->db->where('order_id', $id);
			$this->db->where('kot_status', '1');
			return $result=$this->db->delete('order_items');
			// $delete_item = $this->db->delete('order_items');
			// return ($delete == true && $delete_item) ? true : false;
		}
	}

	public function getOrdersItem()
    {
        $query = $this->db->select('')
                            ->from('order_items')
                            ->get();
        return $query->result_array();
    }
    

    public function getOrdersItem1($data=array())
    {
        $query = $this->db->select('')
                            ->from('order_items')
                            ->where('orders.todate >=', $data['from'])
                            ->where('orders.todate <=', $data['to'])
                            ->join('orders', 'orders.id = order_items.order_id', 'left')
                            ->get();
        return $query->result_array();
    }

    public function getOrdersItem2($data=array())
    {
    	$query = $this->db->select('')
                            ->from('order_items')
                            ->where('orders.todate >=', $data['from'])
                            ->where('orders.todate <=', $data['to'])
                            ->where('products.gst_id', $data['gst'])
                            ->join('orders', 'orders.id = order_items.order_id', 'left')
                            ->join('products', 'products.id = order_items.product_id', 'left')
                            ->get();
        return $query->result_array();	
    }
    



// ===============================================================================
    
    public function getOrdersInvoiceData($id='')
    {
        // print_r($id);exit();
        $query = $this->db->select('')
                            ->from('orders')
                            ->where('orders.id', $id)
                            ->join('tables', 'tables.id = orders.table_id', 'left')
                            ->get();
        return $query->row_array();
    }
    
	/* get the orders data */
	public function getOrdersData($id = null)
	{
		if($id) {
			$sql = "SELECT * FROM orders WHERE id = ?";
			$query = $this->db->query($sql, array($id));
			return $query->row_array();
		}

		$user_id = $this->session->userdata('id');
		if($user_id == 1) {
			$sql = "SELECT * FROM orders ORDER BY id DESC";
			$query = $this->db->query($sql);
			return $query->result_array();
		}
		else {
			$user_data = $this->model_users->getUserData($user_id);
			$sql = "SELECT * FROM orders WHERE store_id = ? ORDER BY id DESC";
			$query = $this->db->query($sql, array($user_data['store_id']));
			return $query->result_array();	
		}
	}

	// get the orders item data
	public function getOrdersItemData($order_id = null)
	{
		if(!$order_id) {
			return false;
		}

		$sql = "SELECT * FROM order_items WHERE order_id = ?";
		$query = $this->db->query($sql, array($order_id));
		return $query->result_array();
	}

    public function getOrdersAndProductItemData($order_id = null)
    {
        $query = $this->db->select()
                        ->from('order_items')
                        ->where('order_items.order_id', $order_id)
                        ->join('products', 'products.sr_no = order_items.product_id', 'left')
                        ->get();
        return $query->result_array();
        
    }

	public function create()
	{
	    // for bill number
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

// 		$lastRecord = $lastRecord->bill_no + 1;
		
// 		$bill_no = str_pad($lastRecord, 5, "0", STR_PAD_LEFT);
		
	   
		// echo "<pre>"; print_r($this->input->post()); echo "</pre>"; exit();
		$user_id = $this->session->userdata('id');
		// get store id from user id 
		$user_data = $this->model_users->getUserData($user_id);
		$store_id = $user_data['store_id'];

// 		$bill_no = 'BILPR-'.strtoupper(substr(md5(uniqid(mt_rand(), true)), 0, 4));
		$tran_data=$this->input->post('tran_name');
		if(isset($tran_data)){
			$tran_type=$this->input->post('tran_name');
		}else{
			$tran_type='tb';
		}
		
		$dateTime = new DateTime('now', new DateTimeZone('Asia/Kolkata'));
		$date = $dateTime->format("Y-m-d  H:i:s");
		
// 		print_r($date); exit();

    	$data = array(
    		'bill_no' => $bill_no,
    		'date_time' => strtotime(date('Y-m-d h:i:s a')),
    		'gross_amount' => $this->input->post('gross_amount_value'),
    		// 'service_charge_rate' => $this->input->post('service_charge_rate'),
    		// 'service_charge_amount' => ($this->input->post('service_charge_value') > 0) ?$this->input->post('service_charge_value'):0,
    		// 'vat_charge_rate' => $this->input->post('vat_charge_rate'),
    		// 'vat_charge_amount' => ($this->input->post('vat_charge_value') > 0) ? $this->input->post('vat_charge_value') : 0,
    		//'totalgst ' => $this->input->post('total_gst_rate_value'),
    		'net_amount' => $this->input->post('net_amount_value'),
    		'discount' => $this->input->post('discount'),
    		'paid_status' => $this->input->post('paid_status'),
    		'user_id' => $user_id,
    		'table_id' => $this->input->post('table_name'),
    		'store_id' => $store_id,
    		'waiter' => $this->input->post('showWaiter'),
    		'payment_term' => $this->input->post('showPaymentor'),
    		'sales_type' => $this->input->post('showSalesType'),
    		'totalgst' => $this->input->post('gst_amount_value'),
// 			'created'=> $date,
			'ordertype'=>$tran_type,
			'created' => $date
			//echo 
    	);
    // 	print_r($data); exit;
        // $this->db->set('created','NOW()', FALSE);	
    	 //echo "<pre>"; print_r($data); echo "</pre>"; exit();

		$insert = $this->db->insert('orders', $data);
		// echo $insert;exit();
		$order_id = $this->db->insert_id();

		$count_product = count($this->input->post('product'));
    	for($x = 0; $x < $count_product; $x++) {
    		$items = array(
    			'order_id' => $order_id,
    			'product_id' => $this->input->post('product_id')[$x],
    			'qty' => $this->input->post('qty')[$x],
    			'rate' => $this->input->post('rate_value')[$x],
				'rate' => $this->input->post('rate_value')[$x],
				'unit'=>$this->input->post('unit_value')[$x],
				'amount' => $this->input->post('amount_value')[$x],
    			'cgst' => 0,
				'sgst' => 0,
    			'hsn' => $this->input->post('hsn_value')[$x],
				'gst' => $this->input->post('gst_value')[$x],
    		
    		);
        // print_r($items); exit;
    	$this->db->insert('order_items', $items);

    	}

    	// update the table status
    	$this->load->model('model_tables');
    	$this->model_tables->update($this->input->post('table_name'), array('available' => 2));

    	$this->db->set('available ', $this->input->post('paid_status'));
    	$this->db->set('currentorder_id ', $order_id);
    	$this->db->where('id', $this->input->post('table_name'));
    	$this->db->update('tables');

		return ($order_id) ? $order_id : false;
	}

	public function countOrderItem($order_id)
	{
		if($order_id) {
			$sql = "SELECT * FROM order_items WHERE order_id = ?";
			$query = $this->db->query($sql, array($order_id));
			return $query->num_rows();
		}
	}

	public function update($id)
	{
		if($id) {
			$user_id = $this->session->userdata('id');
			$user_data = $this->model_users->getUserData($user_id);
			$store_id = $user_data['store_id'];
			// update the table info

			$order_data = $this->getOrdersData($id);
			$data = $this->model_tables->update($order_data['table_id'], array('available' => 1));

			if($this->input->post('paid_status') == 1) {
	    		$this->model_tables->update($this->input->post('table_name'), array('available' => 1));	
	    	}
	    	else {
	    		$this->model_tables->update($this->input->post('table_name'), array('available' => 2));	
	    	}

			// echo "<pre>"; print_r($this->input->post()); echo "</pre>"; exit();

			$data = array(
	    		'gross_amount' => $this->input->post('gross_amount_value'),
	    		// 'service_charge_rate' => $this->input->post('service_charge_rate'),
	    		// 'service_charge_amount' => ($this->input->post('service_charge_value') > 0) ?$this->input->post('service_charge_value'):0,
	    		// 'vat_charge_rate' => $this->input->post('vat_charge_rate'),
	    		// 'vat_charge_amount' => ($this->input->post('vat_charge_value') > 0) ? $this->input->post('vat_charge_value') : 0,
    			'totalgst ' => $this->input->post('gst_amount_value'),
	    		'net_amount' => $this->input->post('net_amount_value'),
	    		'discount' => $this->input->post('discount'),
	    		'paid_status' => $this->input->post('paid_status')
	    		
				// 'totalgst' => $this->input->post('amount_value'),
	    	);

    		// echo "<pre>"; print_r($data); echo "</pre>"; exit();


			$this->db->where('id', $id);
			$update = $this->db->update('orders', $data);

			// now remove the order item data 
			$this->db->where('order_id', $id);
			$this->db->delete('order_items');

			$count_product = count($this->input->post('product'));

	    	for($x = 0; $x < $count_product; $x++) {
	    		$items = array(
	    			'order_id' => $id,
    			'product_id' => $this->input->post('product_id')[$x],
    			'qty' => $this->input->post('qty')[$x],
    			'rate' => $this->input->post('rate_value')[$x],
				'rate' => $this->input->post('rate_value')[$x],
				'unit'=>$this->input->post('unit_value')[$x],
				'amount' => $this->input->post('amount_value')[$x],
    			'cgst' => 0,
				'sgst' => 0,
    			'hsn' => $this->input->post('hsn_value')[$x],
				'gst' => $this->input->post('gst_value')[$x],
				'kot_status' => $this->input->post('kot')[$x],
    			
	    		);
	    		// echo "<pre>"; print_r($items); echo "</pre>"; exit();
	    		$this->db->insert('order_items', $items);
	    	}

	    	if($this->input->post('paid_status') == 1) //paid
	    	{
	    		$this->db->set('available ', 1);
		    	$this->db->set('currentorder_id ', "");
		    	$this->db->where('id', $this->input->post('table_name'));
		    	$this->db->update('tables');
	    	}
	    	else
	    	{
	    		$this->db->set('available ', 2);
		    	$this->db->set('currentorder_id ', $id);
		    	$this->db->where('id', $this->input->post('table_name'));
		    	$this->db->update('tables');	
	    	}
	    	
			return true;
		}
	}

	public function remove($id)
	{
		if($id) {
			$this->db->where('id', $id);
			$delete = $this->db->delete('orders');

			$this->db->where('order_id', $id);
			$delete_item = $this->db->delete('order_items');
			return ($delete == true && $delete_item) ? true : false;
		}
	}

	public function countTotalPaidOrders()
	{
		$sql = "SELECT * FROM orders WHERE paid_status = ?";
		$query = $this->db->query($sql, array(1));
		return $query->num_rows();
	}

	// my code
	public function fecthAllOrderData()
	{
		$query = $this->db->select('orders.id, orders.bill_no, stores.name as name, orders.gross_amount, orders.date_time, orders.paid_status')
							->from('orders')
							->join('stores', 'stores.id = orders.store_id', 'left')
							->get();
		return $query->result();
	}

	public function fecthOrderDataByID($id='')
	{
		$query = $this->db->select('*')
							->from('orders')
							->where('id', $id)
							->get();
		return $query->row_array();
	}



	public function fecthOrderDataByField($field='' , $id='')
	{
		$query = $this->db->select('*')
							->from('orders')
							->where($field, $id)
							->get();
		return $query->row_array();
	}


public function viewData($id = '')
	{
		$query = $this->db->select('')
						->from('orders')
						->where('orders.id', $id)
						// ->join('tables', 'tables.id = orders.table_id', 'left')
						// ->join('waiter', 'waiter.id = orders.waiter', 'left')
						// ->join('paymentor', 'paymentor.id = orders.payment_term', 'left')
						// ->join('sales_type', 'sales_type.id = orders.sales_type', 'left')
						// ->join('order_items', 'order_items.order_id = orders.id', 'left')
						->get();
		return $query->row_array();
	}

	public function viewProductData($id = '')
	{
		$query = $this->db->select()
							->from('order_items')
							->where('order_id', $id)
							// ->join('products', 'products.sr_no = order_items.product_id', 'left')
							->get();
		return $query->result();
	}

	public function countDailyBussiness($toDay)
	{
		$query = $this->db->select()
							->from('orders')
							->where('date_time', $toDay)
							->get();
		return $query->num_rows();
	}

	public function TotalMonthlyBussiness($toDay, $beforeOneMonth)
	{
		$query = $this->db->select()
							->from('orders')
							->where('date_time >=', $beforeOneMonth)
							->where('date_time <=', $toDay)
							->get();
		return $query->num_rows();
	}

	public function tableWiseOrderReportData()
	{
		$query = $this->db->select('tables.table_name as table_name, orders.date_time as date, orders.bill_no, orders.net_amount as amount, sales_type.name as sales_type')
							->from('orders')
							->join('tables', 'tables.id = orders.table_id', 'left')
							->join('sales_type', 'sales_type.id = orders.sales_type', 'left')
							->where('orders.ordertype =', 'tb')
							->get();
		return $query->result();
	}

	public function parcelWiseOrderReportData()
	{
		$query = $this->db->select('table_parcel.table_name as table_name, orders.date_time as date, orders.bill_no, orders.net_amount as amount, sales_type.name as sales_type')
							->from('orders')
							->join('table_parcel', 'table_parcel.id = orders.parcel_id', 'left')
							->join('sales_type', 'sales_type.id = orders.sales_type', 'left')
							->where('orders.ordertype !=', 'tb')
							->get();
		return $query->result();
	}
	
	public function parcelReportData($from='', $to='')
	{
	   // echo $from; echo "<br>"; echo $to;exit();
	    $wh="select * from orders where created between '$from' and '$to' and ordertype != 'tb'";
		$query = $this->db->query($wh);
		return $query->result();
	}

	public function salesReportData()
	{
		$query = $this->db->select('orders.id,  orders.date_time as date, orders.bill_no, orders.net_amount as amount, sales_type.name as sales_type, orders.table_id, orders.parcel_id, tables.table_name as table_name, table_parcel.table_name as parcel_name')
							->from('orders')
							->join('tables', 'tables.id = orders.table_id', 'left')
							->join('table_parcel', 'table_parcel.id = orders.parcel_id', 'left')
							->join('sales_type', 'sales_type.id = orders.sales_type', 'left')
							->get();
		return $query->result();
		// print_r($query->result()); exit();
	}
	
	public function salesReportDataDateWise($from='', $to='')
	{
	   // echo $from; echo $to; exit();
	    $wh="select * from orders where created between '$from' and '$to'";
		$query = $this->db->query($wh);
		return $query->result();
	}

	public function countProducts($id)
	{
		$query = $this->db->select()
							->from('order_items')
							->where('order_id', $id)
							->get();
		return $query->num_rows();
	}

	public function getKOTItemData($order_id = null)
	{
		if(!$order_id) {
			return false;
		}

		$sql = "SELECT * FROM order_items WHERE order_id = ? and kot_status='1'";
		$query = $this->db->query($sql, array($order_id));
		return $query->result_array();
	}
	
	public function setKotStatus($order_items_id)
	{
		// print_r($order_items_id); exit();
		$this->db->set('kot_status', '2');
		$this->db->where('id', $order_items_id);
		return $result = $this->db->update('order_items');
	}


	public function existInProductIdorder($id)
	{
		$query = $this->db->select('*')
							->from('order_items')
							->where('product_id', $id)
							->get();
		return $query->num_rows();
	}

	public function existInTableInorder($id)
	{
		$query = $this->db->select('*')
							->from('orders')
							->where('table_id', $id)
							->get();
		return $query->num_rows();
	}

	public function existInParcelInorder($id)
	{
		$query = $this->db->select('*')
							->from('orders')
							->where('parcel_id', $id)
							->get();
		return $query->num_rows();
	}
	

}