<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pengaturan extends MY_Controller {

	function  __construct() {
                parent::__construct();
                $this->load->model('Pengaturan_M', 'pengaturan');
                }
                
	public function index()
	{
                $this->get_menu();
                $data['title1'] = "Pengaturan";
		$this->load->view('pengaturan', $data);
		$this->load->view('footer');
                
	}
        
        function detail(){
            $detail = $this->pengaturan->detail_pengaturan();
            echo json_encode($detail);
        }
        
        function update(){
             $data = array(
                'printer' => $this->input->post('printer'),
             );
             $status = $this->pengaturan->update('id_outlet', $this->session->userdata('outlet'), $data);
             redirect('pengaturan');
        }
        
}
