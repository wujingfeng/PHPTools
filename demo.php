<?php


require_once "./vendor/autoload.php";

use FileTools\ImageTools;
use FileTools\PHPExcelTools;
use GeneralTools\StringTools;
use FileTools\FileTools;
use GeneralTools\OtherTools;
//use Others\Sorts;
use GeneralTools\Sorts;
//ImageTool::index();
//$result = StringTools::to_guid_string(6);
//print_r($result);

//PHPExcelTools::export();
//PHPExcelTools::index();
//$e = new PHPExcel();
//$c = $e->getActiveSheet();
////print_r($c);
//
//$a = new PHPExcel_Writer_Excel5($e);
//$b=$a->getDiskCachingDirectory();
//print_r($b);

//FileTools::autoDownloadPic();
//$res = OtherTools::getCyclingDistance();
//print($res);

//Sorts::BubbleSort([3,4,2,5,1,6]);
//Sorts::selectSort([3,4,2,5,1,6]);
Sorts::insertSort([3,4,2,5,1,6]);
