<?php


namespace FileTools;

//use PHPExcel;
//use PHPExcel_Writer_Excel5;
//require_once "./vendor/phpoffice/phpexcel/Classes/PHPExcel.php";
//if (!defined('PHPEXCEL_ROOT')) {
//    define('PHPEXCEL_ROOT', dirname(__FILE__) . '/');
//    require_once(PHPEXCEL_ROOT . '../vendor/phpoffice/phpexcel/Classes/PHPExcel.php');
//}

class PHPExcelTools
{

    /*
     * 导出文件 生成excel表格
     * @param array $headers 表头 关联数组 例如: ['shop_name'=>店铺名称]
     * @param array $res 数据  例如:[ ["shop_name"=>"笑嘻嘻",] ]
     * @param string $fileName 文件名
     * @param integer $columns 允许导出的最大列数
     * @param string $mark 文件默认备注
     * @return mixed
     */
    public static function export($headers, $res, $fileName = null, $columns = 24, $mark = '')
    {
        try {
            // 暂不支持导出超过二十四行的
            if (empty($headers) || count($headers) > $columns) {
                die('error');
            }
            $excel = new PHPExcel();
            $data = [];
            $chr = 65; // 65是大写的A (ASCII)
            $letter = [];
            //得到当前工作表对象
            $currentSheet = $excel->getActiveSheet();
            foreach ($headers as $key => $header) {
                $line = chr($chr);
                $currentSheet->getStyle($line . '1')->getFont()->setName('微软雅黑')->setSize(12);
                //$currentSheet->getStyle($line . '1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
                //$currentSheet->getStyle($line . '1')->getFill()->getStartColor()->setARGB('##87CEFA');
                // 设置列名
                $currentSheet->setCellValue($line . '1', $headers[$key]);
                // 设置列宽
                $currentSheet->getColumnDimension($line)->setWidth(15); //->setAutoSize(true); 自动适应对中文支持并不好
                $chr++;
                $letter[] = $line;
            }
            if (!empty($res)) {
                // 对 数据排序(按header数组来)
                foreach ($res as $re) {
                    $temp = [];
                    foreach ($headers as $key => $header) {
                        $temp[$key] = $re[$key];
                    }
                    $data[] = $temp;
                }
                //填充表格信息
                for ($i = 2; $i <= count($data) + 1; $i++) {
                    $j = 0;
                    foreach ($data[$i - 2] as $key => $value) {
                        $currentSheet->setCellValue("$letter[$j]$i", $value);
                        //$currentSheet->setCellValueExplicit("$letter[$j]$i", $value);// 防止 数字 被科学计数法
                        $j++;
                    }
                }
                if ($mark) {
                    $i++;
                    $currentSheet->getStyle('A' . $i)->getFont()->setName('微软雅黑')->setSize(12);
                    $currentSheet->setCellValueExplicit('A' . $i, '备注: ' . $mark);
                }
            }
            $filename = empty($fileName) ? md5(microtime(true)) : $fileName;
            //创建Excel输入对象
            $write = new PHPExcel_Writer_Excel5($excel);
            header("Pragma: public");
            header("Expires: 0");
            header("Cache-Control:must-revalidate, post-check=0, pre-check=0");
            header("Content-Type:application/force-download");
            header("Content-Type:application/vnd.ms-execl");
            header("Content-Type:application/octet-stream");
            header("Content-Type:application/download");
            header('Content-Disposition:attachment;filename="' . $filename . '.xls"');
            header("Content-Transfer-Encoding:binary");
            $write->save('php://output');
            die('success');
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }
}
