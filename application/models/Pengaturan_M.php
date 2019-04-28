<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pengaturan_M extends My_Model {

     protected $_tabel = 'outlet';
    
     function detail_pengaturan(){
         $this->db->select('ppn, printer');
         $this->db->where('id_outlet', $this->session->userdata('outlet'));
         $result = $this->db->get($this->_tabel)->row();
         return $result;        
     }
     
     function get_printer(){
         $printer = "";
         $this->db->select('printer');
         $this->db->where('id_outlet', $this->session->userdata('outlet'));
         $result = $this->db->get($this->_tabel)->row();
         if(isset($result)){
             $printer = $result->printer;
         }
         return $printer;        
     }
}
