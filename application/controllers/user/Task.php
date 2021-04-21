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
			if(!empty($level)){
				return call_user_func_array(array($this, $method), $param);
			}else{
				redirect(base_url('login'));				
			}
		}else{
			display_404();
		}
	}

	public function index_api(){
		$url = api_url('user/Taskapi/index');
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
		// dd($task);
		// die();
		return (array)$task;
	}

	public function index(){
		$data['results'] 	= $this->index_api()['results'];
		$data['hasil'] 		= $this->index_api()['hasil'];
		$data['minus'] 		= $this->index_api()['minus'];
		$data['plus'] 		= $this->index_api()['plus'];
		$minus = 0;
		if($data['minus']){
			foreach($data['minus'] as $m){
				$minus = $minus + 1;
			}
		}
		
		$minus = $minus * 2;
		
		$plus = 0;
		if($data['plus']){
			foreach($data['plus'] as $p){
				$plus = $plus + 1;
			}
		}
		
		$hasil = $plus - $minus;
		
		$data['sp'] = $hasil;
		// dd($data);
		// die();
		set_active_menu('My Task');
		init_view('user/content_mytask', $data);
	}

	public function request_api(){
		$url = api_url('user/Taskapi/request');
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
		// dd($task);
		// die();
		return (array)$task;
	}

	public function request(){
		$data['results'] 	= $this->request_api()['results'];
		$data['hasil'] 		= $this->request_api()['hasil'];
		set_active_menu('Request Task');
		init_view('user/content_permohonan_task', $data);
	}

	public function submission_api(){
		$url = api_url('user/Taskapi/submission');
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
		// dd($task);
		// die();
		return (array)$task;
	}

	public function submission(){
		$data['results'] 	= $this->submission_api()['results'];
		$data['hasil'] 		= $this->submission_api()['hasil'];
		set_active_menu('Submission Task');
		init_view('user/content_pengajuan_task', $data);
	}

	public function all_api(){
		$url = api_url('user/Taskapi/all');
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
		// dd($task);
		// die();
		return (array)$task;
	}

	public function all(){
		$data['results'] 	= $this->all_api()['results'];
		$data['hasil'] 		= $this->all_api()['hasil'];
		set_active_menu('All Task');
		init_view('user/content_all_task', $data);
	}

	public function batalkan_pertukaran_api(){
		$url = api_url('user/Taskapi/batalkan_pertukaran');
		$data = array(
			'idevent' => $this->input->post('idevent')
		);
			$task = optimus_curl('POST', $url, $data);
			if($task != ""){
				$data['message'] = "Data didapatkan atas";
				$data['status'] = "200";
			}else{
				$data['status'] = "300";
			}
		// dd($task);
		// die();
		return (array)$task;
	}

	public function batalkan_pertukaran($idevent, $token){
		if($token == md5($idevent)){
			$results = $this->batalkan_pertukaran_api();
			
			if($results){
				flashdata('success','Berhasil dibatalkan');
			}else{

				flashdata('error','Pertukaran gagal dibatalkan');
			}
		}else{
			flashdata('error','Pertukaran gagal dibatalkan');
		}
		redirect(base_url('user/task'));
	}

	public function event_digantikan_api(){
		$url = api_url('user/Taskapi/event_digantikan');
		$data = array(
			'idevent' => $this->input->post('idevent'),
			'getname' => $this->input->post('getname'),
		);
			$task = optimus_curl('POST', $url, $data);
			if($task != ""){
				$data['message'] = "Data didapatkan atas";
				$data['status'] = "200";
			}else{
				$data['status'] = "300";
			}
		// dd($task);
		// die();
		return (array)$task;
	}

	public function event_digantikan_request_api(){
		$url = api_url('user/Taskapi/event_digantikan_request');
		$data = array(
			'idevent' => $this->input->post('idevent'),
			'getname' => $this->input->post('getname'),
		);
			$task = optimus_curl('POST', $url, $data);
			if($task != ""){
				$data['message'] = "Data didapatkan atas";
				$data['status'] = "200";
			}else{
				$data['status'] = "300";
			}
		// dd($task);
		// die();
		return (array)$task;
	}

	public function event_digantikan(){
		$results = $this->event_digantikan_api();
		
		if($results !== ""){
			$results1 = $this->event_digantikan_request_api();
			if($results1 !== ""){
				flashdata('success','Event telah berhasil di request');
			}else{
				flashdata('error','Request gagal diproses, user sudah terdapat di Event Ini.');
			}
		}else{
			flashdata('error','Maaf, User sudah menggantikan orang lain / di Request orang lain.'); 
		}
		redirect(base_url('user/task'));
	}

	public function approve_request_api($idtask, $idpengganti){
		$url = api_url('user/Taskapi/approve_request/'.$idtask.'/'.$idpengganti);
	
			$task = optimus_curl('GET', $url, $data = "");
			if($task != ""){
				$data['message'] = "Data didapatkan atas";
				$data['status'] = "200";
			}else{
				$data['status'] = "300";
			}
		// dd($task);
		// die();
		return (array)$task;
	}

	public function approve_request($idpengganti, $idtask){
		$results = $this->approve_request_api($idtask, $idpengganti);
		
		if($results){
			flashdata('success','List Event telah ditambahkan kedalam List');
		}else{
			flashdata('error','List Event gagal ditambahkan kedalam List');
		}

		redirect(base_url('user/task/request'));
	}

	public function reject_konfirmasi_pertukaran_api($idevent){
		$url = api_url('user/Taskapi/reject_konfirmasi_pertukaran/'.$idevent);
	
			$task = optimus_curl('POST', $url, $data = "");
			if($task != ""){
				$data['message'] = "Data didapatkan atas";
				$data['status'] = "200";
			}else{
				$data['status'] = "300";
			}
		// dd($task);
		// die();
		return (array)$task;
	}

	public function reject_konfirmasi_pertukaran($idevent, $token){
		if($token == md5($idevent)){
			$results = $this->reject_konfirmasi_pertukaran_api($idevent);
			
			if($results){
				flashdata('success','Sukses mengubah data');
			}else{
				flashdata('error','Gagal mengubah data');
			}
		}else{
			flashdata('error','Gagal mengubah data');
		}
		redirect(base_url('user/task/request'));	
	}

	public function report_pd($idevent, $token){
		if(md5($idevent) == $token){
			$data['results'] = $this->model_task->getusername_event($idevent);
			$i = 0;
			foreach ($data['results'] as $r){
				
				if($r->persetujuan_pengganti == 'ya'){
					$id = $r->id_pengganti;
				}else{
					$id = $r->id_user;
				}
				
				$data['usr'] = $this->model_task->getusername_event_get($id);
				
				foreach($data['usr'] as $rn){
					$hasil[$i][0] = $rn->username;
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
				}

				
				$i = $i + 1;
			}
			
			$data['jmh'] 		= $i;
			$data['hasil']		= $hasil;
			$data['idtask']		= $idevent;
			$data['tgl'] 		= $data['event'][0]->date;
			$data['event'] 		= $data['event'][0]->event;
			$data['idevent'] 	= $idevent;
			$data['nm'] 		= $this->model_task->user_add_task_paytask();
			set_active_menu('My Task');
			init_view('user/content_report_pd',$data);
		}else{
			redirect(base_url('user/task'));
		}
	}

	public function paytask_adding(){
		$idevent 	= $this->input->post('idevent');
		$username 	= $this->input->post('username');
		$eventname 	= $this->input->post('eventname');
		$date 		= $this->input->post('tgl');
		
		$results = $this->model_task->user_add_task_paytask_adding($idevent, $username);
		
		if($results){
			flashdata('success','Warriors ditambahkan kedalam list');
		}else{
			flashdata('error','Warriors sudah terdapat dievent ini');
		}
		redirect(base_url('user/task/report_pd/'.$idevent.'/'.md5($idevent)));
	}

	public function update_report_pd(){
		$idevent = $this->input->post('idtask');
		$jmhuser = $this->input->post('jmhuser') ;
		
		for($i=0; $jmhuser > $i; $i++){
			$iduser = $this->input->post('userid'.$i);
			$tugas = $this->input->post('tugas'.$i);
			$dp = $this->input->post('dp'.$i);
			
			//Modul dihilangkan karena info sri tdk dibutuhkan dan sudah dijadikan satu dengan dp
			$modul = '';
			$lunas = $this->input->post('lunas'.$i);
			
			if(isset($_POST['hadir'.$i])){
				$hadir = 'ya';
			}else{
				$hadir = 'tidak';
			}
			
			
			$results = $this->model_task->update_report_pd($idevent, $iduser, $tugas, $dp, $modul, $lunas, $hadir);
		}
		
		if($this->input->post('jns_report') == 'peserta'){
			$daftar = $this->input->post('daftar');
			$ots = $this->input->post('ots');
			$hadir = $this->input->post('hadir');
			$tidak_hadir = $this->input->post('tidak_hadir');
		}else{
			$daftar = $this->input->post('daftark').','.$this->input->post('daftara');
			$ots = $this->input->post('otsk').','.$this->input->post('otsa');
			$hadir = $this->input->post('hadirk').','.$this->input->post('hadira');
			$tidak_hadir = $this->input->post('tidak_hadirk').','.$this->input->post('tidak_hadira');
		}
		
		$results = $this->model_task->update_report_pd_task($idevent,$daftar,$ots,$hadir,$tidak_hadir);
		
		if($results){
			flashdata('success', 'Berhasil menyimpan data');
		}else{
			flashdata('error', 'Gagal mengubah data');
		}
		redirect(base_url('user/task/'));
	}
	
	public function sesi_perkenalan()
	{
		$data['results'] = $this->model_task->get_sp();
		set_active_menu('Event');
		init_view('user/content_list_sesi_perkenalan', $data);
	}
	
	public function json_get_sp_detail()
	{
		$id 		= $this->input->post('id');
		$response 	= $this->model_task->get_sp_detail($id);
		echo json_encode($response);
	}
	
	public function submit_form_sp()
	{
		$post = $this->input->post();
        $location = $post['location'];
		$lokasi = $post['lokasi'];
		if($lokasi == 'others'){
    		$data_insert = array(
    			'id_user'	=> $this->session->userdata('id'),
    			'id_divisi'  => $this->session->userdata('iddivisi'),
    			'event' => $post['event'],
    			'date_event' => $post['date_event'],
    			'location' => $location,
    			'is_confirm' => $post['is_confirm'],
    			'date_created' => date('Y-m-d')
    		);
    
    		$data_update = array(
    			'id_user'	=> $this->session->userdata('id'),
    			'id_divisi'  => $this->session->userdata('iddivisi'),
    			'event' => $post['event'],
    			'date_event' => $post['date_event'],
    			'location' => $location,
    			'is_confirm' => $post['is_confirm'],
    		);
		}else{
		    $data_insert = array(
    			'id_user'	=> $this->session->userdata('id'),
    			'id_divisi'  => $this->session->userdata('iddivisi'),
    			'event' => $post['event'],
    			'date_event' => $post['date_event'],
    			'location' => $lokasi,
    			'is_confirm' => $post['is_confirm'],
    			'date_created' => date('Y-m-d')
    		);
    
    		$data_update = array(
    			'id_user'	=> $this->session->userdata('id'),
    			'id_divisi'  => $this->session->userdata('iddivisi'),
    			'event' => $post['event'],
    			'date_event' => $post['date_event'],
    			'location' => $lokasi,
    			'is_confirm' => $post['is_confirm'],
    		);
		}

		if (!empty($post['id'])) {
			# update statement
			$id = $post['id'];
			unset($post['id']);
			$result = $this->model_task->update_sp($data_update, $id);
			if ($result) {
				flashdata('success', 'Berhasil mengubah data');
			} else {
				flashdata('error', 'Gagal mengubah data');
			}
		} else {
			# insert statement
			$result = $this->model_task->insert_sp($data_insert);

			if ($result) {
				flashdata('success', 'Berhasil menambahkan data');
			} else {
				flashdata('error', 'Gagal menambahkan data');
			}
		}
		redirect(base_url('user/task/sesi_perkenalan'));
	}
	
	public function delete_sp()
	{
		$id 		= $this->input->post('id');
		$results 	= $this->model_task->hapus_data_sp($id);

		if ($results) {
			flashdata('success', 'Segala data tersebut sudah terhapus dari sistem');
		} else {
			flashdata('error', 'Gagal menghapus data.');
		}
		echo json_encode($results);
	}

	
}
