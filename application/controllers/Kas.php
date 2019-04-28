<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kas extends MY_Controller {

	function  __construct() {
                parent::__construct();
                $this->load->model('Kas_M', 'kas');
                $this->load->model('Outlet_M', 'outlet');
                $this->load->model('Rekapkas_M', 'rkas');
                }
                
	public function index()
	{
                $this->get_menu();
                $detail = $this->outlet->detail('id_outlet', $this->session->userdata('outlet'));
                $data['title1'] = "Kelola Kas";
                $data['outlet'] = $detail->nama_outlet;
		$this->load->view('kas', $data);
		$this->load->view('footer');
	}
	public function printRekap($id)
	{
                $rd = $this->rekapDetail2($id);
                $data = $rd;
                $detail = $this->outlet->detail('id_outlet', $this->session->userdata('outlet'));
                $data['title'] = "Print Rekap Kas";
                $data['id'] = $id;
                $data['outlet'] = "Rekap Kas ".$detail->nama_outlet;
                $data['resume'] = $this->getResume($id);
                $data['detail'] = $this->getDetail($id);
		$this->load->view('printRekap', $data);
	}
        
        public function view($jenis){
            $list = $this->kas->get_table($jenis);
            $data = array();
            foreach ($list as $item){
                $row = array(); 
                $row[] = $item->id_kas;
                $row[] = $item->tgl;
                $row[] = $item->catatan;
                $row[] = number_format($item->jumlah,0,',','.');    
                $row[] = $item->petugas;
                $data[] = $row;
            }
            echo json_encode($data);
        }
        public function view_rekap(){
            $list = $this->rkas->get_table();
            $data = array();
            $no = 0;
            foreach ($list as $item){
                $no++;
                $row = array(); 
                $row[] = $item->id_rekap_kas;
                $row[] = $no;
                $row[] = $item->operator;  
                $row[] = $item->tgl;
                $data[] = $row;
            }
            echo json_encode($data);
        }
        public function view_resume($id = ""){
            if($id != ""){
                $data = array();
                $col1 = array("Tunai","Kartu","Total");
                $list = $this->rkas->get_tableByID($id);
                for ($i=0;$i<sizeof($col1);$i++){
                    $row = array(); 
                    $row[] = $col1[$i];
                    if($i == 0){
                        $row[] = number_format($list->real_tunai,0,",",".");
                        $row[] = number_format($list->tunai+$list->kas_masuk-$list->kas_keluar,0,",",".");
                        $row[] = number_format(($list->real_tunai - ($list->tunai+$list->kas_masuk-$list->kas_keluar)),0,",",".");
                    }else if($i == 1){
                        $row[] = number_format($list->real_kartu,0,",",".");
                        $row[] = number_format($list->kartu,0,",",".");
                        $row[] = number_format(($list->real_kartu - $list->kartu),0,",",".");
                    }else{
                        $row[] = number_format($list->real_tunai + $list->real_kartu,0,",",".");
                        $row[] = number_format($list->tunai+$list->kas_masuk-$list->kas_keluar + $list->kartu,0,",",".");
                        $row[] = number_format(($list->real_tunai - ($list->tunai+$list->kas_masuk-$list->kas_keluar)) + ($list->real_kartu - $list->kartu),0,",",".");
                    }
                    $data[] = $row;
                }
            }else{
                $data = $this->emptyRekap();
            }
            echo json_encode($data);
        }
        
        public function  emptyRekap(){
            $col1 = array("Tunai","Kartu","Total");
            $data = array();
            $no = 0;
            for ($i=0;$i<sizeof($col1);$i++){
                $row = array(); 
                $row[] = $col1[$i];
                $row[] = 0;
                $row[] = 0;
                $row[] = 0;
                $data[] = $row;
            }
            return $data;
        }


        public function view_detail($id = ""){
            if($id != ""){
                $data = array();
                $col1 = array("Kas Masuk","Kas Keluar","Penjualan","Total");
                $list = $this->rkas->get_tableByID($id);
                for ($i=0;$i<  sizeof($col1);$i++){
                    $row = array(); 
                    $row[] = $col1[$i];
                    if($i == 0){
                        $row[] = number_format($list->kas_masuk,0,",",".");
                    }else if($i == 1){
                        $row[] = number_format($list->kas_keluar,0,",",".");
                    }else if($i == 2){
                        $row[] = number_format($list->tunai + $list->kartu,0,",",".");
                    }else{
                        $row[] = number_format($list->kas_masuk-$list->kas_keluar+$list->tunai + $list->kartu,0,",",".");
                    }
                    $data[] = $row;
                }
            }else{
                $data = $this->emptyRekap2();
            }
            echo json_encode($data);
        }
        
        
        public function  emptyRekap2(){
            $col1 = array("Kas Masuk","Kas Keluar","Penjualan","Total");
            $data = array();
            $no = 0;
            for ($i=0;$i<sizeof($col1);$i++){
                $row = array(); 
                $row[] = $col1[$i];
                $row[] = 0;
                $data[] = $row;
            }
            return $data;
        }
        
        function add($jenis){
            $data = array(
                'catatan' => ucwords(strtolower($this->input->post('catatan'))),
                'jumlah' => $this->input->post('jumlah'),
                'tgl' => date("Y-m-d H:i:s"),
                'id_outlet' => $this->session->userdata('outlet'),
                'petugas' => $this->session->userdata('nama'),
                'keluar_masuk' => $jenis
            );
             $inserted = $this->kas->add($data);
             echo json_encode(array('status' => $inserted));
        }
        function addRekap(){
            $tgl = date("Y-m-d H:i:s");
            $data = array(
                'tgl' => $tgl,
                'id_outlet' => $this->session->userdata('outlet'),
                'tunai' => $this->rkas->getTotalPenjualan($tgl,"TUNAI"),
                'kartu' => $this->rkas->getTotalPenjualan($tgl,"KARTU"),
                'real_tunai' => $this->input->post('tunai'),
                'real_kartu' => $this->input->post('kartu'),
                'kas_masuk' => $this->rkas->getTotalKas($tgl, "masuk"),
                'kas_keluar' => $this->rkas->getTotalKas($tgl, "keluar"),
                'operator' => $this->session->userdata('nama')
            );
             $inserted = $this->rkas->add($data);
             echo json_encode(array('status' => $inserted));
        }
        
        function update(){
             $data = array(
                'catatan' => ucwords(strtolower($this->input->post('catatan'))),
                'jumlah' => $this->input->post('jumlah'),
                'tgl' => date("Y-m-d H:i:s"),
                'petugas' => $this->session->userdata('nama')
             );
             $status = $this->kas->update('id_kas', $this->input->post('idkas'), $data);
             echo json_encode(array('status' => $status));
        }
        
        function detail($id){
            $detail = $this->kas->detail('id_kas', $id);
            echo json_encode($detail);
        }
        
        function rekapDetail($id){
            $list = $this->rkas->get_tableByID($id);
            $date = explode(" ", $list->tgl);
            $startdate = date("d M Y H:i:s", strtotime($date[0]." 00:00:00"));
            $enddate = date("d M Y H:i:s", strtotime($list->tgl));
            $data['date'] = $startdate." - ".$enddate;
            $data['jumlah'] = $this->rkas->getJumlahJual($date[0], $list->tgl);
            echo json_encode($data);
        }
        
        function getResume($id){
            $data = array();
            $col1 = array("Tunai","Kartu","Total");
            $list = $this->rkas->get_tableByID($id);
            for ($i=0;$i<sizeof($col1);$i++){
                $row = array(); 
                $row[] = $col1[$i];
                if($i == 0){
                    $row[] = number_format($list->real_tunai,0,",",".");
                    $row[] = number_format($list->tunai+$list->kas_masuk-$list->kas_keluar,0,",",".");
                    $row[] = number_format(($list->real_tunai - ($list->tunai+$list->kas_masuk-$list->kas_keluar)),0,",",".");
                }else if($i == 1){
                    $row[] = number_format($list->real_kartu,0,",",".");
                    $row[] = number_format($list->kartu,0,",",".");
                    $row[] = number_format(($list->real_kartu - $list->kartu),0,",",".");
                }else{
                    $row[] = number_format($list->real_tunai + $list->real_kartu,0,",",".");
                    $row[] = number_format($list->tunai+$list->kas_masuk-$list->kas_keluar + $list->kartu,0,",",".");
                    $row[] = number_format(($list->real_tunai - ($list->tunai+$list->kas_masuk-$list->kas_keluar)) + ($list->real_kartu - $list->kartu),0,",",".");
                }
                $data[] = $row;
            }
            return $data;
        }
        
        function getDetail($id){
             $data = array();
                $col1 = array("Kas Masuk","Kas Keluar","Penjualan","Total");
                $list = $this->rkas->get_tableByID($id);
                for ($i=0;$i<  sizeof($col1);$i++){
                    $row = array(); 
                    $row[] = $col1[$i];
                    if($i == 0){
                        $row[] = number_format($list->kas_masuk,0,",",".");
                    }else if($i == 1){
                        $row[] = number_format($list->kas_keluar,0,",",".");
                    }else if($i == 2){
                        $row[] = number_format($list->tunai + $list->kartu,0,",",".");
                    }else{
                        $row[] = number_format($list->kas_masuk-$list->kas_keluar+$list->tunai + $list->kartu,0,",",".");
                    }
                    $data[] = $row;
                }
            return $data;
        }
                
        function rekapDetail2($id){
            $list = $this->rkas->get_tableByID($id);
            $date = explode(" ", $list->tgl);
            $startdate = date("d M Y H:i:s", strtotime($date[0]." 00:00:00"));
            $enddate = date("d M Y H:i:s", strtotime($list->tgl));
            $data['date'] = $startdate." - ".$enddate;
            $data['jumlah'] = $this->rkas->getJumlahJual($date[0], $list->tgl);
            return $data;
        }
        
}
