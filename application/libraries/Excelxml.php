<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once APPPATH."/third_party/ExcelWriterXML/ExcelWriterXML.php";

class Excelxml extends ExcelWriterXML {
    public function __construct() {
        parent::__construct();
    }
}