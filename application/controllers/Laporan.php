<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan extends MY_Controller {

	function  __construct() {
                parent::__construct();
                    $this->load->model('Menu_M', 'menu');
                }
                
	public function index()
	{
                $this->get_menu();
                $data['title1'] = 'Laporan';
                $data['tile_modul'] = $this->menu->get_data_tile_modul();
		$this->load->view('data', $data);
		$this->load->view('footer');
	}
        
        
        
}
