<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Stok_keluar extends MY_Controller {

	function  __construct() {
                parent::__construct();
                $this->load->model('Stok_Keluar_M', 'skm');
                }
                
	public function index()
	{
                $this->get_menu();
                $data['title1'] = "Stok Keluar";
                $data['table_title'] = "Daftar Transaksi Stok Keluar";
		$this->load->view('inventory/stok_keluar', $data);
		$this->load->view('footer');
                
	}
        
        function view(){
            $list = $this->skm->get_datatables();
            $data = array();
            $no = $_POST['start'];
            foreach ($list as $skm) {
                $row = array();
                $row[] = $skm->id_sk;
                $row[] = $skm->nama_outlet;
                $row[] = $skm->tanggal;
                $row[] = $skm->note;
                $row[] = $skm->nama;
                $row[] = $this->getBarang($skm->id_sk);
               
                $data[] = $row;
            }

            $output = array(
                            "draw" => $_POST['draw'],
                            "recordsTotal" => $this->skm->count_all(),
                            "recordsFiltered" => $this->skm->count_filtered(),
                            "data" => $data,
                    );
            echo json_encode($output);
        }
        
        function add(){
              $data = array(
                  'id_outlet' => $this->session->userdata('outlet'),
                  'tanggal' => $this->input->post('tanggal'),
                  'note' => $this->input->post('note'),
                  'username' => $this->session->userdata('username')
              );  
              $inserted =$this->skm->addData($data);
              echo json_encode(array('status' => $inserted));
        }
        function update(){
              $data = array(
                  'tanggal' => $this->input->post('tanggal'),
                  'note' => $this->input->post('note'),
                  'username' => $this->session->userdata('username')
              );  
              $inserted =$this->skm->updateData($data, $this->input->post('id'));
              echo json_encode(array('status' => $inserted));
        }
        function detail($id){
            $detail = $this->skm->detail('id_sk', $id);
            echo json_encode($detail);
        }
        
        function getBarang($id){
            $list = $this->skm->getBarang($id);
            return $list;
        }
        
        function getListBarang($id){
            $list = $this->skm->getListBarang($id);
            echo json_encode($list);
        }
}