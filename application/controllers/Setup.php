<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Setup extends CI_Controller {

	function  __construct() {
            parent::__construct();
                $this->load->model('Setup_M', 'setup');
                $this->load->model('Activation_M', 'act');
                $this->load->model('Posisi_M', 'posisi');
            }
                
	public function index()
	{
            if((file_exists(APPPATH."config/config.txt") && trim(file_get_contents(APPPATH."config/config.txt")) != false)
                    && $this->setup->check_act_license() && $this->setup->check_registration()){
                redirect('login');
            }else{
                $data['title'] = "Setup Aplikasi Kasir";
                $this->load->view('setup', $data);
            }
	}
        
        function cek_setup_status(){
            $db_config = $activation = $registration  = FALSE;
            if(file_exists(APPPATH."config/config.txt") && trim(file_get_contents(APPPATH."config/config.txt")) != FALSE){
                $db_config = TRUE;
            }
            if($db_config == TRUE && $this->setup->check_act_license()){
                $activation = TRUE;
            }
            if($db_config == TRUE && $activation == TRUE && $this->setup->check_registration()){
                $registration = TRUE;
            }
            echo json_encode(array(
                'db_config' => $db_config,
                'activation' => $activation,
                'registration' => $registration
            ));
        }
                
        function saveDBConfig(){
            $conn = $this->setup->check_connection($this->input->post('host'), $this->input->post('username'), $this->input->post('password'), $this->input->post('database'));
            if($conn['status'] == FALSE){
                echo json_encode(array(
                    'status' => $conn['status'],
                    'message' => $conn['message']
                        ));
            }else{
                $myfile = fopen(APPPATH."config/config.txt", "w");
                $txt = 'hostname = "'.$this->input->post('host').'"'."\n";
                $txt .= 'username = "'.$this->input->post('username').'"'."\n";
                $txt .= 'password = "'.$this->input->post('password').'"'."\n";
                $txt .= 'database = "'.$this->input->post('database').'"'."\n";
                $writed = fwrite($myfile, $txt);
                if($writed == FALSE){
                    $status = FALSE;
                }else{
                    $status = $this->setup->create_database($this->input->post('host'), $this->input->post('username'), $this->input->post('password'), $this->input->post('database'));
                    if($status){
                        $status = $this->setup->first_migration($this->input->post('host'), $this->input->post('username'), $this->input->post('password'), $this->input->post('database'));
                    }
                }
                fclose($myfile);
                echo json_encode(array('status' => $status));
            }
        }
        
        function activate(){
            $status = $this->setup->activate();
            if($status){
                $status = $this->setup->activated_migration();
                $status = $this->add_posisi();
            }
            echo json_encode(array('status' => $status));
        }
        
        function daftar_posisi(){
            $list = $this->setup->get_list_posisi('id_posisi', 'posisi', "Pilih Posisi...");
            echo json_encode($list);
        }
        
        public function add_posisi(){
            $data = array(
                'posisi' => "Admin"
            );
            $inserted = $this->setup->add_posisi($data);
            if($inserted){
                $this->setup->add_first_akses_modul('Admin');
            }
            return $inserted;
        }
        
         function add_admin(){
                $data = array(
                    'username' => $this->input->post('id_user'),
                    'password' => password_hash($this->input->post('user_pass'), PASSWORD_BCRYPT),
                    'nama' =>  ucwords(strtolower($this->input->post('nama'))),
                    'id_posisi' => $this->input->post('id_posisi')
                );
                $inserted = $this->setup->add_admin($data);
                echo json_encode(array('status'=>$inserted)); 
        }
        
         function generateID(){
             if($this->setup->cek_table_pengguna()){
                redirect('login');
            }else{
                $detail = $this->setup->generateID($this->input->post('posisi'));
                echo json_encode($detail);
            }
        }
        
       
}
