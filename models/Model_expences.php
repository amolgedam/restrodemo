<?php 

class Model_expences extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function createExpences($data = array())
	{
		if($data) {
			// print_r($data);exit();
			$this->db->set('created','NOW()', FALSE);
			$this->db->set('todate','NOW()', FALSE);
			$create = $this->db->insert('expences', $data);
			return ($create == true) ? true : false;
		}
	}

	public function countTodayExp($today='')
	{
		$query = $this->db->select('SUM(amount) as amt')
							->from('expences')
							->where('todate', $today)
							->get();
		return $query->row_array();
	}

	public function deleteExpences($id = '')
	{
		$this->db->where('id', $id);
		return $result=$this->db->delete('expences');
	}

	public function updateMyExpences($data = array())
	{
		$this->db->where('id', $data['id']);
		$update = $this->db->update('expences', $data);
		return ($update == true) ? true : false;
	}

	public function fecthDataByID($id='')
	{
		$query = $this->db->select('*')
							->from('expences')
							->where('id', $id)
							->get();
		return $query->row_array();
	}

	public function fecthDataByUserId($id='')
	{
		$query = $this->db->select('*')
							->from('expences')
							->where('users_id', $id)
							->get();
		return $query->row_array();
	}

	public function fecthDataByExpCatId($id='')
	{
		$query = $this->db->select('*')
							->from('expences')
							->where('expcat_id', $id)
							->get();
		return $query->row_array();
	}

	public function unpaidExp()
	{
		$query = $this->db->select('*')
							->from('expences')
							->where('pstatus !=', 'paid')
							->get();
		return $query->result_array();
	}
	
	public function fecthAllExpencesDataWithCat()
	{
	    $query = $this->db->select('expences.id, expences.name as ename, expences.date, expences.description, expences.amount, expences.users_id, expences.payment_method as pid, expences_category.name as cat_name')
							->from('expences')
							->join('expences_category', 'expences_category.id= expences.expcat_id', 'left')
							->get();
		return $query->result();
	}

	public function fecthAllExpencesData()
	{
		$query = $this->db->select('*')
							->from('expences')
							->get();
		return $query->result();
	}

	public function fecthExpencesDataDateWise($data = array())
	{
		$query = $this->db->select('*')
							->from('expences')
							->where(['date >=' => $data['from'], 'date <=' => $data['to'] ])
							->get();
		return $query->result();
	}

	public function fecthExpencesDataDateWise1($data = array())
	{
		$query = $this->db->select('*')
							->from('expences')
							->where(['date >=' => $data['from'], 'date <=' => $data['to'], 'expcat_id' => $data['expCat']])
							->get();
		return $query->result();
	}

	public function fecthExpencesDataDateWise2($data = array())
	{
		$query = $this->db->select('*')
							->from('expences')
							->where(['date >=' => $data['from'], 'date <=' => $data['to'], 'payment_method' => $data['payment_term']])
							->get();
		return $query->result();
	}

	public function fecthAllExpencesReportCatWise()
	{
		// $query = $this->db->select('SUM(amount) as amt, expences.*')
		$query = $this->db->select()
							->from('expences')
							// ->group_by('expcat_id')
							->get();
		return $query->result();	
	}

	public function fecthAllExpencesReportCatWise1($data=array())
	{
		// $query = $this->db->select('SUM(amount) as amt, expences.*')
		$query = $this->db->select()
							->from('expences')
							->where('date >=',$data['from'])
							->where('date <=',$data['to'])
							// ->group_by('expcat_id')
							->get();
		return $query->result();	
	}

	// public function fecthExpences()
	// {
	// 	$query = $this->db->select('expences.name as name, expences.date as date, expences.cheque_no, expences.amount, payment_method.name as payment_method')
	// 						->from('expences')
	// 						->join('payment_method', 'payment_method.id = expences.payment_method')
	// 						->get();
	// 	return $query->result();
	// }

	// public function fecthExpencesReport($data=array())
	// {
	// 	// print_r($data); //exit();
	// 	$query = $this->db->select('expences.name as name, expences.date as date, expences.cheque_no, expences.amount, payment_method.name as payment_method')
	// 						->from('expences')
	// 						->join('payment_method', 'payment_method.id = expences.payment_method')
	// 						->where('expences.date >=', $data['from'])
	// 						->where('expences.date <=', $data['to'])
	// 						->get();
	// 	return $query->result();
	// }

	// public function fecthExpencesWiseReport($data=array())
	// {
	// 	$query = $this->db->select('expences.name as name, expences.date as date, expences.cheque_no, expences.amount, payment_method.name as payment_method')
	// 						->from('expences')
	// 						->join('payment_method', 'payment_method.id = expences.payment_method')
	// 						->where('expences.date >=', $data['from'])
	// 						->where('expences.date <=', $data['to'])
	// 						->where('expences.id', $data['expences'])
	// 						->get();
	// 	return $query->result();
	// }

	

	// #########################################################
	// Expences Category
	// #########################################################

	public function fecthAllCategoryData()
	{
		$query = $this->db->select('*')
							->from('expences_category')
							->get();
		return $query->result();
	}
	
	public function fecthActiveCategoryData()
	{
		$query = $this->db->select('*')
							->from('expences_category')
							->where('status', 'active')
							->get();
		return $query->result();
	}

	public function fecthCategoryDataByID($id='')
	{
		$query = $this->db->select('*')
							->from('expences_category')
							->where('id', $id)
							->get();
		return $query->row_array();
	}

	public function createExpencesCategory($data = array())
	{
		if($data) {
			// print_r($data);exit();
			$this->db->set('created','NOW()', FALSE);
			$create = $this->db->insert('expences_category', $data);
			return ($create == true) ? true : false;
		}
	}

	public function updateExpencesCategory($data = array())
	{
		$this->db->where('id', $data['id']);
		$update = $this->db->update('expences_category', $data);
		return ($update == true) ? true : false;
	}

	public function deleteExpencesCategory($id = '')
	{
		$this->db->where('id', $id);
		return $result=$this->db->delete('expences_category');
	}
}