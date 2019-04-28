<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Order extends MY_Controller {

	function  __construct() {
                parent::__construct();
                    $this->load->model('Kategori_M', 'kategori');
                    $this->load->model('Order_M', 'order');
                    $this->load->model('Detail_Order_M', 'do');
                    $this->load->model('Menu_Outlet_M', 'mo');
                    $this->load->model('Meja_M', 'meja');
                    $this->load->model('Pengaturan_M', 'atur');
                    $this->load->model('Printer_M', 'printer');
                }
                
	public function index()
	{
            redirect('order/myorder');
	}
        
	public function myorder($id_order="")
	{
            if($id_order == ""){
                if($this->session->userdata('outlet') == ""){
                    $data['id_order'] = '';
                }else{
                    if($this->session->userdata('order') == ''){
                        $data['id_order'] = $this->add();
                        $this->session->set_userdata(array('order' => $data['id_order']));
                    }else{
                        $data['id_order'] = $this->session->userdata('order');
                    }
                }
            }else{
                $data['id_order'] = $id_order;
            }
            $this->get_menu();
            $this->load->view('order/order',$data);
            $this->load->view('footer');
                
	}
        
	public function table()
	{
            $data['meja'] = $this->meja->get_meja($this->session->userdata('outlet'));
            $this->get_menu();
            $this->load->view('order/meja',$data);
            $this->load->view('footer');
                
	}
        
	public function assign_table($id_order = '')
	{
            if($id_order == ""){
                if($this->session->userdata('outlet') == ""){
                    $data['id_order'] = '';
                }else{
                    $data['id_order'] = $id_order;
                }
            }else{
                $data['id_order'] = $id_order;
            }
            $data['meja'] = $this->meja->get_meja_kosong($this->session->userdata('outlet'));
            $this->get_menu();
            $this->load->view('order/assign_meja',$data);
            $this->load->view('footer');
                
	}
        
	public function list_order()
	{
            $this->get_menu();
            $this->load->view('order/list_order');
            $this->load->view('footer');
                
	}
        
        public function view(){
            $list = $this->order->get_datatables();
            $data = array();
            $no = $_POST['start'];
            
            foreach ($list as $order) {
                $row = array();
                $row[] = $order->id_order;
                $row[] = date('d/M/Y H:m',strtotime($order->tanggal));
                $row[] = $order->nama;
                $row[] = $order->customer;
                $row[] = $this->do->get_item($order->id_order);
                $row[] = 'Rp. '.number_format($this->count_total($order->subtotal, $order->o_ppn, $order->diskon),'0',',','.');
                $row[] = '<button type="button" onclick="printMenu('."'".$order->id_order."'".')" class="btn btn-sm btn-flat btn-primary"><i class="fa fa-print"></i> Pesanan</button>&nbsp'
                        .'<button type="button" onclick="edit('."'".$order->id_order."'".')" class="btn btn-sm btn-flat btn-info"><i class="fa fa-edit"></i> Edit</button>';

                $data[] = $row;
            }

            $output = array(
                            "draw" => $_POST['draw'],
                            "recordsTotal" => $this->order->count_all(),
                            "recordsFiltered" => $this->order->count_filtered(),
                            "data" => $data,
                    );
            echo json_encode($output);
        }
                
        function view_kategori(){
            $list = $this->kategori->getlistKategori();
            $data = array();
            $row = array();
            $row[] = '';
            $row[] = '<span style="font-size: 14px; font-weight: 700;">SEMUA</span>';
            $data[] = $row;
            $row = array();
            $row[] = '0';
            $row[] = '<span style="font-size: 14px; font-weight: 700;">GOJEK</span>';
            $data[] = $row;
            foreach ($list as $item){
                $row = array();
                $row[] = $item->id_kategori;        
                $row[] = '<span style="font-size: 14px; font-weight: 700;">'.strtoupper($item->kategori).'</span>';      
                $data[] = $row;
            }
            echo json_encode($data);
        }
        
        
         function view_menu_outlet($id_outlet = "", $kategori=""){
            
            if($id_outlet == "" || $id_outlet == "null"){
                $id_outlet = $this->session->userdata('outlet');
            }
            $data = array();
            $no = $_POST['start'];
            $list = $this->mo->get_datatables($id_outlet, $kategori);
            foreach ($list as $menu) {
                $row = array();
                $row[] = $menu->id_om;
                $row[] = '<span class="my-box bg-'.$menu->colour.'" style="width: 55px;height: 55px;">'.$menu->short_name.'</span>';
                $row[] = '<span style="font-size: 16px;">'.$menu->menu.'</span>'
                         .'<p>'.$menu->deskripsi.'</p>';
                if($kategori == '0'){
                    $row[] = 'Rp. '.number_format($menu->harga_gojek,'0',',','.');
                }else{
                    $row[] = 'Rp. '.number_format($menu->harga,'0',',','.');
                }
                $data[] = $row;
            }
           
            $output = array(
                            "draw" => $_POST['draw'],
                            "recordsTotal" => $this->mo->count_all($id_outlet, $kategori),
                            "recordsFiltered" => $this->mo->count_filtered($id_outlet, $kategori),
                            "data" => $data,
                    );
            echo json_encode($output);
        }
        
        function add(){
            $kode = $this->generateID();
            $data = array(
                'id_order' => $kode['id'],
                'id_outlet' => $this->session->userdata('outlet')
            );
            if($this->order->check_exist($kode['id'])){
                return  $kode['id'];
            }else{
                $inserted = $this->order->add($data);
                return  $kode['id'];
            }
             
        }
        
         function add_meja(){
            $meja = $this->input->post('no');
            if($meja == ""){
                $meja = $this->meja->get_no($this->session->userdata('outlet'));
            }
            $data = array(
                'no_meja' => $meja,
                'id_outlet' => $this->session->userdata('outlet')
            );
            $mejaExist = $this->meja->mejaExist($data);
            $inserted = FALSE;
            if(!$mejaExist['status']){
                $inserted = $this->meja->add($data);
                $inserted = TRUE;
            }
            echo json_encode(array('status' => $inserted, 'message' => $mejaExist['message']));
             
        }
        
        function delMeja(){
            $status = $this->meja->delMeja();
            echo json_encode(array('status' => $status));
        }
                
        function update(){
             if(!$this->order->check_processed($this->input->post('id_order'))){
                 $this->session->set_userdata(array('order' => ''));
             }
             $data = array(
                'customer' => $this->normalize_text('customer'),
                'o_ppn' => $this->input->post('ppn'),
                'diskon' => $this->input->post('diskon'),
                'proses' => 1,
                'username' => $this->session->userdata('username'),
                'tanggal' => date("Y-m-d H:i:s")
             );
             if($this->input->post('meja') != ''){
                 $data['meja'] = $this->input->post('meja');
             }
             $status = $this->order->update('id_order', $this->input->post('id_order'), $data);
             echo json_encode(array('status' => $status));
        }
        
        function update2(){
             $data = array(
                'customer' => $this->normalize_text('customer'),
                'o_ppn' => $this->input->post('ppn'),
                'diskon' => $this->input->post('diskon'),
                'username' => $this->session->userdata('username'),
                'tanggal' => date("Y-m-d H:i:s")
             );
             if($this->input->post('meja') != ''){
                 $data['meja'] = $this->input->post('meja');
             }
             $status = $this->order->update('id_order', $this->input->post('id_order'), $data);
             echo json_encode(array('status' => $status));
        }
        
        function payment($id_order=""){
            $data['id_order'] = $id_order;
            $this->get_menu();
            $this->load->view('order/payment',$data);
            $this->load->view('footer');
        }
        
        function bayar(){
            $data = array(
                'proses' => 1,
                'bayar' => $this->input->post('bayar'),
                'jenis_bayar' => $this->input->post('metode'),
                'no_kartu' => $this->input->post('kartu'),
                'bank' => $this->input->post('bank'),
                'catatan' => $this->input->post('catatan'),
                'tanggal' => date("Y-m-d H:i:s")
             );
             $status = $this->order->update('id_order', $this->input->post('id'), $data);
             if($status){
                 $this->mo->updateStok($this->input->post('id'));
             }
             $this->session->set_userdata(array('order' => ''));
             echo json_encode(array(
                    'status' => $status, 
                    'printer' => $this->atur->get_printer(),
                    'kembali' => $this->order->get_kembali($this->input->post('id')),
                    'cara' => $this->order->get_cara_bayar($this->input->post('id'))
                  ));
        }
                
        function cek_paid($id_order=""){
            $data['id_order'] = $id_order;
            $data['printer'] = $this->atur->get_printer();
            $data['paid'] = $this->order->cek_paid($id_order);
            $data['kembali'] = $this->order->get_kembali($id_order);
            $data['cara'] = $this->order->get_cara_bayar($id_order);
            echo json_encode($data);
        }
        
                
        function update_meja(){
             $data = array(
                'meja' => $this->input->post('meja')
             );
             $status = $this->order->update('id_order', $this->input->post('id_order'), $data);
             echo json_encode(array('status' => $status));
        }
        
        function detail($id_order){
            $detail = $this->order->detail_order($id_order);
            echo json_encode($detail);
        }
                
        function generateID(){
             $detail = $this->order->generateID();
             return $detail;
        }
        
        function count_total($sub, $ppn, $disc){
            $vppn = ($sub - $disc) * ($ppn/100);
            return $sub - $disc + $vppn;
        }
        
        function delete($id_order){
            if($this->session->userdata('order') == $id_order){
                $this->session->set_userdata('order','');
            }
            $status = $this->do->delete('id_order',$id_order);
            $status = $this->order->delete('id_order',$id_order);
            echo json_encode(array('status' => $status));
        }
        
        function get_total($id_order=""){
            $detail = $this->order->detail_order($id_order);
            if($detail != false){
                 foreach ($detail as $value) {
                    $sub = $detail->subtotal;
                    $ppn = $detail->ppn;
                    $diskon = $detail->diskon;
                }
                echo json_encode(array('status' => true, 'total' => $this->count_total($sub, $ppn, $diskon)));
            }else{
                echo json_encode(array('status' => true, 'total' => 0));
            }
        }
        
        function haveOption($id){
            $option = $this->order->haveOption($id);
            echo json_encode($option);
        }
        
        
        function strukPrint($id_order){
            $printer = $this->printer->getPrinter();
            $outlet = $this->printer->getOutlet();
            $order = $this->printer->getDetailOrder($id_order);
            $item = $this->printer->getOrderItem($id_order);
            $this->load->library('ReceiptPrint');
            $data = $this->connectPrint($printer);
            if($data['connected']){
                $this->receiptprint->strukPrint($printer, $outlet, $order, $item, $this->session->userdata('nama'));
            }
            echo json_encode($data);
        }
        function kitchenPrint($id_order){
            $printer = $this->printer->getPrinter();
            $outlet = $this->printer->getOutlet();
            $order = $this->printer->getDetailOrder($id_order);
            $item = $this->printer->getOrderItem($id_order);
            $this->load->library('ReceiptPrint');
            $data = $this->connectPrint($printer);
            if($data['connected']){
                $this->receiptprint->kitchenPrint($printer, $outlet, $order, $item, $this->session->userdata('nama'));
            }
            echo json_encode($data);
        }
        function connectPrint($printer){
            $data = $this->receiptprint->connect($printer);
            return $data;
        }
}
