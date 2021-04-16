<?php
defined('BASEPATH') OR exit('No direct script access allowed'); 

class Task extends CI_Controller {
	
	public function __construct(){
		parent::__construct();
		$this->load->model('model_task');
		$this->load->model('model_login');
	} 
	
	public function _remap($method, $param = array()){
		if(method_exists($this, $method)){
			$level = $this->session->userdata('level');
			if(!empty($level) && $level == 'support' || $this->session->userdata('id') == '28' ||  $this->session->userdata('id') == '43' || $this->session->userdata('id') == '44' || $this->session->userdata('id') == '64' || $this->session->userdata('id') == '76' || $this->session->userdata('id') == '82' || $this->session->userdata('id') == '63' || $this->session->userdata('id') == '88' || $this->session->userdata('id') == '190' || $this->session->userdata('id') == '72' || $this->session->userdata('id') == '169' || $this->session->userdata('id') == '133'){
				return call_user_func_array(array($this, $method), $param);
			}else{
				redirect(base_url('login'));				
			}
		}else{
			display_404();
		}
	}

	public function api_index(){
		$url = api_url('support/Taskapi/api_index');
		$data = array(
			'id' => $this->session->userdata('id'),
			'iddivisi' => $this->session->userdata('iddivisi'),
		);
			$task = optimus_curl('POST', $url, $data);
			if($task != ""){
				$data['message'] = "Data didapatkan atas";
				$data['status'] = "200";
			}else{
				$data['status'] = "300";
			}
		return (array)$task;
	}

	public function index(){
		$data['results'] = $this->api_index()['results'];
		$data['divisi'] = $this->api_index()['divisi'];
		// $jsonstat = json_encode($data);
		// $datas = json_decode($jsonstat, true );

		// dd($data);
		// die();
		set_active_menu('Future Task Support');
		init_view('support/content_get_task', $data);
	}

	public function api_index_all(){
		$url = api_url('support/Taskapi/all');
		$data = array(
			'id' => $this->session->userdata('id'),
			'iddivisi' => $this->session->userdata('iddivisi'),
		);
			$task = optimus_curl('POST', $url, $data);
			if($task != ""){
				$data['message'] = "Data didapatkan atas";
				$data['status'] = "200";
			}else{
				$data['status'] = "300";
			}
		return (array)$task;
	}

	public function all(){
		$data['results'] = $this->api_index_all()['results'];
		
		set_active_menu('Last Task Support');
		init_view('support/content_get_alltask', $data);
		// $this->load->view('content_get_alltask.php',$data);
	}

	public function add(){
		set_active_menu('Add Task');
		init_view('support/content_add_task');
	}

	public function addtaskwarrior_api($id){
		$url = api_url('support/Taskapi/addtaskwarrior/'.$id);
		$data = array(
			'id' => $this->session->userdata('id'),
			'iddivisi' => $this->session->userdata('iddivisi'),
		);
			$task = optimus_curl('POST', $url, $data);
			if($task != ""){
				$data['message'] = "Data didapatkan atas";
				$data['status'] = "200";
			}else{
				$data['status'] = "300";
			}
		return (array)$task;
	}

	public function hasil_api(){
		$url = api_url('support/Taskapi/addtaskwarriors');
		$data = array(
			'id' => $this->session->userdata('id'),
			'is_hr_division' => $this->session->userdata('is_hr_division'),
		);
			$task = optimus_curl('POST', $url, $data);
			if($task != ""){
				$data['message'] = "Data didapatkan atas";
				$data['status'] = "200";
			}else{
				$data['status'] = "300";
			}
		return (array)$task;
	}

	public function addtaskwarrior($id){
		$data['results'] 	= $this->addtaskwarrior_api($id)['results'];
		$data['hasil'] 		= $this->hasil_api()['hasil'];
		
		set_active_menu('Add Task Warrior');
		init_view('support/content_add_war_event', $data);
	}

	public function tambah_war_task_api(){
		$url = api_url('support/Taskapi/tambah_war_task');
		$data = array(
			'id' => $this->input->post('id'),
			'getname' => $this->input->post('getname'),
		);
			$task = optimus_curl('POST', $url, $data);
			if($task != ""){
				$data['message'] = "Data didapatkan atas";
				$data['status'] = "200";
			}else{
				$data['status'] = "300";
			}
		return (array)$task;
	}

	public function tambah_war_task(){
		$results = $this->tambah_war_task_api();
		if($results){
			flashdata('success','Warriors berhasil dimasukan kedalam Event');
		}else{
			flashdata('error','Gagal menambahkan warriors kedalam Event');
		}
		redirect(base_url('support/task/'));
	}

	public function pay_war_task_api(){
		$url = api_url('support/Taskapi/pay_war_task');
		$data = array(
			'id' => $this->input->post('id'),
			'getname' => $this->input->post('getname'),
		);
			$task = optimus_curl('POST', $url, $data);
			if($task != ""){
				$data['message'] = "Data didapatkan atas";
				$data['status'] = "200";
			}else{
				$data['status'] = "300";
			}
		return (array)$task;
	}

	public function pay_war_task(){
		$results = $this->tambah_war_task_api();
		if($results){
			flashdata('success','Warriors berhasil dimasukan kedalam Event');
		}else{
			flashdata('error','Gagal menambahkan warriors kedalam Event');
		}
		redirect(base_url('support/task/'));
	}

	public function submit_api(){
		$url = api_url('support/Taskapi/submit');
		$data = array(
			'id' => $this->input->post('id'),
			'nama' => $this->input->post('nama'),
			'location' => $this->input->post('location'),
			'lokasi' => $this->input->post('lokasi'),
			'tgl' => $this->input->post('tgl'),
			'komisilunas' => $this->input->post('komisilunas'),
			'komisidp' => $this->input->post('komisidp'),
			'id_divisi' => $this->input->post('id_divisi'),
			'iddivisi' => $this->session->userdata('iddivisi'),
			'username' => $this->session->userdata('username'),
		);
			$task = optimus_curl('POST', $url, $data);
			if($task != ""){
				$data['message'] = "Data didapatkan atas";
				$data['status'] = "200";
			}else{
				$data['status'] = "300";
			}

			echo json_encode($data);
			// die();
	}

	public function submit(){
		$id =  $this->input->post('id');
		if(empty($id)){
			# insert statement
			$results = $this->submit_api();

			if($results !== ""){
				flashdata('success','Event ditambahkan di List');
			}else{
				flashdata('error','Gagal menambahkan data');
			}
		}else{
			# update statement
			$results = $this->submit_api();
			if($results !== ""){
				flashdata('success','Berhasil mengubah data');
			}else{
				flashdata('error','Gagal mengubah data');
			}
		}
		redirect(base_url('support/task/'));
	}

	public function delete_api(){
		$url = api_url('support/Taskapi/delete');
		$data = array(
			'id' => $this->input->post('id'),
		);
			$task = optimus_curl('POST', $url, $data);
			if($task != ""){
				$data['message'] = "Data didapatkan atas";
				$data['status'] = "200";
			}else{
				$data['status'] = "300";
			}
		return (array)$task;
	}

	public function delete(){
		$results 	= $this->delete_api();

		if($results){
			$this->session->set_flashdata('success','Berhasil menghapus data.');
		}else{
			$this->session->set_flashdata('error','Gagal menghapus data.');
		}
		echo json_encode($results);
	}
	
	public function delete_wartask_api(){
		$url = api_url('support/Taskapi/delete_wartask');
		$data = array(
			'id_task' => $this->input->post('id_task'),
			'id_user' => $this->input->post('id_user'),
		);
			$task = optimus_curl('POST', $url, $data);
			if($task != ""){
				$data['message'] = "Data didapatkan atas";
				$data['status'] = "200";
			}else{
				$data['status'] = "300";
			}
		return (array)$task;
	}

	public function delete_wartask(){
		$id_task = $this->input->post('id_task');
		$response = $this->delete_wartask_api();
		if($response){
			flashdata('success','Warriors berhasil dihapus dari event');
		}else{
			flashdata('error','Gagal mengubah data');
		}
		flashdata('modal_active', $id_task);
		echo json_encode($response);			
	}

	public function submit_pd_api(){
		$url = api_url('support/Taskapi/submit_pd');
		$data = array(
			'id' => $this->input->post('id'),
			'getpd' => $this->input->post('getpd'),
		);
			$task = optimus_curl('POST', $url, $data);
			if($task != ""){
				$data['message'] = "Data didapatkan atas";
				$data['status'] = "200";
			}else{
				$data['status'] = "300";
			}
		return (array)$task;
	}


	public function submit_pd(){
		$results 	= $this->submit_pd_api();
		
		if($results){
			flashdata('success','PD berhasil ditentukan.');
		}else{
			flashdata('error','Gagal mengubah data');
		}
		redirect(base_url('support/task'));		
	}

	public function report($idevent){
		$data['results'] = $this->model_task->getusername_event($idevent);

		$i = 0;
		foreach ($data['results'] as $r){

			if($r->persetujuan_pengganti == 'ya'){
				$id = $r->id_pengganti;
				$idp = $r->id_user;
			}else{
				$id = $r->id_user;
				$idp = null;
			}

			$data['usr'] = $this->model_task->getusername_event_get($id);

			if($idp <> null){
				$data['usr_p'] = $this->model_task->getusername_event_get($idp);

				foreach($data['usr_p'] as $rn){
					$sblm_diganti = '<span style="color:red;">'.$rn->username.'</span> <i class="fa fa-caret-right" aria-hidden="true"></i> ';
				}
			}else{
				$sblm_diganti = "";
			}

			foreach($data['usr'] as $rn){
				$hasil[$i][0] = $sblm_diganti.' '.$rn->username;
			}
			$hasil[$i][1] = $r->tugas;
			$hasil[$i][2] = $r->dp;
			$hasil[$i][3] = $r->modul;
			$hasil[$i][4] = $r->lunas;
			$hasil[$i][5] = $id;
			$hasil[$i][6] = $r->hadir;

			$data['event'] = $this->model_task->getidtask_get($idevent);
			foreach($data['event'] as $re){
				$hasil[0][7] = $re->jenis_report;

				if($hasil[0][7]=='peserta'){
					$hasil[0][8] = $re->daftar;
					$hasil[0][9] = $re->ots;
					$hasil[0][10] = $re->hadir;
					$hasil[0][11] = $re->tidak_hadir;						
				}elseif($hasil[0][7]=='keluarga'){

					$explode_daftar = $re->daftar;

					if(strlen($explode_daftar) > 0){
						$daftar_pecah = explode(",", $explode_daftar);

						$hasil[1][8] = $daftar_pecah[0];
						$hasil[2][8] = $daftar_pecah[1];

						$explode_ots = $re->ots;
						$ots_pecah = explode(",", $explode_ots);

						$hasil[1][9] = $ots_pecah[0];
						$hasil[2][9] = $ots_pecah[1];

						$explode_hadir = $re->hadir;
						$hadir_pecah = explode(",", $explode_hadir);

						$hasil[1][10] = $hadir_pecah[0];
						$hasil[2][10] = $hadir_pecah[1];

						$explode_tidak_hadir = $re->tidak_hadir;
						$tidak_hadir_pecah = explode(",", $explode_tidak_hadir);

						$hasil[1][11] = $tidak_hadir_pecah[0];
						$hasil[2][11] = $tidak_hadir_pecah[1];

					}
				}
				$data['hasil']= $hasil;
			}
			$i = $i + 1;
		}
		$data['jmh'] 	= $i;
		$data['idtask']	= $idevent;
		$data['tgl'] 	= $data['event'][0]->date;
		$data['event'] 	= $data['event'][0]->event;
		$data['nm'] 	= $this->model_task->user_add_task_paytask();
		set_active_menu('Report Task');
		init_view('support/content_review_report', $data);
	}

	public function overview(){
		$data['name'] = $this->model_task->getusername_report_task();
		$baris	= 0;
		$i 		= 0;
		foreach($data['name'] as $r){
			$hasil[$i][0] = $r->username;
			$data['jmh_event_no_pay'] 	= $this->model_task->get_event_all_notpay($r->id);
			$hasil[$i][1] 				= $data['jmh_event_no_pay'];
			
			$data['jmh_event_pay'] 		= $this->model_task->get_event_all_pay($r->id);
			$hasil[$i][2] 				= $data['jmh_event_pay'];
			
			$data['jmh_event_hutang'] 	= $this->model_task->get_event_all_hutang($r->id);
			$hasil[$i][3] 				= $data['jmh_event_hutang'];
			
			$baris = $baris + 1;
			$i = $i + 1;
		}
		
		$data['hasil'] = $hasil;
		$data['baris'] = $baris;
		set_active_menu('Overview Task');
		init_view('support/content_overviewtask', $data);
	}

	public function list_incentive_api(){
		$url = api_url('support/Taskapi/list_incentive');
		
			$task = optimus_curl('GET', $url, $data="");
			if($task != ""){
				$data['message'] = "Data didapatkan atas";
				$data['status'] = "200";
			}else{
				$data['status'] = "300";
			}
		echo json_encode($task);
	}

	public function list_incentive(){
		$data['results'] = $this->list_incentive_api()['results'];
		set_active_menu('List Incentive');
		init_view('support/content_list_incentive_sp', $data);
	}

	public function add_newevent(){
		$name 	= $this->input->post('name');
		$dp 	= $this->input->post('dp');
		$lunas 	= $this->input->post('lunas');
		$result = $this->model_task->add_newevent_incen($name, $dp, $lunas);

		if($result){
			flashdata('success','Incentive Event berhasil ditambahkan');
		}else{
			flashdata('error','Gagal menambah data');
		}
		redirect(base_url('support/task/list_incentive'));
	}

	public function delete_event_incent(){
		$id 	= $this->input->post('id');
		$result = $this->model_task->delete_event_incent($id);

		if($result){
			flashdata('success','Data berhasil dihapus.');
		}else{
			flashdata('error','Gagal mengubah data.');
		}
		echo json_encode($result);            
	}

	public function json_get_data_event(){
		$url = api_url('support/Taskapi/json_get_data_event');
		$data = array(
			'id' => $this->input->post('id'),
		);
			$task = optimus_curl('POST', $url, $data);
			if($task != ""){
				$data['message'] = "Data didapatkan atas";
				$data['status'] = "200";
			}else{
				$data['status'] = "300";
			}
		echo json_encode($task);
	}

	public function json_get_data_task_api(){
		$url = api_url('support/Taskapi/json_get_data_task');
		$data = array(
			'id' => $this->input->post('id'),
		);
			$task = optimus_curl('POST', $url, $data);
			if($task != ""){
				$data['message'] = "Data didapatkan atas";
				$data['status'] = "200";
			}else{
				$data['status'] = "300";
			}
		echo json_encode($task);
	}

	public function json_get_data_task(){
		$response['event'] 	= $this->json_get_data_task_api()[0];
		$response['list']	= $this->json_get_data_task_api();
		echo json_encode($response);
	}

	
	
}
