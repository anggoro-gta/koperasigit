<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
 
 // vendor\mpdf\mpdf
include_once APPPATH.'/third_party/mpdf/mpdf.php';
 
class M_pdf {

    public $param;
    public $pdf;
    public function __construct($param = "'utf-8', array(210,290)")
    {
      $this->param =$param;
      $this->pdf = new mPDF($this->param);
    }
 }