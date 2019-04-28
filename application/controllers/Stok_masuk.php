<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Stok_masuk extends MY_Controller {

	function  __construct() {
                parent::__construct();
                $this->load->model('Stok_Masuk_M', 'smm');
                }
                
	public function index()
	{
                $this->get_menu();
                $data['title1'] = "Stok Masuk";
                $data['table_title'] = "Daftar Transaksi Stok Masuk";
		$this->load->view('inventory/stok_masuk', $data);
		$this->load->view('footer');
                
	}
        
        function view(){
            $list = $this->smm->get_datatables();
            $data = array();
            $no = $_POST['start'];
            foreach ($list as $smm) {
                $row = array();
                $row[] = $smm->id_sm;
                $row[] = $smm->nama_outlet;
                $row[] = $smm->tanggal;
                $row[] = $smm->note;
                $row[] = $smm->nama;
                $row[] = $this->getBarang($smm->id_sm);
               
                $data[] = $row;
            }

            $output = array(
                            "draw" => $_POST['draw'],
                            "recordsTotal" => $this->smm->count_all(),
                            "recordsFiltered" => $this->smm->count_filtered(),
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
              $inserted =$this->smm->addData($data);
              echo json_encode(array('status' => $inserted));
        }
        function update(){
              $data = array(
                  'tanggal' => $this->input->post('tanggal'),
                  'note' => $this->input->post('note'),
                  'username' => $this->session->userdata('username')
              );  
              $inserted =$this->smm->updateData($data, $this->input->post('id'));
              echo json_encode(array('status' => $inserted));
        }
        function detail($id){
            $detail = $this->smm->detail('id_sm', $id);
            echo json_encode($detail);
        }
        
        function getBarang($id){
            $list = $this->smm->getBarang($id);
            return $list;
        }
        
        function getListBarang($id){
            $list = $this->smm->getListBarang($id);
            echo json_encode($list);
        }
}