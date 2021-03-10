<?php
defined('BASEPATH') OR exit('No direct script access allowed'); 

class Login extends CI_Controller {
	
	public function __construct(){
		parent::__construct();
	} 
	
	public function _remap($method, $param = array()){
		if(method_exists($this, $method)){
			return call_user_func_array(array($this, $method), $param);
		}else{
			display_404();
		}
	}

	private $page_name 		= 'Login';
	private $title 			= 'Please Login, First...';
	private $description 	= 'Welcome to Merry Riana Learning Centre';
	private $keywords 		= 'login, welcome visitor';
	public $credit 			= 'Andy Ajhis Ramadhan';

	public function index(){
		if(!$this->session->userdata('logged_in')){
			// $data['page_name'] = $this->page_name;
			// $data['title'] = $this->title;
			// $data['description'] = $this->description;
			// $data['keywords'] = $this->keywords;
			// $data['credit'] = $this->credit;
			$this->load->helper(array('form'));
			$this->load->view('login2');
		}else{
			redirect(base_url('dashboard'));
		}
	}

	public function auth(){

        $data = array(
            'username' => $this->input->post('user'),
            'password' => $this->input->post('password')
		);
		
        $url = api_url('Login/verification_api');

		$user = optimus_curl('POST', $url, $data);
		
		// echo json_encode($user->results);
		// die;

        if($user->results != 'kosong'){
			$this ->session->set_userdata('id', $user->results->id);
			$this->session->set_userdata('email', $user->results->email);
			$this->session->set_userdata('username', $user->results->username);
			$this->session->set_userdata('birthday', $user->results->birthday);
			$this->session->set_userdata('name', $user->results->name);
			$this->session->set_userdata('picture', $user->results->picture);
			$this->session->set_userdata('anim', $user->results->anime);
			$this->session->set_userdata('signup_privilege', $user->results->signup_privilege);
			$this->session->set_userdata('student_privilege', $user->results->student_privilege);
			$this->session->set_userdata('logged_in', true);
			$this->session->set_userdata('level', $user->results->level);
			$this->session->set_userdata('iddivisi', $user->results->id_divisi);
			$this->session->set_userdata('divisi', $user->results->departement);
			$this->session->set_userdata('branch', $user->results->branch_id);
			$this->session->set_userdata('branch_leader', $user->results->branch_leader);
			if($user->results->id == $user->results->id_user_spv){
				$this->session->set_userdata('is_spv', true);
			}else{
				$this->session->set_userdata('is_spv', false);
			}

			if(!empty($user->results->hr_access_divisi)){
				$this->session->set_userdata('is_hr', true);
				$this->session->set_userdata('is_hr_division', $user->results->hr_access_divisi);
			}else{
				$this->session->set_userdata('is_hr', false);
				$this->session->set_userdata('is_hr_division', false);
			}
			
			if(!empty($user->results->id_pt)){
				$this->session->set_userdata('is_pt', true);
				$this->session->set_userdata('is_id_pt', $user->results->id_pt);
			}else{
				$this->session->set_userdata('is_pt', false);
				$this->session->set_userdata('is_id_pt', false);
			}
            $data['results'] = $user->results;
            $data['message'] = $user->message;
            $data['status'] = $user->status;
        }else{
            $data['results'] = 'kosong';
            $data['message'] = $user->message;
            $data['status'] = $user->status;
        }

        echo json_encode($data);
    }
	
	
}