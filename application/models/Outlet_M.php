<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Outlet_M extends My_Model {

     protected $_tabel = 'outlet';
    
     var $table = 'outlet';
     var $column = array('id_outlet','nama_outlet','alamat_outlet','ppn'); //set column field database for order and search
     var $order = array('id_outlet' => 'asc'); // default order 
     
     private function _get_datatables_query()
        {
         
        $this->db->from($this->table);
 
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
        $this->db->from($this->table);
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
    
    function addAutoAssignMenu($outlet){
        $this->db->select('id_outlet');
        $this->db->where('nama_outlet',$outlet);
        $result = $this->db->get('outlet')->row();
        if(isset($result)){
            $id_outlet = $result->id_outlet;
            $this->db->where('auto_assign',1);
            $menu = $this->db->get('menu');
            if($menu->result()){
                foreach ($menu->result() as $item){
                    $data = array(
                        'id_outlet' => $id_outlet,
                        'id_menu' => $item->id_menu,
                        'harga' => $item->price,
                        'harga_gojek' => $item->gojek_price,
                    );
                    $this->db->insert('outlet_menu', $data);
                }
            }
        }
    }
    
    function outletData(){
        $result = $this->db->get($this->_tabel);
        return $result->result();
    }
     
}
