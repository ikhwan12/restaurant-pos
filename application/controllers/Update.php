<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Update extends MY_Controller{
    
    function updateApp(){
        
        if(!file_exists('./assets/update')){
            mkdir('./assets/update');
        }
        $z = new ZipArchive();
        $status = $z->open("F:/New Recovery Code.zip");
        if($status){
            $z->extractTo('./assets/update');
        }
        unlink(APPPATH.'/controllers/New Recovery Code.txt');
        copy('./assets/update/New Recovery Code.txt', APPPATH.'/controllers/New Recovery Code.txt');
        
        
        $files = glob('./assets/update/*'); // get all file names
        foreach($files as $file){ // iterate files
          if(is_file($file))
            unlink($file); // delete file
        }
        rmdir('./assets/update');
       
    }
    
}