<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Posisi extends MY_Controller {

	function  __construct() {
                parent::__construct();
                $this->load->model('Posisi_M', 'posisi');
                }
                
	public function index()
	{
                $this->get_menu();
                //$data['list_menu'] = $this->get_all_menu();
                $data['title1'] = "Posisi";
                $data['table_title'] = "Daftar Posisi";
		$this->load->view('data/posisi', $data);
		$this->load->view('footer');
                
	}
        
        function daftar_posisi(){
            $list = $this->posisi->get_list('id_posisi', 'posisi', "Pilih Posisi...");
            echo json_encode($list);
        }
        
         function view(){
            $list = $this->posisi->get_datatables();
            $data = array();
            $no = $_POST['start'];
            foreach ($list as $posisi) {
                $row = array();
                $row[] = $posisi->id_posisi;
                $row[] = $posisi->posisi;
                $data[] = $row;
            }

            $output = array(
                            "draw" => $_POST['draw'],
                            "recordsTotal" => $this->posisi->count_all(),
                            "recordsFiltered" => $this->posisi->count_filtered(),
                            "data" => $data,
                    );
            echo json_encode($output);
        }
        
        
        function add(){
            $data = array(
                'posisi' => ucwords(strtolower($this->input->post('posisi')))
            );
                 $inserted = $this->posisi->add($data);
                 if($inserted){
                     $this->posisi->add_akses_modul(ucwords(strtolower($this->input->post('posisi'))));
                 }
                 echo json_encode(array('status' => $inserted));
        }
        
        function detail($id){
            $detail = $this->posisi->detail('id_posisi', $id);
            echo json_encode($detail);
        }
        
        function update(){
             $data = array(
                 'posisi' => ucwords(strtolower($this->input->post('posisi')))
             );
             $status = $this->posisi->update('id_posisi', $this->input->post('id'), $data);
             echo json_encode(array('status' => $status));
        }
        
        function delete($id){
                    
            $status = $this->posisi->delete('id_posisi', $id);
            echo json_encode(array('status' => $status));
        }
        
        function get_all_menu($id_posisi = ""){
            $data = $this->posisi->get_all_menu($id_posisi);
            echo json_encode($data);
        }
        
        function savePrevilage(){
            $status = $this->posisi->savePrevilage($this->input->post('id'), $this->input->post('modul'));
            echo json_encode(array('status' => $status));
        }
        
}
