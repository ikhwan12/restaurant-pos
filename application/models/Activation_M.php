<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Activation_M extends CI_Model {
    
    function  __construct() {
                parent::__construct();
                    $this->load->database();

                }
    
    function is_activated_local(){
        $this->db->insert('license',array('serial' => password_hash('AW2A-X6WD-URHN-PX4J-J3B4', PASSWORD_BCRYPT),));
        $status = FALSE;
        $this->db->select('serial');
        $row = $this->db->get('activation')->row();
        if(isset($row)){
            $this->db->select('serial');
            $result = $this->db->get('license');
            if($result->result()){
                foreach ($result->result() as $value) {
                    if(password_verify($row->serial, $value->serial)){
                        $status = TRUE;
                        break;
                    }
                }
            }
        }
        return $status;
    }      
    
    function activate(){
        //$this->db->insert('license',array('serial' => password_hash('AW2A-X6WD-URHN-PX4J-J3B4', PASSWORD_BCRYPT),));
        $status = FALSE;
        $this->db->select('serial');
        $result = $this->db->get('license');
        if($result->result()){
            foreach ($result->result() as $value) {
                if(password_verify($this->input->post('serial'), $value->serial)){
                    $status = TRUE;
                    $this->db->empty_table('activation');
                    $this->db->insert('activation',array('serial' => $this->input->post('serial')));
                    break;
                }
            }
        }
        return $status;
    }
                
}