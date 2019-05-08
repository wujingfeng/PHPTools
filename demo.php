<?php


require_once "./vendor/autoload.php";

use FileTools\ImageTools;
use FileTools\PHPExcelTools;
use GeneralTools\StringTools;


//ImageTool::index();
//$result = StringTools::to_guid_string(6);
//print_r($result);

PHPExcelTools::export();
