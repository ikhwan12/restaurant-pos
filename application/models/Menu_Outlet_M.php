<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Menu_Outlet_M extends My_Model {

     protected $_tabel = 'outlet_menu';
    
     var $table = 'outlet_menu';
     var $column = array('id_om','menu','harga','harga_gojek'); //set column field database for order and search
     var $order = array('menu' => 'asc'); // default order 
     
     private function _get_datatables_query($id_outlet, $kategori)
        {
         
        $this->db->from($this->table.' om');
        $this->db->join('menu m', 'om.id_menu = m.id_menu', 'left');
        $this->db->join('kategori k', 'm.id_kategori = k.id_kategori', 'left');
        $this->db->where('id_outlet', $id_outlet);
        if($kategori == '0'){
            $this->db->where('harga_gojek !=', 0);
        }else if($kategori != ""){
            $this->db->where('m.id_kategori', $kategori);
        }
        $this->db->where('sold', 1);
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
        
    function count_filtered($id_outlet, $kategori)
    {
        $this->_get_datatables_query($id_outlet, $kategori);
        $query = $this->db->get();
        return $query->num_rows();
    }
 
    public function count_all($id_outlet, $kategori)
    {
        $this->_get_datatables_query($id_outlet, $kategori);
        return $this->db->count_all_results();
    }
    
    function get_datatables($id_outlet, $kategori)
    {
        $this->_get_datatables_query($id_outlet, $kategori);
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }
    
    function cek_added($outlet, $menu){
        $this->db->where('id_outlet', $outlet);
        $this->db->where('id_menu', $menu);
        $this->db->from($this->_tabel);
        $result = $this->db->count_all_results();
        if($result == 0){
            return true;
        }
        return false;
    }
     
    function updateStok($id_order){
        $this->db->select('id_menu, o.id_outlet, jumlah');
        $this->db->join('detail_order do','o.id_order = do.id_order');
        $this->db->join('outlet_menu om','do.id_om = om.id_om');
        $this->db->where('o.id_order', $id_order);
        $result = $this->db->get('order o');
        foreach ($result->result() as $value) {
            $this->db->where('id_menu',$value->id_menu);
            $result2 = $this->db->get('resep');
            if($result2->result()){
                foreach ($result2->result() as $bahan) {
                    $dec = $bahan->jumlah * $value->jumlah;
                    $this->db->set('stok','stok-'.$dec,FALSE);
                    $this->db->where('id_menu',$bahan->id_bahan);
                    $this->db->where('id_outlet',$value->id_outlet);
                    $this->db->update('outlet_menu');
                }
            }
        }
    }
    function warehouseData(){
        $this->db->join('menu m','om.id_menu = m.id_menu','left');
        $this->db->where('id_outlet',  $this->session->userdata('outlet'));
        $this->db->where('manage_stock',  1);
        $result = $this->db->get($this->_tabel.' om');
        return $result->result();
    }
    function getDetailProduk($id){
        $this->db->select('id_menu');
        $this->db->where('id_om', $id);
        $det = $this->db->get('outlet_menu')->row();
        $this->db->select('satuan');
        $this->db->where('id_menu',$det->id_menu);
        $result = $this->db->get('menu')->row();
        if(isset($result)){
            return $result;
        }else{
            return 0;
        }
        
    }
    
}
