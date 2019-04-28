<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Support_M extends My_Model {

    function executeMigration($version){
        $this->load->library('migration');
        $this->migration->version($version);
    }
    
     
}
