<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	function  __construct() {
            parent::__construct();
            
                $this->load->helper('url');
                $this->load->model('Login_M', 'login');
                $this->load->model('Setup_M', 'setup');
                $this->load->library('session');
            }
                
	public function index()
	{
            if((file_exists(APPPATH."config/config.txt") && trim(file_get_contents(APPPATH."config/config.txt")) != false)
                    && $this->setup->check_act_license() && $this->setup->check_registration()){
                if($this->session->userdata('suprek_logged_in')){
                    redirect('dashboard');
                }else{
                    $data['title'] = "Mr. Suprek";
                    $this->load->view('login', $data);
                }
            }else{
                redirect('setup');
            }
            
	}
        public function check_login(){
        
                extract($_POST);
                $data = $this->login->check_login($username, $password);

                if(! $data)
                {
                    $this->session->set_flashdata('login_error', 'TRUE');
                    redirect('login');

                }
                else
                {
                    $this->session->set_userdata(array(
                                                    'suprek_logged_in'=> TRUE,
                                                    'username'=> $data['username'],
                                                    'nama'=> $data['nama'],
                                                    'posisi'=> $data['id_posisi'],
                                                    'outlet'=> $data['id_outlet'],
                                                    'order'=> '',
                                                    ));
                    
                       redirect('dashboard');

                }
           
        }
        
        function logout(){
            //if($this->session->userdata('logged_in')){
                if($this->session->userdata('order') != ''){
                    $this->login->delete_order($this->session->userdata('order'));
                }
                $this->login->set_login_status($this->session->userdata('username'), 0);
                $this->session->sess_destroy();
                redirect('login');
            //}
            
        }
       
}
