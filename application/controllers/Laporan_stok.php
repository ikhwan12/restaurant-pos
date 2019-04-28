<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan_stok extends MY_Controller {

	function  __construct() {
                parent::__construct();
                    $this->load->model('Laporan_Stok_M', 'lsm');
                }
                
	public function index()
	{
            $this->get_menu();
            $data['title1'] = 'Laporan Stok';
            $this->load->view('laporan/laporan_stok', $data);
            $this->load->view('footer');
	}
        
        public function view($id_outlet = ""){
            $list = $this->lsm->getStok($id_outlet);
            $data = array();
            foreach ($list as $item){
                $row = array();
                $row[] = $item->kategori;        
                $row[] = $item->menu;
                $row[] = number_format($item->stok,2,',','.');   
                $row[] = $item->satuan;
                $data[] = $row;
            }
            echo json_encode($data);
        }
        
}
