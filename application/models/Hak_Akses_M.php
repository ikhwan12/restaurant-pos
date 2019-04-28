<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Hak_Akses_M extends My_Model {

     protected $_tabel = 'modul_akses';
     var $table = 'modul_akses';
     var $column = array('id_modul_akses','menu','modul','akses'); //set column field database for order and search
     var $order = array('id_modul_akses' => 'desc'); // default order 
     
     private function _get_datatables_query($id_pos)
        {
         
        $this->db->from($this->table.' ma, modul m, menu n');
        $this->db->where('id_posisi', $id_pos);
        $this->db->where('ma.id_modul = m.id_modul');
        $this->db->where('m.id_menu= n.id_menu');
 
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
        
    function count_filtered($id_pos)
    {
        $this->_get_datatables_query($id_pos);
        $query = $this->db->get();
        return $query->num_rows();
    }
 
    public function count_all($id_pos)
    {
        $this->db->from($this->table.' ma, modul m');
        $this->db->where('id_posisi', $id_pos);
        $this->db->where('ma.id_modul = m.id_modul');
        return $this->db->count_all_results();
    }
    
    function get_datatables($id_pos)
    {
        $this->_get_datatables_query($id_pos);
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }
    
}
