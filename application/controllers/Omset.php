<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Omset extends MY_Controller {

	function  __construct() {
                parent::__construct();
                $this->load->model('Omset_M', 'omset');
                $this->load->model('Perproduk_M', 'pm');
                $this->load->model('Perkategori_M', 'pk');
                }
                
	public function index()
	{
                
                $this->get_menu();
		$this->load->view('laporan/omset');
		$this->load->view('footer');
                
	}
        
        function get_data($start = "", $end = "", $outlet=""){
            if($start == $end){
                $lbl = $this->omset->getLabelHours($start, $outlet);
            }else{
                 $lbl = $this->omset->getLabel($start, $end, $outlet);
            }
            $dataset = array();
            if($outlet == "" || $outlet == 'null'){
                $outlet = $this->omset->getListOutlet();
                foreach ($outlet as $item) {
                    $dataset = $this->generateData($item, $start, $end, $dataset, $lbl);
                }
            }else{
                $outlet = $this->omset->getOutlet($outlet);
                $dataset = $this->generateData($outlet, $start, $end, $dataset, $lbl);
            }
            
            echo json_encode($dataset);
        }
        
        function get_label($start = "", $end = "",$outlet=""){
            if($start == $end){
                $lbl = $this->omset->getLabelHours($start, $outlet);
            }else{
                 $lbl = $this->omset->getLabel($start, $end, $outlet);
            }
            
            echo json_encode($lbl);
        }
        
        function generateData($outlet, $start, $end, $dataset, $lbl){
            //$diff = round(abs(strtotime($start)-strtotime($end))/86400);
            //echo $diff;
            $opacity1 = '0.4';
            $opacity2 = '1';
            $row = array();
            $data = array();
            foreach ($lbl as $value) {
                array_push($data, $this->omset->getDataOmset($outlet->id_outlet, $value, $start, $end));
                
            }
            $color1 = rand(0, 255);
            $color2 = rand(0, 255);
            $color3 = rand(0, 255);
            $row['label'] = $outlet->nama_outlet;
            $row['fill'] = false;
            $row['lineTension'] = 0.2;
            $row['backgroundColor'] = "rgba($color1,$color2,$color3,0.4)";
            $row['borderColor'] = "rgba($color1,$color2,$color3,1)";
            $row['borderCapStyle'] = 'butt';
            $row['borderDash'] = [];
            $row['borderDashOffset'] = 0.0;
            $row['borderJoinStyle'] = 'miter';
            $row['pointBorderColor'] = "rgba($color1,$color2,$color3,1)";
            $row['pointBackgroundColor'] = "#fff";
            $row['pointBorderWidth'] = 1;
            $row['pointHoverRadius'] = 5;
            $row['pointHoverBackgroundColor'] = "rgba($color1,$color2,$color3,1)";
            $row['pointHoverBorderColor'] = "rgba(225,225,225,0.5)";
            $row['pointHoverBorderWidth'] = 2;
            $row['pointRadius'] = 3;
            $row['pointHitRadius'] = 10;
            $row['spanGaps'] = false;
            $row['data'] = $data;
            $dataset[] = $row;
            return $dataset;
        }
        
        function getBarData($start = "", $end = "", $outlet=""){
             if($outlet == "null"){
                $outlet = "";
            }
            $data = array();
            $list = $this->pm->getReportSorted($start, $end, $outlet,'jumlah');
            $label = array();
            $point = array();
            foreach ($list as $item){
                $label[] = $item->menu.' '.$item->tampilan;  
                $point[] = $item->jumlah;
            }
            $label[] = "";
            $point[] = 0;
            $data['label'] = $label;
            $data['point'] = $point;
            echo json_encode($data);
        }
        function getBarData2($start = "", $end = "", $outlet=""){
            if($outlet == "null"){
                $outlet = "";
            }
            $data = array();
            $list = $this->pm->getReportSorted($start, $end, $outlet,'total');
            $label = array();
            $point = array();
            foreach ($list as $item){
                $label[] = $item->menu.' '.$item->tampilan;  
                $point[] = $item->total;
            }
            $label[] = "";
            $point[] = 0;
            $data['label'] = $label;
            $data['point'] = $point;
            echo json_encode($data);
        }
        function getPieData($start = "", $end = "", $outlet=""){
             if($outlet == "null"){
                $outlet = "";
            }
            $data = array();
            $list = $this->pk->getPieData($start, $end, $outlet);
            $label = array();
            $point = array();
            foreach ($list as $item){
                $label[] = $item->kategori;  
                $point[] = $item->total;
            }
            $data['label'] = $label;
            $data['point'] = $point;
            echo json_encode($data);
        }
}
