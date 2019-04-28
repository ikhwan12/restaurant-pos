<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Detail_Order_M extends My_Model {

     protected $_tabel = 'detail_order';
    
     var $table = 'detail_order';
     var $column = array('id_detail_order','menu','harga_satuan'); //set column field database for order and search
     var $order = array('id_order' => 'asc'); // default order 
     
     private function _get_datatables_query($id_order)
        {
         
        $this->db->from($this->table.' do');
        $this->db->join('outlet_menu om','do.id_om = om.id_om','left');
        $this->db->join('menu m','om.id_menu = m.id_menu','left');
        $this->db->join('modifier mo','do.id_modifier = mo.id_modifier','left');
        $this->db->where('id_order', $id_order);
 
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
        
    function count_filtered($id_order)
    {
        $this->_get_datatables_query($id_order);
        $query = $this->db->get();
        return $query->num_rows();
    }
 
    public function count_all($id_order)
    {
        $this->_get_datatables_query($id_order);
        return $this->db->count_all_results();
    }
    
    function get_datatables($id_order)
    {
        $this->_get_datatables_query($id_order);
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }
    
    function item_exist($id_order, $id_om, $harga){
        $this->db->where('id_order',$id_order);
        $this->db->where('id_om',$id_om);
        $this->db->where('harga_satuan',$harga);
        $this->db->from($this->_tabel);
        $result = $this->db->count_all_results();
        if($result == 0){
            return false;
        }
        return true;
    }
    
    function update_qty($id_order, $id_om, $harga){
        $this->db->set('jumlah', 'jumlah+1', FALSE);
        $this->db->where('id_order',$id_order);
        $this->db->where('id_om',$id_om);
        $this->db->where('harga_satuan',$harga);
        $this->db->update($this->_tabel);
        if($this->db->affected_rows() > 0){
            return TRUE;
        }
        return FALSE;
        
    }
     
    function get_item($id_order){
        $item = '';
        $this->db->select('menu, jumlah, tampilan, harga_pilihan, do.id_modifier as id_modifier');
        $this->db->join('outlet_menu om','do.id_om = om.id_om','left');
        $this->db->join('menu m','om.id_menu = m.id_menu','left');
        $this->db->join('modifier mo','do.id_modifier = mo.id_modifier','left');
        $this->db->where('id_order', $id_order);
        $result = $this->db->get($this->_tabel.' do');
        if($result->result()){
            foreach ($result->result() as $row) {
                if($row->harga_pilihan == 0 && $row->id_modifier == ''){
                    $item .= $row->menu.' x'.$row->jumlah.'; ';
                }else{
                    $item .= $row->menu.' x'.$row->jumlah.' + '.$row->tampilan.' @'.number_format($row->harga_pilihan,'0',',','.').'; ';
                }
            }
        }
        return $item;
    }
    
    function addWithOption($data){
        $this->db->where('id_order', $data['id_order']);
        $this->db->where('id_om', $data['id_om']);
        $this->db->where('harga_satuan', $data['harga_satuan']);
        $this->db->where('id_modifier', $data['id_modifier']);
        $this->db->where('harga_pilihan', $data['harga_pilihan']);
        $result = $this->db->get($this->table)->row();
        if(isset($result)){
            $this->db->set('jumlah', 'jumlah+'.$data['jumlah'], FALSE);
            $this->db->where('id_order', $data['id_order']);
            $this->db->where('id_om', $data['id_om']);
            $this->db->where('id_modifier', $data['id_modifier']);
            $this->db->where('harga_satuan', $data['harga_satuan']);
            $this->db->where('harga_pilihan', $data['harga_pilihan']);
            $this->db->update($this->_tabel);
        }else{
            $this->db->insert($this->_tabel, $data);
        }
        return TRUE;
    }
}
