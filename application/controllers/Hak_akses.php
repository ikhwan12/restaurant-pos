<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Hak_Akses extends MY_Controller {

	function  __construct() {
                parent::__construct();
                $this->load->model('Hak_Akses_M', 'ham');
                }
                
	public function index()
	{
                $this->get_menu();
                $data['title1'] = "Pengaturan Hak Akses";
                $data['table_title'] = "Hak Akses Modul";
		$this->load->view('pengaturan/hak_akses', $data);
		$this->load->view('footer');
                
	}
        
          function view($id_pos = ''){
            $list = $this->ham->get_datatables($id_pos);
            $data = array();
            $no = $_POST['start'];
            foreach ($list as $akses) {
                $no++;
                $row = array();
                $row[] = $no;
                $row[] = $akses->menu;
                $row[] = $akses->modul;
                if($akses->akses == 1){
                    $row[] = '<input type="checkbox" name="checkfield" id="check-'.$akses->id_modul_akses.'"  onchange="doalert(this, '."'".$akses->id_modul_akses."'".')" checked/>';
                }else{
                    $row[] = '<input type="checkbox" name="checkfield" id="check-'.$akses->id_modul_akses.'"  onchange="doalert(this, '."'".$akses->id_modul_akses."'".')"/>'; 
//              
                }
                 
                $data[] = $row;
            }

            $output = array(
                            "draw" => $_POST['draw'],
                            "recordsTotal" => $this->ham->count_all($id_pos),
                            "recordsFiltered" => $this->ham->count_filtered($id_pos),
                            "data" => $data,
                    );
            echo json_encode($output);
        }
        
        function ubah_akses($id){
            
            $data = array('akses' => $this->input->post('baca'));
            $diubah = $this->ham->update('id_modul_akses', $id, $data);
            echo json_encode(array('status'=> $diubah));
            
        }
        
        
        
        
        
        
}
