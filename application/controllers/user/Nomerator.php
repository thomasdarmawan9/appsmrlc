<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Nomerator extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
		$this->load->model('Model_finance');
		$this->load->model('Model_incentive');
		$this->load->model('Model_login');
		$this->load->library('form_validation');
		$this->load->helper('text');
    }

    public function _remap($method, $param = array())
	{
		if (method_exists($this, $method)) {
			$level = $this->session->userdata('level');
			if (!empty($level)) {
				return call_user_func_array(array($this, $method), $param);
			} else {
				redirect(base_url('login'));
			}
		} else {
			display_404();
		}
	}
	
	public function api_index(){
		$url = api_url('user/Nomeratorapi/index');
		$data = array(
			'id' => $this->session->userdata('id')
		);
			$nomerator = optimus_curl('POST', $url, $data);
			if($nomerator != ""){
				$data['message'] = "Data didapatkan atas";
				$data['status'] = "200";
			}else{
				$data['status'] = "300";
			}
		// dd($task);
		// die();
		return (array)$nomerator;
	}
	
    public function index(){
        $data['results']    = $this->api_index()['results'];
	    $data['program']    = $this->api_index()['program'];
	    $data['branch']     = $this->api_index()['branch'];
		$data['hp_branch']  = $this->api_index()['hp_branch'];
		// dd($data);
		// die();
        set_active_menu('Add Nomerator');
        init_view('user/content_nomerator', $data);
	}
	
	public function json_get_tt_detail_api(){
		$url = api_url('user/Nomeratorapi/json_get_tt_detail');
		$data = array(
			'id' => $this->input->post('id')
		);
			$nomerator = optimus_curl('POST', $url, $data);
			if($nomerator != ""){
				$data['message'] = "Data didapatkan atas";
				$data['status'] = "200";
			}else{
				$data['status'] = "300";
			}
		// dd($task);
		// die();
		return (array)$nomerator;
	}

    public function json_get_tt_detail()
	{
		$response 	= $this->json_get_tt_detail_api();
		echo json_encode($response);
	}

	public function submit_form_nomerator_api(){
		$url = api_url('user/Nomeratorapi/submit_form_nomerator');
		$data = array(
			'headnumber' => $this->input->post('headnumber'),
			'bodynumber' => $this->input->post('bodynumber'),
			'location' => $this->input->post('location'),
			'holiday' => $this->input->post('holiday'),
			'type' => $this->input->post('type'),
			'type_psa' => $this->input->post('type_psa'),
			'payment' => $this->input->post('payment'),
			'payment_isp' => $this->input->post('payment_isp'),
			'payment_nisp' => $this->input->post('payment_nisp'),
			'branch' => $this->input->post('branch'),
			'bank' => $this->input->post('bank'),
			'program' => $this->input->post('program'),
			'keterangan' => $this->input->post('keterangan'),
			'id_user' => $this->session->userdata('id'),
			'id_divisi' => $this->session->userdata('iddivisi'),
			'jumlah' => $this->input->post('jumlah'),
			'date' => $this->input->post('date')
		);
			$nomerator = optimus_curl('POST', $url, $data);
			if($nomerator != ""){
				$data['message'] = "Data didapatkan atas";
				$data['status'] = "200";
			}else{
				$data['status'] = "300";
			}
		dd($data);
		die();
		return (array)$nomerator;
	}

    public function submit_form_nomerator()
    {
		$result = $this->submit_form_nomerator_api();

		if ($result) {
			flashdata('success', 'Berhasil menambahkan data');
		} else {
			flashdata('error', 'Gagal menambahkan data atau nomerator sudah terpakai');
		}

		redirect(base_url('user/nomerator'));
	}

	public function delete_nomerator_api(){
		$url = api_url('user/Nomeratorapi/delete_nomerator');
		$data = array(
			'id' => $this->input->post('id')
		);
			$nomerator = optimus_curl('POST', $url, $data);
			if($nomerator != ""){
				$data['message'] = "Data didapatkan atas";
				$data['status'] = "200";
			}else{
				$data['status'] = "300";
			}
		// dd($task);
		// die();
		return (array)$nomerator;
	}

    public function delete_nomerator()
	{
		$results 	= $this->delete_nomerator_api();

		if ($results) {
			flashdata('success', 'Segala data tersebut sudah terhapus dari sistem');
		} else {
			flashdata('error', 'Gagal menghapus data.');
		}
		echo json_encode($results);
	}
}

?>
