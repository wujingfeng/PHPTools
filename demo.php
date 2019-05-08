<?php


require_once "./vendor/autoload.php";

use FileTools\ImageTools;
use FileTools\PHPExcelTools;
use GeneralTools\StringTools;


//ImageTool::index();
//$result = StringTools::to_guid_string(6);
//print_r($result);

//PHPExcelTools::export();
PHPExcelTools::index();
$e = new PHPExcel();
$c = $e->getActiveSheet();
//print_r($c);

$a = new PHPExcel_Writer_Excel5($e);
$b=$a->getDiskCachingDirectory();
print_r($b);
