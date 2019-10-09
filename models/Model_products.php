<?php 

class Model_products extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('model_users');
	}

	/* get the product data */
	public function getProductGstData($id)
	{
		
		$query = $this->db->select('*')
							->from('products')
							->where('products.name', $id)
							->join('gst', 'gst.gst_id = products.gst_id', 'left')
							->join('unit_type', 'unit_type.id = products.unit_id', 'left')
							->get();
		return $query->row_array();
	}
  
	public function getProductData($id = null)
	{
		if($id) {
			$sql = "SELECT * FROM products where id = ?";
			$query = $this->db->query($sql, array($id));
			return $query->row_array();
		}	

		$user_id = $this->session->userdata('id');
		if($user_id == 1) {
			$sql = "SELECT * FROM products ORDER BY id DESC";
			$query = $this->db->query($sql);
			return $query->result_array(); 
		}
		else {
			
			$user_data = $this->model_users->getUserData($user_id);
			$sql = "SELECT * FROM products ORDER BY id DESC";
			$query = $this->db->query($sql);

			$data = array();
			foreach ($query->result_array() as $k => $v) {
				$store_ids = json_decode($v['store_id']);
				if(in_array($user_data['store_id'], $store_ids)) {
					$data[] = $v;
				}
			}

			return $data;		
		}
	}
	
	public function getProductDataBySrNo($sr_no = '')
	{
	    $query = $this->db->select('*')
	                    ->from('products')
	                    ->where('sr_no', $sr_no)
	                    ->get();
	   return $query->row_array();
	}

	public function getDataByid($id = '')
	{
	    $query = $this->db->select('*')
	                    ->from('products')
	                    ->where('id', $id)
	                    ->get();
	   return $query->row_array();
	}

	public function getProductDataByName($name = '')
	{
	    $query = $this->db->select('*')
	                    ->from('products')
	                    ->where('name', $name)
	                    ->get();
	   return $query->row_array();
	}
	
	public function getKotDataBySrNo($sr_no)
	{
		$query = $this->db->select('products.name')
							->from('products')
							->join('order_items', 'order_items.product_id = products.sr_no', 'left')
							->where('products.sr_no', $sr_no)
				// 			->where('order_items.kot_status', 1)
							->get();
		return $query->row_array();
	}

	/* get the product data */
	public function getProductDataByCat($cat_id = null)
	{
		if($cat_id) {

			$user_id = $this->session->userdata('id');
			if($user_id == 1) {
				$sql = "SELECT * FROM products ORDER BY id DESC";
				$query = $this->db->query($sql);
				$result = array();
				foreach($query->result_array() as $key => $value) {
					$category_ids = json_decode($value['category_id']);
					if(in_array($cat_id, $category_ids)) {
						$result[] = $value;
					}
				} 

				return $result;
			}
			else {

				// for store users 
				$user_data = $this->model_users->getUserData($user_id);

				$sql = "SELECT * FROM products ORDER BY id DESC";
				$query = $this->db->query($sql);

				$data = array();
				foreach ($query->result_array() as $k => $v) {
					$store_ids = json_decode($v['store_id']);
					$category_ids = json_decode($v['category_id']);
					if(in_array($cat_id, $category_ids) && in_array($user_data['store_id'], $store_ids)) {
						$data[] = $v;
					}
				}

				return $data;		


			}
		}	
	}

	public function getActiveProductData()
	{
		$user_id = $this->session->userdata('id');

		if($user_id == 1) {
			$sql = "SELECT * FROM products WHERE active = ? ORDER BY id DESC";
			$query = $this->db->query($sql, array(1));
			return $query->result_array();
		}
		else {
			$this->load->model('model_users');
			$user_data = $this->model_users->getUserData($user_id);
			$sql = "SELECT * FROM products WHERE active = ? ORDER BY id DESC";
			$query = $this->db->query($sql, array(1));

			$data = array();
			foreach ($query->result_array() as $k => $v) {
				$store_ids = json_decode($v['store_id']);
				if(in_array($user_data['store_id'], $store_ids)) {
					$data[] = $v;
				}
			}

			return $data;			
		}

		
	}

	public function create($data)
	{
		if($data) {
			$insert = $this->db->insert('products', $data);
			return ($insert == true) ? true : false;
		}
	}

	public function update($data, $id)
	{
		if($data && $id) {
			$this->db->where('id', $id);
			$update = $this->db->update('products', $data);
			return ($update == true) ? true : false;
		}
	}

	public function remove($id)
	{
		if($id) {
			$this->db->where('id', $id);
			$delete = $this->db->delete('products');
			return ($delete == true) ? true : false;
		}
	}

	public function countTotalProducts()
	{
		$sql = "SELECT * FROM products";
		$query = $this->db->query($sql);
		return $query->num_rows();
	}

	public function productsReportData()
	{
		$query = $this->db->select('orders.date_time as date, products.name as products_name, order_items.qty , sales_type.name as sales_type')
							->from('orders')
							->join('order_items', 'order_items.order_id = orders.id', 'left')
							->join('products', 'products.id = order_items.product_id', 'left')
							->join('sales_type', 'sales_type.id = orders.sales_type', 'left')
							->get();
		return $query->result();
	}
	
	public function productReportDataDateWise($from='', $to='', $product_id='')
	{
	   // echo $from; echo "<br>"; echo $to; echo "<br>"; echo $product_id; exit;
	   //  $wh="select * from orders where created between '$from' and '$to'";
	   $query = $this->db->select('*')
	                    ->from('orders')
	                    ->where('orders.created >=', $from)
						->where('orders.created <=', $to)
	                    ->where('order_items.product_id', $product_id)
	                   // ->or_where('orders.created =', $from)
	                    ->join('order_items', 'order_items.order_id = orders.id')
	                    ->get();
	   return $query->result();
	}


	// Find GST in Product Table
	public function existInGstinProduct($id)
	{
		$query = $this->db->select('*')
							->from('products')
							->where('gst_id', $id)
							->get();
		return $query->num_rows();
	}

	public function existInCatinProduct($id)
	{
		$query = $this->db->select('*')
							->from('products')
							->where('category_id', $id)
							->get();
		return $query->num_rows();
	}

	public function existInUnitinProduct($id)
	{
		$query = $this->db->select('*')
							->from('products')
							->where('unit_id', $id)
							->get();
		return $query->num_rows();
	}
	
}	