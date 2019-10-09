<?php 

class Model_paymentor extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function fecthActivePaymentorData()
	{
		$query = $this->db->select()
							->from('paymentor')
							->where('active', 1)
							->get();
		return $query->result();
	}

	public function fecthAllData()
	{
		$query = $this->db->select('*')
							->from('paymentor')
							->get();
		return $query->result();
	}

	public function fecthAllDataById($id='')
	{
		$query = $this->db->select('*')
							->from('paymentor')
							->where('id', $id)
							->get();
		return $query->row_array();
	}

	public function create($data = array())
	{
		if($data) {

			$this->db->set('created','NOW()', FALSE);
			$create = $this->db->insert('paymentor', $data);
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
			return $result = $this->db->update('paymentor');
		}
	}

	public function deletePaymentor($id = "")
	{
		$this->db->where('id', $id);
		return $result=$this->db->delete('paymentor');
	}

	public function statusWaiter($data = array())
	{
		if($data) {
			$this->db->set('modified','NOW()', FALSE);

			$this->db->set('active', $data['active']);

			$this->db->where('id', $data['id']);
			return $result = $this->db->update('paymentor');
		}
	}
}