<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kategori_M extends My_Model {

     protected $_tabel = 'kategori';
    
     var $table = 'kategori';
     var $column = array('id_kategori','id_kategori','kategori'); //set column field database for order and search
     var $order = array('id_kategori' => 'asc'); // default order 
     
     private function _get_datatables_query()
        {
         
        $this->db->from($this->table);
 
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
        
    function count_filtered()
    {
        $this->_get_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }
 
    public function count_all()
    {
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }
    
    function get_datatables()
    {
        $this->_get_datatables_query();
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }
    
    function getListKategori(){
        $this->db->select('DISTINCT(k.id_kategori) as id_kategori, kategori');
        $this->db->join($this->_tabel.' k','m.id_kategori = k.id_kategori','left');
        $this->db->where('sold', 1);
        $result = $this->db->get('menu m');
        return $result->result();
    }
            
    function get_list2(){
        $list = array();
        $this->db->select('kategori');
        $result = $this->db->get($this->_tabel);
        if($result->result()){
            foreach ($result->result() as $item){
                $list[] = $item->kategori;
            }
        }
        return $list;
    }
            
    function export($table_name=""){
            $query = $this->db->get($table_name);
 
            if(!$query)
                return false;

            $this->load->library('excel');

            $objPHPExcel = new PHPExcel();
            $objPHPExcel->getProperties()->setTitle("export")->setDescription("none");

            $objPHPExcel->setActiveSheetIndex(0);

            // Field names in the first row
            $fields = $query->list_fields();
            $col = 0;
            foreach ($fields as $field)
            {
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
            $objPHPExcel->setActiveSheetIndex(0);
            $objPHPExcel->getActiveSheet()->setTitle(ucfirst('kategori'));

            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');

            // Sending headers to force the user to download the file
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="'.ucfirst($table_name).'_'.date('dMY').'.xls"');
            header('Cache-Control: max-age=0');

            $objWriter->save('php://output');
    }
            
    function import(){
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
                    if($this->db->table_exists($sheet)){
                        $_sheet = $excel->setActiveSheetIndexByName($sheet);
                        $maxRow = $_sheet->getHighestRow();
                        $maxCol = $_sheet->getHighestColumn();
                        $field  = array();
                        $sql    = array();
                        $maxCol = range('A',$maxCol);
                        foreach($maxCol as $key => $coloumn){
                            $field[$key]    = $_sheet->getCell($coloumn.'1')->getCalculatedValue();
                        }
                        for($i = 2; $i <= $maxRow; $i++){
                            foreach($maxCol as $k => $coloumn){
                                $sql[$field[$k]]  = $_sheet->getCell($coloumn.$i)->getCalculatedValue();
                            }
                            $this->db->insert($sheet,$sql);
                        }
                    }
                }
            }else{
                exit('do not allowed to upload');
            }
//            redirect('home');
    }
     
}
