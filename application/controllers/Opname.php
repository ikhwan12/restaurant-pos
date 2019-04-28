<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Opname extends MY_Controller {

	function  __construct() {
                parent::__construct();
                $this->load->model('Opname_M', 'opm');
                }
                
	public function index()
	{
                $this->get_menu();
                $data['title1'] = "Opname";
                $data['table_title'] = "Daftar Opname";
		$this->load->view('inventory/opname', $data);
		$this->load->view('footer');
                
	}
        
        function view(){
            $list = $this->opm->get_datatables();
            $data = array();
            $no = $_POST['start'];
            foreach ($list as $opm) {
                $row = array();
                $row[] = $opm->id_opname;
                $row[] = $opm->nama_outlet;
                $row[] = $opm->tanggal;
                $row[] = $opm->note;
                $row[] = $opm->nama;
                $data[] = $row;
            }

            $output = array(
                            "draw" => $_POST['draw'],
                            "recordsTotal" => $this->opm->count_all(),
                            "recordsFiltered" => $this->opm->count_filtered(),
                            "data" => $data,
                    );
            echo json_encode($output);
        }
        
        function addView($id_outlet=""){
            $list = $this->opm->getInventory($id_outlet);
            $data = array();
            $i = 1;
            foreach ($list as $item){
                $row = array();
                $row[] = '<input type="text" name="idom[]" value="'.$item->id_om.'" hidden>';        
                $row[] = $item->menu;
                $row[] = number_format($item->stok,2,',','.').'<input type="text" name="stok[]" id="st'.$i.'" value="'.$item->stok.'" hidden>';   
                $row[] = '<input type="text" style="width:100px;" onkeyup="updateVar(this.value, '.$i.');" name="real[]" class="input-xs">';
                $row[] = '<span id="var'.$i.'"></span>';
                $data[] = $row;
                $i++;
            }
            echo json_encode($data);
        }
        
        function updateView($id_opname){
            $list = $this->opm->getInventory2($id_opname);
            $data = array();
            $i = 1;
            foreach ($list as $item){
                $row = array();
                $row[] = '<input type="text" name="idom[]" value="'.$item->id_om.'" hidden>';        
                $row[] = $item->menu;
                $row[] = number_format($item->stok_db,2,',','.').'<input type="text" name="stok[]" id="st'.$i.'" value="'.$item->stok_db.'" hidden>';   
                $row[] = '<input type="text" style="width:100px;" onkeyup="updateVar(this.value, '.$i.');" name="real[]" value="'.$item->stok_real.'" class="input-xs">';
                $variance = $this->getVariance($item->stok_db, $item->stok_real);
                $row[] = '<span id="var'.$i.'">'.$variance.'</span>';
                $data[] = $row;
                $i++;
            }
            echo json_encode($data);
        }
                
        function add(){
              $data = array(
                  'id_outlet' => $this->session->userdata('outlet'),
                  'tanggal' => $this->input->post('tanggal'),
                  'note' => $this->input->post('note'),
                  'username' => $this->session->userdata('username')
              );  
              $inserted =$this->opm->addData($data);
              echo json_encode(array('status' => $inserted));
        }
        function update(){
              $data = array(
                  'tanggal' => $this->input->post('tanggal'),
                  'note' => $this->input->post('note'),
                  'username' => $this->session->userdata('username')
              );  
              $inserted =$this->opm->updateData($data, $this->input->post('id'));
              echo json_encode(array('status' => $inserted));
        }
        function detail($id){
            $detail = $this->opm->detail('id_opname', $id);
            echo json_encode($detail);
        }
        function getVariance($stok, $real){
            $Ex = $stok + $real;
            $Ex2 = pow($stok,2) + pow($real,2);
            $Ex_2 = pow($Ex,2);
            $variance = (2*$Ex2 - $Ex_2)/(2*1);
            return number_format($variance,'2','.',',');
        }
}