<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pengguna_M extends My_Model {

     protected $_tabel = 'pengguna';
    
     var $table = 'pengguna';
     var $column = array('username','nama','alamat','no_telp','posisi','nama_outlet','aktif','status'); //set column field database for order and search
     var $order = array('username' => 'desc'); // default order 
     
     private function _get_datatables_query()
        {
         
        $this->db->from($this->table.' p');
        $this->db->join('posisi s','p.id_posisi = s.id_posisi','left');
        $this->db->join('outlet o','p.id_outlet = o.id_outlet','left');
 
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
    
     function generateID($text){
        
        $seg1 = 'SPK-';
        $seg2 = substr(strtoupper($text), 0, 3).'-';
         
        $this->db->select("MAX(RIGHT(`username`, 3)) as 'maxID'");
        $this->db->like("username", $seg1.$seg2, 'after');
        $result = $this->db->get('pengguna');
        $code = $result->row(0)->maxID;
        $code++; 
        $data = array(
                'id' => $seg1.$seg2.sprintf("%03s", $code)
            ); 
        
        return $data;
    }
    
    
     
}
