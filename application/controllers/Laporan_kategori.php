<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan_kategori extends MY_Controller {

	function  __construct() {
                parent::__construct();
                    $this->load->model('Perkategori_M', 'pk');
                }
                
	public function index()
	{
            $this->get_menu();
            $data['title1'] = 'Laporan Per Kategori';
            $this->load->view('laporan/perkategori', $data);
            $this->load->view('footer');
	}
        
        public function view($start ="", $end = "", $id_outlet = ""){
            if($start == "" && $end == ""){
                $start = $end = date("Y-m-d");
            }
            $list = $this->pk->getReport($start, $end, $id_outlet);
            $data = array();
            foreach ($list as $item){
                $row = array();
                $row[] = $item->kategori;        
                $row[] = $item->jumlah;  
                $row[] = number_format($item->total,0,',','.');   
                $row[] = number_format($item->total/$item->jumlah,0,',','.');   
                $data[] = $row;
            }
            echo json_encode($data);
        }
        
}
