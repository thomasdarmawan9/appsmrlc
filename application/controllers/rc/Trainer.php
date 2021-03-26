<?php
defined('BASEPATH') OR exit('No direct script access allowed'); 

class Trainer extends CI_Controller {
	
	public function __construct(){
		parent::__construct();
		$this->load->model('model_trainer');
		$this->load->model('model_periode');
		$this->load->model('model_branch');
		$this->load->model('model_classroom');
	}
	
	public function _remap($method, $param = array()){
		if(method_exists($this, $method)){
			$level = $this->session->userdata('level');
			if(!empty($level) && (strpos($this->session->userdata('divisi'), 'MRLC') !== false) || ($this->session->userdata('id') == '32') || ($this->session->userdata('id') == '190') || ($this->session->userdata('id') == '72')){
				return call_user_func_array(array($this, $method), $param);
			}else{
				redirect(base_url('login'));				
			}
		}else{
			display_404();
		}
	}

	public function index(){
		$data['periode'] 		= $this->api_index()['periode'];
		$data['periode_adult'] 	= $this->api_index()['periode_adult'];
		$jsonstat = json_encode($data);
		$datas = json_decode($jsonstat, true );
		set_active_menu('trainer');
		init_view('rc/trainer_periode', $datas);
	}

	public function api_index(){
		$url = api_url('rc/Trainerapi/api_get_index');

			$trainer = optimus_curl('GET', $url, $data = "");
			if($trainer != ""){
				$data['message'] = "Data didapatkan atas";
				$data['status'] = "200";
			}else{
				$data['status'] = "300";
			}	
		// dd($url);
		// die();
		return (array)$trainer;
	}

	public function periode($periode){
		$data['periode'] 	= $this->api_get_periode($periode)['periode'] ;
		$data['branch'] 	= $this->api_get_branch()['branch'] ;
		$jsonstat = json_encode($data);
		$datas = json_decode($jsonstat, true );
		set_active_menu('trainer');
		init_view('rc/trainer_branch', $datas);
	}

	public function api_get_periode($periode){
		$url = api_url('rc/Trainerapi/api_get_periode/'.$periode);

			$get_periode = optimus_curl('GET', $url, $data = "");
			if($get_periode != ""){
				$data['message'] = "Data didapatkan atas";
				$data['status'] = "200";
			}else{
				$data['status'] = "300";
			}	
		// dd($url);
		// die();
		return (array)$get_periode;
	}

	public function api_get_branch(){
		$url = api_url('rc/Trainerapi/api_get_branch');

			$get_branch = optimus_curl('GET', $url, $data = "");
			if($get_branch != ""){
				$data['message'] = "Data didapatkan atas";
				$data['status'] = "200";
			}else{
				$data['status'] = "300";
			}	
		// dd($url);
		// die();
		return (array)$get_branch;
	}

	public function periode_adult($periode){
		$data['periode'] 	= $this->api_get_periode($periode)['periode'] ;
		$data['branch'] 	= $this->api_get_branch()['branch'] ;
		$jsonstat = json_encode($data);
		$datas = json_decode($jsonstat, true );
		set_active_menu('trainer');
		init_view('rc/trainer_branch_adult', $datas);
	}

	public function branch($periode, $branch){
		$data['periode'] 	= $this->api_get_periode($periode)['periode'] ;
		$data['branch'] 	= $this->api_get_branch_param($branch)['branch'] ;
		$data['program'] 	= $this->api_get_program_and_class()['program'];
		$data['class'] 		= $this->api_get_program_and_class()['class'];
		$data['trainer'] 	= $this->api_get_trainer_param($branch)['trainer'] ;
		$data['list'] 		= $this->api_get_list_param($periode, $branch)['list'] ;
		$jsonstat = json_encode($data);
		$datas = json_decode($jsonstat, true );
		// dd($data);
		set_active_menu('trainer');
		init_view('rc/trainer_program', $datas);
	}
	
	public function branch_adult($periode, $branch){
		$data['periode'] 	= $this->api_get_periode($periode)['periode'] ;
		$data['branch'] 	= $this->api_get_branch_param($branch)['branch'];
		$data['program'] 	= $this->api_get_program_and_class_adult()['program'];
		$data['class'] 		= $this->api_get_program_and_class_adult()['class'];
		$data['trainer'] 	= $this->api_get_trainer_param($branch)['trainer'] ;
		$data['list'] 		= $this->api_get_list_param($periode, $branch)['list'] ;
		$jsonstat = json_encode($data);
		$datas = json_decode($jsonstat, true );
		// dd($data);
		set_active_menu('trainer');
		init_view('rc/trainer_program_adult', $datas);
	}

	public function api_get_trainer_param($branch){
		$url = api_url('rc/Trainerapi/api_get_trainer_param/'. $branch);

			$get_trainer = optimus_curl('GET', $url, $data = "");
			if($get_trainer != ""){
				$data['message'] = "Data didapatkan atas";
				$data['status'] = "200";
			}else{
				$data['status'] = "300";
			}	
		// dd($url);
		// die();
		return (array)$get_trainer;
	}

	public function api_get_list_param($periode, $branch){
		$url = api_url('rc/Trainerapi/api_get_list_param/'. $periode .'/'. $branch);

			$get_list = optimus_curl('GET', $url, $data = "");
			if($get_list != ""){
				$data['message'] = "Data didapatkan atas";
				$data['status'] = "200";
			}else{
				$data['status'] = "300";
			}	
		// dd($url);
		// die();
		return (array)$get_list;
	}

	public function api_get_branch_param($branch){
		$url = api_url('rc/Trainerapi/api_get_branch_param/'. $branch);

			$get_branch = optimus_curl('GET', $url, $data = "");
			if($get_branch != ""){
				$data['message'] = "Data didapatkan atas";
				$data['status'] = "200";
			}else{
				$data['status'] = "300";
			}	
		// dd($url);
		// die();
		return (array)$get_branch;
	}

	public function api_get_program_and_class(){
		$url = api_url('rc/Trainerapi/api_get_program');

			$get_program_class = optimus_curl('GET', $url, $data = "");
			if($get_program_class != ""){
				$data['message'] = "Data didapatkan atas";
				$data['status'] = "200";
			}else{
				$data['status'] = "300";
			}	
		// dd($url);
		// die();
		return (array)$get_program_class;
	}

	public function api_get_program_and_class_adult(){
		$url = api_url('rc/Trainerapi/api_get_program_adult');

			$get_program_class = optimus_curl('GET', $url, $data = "");
			if($get_program_class != ""){
				$data['message'] = "Data didapatkan atas";
				$data['status'] = "200";
			}else{
				$data['status'] = "300";
			}	
		// dd($url);
		// die();
		return (array)$get_program_class;
	}


	public function submit_form(){
		$post 							= $this->input->post();
		$periode_detail_id 				= $this->model_periode->get_periode_detail_id($post['periode_id'], $post['program_id'])['periode_detail_id'];
		$insert['periode_detail_id'] 	= $periode_detail_id;
		$insert['branch_id']			= $post['branch_id'];
		$insert['program_id'] 			= $post['program_id'];
		$insert['class_id'] 			= $post['class_id'];
		$insert['trainer_id'] 			= $post['trainer_id'];
		$insert['timestamp'] 			= setNewDateTime();

		$result 	= $this->model_trainer->insert($insert);
		if($result){
			flashdata('success', 'Berhasil menambahkan data');
		}else{
			flashdata('error', 'Gagal menambahkan data');
		}

		redirect(base_url('rc/trainer/branch/'.$post['periode_id'].'/'.$post['branch_id']));
	}

	public function delete(){
		$id 		= $this->input->post('id');
		$response 	= $this->model_trainer->delete($id);
		if($response){
			flashdata('success', 'Berhasil menghapus data');
		}else{
			flashdata('error', 'Gagal mengubah data');
		}
		echo json_encode($response);
	}


	public function json_get_detail_classroom(){
		$url = api_url('rc/Trainerapi/json_get_detail_classroom/');
		$data = array(
			'id' => $this->input->post('id')
		);
			$response = optimus_curl('POST', $url, $data);
			if($response){
				$data['message'] = "Data dihapus";
				$data['status'] = "200";
			}else{
				$data['status'] = "300";
			}	
		// dd($url);
		// die();
		// return (array)$response;
		echo json_encode($response);
	}
	
}