<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan_penjualan extends MY_Controller {

	function  __construct() {
                parent::__construct();
                    $this->load->model('Laporan_Penjualan_M', 'lpm');
                    $this->load->model('Outlet_M', 'outlet');
                    $this->load->model('Detail_Order_M', 'do');
                }
                
	public function index()
	{
                
                $this->get_menu();
                $data['title1'] = 'Laporan';
		$this->load->view('laporan/laporan_penjualan', $data);
		$this->load->view('footer');
                
	}
        
        function daftar_outlet(){
            $list = $this->outlet->get_list('id_outlet', 'nama_outlet', "Semua Outlet...");
            echo json_encode($list);
        }
        
        public function view($start ="", $end = "", $outlet = ""){
            if($start == "" && $end == ""){
                $start = $end = date("Y-m-d");
            }
            $list = $this->lpm->get_datatables($start, $end, $outlet);
            $data = array();
            $no = $_POST['start'];
            foreach ($list as $order) {
                $produk = '';
                $row = array();
                $row[] = $order->tanggal;
                $row[] = $order->id_order;
                $row[] = $order->nama_outlet;
                $row[] = $order->nama;
                $row[] = $order->customer;
                $row[] = $order->catatan;
                $item = explode('; ', $this->do->get_item($order->id_order));
                for($i = 0; $i < sizeof($item)-1; $i++){
                    if($i == 0){
                        $produk .= '<ul><li>'.$item[$i].'</li>';
                    }else if($i == sizeof($item)-1){
                        $produk .= '<li>'.$item[$i].'</li></ul>';
                    }else{
                        $produk .= '<li>'.$item[$i].'</li>';
                    }
                }
                $row[] = $produk;
                $row[] = number_format($order->subtotal,0,',','.');
                $row[] = number_format($order->diskon,0,',','.');
                $row[] = number_format(($order->subtotal-$order->diskon)*$order->o_ppn/100,0,',','.');
                $row[] = number_format($this->count_total($order->subtotal, $order->o_ppn, $order->diskon),'0',',','.');
                
                $data[] = $row;
            }

            $output = array(
                            "draw" => $_POST['draw'],
                            "recordsTotal" => $this->lpm->count_all($start, $end, $outlet),
                            "recordsFiltered" => $this->lpm->count_filtered($start, $end, $outlet),
                            "data" => $data,
                    );
            echo json_encode($output);
        }
        
         function count_total($sub, $ppn, $disc){
            $vppn = ($sub - $disc) * ($ppn/100);
            return $sub - $disc + $vppn;
        }
        
}
