<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Printer_M extends My_Model {

     protected $_tabel = 'order';
    
     function getPrinter(){
         $this->db->select('printer');
         $this->db->where('id_outlet', $this->session->userdata('outlet'));
         $prt = $this->db->get('outlet')->row();
         return $prt->printer;
     }
             
    function getOutlet(){
        $this->db->where('id_outlet',  $this->session->userdata('outlet')); 
        $outlet = $this->db->get('outlet')->row(); 
        return $outlet;
    }
    
    function getDetailOrder($id){
        $this->db->where('id_order', $id); 
        $order = $this->db->get('order')->row();
        return $order;
    }
    
    function getOrderItem($id){
        $this->db->select('menu, tampilan, (harga_satuan + harga_pilihan) as harga, jumlah');
        $this->db->join('outlet_menu om','do.id_om = om.id_om','left');
        $this->db->join('menu m','om.id_menu = m.id_menu','left');
        $this->db->join('modifier mo','do.id_modifier = mo.id_modifier','left');
        $this->db->where('id_order', $id);
        $this->db->order_by('menu', 'asc');
        $this->db->order_by('tampilan', 'asc');
        $listItem = $this->db->get('detail_order do');
        return $listItem->result();
    }
     
}
