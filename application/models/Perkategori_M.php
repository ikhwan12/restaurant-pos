<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Perkategori_M extends My_Model {

    protected $_tabel = 'detail_order';
     
    function getReport($start, $end, $outlet){
        $this->db->select('kategori, SUM(jumlah) as jumlah, SUM((harga_satuan+harga_pilihan)*jumlah) as total');
        $this->db->join('order o','do.id_order = o.id_order','left');
        $this->db->join('outlet_menu om','do.id_om = om.id_om','left');
        $this->db->join('menu n','om.id_menu = n.id_menu','left');
        $this->db->join('kategori k','n.id_kategori= k.id_kategori','left');
        if($outlet != ""){
            $this->db->where('o.id_outlet', $outlet);
        }
        $this->db->where('proses',1);
        $this->db->where('bayar !=',0);
        $this->db->where('DATE(tanggal) BETWEEN "'.$start.'" AND "'.$end.'"');
        $this->db->group_by('k.id_kategori');
        $this->db->order_by('kategori','asc');
        $result = $this->db->get($this->_tabel.' do');
        return $result->result();
    }
    
    function getPieData($start, $end, $outlet){
        $this->db->select('kategori, SUM(jumlah) as jumlah, SUM((harga_satuan+harga_pilihan)*jumlah) as total');
        $this->db->join('order o','do.id_order = o.id_order','left');
        $this->db->join('outlet_menu om','do.id_om = om.id_om','left');
        $this->db->join('menu n','om.id_menu = n.id_menu','left');
        $this->db->join('kategori k','n.id_kategori= k.id_kategori','left');
        if($outlet != ""){
            $this->db->where('o.id_outlet', $outlet);
        }
        $this->db->where('proses',1);
        $this->db->where('bayar !=',0);
        $this->db->where('DATE(tanggal) BETWEEN "'.$start.'" AND "'.$end.'"');
        $this->db->limit(5);
        $this->db->group_by('k.id_kategori');
        $this->db->order_by('total','desc');
        $result = $this->db->get($this->_tabel.' do');
        return $result->result();
    }
    
    
}
