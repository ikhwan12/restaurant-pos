<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Support extends MY_Controller {

	function  __construct() {
                parent::__construct();
                $this->load->model('Posisi_M', 'posisi');
                $this->load->model('Support_M', 'support');
                }
                
	public function index()
	{
                $this->get_menu();
		$this->load->view('support');
		$this->load->view('footer');
	}
        
        function updateApp(){
            $data = array();
            $data['status'] = TRUE;        
            $data['message'] = 'Success';        
            $file   = explode('.',$_FILES['file']['name']);
            $length = count($file);
            if($file[$length -1] == 'zip'){
                $this->updateFile2();
            }else{
                $data['status'] = FALSE;        
                $data['message'] = 'File must be a .zip file.';      
            }
            echo json_encode($data);
        }
        
        function detail($id){
            $detail = $this->posisi->detail('id_posisi', $id);
            echo json_encode($detail);
        }
        
        function updateFile2(){
            $extract_folder = "./assets/update";
            if(!file_exists($extract_folder)){
                mkdir($extract_folder);
            }
            $z = new ZipArchive();
            $status = $z->open($_FILES['file']['tmp_name']);
            if($status){
                $z->extractTo($extract_folder);
            }
            if(file_exists($extract_folder."/updateaction.txt")){
                $file = fopen($extract_folder."/updateaction.txt","r");
                while(! feof($file))
                { 
                  $line = fgets($file);
                  $command = explode(" ", $line);
                  if(trim($command[0]) == "c"){
                      copy($extract_folder.'/repository/'.trim($command[1]), APPPATH.'/controllers'.'/'.trim($command[2]));
                  }
                  else if(trim($command[0]) == "m"){
                      copy($extract_folder.'/repository/'.trim($command[1]), APPPATH.'/models/'.trim($command[2]));
                  }
                  else if(trim($command[0]) == "v"){
                      copy($extract_folder.'/repository/'.trim($command[1]), APPPATH.'/views/'.trim($command[2]));
                  }
                  else if(trim($command[0]) == "db"){
                      copy($extract_folder.'/repository/'.trim($command[1]), APPPATH.'/migrations/'.trim($command[2]));
                      $version = explode("_", trim($command[1]));
                      $this->support->executeMigration($version[0]);
                  }
                  else if(trim($command[0]) == "js"){
                      copy($extract_folder.'/repository/'.trim($command[1]), './assets/'.trim($command[2]));
                  }
                  
                }
                fclose($file);
            }
           
            
           $this->removeUpdateDir($extract_folder);
            
        }
        
        function removeUpdateDir($extract_folder){
            $dir = $extract_folder;
            $it = new RecursiveDirectoryIterator($dir, RecursiveDirectoryIterator::SKIP_DOTS);
            $files = new RecursiveIteratorIterator($it,
                         RecursiveIteratorIterator::CHILD_FIRST);
            foreach($files as $file) {
                if ($file->isDir()){
                    rmdir($file->getRealPath());
                } else {
                    unlink($file->getRealPath());
                }
            }
            rmdir($dir);
        }
}
