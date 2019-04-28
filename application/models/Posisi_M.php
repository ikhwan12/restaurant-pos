<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Posisi_M extends My_Model {

     protected $_tabel = 'posisi';
    
     var $table = 'posisi';
     var $column = array('id_posisi','posisi'); //set column field database for order and search
     var $order = array('id_posisi' => 'asc'); // default order 
     
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
    
   function add_akses_modul($posisi){
        
        $this->db->select('id_posisi');
        $this->db->where('posisi', $posisi);
        $row = $this->db->get('posisi')->row();
        if (isset($row))
        {
            $result = $this->db->get('modul');
            foreach ($result->result() as $modul)
            {
                $akses = $tambah = $hapus = $ubah = 0;
                if($modul->modul != 'Outlet' && $modul->modul != 'Kategori' && $modul->modul != 'Menu' 
                        && $modul->modul != 'Posisi' && $modul->modul != 'Pengguna'
                        && $modul->modul != 'Stok Keluar' && $modul->modul != 'Stok Masuk' && $modul->modul != 'Supplier'
                        && $modul->modul != 'Purchase Order' && $modul->modul != 'Opname' && $modul->id_parent_modul != 6){
                    $akses = $tambah = $hapus = $ubah = 1;
                }
                $data = array(
                    'id_modul' => $modul->id_modul,
                    'id_posisi' => $row->id_posisi,
                    'akses'  =>  $akses,
                    'tambah'  =>  $tambah,
                    'ubah'  =>  $ubah,
                    'hapus' =>  $hapus
                );
                $this->db->insert('akses', $data);
            }
        }
    }
    
    function get_all_menu($id_posisi){
        $this->db->select('id_akses, parent_modul, modul, akses');
        $this->db->join('modul m','a.id_modul = m.id_modul','left');
        $this->db->join('parent_modul p','m.id_parent_modul = p.id_parent_modul','left');
        $this->db->where('a.id_posisi',$id_posisi);
        $this->db->order_by('urutan','asc');
        $this->db->order_by('modul','asc');
        $result = $this->db->get('akses a');
        return $result->result();
    }
    
    function savePrevilage($id, $modul){
        $this->db->set('akses',0);
        $this->db->where('id_posisi',$id);
        $this->db->update('akses');
        foreach ($modul as $item){
            if(is_numeric($item)){
                $this->db->set('akses',1);
                $this->db->where('id_akses',$item);
                $this->db->update('akses');
            }
        }
        return TRUE;
    }
     
}
