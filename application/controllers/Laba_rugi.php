<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laba_rugi extends MY_Controller {

	public function index(){
                $this->get_menu();
		$this->load->view('under_construction');
		$this->load->view('footer');
	}
        
        
}
