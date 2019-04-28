<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pengguna extends MY_Controller {

	function  __construct() {
                parent::__construct();
                $this->load->model('Pengguna_M', 'pengguna');
                }
                
	public function index()
	{
                $this->get_menu();
                $data['title1'] = "Pengguna";
                $data['table_title'] = "Daftar Pengguna";
		$this->load->view('data/pengguna', $data);
		$this->load->view('footer');
                
	}
        
        function daftar_pengguna(){
            $list = $this->pengguna->get_list('id_pengguna', 'pengguna', "Pilih Divisi...");
            echo json_encode($list);
        }
        
         function view(){
            $list = $this->pengguna->get_datatables();
            $data = array();
            $no = $_POST['start'];
            foreach ($list as $pengguna) {
                $no++;
                $row = array();
                $row[] = $pengguna->username;
                $row[] = $pengguna->nama;
                $row[] = $pengguna->alamat;
                $row[] = $pengguna->no_telp;
                $row[] = $pengguna->posisi;
                $row[] = $pengguna->nama_outlet;
                if($pengguna->aktif == 1){
                    $row[] = "Aktif";
                }else{
                    $row[] = "Non Aktif";
                }
                if($pengguna->status == 1){
                    $row[] = "<span class='badge bg-green'>online</span>";
                }else{
                     $row[] = "<span class='badge bg-red'>offline</span>";
                }
                $data[] = $row;
            }

            $output = array(
                            "draw" => $_POST['draw'],
                            "recordsTotal" => $this->pengguna->count_all(),
                            "recordsFiltered" => $this->pengguna->count_filtered(),
                            "data" => $data,
                    );
            echo json_encode($output);
        }
        
        
        function add(){
            $data = array(
                'username' => $this->input->post('username'),
                'password' => password_hash($this->input->post('password'), PASSWORD_BCRYPT),
                'nama' => $this->normalize_text(('nama')),
                'alamat' => $this->normalize_text(('alamat')),
                'no_telp' => $this->input->post('no_telp'),
                'id_posisi' => $this->input->post('id_posisi'),
                'id_outlet' => $this->input->post('outlet'),
                'aktif' => $this->input->post('aktif')
            );
             $inserted = $this->pengguna->add($data);
             echo json_encode(array('status' => $inserted));
        }
        
        function detail($id){
            $detail = $this->pengguna->detail('username', $id);
            echo json_encode($detail);
        }
        
        function update(){
            if($this->input->post('password') == '--------'){
                $data = array(
                    'username' => $this->input->post('username'),
                    'nama' => $this->normalize_text(('nama')),
                    'alamat' => $this->normalize_text(('alamat')),
                    'no_telp' => $this->input->post('no_telp'),
                    'id_outlet' => $this->input->post('outlet'),
                    'id_posisi' => $this->input->post('id_posisi'),
                    'aktif' => $this->input->post('aktif')
                 );
            }else{
                $data = array(
                    'username' => $this->input->post('username'),
                    'password' => password_hash($this->input->post('password'), PASSWORD_BCRYPT),
                    'nama' => $this->normalize_text(('nama')),
                    'alamat' => $this->normalize_text(('alamat')),
                    'no_telp' => $this->input->post('no_telp'),
                    'id_outlet' => $this->input->post('outlet'),
                    'id_posisi' => $this->input->post('id_posisi'),
                    'aktif' => $this->input->post('aktif')
                 );
            }
             
             $status = $this->pengguna->update('username', $this->input->post('id'), $data);
             echo json_encode(array('status' => $status));
        }
        
        function delete($id){
                    
            $status = $this->pengguna->delete('username', $id);
            echo json_encode(array('status' => $status));
        }
        
         function generateID(){
             $detail = $this->pengguna->generateID($this->input->post('posisi'));
             echo json_encode($detail);
        }
        
        
        
}
