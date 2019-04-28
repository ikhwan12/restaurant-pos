<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Menu extends MY_Controller {

	function  __construct() {
                parent::__construct();
                $this->load->model('Produk_M', 'produk');
                }
                
	public function index()
	{
                $this->get_menu();
                $data['title1'] = "Menu";
                $data['table_title'] = "Daftar Menu";
		$this->load->view('data/menu', $data);
		$this->load->view('footer');
                
	}
        
        function daftar_menu(){
            $list = $this->produk->get_list('kode_menu', 'nama_menu', "Pilih Sopir...");
            echo json_encode($list);
        }
        
         function view($page = "", $kategori = ""){
            $data = array();
            $no = $_POST['start'];
            $list = $this->produk->get_datatables($kategori);
            foreach ($list as $menu) {
                $row = array();
                $row[] = $menu->id_menu;
                $row[] = $menu->menu;
                $row[] = 'Rp '.number_format($menu->price,0,',','.');
                $row[] = 'Rp '.number_format($menu->gojek_price,0,',','.');

                $data[] = $row;
            }
            $output = array(
                            "draw" => $_POST['draw'],
                            "recordsTotal" => $this->produk->count_all($kategori),
                            "recordsFiltered" => $this->produk->count_filtered($kategori),
                            "data" => $data,
                    );
            echo json_encode($output);
        }
        
        
        function add(){
            $id_kategori = $this->produk->getIDKategori($this->input->post('kategori'));
            $menu = $this->normalize_text('menu');
            $kom = $this->imgComb($menu);
            $data = array(
                'id_kategori' => $id_kategori,
                'menu' => $this->normalize_text('menu'),
                'deskripsi' => $this->normalize_text('deskripsi'),
                'price' => $this->input->post('price'),
                'gojek_price' => $this->input->post('gojek_price'),
                'short_name' => $kom['sn'],
                'colour' => $kom['selected_colour']
            );
            if($this->input->post('sold') == "on"){
                $data['sold'] = 1;
            }
            if($this->input->post('auto_assign') == "on"){
                $data['auto_assign'] = 1;
            }
            if($this->input->post('manage_stock') == "on"){
                $data['manage_stock'] = 1;
                $data['satuan'] = $this->input->post('satuan');
            }
            $inserted = $this->produk->add($data);
            if($inserted){
                $this->produk->assignToAllOutlet($data['menu']);
            }
            if($inserted && $this->input->post('piltam') == "on" ){
                $this->produk->insert_modifier($data['menu']);
            }
            if($inserted && $this->input->post('resep') == "on" ){
                $this->produk->insert_resep($data['menu']);
            }
            echo json_encode(array('status' => $inserted));
        }
        
        function imgComb($menu){
            $kom = array();
            $sn = '';
            foreach (preg_split('#[^a-z]+#i', $menu, -1, PREG_SPLIT_NO_EMPTY) as $word) {
                $sn .= $word[0];
            }
            $sn = substr($sn, 0, 2);
            $color = array('aqua', 'blue', 'purple', 'green', 'red', 'lime', 'maroon', 'orange', 'olive', 'teal');
            $selected_colour = 'white';
            foreach ($color as $item){
                $result = $this->produk->cek_kombinasi($sn, $item);
                if($result){
                    $selected_colour = $item;
                    break;
                }
            }
            $kom['sn'] = $sn;
            $kom['selected_colour'] = $selected_colour;
            return $kom;
        }
                
        function detail($id){
            $detail = $this->produk->detail('id_menu', $id);
            echo json_encode($detail);
        }
        
        function update(){
            $data = array();
            $menu_detail = $this->produk->detail('id_menu', $this->input->post('id'));
            $id_kategori = $this->produk->getIDKategori($this->input->post('kategori'));
            $menu_modifier;
            $menu_resep;
            if($id_kategori != $menu_detail->id_kategori){
               $data['id_kategori'] = $id_kategori ;
            }
            if($this->normalize_text('menu') != $menu_detail->menu){
               $data['menu'] = $this->normalize_text('menu');
            }
            if($this->input->post('deskripsi') != $menu_detail->deskripsi){
               $data['deskripsi'] = $this->input->post('deskripsi');
            }
            if($this->input->post('price') != $menu_detail->price){
               $data['price'] = $this->input->post('price');
            }
            if($this->input->post('gojek_price') != $menu_detail->gojek_price){
               $data['gojek_price'] = $this->input->post('gojek_price');
            }
            if($this->input->post('satuan') != $menu_detail->satuan){
               $data['satuan'] = $this->input->post('satuan');
            }
            if($this->input->post('sold') == "on"){
               $data['sold'] = 1;
            }else{
               $data['sold'] = 0;
            }
            if($this->input->post('manage_stock') == "on"){
               $data['manage_stock'] = 1;
            }else{
               $data['manage_stock'] = 0;
            }
            if($this->input->post('auto_assign') == "on"){
               $data['auto_assign'] = 1;
            }else{
               $data['auto_assign'] = 0;
            }
            $status = $this->produk->update('id_menu', $this->input->post('id'), $data);
            if($this->input->post('piltam') == "on"){
                $this->produk->updatePilihan($this->input->post('id'));
            }else{
               $this->produk->deletePilihan($this->input->post('id'));
            }
            if($this->input->post('resep') == "on"){
                $this->produk->updateResep($this->input->post('id'));
            }else{
               $this->produk->deleteResep($this->input->post('id'));
            }
            echo json_encode(array('status' => $status));
        }
        
        function delete($id){
                    
            $status = $this->produk->delete('kode_menu', $id);
            echo json_encode(array('status' => $status));
        }
        
        function modifierData(){
            $data = array();
            $list = $this->produk->get_modifier();
            if(sizeof($list) > 0){
                foreach ($list as $value) {
                    $data[] = $value->id_modifier;
                }
            }else{
                $data[] = "No Data";
            }
            echo json_encode($data);
            
        }
        function resepData(){
            $data = array();
            $list = $this->produk->get_resep();
            if(sizeof($list) > 0){
                $row = array();
                $row['id'] = '';
                $row['text'] = 'Pilih Bahan';
                $data[] = $row;
                foreach ($list as $value) {
                    $row = array();
                    $row['id'] = $value->id_menu;
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
        
        function get_modifier_detail(){
            $data = $this->produk->get_modifier_detail($this->input->post('mod'));
            echo json_encode($data);
        }
        function get_resep_detail(){
            $data = $this->produk->get_resep_detail($this->input->post('resep'));
            echo json_encode($data);
        }
        
        function getMenuModifier($id_menu){
            $data = $this->produk->getMenuModifier($id_menu);
            echo json_encode($data);
        }
        function getMenuResep($id_menu){
            $data = $this->produk->getMenuResep($id_menu);
            echo json_encode($data);
        }
        function export(){
           $this->produk->export();
        }
       function import(){
           $d = $this->produk->import();
           echo json_encode($d);
       }
        
}
