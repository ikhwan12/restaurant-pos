<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Stok_Masuk_M extends My_Model {

     protected $_tabel = 'stok_masuk';
    
     var $table = 'stok_masuk';
     var $column = array('id_sm','id_outlet','tanggal','catatatn','username','id_sm'); //set column field database for order and search
     var $order = array('id_sm' => 'asc'); // default order 
     
     private function _get_datatables_query()
        {
         
        $this->db->from($this->table.' sk');
        $this->db->join('outlet o','sk.id_outlet = o.id_outlet','left');
        $this->db->join('pengguna p','sk.username = p.username','left');
        $this->db->where('sk.id_outlet',  $this->session->userdata('outlet'));
 
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
   
    
    function addData($data){
        $produk = $this->input->post('bahan');
        $jumlah = $this->input->post('qty');
        $status = $this->db->insert($this->_tabel, $data);
        $id_sm = $this->db->insert_id();
        if($status){
            for($i =0 ; $i < sizeof($produk); $i++){
                if($produk[$i] != -1){
                    $data2 = array(
                        'id_sm' => $id_sm,
                        'id_om' => $produk[$i],
                        'jumlah' => $jumlah[$i]
                    );
                    $success = $this->db->insert('detail_stok_masuk', $data2);
                    if($success){
                        $this->db->set('stok','stok+'.$jumlah[$i],FALSE);
                        $this->db->where('id_om',$produk[$i]);
                        $this->db->update('outlet_menu');
                    }
                }
            }
        }
        return $status;
    }
    function updateData($data, $id_sm){
        $produk = $this->input->post('bahan');
        $jumlah = $this->input->post('qty');
        $this->db->where('id_sm', $id_sm);
        $this->db->update($this->_tabel, $data);
        
        $this->db->where('id_sm', $id_sm);
        $barang = $this->db->get('detail_stok_masuk');
        if($barang->result()){
            foreach ($barang->result() as $item) {
                $this->db->set('stok','stok-'.$item->jumlah,FALSE);
                $this->db->where('id_om',$item->id_om);
                $this->db->update('outlet_menu');
                
                $this->db->where('id_sm', $id_sm);
                $this->db->where('id_om',$item->id_om);
                $this->db->delete('detail_stok_masuk');
            }
        }
        
        for($i =0 ; $i < sizeof($produk); $i++){
            if($produk[$i] != -1){
                $data2 = array(
                    'id_sm' => $id_sm,
                    'id_om' => $produk[$i],
                    'jumlah' => $jumlah[$i]
                );
                $success = $this->db->insert('detail_stok_masuk', $data2);
                if($success){
                    $this->db->set('stok','stok+'.$jumlah[$i],FALSE);
                    $this->db->where('id_om',$produk[$i]);
                    $this->db->update('outlet_menu');
                }
            }
        }
        return $success;
    }
    
    function getBarang($id){
        $list = '';
        $this->db->select('menu, dsm.jumlah, satuan');
        $this->db->join('outlet_menu om','dsm.id_om = om.id_om','left');
        $this->db->join('menu m','om.id_menu = m.id_menu','left');
        $this->db->where('id_sm',$id);
        $result = $this->db->get('detail_stok_masuk dsm');
        if($result->result()){
            $list .= "<ul>";
            foreach ($result->result() as $value) {
                $list .= '<li>'.$value->menu.' ('.$value->jumlah.' '.$value->satuan.')'.'</li>' ;
            }
            $list .= "</ul>";
        }
        return $list;
    }
    
    function getListBarang($id){
        $this->db->where('id_sm',$id);
        $result = $this->db->get('detail_stok_masuk');
        return $result->result();
    }
     
}
