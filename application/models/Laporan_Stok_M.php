<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan_Stok_M extends My_Model {

    protected $_tabel = 'outlet_menu';
     
    function getStok($outlet){
        $this->db->select('kategori, menu, om.stok as stok, satuan');
        $this->db->join('menu m','om.id_menu = m.id_menu','left');
        $this->db->join('kategori k','m.id_kategori = k.id_kategori','left');
        if($outlet == ""){
            $outlet = $this->session->userdata('outlet');
        }
        $this->db->where('id_outlet', $outlet);
        $this->db->where('manage_stock', 1);
        $result = $this->db->get('outlet_menu om');
        return $result->result();
    }
    
    
}
