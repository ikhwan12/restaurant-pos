<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Rekap_kas extends MY_Controller {

	function  __construct() {
                parent::__construct();
                    $this->load->model('Laporan_Kas_M', 'lkm');
                }
                
	public function index()
	{
            $this->get_menu();
            $data['title1'] = 'Rekapitulasi Kas';
            $this->load->view('laporan/rekapitulasi_kas', $data);
            $this->load->view('footer');
	}
        
        public function view($start ="", $end = "", $id_outlet = ""){
            if($start == "" && $end == ""){
                $start = $end = date("Y-m-d");
            }
            $list = $this->lkm->getRekap($start, $end, $id_outlet);
            $data = array();
            foreach ($list as $item){
                $row = array();
                $row[] = $item->tgl;        
                $row[] = $item->nama_outlet;
                $row[] = number_format($item->real_tunai,0,',','.');  
                $row[] = number_format($item->real_kartu,0,',','.');  
                $row[] = number_format($item->tunai+$item->kartu,0,',','.');  
                $row[] = number_format($item->kas_masuk,0,',','.');  
                $row[] = number_format($item->kas_keluar,0,',','.');  
                $row[] = number_format(($item->real_tunai+$item->real_kartu)-($item->tunai+$item->kartu+$item->kas_masuk-$item->kas_keluar),0,',','.');  
                $row[] = $item->operator; 
                $data[] = $row;
            }
            echo json_encode($data);
        }
        
}
