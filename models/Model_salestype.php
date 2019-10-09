<?php 

class Model_salestype extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function fecthActiveSalesTypeData()
	{
		$query = $this->db->select()
							->from('sales_type')
							->where('active', 1)
							->get();
		return $query->result();
	}

	public function fecthAllData()
	{
		$query = $this->db->select('*')
							->from('sales_type')
							->get();
		return $query->result();
	}

	public function fecthDataByID($id='')
	{
		$query = $this->db->select('*')
							->from('sales_type')
							->where('id', $id)
							->get();
		return $query->row_array();
	}

	public function create($data = array())
	{
		if($data) {

			$this->db->set('created','NOW()', FALSE);
			$create = $this->db->insert('sales_type', $data);
			return ($create == true) ? true : false;
		}
	}

	public function update($data = array())
	{
		if($data) {
			$this->db->set('modified','NOW()', FALSE);

			$this->db->set('name', $data['name']);
			$this->db->set('active', $data['active']);

			$this->db->where('id', $data['id']);
			return $result = $this->db->update('sales_type');
		}
	}

	public function deleteSalesType($id = "")
	{
		$this->db->where('id', $id);
		return $result=$this->db->delete('sales_type');
	}

	public function statusChange($data = array())
	{
		if($data) {
			$this->db->set('modified','NOW()', FALSE);

			$this->db->set('active', $data['active']);

			$this->db->where('id', $data['id']);
			return $result = $this->db->update('sales_type');
		}
	}
}