<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Menu_M extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    function get_menu(){
        $this->db->select('DISTINCT(parent_modul), parent_link, parent_icon');
        $this->db->join('modul m','a.id_modul = m.id_modul', 'left');
        $this->db->join('parent_modul p','m.id_parent_modul = p.id_parent_modul', 'left');
        $this->db->where('id_posisi', $this->session->userdata('posisi'));
        $this->db->where('akses', 1);
        $this->db->order_by('urutan','asc');
        $result = $this->db->get('akses a');
        return $result->result();
    }
    
    function get_posisi(){
        $this->db->where('id_posisi', $this->session->userdata('posisi'));
        $result = $this->db->get('posisi')->row();
        if(isset($result)){
            return $result->posisi;
        }else{
            return "Undefined";
        }
    }
    
    function checkPrevilage(){
        
        $akses = FALSE;
        $this->db->select('id_modul');
        $this->db->where('link', $this->uri->segment(1));
        $result = $this->db->get('modul');
        if($result->result()){
            $this->db->select('akses');
            $this->db->where('id_posisi', $this->session->userdata('posisi'));
            $this->db->where('id_modul', $result->row(0)->id_modul);
            $result2 = $this->db->get('akses');
            if($result2->row(0)->akses == 1){
                $akses = TRUE;
            }
        }else{
            $akses = TRUE;
        }
        return $akses;
    }
    
    function get_data_tile_modul(){
        $this->db->select('id_parent_modul');
        $this->db->where('parent_link',  $this->uri->segment(1));
        $result = $this->db->get('parent_modul')->row();
        if(isset($result)){
            $this->db->select('modul, link, akses, icon');
            $this->db->join('modul m','a.id_modul = m.id_modul','left');
            $this->db->where('id_posisi',  $this->session->userdata('posisi'));
            $this->db->where('id_parent_modul',  $result->id_parent_modul);
            $this->db->where('akses',  1);
            $result2 = $this->db->get('akses a');
        }
        return $result2->result();
        
    }
}
