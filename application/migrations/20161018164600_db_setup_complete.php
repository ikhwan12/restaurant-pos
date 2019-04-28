<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_db_setup_complete extends CI_Migration {

  public function __construct()
  {
    parent::__construct();
    $this->load->dbforge();
  }
    
  public function up()
  {
    $activation = array(
      'id' => array(
        'type' => 'INT',
        'constraint' => 11,
        'unsigned' => TRUE,
        'auto_increment' => TRUE
      ),
      'serial' => array(
        'type' => 'VARCHAR',
        'constraint' => 255
      )
    );
    $this->dbforge->add_field($activation);
    $this->dbforge->add_key('id',TRUE);
    $this->dbforge->add_key('serial');
    $this->dbforge->create_table('activation',TRUE); 
      
    $license = array(
      'id' => array(
        'type' => 'INT',
        'constraint' => 11,
        'unsigned' => TRUE,
        'auto_increment' => TRUE
      ),
      'serial' => array(
        'type' => 'VARCHAR',
        'constraint' => 255
      )
    );
    $this->dbforge->add_field($license);
    $this->dbforge->add_key('id',TRUE);
    $this->dbforge->add_key('serial');
    $this->dbforge->create_table('license',TRUE); 
    
    $serial = '1111-1111-1111-1111-1111';
    $handle = fopen(APPPATH."activation/serial.txt", "r");
    if ($handle) {
        while (($line = fgets($handle)) !== false) {
            $serial = trim($line);
        }
        fclose($handle);
    } 
    $this->db->insert('license',array('serial' => password_hash($serial, PASSWORD_BCRYPT),));
    
  }

  public function down()
  {
      $this->dbforge->drop_table('activation', TRUE);
      $this->dbforge->drop_table('license', TRUE);
  }
}