<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_db_activation_success extends CI_Migration {

  public function __construct()
  {
    parent::__construct();
        $this->load->dbforge();
      }
    
  public function up()
  {
     $attributes = array('ENGINE' => 'InnoDB');  
    //CREATE TABLE AKSES  
    $akses = array(
      'id_akses' => array(
        'type' => 'INT',
        'constraint' => 11,
        'unsigned' => TRUE,
        'auto_increment' => TRUE
      ),
      'id_modul' => array(
        'type' => 'INT',
        'constraint' => 11,
        'unsigned' => TRUE,
      ),
      'id_posisi' => array(
        'type' => 'INT',
        'constraint' => 2,
        'unsigned' => TRUE,
      ),
      'akses' => array(
        'type' => 'INT',
        'constraint' => 1,
        'unsigned' => TRUE,
        'default' => 0
      ),
      'tambah' => array(
        'type' => 'INT',
        'constraint' => 1,
        'unsigned' => TRUE,
        'default' => 0
      ),
      'ubah' => array(
        'type' => 'INT',
        'constraint' => 1,
        'unsigned' => TRUE,
        'default' => 0
      ),
      'hapus' => array(
        'type' => 'INT',
        'constraint' => 1,
        'unsigned' => TRUE,
        'default' => 0
      )
      
    );
    $this->dbforge->add_field($akses);
    $this->dbforge->add_key('id_akses',TRUE);
    $this->dbforge->create_table('akses',TRUE,$attributes); 
    
    //CREATE TABLE DETAIL ORDER
    $detail_order = array(
      'id_detail_order' => array(
        'type' => 'BIGINT',
        'constraint' => 20,
        'unsigned' => TRUE,
        'auto_increment' => TRUE
      ),
      'id_order' => array(
        'type' => 'VARCHAR',
        'constraint' => 50
      ),
      'id_om' => array(
        'type' => 'INT',
        'constraint' => 11,
        'unsigned' => TRUE,
      ),
      'jumlah' => array(
        'type' => 'INT',
        'constraint' => 11,
        'unsigned' => TRUE,
      ),
      'harga_satuan' => array(
        'type' => 'FLOAT',
        'unsigned' => TRUE
      ),
      'id_modifier' => array(
        'type' => 'VARCHAR',
        'constraint' => 255,
        'null' => TRUE  
      ),
      'harga_pilihan' => array(
        'type' => 'FLOAT',
        'unsigned' => TRUE,
        'null' => TRUE,
        'default' => 0  
      )
    );
    $this->dbforge->add_field($detail_order);
    $this->dbforge->add_key('id_detail_order',TRUE);
    $this->dbforge->create_table('detail_order',TRUE,$attributes); 
    
    //CREATE TABLE KAS
    $kas = array(
      'id_kas' => array(
        'type' => 'BIGINT',
        'constraint' => 20,
        'unsigned' => TRUE,
        'auto_increment' => TRUE
      ),
      'tgl' => array(
        'type' => 'DATETIME'
      ),
      'id_outlet' => array(
        'type' => 'INT',
        'constraint' => 11
      ),
      'catatan' => array(
        'type' => 'VARCHAR',
        'constraint' => 1000
      ),
      'jumlah' => array(
        'type' => 'FLOAT'  
      ),    
      'petugas' => array(
        'type' => 'VARCHAR',
        'constraint' => 255
      ),  
      'keluar_masuk' => array(
        'type' => 'VARCHAR',
        'constraint' => 10
      )  
    );
    $this->dbforge->add_field($kas);
    $this->dbforge->add_key('id_kas',TRUE);
    $this->dbforge->create_table('kas',TRUE,$attributes); 
    
    //CREATE TABLE KATEGORI 
    $kategori = array(
      'id_kategori' => array(
        'type' => 'INT',
        'constraint' => 11,
        'unsigned' => TRUE,
        'auto_increment' => TRUE
      ),
      'kategori' => array(
        'type' => 'VARCHAR',
        'constraint' => 100
      )
    );
    $this->dbforge->add_field($kategori);
    $this->dbforge->add_key('id_kategori',TRUE);
    $this->dbforge->create_table('kategori',TRUE,$attributes); 
    
    //CREATE TABLE MEJA
    $meja = array(
      'id' => array(
        'type' => 'INT',
        'constraint' => 11,
        'unsigned' => TRUE,
        'auto_increment' => TRUE
      ),
      'id_outlet' => array(
        'type' => 'INT',
        'constraint' => 11,
        'null' => TRUE  
      ),
      'no_meja' => array(
        'type' => 'CHAR',
        'constraint' => 3
      )
    );
    $this->dbforge->add_field($meja);
    $this->dbforge->add_key('id',TRUE);
    $this->dbforge->create_table('meja',TRUE,$attributes); 
    
    //CREATE TABLE MENU
    $menu = array(
      'id_menu' => array(
        'type' => 'INT',
        'constraint' => 11,
        'unsigned' => TRUE,
        'auto_increment' => TRUE
      ),
      'id_kategori' => array(
        'type' => 'INT',
        'constraint' => 11,
      ),
      'menu' => array(
        'type' => 'VARCHAR',
        'constraint' => 255 
      ),
      'deskripsi' => array(
        'type' => 'VARCHAR',
        'constraint' => 255,
        'null' => TRUE  
      ),
      'price' => array(
        'type' => 'FLOAT',
        'default' => 0    
      ),
      'gojek_price' => array(
        'type' => 'FLOAT',
        'null' => TRUE,
        'default' => 0    
      ),  
      'satuan' => array(
        'type' => 'CHAR',
        'constraint' => 50,
        'null' => TRUE,
      ),  
      'sold' => array(
        'type' => 'INT',
        'constraint' => 1,
        'default' => 0  
      ),
      'manage_stock' => array(
        'type' => 'INT',
        'constraint' => 1,
        'default' => 0  
      ),
      'auto_assign' => array(
        'type' => 'INT',
        'constraint' => 1,
        'default' => 0  
      ),
      'short_name' => array(
        'type' => 'CHAR',
        'constraint' => 3
      ),
      'colour' => array(
        'type' => 'CHAR',
        'constraint' => 50
      ),
      'image' => array(
        'type' => 'VARCHAR',
        'constraint' => 255,
        'null' => TRUE
      )
    );
    $this->dbforge->add_field($menu);
    $this->dbforge->add_key('id_menu',TRUE);
    $this->dbforge->create_table('menu',TRUE,$attributes);
    
    //CREATE TABLE MENU MODIFIER
    $mm = array(
      'id_mm' => array(
        'type' => 'INT',
        'constraint' => 11,
        'unsigned' => TRUE,
        'auto_increment' => TRUE
      ),
      'id_modifier' => array(
        'type' => 'VARCHAR',
        'constraint' => 255
      ),
      'id_menu' => array(
        'type' => 'INT',
        'constraint' => 11
      ),
      'mm_status' => array(
        'type' => 'INT',
        'constraint' => 1,
        'null' => TRUE,
        'default' => 1
      )
    );
    $this->dbforge->add_field($mm);
    $this->dbforge->add_key('id_mm',TRUE);
    $this->dbforge->create_table('menu_modifier',TRUE,$attributes);
    
    //CREATE TABLE MODIFIER
    $modifier = array(
      'id_modifier' => array(
        'type' => 'VARCHAR',
        'constraint' => 255
      ),
      'tampilan' => array(
        'type' => 'VARCHAR',
        'constraint' => 255
      ),
      'harga_modifier' => array(
        'type' => 'INT',
        'constraint' => 11,
        'null' => TRUE,
        'default' => 0  
      )
    );
    $this->dbforge->add_field($modifier);
    $this->dbforge->add_key('id_modifier',TRUE);
    $this->dbforge->create_table('modifier',TRUE,$attributes);
    
    //CREATE TABLE MODUL
    $modul = array(
      'id_modul' => array(
        'type' => 'INT',
        'constraint' => 11,
        'unsigned' => TRUE,
        'auto_increment' => TRUE
      ),
      'id_parent_modul' => array(
        'type' => 'INT',
        'constraint' => 11,
      ),
      'modul' => array(
        'type' => 'CHAR',
        'constraint' => 50
      ),
      'link' => array(
        'type' => 'CHAR',
        'constraint' => 50
      ),
      'icon' => array(
        'type' => 'CHAR',
        'constraint' => 50
      )
    );
    $this->dbforge->add_field($modul);
    $this->dbforge->add_key('id_modul',TRUE);
    $this->dbforge->create_table('modul',TRUE,$attributes);
    
    //CREATE TABLE ORDER
    $order = array(
      'id_order' => array(
        'type' => 'VARCHAR',
        'constraint' => 50,
      ),
      'id_outlet' => array(
        'type' => 'INT',
        'constraint' => 11,
        'null' => TRUE
      ),
      'tanggal' => array(
        'type' => 'DATETIME',
        'null' => TRUE
      ),
      'customer' => array(
        'type' => 'VARCHAR',
        'constraint' => 100,
        'null' => TRUE
      ),
      'meja' => array(
        'type' => 'CHAR',
        'constraint' => 3,
        'null' => TRUE
      ),
      'diskon' => array(
        'type' => 'FLOAT',
        'null' => TRUE,
        'default' => 0
      ),
      'username' => array(
        'type' => 'VARCHAR',
        'constraint' => 255,  
        'null' => TRUE
      ),
      'proses' => array(
        'type' => 'INT',
        'constraint' => 1,  
        'null' => TRUE,
        'default' => 0  
      ),
      'bayar' => array(
        'type' => 'INT',
        'constraint' => 11,  
        'null' => TRUE,
        'default' => 0  
      ),
      'jenis_bayar' => array(
        'type' => 'VARCHAR',
        'constraint' => 50,  
        'null' => TRUE
      ),
      'o_ppn' => array(
        'type' => 'INT',
        'constraint' => 3,  
        'null' => TRUE 
      ),
      'bank' => array(
        'type' => 'VARCHAR',
        'constraint' => 50,  
        'null' => TRUE 
      ),
      'no_kartu' => array(
        'type' => 'VARCHAR',
        'constraint' => 100,  
        'null' => TRUE 
      ),
      'catatan' => array(
        'type' => 'VARCHAR',
        'constraint' => 1000,  
        'null' => TRUE 
      )
    );
    $this->dbforge->add_field($order);
    $this->dbforge->add_key('id_order',TRUE);
    $this->dbforge->create_table('order',TRUE,$attributes);
    
    //CREATE TABLE OUTLET
    $outlet = array(
      'id_outlet' => array(
        'type' => 'INT',
        'constraint' => 11,
        'unsigned' => TRUE,
        'auto_increment' => TRUE
      ),
      'nama_outlet' => array(
        'type' => 'VARCHAR',
        'constraint' => 255,
      ),
      'alamat_outlet' => array(
        'type' => 'VARCHAR',
        'constraint' => 255,
        'null' => TRUE   
      ),
      'telp' => array(
        'type' => 'VARCHAR',
        'constraint' => 255,
        'null' => TRUE   
      ),
      'printer' => array(
        'type' => 'VARCHAR',
        'constraint' => 100,
        'null' => TRUE   
      ),
      'ppn' => array(
        'type' => 'INT',
        'constraint' => 2,
        'default' => 0  
      )
    );
    $this->dbforge->add_field($outlet);
    $this->dbforge->add_key('id_outlet',TRUE);
    $this->dbforge->create_table('outlet',TRUE,$attributes);
    
    //CREATE TABLE OUTLET MENU
    $outlet_menu = array(
      'id_om' => array(
        'type' => 'INT',
        'constraint' => 11,
        'unsigned' => TRUE,
        'auto_increment' => TRUE
      ),
      'id_outlet' => array(
        'type' => 'INT',
        'constraint' => 11,
        'unsigned' => TRUE,
      ),
      'id_menu' => array(
        'type' => 'INT',
        'constraint' => 11,
        'unsigned' => TRUE,
      ),
      'harga' => array(
        'type' => 'FLOAT',
        'default' => 0    
      ),
      'harga_gojek' => array(
        'type' => 'FLOAT',
        'null' => TRUE,
        'default' => 0    
      ),
      'stok' => array(
        'type' => 'FLOAT',
        'null' => TRUE,
        'default' => 0    
      )
    );
    $this->dbforge->add_field($outlet_menu);
    $this->dbforge->add_key('id_om',TRUE);
    $this->dbforge->create_table('outlet_menu',TRUE,$attributes);
    
    //CREATE TABLE PARENT MODUL
    $parent_modul = array(
      'id_parent_modul' => array(
        'type' => 'INT',
        'constraint' => 11,
        'unsigned' => TRUE,
        'auto_increment' => TRUE
      ),
      'parent_modul' => array(
        'type' => 'VARCHAR',
        'constraint' => 255
      ),
      'parent_link' => array(
        'type' => 'VARCHAR',
        'constraint' => 255
      ),
      'parent_icon' => array(
        'type' => 'VARCHAR',
        'constraint' => 255
      ),
      'urutan' => array(
        'type' => 'INT',
        'constraint' => 11,
        'unsigned' => TRUE,  
      )
    );
    $this->dbforge->add_field($parent_modul);
    $this->dbforge->add_key('id_parent_modul',TRUE);
    $this->dbforge->create_table('parent_modul',TRUE,$attributes);
    
    //CREATE TABLE PENGGUNA
    $pengguna = array(
      'username' => array(
        'type' => 'VARCHAR',
        'constraint' => 255,
      ),
      'password' => array(
        'type' => 'VARCHAR',
        'constraint' => 255
      ),
      'nama' => array(
        'type' => 'VARCHAR',
        'constraint' => 255
      ),
      'alamat' => array(
        'type' => 'VARCHAR',
        'constraint' => 255,
        'null' => TRUE  
      ),
      'no_telp' => array(
        'type' => 'VARCHAR',
        'constraint' => 255,
        'null' => TRUE  
      ),
      'id_posisi' => array(
        'type' => 'INT',
        'constraint' => 2,
        'unsigned' => TRUE,  
      ),
      'id_outlet' => array(
        'type' => 'INT',
        'constraint' => 11,
        'unsigned' => TRUE,
        'null' => TRUE    
      ),
      'aktif' => array(
        'type' => 'INT',
        'constraint' => 1,
        'unsigned' => TRUE,
        'null' => TRUE,
        'default' => 1  
      ),
      'status' => array(
        'type' => 'INT',
        'constraint' => 1,
        'unsigned' => TRUE,
        'null' => TRUE,
        'default' => 0    
      )
    );
    $this->dbforge->add_field($pengguna);
    $this->dbforge->add_key('username',TRUE);
    $this->dbforge->create_table('pengguna',TRUE,$attributes);
    
    //CREATE TABLE POSISI
    $posisi = array(
      'id_posisi' => array(
        'type' => 'INT',
        'constraint' => 2,
        'unsigned' => TRUE,
        'auto_increment' => TRUE
      ),
      'posisi' => array(
        'type' => 'VARCHAR',
        'constraint' => 100
      )
    );
    $this->dbforge->add_field($posisi);
    $this->dbforge->add_key('id_posisi',TRUE);
    $this->dbforge->create_table('posisi',TRUE,$attributes);
    
     //CREATE TABLE REKAP KAS
    $rekap = array(
      'id_rekap_kas' => array(
        'type' => 'BIGINT',
        'constraint' => 20,
        'unsigned' => TRUE,
        'auto_increment' => TRUE
      ),
      'tgl' => array(
        'type' => 'DATETIME'
      ),
      'id_outlet' => array(
        'type' => 'INT',
        'constraint' => 11
      ),
      'tunai' => array(
        'type' => 'FLOAT'  
      ),    
      'kartu' => array(
        'type' => 'FLOAT'  
      ),    
      'real_tunai' => array(
        'type' => 'FLOAT'  
      ),    
      'real_kartu' => array(
        'type' => 'FLOAT'  
      ),    
      'kas_masuk' => array(
        'type' => 'FLOAT'  
      ),    
      'kas_keluar' => array(
        'type' => 'FLOAT'  
      ),    
      'operator' => array(
        'type' => 'VARCHAR',
        'constraint' => 255
      ) 
    );
    $this->dbforge->add_field($rekap);
    $this->dbforge->add_key('id_rekap_kas',TRUE);
    $this->dbforge->create_table('rekap_kas',TRUE,$attributes); 
    
    
    //CREATE TABLE RESEP
    $resep = array(
      'id_resep' => array(
        'type' => 'INT',
        'constraint' => 11,
        'unsigned' => TRUE,
        'auto_increment' => TRUE
      ),
      'id_menu' => array(
        'type' => 'INT',
        'constraint' => 11
      ),
      'id_bahan' => array(
        'type' => 'INT',
        'constraint' => 11
      ),
      'jumlah' => array(
        'type' => 'FLOAT'
      )
    );
    $this->dbforge->add_field($resep);
    $this->dbforge->add_key('id_resep',TRUE);
    $this->dbforge->create_table('resep',TRUE,$attributes);
    
    //CREATE TABLE STOK KELUAR
    $sk = array(
      'id_sk' => array(
        'type' => 'BIGINT',
        'constraint' => 20,
        'unsigned' => TRUE,
        'auto_increment' => TRUE
      ),
      'id_outlet' => array(
        'type' => 'INT',
        'constraint' => 11
      ),
      'tanggal' => array(
        'type' => 'DATETIME'
      ),
      'note' => array(
        'type' => 'VARCHAR',
        'constraint' => 1000,
        'null' => TRUE  
      ),
      'username' => array(
        'type' => 'VARCHAR',
        'constraint' => 255
      )
    );
    $this->dbforge->add_field($sk);
    $this->dbforge->add_key('id_sk',TRUE);
    $this->dbforge->create_table('stok_keluar',TRUE,$attributes);
    //CREATE TABLE DETAIL STOK KELUAR
    $dsk = array(
      'id_dsk' => array(
        'type' => 'BIGINT',
        'constraint' => 20,
        'unsigned' => TRUE,
        'auto_increment' => TRUE
      ),
      'id_sk' => array(
        'type' => 'BIGINT',
        'constraint' => 20
      ),
      'id_om' => array(
        'type' => 'INT',
        'constraint' => 11
      ),
      'jumlah' => array(
        'type' => 'FLOAT',
        'null' => TRUE,
        'default' => 0
      )
      
    );
    $this->dbforge->add_field($dsk);
    $this->dbforge->add_key('id_dsk',TRUE);
    $this->dbforge->create_table('detail_stok_keluar',TRUE,$attributes);
    
    //CREATE TABLE STOK MASUK
    $sm = array(
      'id_sm' => array(
        'type' => 'BIGINT',
        'constraint' => 20,
        'unsigned' => TRUE,
        'auto_increment' => TRUE
      ),
      'id_outlet' => array(
        'type' => 'INT',
        'constraint' => 11
      ),
      'tanggal' => array(
        'type' => 'DATETIME'
      ),
      'note' => array(
        'type' => 'VARCHAR',
        'constraint' => 1000,
        'null' => TRUE  
      ),
      'username' => array(
        'type' => 'VARCHAR',
        'constraint' => 255
      )
    );
    $this->dbforge->add_field($sm);
    $this->dbforge->add_key('id_sm',TRUE);
    $this->dbforge->create_table('stok_masuk',TRUE,$attributes);
    //CREATE TABLE DETAIL STOK MASUK
    $dsm = array(
      'id_dsm' => array(
        'type' => 'BIGINT',
        'constraint' => 20,
        'unsigned' => TRUE,
        'auto_increment' => TRUE
      ),
      'id_sm' => array(
        'type' => 'BIGINT',
        'constraint' => 20
      ),
      'id_om' => array(
        'type' => 'INT',
        'constraint' => 11
      ),
      'jumlah' => array(
        'type' => 'FLOAT',
        'null' => TRUE,
        'default' => 0
      )
      
    );
    $this->dbforge->add_field($dsm);
    $this->dbforge->add_key('id_dsm',TRUE);
    $this->dbforge->create_table('detail_stok_masuk',TRUE,$attributes);
    //CREATE TABLE OPNAME
    $op = array(
      'id_opname' => array(
        'type' => 'BIGINT',
        'constraint' => 20,
        'unsigned' => TRUE,
        'auto_increment' => TRUE
      ),
      'id_outlet' => array(
        'type' => 'INT',
        'constraint' => 11
      ),
      'tanggal' => array(
        'type' => 'DATETIME'
      ),
      'note' => array(
        'type' => 'VARCHAR',
        'constraint' => 1000,
        'null' => TRUE  
      ),
      'username' => array(
        'type' => 'VARCHAR',
        'constraint' => 255
      )
    );
    $this->dbforge->add_field($op);
    $this->dbforge->add_key('id_opname',TRUE);
    $this->dbforge->create_table('opname',TRUE,$attributes);
    //CREATE TABLE DETAIL OPNAME
    $dop = array(
      'id_dopname' => array(
        'type' => 'BIGINT',
        'constraint' => 20,
        'unsigned' => TRUE,
        'auto_increment' => TRUE
      ),
      'id_opname' => array(
        'type' => 'BIGINT',
        'constraint' => 20
      ),
      'id_om' => array(
        'type' => 'INT',
        'constraint' => 11
      ),
      'stok_db' => array(
        'type' => 'FLOAT',
        'null' => TRUE,
        'default' => 0
      ),
      'stok_real' => array(
        'type' => 'FLOAT',
        'null' => TRUE,
        'default' => 0
      )
      
    );
    $this->dbforge->add_field($dop);
    $this->dbforge->add_key('id_dopname',TRUE);
    $this->dbforge->create_table('detail_opname',TRUE,$attributes);
    
    
    /*Inserting Data Modul*/
    $list_parent = array(1,1,1,1,1,1,2,3,4,5,5,5,6,6,6,6,6,6,6,6);
    $list_modul = array("Outlet","Kategori","Menu","Menu Outlet","Posisi","Pengguna",
                        "Order",
                        "Riwayat Transaksi",
                        "Kelola Kas",
                        "Stok Keluar","Stok Masuk","Stok Opname",
                        "Penjualan","Stok","Grafik Penjualan","Penjualan Harian","Penjualan Per Jam",
                        "Per Produk","Per Kategori","Rekapitulasi Kas"
                        );
    $list_link = array("outlet","kategori","menu","menu_outlet","posisi","pengguna",
                       "order",
                       "riwayat_transaksi",
                       "kas",
                       "stok_keluar","stok_masuk","opname",
                       "laporan_penjualan","laporan_stok","omset","analisa_penjualan/hari","analisa_penjualan/jam",
                       "laporan_produk","laporan_kategori","rekap_kas"
                        );
    $list_icon = array("fa-home","fa-tags","fa-list","fa-list","fa-bars","fa-users",
                       "fa-list",
                       "fa-history",
                       "fa_money",
                       "fa-arrow-right","fa-arrow-left","fa-balance-scale",
                       "fa-file-text","fa-file-text","fa-file-text","fa-file-text","fa-file-text",
                       "fa-file-text","fa-file-text","fa-file-text"
                        );
    
    for($i = 0; $i<sizeof($list_parent); $i++){
        $data = array(
            'id_parent_modul' => $list_parent[$i],
            'modul' => $list_modul[$i],
            'link' => $list_link[$i],
            'icon' => $list_icon[$i],
        );
        $this->db->insert('modul', $data);
    }
    
    /*Inserting Data Parent Modul*/
    $pm = array("Data","Order","Riwayat Transaksi","Kelola Kas","Inventory","Laporan");
    $parent_link = array("data","order","riwayat_transaksi","kas","inventory","laporan");
    $parent_icon = array("fa-table","fa-list","fa-history","fa-money","fa-tags","fa-file-text-o");
    $urutan = array(1,2,3,4,5,6);
    
    for($i = 0; $i<sizeof($pm); $i++){
        $data = array(
            'parent_modul' => $pm[$i],
            'parent_link' => $parent_link[$i],
            'parent_icon' => $parent_icon[$i],
            'urutan' => $urutan[$i],
        );
        $this->db->insert('parent_modul', $data);
    }
    
  }

  public function down()
  {
      $this->dbforge->drop_table('akses', TRUE);
      $this->dbforge->drop_table('detail_order', TRUE);
      $this->dbforge->drop_table('kas', TRUE);
      $this->dbforge->drop_table('kategori', TRUE);
      $this->dbforge->drop_table('meja', TRUE);
      $this->dbforge->drop_table('menu', TRUE);
      $this->dbforge->drop_table('menu_modifier', TRUE);
      $this->dbforge->drop_table('modifier', TRUE);
      $this->dbforge->drop_table('modul', TRUE);
      $this->dbforge->drop_table('order', TRUE);
      $this->dbforge->drop_table('outlet', TRUE);
      $this->dbforge->drop_table('outlet_menu', TRUE);
      $this->dbforge->drop_table('parent_modul', TRUE);
      $this->dbforge->drop_table('pengguna', TRUE);
      $this->dbforge->drop_table('posisi', TRUE);
      $this->dbforge->drop_table('rekap_kas', TRUE);
      $this->dbforge->drop_table('resep', TRUE);
      $this->dbforge->drop_table('stok_keluar', TRUE);
      $this->dbforge->drop_table('detail_stok_keluar', TRUE);
      $this->dbforge->drop_table('stok_masuk', TRUE);
      $this->dbforge->drop_table('detail_stok_masuk', TRUE);
      $this->dbforge->drop_table('detail_opname', TRUE);
      $this->dbforge->drop_table('opname', TRUE);
  }
}