<?php
	defined('BASEPATH') OR exit('No direct script access allowed'); 

	class Student extends CI_Controller {
		
		public function __construct(){
			parent::__construct();
			$this->load->model('model_branch');
			$this->load->model('model_periode');
			$this->load->model('model_classroom');
			$this->load->model('model_absensi');
			$this->load->model('model_student');
			$this->load->model('model_signup');
		} 
		
		public function _remap($method, $param = array()){
			if(method_exists($this, $method)){
				$level = $this->session->userdata('level');
				if(!empty($level) && (strpos($this->session->userdata('divisi'), 'MRLC') !== false || ($this->session->userdata('id') == '32') || ($this->session->userdata('id') == '190') || ($this->session->userdata('id') == '72') || ($this->session->userdata('id') == '128'))){
					return call_user_func_array(array($this, $method), $param);
				}else{
					redirect(base_url('login'));				
				}
			}else{
				display_404();
			}
		}


		public function manage_as_spv(){
			$data = array(
				'is_spv' => $this->session->userdata('is_spv'),
				'id' => $this->session->userdata('id'),
				'divisi' => $this->session->userdata('divisi'),
				'is_spv' => $this->session->userdata('is_spv'),
				'input' => $this->input->get(),
				'periode' => $this->input->get('periode')
			);
			
			$url = api_url('rc/Studentapi/manage_as_spv');

				$manage = optimus_curl('POST', $url, $data);
				if($manage){
					$data['message'] = "Data dinonaktifkan";
					$data['status'] = "200";
				}else{
					$data['status'] = "300";
				}	

				return (array)$manage;
		}

		public function manage_as_trainer(){
			$data = array(
				'is_spv' => $this->session->userdata('is_spv'),
				'id' => $this->session->userdata('id'),
				'divisi' => $this->session->userdata('divisi'),
				'is_spv' => $this->session->userdata('is_spv'),
				'input' => $this->input->get(),
				'periode' => $this->input->get('periode')
			);
			
			$url = api_url('rc/Studentapi/manage_as_trainer');

				$manage = optimus_curl('POST', $url, $data);
				if($manage){
					$data['message'] = "Data dinonaktifkan";
					$data['status'] = "200";
				}else{
					$data['status'] = "300";
				}	

				return (array)$manage;
		}

		public function manage_as_spv_adult(){
			$data = array(
				'is_spv' => $this->session->userdata('is_spv'),
				'id' => $this->session->userdata('id'),
				'divisi' => $this->session->userdata('divisi'),
				'is_spv' => $this->session->userdata('is_spv'),
				'input' => $this->input->get(),
				'periode' => $this->input->get('periode')
			);
			
			$url = api_url('rc/Studentapi/manage_as_spv_adult');

				$manage = optimus_curl('POST', $url, $data);
				if($manage){
					$data['message'] = "Data dinonaktifkan";
					$data['status'] = "200";
				}else{
					$data['status'] = "300";
				}	

				return (array)$manage;
		}

		public function manage_as_trainer_adult(){
			$data = array(
				'is_spv' => $this->session->userdata('is_spv'),
				'id' => $this->session->userdata('id'),
				'divisi' => $this->session->userdata('divisi'),
				'is_spv' => $this->session->userdata('is_spv'),
				'input' => $this->input->get(),
				'periode' => $this->input->get('periode')
			);
			
			$url = api_url('rc/Studentapi/manage_as_trainer_adult');

				$manage = optimus_curl('POST', $url, $data);
				if($manage){
					$data['message'] = "Data dinonaktifkan";
					$data['status'] = "200";
				}else{
					$data['status'] = "300";
				}	

				return (array)$manage;
		}


		public function manage(){
			if($this->session->userdata('is_spv') == true && strpos($this->session->userdata('divisi'), 'MRLC') !== false || ($this->session->userdata('id') == '32') || ($this->session->userdata('id') == '190') || ($this->session->userdata('id') == '72') || ($this->session->userdata('id') == '128')){
				# as supervisor
				$data['periode'] 		= $this->manage_as_spv()['periode'] ;
				$data['list_branch'] 	= $this->manage_as_spv()['list_branch'] ;
				$data['school'] 		= $this->manage_as_spv()['school'] ;
				$data['class'] 			= $this->manage_as_spv()['class'] ;
				$data['list'] 			= $this->manage_as_spv()['list'] ;
				$data['status'] 		= array("Active", "Need to upgrade", "Graduate soon", "Dropout", "Graduated");
				$data['type'] 			= array("modul", "full program");
				$data['special'] 		= array("None", "Special Case", "Free");
				$data['tab'] 			= 'regular';

				$data['list_warrior'] 		= $this->manage_as_spv()['list_warrior'] ;
				$data['list_signup_type']	= array('SP', 'PTM', 'Others');
				$data['list_closing_class'] = array('modul', 'full program');
				$data['list_source'] 		= array('Facebook Ads', 'WI/CI', 'Email Blast', 'Referral', 'Others');
				$data['list_payment_type'] 	= array('EDC', 'Transfer', 'Cash', 'Others');
				$jsonstat = json_encode($data);
				$datas = json_decode($jsonstat, true );
				set_active_menu('student');
				init_view('rc/student_manage_spv', $datas);
			}else{
				# as trainer
				$data['periode'] 		= $this->manage_as_trainer()['periode'] ;
				$data['school'] 		= $this->manage_as_trainer()['school'] ;
				$data['class'] 			= $this->manage_as_trainer()['class'] ;
				$data['status'] 		= array("Active", "Need to upgrade", "Graduate soon", "Dropout", "Graduated");
				$data['type'] 			= array("modul", "full program");
				$data['tab'] 			= 'regular';
				$data['list'] 			= $this->manage_as_trainer()['list'] ;
				$jsonstat = json_encode($data);
				$datas = json_decode($jsonstat, true );
				set_active_menu('student');
				init_view('rc/student_manage', $datas);
			}
			
		
		}

		public function manage_adult(){
			if($this->session->userdata('is_spv') == true && strpos($this->session->userdata('divisi'), 'MRLC') !== false || ($this->session->userdata('id') == '32') || ($this->session->userdata('id') == '190') || ($this->session->userdata('id') == '72') || ($this->session->userdata('id') == '128')){
				# as supervisor
				$data['periode'] 		= $this->manage_as_spv()['periode'] ;
				$data['list_branch'] 	= $this->manage_as_spv()['list_branch'] ;
				$data['school'] 		= $this->manage_as_spv()['school'] ;
				$data['class'] 			= $this->manage_as_spv()['class'] ;
				$data['list'] 			= $this->manage_as_spv()['list'] ;
				$data['status'] 		= array("Active", "Need to upgrade", "Graduate soon", "Dropout", "Graduated");
				$data['type'] 			= array("modul", "full program");
				$data['special'] 		= array("None", "Special Case", "Free");
				$data['tab'] 			= 'adult';

				$data['list_warrior'] 		= $this->manage_as_spv()['list_warrior'] ;
				$data['list_signup_type']	= array('SP', 'PTM', 'Others');
				$data['list_closing_class'] = array('modul', 'full program');
				$data['list_source'] 		= array('Facebook Ads', 'WI/CI', 'Email Blast', 'Referral', 'Others');
				$data['list_payment_type'] 	= array('EDC', 'Transfer', 'Cash', 'Others');
				$jsonstat = json_encode($data);
				$datas = json_decode($jsonstat, true );
				set_active_menu('student');
				init_view('rc/student_manage_adult_spv', $datas);
			}else{
				# as trainer
				$data['periode'] 		= $this->manage_as_trainer()['periode'] ;
				$data['school'] 		= $this->manage_as_trainer()['school'] ;
				$data['class'] 			= $this->manage_as_trainer()['class'] ;
				$data['status'] 		= array("Active", "Need to upgrade", "Graduate soon", "Dropout", "Graduated");
				$data['type'] 			= array("modul", "full program");
				$data['tab'] 			= 'adult';
				$data['list'] 			= $this->manage_as_trainer()['list'] ;
				$jsonstat = json_encode($data);
				$datas = json_decode($jsonstat, true );
				set_active_menu('student');
				init_view('rc/student_manage_adult', $datas);
			}
		
		}

		public function submission_api_spv(){
			$data = array(
				'is_spv' => $this->session->userdata('is_spv'),
				'id' => $this->session->userdata('id'),
				'divisi' => $this->session->userdata('divisi')
			);
			
			$url = api_url('rc/Studentapi/submission_spv');

				$subm = optimus_curl('POST', $url, $data);
				if($subm){
					$data['message'] = "Data dinonaktifkan";
					$data['status'] = "200";
				}else{
					$data['status'] = "300";
				}	

				return (array)$subm;
		}

		public function submission_api_trainer(){
			$data = array(
				'is_spv' => $this->session->userdata('is_spv'),
				'id' => $this->session->userdata('id'),
				'divisi' => $this->session->userdata('divisi')
			);
			
			$url = api_url('rc/Studentapi/submission_trainer');

				$subm = optimus_curl('POST', $url, $data);
				if($subm){
					$data['message'] = "Data dinonaktifkan";
					$data['status'] = "200";
				}else{
					$data['status'] = "300";
				}	

				return (array)$subm;
		}


		public function submission(){
			if($this->session->userdata('is_spv') == true && strpos($this->session->userdata('divisi'), 'MRLC') !== false || ($this->session->userdata('id') == '32') || ($this->session->userdata('id') == '190') || ($this->session->userdata('id') == '72') || ($this->session->userdata('id') == '128')){
				# as supervisor
				$data['list'] = $this->submission_api_spv()['list'] ;
				$jsonstat = json_encode($data);
				$datas = json_decode($jsonstat, true );
				set_active_menu('submission');
				init_view('rc/student_submission_spv', $datas);
			}else{
				# as trainer
				$data['list'] = $this->submission_api_trainer()['list'] ;
				$jsonstat = json_encode($data);
				$datas = json_decode($jsonstat, true );
				set_active_menu('submission');
				init_view('rc/student_submission', $datas);
			}
		}

		public function submission_add_api(){
			$data = array(
				'get' => $this->input->get(),
				'id' => $this->session->userdata('id'),
				'periode' => $this->input->get('periode'),
				'branch' => $this->input->get('branch'),
				'school' => $this->input->get('school'),
				'class' => $this->input->get('class')
			);
			
			$url = api_url('rc/Studentapi/submission_add');

				$subm = optimus_curl('POST', $url, $data);
				if($subm){
					$data['message'] = "Data berhasil diubah";
					$data['status'] = "200";
				}else{
					$data['status'] = "300";
				}	
			
				return $subm;
		}

		public function submission_add(){
			$data['periode'] 		= $this->submission_add_api();
			$data['branch'] 		= $this->submission_add_api();
			$data['list_branch'] 	= $this->submission_add_api();
			$data['school'] 		= $this->submission_add_api();
			$data['class'] 			= $this->submission_add_api();
			$data['list'] 			= $this->submission_add_api();
			$jsonstat = json_encode($data);
			$datas = json_decode($jsonstat, true);
			$data['periode'] 		= $datas['periode']['periode'];
			$data['branch'] 		= $datas['periode']['branch'];
			$data['list_branch'] 	= $datas['periode']['list_branch'];
			$data['school'] 		= $datas['periode']['school'];
			$data['class'] 			= $datas['periode']['class'];
			$data['list'] 			= $datas['periode']['list'];
			// dd($datas['periode']['list_branch']);
			// die();
			set_active_menu('submission');
			init_view('rc/student_submission_add', $data);
		}

		public function submission_add_api_adult(){
			$data = array(
				'get' => $this->input->get(),
				'id' => $this->session->userdata('id'),
				'periode' => $this->input->get('periode'),
				'branch' => $this->input->get('branch'),
				'school' => $this->input->get('school'),
				'class' => $this->input->get('class')
			);
			
			$url = api_url('rc/Studentapi/submission_adult_add');

				$subm = optimus_curl('POST', $url, $data);
				if($subm){
					$data['message'] = "Data berhasil diubah";
					$data['status'] = "200";
				}else{
					$data['status'] = "300";
				}	
			
				return $subm;
		}

		public function submission_add_adult(){
			$data['periode'] 		= $this->submission_add_api_adult();
			$data['branch'] 		= $this->submission_add_api_adult();
			$data['list_branch'] 	= $this->submission_add_api_adult();
			$data['school'] 		= $this->submission_add_api_adult();
			$data['class'] 			= $this->submission_add_api_adult();
			$data['list'] 			= $this->submission_add_api_adult();
			$jsonstat = json_encode($data);
			$datas = json_decode($jsonstat, true);
			$data['periode'] 		= $datas['periode']['periode'];
			$data['branch'] 		= $datas['periode']['branch'];
			$data['list_branch'] 	= $datas['periode']['list_branch'];
			$data['school'] 		= $datas['periode']['school'];
			$data['class'] 			= $datas['periode']['class'];
			$data['list'] 			= $datas['periode']['list'];
			// dd($datas['periode']['list_branch']);
			// die();
			set_active_menu('submission');
			init_view('rc/student_submission_adult_add', $data);
		}

		public function submission_adult_add(){
			$data['periode'] 		= $this->model_periode->get_active_periode_adult();
			$data['branch'] 		= $this->model_branch->get_branch_trainer($this->session->userdata('id'));
			$data['list_branch'] 	= $this->model_branch->get_active_branch();
			$data['school'] 		= $this->model_periode->get_program_adult();
			$data['class'] 			= $this->model_classroom->get_active_class_adult();
			if(!empty($this->input->get())){
				if($this->input->get('periode') != ''){
					$periode 			= $this->model_periode->get_data($this->input->get('periode'));
					// dd($periode);
					$data['list'] 		= $this->model_student->get_student_list($periode['periode_start_date'], $periode['periode_end_date'], $this->input->get('branch'), $this->input->get('school'), $this->input->get('class'), 'adult');
				}else{
					$data['list'] 		= $this->model_student->get_student_list('','', $this->input->get('branch'), $this->input->get('school'), $this->input->get('class'), 'adult');
				}
			}else{
				$data['list'] 		= array();
			}
			set_active_menu('submission');
			init_view('rc/student_submission_adult_add', $data);
		}

		public function change_student_api(){
			$data = array(
				'ch_branch_to' => $this->input->post('ch_branch_to'),
				'ch_program_to' => $this->input->post('ch_program_to'),
				'ch_class_to' => $this->input->post('ch_class_to'),
				'ch_student_id' => $this->input->post('ch_student_id'),
				'ch_periode_id' => $this->input->post('ch_periode_id'),
				'ch_periode_id' => $this->input->post('ch_program_from'),
				'ch_class_from' => $this->input->post('ch_class_from'),
			);
			
			$url = api_url('rc/Studentapi/change_student');

				$subm = optimus_curl('POST', $url, $data);
				if($subm){
					$data['message'] = "Data berhasil diubah";
					$data['status'] = "200";
				}else{
					$data['status'] = "300";
				}	
			
				return $subm;
		}

		public function change_student(){
			
			$response 		= $this->change_student_api();
			if($response){
				flashdata('success', 'Berhasil mengubah data');
			}else{
				flashdata('error', 'Gagal mengubah data');
			}
			redirect(base_url('rc/student/manage?'.$this->input->post('ch_redirect')));
		}

		public function submission_submit_api(){
			$data = array(
				'student_id' => $this->input->post('student_id'),
				'periode_id' => $this->input->post('periode_id'),
				'program_from' => $this->input->post('program_from'),
				'branch_from' => $this->input->post('branch_from'),
				'class_from' => $this->input->post('class_from'),
				'branch_to' => $this->input->post('branch_to'),
				'program_to' => $this->input->post('program_to'),
				'class_to' => $this->input->post('class_to'),
				'id' => $this->session->userdata('id'),
			);
			
			$url = api_url('rc/Studentapi/submission_submit');

				$subm = optimus_curl('POST', $url, $data);
				if($subm){
					$data['message'] = "Data berhasil diubah";
					$data['status'] = "200";
				}else{
					$data['status'] = "300";
				}	
			
				return $subm;
		}

		public function submission_submit(){
			$result = $this->submission_submit_api();
			if($result){
				flashdata('success', 'Berhasil menambahkan data pengajuan');
			}else{
				flashdata('error', 'Gagal menambahkan data');
			}

			redirect(base_url('rc/student/submission'));
		}

		public function submit_edit_form_api(){
			$data = array(
				'dad_id' => $this->input->post('dad_id'),
				'dad_name' => $this->input->post('dad_name'),
				'dad_email' => $this->input->post('dad_email'),
				'dad_phone' => $this->input->post('dad_phone'),
				'dad_job' => $this->input->post('dad_job'),
				'mom_id' => $this->input->post('mom_id'),
				'mom_name' => $this->input->post('mom_name'),
				'mom_email' => $this->input->post('mom_email'),
				'mom_phone' => $this->input->post('mom_phone'),
				'mom_job' => $this->input->post('mom_job'),
				'participant_name' => $this->input->post('participant_name'),
				'gender' => $this->input->post('gender'),
				'phone' => $this->input->post('phone'),
				'email' => $this->input->post('email'),
				'birthdate' => $this->input->post('birthdate'),
				'program_type' => $this->input->post('program_type'),
				'start_date' => $this->input->post('start_date'),
				'end_date' => $this->input->post('end_date'),
				'special_status' => $this->input->post('special_status'),
				'special_note' => $this->input->post('special_note'),
				'participant_id' => $this->input->post('participant_id'),
				'student_id' => $this->input->post('student_id'),
			);
			
			$url = api_url('rc/Studentapi/submit_edit_form');

				$subm = optimus_curl('POST', $url, $data);
				if($subm){
					$data['message'] = "Data berhasil diubah";
					$data['status'] = "200";
				}else{
					$data['status'] = "300";
				}	
			
				return $subm;
		}

		public function submit_edit_form(){
			$post = $this->input->post();
			$result = $this->submit_edit_form_api();
			if($result){
				flashdata('success', 'Berhasil mengubah data');
			}else{
				flashdata('error', 'Gagal mengubah data');
			}
			redirect(base_url('rc/student/manage?'.$post['redirect']));
		}

		public function delete_submission_api(){
			$data = array(
				'id' => $this->input->post('id'),
			);
			
			$url = api_url('rc/Studentapi/delete_submission');

				$subm = optimus_curl('POST', $url, $data);
				if($subm){
					$data['message'] = "Data berhasil diubah";
					$data['status'] = "200";
				}else{
					$data['status'] = "300";
				}	
			
				return $subm;
		}

		public function delete_submission(){
			$response	= $this->delete_submission_api();
			if($response){
				flashdata('success', 'Berhasil menghapus data');
			}else{
				flashdata('error', 'Gagal mengubah data');
			}
			echo json_encode($response);
		}

		public function approve_submission_api(){
			$data = array(
				'id' => $this->input->post('id'),
			);
			
			$url = api_url('rc/Studentapi/approve_submission');

				$subm = optimus_curl('POST', $url, $data);
				if($subm){
					$data['message'] = "Data berhasil diubah";
					$data['status'] = "200";
				}else{
					$data['status'] = "300";
				}	
			
				return $subm;
		}

		public function approve_submission(){
			$response	= $this->approve_submission_api();
			if($response){
				flashdata('success', 'Berhasil mengubah data');
			}else{
				flashdata('error', 'Gagal mengubah data');
			}
			echo json_encode($response);
		}

		public function submit_upgrade_student_api(){
			$data = array(
				'post' => $this->input->post(),
				'student_id' => $this->input->post('student_id'),
				'program_id' => $this->input->post('program_id'),
				'program' => $this->input->post('program'),
				'price' => $this->input->post('price'),
				'signup_type' => $this->input->post('signup_type'),
				'source' => $this->input->post('source'),
				'payment_type' => $this->input->post('payment_type'),
				'atas_nama' => $this->input->post('atas_nama'),
				'paid_value' => $this->input->post('paid_value'),
				'paid_date' => $this->input->post('paid_date'),
				'closing_type' => $this->input->post('closing_type'),
				'remark' => $this->input->post('remark'),
				'modul_class' => $this->input->post('modul_class'),
				'full_program_startdate' => $this->input->post('full_program_startdate'),
				'full_program_enddate' => $this->input->post('full_program_enddate'),
				'branch_id' => $this->input->post('branch_id'),
				'class_id' => $this->input->post('class_id'),
				'id_user_closing' => $this->input->post('id_user_closing'),
				'id' => $this->session->userdata('id')
			);
			
			$url = api_url('rc/Studentapi/submit_upgrade_student');

				$subm = optimus_curl('POST', $url, $data);
				if($subm){
					$data['message'] = "Data berhasil diubah";
					$data['status'] = "200";
				}else{
					$data['status'] = "300";
				}	
			
				return $subm;
		}

		public function submit_upgrade_student(){
			$post = $this->input->post();
			$result2 = $this->submit_upgrade_student_api();
			if($result2){
				flashdata('success', 'Berhasil mengubah data');
			}else{
				flashdata('error', 'Gagal mengubah data');
			}
			redirect(base_url('rc/student/manage?'.$post['url']));
		}


		public function export_data_student(){
			$periode	= $this->model_periode->get_data($this->input->get('periode'));
			$data 		= $this->model_student->get_filtered_student_export($this->input->get(), $periode['periode_start_date'], $periode['periode_end_date'], 'regular');
			$filename 	= "Data Student - ".strtotime(setNewDateTime());
			exportToExcel($data, 'Sheet 1', $filename);
		}

		public function export_data_student_adult(){
			$periode	= $this->model_periode->get_data($this->input->get('periode'));
			$data 		= $this->model_student->get_filtered_student_export($this->input->get(), $periode['periode_start_date'], $periode['periode_end_date'], 'adult');
			$filename 	= "Data Student - ".strtotime(setNewDateTime());
			exportToExcel($data, 'Sheet 1', $filename);
		}

		public function delete_student_api(){
			$data = array(
				'id' => $this->input->post('id'),
			);
			
			$url = api_url('rc/Studentapi/delete_student');

				$subm = optimus_curl('POST', $url, $data);
				if($subm){
					$data['message'] = "Data berhasil diubah";
					$data['status'] = "200";
				}else{
					$data['status'] = "300";
				}	
			
				return $subm;
		}

		public function delete_student(){
			$response	= $this->delete_student_api();
			if($response){
				flashdata('success', 'Berhasil menghapus data');
			}else{
				flashdata('error', 'Gagal mengubah data');
			}
			echo json_encode($response);
		}

		public function reject_submission_api(){
			$data = array(
				'id' => $this->input->post('id'),
			);
			
			$url = api_url('rc/Studentapi/reject_submission');

				$subm = optimus_curl('POST', $url, $data);
				if($subm){
					$data['message'] = "Data berhasil diubah";
					$data['status'] = "200";
				}else{
					$data['status'] = "300";
				}	
			
				return $subm;
		}

		public function reject_submission(){
			$response	= $this->reject_submission_api();
			if($response){
				flashdata('success', 'Berhasil mengubah data');
			}else{
				flashdata('error', 'Gagal mengubah data');
			}
			echo json_encode($response);
		}

		public function json_get_detail_student(){
			$data = array(
				'id' => $this->input->post('id'),
			);
			
			$url = api_url('rc/Studentapi/json_get_detail_student');

				$subm = optimus_curl('POST', $url, $data);
				if($subm){
					$data['message'] = "Data berhasil diubah";
					$data['status'] = "200";
				}else{
					$data['status'] = "300";
				}	
			
			echo json_encode($subm);
		}

		public function json_get_detail_student_upgrade(){
			$data = array(
				'id' => $this->input->post('id'),
			);
			
			$url = api_url('rc/Studentapi/json_get_detail_student_upgrade');

				$subm = optimus_curl('POST', $url, $data);
				if($subm){
					$data['message'] = "Data berhasil diubah";
					$data['status'] = "200";
				}else{
					$data['status'] = "300";
				}	
			
			echo json_encode($subm);
		}

		public function json_remove_trainer(){
			$data = array(
				'id' => $this->input->post('id'),
			);
			
			$url = api_url('rc/Studentapi/json_remove_trainer');

				$subm = optimus_curl('POST', $url, $data);
				if($subm){
					$data['message'] = "Data berhasil diubah";
					$data['status'] = "200";
				}else{
					$data['status'] = "300";
				}	
			
			if($subm){
				flashdata('success', 'Berhasil menghapus data');
			}else{
				flashdata('error', 'Gagal mengubah data');
			}
			echo json_encode($subm);
		}

		public function json_get_history_trx(){
			$data = array(
				'id' => $this->input->post('id'),
			);
			
			$url = api_url('rc/Studentapi/json_get_history_trx');

				$subm = optimus_curl('POST', $url, $data);
				if($subm){
					$data['message'] = "Data berhasil diubah";
					$data['status'] = "200";
				}else{
					$data['status'] = "300";
				}	
			
			echo json_encode($subm);
		}

		public function json_get_data_participant_by_id(){
			$data = array(
				'id' => $this->input->post('id'),
			);
			
			$url = api_url('rc/Studentapi/json_get_data_participant_by_id');

				$subm = optimus_curl('POST', $url, $data);
				if($subm){
					$data['message'] = "Data berhasil diubah";
					$data['status'] = "200";
				}else{
					$data['status'] = "300";
				}	
			
			echo json_encode($subm);
		}
		
	}
