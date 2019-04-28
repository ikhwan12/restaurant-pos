<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
// IMPORTANT - Replace the following line with your path to the escpos-php autoload script
require_once APPPATH. '/third_party/autoload.php';
use Mike42\Escpos\PrintConnectors\NetworkPrintConnector;
use Mike42\Escpos\PrintConnectors\FilePrintConnector;
use Mike42\Escpos\EscposImage;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\Printer;
class ReceiptPrint {
  private $CI;
  private $connector;
  private $printer;
  // TODO: printer settings
  // Make this configurable by printer (32 or 48 probably)
  private $printer_width = 32;
  function __construct()
  {
    $this->CI =& get_instance(); // This allows you to call models or other CI objects with $this->CI->... 
  }
  function connect($connector)
  {
    $data = array();  
    $data['connected'] = TRUE;
    $data['message'] = "";
    $cerl = error_reporting ();
    error_reporting (0);
    try{
        $connector = new WindowsPrintConnector($connector);
        $printer = new Printer($connector);
        $printer->close();
    }  catch (Exception $e){
       $data['connected'] = FALSE;  
       $data['message'] = $e->getMessage();
    }
    error_reporting ($cerl);  
    return $data;
  }
  function strukPrint($connector, $outlet, $order, $items, $kasir)
  {
    try {
        // Enter the share name for your USB printer here
        if(file_exists("./assets/images/logo_print2.png")){
            $logo = EscposImage::load("./assets/images/logo_print2.png", false);
        }
        if(file_exists("./assets/images/footer.png")){
            $logo2 = EscposImage::load("./assets/images/footer.png", false);
        }
        $connector = new WindowsPrintConnector($connector);
        $printer = new Printer($connector);
        
        $printer -> setJustification(Printer::JUSTIFY_CENTER);
        if(isset($logo)){
            //$printer -> bitImage($logo);
        }
        
        /* Name of shop */
        $printer -> selectPrintMode(Printer::MODE_EMPHASIZED);
        $printer -> text($outlet->nama_outlet.".\n");
        $printer -> selectPrintMode(Printer::FONT_B);
        $printer -> text($outlet->alamat_outlet.".\n");
        $printer -> feed();
        
        /* Title of receipt */
        $printer -> setJustification(Printer::JUSTIFY_LEFT);
        $printer -> text("No : ".$order->id_order."\n");
        if($order->meja == ""){
            $meja = "-";
        }else{
            $meja = $order->meja;
        }
        if($order->customer == ""){
            $customer = "-";
        }else{
            $customer  = $order->customer;
        }
        $printer -> text(sprintf("%-32s%+10s", "Customer : ".$customer, "Meja : ".$meja."\n"));
        $printer -> text("Kasir : ".$kasir."\n");
        
        /* Items */
        $printer -> selectPrintMode(Printer::MODE_EMPHASIZED);
        $printer -> text(str_repeat("-", 32)."\n");
        $printer -> selectPrintMode();
        $stotal = 0;
        foreach ($items as $item) {
            $printer -> text($item->menu." ".$item->tampilan."\n");
            $printer -> text(sprintf("%+16s%+16s", $item->jumlah." x ".number_format($item->harga, 0,'.',','), number_format($item->harga*$item->jumlah, 0,'.',',')."\n"));
            $stotal += $item->harga*$item->jumlah;
        }
        $printer -> selectPrintMode(Printer::MODE_EMPHASIZED);
        $printer -> text(str_repeat("-", 32)."\n");
        $printer -> selectPrintMode();
         /* Tax and total */
        $printer -> setEmphasis(true);
        $printer -> text(sprintf("%+16s%+16s", "Subtotal", number_format($stotal, 0,'.',',')."\n"));
        if($order->diskon > 0){
            $printer -> text(sprintf("%+16s%+16s", "Diskon", number_format($order->diskon, 0,'.',',')."\n"));
        }
        $pajak = ($stotal-$order->diskon)*($order->o_ppn/100);
        if($order->o_ppn > 0){
            $printer -> text(sprintf("%+16s%+16s", "Pajak"."(".$order->o_ppn."%)", number_format($pajak, 0,'.',',')."\n"));
        }
        $printer -> text(sprintf("%+16s%+16s",'',str_repeat("-", 16)."\n"));
        $printer -> text(sprintf("%+16s%+16s", "Total", number_format($stotal-$order->diskon+$pajak, 0,'.',',')."\n"));
        $printer -> text(sprintf("%+16s%+16s", "Tunai", number_format($order->bayar, 0,'.',',')."\n"));
        $printer -> text(sprintf("%+16s%+16s",'',str_repeat("-", 16)."\n"));
        $printer -> text(sprintf("%+16s%+16s", "Kembali", number_format($order->bayar-($stotal-$order->diskon+$pajak), 0,'.',',')."\n"));
        $printer -> selectPrintMode();
        $printer -> setEmphasis(false);
        /* Footer */
        $printer -> feed();
        $printer -> setJustification(Printer::JUSTIFY_CENTER);
        $printer -> selectPrintMode(Printer::FONT_B);
        $printer -> text(strtoupper("Terima Kasih Atas Kunjungan Anda\n"));
        $printer -> text(str_repeat("=", 13).strtoupper("Layanan Konsumen").str_repeat("=", 13)."\n");
        $printer -> text("CALL / SMS ".$outlet->telp."\n");
        $printer -> text("Buka : 11:00 - 22:00 WIB\n");
        if(isset($logo2)){
            $printer -> bitImage($logo2);
        }
        $printer -> text(date("d.m.Y-H:i:s") . "\n");
        $printer -> feed(4);
        
        //$printer -> cut();

        /* Close printer */
        $printer -> close();
    } catch (Exception $e) {
        echo "Couldn't print to this printer: " . $e -> getMessage() . "\n";
    }
  }
  function kitchenPrint($connector, $outlet, $order, $items, $kasir)
  {
    try {
        // Enter the share name for your USB printer here
        $connector = new WindowsPrintConnector($connector);
        $printer = new Printer($connector);
        
        $printer -> setJustification(Printer::JUSTIFY_CENTER);
        
        /* Name of shop */
        $printer -> selectPrintMode(Printer::MODE_EMPHASIZED);
        $printer -> text($outlet->nama_outlet.".\n");
        $printer -> selectPrintMode(Printer::FONT_B);
        $printer -> text($outlet->alamat_outlet.".\n");
        $printer -> feed();
        
        /* Title of receipt */
        $printer -> setJustification(Printer::JUSTIFY_LEFT);
        $printer -> text("No : ".$order->id_order."\n");
        if($order->meja == ""){
            $meja = "-";
        }else{
            $meja = $order->meja;
        }
        if($order->customer == ""){
            $customer = "-";
        }else{
            $customer  = $order->customer;
        }
        $printer -> text(sprintf("%-32s%+10s", "Customer : ".$customer, "Meja : ".$meja."\n"));
        $printer -> text("Kasir : ".$kasir."\n");
        
        /* Items */
        $printer -> feed();
        $printer -> selectPrintMode();
        $printer -> setEmphasis(true);
        $printer -> text(sprintf("%-16s%+16s", "Menu","Qty\n"));
        $printer -> setEmphasis(false);
        $printer -> text(str_repeat("-", 32)."\n");
        $stotal = 0;
        foreach ($items as $item) {
            $printer -> text($item->menu." ".$item->tampilan."\n");
            $printer -> text(sprintf("%+32s", "x".$item->jumlah."\n"));
        }
        $printer -> text(str_repeat("=", 32)."\n");
        $printer -> feed();
        $printer -> setJustification(Printer::JUSTIFY_CENTER);
        $printer -> selectPrintMode(Printer::FONT_B);
        $printer -> text(date("d.m.Y-H:i") . "\n");
        $printer -> feed(3);
        //$printer -> cut();

        /* Close printer */
        $printer -> close();
    } catch (Exception $e) {
        echo "Couldn't print to this printer: " . $e -> getMessage() . "\n";
    }
  }
  private function check_connection()
  {
    if (!$this->connector OR !$this->printer OR !is_a($this->printer, 'Mike42\Escpos\Printer')) {
      throw new Exception("Tried to create receipt without being connected to a printer.");
    }
  }
  public function close_after_exception()
  {
    if (isset($this->printer) && is_a($this->printer, 'Mike42\Escpos\Printer')) {
      $this->printer->close();
    }
    $this->connector = null;
    $this->printer = null;
    $this->emc_printer = null;
  }
  // Calls printer->text and adds new line
  private function add_line($text = "", $should_wordwrap = true)
  {
    $text = $should_wordwrap ? wordwrap($text, $this->printer_width) : $text;
    $this->printer->text($text."\n");
  }
  public function print_test_receipt($text = "")
  {
    $this->check_connection();
    $this->printer->setJustification(Printer::JUSTIFY_CENTER);
    $this->printer->selectPrintMode(Printer::MODE_DOUBLE_WIDTH);
    $this->add_line("TESTING");
    $this->add_line("Receipt Print");
    $this->printer->selectPrintMode();
    $this->add_line(); // blank line
    $this->add_line($text);
    $this->add_line(); // blank line
    $this->add_line(date('Y-m-d H:i:s'));
    $this->printer->cut(Printer::CUT_PARTIAL);
    $this->printer->close();
  }
}

class item
{
    private $name;
    private $price;
    private $dollarSign;
    public function __construct($name = '', $price = '', $dollarSign = false)
    {
        $this -> name = $name;
        $this -> price = $price;
        $this -> dollarSign = $dollarSign;
    }
    
    public function __toString()
    {
        $rightCols = 10;
        $leftCols = 30;
        if ($this -> dollarSign) {
            $leftCols = $leftCols / 2 - $rightCols / 2;
        }
        $left = str_pad($this -> name, $leftCols) ;
        
        $sign = ($this -> dollarSign ? 'Rp. ' : '');
        $right = str_pad($sign . $this -> price, $rightCols, ' ', STR_PAD_LEFT);
        return "$left$right";
    }
}