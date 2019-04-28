<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Analisa_penjualan extends MY_Controller {

	function  __construct() {
                parent::__construct();
                    $this->load->model('Analisa_Penjualan_M', 'am');
                }
                
	public function index($param="")
	{
                    $this->get_menu();
                    if($param=='hari'){
                        $data['title1'] = 'Analisa Penjualan Per Hari';
                        $this->load->view('laporan/analisa_penjualan_hari', $data);
                    }else if($param=='jam'){
                        $data['title1'] = 'Analisa Penjualan Per jam';
                        $this->load->view('laporan/Analisa_penjualan_jam', $data);
                    }else{
                        $this->load->view('404_not_found');
                    }
                    $this->load->view('footer');
	}
        
        public function view_hari($start = "", $end = "", $outlet = ""){
            if($start == "" && $end == "" ){
                $start = $end = date("Y-m-d");
            }
            $list = $this->am->get_data_hari($start, $end, $outlet);
            $data = array();
            foreach ($list as $item){
                $row = array();
                $row[] = $item->tanggal;        
                $row[] = $item->jumlah;
                $row[] = number_format($item->total,0,',','.');
                $row[] = number_format($item->total/$item->jumlah,0,',','.');      
                $data[] = $row;
            }
            echo json_encode($data);
        }
          public function view_jam($start = "", $end = "", $outlet = ""){
            if($start == "" && $end == "" ){
                $start = $end = date("Y-m-d");
            }
            $list = $this->am->get_data_jam($start, $end, $outlet);
            $data = array();
            foreach ($list as $item){
                $row = array();
                if(strlen($item->hour) < 2){
                    $row[] = '0'.$item->hour.':00';  
                }else{
                    $row[] = $item->hour.':00';;  
                }
                      
                $row[] = $item->jumlah;
                $row[] = number_format($item->total,0,',','.');
                $row[] = number_format($item->total/$item->jumlah,0,',','.');      
                $data[] = $row;
            }
            echo json_encode($data);
        }
        
     
        
        
}
