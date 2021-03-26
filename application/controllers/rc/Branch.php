<?php
defined('BASEPATH') OR exit('No direct script access allowed'); 

class Branch extends CI_Controller {
	
	public function __construct(){
		parent::__construct();
		$this->load->model('model_branch');
	} 
	
	public function _remap($method, $param = array()){
		if(method_exists($this, $method)){
			$level = $this->session->userdata('level');
			if(!empty($level) && (strpos($this->session->userdata('divisi'), 'MRLC') !== false|| ($this->session->userdata('id') == '32') || ($this->session->userdata('id') == '190') || ($this->session->userdata('id') == '72'))){
				return call_user_func_array(array($this, $method), $param);
			}else{
				redirect(base_url('login'));				
			}
		}else{
			display_404();
		}
	}

	public function index(){
		$data['branch'] 				= $this->api_index()['branch'];
		$data['trainer'] 				= $this->api_index()['trainer'];
		$jsonstat = json_encode($data);
		$datas = json_decode($jsonstat, true );
		// dd($datas);
		// die();
		set_active_menu('branch');
		init_view('rc/branch_add', $datas);
	}

	
	public function api_index(){
		$data = array(

		);
		
		$url = api_url('rc/Branchapi/api_get_index');

			$branch = optimus_curl('POST', $url, $data);
			if($branch != ""){
				$data['message'] = "Data didapatkan atas";
				$data['status'] = "200";
			}else{
				$data['status'] = "300";
			}	
		// dd($url);
		// die();
		return (array)$branch;
	}

	public function submit_form(){
		$post 		= $this->input->post();
		$branch_id 	= $post['branch_id'];
		unset($post['branch_id']);

		if(!empty($branch_id)){
			# update statement
			$this->api_ubah();
		}else{
			# insert statement
			$this->api_tambah();
		}

		redirect(base_url('rc/branch'));
	}

	public function api_ubah(){
		$data = array(
			'branch_id' => $this->input->post('branch_id'),
			'branch_lead_trainer' => $this->input->post('branch_lead_trainer'),
			'ubah' => $this->input->post()
		);
		
		$url = api_url('rc/Branchapi/api_ubah');

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


	public function api_tambah(){
		$data = array(
			'branch_id' => $this->input->post('branch_id'),
			'branch_lead_trainer' => $this->input->post('branch_lead_trainer'),
			'tambah' => $this->input->post()
		);
		
		$url = api_url('rc/Branchapi/api_tambah');

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
		
		$url = api_url('rc/Branchapi/api_nonaktif');

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

	public function api_delete(){
		$data = array(
			'id' => $this->input->post('id')
		);
		
		$url = api_url('rc/Branchapi/api_delete');

			$aktif = optimus_curl('POST', $url, $data);
			if($aktif){
				$data['message'] = "Data dihapus";
				$data['status'] = "200";
				flashdata('success', 'Berhasil menghapus data');
			}else{
				$data['status'] = "300";
				flashdata('error', 'Gagal mengubah data');
			}	
		// dd($url);
		// die();
		// return (array)$branch;
		echo json_encode($aktif);
	}


	public function api_aktif(){
		$data = array(
			'id' => $this->input->post('id')
		);
		
		$url = api_url('rc/Branchapi/api_aktif');

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

	public function trainer($branch){
		$data['branch'] 	= $this->api_trainer($branch)['branch'] ;
		$data['trainer'] 	= $this->api_trainer($branch)['trainer'];
		$data['list'] 		= $this->api_trainer($branch)['list'];
		$jsonstat = json_encode($data);
		$datas = json_decode($jsonstat, true );
		set_active_menu('branch');
		init_view('rc/branch_trainer', $datas);
	}

	public function api_trainer($branch){
		
		$url = api_url('rc/Branchapi/api_trainer/'.$branch);

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

	public function add_trainer(){
		$data = array(
			'trainer' => $this->input->post('trainer'),
			'branch_id' => $this->input->post('branch_id'),
		);
		
		$url = api_url('rc/Branchapi/api_add_trainer');

			$response = optimus_curl('POST', $url, $data);
			if($response){
				$data['message'] = "Data diaktifkan";
				$data['status'] = "200";
				flashdata('success', 'Berhasil mengubah data');
			}else{
				$data['status'] = "300";
				flashdata('error', 'Gagal mengubah data');
			}	

		redirect(base_url('rc/branch/trainer/'.$this->input->post('branch_id')));
	}
	
	public function json_get_detail_branch(){
		
		$url = api_url('rc/Branchapi/api_json_get_detail_branch/');
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

	public function json_remove_trainer(){
		
		$url = api_url('rc/Branchapi/api_json_remove_trainer/');
		$data = array(
			'id' => $this->input->post('id')
		);
			$response = optimus_curl('POST', $url, $data);
			if($response){
				$data['message'] = "Data dihapus";
				$data['status'] = "200";
							flashdata('success', 'Berhasil menghapus data');
			}else{
				$data['status'] = "300";
							flashdata('error', 'Gagal mengubah data');
			}	
		// dd($url);
		// die();
		// return (array)$response;
		echo json_encode($response);
	}
	
}