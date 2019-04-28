<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Meja_M extends My_Model {

     protected $_tabel = 'meja';
     
     function get_no($id_outlet){
         $this->db->select('max(no_meja) as max');
         $this->db->where('id_outlet', $id_outlet);
         $result = $this->db->get($this->_tabel)->row();
         if($result->max == null){
             return 1;
         }else{
             return $result->max + 1;
         }
     }
     
     function get_meja($id_outlet){
         $result =$this->db->query("SELECT m.no_meja, id_order
                           FROM
                           (
                            SELECT * FROM `meja` WHERE `id_outlet` = ".$this->db->escape($id_outlet)." 
                            )as m
                            LEFT JOIN( 
                                SELECT * FROM `order` WHERE `id_outlet` = ".$this->db->escape($id_outlet)."  AND proses = 1 AND bayar = 0
                            )as o
                            ON m.no_meja = o.meja

                            ORDER BY m.no_meja
                            ");
         
         return $result->result();
     }
     
     function get_meja_kosong($id_outlet){
         $result =$this->db->query("SELECT m.no_meja, id_order
                           FROM
                           (
                            SELECT * FROM `meja` WHERE `id_outlet` = ".$this->db->escape($id_outlet)." 
                            )as m
                            LEFT JOIN( 
                                SELECT * FROM `order` WHERE `id_outlet` = ".$this->db->escape($id_outlet)."  AND proses = 1 AND bayar = 0
                            )as o
                            ON m.no_meja = o.meja
                            WHERE id_order IS NULL
                            ORDER BY m.no_meja
                            ");
         
         return $result->result();
     }
    
     
     function mejaExist($data){
         $this->db->where('no_meja',$data['no_meja']);
         $this->db->where('id_outlet',$data['id_outlet']);
         $result = $this->db->get('meja')->row();
         if(isset($result)){
             $status['status'] = TRUE;
             $status['message'] = "Meja Sudah Ada.";
         }else{
             $status['status'] = FALSE;
             $status['message'] = "";
         }
         return $status;
     }
     
     function delMeja(){
         $this->db->where('id_outlet', $this->session->userdata('outlet'));
         $this->db->where('no_meja', $this->input->post('no_meja'));
         $this->db->delete('meja');
         $jum_hapus = $this->db->affected_rows();
         if($jum_hapus == 1){
            return TRUE;
        }
        return FALSE;
     }
}