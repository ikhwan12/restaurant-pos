<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Rekapkas_M extends My_Model {

    protected $_tabel = 'rekap_kas';
    
    function get_table(){
        $this->db->where("id_outlet",  $this->session->userdata('outlet'));
        $this->db->like("tgl",  date("Y-m-d"), "after");
        $result = $this->db->get($this->_tabel);
        return $result->result();
    }
    
    function get_tableByID($id){
        $this->db->where('id_rekap_kas',$id);
        $row = $this->db->get('rekap_kas')->row();
        return $row;        
    }
            
    function getTotalPenjualan($tgl, $jenis){
        $date = explode(" ", $tgl);
        $this->db->select('o_ppn, diskon, SUM((harga_satuan + harga_pilihan)*jumlah) as jumlah');
        $this->db->join('order o','do.id_order = o.id_order','left');
        $this->db->where('id_outlet',  $this->session->userdata('outlet'));
        $this->db->where('proses',1);
        $this->db->where('bayar !=',0);
        if($jenis == "TUNAI"){
            $this->db->where('jenis_bayar',  'TUNAI');
        }else{
            $this->db->where('jenis_bayar !=',  'TUNAI');
        }
        
        $this->db->like('tanggal',$date[0],'after');
        $this->db->where('tanggal <=',$tgl);
        $this->db->group_by('do.id_order');
        $result = $this->db->get('detail_order do');
        if($result->result()){
            $jumlah = 0;
            foreach ($result->result() as $item) {
                $subtotal = $item->jumlah - $item->diskon;
                $total = $item->jumlah - $item->diskon + ($subtotal * $item->o_ppn/100);
                $jumlah += $total;
            }
            return ceil($jumlah);
        }else{
            return 0;
        }
    }
    
    function getTotalKas($tgl, $jenis){
        $date = explode(" ", $tgl);
        $this->db->select('COALESCE(SUM(jumlah),0) as jumlah');
        $this->db->where('keluar_masuk',  $jenis);
        $this->db->where('id_outlet',  $this->session->userdata('outlet'));
        $this->db->like('tgl',$date[0],'after');
        $this->db->where('tgl <=',$tgl);
        $result = $this->db->get('kas')->row();
        return $result->jumlah;
    }
    
    function getJumlahJual($date, $dateTime){
        $this->db->select("COUNT(id_order) as jumlah");
        $this->db->where('id_outlet',  $this->session->userdata('outlet'));
        $this->db->where('proses',1);
        $this->db->where('bayar !=',0);
        $this->db->like('tanggal',$date,'after');
        $this->db->where('tanggal <=',$dateTime);
        $row = $this->db->get('order')->row();
        return $row->jumlah;
    }
    
}
