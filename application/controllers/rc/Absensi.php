<?php
defined('BASEPATH') OR exit('No direct script access allowed'); 

class Absensi extends CI_Controller {
	
	public function __construct(){
		parent::__construct();
		// $this->load->model('model_trainer');
		// $this->load->model('model_periode');
		// $this->load->model('model_branch');
		// $this->load->model('model_classroom');
		// $this->load->model('model_absensi');
		// $this->load->model('model_student');
	} 
	
	public function _remap($method, $param = array()){
		if(method_exists($this, $method)){
			$level = $this->session->userdata('level');
			if(!empty($level) && (strpos($this->session->userdata('divisi'), 'MRLC') !== false || ($this->session->userdata('id') == 32) || ($this->session->userdata('id') == '190') || ($this->session->userdata('id') == '72') || ($this->session->userdata('id') == '128'))){
				return call_user_func_array(array($this, $method), $param);
			}else{
				redirect(base_url('login'));				
			}
		}else{
			display_404();
		}
	}
	
	public function api_index(){
		$data = array(
			'is_spv' => $this->session->userdata('is_spv'),
			'divisi' => $this->session->userdata('divisi'),
			'id' => $this->session->userdata('id'),
			'get' => $this->input->get()
		);
		
		$url = api_url('rc/Absensiapi/api_get_absensi');

			$absen = optimus_curl('POST', $url, $data);
			if($absen != ""){
				$data['message'] = "Data didapatkan";
				$data['status'] = "200";
			}else{
				$data['status'] = "300";
			}	
		// dd($url);
		// die();
		return (array)$absen;
	}

	public function index(){
		if($this->session->userdata('is_spv') == true && strpos($this->session->userdata('divisi'), 'MRLC') !== false || ($this->session->userdata('id') == '32') || ($this->session->userdata('id') == '190') || ($this->session->userdata('id') == '72') || ($this->session->userdata('id') == '128')){
			# as supervisor
			$data['periode'] 	= $this->api_index()['periode'];
			$data['branch'] 	= $this->api_index()['branch'];
			$data['school'] 	= $this->api_index()['school'];
			$data['class'] 		= $this->api_index()['class'];
			$data['tab'] 		= 'regular';
			$data['absen'] 	= $this->api_index()['absen'];
			$data['rekap'] 	= $this->api_index()['rekap'];
			$jsonindex = json_encode($data);
			$datas = json_decode($jsonindex, true );
			// dd($datas);
			// die();
			set_active_menu('absensi');
			init_view('rc/absensi_periode_spv', $datas);
		}else{
			# as trainer
			$data['periode'] 	= $this->api_index()['periode'];
			$data['branch'] 	= $this->api_index()['branch'];
			$data['tab'] 		= 'regular';
			$jsonindex = json_encode($data);
			$datas = json_decode($jsonindex, true );
			// dd($datas);
			// die();
			set_active_menu('absensi');
			init_view('rc/absensi_periode', $datas);
		}
	}

	public function api_index_adult(){
		$data = array(
			'is_spv' => $this->session->userdata('is_spv'),
			'divisi' => $this->session->userdata('divisi'),
			'id' => $this->session->userdata('id'),
			'get' => $this->input->get()
		);
		
		$url = api_url('rc/Absensiapi/api_get_absensi_adult');

			$absen = optimus_curl('POST', $url, $data);
			if($absen != ""){
				$data['message'] = "Data didapatkan";
				$data['status'] = "200";
			}else{
				$data['status'] = "300";
			}	
		// dd($url);
		// die();
		return (array)$absen;
	}

	public function adult(){
		if($this->session->userdata('is_spv') == true && strpos($this->session->userdata('divisi'), 'MRLC') !== false || ($this->session->userdata('id') == '32') || ($this->session->userdata('id') == '190') || ($this->session->userdata('id') == '72') || ($this->session->userdata('id') == '128')){
			# as supervisor
			$data['periode'] 	= $this->api_index_adult()['periode'];
			$data['branch'] 	= $this->api_index_adult()['branch'];
			$data['school'] 	= $this->api_index_adult()['school'];
			$data['class'] 		= $this->api_index_adult()['class'];
			$data['tab'] 		= 'adult';
			if(!empty($this->input->get())){
				$data['absen'] 	= $this->api_index_adult()['absen'];
				$data['rekap'] 	= $this->api_index_adult()['rekap'];
			}else{
				$data['absen'] 	= array();
				$data['rekap'] 	= $this->api_index_adult()['rekap'];				
			}
			$jsonindex = json_encode($data);
			$datas = json_decode($jsonindex, true );
			// dd($data['rekap']);
			set_active_menu('absensi');
			init_view('rc/absensi_periode_adult_spv', $datas);
		}else{
			# as trainer
			$data['periode'] 	= $this->api_index_adult();
			$data['branch'] 	= $this->api_index_adult();
			$data['tab'] 		= 'adult';
			$jsonindex = json_encode($data);
			$datas = json_decode($jsonindex, true );
			set_active_menu('absensi');
			init_view('rc/absensi_periode_adult', $datas);
		}
	}

	public function api_periode($periode, $branch = null){
		$data = array(
			'id' => $this->session->userdata('id')
		);
		
		$url = api_url('rc/Absensiapi/periode/'.$periode.'/'.$branch);

			$absen = optimus_curl('POST', $url, $data);
			if($absen != ""){
				$data['message'] = "Data didapatkan";
				$data['status'] = "200";
			}else{
				$data['status'] = "300";
			}	
		// dd($url);
		// die();
		return (array)$absen;
	}

	public function periode($periode, $branch = null){
		$data['class'] 		= $this->api_periode($periode, $branch)['class'] ;
		$data['periode'] 	= $this->api_periode($periode, $branch)['periode'];
		$data['branch'] 	= $this->api_periode($branch)['branch'];
		$data['rekap'] 		= $this->api_periode($periode, $branch)['rekap'] ;
		// dd($data);
		$jsonindex = json_encode($data);
		$datas = json_decode($jsonindex, true );
		set_active_menu('absensi');
		init_view('rc/absensi_program', $datas);
	}

	public function export($class_id){
		$class 			= $this->model_trainer->get_data($class_id);
		$periode		= $this->model_periode->get_periode_by_detail($class['periode_detail_id']);
		$periode_detail = $this->model_periode->get_periode_detail_id($periode['periode_id'], $class['program_id']);
		$student 	 	= $this->model_absensi->get_student_class($class['branch_id'], $class['program_id'], $class['class_id'], $periode['periode_start_date'], $periode['periode_end_date']);
		$trainer 		= $this->model_trainer->get_trainer($class['periode_detail_id'], $class['branch_id'], $class['program_id'], $class['class_id']);

		$detail['periode_name'] = $periode['periode_name'];
		$detail['branch'] 		= $trainer['branch_name'];
		$detail['program'] 		= $class['program'];
		$detail['class_name']	= $class['class_name'];
		$detail['trainer'] 		= $trainer['name'];
		$header = array("No", "Student", "Type");
		$session = array();
		$rekap = array();
		for($i = 0; $i < $periode_detail['presence']; $i++){
			$absen 	= $this->model_absensi->get_list_absen_export($class['periode_detail_id'], $class['branch_id'], $class['program_id'], $class['class_id'], $periode['periode_start_date'], $periode['periode_end_date'], ($i+1));
			array_push($header, "Sesi ".($i+1));

			$detailrekap 	= $this->model_absensi->get_list_absen_rekap($class['periode_detail_id'], $class['branch_id'], $class['program_id'], $class['class_id'], ($i+1));
			array_push($rekap, $detailrekap);

			for($j = 0; $j < count($student); $j++){
				$session[$i][$j]['sesi'] 			= ($i+1);
				if(!empty($absen)){
					for($k = 0; $k < count($student); $k++){
						if(!empty($absen[$k]['student_id']) && $student[$j]['student_id'] == $absen[$k]['student_id']){
							$session[$i][$j]['student_id']	= $student[$j]['student_id'];
							if($absen[$k]['is_attend'] == 1){
								$session[$i][$j]['is_attend'] 	= 'v';
							}else if($absen[$k]['is_attend'] == 2){
								$session[$i][$j]['is_attend'] 	= 'xv';
							}else{
								$session[$i][$j]['is_attend'] 	= 'x';
							}
							break;
						}else{
							$session[$i][$j]['student_id']	= $student[$j]['student_id'];
							$session[$i][$j]['is_attend'] 	= '-';
						}
					}
				}else{
					$session[$i][$j]['student_id']	= $student[$j]['student_id'];
					$session[$i][$j]['is_attend'] 	= '-';
				}
			}
		}

		exportAbsen($detail, $header, $student, $session, $rekap, 'Absensi', $detail['branch'].'_'.$detail['program'].'_'.$detail['class_name'].'_'.date('ymdhis'));
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

	public function sesi_as_spv($class, $sesi){
		$data = array(
			'is_spv' => $this->session->userdata('is_spv'),
			'id' => $this->session->userdata('id'),
			'divisi' => $this->session->userdata('divisi'),
		);
		
		$url = api_url('rc/Absensiapi/sesi_as_spv/'.$class.'/'.$sesi);

			$manage = optimus_curl('POST', $url, $data);
			if($manage){
				$data['message'] = "Data dinonaktifkan";
				$data['status'] = "200";
			}else{
				$data['status'] = "300";
			}	

			return (array)$manage;
	}

	public function sesi_as_trainer($class, $sesi){
		$data = array(
			'is_spv' => $this->session->userdata('is_spv'),
			'id' => $this->session->userdata('id'),
			'divisi' => $this->session->userdata('divisi'),
		);
		
		$url = api_url('rc/Absensiapi/sesi_as_trainer/'.$class.'/'.$sesi);

			$manage = optimus_curl('POST', $url, $data);
			if($manage){
				$data['message'] = "Data dinonaktifkan";
				$data['status'] = "200";
			}else{
				$data['status'] = "300";
			}	

			return (array)$manage;
	}

	public function sesi($class, $sesi){
		if($this->session->userdata('is_spv') == true && strpos($this->session->userdata('divisi'), 'MRLC') !== false || ($this->session->userdata('id') == '32') || ($this->session->userdata('id') == '190') || ($this->session->userdata('id') == '72') || ($this->session->userdata('id') == '128')){
			# as supervisor
			$data['url'] 		= $_SERVER['QUERY_STRING'];
			$data['sesi'] 		= $sesi;
			$data['class'] 		= $this->sesi_as_spv($class, $sesi)['class'];
			$data['periode'] 	= $this->sesi_as_spv($class, $sesi)['periode'];
			$data['student'] 	= $this->sesi_as_spv($class, $sesi)['student'];
			$data['absen'] 		= $this->sesi_as_spv($class, $sesi)['absen'];
			$data['rekap'] 		= $this->sesi_as_spv($class, $sesi)['rekap'];
		
			
			$data['attendance'] = $this->sesi_as_spv($class, $sesi);
			$data['other'] 		= $this->sesi_as_spv($class, $sesi);
			$data['trainer_class'] 	= $class;
			$jsonstat = json_encode($data);
			$datas = json_decode($jsonstat, true );
			set_active_menu('absensi');
			init_view('rc/absensi_class_spv', $datas);
		}else{
			# as trainer
			$data['sesi'] 		= $sesi;
			$data['class'] 		= $this->sesi_as_trainer($class, $sesi)['class'];
			$data['periode'] 	= $this->sesi_as_trainer($class, $sesi)['periode'];
			$data['student'] 	= $this->sesi_as_trainer($class, $sesi)['student'];
			$data['absen'] 		= $this->sesi_as_trainer($class, $sesi)['absen'];
			$data['rekap'] 		= $this->sesi_as_trainer($class, $sesi)['rekap'];
			// dd($data['absen']);
			
			$attendance = 0;
			$other = 0;
			foreach($data['absen'] as $row){
				if($row['is_attend'] == 1 && $row['is_change'] == 0){
					$attendance++;
				}

				if($row['is_change'] == 1 && $row['change_to'] == 0){
					$other++;
				}
			}
			$data['attendance'] = $attendance;
			$data['other'] 		= $other;
			$data['trainer_class'] 	= $class;
			set_active_menu('absensi');
			init_view('rc/absensi_class', $data);
		}

	}

	public function api_presence(){
		$data = array(
			'url' => $this->input->post('url'),
			'trainer_class_id' =>  $this->input->post('trainer_class_id'),
			'attend' =>  $this->input->post('attend'),
			'sesi' =>  $this->input->post('sesi'),
			'student_id' =>  $this->input->post('student_id')
		);
		
		$url = api_url('rc/Absensiapi/api_post_presence');

			$absen = optimus_curl('POST', $url, $data);
			if($absen != ""){
				$data['message'] = "Data didapatkan";
				$data['status'] = "200";
			}else{
				$data['status'] = "300";
			}

			return (array)$absen;
	}

	public function add_presence(){
		$data = array(
			'url' => $this->input->post('url'),
			'trainer_class_id' =>  $this->input->post('trainer_class_id'),
			'attend' =>  $this->input->post('attend'),
			'sesi' =>  $this->input->post('sesi'),
			'student_id' =>  $this->input->post('student_id')
		);
		
		$url = api_url('rc/Absensiapi/api_post_presence');

			$absen = optimus_curl('POST', $url, $data);
			if($absen != ""){
				$data['message'] = "Data didapatkan";
				$data['status'] = "200";
			}else{
				$data['status'] = "300";
			}	
		
			if($absen){
				$this->api_presence();
				flashdata('success', 'Berhasil menambahkan data');
			}else{
				flashdata('error', 'Gagal menambahkan data');
			}
		redirect(base_url('rc/absensi/sesi/'.$this->input->post('trainer_class_id').'/'.$this->input->post('sesi').'?'.$url));
	}

	public function submit_rekap(){
		$post = $this->input->post();
		if(empty($post['recap_id'])){
 			# insert statement
 			$insert['periode_detail_id'] 	= $post['periode_detail_id'];
 			$insert['branch_id'] 		 	= $post['branch_id'];
 			$insert['program_id'] 			= $post['program_id'];
 			$insert['class_id'] 			= $post['class_id'];
 			$insert['session'] 				= $post['session'];
 			$insert['other_class'] 			= $post['other_class'];
 			$insert['bonus_class'] 			= $post['bonus_class'];
 			$insert['attendance'] 			= $post['attendance'];
 			$insert['total_attendance'] 	= $post['total_attendance'];
 			$insert['recap_notes'] 			= $post['recap_notes'];
 			$insert['input_by'] 			= $this->session->userdata('id');
 			$insert['timestamp'] 			= setNewDateTime();
 			$result = $this->model_absensi->insert_recap($insert);
 			if($result){
				flashdata('success', 'Berhasil menambahkan data');
			}else{
				flashdata('error', 'Gagal menambahkan data');
			}
		}else{
			# update statement
			$update['other_class'] 			= $post['other_class'];
 			$update['bonus_class'] 			= $post['bonus_class'];
 			$update['attendance'] 			= $post['attendance'];
 			$update['total_attendance'] 	= $post['total_attendance'];
 			$update['recap_notes'] 			= $post['recap_notes'];
 			$update['timestamp'] 			= setNewDateTime();
 			$result = $this->model_absensi->update_recap($update, $post['recap_id']);
 			if($result){
				flashdata('success', 'Berhasil mengubah data');
			}else{
				flashdata('error', 'Gagal mengubah data');
			}
		}
		redirect(base_url('rc/absensi/sesi/'.$post['trainer_class_id'].'/'.$post['session'].'?'.$post['url']));
	}

	public function json_remove_absen(){
		$id 		= $this->input->post('id');
		$response 	= $this->model_absensi->delete($id);
		$this->model_absensi->delete_change_to($id);
		if($response){
			flashdata('success', 'Berhasil menghapus data');
		}else{
			flashdata('error', 'Gagal mengubah data');
		}
		echo json_encode($response);
	}


	public function json_get_detail_classroom(){
		$id 		= $this->input->post('id');
		$response	= $this->model_trainer->get_data($id);
		echo json_encode($response);
	}
	
	public function json_get_other_class(){
		$post = $this->input->post();
		$response = $this->model_absensi->get_student_class($post['branch_id'], $post['program_id'], $post['class_id'], $post['periode_start_date'], $post['periode_end_date'], $post['is_adult_class']);
		echo json_encode($response);
	}

	public function json_get_detail_student(){
		$id = $this->input->post('id');
		$response = $this->model_student->get_data($id);
		echo json_encode($response);
	}

	public function add_to_class(){
		$post = $this->input->post();
		$student = $this->model_student->get_data($post['student_id']);
		# Insert ke kelas yg dia hadiri
		$insert2 = array(
			'periode_detail_id' => $post['periode_detail_id'],
			'branch_id' 		=> $post['branch_id_change'],
			'program_id' 		=> $post['program_id'],
			'class_id' 			=> $post['class_id_change'],
			'student_id' 		=> $post['student_id'],
			'session' 			=> $post['session'],
			'is_attend' 		=> 1,
			'is_change' 		=> 1,
			'branch_id_from'  	=> $student['branch_id'],
			'class_id_from' 	=> $student['class_id'],
			'input_by' 			=> $this->session->userdata('id'),
			'timestamp' 		=> setNewDateTime()
				);
		$result2 = $this->model_absensi->insert($insert2);
		$change_id = $this->db->insert_id();

		# Insert ke kelas asalnya
		$insert1 = array(
			'periode_detail_id' => $post['periode_detail_id'],
			'branch_id' 		=> $post['branch_id'],
			'program_id' 		=> $post['program_id'],
			'class_id' 			=> $post['class_id'],
			'student_id' 		=> $post['student_id'],
			'session' 			=> $post['session'],
			'is_attend' 		=> 2,
			'input_by' 			=> $this->session->userdata('id'),
			'timestamp' 		=> setNewDateTime(),
			'is_change' 		=> 1,
			'change_to' 		=> $change_id,
			'branch_id_change'  => $post['branch_id_change'],
			'class_id_change' 	=> $post['class_id_change']
				);
		$result1 = $this->model_absensi->insert($insert1);

		if($result1){
			flashdata('success', 'Berhasil menyimpan data');
		}else{
			flashdata('error', 'Gagal mengubah data');
		}
		echo json_encode($result1);
	}

}