<?php 

class Model_waiter extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function fecthActiveWaiterData()
	{
		$query = $this->db->select()
							->from('waiter')
							->where('active', 1)
							->get();
		return $query->result();
	}

	public function fecthAllData()
	{
		$query = $this->db->select('*')
							->from('waiter')
							->get();
		return $query->result();
	}

	public function fecthAllDataById($id='')
	{
		$query = $this->db->select('*')
							->from('waiter')
							->where('id', $id)
							->get();
		return $query->row_array();
	}

	public function getDataByName($name='')
	{
		$query = $this->db->select('*')
							->from('waiter')
							->where('name', $name)
							->get();
		return $query->row_array();
	}

	public function create($data = array())
	{
		if($data) {

			$this->db->set('created','NOW()', FALSE);
			$create = $this->db->insert('waiter', $data);
			return ($create == true) ? true : false;
		}
	}

	public function update($data = array())
	{
		if($data) {
			$this->db->set('modified','NOW()', FALSE);

			$this->db->set('name', $data['name']);
			$this->db->set('mobile', $data['mobile']);
			$this->db->set('address', $data['address']);
			$this->db->set('active', $data['active']);

			$this->db->where('id', $data['id']);
			return $result = $this->db->update('waiter');
		}
	}

	public function updateAll($data = array())
	{
		if($data) {
			$this->db->set('modified','NOW()', FALSE);
			$this->db->where('id', $data['id']);
			return $result = $this->db->update('waiter', $data);
		}
	}

	public function deleteWaiter($id = "")
	{
		$this->db->where('id', $id);
		return $result=$this->db->delete('waiter');
	}

	public function statusWaiter($data = array())
	{
		if($data) {
			$this->db->set('modified','NOW()', FALSE);

			$this->db->set('active', $data['active']);

			$this->db->where('id', $data['id']);
			return $result = $this->db->update('waiter');
		}
	}

	public function waiterReportData($from='', $to='',$water='')
	{
		
		$wh="select * from orders where created between '$from' and '$to' and waiter=".$water."";
		$query = $this->db->query($wh);
							
							
		//$result= $this->db->get();
							
				
							
		return $query->result();
	}
}