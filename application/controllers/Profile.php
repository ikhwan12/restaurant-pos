<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends MY_Controller {

	function  __construct() {
                parent::__construct();
                $this->load->model('Profile_M', 'profile');
                }
                
	public function index()
	{
                $this->get_menu();
                $data['title1'] = "Profile";
		$this->load->view('profile', $data);
		$this->load->view('footer');
                
	}
        
        function detail2(){
            $detail = $this->profile->detail2();
            echo json_encode($detail);
        }
        
        function update_detail(){
             $data = array(
                    'nama' => $this->normalize_text(('nama')),
                    'alamat' => $this->normalize_text(('alamat')),
                    'no_telp' => $this->input->post('no_telp'),
                 );
             $status = $this->profile->update('username', $this->session->userdata('username'), $data);
             redirect('profile');
        }
        
        function update_password(){
             $data = array(
                 'password' => password_hash($this->input->post('v_pass'), PASSWORD_BCRYPT),
             );
             $status = $this->profile->update('username', $this->session->userdata('username'), $data);
             redirect('profile');
        }
        
        
        
}
