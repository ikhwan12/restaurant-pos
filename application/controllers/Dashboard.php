<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends MY_Controller {

	function  __construct() {
                parent::__construct();
                    $this->load->model('Dashboard_M', 'dash');
                }
                
	public function index()
	{
                
                $this->get_menu();
                $data['isChange'] = $this->dash->isPassChanged();
		$this->load->view('dashboard', $data);
		$this->load->view('footer');
                
	}
        
        
}
