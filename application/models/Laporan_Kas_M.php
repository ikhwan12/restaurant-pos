<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan_Kas_M extends My_Model {

    protected $_tabel = 'rekap_kas';
     
    function getRekap($start, $end, $outlet){
        $this->db->join('outlet o','rk.id_outlet = o.id_outlet','left');
        if($outlet != ""){
            $this->db->where('rk.id_outlet', $outlet);
        }
        $this->db->where('DATE(tgl) BETWEEN "'.$start.'" AND "'.$end.'"');
        $result = $this->db->get($this->_tabel.' rk');
        return $result->result();
    }
    
    
}
