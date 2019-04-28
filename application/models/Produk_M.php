<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Produk_M extends My_Model {

     protected $_tabel = 'menu';
    
     var $table = 'menu';
     var $column = array('id_menu','menu','price','gojek_price'); //set column field database for order and search
     var $order = array('menu' => 'asc'); // default order 
     
     private function _get_datatables_query($kategori)
        {
         
        $this->db->from($this->table.' m');
        $this->db->join('kategori k', 'm.id_kategori = k.id_kategori', 'left');
        if($kategori != ""){
            $this->db->where('m.id_kategori', $kategori);
        }
 
        $i = 0;
     
        foreach ($this->column as $item) // loop column 
        {
            if($_POST['search']['value']) // if datatable send POST for search
            {
                 
                if($i===0) // first loop
                {
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND. 
                    $this->db->like($item, $_POST['search']['value']);
                }
                else
                {
                    $this->db->or_like($item, $_POST['search']['value']);
                }
 
                if(count($this->column) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $column[$i] = $item; // set column array variable to order processing
            $i++;
        }
         
        if(isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($column[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } 
        else if(isset($this->order))
        {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }
        
    function count_filtered($kategori)
    {
        $this->_get_datatables_query($kategori);
        $query = $this->db->get();
        return $query->num_rows();
    }
 
    public function count_all($kategori)
    {
        $this->_get_datatables_query($kategori);
        return $this->db->count_all_results();
    }
    
    function get_datatables($kategori)
    {
        $this->_get_datatables_query($kategori);
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }
    
    function getIDKategori($kategori){
        $this->db->where('kategori', $kategori);
        $result = $this->db->get('kategori')->row();
        if(!isset($result)){
            $this->db->insert('kategori',array('kategori' => ucwords($kategori)));
            return $this->db->insert_id();
        }
        return $result->id_kategori;
    }
            
    function cek_kombinasi($sn, $color){
        $this->db->where('short_name', $sn);
        $this->db->where('colour', $color);
        $this->db->from($this->_tabel);
        $result = $this->db->count_all_results();
        if($result == 0){
            return true;
        }
        return false;
    }
    
    function get_modifier(){
        $result = $this->db->get('modifier');
        return $result->result();
    }
    function get_resep(){
        $this->db->select('id_menu, menu');
        $this->db->where('manage_stock',1);
        $result = $this->db->get('menu');
        return $result->result();
    }
    function get_modifier_detail($name){
        $this->db->where('id_modifier',$name);
        $result = $this->db->get('modifier')->row();
        if(isset($result)){
            return $result;
        }else{
            return 0;
        }
        
    }
    function get_resep_detail($id){
        $this->db->select('satuan');
        $this->db->where('id_menu',$id);
        $result = $this->db->get('menu')->row();
        if(isset($result)){
            return $result;
        }else{
            return 0;
        }
        
    }
    
    function insert_modifier($menu){
        $modifier = $this->input->post('modifier');
        $tampilan = $this->input->post('tampilan');
        $harga = $this->input->post('harga');
        $this->db->select('id_menu');
        $this->db->where('menu',$menu);
        $result = $this->db->get('menu')->row();
        if(isset($result)){
            $id = $result->id_menu;
            for($i = 0; $i < sizeof($modifier); $i++){
                $this->insertModifier($i, $id, $modifier, $tampilan, $harga);
            }
        }
    }
    
    function insertModifier($i, $id, $modifier, $tampilan, $harga){
        if($modifier[$i] != ''){
            $this->db->where('id_modifier',  strtoupper($modifier[$i]));
            $mod = $this->db->get('modifier')->row();
            if(isset($mod)){
                $data = array(
                    'id_menu' => $id,
                    'id_modifier' => $mod->id_modifier
                );
                $this->db->insert('menu_modifier', $data);
            }else{
                 $data1 = array('id_modifier' => strtoupper($modifier[$i]),'tampilan' => ucwords($tampilan[$i]),'harga_modifier' => $harga[$i]);
                 $this->db->insert('modifier', $data1);
                 $data2 = array('id_menu' => $id,'id_modifier' => strtoupper($modifier[$i]));
                 $this->db->insert('menu_modifier', $data2);
            }
        }
    }
    
    function insert_resep($menu){
        $resep = $this->input->post('bahan');
        $qty = $this->input->post('qty');
        $this->db->select('id_menu');
        $this->db->where('menu',$menu);
        $result = $this->db->get('menu')->row();
        if(isset($result)){
            $id = $result->id_menu;
            for($i = 0; $i < sizeof($resep); $i++){
                if($resep[$i] != ''){
                    $data = array(
                        'id_menu' => $id,
                        'id_bahan' => $resep[$i],
                        'jumlah' => $qty[$i],
                    );
                    $this->db->insert('resep', $data);
                } 
            }
        }
    }
    
    function cek_menu_modifier_exist($id_menu, $id_modifier){
        $this->db->where('id_menu',$id_menu);
        $this->db->where('id_modifier',$id_modifier);
        $result = $this->db->get('menu_modifier')->row();
        if(isset($result)){
            return TRUE;
        }
        return FALSE;
    }
    
    function getMenuModifier($id_menu){
        $this->db->select('m.id_modifier as id_modifier, harga_modifier, tampilan');
        $this->db->join('modifier m','mm.id_modifier = m.id_modifier','left');
        $this->db->where('id_menu', $id_menu);
        $this->db->order_by('harga_modifier','asc');
        $result = $this->db->get('menu_modifier mm');
        return $result->result();
    }
    function getMenuResep($id_menu){
        $this->db->select('id_bahan, jumlah');
        $this->db->join('menu m','r.id_bahan = m.id_menu','left');
        $this->db->where('r.id_menu', $id_menu);
        $result = $this->db->get('resep r');
        return $result->result();
    }
    
    function assignToAllOutlet($menu){
        $this->db->select('id_menu, price, gojek_price');
        $this->db->where('menu',$menu);
        $result = $this->db->get('menu')->row();
        if(isset($result)){
            $outlets = $this->db->get('outlet');
            if($outlets->result()){
                foreach ($outlets->result() as $outlet){
                    $data = array(
                        'id_outlet' => $outlet->id_outlet,
                        'id_menu' => $result->id_menu,
                        'harga' => $result->price,
                        'harga_gojek' => $result->gojek_price
                    );
                    $this->db->insert('outlet_menu',$data);
                }
            }
        }
    }
    
    function updatePilihan($id_menu){
        $modifier = $this->input->post('modifier');
        $tampilan = $this->input->post('tampilan');
        $harga = $this->input->post('harga');
        $this->deletePilihan($id_menu);
        for($i = 0; $i < sizeof($modifier); $i++){
            if($modifier[$i] != ''){
                $this->db->where('id_modifier',  strtoupper($modifier[$i]));
                $mod = $this->db->get('modifier')->row();
                if(isset($mod)){
                    $data = array(
                        'id_menu' => $id_menu,
                        'id_modifier' => $mod->id_modifier
                    );
                    $this->db->insert('menu_modifier', $data);
                }else{
                     $data1 = array('id_modifier' => strtoupper($modifier[$i]),'tampilan' => ucwords($tampilan[$i]),'harga_modifier' => $harga[$i]);
                     $this->db->insert('modifier', $data1);
                     $data2 = array('id_menu' => $id_menu,'id_modifier' => strtoupper($modifier[$i]));
                     $this->db->insert('menu_modifier', $data2);
                }
            }
        }
    }
    
    function deletePilihan($id_menu){
        $this->db->where('id_menu', $id_menu);
        $this->db->delete('menu_modifier');
    }
    
    function updateResep($id_menu){
        $resep = $this->input->post('bahan');
        $qty = $this->input->post('qty');
        $this->deleteResep($id_menu);
        for($i = 0; $i < sizeof($resep); $i++){
            if($resep[$i] != ''){
                $data = array(
                    'id_menu' => $id_menu,
                    'id_bahan' => $resep[$i],
                    'jumlah' => $qty[$i],
                );
                $this->db->insert('resep', $data);
            } 
        }
    }
    
    function deleteResep($id_menu){
        $this->db->where('id_menu', $id_menu);
        $this->db->delete('resep');
    }
    
    function export(){
            $table_name = "menu";
            $query = $this->sheetMenuQuery();
            $query2 = $this->sheetPilihanQuery();
            $query3 = $this->sheetResepQuery();
            
            $this->load->library('excel');

            $objPHPExcel = new PHPExcel();
            $objPHPExcel->getProperties()->setTitle("export")->setDescription("none");
            
            $objPHPExcel->setActiveSheetIndex(0);
            $objPHPExcel = $this->generateSheet($objPHPExcel, $query);
            $objPHPExcel->getActiveSheet()->setTitle(ucfirst('menu'));
            
            $objPHPExcel->createSheet();
            
            $objPHPExcel->setActiveSheetIndex(1);
            $objPHPExcel = $this->generateSheet($objPHPExcel, $query2);
            $objPHPExcel->getActiveSheet()->setTitle(ucfirst('pilihan'));
            
            $objPHPExcel->createSheet();
            
            $objPHPExcel->setActiveSheetIndex(2);
            $objPHPExcel = $this->generateSheet($objPHPExcel, $query3);
            $objPHPExcel->getActiveSheet()->setTitle(ucfirst('resep'));
            
            $objPHPExcel->setActiveSheetIndex(0);

            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');

            // Sending headers to force the user to download the file
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="'.ucfirst($table_name).'_'.date('dMY').'.xls"');
            header('Cache-Control: max-age=0');
            
            $objWriter->save('php://output');
    }
    
    function sheetMenuQuery(){
        $this->db->select('kategori, menu, deskripsi, price, gojek_price, manage_stock as stok, satuan');
        $this->db->join('kategori k','m.id_kategori = k.id_kategori','left');
        $this->db->order_by('kategori','asc');
        $this->db->order_by('menu','asc');
        $query = $this->db->get('menu m');
        if(!$query)
            return false;
        return $query;
    }
    function sheetPilihanQuery(){
        $this->db->select('menu, tampilan as pilihan, harga_modifier as harga');
        $this->db->join('menu m','mm.id_menu = m.id_menu','left');
        $this->db->join('modifier md','mm.id_modifier = md.id_modifier','left');
        $this->db->order_by('menu','asc');
        $this->db->order_by('harga_modifier','asc');
        $query = $this->db->get('menu_modifier mm');
        if(!$query){return false;}
        return $query;
    }
    function sheetResepQuery(){
        $this->db->select('m.menu, mm.menu as bahan, jumlah');
        $this->db->join('menu m','r.id_menu = m.id_menu','left');
        $this->db->join('menu mm','r.id_bahan = mm.id_menu','left');
        $this->db->order_by('m.menu','asc');
        $this->db->order_by('mm.menu','asc');
        $query = $this->db->get('resep r');
        if(!$query){return false;}
        return $query;
    }
    
    function generateSheet($objPHPExcel, $query){
        // Field names in the first row
        $fields = $query->list_fields();
        $col = 0;
        foreach ($fields as $field)
        {
            $field = ucwords(str_replace("_", " ", $field));
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, 1, $field);
            $col++;
        }
        // Fetching the table data
        $row = 2;
        foreach($query->result() as $data)
        {
            $col = 0;
            foreach ($fields as $field)
            {
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $data->$field);
                $col++;
            }

            $row++;
        }
        return $objPHPExcel;
    }
    
    function import(){
        $d = array();
        $d['message']= "Success";
        $d['status'] = true;
        $file   = explode('.',$_FILES['file']['name']);
        $length = count($file);
        if($file[$length -1] == 'xlsx' || $file[$length -1] == 'xls'){
            $tmp    = $_FILES['file']['tmp_name'];
            $this->load->library('excel');
            $read   = PHPExcel_IOFactory::createReaderForFile($tmp);
            $read->setReadDataOnly(true);
            $excel  = $read->load($tmp);
            $sheets = $read->listWorksheetNames($tmp);
            foreach($sheets as $sheet){
                if($this->checkExist($sheet)){
                    $_sheet = $excel->setActiveSheetIndexByName($sheet);
                    $maxRow = $_sheet->getHighestRow();
                    $maxCol = $_sheet->getHighestColumn();
                    $field  = array();
                    $maxCol = range('A',$maxCol);
                    if($sheet == "Menu"){
                        $this->insertToDBMenu($maxCol, $maxRow, $field, $_sheet, strtolower($sheet));
                    }else if($sheet == "Pilihan"){
                        $this->insertToDBPilihan($maxCol, $maxRow, $field, $_sheet, strtolower($sheet));
                    }else if($sheet == "Resep"){
                        $this->insertToDBResep($maxCol, $maxRow, $field, $_sheet, strtolower($sheet));
                    }
                }
            }
        }else{
            $d['message']= "Do not allowed to upload";
            $d['status'] = FALSE;
        }
        return $d;
    }
    
    function checkExist($sheet){
        $sheet = strtolower($sheet);
        if($sheet == "pilihan"){
            $sheet = "modifier";
        }
        $exist = $this->db->table_exists($sheet);
        return $exist;
    }
    
    function insertToDBMenu($maxCol, $maxRow, $field, $_sheet, $sheet){
        $sql    = array();
        foreach($maxCol as $key => $coloumn){
            if($_sheet->getCell($coloumn.'1')->getCalculatedValue() == "stok"){
                $field[$key]  = "manage_stock";
            }else{
                $field[$key]    = strtolower(str_replace(" ","_",$_sheet->getCell($coloumn.'1')->getCalculatedValue()));
            }
        }
        for($i = 2; $i <= $maxRow; $i++){
            $insert = true;
            $sold = $manage_stock = $auto_assign = 1;
            $stok = 0;
            $mID = -1;
            foreach($maxCol as $k => $coloumn){
                if(strtolower($_sheet->getCell($coloumn.'1')->getCalculatedValue()) == "kategori"){
                    $sql['id_kategori'] = $this->getIDKategori($_sheet->getCell($coloumn.$i)->getCalculatedValue());
                }else if(strtolower($_sheet->getCell($coloumn.'1')->getCalculatedValue()) == "menu"){
                    $kom = $this->imgComb($_sheet->getCell($coloumn.$i)->getCalculatedValue());
                    if($this->menuExist($_sheet->getCell($coloumn.$i)->getCalculatedValue())){
                        $insert = FALSE;
                        $mID = $this->getIDMenu($_sheet->getCell($coloumn.$i)->getCalculatedValue());
                    }else{
                        $sql[$field[$k]]  = $_sheet->getCell($coloumn.$i)->getCalculatedValue();
                    }      
                }else if(strtolower($_sheet->getCell($coloumn.'1')->getCalculatedValue()) == 'stok'){
                    if($_sheet->getCell($coloumn.$i)->getCalculatedValue() > 0){
                        $stok = $_sheet->getCell($coloumn.$i)->getCalculatedValue();
                        $manage_stock = 1;
                        $sold = 0;
                    }else{
                        $manage_stock = 0;
                    }
                }
                else{
                    $sql[$field[$k]]  = $_sheet->getCell($coloumn.$i)->getCalculatedValue();
                }
            }
            $sql['sold'] = $sold; $sql['manage_stock'] = $manage_stock; $sql['auto_assign'] = $auto_assign;
            $sql['short_name'] = $kom['sn']; $sql['colour'] = $kom['selected_colour'];
            if($insert){
                $this->db->insert($sheet,$sql);
                $this->insertToOutlet($this->db->insert_id(), $stok, $sql);
            }else{
                $this->updateMenu($mID, $sql);
                $this->updateMenuOutlet($mID, $stok, $sql);
            }
        }
    }
    
    function insertToDBPilihan($maxCol, $maxRow, $field, $_sheet, $sheet){
        $sql    = array();
        foreach($maxCol as $key => $coloumn){
            if($_sheet->getCell($coloumn.'1')->getCalculatedValue() == "Menu"){
                $field[$key] = 'id_menu';
            }else if($_sheet->getCell($coloumn.'1')->getCalculatedValue() == "Pilihan"){
                $field[$key] = 'id_modifier';
            }else if($_sheet->getCell($coloumn.'1')->getCalculatedValue() == "Harga"){
                $field[$key] = 'harga_modifier';
            }
        }
        for($i = 2; $i <= $maxRow; $i++){
            $insert = false;
            foreach($maxCol as $k => $coloumn){
                if($_sheet->getCell($coloumn.'1')->getCalculatedValue() == "Menu"){
                    if($this->menuExist($_sheet->getCell($coloumn.$i)->getCalculatedValue())){
                        $insert = TRUE;
                        $sql[$field[$k]]  = $this->getIDMenu($_sheet->getCell($coloumn.$i)->getCalculatedValue());
                    }
                }else{
                    $sql[$field[$k]]  = $_sheet->getCell($coloumn.$i)->getCalculatedValue();
                }
            }
            if($insert){
                $idMod = $this->getPilihan($sql['id_modifier'], $sql['harga_modifier']);
                $col = array();
                $col['id_menu'] = $sql['id_menu'];
                $col['id_modifier'] = $idMod;
                if(!$this->combExist($col)){
                    $this->db->insert('menu_modifier',$col);
                }
                /*Updateing modifier price
                else{
                    $this->db->set('harga_modifier',$sql['harga_modifier']);
                    $this->db->where('id_modifier', $idMod);
                    $this->db->where('modifier');
                }*/
            }     
        }
    }
    
    function insertToDBResep($maxCol, $maxRow, $field, $_sheet, $sheet){
        $sql    = array();
        foreach($maxCol as $key => $coloumn){
            if($_sheet->getCell($coloumn.'1')->getCalculatedValue() == "Menu"){
                $field[$key] = 'id_menu';
            }else if($_sheet->getCell($coloumn.'1')->getCalculatedValue() == "Bahan"){
                $field[$key] = 'id_bahan';
            }else if($_sheet->getCell($coloumn.'1')->getCalculatedValue() == "Jumlah"){
                $field[$key] = 'jumlah';
            }
        }
        for($i = 2; $i <= $maxRow; $i++){
            $insert = false;
            foreach($maxCol as $k => $coloumn){
                if($_sheet->getCell($coloumn.'1')->getCalculatedValue() == "Menu"){
                    if($this->menuExist($_sheet->getCell($coloumn.$i)->getCalculatedValue())){
                       $sql[$field[$k]]  = $this->getIDMenu($_sheet->getCell($coloumn.$i)->getCalculatedValue()); 
                       $insert = TRUE;
                    }
                }else if($_sheet->getCell($coloumn.'1')->getCalculatedValue() == "Bahan"){
                    if($this->menuExist($_sheet->getCell($coloumn.$i)->getCalculatedValue())){
                       $sql[$field[$k]]  = $this->getIDMenu($_sheet->getCell($coloumn.$i)->getCalculatedValue()); 
                       $insert = TRUE;
                    }
                }else{
                    $sql[$field[$k]]  = $_sheet->getCell($coloumn.$i)->getCalculatedValue();
                }
            }
            if($insert){
                if(!$this->combResepExist($sql)){
                    $this->db->insert('resep',$sql);
                }
            }     
        }
    }
    
    function imgComb($menu){
        $kom = array();
        $sn = '';
        foreach (preg_split('#[^a-z]+#i', $menu, -1, PREG_SPLIT_NO_EMPTY) as $word) {
            $sn .= $word[0];
        }
        $sn = substr($sn, 0, 2);
        $color = array('aqua', 'blue', 'purple', 'green', 'red', 'lime', 'maroon', 'orange', 'olive', 'teal');
        $selected_colour = 'white';
        foreach ($color as $item){
            $result = $this->cek_kombinasi($sn, $item);
            if($result){
                $selected_colour = $item;
                break;
            }
        }
        $kom['sn'] = $sn;
        $kom['selected_colour'] = $selected_colour;
        return $kom;
    }
    
    function menuExist($menu){
        $this->db->where('menu',$menu);
        $result = $this->db->get('menu')->row();
        if(isset($result)){
            return true;
        }
        return false;
    }
    
    function getIDMenu($menu){
        $this->db->where('menu',$menu);
        $result = $this->db->get('menu')->row();
        return $result->id_menu;
    }


    function insertToOutlet($id_menu, $stok, $sql){
        $data = array(
            'id_menu' => $id_menu,
            'id_outlet' => $this->session->userdata('outlet'),
            'stok' => $stok,
            'harga' => $sql['price'],
            'harga_gojek' => $sql['gojek_price']
        );
        $this->db->insert('outlet_menu',$data);
    }
    
    function updateMenu($id_menu, $attr){
        $data = array(
            'price' => $attr['price'],
            'gojek_price' => $attr['gojek_price']
        );
        $this->db->where('id_menu', $id_menu);
        $this->db->update($this->_tabel, $data);
    }
    function updateMenuOutlet($id_menu, $stok, $attr){
        $data = array(
            'harga' => $attr['price'],
            'harga_gojek' => $attr['gojek_price']
        );
        $this->db->where('id_outlet', $this->session->userdata('outlet'));
        $this->db->where('id_menu', $id_menu);
        $this->db->update('outlet_menu', $data);
        
        $this->db->set('stok','stok+'.$stok, FALSE);
        $this->db->where('id_outlet', $this->session->userdata('outlet'));
        $this->db->where('id_menu', $id_menu);
        $this->db->update('outlet_menu');
    }
    
    
            
    function getPilihan($mod, $harga){
        $this->db->where('harga_modifier', $harga);
        $this->db->like('id_modifier', strtoupper($mod), 'after');
        $result = $this->db->get('modifier')->row();
        if(isset($result)){
            return $result->id_modifier;
        }else{
            $inc ='';
            $this->db->like('id_modifier', strtoupper($mod),'after');
            $result = $this->db->get('modifier');
            if($result->result()){
                $inc = $result->num_rows()+1;
            }
            
            $this->db->insert('modifier', array(
                'id_modifier' => strtoupper($mod).$inc,
                'tampilan' => $mod,
                'harga_modifier' => $harga
            ));
            $this->db->where('id_modifier',strtoupper($mod).$inc);
            $res = $this->db->get('modifier')->row();
            return $res->id_modifier;
        }
    }
    
    function combExist($col){
        $this->db->where('id_menu',$col['id_menu']);
        $this->db->where('id_modifier',$col['id_modifier']);
        $result = $this->db->get('menu_modifier')->row();
        if(isset($result)){
            return TRUE;
        }
        return FALSE;
    }
    function combResepExist($col){
        $this->db->where('id_menu',$col['id_menu']);
        $this->db->where('id_bahan',$col['id_bahan']);
        $result = $this->db->get('resep')->row();
        if(isset($result)){
            return TRUE;
        }
        return FALSE;
    }
}
