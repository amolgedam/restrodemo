<?php 

class Model_parcel extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function fecthAllTables()
	{
		$query = $this->db->select()
							->from('table_parcel')
							->get();
		return $query->result();
	}

	public function getTableData($id = null)
	{
		if($id) {
			$sql = "SELECT * FROM table_parcel WHERE id = ?";
			$query = $this->db->query($sql, array($id));
			return $query->row_array();
		}

		// if admin all data 
		$user_id = $this->session->userdata('id');
		if($user_id == 1) {
			$sql = "SELECT * FROM table_parcel ORDER BY id DESC";
			$query = $this->db->query($sql);
			return $query->result_array();	
		}
		else {
			$this->load->model('model_users');
			$user_data = $this->model_users->getUserData($user_id);
			$sql = "SELECT * FROM table_parcel WHERE store_id = ? ORDER BY id DESC";
			$query = $this->db->query($sql, array($user_data['store_id']));
			return $query->result_array();		
		}

		// else store wise

		
	}

	public function create($data = array())
	{
		if($data) {
			$create = $this->db->insert('table_parcel', $data);
			return ($create == true) ? true : false;
		}
	}

	public function update($id = null, $data = array())
	{		
		$this->db->where('id', $id);
		$update = $this->db->update('table_parcel', $data);

		return ($update == true) ? true : false;
	}

	public function remove($id = null)
	{
		if($id) {
			$this->db->where('id', $id);
			$delete = $this->db->delete('table_parcel');
			return ($delete == true) ? true : false;
		}
	}

	public function getActiveTable()
	{
		$user_id = $this->session->userdata('id');
		if($user_id == 1) {
			$sql = "SELECT * FROM table_parcel WHERE available = ? AND active = ?";
			$query = $this->db->query($sql, array(1, 1));
			return $query->result_array();	
		}
		else {
			$this->load->model('model_users');
			$user_data = $this->model_users->getUserData($user_id);
			$sql = "SELECT * FROM table_parcel WHERE store_id = ? AND available = ? AND active = ? ORDER BY id DESC";
			$query = $this->db->query($sql, array($user_data['store_id'], 1, 1));
			return $query->result_array();			
		}

		
	}
}