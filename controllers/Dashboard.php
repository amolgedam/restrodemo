<?php 

class Dashboard extends Admin_Controller 
{
	public function __construct()
	{
		parent::__construct();

		$this->not_logged_in();

		$this->data['page_title'] = 'ZEON ERP';
		
		$this->load->model('model_products');
		$this->load->model('model_orders');
		$this->load->model('model_users');
		$this->load->model('model_stores');
		$this->load->model('model_tables');
		$this->load->model('model_parcel');
		$this->load->model('model_company');
		$this->load->model('model_expences');
	}

	public function index()
	{
		$date = date('Y-m-d');
		
		$this->data['daily_salevolum'] = $this->model_orders->countSalesVolume($date);
		$this->data['dive_in'] = $this->model_orders->countTodayOrder($date, 'ordertype', 'tb');
		$this->data['take_away'] = $this->model_orders->countTodayOrder($date, 'ordertype', 'pb');
		$this->data['today_sales'] = $this->model_orders->countTodaySalesAmt($date);
		$this->data['today_salesamt_tb'] = $this->model_orders->countTodaySalesAmt1($date, 'ordertype', 'tb');
		$this->data['today_salesamt_pb'] = $this->model_orders->countTodaySalesAmt1($date, 'ordertype', 'pb');
		$this->data['today_exp'] = $this->model_expences->countTodayExp($date);
		$this->data['total_products'] = $this->model_products->countTotalProducts();
		



		$this->data['daily_productsales'] = $this->model_orders->countProductSales($date);
		$this->data['daily_exp'] = $this->model_expences->countTodayExp($date);
		$this->data['daily_parcel'] = $this->model_orders->countTodayParcel($date);
		$this->data['table_open'] = $this->model_tables->countTableopen();
		$this->data['table_close'] = $this->model_tables->countTableclose();



		$this->data['total_products'] = $this->model_products->countTotalProducts();
		$this->data['total_paid_orders'] = $this->model_orders->countTotalPaidOrders();
		$this->data['total_users'] = $this->model_users->countTotalUsers();
		$this->data['total_stores'] = $this->model_stores->countTotalStores();

		$this->data['tablesData'] = $this->model_tables->fecthAllTables();
		$this->data['parcelData'] = $this->model_parcel->fecthAllTables();
		// print_r(date('Y-m-d')); exit();

		$this->data['unpaid_exp'] = $this->model_expences->unpaidExp();


		$toDay = strtotime(date('Y-m-d'));
		
		$beforeOneMonth = strtotime(date('Y-m-d', strtotime("-1 month")));//exit();

		$this->data['TotalDailyBussiness'] = $this->model_orders->countDailyBussiness($toDay);

		$this->data['TotalMonthlyBussiness'] = $this->model_orders->TotalMonthlyBussiness($toDay, $beforeOneMonth);

		$user_id = $this->session->userdata('id');
		$is_admin = ($user_id == 1) ? true :false;

		$this->data['is_admin'] = $is_admin;
		$this->render_template('dashboard', $this->data);
	}
}