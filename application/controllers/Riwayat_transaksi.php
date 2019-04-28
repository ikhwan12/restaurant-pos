<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Riwayat_transaksi extends MY_Controller {

	function  __construct() {
                parent::__construct();
                    $this->load->model('Riwayat_Transaksi_M', 'rwm');
                    $this->load->model('Detail_Order_M', 'do');
                }
                
	public function index()
	{
            $this->get_menu();
            $this->load->view('riwayat_transaksi');
            $this->load->view('footer');
        }
        
         public function view(){
            $list = $this->rwm->get_datatables();
            $data = array();
            $no = $_POST['start'];
            
            foreach ($list as $order) {
                $row = array();
                $row[] = $order->id_order;
                $row[] = date('d/M/Y H:m',strtotime($order->tanggal));
                $row[] = $order->id_order;
                $row[] = $order->nama;
                $row[] = $order->customer;
                $row[] = $this->do->get_item($order->id_order);
                $row[] = 'Rp. '.number_format($this->count_total($order->subtotal, $order->o_ppn, $order->diskon),'0',',','.');
               
                $data[] = $row;
            }

            $output = array(
                            "draw" => $_POST['draw'],
                            "recordsTotal" => $this->rwm->count_all(),
                            "recordsFiltered" => $this->rwm->count_filtered(),
                            "data" => $data,
                    );
            echo json_encode($output);
        }
        
        function count_total($sub, $ppn, $disc){
            $vppn = ($sub - $disc) * ($ppn/100);
            return $sub - $disc + $vppn;
        }

}