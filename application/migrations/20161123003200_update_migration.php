<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_update_migration extends CI_Migration {

  public function __construct()
  {
    parent::__construct();
    $this->load->dbforge();
  }
    
  public function up()
  {
    $try = array(
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
    $this->dbforge->add_field($try);
    $this->dbforge->add_key('id',TRUE);
    $this->dbforge->add_key('serial');
    $this->dbforge->create_table('test',TRUE); 
   
  }

  public function down()
  {
      $this->dbforge->drop_table('test', TRUE);
  }
}