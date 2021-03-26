<?php
defined('BASEPATH') OR exit('No direct script access allowed'); 

class Classroom extends CI_Controller {
	
	public function __construct(){
		parent::__construct();
		// $this->load->model('model_classroom');
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
		$data['classroom'] 				= $this->api_index()['classroom'];
		$jsonstat = json_encode($data);
		$datas = json_decode($jsonstat, true );
		set_active_menu('classroom');
		init_view('rc/classroom_add', $datas);
	}

	public function api_index(){
		$url = api_url('rc/Classroomapi/api_get_index');

			$class = optimus_curl('GET', $url, $data = "");
			if($class != ""){
				$data['message'] = "Data didapatkan atas";
				$data['status'] = "200";
			}else{
				$data['status'] = "300";
			}	
		// dd($url);
		// die();
		return (array)$class;
	}

	public function submit_form(){
		$post 		= $this->input->post();
		if(!empty($post['is_adult_class'])){
			$post['is_adult_class'] = 1;
		}else{
			$post['is_adult_class'] = 0;
		}
		$class_id 	= $post['class_id'];
		unset($post['class_id']);

		if(!empty($class_id)){
			# update statement
			$this->api_ubah_class();
		}else{
			# insert statement
			$this->api_tambah_class();
		}

		redirect(base_url('rc/classroom'));
	}

	public function api_ubah_class(){
		$data = array(
			'is_adult_class' => $this->input->post('is_adult_class'),
			'class_id' => $this->input->post('class_id'),
			'ubah' => $this->input->post()
		);
		
		$url = api_url('rc/Classroomapi/api_ubah_class');

			$ubah = optimus_curl('POST', $url, $data);
			if($ubah){
				$data['message'] = "Data diubah";
				$data['status'] = "200";
				// flashdata('success', 'Berhasil mengubah data');
			}else{
				$data['status'] = "300";
				dd($ubah);
				// flashdata('error', 'Gagal mengubah data');
			}	
		// dd($url);
		// die();
		return (array)$ubah;
		// echo json_encode($ubah);
	}


	public function api_tambah_class(){
		$data = array(
			'is_adult_class' => $this->input->post('is_adult_class'),
			'class_id' => $this->input->post('class_id'),
			'tambah' => $this->input->post()
		);
		
		$url = api_url('rc/Classroomapi/api_tambah_class');

			$tambah = optimus_curl('POST', $url, $data);
			if($tambah){
				$data['message'] = "Data ditambah";
				$data['status'] = "200";
				flashdata('success', 'Berhasil menambahkan data');
			}else{
				$data['status'] = "300";
				flashdata('error', 'Gagal menambahkan data');
			}	
		// dd($url);
		// die();
		return (array)$tambah;
		// echo json_encode($ubah);
	}


	public function api_nonaktif(){
		$data = array(
			'id' => $this->input->post('id')
		);
		
		$url = api_url('rc/Classroomapi/api_nonaktif');

			$nonaktif = optimus_curl('POST', $url, $data);
			if($nonaktif){
				$data['message'] = "Data dinonaktifkan";
				$data['status'] = "200";
				flashdata('success', 'Berhasil menonaktifkan data');
			}else{
				$data['status'] = "300";
				flashdata('error', 'Gagal mengubah data');
			}	
		// dd($url);
		// die();
		// return (array)$branch;
		echo json_encode($nonaktif);
	}

	public function api_aktif(){
		$data = array(
			'id' => $this->input->post('id')
		);
		
		$url = api_url('rc/Classroomapi/api_aktif');

			$aktif = optimus_curl('POST', $url, $data);
			if($aktif){
				$data['message'] = "Data diaktifkan";
				$data['status'] = "200";
				flashdata('success', 'Berhasil mengaktifkan data');
			}else{
				$data['status'] = "300";
				flashdata('error', 'Gagal mengubah data');
			}	
		// dd($url);
		// die();
		// return (array)$branch;
		echo json_encode($aktif);
	}

	public function json_get_detail_classroom(){

		$url = api_url('rc/Classroomapi/json_get_detail_classroom/');
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