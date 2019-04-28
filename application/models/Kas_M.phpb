<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kas_M extends My_Model {

    protected $_tabel = 'kas';
    
    function get_table($jenis){
        $this->db->where("id_outlet",  $this->session->userdata('outlet'));
        $this->db->like("tgl",  date("Y-m-d"), "after");
        $this->db->where("keluar_masuk", $jenis);
        $result = $this->db->get($this->_tabel);
        return $result->result();
    }
    function get_rekap_table(){
        $this->db->where("id_outlet",  $this->session->userdata('outlet'));
        $this->db->like("tgl",  date("Y-m-d"), "after");
        $result = $this->db->get('rekap_kas');
        return $result->result();
    }
    
}
