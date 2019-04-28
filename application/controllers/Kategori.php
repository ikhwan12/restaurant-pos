<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kategori extends MY_Controller {

	function  __construct() {
                parent::__construct();
                $this->load->model('Kategori_M', 'kategori');
                }
                
	public function index()
	{
                $this->get_menu();
                $data['title1'] = "Kategori Menu";
                $data['table_title'] = "Daftar Kategori Menu";
		$this->load->view('data/kategori', $data);
		$this->load->view('footer');
                
	}
        
        function daftar_kategori(){
            $list = $this->kategori->get_list('id_kategori', 'kategori', "Pilih Kategori...");
            echo json_encode($list);
        }
        function daftar_kategori2(){
            $list = $this->kategori->get_list2();
            echo json_encode($list);
        }
        
         function view($page = ""){
            $list = $this->kategori->get_datatables();
            $data = array();
            $no = $_POST['start'];
            if($page != ""){
                $row = array();
                $row[] = 0;
                $row[] = '';
                $row[] = 'Semua';
                
                $data[] = $row;
            }
            foreach ($list as $kategori) {
                $no++;
                $row = array();
                $row[] = $no;
                $row[] = $kategori->id_kategori;
                $row[] = $kategori->kategori;
                
                $data[] = $row;
            }

            $output = array(
                            "draw" => $_POST['draw'],
                            "recordsTotal" => $this->kategori->count_all(),
                            "recordsFiltered" => $this->kategori->count_filtered(),
                            "data" => $data,
                    );
            echo json_encode($output);
        }
        
        
        function add(){
            $data = array(
                'kategori' => $this->normalize_text('kategori')
            );
                 $inserted = $this->kategori->add($data);
                 echo json_encode(array('status' => $inserted));
        }
        
        function detail($id){
            $detail = $this->kategori->detail('id_kategori', $id);
            echo json_encode($detail);
        }
        
        function update(){
             $data = array(
                'kategori' => $this->normalize_text('kategori'),
             );
             $status = $this->kategori->update('id_kategori', $this->input->post('id'), $data);
             echo json_encode(array('status' => $status));
        }
        
        function delete($id){
                    
            $status = $this->kategori->delete('kode_kategori', $id);
            echo json_encode(array('status' => $status));
        }
        
       function import(){
           $this->kategori->import();
       }
       function export($table){
           $this->kategori->export($table);
       }
      
        
}
