<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Menu_Outlet extends MY_Controller {

	function  __construct() {
                parent::__construct();
                    $this->load->model('Kategori_M', 'kategori');
                    $this->load->model('Menu_Outlet_M', 'mo');
                    $this->load->model('Produk_M', 'produk');
                }
                
	public function index()
	{
                
                $this->get_menu();
		$this->load->view('data/menu_outlet');
		$this->load->view('footer');
                
	}
        
        function view_menu($kategori = ""){
            $data = array();
            $no = $_POST['start'];
           
                $list = $this->produk->get_datatables($kategori);
                foreach ($list as $menu) {
                    $row = array();
                    $row[] = $menu->id_menu;
                    $row[] = '<span class="my-box bg-'.$menu->colour.'" style="width: 55px;height: 55px;">'.$menu->short_name.'</span>';
                    $row[] = '<span style="font-size: 16px;">'.$menu->menu.'</span>'
                             .'<p>'.$menu->deskripsi.'</p>';
                    $row[] = $menu->price;
                    $row[] = $menu->gojek_price;
                    if($menu->sold == "1"){
                        $data[] = $row;
                    }
                    
                }
                
            $output = array(
                            "draw" => $_POST['draw'],
                            "recordsTotal" => $this->produk->count_all($kategori),
                            "recordsFiltered" => $this->produk->count_filtered($kategori),
                            "data" => $data,
                    );
            echo json_encode($output);
        }
        
        function view_menu_outlet($id_outlet = ""){
            
            if($id_outlet == "" || $id_outlet == "null"){
                $id_outlet = $this->session->userdata('outlet');
            }
            $data = array();
            $no = $_POST['start'];
            $list = $this->mo->get_datatables($id_outlet,"");
            foreach ($list as $menu) {
                $row = array();
                $row[] = $menu->id_om;
                $row[] = '<span class="my-box bg-'.$menu->colour.'" style="width: 50px;height: 50px;">'.$menu->short_name.'</span>';
                $row[] = '<span style="font-size: 14px;">'.$menu->menu.'</span>'
                         .'<p>'.$menu->deskripsi.'</p>';
                $row[] = 'Rp. '.number_format($menu->harga,'0',',','.');
                $row[] = 'Rp. '.number_format($menu->harga_gojek,'0',',','.');

                $data[] = $row;
            }
           
            $output = array(
                            "draw" => $_POST['draw'],
                            "recordsTotal" => $this->mo->count_all($id_outlet,""),
                            "recordsFiltered" => $this->mo->count_filtered($id_outlet,""),
                            "data" => $data,
                    );
            echo json_encode($output);
        }
        
         function add(){
            $id_outlet = $this->input->post('id_outlet');
            if($id_outlet == ""){
                $id_outlet = $this->session->userdata('outlet');
            } 
             
            $data = array(
                'id_menu' => $this->input->post('id_menu'),
                'id_outlet' => $id_outlet,
                'harga' => $this->input->post('harga'),
                'harga_gojek' => $this->input->post('harga_gojek')
            );
             $inserted = $this->mo->add($data);
             echo json_encode(array('status' => $inserted));
        }
        
        function cek_added(){
            $inserted = $this->mo->cek_added($this->input->post('outlet'),$this->input->post('menu'));
            echo json_encode(array('status' => $inserted));
        }
        
         function detail($id){
            $detail = $this->mo->detail('id_om', $id);
            echo json_encode($detail);
        }
        
        function update(){
             $data = array(
                'harga' => $this->input->post('harga'),
                'harga_gojek' => $this->input->post('harga_gojek')
             );
             $status = $this->mo->update('id_om', $this->input->post('id'), $data);
             echo json_encode(array('status' => $status));
        }
        
        function warehouseData(){
            $data = array();
            $list = $this->mo->warehouseData();
            if(sizeof($list) > 0){
                $row = array();
                $row['id'] = "-1";
                $row['text'] = "Pilih Produk...";
                $data[] = $row;
                $row = array();
                foreach ($list as $value) {
                    $row = array();
                    $row['id'] = $value->id_om;
                    $row['text'] = $value->menu;
                    $data[] = $row;
                }
            }else{
                $row['id'] = '';
                $row['text'] = 'No Data';
                $data[] = "No Data";
            }
            echo json_encode($data);
        }
        function getDetailProduk(){
            $data = $this->mo->getDetailProduk($this->input->post('id'));
            echo json_encode($data);
        }
        
        
}
