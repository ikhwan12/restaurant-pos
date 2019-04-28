<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Perproduk_M extends My_Model {

    protected $_tabel = 'detail_order';
     
    function getReport($start, $end, $outlet){
        $this->db->select('kategori, menu, tampilan, SUM(jumlah) as jumlah, SUM((harga_satuan+harga_pilihan)*jumlah) as total');
        $this->db->join('order o','do.id_order = o.id_order','left');
        $this->db->join('outlet_menu om','do.id_om = om.id_om','left');
        $this->db->join('menu n','om.id_menu = n.id_menu','left');
        $this->db->join('kategori k','n.id_kategori= k.id_kategori','left');
        $this->db->join('modifier m','do.id_modifier = m.id_modifier','left');
        if($outlet != ""){
            $this->db->where('o.id_outlet', $outlet);
        }
        $this->db->where('proses',1);
        $this->db->where('bayar !=',0);
        $this->db->where('DATE(tanggal) BETWEEN "'.$start.'" AND "'.$end.'"');
        $this->db->group_by('do.id_om, do.id_modifier');
        $this->db->order_by('menu','asc');
        $this->db->order_by('tampilan','asc');
        $result = $this->db->get($this->_tabel.' do');
        return $result->result();
    }
    
    function getReportSorted($start, $end, $outlet, $sort){
        $this->db->select('menu, tampilan, SUM(jumlah) as jumlah, SUM((harga_satuan+harga_pilihan)*jumlah) as total');
        $this->db->join('order o','do.id_order = o.id_order','left');
        $this->db->join('outlet_menu om','do.id_om = om.id_om','left');
        $this->db->join('menu n','om.id_menu = n.id_menu','left');
        $this->db->join('kategori k','n.id_kategori= k.id_kategori','left');
        $this->db->join('modifier m','do.id_modifier = m.id_modifier','left');
        if($outlet != ""){
            $this->db->where('o.id_outlet', $outlet);
        }
        $this->db->where('proses',1);
        $this->db->where('bayar !=',0);
        $this->db->where('DATE(tanggal) BETWEEN "'.$start.'" AND "'.$end.'"');
        $this->db->limit(10);
        $this->db->group_by('do.id_om, do.id_modifier');
        $this->db->order_by($sort,'desc');
        $result = $this->db->get($this->_tabel.' do');
        return $result->result();
    }
    
    
}
