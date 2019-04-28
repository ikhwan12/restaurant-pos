<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Detail_Order extends MY_Controller {

	function  __construct() {
                parent::__construct();
                $this->load->model('Detail_Order_M', 'dom');
                }
             
        function daftar_dom(){
            $list = $this->dom->get_list('id_dom', 'dom', "Pilih Kategori...");
            echo json_encode($list);
        }
        
         function view(){
            $id_order = $this->input->post('id_order');
            $list = $this->dom->get_datatables($id_order);
            $data = array();
            $no = $_POST['start'];
           
            foreach ($list as $dom) {
                $disp = ""; 
                $row = array();
                $row[] = $dom->id_detail_order;
                if($dom->id_modifier != "" && $dom->harga_pilihan != 0){
                    $disp = $dom->menu.' (x'.$dom->jumlah.') +'.$dom->tampilan.' @ '.number_format($dom->harga_pilihan,'0',',','.');
                }else{
                    $disp = $dom->menu.' (x'.$dom->jumlah.')';
                }
                $row[] = $disp;
                $row[] = 'Rp. '.number_format($dom->jumlah*($dom->harga_satuan+$dom->harga_pilihan),'0',',','.');
                
                $data[] = $row;
            }

            $output = array(
                            "draw" => $_POST['draw'],
                            "recordsTotal" => $this->dom->count_all($id_order),
                            "recordsFiltered" => $this->dom->count_filtered($id_order),
                            "data" => $data,
                    );
            echo json_encode($output);
        }
        
        
        function add(){
          
            $data = array(
                'id_order' => $this->input->post('id_order'),
                'id_om' => $this->input->post('id_om'),
                'jumlah' => 1,
                'harga_satuan' => $this->input->post('harga'),
            );
            if($this->dom->item_exist($this->input->post('id_order'), $this->input->post('id_om'), $this->input->post('harga'))){
                $inserted = $this->dom->update_qty($this->input->post('id_order'), $this->input->post('id_om'), $this->input->post('harga'));
            }else{
                $inserted = $this->dom->add($data);
            }
            echo json_encode(array('status' => $inserted));
        }
        
        function addWithOption(){
            $data = array(
                'id_order' => $this->input->post('id_order_wo'),
                'id_om' => $this->input->post('idOm'),
                'jumlah' => $this->input->post('jml'),
                'harga_satuan' => $this->input->post('harga_om'),
                'id_modifier' => $this->input->post('opsi'),
                'harga_pilihan' => $this->input->post('harga_modifier')
            );
            $inserted = $this->dom->addWithOption($data);
            echo json_encode(array('status' => $inserted));
        }
                
        function detail($id){
            $detail = $this->dom->detail('id_detail_order', $id);
            echo json_encode($detail);
        }
        
        
        function update_qty(){
            if($this->input->post('qty') == 0 || $this->input->post('qty') == ''){
                $status = $this->dom->delete('id_detail_order', $this->input->post('id'));
            }else{
                 $data = array(
                    'jumlah' => $this->input->post('qty'),
                 );
                 $status = $this->dom->update('id_detail_order', $this->input->post('id'), $data);
            }
             echo json_encode(array('status' => $status));
        }
        
        function delete($id){
                    
            $status = $this->dom->delete('kode_dom', $id);
            echo json_encode(array('status' => $status));
        }
      
        
}
