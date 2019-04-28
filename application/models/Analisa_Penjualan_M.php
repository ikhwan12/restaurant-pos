<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Analisa_Penjualan_M extends My_Model {

     protected $_tabel = 'order';
     
    function get_data_hari($start, $end, $outlet){
        $where_outlet = '';  
        if($this->session->userdata('outlet') != ""){
            $where_outlet = 'AND id_outlet = '.$this->session->userdata('outlet');
        }else{
            if($outlet != ''){
               $where_outlet = 'AND id_outlet = '.$outlet;
            }
        }
        $query = 'SELECT tanggal, COUNT(id_order) as jumlah, SUM(total) as total '
                . 'FROM '
                . '( '
                . 'SELECT do.id_order as  id_order, DATE_FORMAT(tanggal,"%Y-%m-%d") as tanggal, SUM(jumlah*(harga_satuan+harga_pilihan))-diskon+(SUM(jumlah*(harga_satuan+harga_pilihan))-diskon)*o_ppn/100 as total '
                . 'FROM detail_order do '
                . 'LEFT JOIN `order` o ON do.id_order = o.id_order '
                . 'WHERE DATE(tanggal) BETWEEN '.$this->db->escape($start).' AND '.$this->db->escape($end).' '
                . 'AND proses = 1 AND bayar != 0 '
                . ''.$where_outlet.' '
                . 'GROUP BY do.id_order '
                . ') a '
                . 'GROUP BY tanggal';
        
        $a = $this->db->query($query);
        return $a->result();
    }
    function get_data_jam($start, $end, $outlet){
        $where_outlet = '';  
        if($this->session->userdata('outlet') != ""){
            $where_outlet = 'AND id_outlet = '.$this->session->userdata('outlet');
        }else{
            if($outlet != ''){
               $where_outlet = 'AND id_outlet = '.$outlet;
            }
        }
        $query = 'SELECT hour, COUNT(id_order) as jumlah, SUM(total) as total '
                . 'FROM '
                . '( '
                . 'SELECT do.id_order as  id_order, EXTRACT(HOUR FROM tanggal) as hour, SUM(jumlah*(harga_satuan+harga_pilihan))-diskon+(SUM(jumlah*(harga_satuan+harga_pilihan))-diskon)*o_ppn/100 as total '
                . 'FROM detail_order do '
                . 'LEFT JOIN `order` o ON do.id_order = o.id_order '
                . 'WHERE DATE(tanggal) BETWEEN '.$this->db->escape($start).' AND '.$this->db->escape($end).' '
                . 'AND proses = 1 AND bayar != 0 '
                . ''.$where_outlet.' '
                . 'GROUP BY do.id_order '
                . ') a '
                . 'GROUP BY hour';
        
        $a = $this->db->query($query);
        return $a->result();
    }
    
    
}
