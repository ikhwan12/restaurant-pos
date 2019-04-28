<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Omset_M extends My_Model {

     protected $_tabel = 'order';
    
     function getLabelHours($start, $outlet){
         $lbl = array();
         $this->db->select('DATE_FORMAT(tanggal, "%H") as hour');
         $this->db->where("DATE_FORMAT(tanggal, '%Y-%m-%d') =", $start);
         if($outlet != "" && $outlet != 'null'){
             $this->db->where('id_outlet',$outlet);
         }
         $this->db->where('proses',1);
         $this->db->where('bayar !=',0);
         $this->db->group_by('DATE_FORMAT(tanggal, "%H")');
         $result = $this->db->get('order');
         if($result->result()){
             foreach ($result->result() as $hour){
                 $lbl[] = $hour->hour.':00';
             }
         }
         return $lbl;
     }
     function getLabel($start, $end, $outlet){
         $lbl = array();
         $this->db->select('DATE_FORMAT(tanggal, "%Y-%m-%d") as tanggal');
         $this->db->where("DATE_FORMAT(tanggal, '%Y-%m-%d') >=", $start);
         $this->db->where("DATE_FORMAT(tanggal, '%Y-%m-%d') <=", $end);
         $this->db->where('proses',1);
         $this->db->where('bayar !=',0);
         if($outlet != "" && $outlet != 'null'){
             $this->db->where('id_outlet',$outlet);
         }
         $this->db->group_by('DATE_FORMAT(tanggal, "%Y-%m-%d")');
         $result = $this->db->get('order');
         if($result->result()){
             foreach ($result->result() as $hour){
                 $lbl[] = $hour->tanggal;
             }
         }
         return $lbl;
     }
     
     function getListOutlet(){
         $result = $this->db->get('outlet');
         return $result->result();
     }
     function getOutlet($id){
         $this->db->where('id_outlet',$id);
         $result = $this->db->get('outlet')->row();
         return $result;
     }
     function getDataOmset($outlet, $value, $start, $end){
         if($start == $end){
             $result = $this->getDataOmsetHour($outlet, $value, $start);
         }else{
             $result = $this->getDataOmsetRange($outlet, $value);
         }
         
         return $result;
     }
     
     function getDataOmsetHour($outlet, $value, $start){
         $total = 0;
         $this->db->select('id_order');
         $this->db->like("tanggal", $start.' '.substr($value, 0, 2),'after');
         $this->db->where('id_outlet',$outlet);
         $this->db->where('proses',1);
         $this->db->where('bayar !=',0);
         $result = $this->db->get('order');
         
         if($result->result()){
             foreach ($result->result() as $order){
                 $this->db->select('SUM(jumlah*(harga_satuan+harga_pilihan)) as total, diskon, o_ppn');
                 $this->db->join('order o', 'do.id_order = o.id_order','left');
                 $this->db->where('do.id_order', $order->id_order);
                 $this->db->group_by('do.id_order');
                 $t = $this->db->get('detail_order do')->row();
                 $total += ($t->total - $t->diskon + (($t->total - $t->diskon)*($t->o_ppn/100)));
             }
             
         }
         return $total;
     }
     function getDataOmsetRange($outlet, $value){
         $total = 0;
         $this->db->select('id_order');
         $this->db->like("tanggal", $value,'after');
         $this->db->where('id_outlet',$outlet);
         $this->db->where('proses',1);
         $this->db->where('bayar !=',0);
         $result = $this->db->get('order');
         
         if($result->result()){
             foreach ($result->result() as $order){
                 $this->db->select('SUM(jumlah*(harga_satuan+harga_pilihan)) as total, diskon, o_ppn');
                 $this->db->join('order o', 'do.id_order = o.id_order','left');
                 $this->db->where('do.id_order', $order->id_order);
                 $this->db->group_by('do.id_order');
                 $t = $this->db->get('detail_order do')->row();
                 $total += ($t->total - $t->diskon + (($t->total - $t->diskon)*($t->o_ppn/100)));
             }
             
         }
         return $total;
     }
}
