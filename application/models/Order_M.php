<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Order_M extends My_Model {

     protected $_tabel = 'order';
    
     var $table = 'order';
     var $column = array('o.id_order','tanggal','nama','customer','o.id_order','subtotal'); //set column field database for order and search
     var $order = array('o.id_order' => 'asc'); // default order 
     
     private function _get_datatables_query()
        {
        
        $this->db->select('o.id_order, tanggal, nama, customer, o_ppn, SUM(jumlah*(harga_pilihan+harga_satuan)) as subtotal, diskon'); 
        $this->db->from($this->table.' o');
        $this->db->join('detail_order do', 'o.id_order = do.id_order','left');
        $this->db->join('pengguna p', 'o.username = p.username','left');
        $this->db->where('o.id_outlet',  $this->session->userdata('outlet'));
        $this->db->where('proses',1);
        $this->db->where('meja IS NULL');
        $this->db->where('bayar',0);
        $this->db->group_by('o.id_order');
 
        $i = 0;
     
        foreach ($this->column as $item) // loop column 
        {
            if($_POST['search']['value']) // if datatable send POST for search
            {
                 
                if($i===0) // first loop
                {
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND. 
                    $this->db->like($item, $_POST['search']['value']);
                }
                else
                {
                    $this->db->or_like($item, $_POST['search']['value']);
                }
 
                if(count($this->column) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $column[$i] = $item; // set column array variable to order processing
            $i++;
        }
         
        if(isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($column[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } 
        else if(isset($this->order))
        {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }
        
    function count_filtered()
    {
        $this->_get_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }
 
    public function count_all()
    {
        $this->_get_datatables_query();
        return $this->db->count_all_results();
    }
    
    function get_datatables()
    {
        $this->_get_datatables_query();
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }
    
    
    function generateID(){
        
        $seg1 = "OD".$this->session->userdata('outlet').'-'.date("Ymd")."-";
        $this->db->select("MAX(RIGHT(`id_order`, 4)) as 'maxID'");
        $this->db->like('id_order',$seg1,'after');
        $this->db->where('id_outlet',  $this->session->userdata('outlet'));
        //$this->db->where('proses',1);
        $result = $this->db->get($this->_tabel);
        $code = $result->row(0)->maxID;
        $code++; 
        $data = array(
                'id' => $seg1.sprintf("%04s", $code)
            ); 
        
        return $data;
    }
    
    function check_exist($kode){
        $this->db->where('id_order', $kode);
        $result = $this->db->get($this->_tabel);
        if($result->result()){
            return TRUE;
        }
        return FALSE;
    }
    
    function detail_order($id_order){
        $this->db->select('customer, meja, ppn, o_ppn, SUM(jumlah*(harga_satuan+harga_pilihan)) as subtotal, diskon');
        $this->db->join('detail_order do', 'o.id_order = do.id_order','left');
        $this->db->join('outlet t', 'o.id_outlet = t.id_outlet','left');
        $this->db->where('o.id_order', $id_order);
        $this->db->group_by('o.id_order');
        $result = $this->db->get($this->_tabel.' o');
        if($result->result()){
            return $result->row();
        }
        return false;
    }
    
    function check_processed($id_order){
        $this->db->select('proses');
        $this->db->where('id_order', $id_order);
        $result = $this->db->get($this->_tabel)->row();
        if($result->proses == 1){
            return true;
        }
        return false;
    }
    
    function cek_paid($id_order){
        $this->db->select('bayar');
        $this->db->where('id_order', $id_order);
        $result = $this->db->get($this->_tabel)->row();
        if(isset($result)){
            if($result->bayar != 0){
                return true;
            }
        }
        return false;
    }
    
    function get_kembali($id_order){
        $kembali = 0;
        $this->db->select('SUM((harga_pilihan+harga_satuan)*jumlah) as subtotal, o_ppn, diskon, bayar');
        $this->db->join('order o', "do.id_order = o.id_order", 'left');
        $this->db->where('do.id_order', $id_order);
        $this->db->group_by('do.id_order');
        $result = $this->db->get('detail_order do')->row();
        if(isset($result)){
            return $result->bayar - ($result->subtotal - $result->diskon + (($result->subtotal - $result->diskon)*$result->o_ppn/100));
        }
        return 0;
        
    }
    
    function get_cara_bayar($id_order){
        $this->db->select('jenis_bayar');
        $this->db->where('id_order', $id_order);
        $result = $this->db->get($this->_tabel)->row();
        if(isset($result)){
            return ucfirst($result->jenis_bayar);
        }
        return '';
    }
    
    
    function haveOption($id){
        $this->db->select('id_menu');
        $this->db->where('id_om', $id);
        $this->db->where('id_outlet', $this->session->userdata('outlet'));
        $menu = $this->db->get('outlet_menu')->row();
        
        $this->db->select('mm.id_modifier as id_modifier, tampilan, harga_modifier');
        $this->db->join('modifier m', 'mm.id_modifier = m.id_modifier','left');
        $this->db->where('id_menu', $menu->id_menu);
        $result = $this->db->get('menu_modifier mm');
        return $result->result();
    }
    
    
    
    
}
