<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan_Penjualan_M extends My_Model {

     protected $_tabel = 'order';
    
     var $table = 'order';
     var $column = array('o.id_order','tanggal','nama','customer','o.id_order','subtotal'); //set column field database for order and search
     var $order = array('o.id_order' => 'asc'); // default order 
     
     private function _get_datatables_query($start, $end, $outlet)
        {
        
        $this->db->select('o.id_order, tanggal, nama_outlet, catatan, nama, customer, o_ppn, SUM(jumlah*(harga_satuan+harga_pilihan)) as subtotal, diskon'); 
        $this->db->from($this->table.' o');
        $this->db->join('detail_order do', 'o.id_order = do.id_order','left');
         $this->db->join('outlet t', 'o.id_outlet = t.id_outlet','left');
        $this->db->join('pengguna p', 'o.username = p.username','left');
        if($this->session->userdata('outlet') != ""){
            $this->db->where('o.id_outlet',  $this->session->userdata('outlet'));
        }else{
            if($outlet != ''){
                $this->db->where('o.id_outlet',  $outlet);
            }
        }
        $this->db->where('proses',1);
        $this->db->where('bayar !=',0);
        $this->db->where('DATE(tanggal) BETWEEN "'.$start.'" AND "'.$end.'"');
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
        
    function count_filtered($start, $end, $outlet)
    {
        $this->_get_datatables_query($start, $end, $outlet);
        $query = $this->db->get();
        return $query->num_rows();
    }
 
    public function count_all($start, $end, $outlet)
    {
        $this->_get_datatables_query($start, $end, $outlet);
        return $this->db->count_all_results();
    }
    
    function get_datatables($start, $end, $outlet)
    {
        $this->_get_datatables_query($start, $end, $outlet);
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }
    
    
    
}
