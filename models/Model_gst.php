<?php 

class Model_gst extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function fecthfecthSgst()
	{
		$query = $this->db->select('sgst')
							->from('gst')
							->get();
		return $query->result();
	}

	public function fecthfecthCgst()
	{
		$query = $this->db->select('cgst')
							->from('gst')
							->get();
		return $query->result();
	}

	public function fecthAllData()
	{
		$query = $this->db->select('*')
							->from('gst')
							->get();
		return $query->result();
	}

	public function fecthAllDataByID($id='')
	{
		$query = $this->db->select('*')
							->from('gst')
							->where('gst_id', $id)
							->get();
		return $query->row_array();
	}

	public function createGst($data = array())
	{
		if($data) {
			$this->db->set('created','NOW()', FALSE);	

			$create = $this->db->insert('gst', $data);
			return ($create == true) ? true : false;
		}
	}

	public function updateGst($data = array())
	{
		if($data) {
			$this->db->set('modified','NOW()', FALSE);

			$this->db->set('name', $data['name']);
			$this->db->set('hsn', $data['hsn']);
			$this->db->set('sgst', $data['sgst']);
			$this->db->set('cgst', $data['cgst']);
			$this->db->set('igst', $data['igst']);
			$this->db->set('total_gst', $data['total_gst']);

			$this->db->where('gst_id', $data['gst_id']);
			return $result = $this->db->update('gst');
		}
	}	

	public function deleteGst($id = "")
	{
		$this->db->where('gst_id', $id);
		return $result=$this->db->delete('gst');
	}


}