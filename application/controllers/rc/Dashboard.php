<?php
defined('BASEPATH') OR exit('No direct script access allowed'); 

class Dashboard extends CI_Controller {
	
	public function __construct(){
		parent::__construct();
		$this->load->model('model_student');
		$this->load->model('model_branch');
		$this->load->model('model_periode');
	} 
	
	public function _remap($method, $param = array()){
		if(method_exists($this, $method)){
			$level = $this->session->userdata('level');
			if(!empty($level) && strpos($this->session->userdata('divisi'), 'MRLC') !== false){
				return call_user_func_array(array($this, $method), $param);
			}else{
				redirect(base_url('login'));				
			}
		}else{
			display_404();
		}
	}

	public function index(){
		$data['status'] 		= array("Active", "Need to upgrade", "Graduate soon", "Dropout", "Graduated");
		$data['regular'] 		= $this->api_index()['regular'];
		$data['adult'] 			= $this->api_index()['adult'];
		$data['branch'] 		= $this->api_index();

		$data['stat_regular'] 	= $this->api_index()['stat_regular'];
		$data['stat_adult'] 	= $this->api_index()['stat_adult'];
		$jsonstat = json_encode($data);
		$datas = json_decode($jsonstat, true );

		// dd($datas);
		// die();
		// dd($data['stat_regular']);
		set_active_menu('dashboard student');
		init_view('rc/dashboard_student', $datas);
	}

	public function api_index(){
		$data = array(

		);
		
		$url = api_url('rc/DashboardApi/api_get_index');

			$dashboard = optimus_curl('POST', $url, $data);
			if($dashboard != ""){
				$data['message'] = "Data didapatkan atas";
				$data['status'] = "200";
			}else{
				$data['status'] = "300";
			}	
		// 		dd($dashboard->stat_regular);
		// die();
		return (array)$dashboard;
	}

	// public function api_get_chart_status_student(){
	// 	$data = array(

	// 	);
		
	// 	$url = api_url('rc/DashboardApi/api_get_index');

	// 		$dashboard = optimus_curl('POST', $url, $data);
	// 		if($dashboard != ""){
	// 			$data['message'] = "Data didapatkan atas";
	// 			$data['status'] = "200";
	// 		}else{
	// 			$data['status'] = "300";
	// 		}	
	// 	dd($dashboard);
	// 	die();
	// 	return (array)$dashboard;
	// }

	
	
}