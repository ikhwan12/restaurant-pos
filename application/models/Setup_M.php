<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Setup_M extends CI_Model {
    
    function  __construct() {
                parent::__construct();
                
                }
    
    function cek_table_posisi()
    {
        $this->load->database();
        $result = $this->db->get('posisi');
        if($result->num_rows() > 0){
            return TRUE;
        }
        return FALSE;
       
    }
    function cek_table_pengguna()
    {
        $this->load->database();
        $result = $this->db->get('pengguna');
        if($result->num_rows() > 0){
            return TRUE;
        }
        return FALSE;
       
    }
    function get_list_posisi($key, $value, $empty_selection) {
        $this->load->database();
        $query = $this->db->get('posisi');
        $list = array();
        $list[''] = $empty_selection;
        if($query->result()){
            foreach ($query->result() as $item) {
                $list[$item->$key] = $item->$value;
            }
        } 
        return $list;
    }
    
    function add_posisi($data){
        $this->load->database();
        $inserted = $this->db->insert('posisi', $data);
        return $inserted;
    }
    
    function add_first_akses_modul($posisi){
        $status = false;
        $this->load->database();
        $this->db->select('id_posisi');
        $this->db->where('posisi', $posisi);
        $row = $this->db->get('posisi')->row();
        if (isset($row))
        {
            $result = $this->db->get('modul');
            foreach ($result->result() as $modul)
            {
                $data = array(
                    'id_modul' => $modul->id_modul,
                    'id_posisi' => $row->id_posisi,
                    'akses'  =>  1,
                    'tambah'  =>  1,
                    'ubah'  =>  1,
                    'hapus' =>  1
                );
                $status = $this->db->insert('akses', $data);
            }
        }
        return $status;
    }
            
    function add_admin($data){
        $this->load->database();
        $inserted = $this->db->insert('pengguna', $data);     
        if($inserted){
            $my_outlet = array(
                'nama_outlet' => "Outlet 1",
                'ppn' => "10",
            );
            $this->db->insert('outlet', $my_outlet);
            $id_outlet = $this->db->insert_id();
            $this->db->set('id_outlet', $id_outlet);
            $this->db->update('pengguna');
        }
        return $inserted;
    }
    
    
    function generateID($text){
        
        $seg1 = 'SPK-';
        $seg2 = substr(strtoupper($text), 0, 3).'-';
         
        $this->db->select("MAX(RIGHT(`username`, 3)) as 'maxID'");
        $this->db->like("username", $seg1.$seg2, 'after');
        $result = $this->db->get('pengguna');
        $code = $result->row(0)->maxID;
        $code++; 
        $data = array(
                'id' => $seg1.$seg2.sprintf("%03s", $code)
            ); 
        
        return $data;
    }
    
    function check_connection($host, $username, $password, $db_name){
        $cerl = error_reporting ();
        error_reporting (0);
        $data = array(); $data['status'] = FALSE; $data['message'] = "";
        
        $mysqli = mysqli_init();
        if (!$mysqli) {
            $data['mysqli_init failed'] = "";
        }
        if (!$mysqli->options(MYSQLI_INIT_COMMAND, 'SET AUTOCOMMIT = 0')) {
            $data['message'] = "Setting MYSQLI_INIT_COMMAND failed";
        }
        if (!$mysqli->options(MYSQLI_OPT_CONNECT_TIMEOUT, 5)) {
            $data['message'] = "Setting MYSQLI_OPT_CONNECT_TIMEOUT failed";
        }
        if (!$mysqli->real_connect($host, $username, $password, $db_name)) {
            if(mysqli_connect_errno() != 1049){
                $data['message'] = 'Connect Error (' . mysqli_connect_errno() . ') '. mysqli_connect_error();
            }else{
                $data['status'] = TRUE;
            }
        }else{
            $mysqli->close();
            $this->temp_connection($host, $username, $password, '');
            $this->load->dbutil();
            if($this->dbutil->database_exists($db_name)){
                $data['message'] = "Can't Use Database. Database Exist.";
            }else{
                $data['status'] = TRUE;
            }
            $this->db->close();
        }
        
        error_reporting($cerl);
        return $data;
        
    }
            
    function create_database($host, $username, $password="", $db_name){
        $status = FALSE;
        $this->temp_connection($host, $username, $password, "");
        $this->load->dbforge();
        $status = $this->dbforge->create_database($db_name);
        $this->db->close();
        return $status;
    }
    
    function check_act_license(){
        $status = FALSE;
        $this->db->select('serial');
        $row = $this->db->get('activation')->row();
        if(isset($row)){
            $this->db->select('serial');
            $result = $this->db->get('license');
            if($result->result()){
                $status = $this->check_license($result->result(), $row->serial);
            }
        }
        return $status;
    }
    
    function first_migration($host, $username, $password="", $db_name){
            $this->temp_connection($host, $username, $password, $db_name);
            $this->load->library('migration');
            $status = $this->migration->version('20161018164600');
            $this->migration->error_string();
            $this->db->close();
            return $status;
        }
    
    function activate(){
        $this->load->database();
        $status = FALSE;
        $this->db->select('serial');
        $result = $this->db->get('license');
        if($result->result()){
            foreach ($result->result() as $value) {
                if(password_verify($this->input->post('serial'), $value->serial)){
                    $status = TRUE;
                    $this->db->empty_table('activation');
                    $this->db->insert('activation',array('serial' => $this->input->post('serial')));
                    break;
                }
            }
        }
        return $status;
    }    
    
    function activated_migration(){
        $this->load->database();
        $this->load->library('migration');
        $status = $this->migration->version('20161018212100');
        $this->migration->error_string();
        $this->db->close();
        return $status;
    }
            
    function check_license($license, $serial){
        foreach ($license as $value) {
            if(password_verify($serial, $value->serial)){
                return TRUE;
            }
        }
        return FALSE;
    }
    
    function check_registration(){
        $result = $this->db->count_all_results('pengguna');
        if($result > 0){
            return TRUE;
        }
        return FALSE;
    }
    
    function temp_connection($host, $username, $password="", $db_name){
        $this->db->close();
        $config['hostname'] = $host;
        $config['username'] = $username;
        $config['password'] = $password;
        $config['database'] = $db_name;
        $config['dbdriver'] = 'mysqli';
        $config['dbprefix'] = '';
        $config['pconnect'] = FALSE;
        $config['db_debug'] = TRUE;
        $config['cache_on'] = FALSE;
        $config['cachedir'] = '';
        $config['char_set'] = 'utf8';
        $config['dbcollat'] = 'utf8_general_ci';
        $this->load->database($config);
    }
}