<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Opname_M extends My_Model {

     protected $_tabel = 'opname';
    
     var $table = 'opname';
     var $column = array('id_opname','op.id_outlet','tanggal','note','op.username','id_opname'); //set column field database for order and search
     var $order = array('id_opname' => 'asc'); // default order 
     
     private function _get_datatables_query()
        {
         
        $this->db->from($this->table.' op');
        $this->db->join('outlet o','op.id_outlet = o.id_outlet','left');
        $this->db->join('pengguna p','op.username = p.username','left');
        $this->db->where('op.id_outlet',  $this->session->userdata('outlet'));
 
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
   
    function getInventory($outlet){
        $this->db->select('id_om, menu, om.stok as stok, satuan');
        $this->db->join('menu m','om.id_menu = m.id_menu','left');
        $this->db->where('id_outlet', $outlet);
        $this->db->where('manage_stock', 1);
        $result = $this->db->get('outlet_menu om');
        return $result->result();
    }
    function getInventory2($id_opname){
        $this->db->select('do.id_om as id_om, menu, do.stok_db, stok_real');
        $this->db->join('outlet_menu om','do.id_om = om.id_om','left');
        $this->db->join('menu m','om.id_menu= m.id_menu','left');
        $this->db->where('do.id_opname', $id_opname);
        $result = $this->db->get('detail_opname do');
        return $result->result();
    }
    
    function addData($data){
        $id_om = $this->input->post('idom');
        $stok = $this->input->post('stok');
        $real = $this->input->post('real');
        $this->db->insert('opname', $data);
        $id_opname = $this->db->insert_id();
        $variance = $this->input->post('variance');
        for($i = 0; $i < sizeof($id_om); $i++){
            if($real[$i] == ""){
                $real[$i] = $stok[$i];
            }
            $op = array(
                'id_opname' => $id_opname,
                'id_om' => $id_om[$i],
                'stok_db' => $stok[$i],
                'stok_real' => $real[$i],
            );
            $success = $this->db->insert('detail_opname', $op);
        }
        return $success;
    }
    
    function updateData($data, $id_opname){
        $id_om = $this->input->post('idom');
        $real = $this->input->post('real');
        $this->db->where('id_opname', $id_opname);
        $this->db->update('opname', $data);
        for($i = 0; $i < sizeof($id_om); $i++){
            if($real[$i] == ""){
                $real[$i] = $stok[$i];
            }
            $op = array(
                'stok_real' => $real[$i],
            );
            $this->db->where('id_om', $id_om[$i]);
            $this->db->where('id_opname', $id_opname);
            $this->db->update('detail_opname', $op);
        }
        return TRUE;
    }
}
