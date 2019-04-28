<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller {
       
    function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->model('Menu_M', 'menu');
        if(!$this->session->userdata('suprek_logged_in')){
            redirect('login');
        }else{
            if($this->uri->segment(1) != 'detail_order'){
                if(!$this->menu->checkPrevilage()){
                    redirect('login');
                }
            }
            
        }
    }
    
    function normalize_text($input){
        return ucwords(strtolower($this->input->post($input)));
    }
            
    function get_menu(){
        $menu['modul'] = $this->menu->get_menu();
        $menu['posisi'] = $this->menu->get_posisi();
        $menu['title'] = "Mr. Suprek"; 
        $this->load->view('header', $menu);
    }
    
    function log_activity($type){
        
        $log_file = fopen('./assets/'.$this->session->userdata('username').'.txt', 'a');
        $log = $this->uri->segment(1)."--$type--".  date("Y-m-d H:i:s")."\n";
        fwrite($log_file, $log);
        fclose($log_file);
        
    }
    
    

}
