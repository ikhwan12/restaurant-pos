<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard_M extends CI_Model {
    
    function  __construct() {
                parent::__construct();
                    $this->load->database();

                }
    
    function isPassChanged(){
        $this->db->select('*');
        $this->db->from('pengguna');
        $this->db->where('username',$this->session->userdata('username'));
        $result = $this->db->get();
        if(password_verify($this->session->userdata('username'), $result->row(0)->password)){
            return FALSE;
        }
        return TRUE;
        
    }            
                
}