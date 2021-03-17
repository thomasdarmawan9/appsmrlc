<?php
defined('BASEPATH') OR exit('No direct script access allowed'); 

class Signup extends CI_Controller {
	
	public function __construct(){
		parent::__construct();
		$this->load->model('model_signup');
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

	public function index(){
		// $data['event'] 				= $this->model_signup->get_list_event($this->session->userdata('iddivisi'));
		$data['event'] = $this->api_list_event()['event'];
		
		// $data['list_warrior'] 		= $this->model_signup->get_list_warrior();	
		// $data['list_task'] 			= $this->model_signup->get_list_task();
		$data['results'] = $this->api_list_signup();
		$data['branch'] = $this->api_list_signup()['branch'];
		$data['class'] = $this->api_list_signup()['class'];
		$data['list_warrior'] = $this->api_list_signup()['list_warrior'];
		$data['list_task'] = $this->api_list_signup()['list_task'];
		// dd($data['list_warrior']);
		// die();
		// echo json_encode($data);

		$data['list_signup_type']	= array('SP', 'PTM', 'Others');
		$data['list_closing_type'] 	= array('DP', 'Lunas');
		$data['list_closing_class'] = array('Modul', 'Full Program');
		$data['list_source'] 		= array('Website', 'Facebook Ads', 'WI/CI', 'Email Blast', 'Referral', 'Others');
		$data['list_payment_type'] 	= array('EDC', 'Transfer', 'Cash', 'Others');
		// dd($data['results']['waiting']);
		// echo json_encode($data);
		// die();
		// $data['results'] = '';

		set_active_menu('Add Signup');
		init_view('user/content_signup_add', $data);
	}
	public function api_list_event(){
		$data = array(
			'iddivisi' => '28'
		);
		
		$url = api_url('user/SignupApi/api_get_list_event');

			$event = optimus_curl('POST', $url, $data);
			if($event != ""){
				$data['message'] = "Data didapatkan atas";
				$data['status'] = "200";
			}else{
				$data['status'] = "300";
			}	
		// echo json_encode($event);
		$list_event = array(
			'event' => $event
		);
		return $list_event;
		
	}

	public function api_list_signup(){
		$data = array(
			'iddivisi' => $this->session->userdata('id_divisi'),
			'divisi' => $this->session->userdata('divisi'),
			'id' => $this->session->userdata('id'),
		);
		
		$url = api_url('user/SignupApi/api_get_signup2');

			$signup = optimus_curl('POST', $url, $data);
			if($signup != ""){
				$data['message'] = "Data didapatkan";
				$data['status'] = "200";
			}else{
				$data['status'] = "300";
			}
		// echo json_encode($signup);
		return (array)$signup;
		
	}

	public function api_search_data_by_phone(){
		// $this->input->post('phone')
		$data = array(
			'id' => $this->session->userdata('id'), 
			'phone' => $this->input->post('phone'),
			'divisi' => $this->session->userdata('divisi'),
			'iddivisi' => $this->session->userdata('iddivisi')
		);
		// echo json_encode($data);
		// die();
		$url = api_url('user/SignupApi/search_data_by_phone');

			$phone = optimus_curl('POST', $url, $data);
			if($phone!= ""){
				$data['message'] = "Data didapatkan atas";
				$data['status'] = "200";
			}else{
				$data['status'] = "300";
			}
			// dd((array)$phone);
		echo json_encode($phone);
		// return (array)$phone;
		
	}

	public function api_json_get_batch_list(){
		// $this->input->post('phone')
		$data = array( 
			'event' => $this->input->post('event'),
		);
		// echo json_encode($data);
		// die();
		$url = api_url('user/SignupApi/json_get_batch_list');

			$batch_list = optimus_curl('POST', $url, $data);
			if($batch_list!= ""){
				$data['message'] = "Data didapatkan atas";
				$data['status'] = "200";
			}else{
				$data['status'] = "300";
			}
			// dd((array)$phone);
		echo json_encode($batch_list);
		// return (array)$phone;
		
	}

	
	public function api_json_master_get_detail_transaction(){
		// $this->input->post('phone')
		$data = array( 
			'id' => $this->input->post('id'),
		);
		// echo json_encode($data);
		// die();
		$url = api_url('user/SignupApi/json_master_get_detail_transaction');

			$det_tans = optimus_curl('POST', $url, $data);
			if($det_tans!= ""){
				$data['message'] = "Data didapatkan atas";
				$data['status'] = "200";
			}else{
				$data['status'] = "300";
			}
			// dd((array)$phone);
		echo json_encode($det_tans);
		// return (array)$phone;
		
	}

	public function all(){
		
		$data['branch'] = $this->api_get_all()['branch'];
		$data['class'] = $this->api_get_all()['class'];
		$data['list_warrior'] = $this->api_get_all()['list_warrior'];
		$data['list_task'] = $this->api_get_all()['list_task'];
		$data['filter'] = $this->api_get_all();
		$data['event'] = $this->api_get_all()['event'];
		$data['list'] = $this->api_get_all()['list'];
		// dd($data['filter']);
		// die();
		set_active_menu('List Signup');
		init_view('user/content_signup_list',$data);
	}

	public function api_get_all(){
		$data = array(
			'id' => $this->session->userdata('id'),
			'divisi' => $this->session->userdata('divisi'),
			'filter' => $this->input->get()
		);
		// echo json_encode($data);
		// die();
		$url = api_url('user/SignupApi/api_all');

			$all = optimus_curl('POST', $url, $data);
			if($all != ""){
				$data['message'] = "Data didapatkan atas";
				$data['status'] = "200";
			}else{
				$data['status'] = "300";
			}
		// $data['list'] = $this->model_signup->get_data_signup_approved($this->session->userdata('id'), $parameter);
		// echo json_encode($all);
		return (array)$all;
	}

	public function api_export(){
		$data = array(
			'id' => $this->session->userdata('id'),
			'divisi' => $this->session->userdata('divisi'),
			'iddivisi' => $this->session->userdata('iddivisi'),
			'filter' => $this->input->get()
		);
		$url = api_url('user/SignupApi/export_data_transaction');

			$data = optimus_curl('POST', $url, $data);

			if($data != ""){
		// dd($data);
		// die();
				$filename 	= "Data_transaksi_".strtotime(setNewDateTime());
				exportToExcel($data->results, $data->list_fields, 'Sheet 1', $filename);
				
			}else{
				$data['status'] = "300";
			}
		// $data['list'] = $this->model_signup->get_data_signup_approved($this->session->userdata('id'), $parameter);
		// echo json_encode($export);
	}

	public function api_submit_form_student(){
		// $this->input->post('phone')
		// $post = $this->input->post();

		$data = array(
			'id' => $this->session->userdata('id'),
			'iddivisi' => $this->session->userdata('iddivisi'),
			'divisi' => $this->session->userdata('divisi'),
			'std_participant_name' => $this->input->post('std_participant_name'),
			'std_birthdate' => $this->input->post('std_birthdate'),
			'std_gender' => $this->input->post('std_gender'),
			'std_phone' => $this->input->post('std_phone'),
			'std_email' => $this->input->post('std_email'),
			'std_address' => $this->input->post('std_address'),
			'std_school' => $this->input->post('std_school'),
			// 'std_is_vegetarian' => $this->input->post('std_is_vegetarian'),
			// 'std_is_allergy' => $this->input->post('std_is_allergy'),
			'std_dad_id' => $this->input->post('std_dad_id'),
			'std_dad_name' => $this->input->post('std_dad_name'),
			'std_dad_email' => $this->input->post('std_dad_email'),
			'std_dad_phone' => $this->input->post('std_dad_phone'),
			'std_dad_job' => $this->input->post('std_dad_job'),
			'std_mom_id' => $this->input->post('std_mom_id'),
			'std_mom_name' => $this->input->post('std_mom_name'),
			'std_mom_email' => $this->input->post('std_mom_email'),
			'std_mom_phone' => $this->input->post('std_mom_phone'),
			'std_mom_job' => $this->input->post('std_mom_job'),
			'participant_id_std' => $this->input->post('participant_id_std'),
			'affiliate_id' => $this->input->post('affiliate_id'),
			'std_event_name' => $this->input->post('std_event_name'),
			'std_event_commision' => $this->input->post('std_event_commision'),
			'std_family_discount' => $this->input->post('std_family_discount'),
			'std_signup_type' => $this->input->post('std_signup_type'),
			'std_branch' => $this->input->post('std_branch'),
			'std_class' => $this->input->post('std_class'),
			'std_source' => $this->input->post('std_source'),
			'std_payment_type' => $this->input->post('std_payment_type'),
			'std_atas_nama' => $this->input->post('std_atas_nama'),
			'std_detail_edc' => $this->input->post('std_detail_edc'),
			'std_payment_source' => $this->input->post('std_payment_source'),
			'std_paid_value' => $this->input->post('std_paid_value'),
			'std_paid_date' => $this->input->post('std_paid_date'),
			'std_closing_type' => $this->input->post('std_closing_type'),
			'modul_class' => $this->input->post('modul_class'),
			'std_id_task' => $this->input->post('std_id_task'),
			'std_closing_type' => $this->input->post('std_closing_type'),
			'full_program_startdate' => $this->input->post('full_program_startdate'),
			'std_remark' => $this->input->post('std_remark'),
			'std_is_upgrade' => $this->input->post('std_is_upgrade'),
			'std_referral' => $this->input->post('std_referral'),
			'std_id_user_closing' => $this->input->post('std_id_user_closing'),
			'std_referral' => $this->input->post('std_referral'),
		);
		// echo json_encode($data);
		// die();
		$url = api_url('user/SignupApi/submit_form_student');

			$submitstd = optimus_curl('POST', $url, $data);
			// dd($submitstd);
			// die();
			// if($submitstd != ""){
			// 	$data['message'] = "Data didapatkan atas";
			// 	$data['status'] = "200"	;
			// }else{
			// 	$data['status'] = "300";
			// }
			if($submitstd !== ""){
			flashdata('success', 'Berhasil menambahkan data.');
		}else{
			flashdata('error', 'Gagal menambahkan data.');
		}
		redirect(base_url('user/signup'));
			// dd((array)$phone);
		// echo json_encode($submitstd);
		// return $submitstd;
		
	}	

	public function delete(){
		$id = $this->input->post('id');
		$result = $this->model_signup->delete_transaction($id);
		if($result){
			flashdata('success', 'Berhasil menghapus data');
		}else{
			flashdata('error', 'Gagal menghapus data');
		}
		echo json_encode($result);
	}


	// public function json_email_exist(){
	// 	$isExist = $this->model_signup->is_email_exist($this->input->post('email'));
	// 	echo json_encode($isExist);
	// }

	public function api_json_email_exist(){
		// $this->input->post('phone')
		$data = array( 
			'email' => $this->input->post('email'),
		);
		// echo json_encode($data);
		// die();
		$url = api_url('user/SignupApi/json_email_exist');

			$email_exist = optimus_curl('POST', $url, $data);
			if($email_exist!= ""){
				$data['message'] = "Data didapatkan atas";
				$data['status'] = "200";
			}else{
				$data['status'] = "300";
			}
			// dd((array)$phone);
		echo json_encode($email_exist);
		// return (array)$phone;
		
	}

	// public function get_data_participant(){
	// 	$email 	= secure($this->input->post('email'));
	// 	$result = $this->model_signup->get_data_participant_by_email($email);
	// 	echo json_encode($result);
	// }

	public function api_get_data_participant(){
		// $this->input->post('phone')
		$data = array( 
			'email' => $this->input->post('email'),
		);
		// echo json_encode($data);
		// die();
		$url = api_url('user/SignupApi/get_data_participant');

			$participant_exist = optimus_curl('POST', $url, $data);
			if($participant_exist!= ""){
				$data['message'] = "Data didapatkan atas";
				$data['status'] = "200";
			}else{
				$data['status'] = "300";
			}
			// dd((array)$phone);
		echo json_encode($participant_exist);
		// return (array)$phone;
		
	}

	// public function json_get_data_transaksi(){
	// 	$id 		= $this->input->post('id');
	// 	$response 	= $this->model_signup->get_data_repayment_transaction($id);
	// 	echo json_encode($response);
	// }

	public function api_json_get_data_transaksi(){
		// $this->input->post('phone')
		$data = array( 
			'id' => $this->input->post('id'),
		);
		// echo json_encode($data);
		// die();
		$url = api_url('user/SignupApi/json_get_data_transaksi');

			$dat_trans_json = optimus_curl('POST', $url, $data);
			if($dat_trans_json!= ""){
				$data['message'] = "Data didapatkan atas";
				$data['status'] = "200";
			}else{
				$data['status'] = "300";
			}
			// dd((array)$phone);
		echo json_encode($dat_trans_json);
		// return (array)$phone;
		
	}

	// public function json_phone_exist(){
	// 	$phone 		= $this->input->post('phone');
	// 	$response 	= $this->model_signup->get_data_participant_by_phone($phone);
	// 	echo json_encode($response);
	// }

	public function api_json_phone_exist(){
		// $this->input->post('phone')
		$data = array( 
			'phone' => $this->input->post('phone'),
		);
		// echo json_encode($data);
		// die();
		$url = api_url('user/SignupApi/json_phone_exist');

			$phone_exist = optimus_curl('POST', $url, $data);
			if($phone_exist!= ""){
				$data['message'] = "Data didapatkan atas";
				$data['status'] = "200";
			}else{
				$data['status'] = "300";
			}
			// dd((array)$phone);
		echo json_encode($phone_exist);
		// return (array)$phone;
		
	}

	// public function json_get_data_event(){
	// 	$id 		= $this->input->post('event');
	// 	$response 	= $this->model_signup->get_data_event_by_id($id);
	// 	echo json_encode($response);
	// }

	public function api_json_get_data_event(){
		// $this->input->post('phone')
		$data = array( 
			'event' => $this->input->post('event'),
		);
		// echo json_encode($data);
		// die();
		$url = api_url('user/SignupApi/json_get_data_event');

			$event_json = optimus_curl('POST', $url, $data);
			if($event_json!= ""){
				$data['message'] = "Data didapatkan atas";
				$data['status'] = "200";
			}else{
				$data['status'] = "300";
			}
			// dd((array)$phone);
		echo json_encode($event_json);
		// return (array)$phone;
		
	}

	// public function search_data_by_phone(){
	// 	$phone 		= secure($this->input->post('phone'));
	// 	$isExist 	= $this->model_signup->get_data_participant_by_phone($phone);
	// 	if(!$isExist){
	// 		# jika bukan existing customer, maka cek apakah terdaftar di apps reseller
	// 		$url = $this->config->item('reseller_url').'request/get_data_participant_active';
	// 		$curl_response = curl_post_https($url, array('phone' => $phone));
	// 		$extract = json_decode($curl_response);
	// 		if(!$extract){
	// 			$response['type'] 	= 'new';
	// 		}else{
	// 			# data reseller
	// 			$event 		= $this->model_signup->get_data_event_by_name($extract->event);
	// 			if ((strpos($this->session->userdata('divisi'), 'MRLC')  !== false) || ($this->session->userdata('id') == '28') || ($this->session->userdata('id') == 32) || ($this->session->userdata('id') == '155')) {
	// 				$iddivisi = $this->db->get_where('divisi', array('departement' => 'MRLC-1'))->row_array()['id'];
	// 			}else{
	// 				$iddivisi 	= $this->session->userdata('iddivisi');
	// 			}
	// 			if($iddivisi == $event['department_id']){
	// 				# jika eventnya sesuai dengan divisi/ department spv
	// 				$response['type'] = 'reseller';
	// 				$response['data'] = (array) $extract;
	// 				$response['data']['id_event'] = $event['id'];
	// 			}else{
	// 				# jika eventnya tidak sesuai dengan divisi/ department spv
	// 				$response['type'] 		= 'new';
	// 			}
	// 		}
	// 	}else{
	// 		# existing customer
	// 		$response['type'] = 'exist';
	// 		$response['data'] = $isExist;
	// 	}
	// 	echo json_encode($response);
	// }

	public function submit_form_participant(){
		$post = $this->input->post();
		if(empty($post['gender'])){
			$post['gender'] = '-';
		}
		$participant['participant_name']	= $post['participant_name'];
		$participant['birthdate'] 			= $post['birthdate'];
		$participant['gender'] 				= $post['gender'];
		$participant['phone'] 				= $post['phone'];
		$participant['email'] 				= $post['email'];
		$participant['address'] 			= $post['address'];
		$participant['school'] 				= $post['school'];
		$participant['date_created'] 		= setNewDateTime();
		if(!empty($post['dad_id'])){
			# jika data ayah tersedia di database
			$participant['dad_id'] 			= $post['dad_id'];		
		}else if(!empty($post['dad_phone'])){
			# data baru ayah
			$dad['participant_name']		= $post['dad_name'];
			$dad['email'] 					= $post['dad_email'];
			$dad['phone'] 					= $post['dad_phone'];
			$dad['job'] 					= $post['dad_job'];
			$dad['gender'] 					= 'L';
			$dad['date_created']			= setNewDateTime();
			$participant['dad_id'] 			= $this->model_signup->insert_participant($dad);
		}else{
			$participant['dad_id'] 			= "";
		}

		if(!empty($post['mom_id'])){
			# jika data ibu tersedia di database
			$participant['mom_id'] 			= $post['mom_id'];		
		}else if(!empty($post['mom_phone'])){
			# data baru ibu
			$mom['participant_name']		= $post['mom_name'];
			$mom['email'] 					= $post['mom_email'];
			$mom['phone'] 					= $post['mom_phone'];
			$mom['job'] 					= $post['mom_job'];
			$mom['gender'] 					= 'P';
			$mom['date_created']			= setNewDateTime();
			$participant['mom_id'] 			= $this->model_signup->insert_participant($mom);
		}else{
			$participant['mom_id'] 			= "";
		}


		if(!empty($post['participant_id'])){
			# jika data existing customer
			$participant_id 				= $post['participant_id'];
			$result 						= $this->model_signup->update_participant($participant, $participant_id);
		}else if(!empty($post['affiliate_id'])){
			# jika data reseller
			$participant_id 				= $this->model_signup->insert_participant($participant);
			$transaction['id_affiliate'] 	= $post['affiliate_id'];
		}else{
			# jika data baru
			$participant_id 				= $this->model_signup->insert_participant($participant);
		}
		
		$event 							= $this->model_signup->get_data_event_by_id($post['event_name']);
		$transaction['participant_id'] 	= $participant_id;
		$transaction['event_id'] 		= $post['event_name'];
		$transaction['event_name'] 		= $event['name'];
		$transaction['event_commision'] = $post['event_commision'];
		$transaction['event_price'] 	= $event['price'];
		$transaction['reseller_fee'] 	= $event['reseller_fee'];
		$transaction['signup_type'] 	= $post['signup_type'];
		$transaction['source'] 			= $post['source'];
		$transaction['payment_type'] 	= $post['payment_type'];
		$transaction['transfer_atas_nama'] = $post['atas_nama'];
		$transaction['paid_value']		= $post['paid_value'];
		$transaction['paid_date']		= $post['paid_date'];
		$transaction['closing_type']	= $post['closing_type'];
		$transaction['remark']			= $post['remark'];
		if(!empty($post['is_reattendance'])){
			$transaction['is_reattendance']	= 1;
		}
		$transaction['referral'] 		= $post['referral'];
		$transaction['sales_id'] 		= $post['id_user_closing'];
		$transaction['id_task'] 		= $post['id_task'];
		if ((strpos($this->session->userdata('divisi'), 'MRLC')  !== false) || ($this->session->userdata('id') == '28') || ($this->session->userdata('id') == 32) || ($this->session->userdata('id') == '155')) {
			$mrlc 					= $this->db->get_where('divisi', array('departement' => 'MRLC-1'))->row_array()['id'];
			$transaction['department_id']	= $mrlc;
		}else{
			$transaction['department_id'] 	= $this->session->userdata('iddivisi');
		}
		$transaction['input_by']		= $this->session->userdata('id');
		$transaction['timestamp'] 		= setNewDateTime();

		$result = $this->model_signup->insert_transaction($transaction);
		if($result){
			flashdata('success', 'Berhasil menambahkan data.');
		}else{
			flashdata('error', 'Gagal menambahkan data.');
		}
		redirect(base_url('user/signup'));
	}
	
}