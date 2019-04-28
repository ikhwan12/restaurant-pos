<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Transaksi_lain extends MY_Controller {

	public function index(){
                $this->get_menu();
		$this->load->view('under_construction');
		$this->load->view('footer');
	}
        
        
}
