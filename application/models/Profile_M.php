<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile_M extends My_Model {

    protected $_tabel = 'pengguna';
    
    function detail2(){
        $this->db->select('nama, alamat, no_telp, username, posisi');
        $this->db->from($this->_tabel.' p');
        $this->db->join('posisi s','p.id_posisi = s.id_posisi');
        $this->db->where('username', $this->session->userdata('username'));
        $result = $this->db->get()->row();
        return $result;
    }
    
}
