<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Outlet extends MY_Controller {

	function  __construct() {
                parent::__construct();
                $this->load->model('Outlet_M', 'outlet');
                }
                
	public function index()
	{
                $this->get_menu();
                $data['title1'] = "Outlet";
                $data['table_title'] = "Daftar Outlet";
		$this->load->view('data/outlet', $data);
		$this->load->view('footer');
                
	}
        
        function daftar_outlet(){
            $list = $this->outlet->get_list('id_outlet', 'nama_outlet', "Pilih Outlet...");
            echo json_encode($list);
        }
        
         function view(){
            $list = $this->outlet->get_datatables();
            $data = array();
            $no = $_POST['start'];
            foreach ($list as $outlet) {
                $row = array();
                $row[] = $outlet->id_outlet;
                $row[] = $outlet->nama_outlet;
                $row[] = $outlet->alamat_outlet;
                $row[] = $outlet->ppn;
                
                $data[] = $row;
            }

            $output = array(
                            "draw" => $_POST['draw'],
                            "recordsTotal" => $this->outlet->count_all(),
                            "recordsFiltered" => $this->outlet->count_filtered(),
                            "data" => $data,
                    );
            echo json_encode($output);
        }
        
        
        function add(){
            $data = array(
                'nama_outlet' => $this->normalize_text('nama_outlet'),
                'alamat_outlet' => $this->normalize_text('alamat_outlet'),
                'telp' => $this->input->post('telp'),
                'ppn' => $this->input->post('ppn'),
                'printer' => $this->input->post('printer'),
            );
             $inserted = $this->outlet->add($data);
             if($inserted){
                 $this->outlet->addAutoAssignMenu($this->normalize_text('nama_outlet'));
             }
             echo json_encode(array('status' => $inserted));
        }
        
        function detail($id){
            $detail = $this->outlet->detail('id_outlet', $id);
            echo json_encode($detail);
        }
        
        function update(){
             $data = array(
                'nama_outlet' => $this->normalize_text('nama_outlet'),
                'alamat_outlet' => $this->normalize_text('alamat_outlet'),
                'telp' => $this->input->post('telp'),
                'ppn' => $this->input->post('ppn'),
                'printer' => $this->input->post('printer'),
             );
             $status = $this->outlet->update('id_outlet', $this->input->post('id'), $data);
             echo json_encode(array('status' => $status));
        }
        
        function delete($id){
                    
            $status = $this->outlet->delete('kode_outlet', $id);
            echo json_encode(array('status' => $status));
        }
        
        function outletData(){
            $data = array();
            $list = $this->outlet->outletData();
            if(sizeof($list) > 0){
                $row = array();
                foreach ($list as $value) {
                    $row = array();
                    $row['id'] = $value->id_outlet;
                    $row['text'] = $value->nama_outlet;
                    $data[] = $row;
                }
            }else{
                $row['id'] = '';
                $row['text'] = 'No Data';
                $data[] = "No Data";
            }
            echo json_encode($data);
            
        }
      
        
}
