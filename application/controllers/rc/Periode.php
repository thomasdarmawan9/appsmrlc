<?php
defined('BASEPATH') OR exit('No direct script access allowed'); 

class Periode extends CI_Controller {
	
	public function __construct(){
		parent::__construct();
		$this->load->model('model_periode');
	} 
	
	public function _remap($method, $param = array()){
		if(method_exists($this, $method)){
			$level = $this->session->userdata('level');
			if(!empty($level) && (strpos($this->session->userdata('divisi'), 'MRLC') !== false || ($this->session->userdata('id') == '32') || ($this->session->userdata('id') == '190') || ($this->session->userdata('id') == '72'))){
				return call_user_func_array(array($this, $method), $param);
			}else{
				redirect(base_url('login'));				
			}
		}else{
			display_404();
		}
	}

	public function index(){
		$data['periode'] 				= $this->api_index()['periode'];
		$data['periode_adult'] 			= $this->api_index()['periode_adult'];
		$jsonstat = json_encode($data);
		$datas = json_decode($jsonstat, true );
		set_active_menu('periode');
		init_view('rc/periode_add', $datas);
	}

	public function api_index(){
		
		$url = api_url('rc/Periodeapi/api_get_index');

			$periode = optimus_curl('GET', $url, $data = "");
			if($periode != ""){
				$data['message'] = "Data didapatkan atas";
				$data['status'] = "200";
			}else{
				$data['status'] = "300";
			}	
		// dd($url);
		// die();
		return (array)$periode;
	}


	public function submit_form(){
		$post 		= $this->input->post();
		$periode_id	= $post['periode_id'];
		unset($post['periode_id']);


		if(!empty($periode_id)){
			# update statement
			$this->api_ubah_periode();
		}else{
			# insert statement
			$this->api_tambah_periode();
		}

		redirect(base_url('rc/periode'));
	}

	public function api_ubah_periode(){
		$data = array(
			'periode_id' => $this->input->post('periode_id'),
			'periode_status' => $this->input->post('periode_status'),
			'is_adult_class' => $this->input->post('is_adult_class'),
			'ubah' => $this->input->post()
		);
		
		$url = api_url('rc/Periodeapi/api_ubah_periode');

			$ubah = optimus_curl('POST', $url, $data);
			if($ubah){
				$data['message'] = "Data diubah";
				$data['status'] = "200";
				flashdata('success', 'Berhasil mengubah data');
			}else{
				$data['status'] = "300";
				flashdata('error', 'Gagal mengubah data');
			}	
		// dd($url);
		// die();
		return (array)$ubah;
		// echo json_encode($ubah);
	}


	public function api_tambah_periode(){
		$data = array(
			'periode_id' => $this->input->post('periode_id'),
			'periode_status' => $this->input->post('periode_status'),
			'is_adult_class' => $this->input->post('is_adult_class'),
			'tambah' => $this->input->post()
		);
		
		$url = api_url('rc/Periodeapi/api_tambah_periode');

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

	public function submit_modul(){

		$data = array(
			'program_id' => $this->input->post('program_id'),
			'periode_modul' => $this->input->post('periode_modul'),
			'presence' => $this->input->post('presence'),
			'periode_detail_id' => $this->input->post('periode_detail_id'),
			'tambah' => $this->input->post()
		);
		
		$url = api_url('rc/Periodeapi/api_submit_modul');

		$result = optimus_curl('POST', $url, $data);
		if($result){
			flashdata('success', 'Berhasil mengubah data');
		}else{
			flashdata('error', 'Gagal mengubah data');
		}
		redirect(base_url('rc/periode/modul/'. $this->input->post('periode_id')));
	}

	public function api_nonaktif(){
		$data = array(
			'id' => $this->input->post('id')
		);
		
		$url = api_url('rc/Periodeapi/api_nonaktif');

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
		
		$url = api_url('rc/Periodeapi/api_aktif');

			$aktif = optimus_curl('POST', $url, $data);
			if($aktif){
				$data['message'] = "Data dinonaktifkan";
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

	public function modul($periode){
		$data['periode'] 				= $this->api_modul($periode)['periode'];
		$data['detail'] 				= $this->api_modul($periode)['detail'];
		$data['program'] 				= $this->api_modul($periode)['program'];
		$jsonstat = json_encode($data);
		$datas = json_decode($jsonstat, true );
		set_active_menu('periode');
		init_view('rc/periode_detail', $datas);
	}

	public function api_modul($periode){
		
		$url = api_url('rc/Periodeapi/api_modul/'.$periode);

			$response = optimus_curl('GET', $url, $data = '');
			if($response){
				$data['message'] = "Data didapatkan";
				$data['status'] = "200";
			}else{
				$data['status'] = "300";
			}	
		// dd($url);
		// die();
		return (array)$response;
		// echo json_encode($response);
	}

	public function json_get_detail_periode(){
		
		$url = api_url('rc/Periodeapi/json_get_detail_periode/');
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