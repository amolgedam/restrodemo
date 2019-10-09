<?php 

class Model_tables extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function fecthAllTables()
	{
		$query = $this->db->select()
							->from('tables')
							->get();
		return $query->result();
	}

	public function getTableData($id = null)
	{
		if($id) {
			$sql = "SELECT * FROM tables WHERE id = ?";
			$query = $this->db->query($sql, array($id));
			return $query->row_array();
		}

		// if admin all data 
		$user_id = $this->session->userdata('id');
		if($user_id == 1) {
			$sql = "SELECT * FROM tables ORDER BY id DESC";
			$query = $this->db->query($sql);
			return $query->result_array();	
		}
		else {
			$this->load->model('model_users');
			$user_data = $this->model_users->getUserData($user_id);
			$sql = "SELECT * FROM tables WHERE store_id = ? ORDER BY id DESC";
			$query = $this->db->query($sql, array($user_data['store_id']));
			return $query->result_array();		
		}

		// else store wise

		
	}

	public function countTableopen()
	{
		$query = $this->db->select()
							->from('tables')
							->where('available', '1')
							->get();
		return $query->num_rows();
	}

	public function countTableclose()
	{
		$query = $this->db->select()
							->from('tables')
							->where('available !=', '1')
							->get();
		return $query->num_rows();
	}

	public function create($data = array())
	{
		if($data) {
			$create = $this->db->insert('tables', $data);
			return ($create == true) ? true : false;
		}
	}

	public function update($id = null, $data = array())
	{		
		// echo $id;
		// echo "<pre>"; print_r($data); exit();
		$this->db->where('id', $id);
		$update = $this->db->update('tables', $data);

		return ($update == true) ? true : false;
	}

	public function remove($id = null)
	{
		if($id) {
			$this->db->where('id', $id);
			$delete = $this->db->delete('tables');
			return ($delete == true) ? true : false;
		}
	}

	public function getActiveTable()
	{
		$user_id = $this->session->userdata('id');
		if($user_id == 1) {
			$sql = "SELECT * FROM tables WHERE available = ? AND active = ?";
			$query = $this->db->query($sql, array(1, 1));
			return $query->result_array();	
		}
		else {
			$this->load->model('model_users');
			$user_data = $this->model_users->getUserData($user_id);
			$sql = "SELECT * FROM tables WHERE store_id = ? AND available = ? AND active = ? ORDER BY id DESC";
			$query = $this->db->query($sql, array($user_data['store_id'], 1, 1));
			return $query->result_array();			
		}
	}
	
	public function getTableDataByOrderID($id='')
	{
	    $query = $this->db->select('tables.id, tables.table_name')
	                        ->from('tables')
	                        ->where('orders.id', $id)
	                        ->join('orders', 'orders.table_id = tables.id', 'left')
	                        ->get();
	    return $query->row_array();
	}

	public function getTableDataByStoreID($id='')
	{
	    $query = $this->db->select('*')
	                        ->from('tables')
	                        ->where('store_id', $id)
	                        ->get();
	    return $query->row_array();
	}
	
	public function tableReportData($from='', $to='',$table='')
	{
	   // echo $from;echo "<br>"; echo $to; echo "<br>"; echo $table;exit;
	    $wh="select * from orders where created between '$from' and '$to' and table_id=".$table."";
		$query = $this->db->query($wh);
							
		//$result= $this->db->get();
		return $query->result();
	}
}