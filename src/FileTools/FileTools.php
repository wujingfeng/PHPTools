<?php


namespace FileTools;


use OSS\Core\OssException;
use OSS\OssClient;

class FileTools
{
    /*
     * 让图片以文件的形式自动下载,而不是显示到浏览器上
     * @param $filePath     图片地址
     * @param string $exportName        下载的名字(包括后缀 例:a.png)
     */
    public static function autoDownloadPic($filePath, $exportName = '')
    {
        if (empty($filePath)) {
            die('file not find');
        }
        if (!$exportName) {
            $exportName = basename($filePath);
        }
        header('Pragma: public'); // required
        header('Expires: 0'); // no cache
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Cache-Control: private', false);
        header('Content-Type: application/force-download');
        header('Content-Disposition: attachment; filename="' . $exportName . '"');
        header('Content-Transfer-Encoding: binary');
        header('Connection: close');
        readfile($filePath); // push it out
        exit();
    }

    public static function updateFileToAliyunOss($AccessId, $AccessKey, $EndPoint, $bucket, $objectName, $filePath)
    {
        try {
            $ossClient = new OssClient($AccessId, $AccessKey, $EndPoint);
            $ossClient->uploadFile($bucket, $objectName, $filePath);
        } catch (OssException $e) {
            return false;
        }
        return true;
    }


}
