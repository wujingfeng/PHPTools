<?php


namespace GeneralTools;


class OtherTools
{
    /*
     * 根据ip地址获取省市地址
     */
    public static function getAreaByip($ip = '124.124.14.123')
    {
        if (empty($ip)) {
            return '未知';
        }
        if (strpos($ip, '192.168.') !== false || $ip == '127.0.0.1') {
            return '本地';
        }
        $url = "http://ip.taobao.com/service/getIpInfo.php?ip=".$ip;

        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); // 跳过证书检查
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false); // 检查SSL加密算法是否存在
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_TIMEOUT, 10);
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 5);
        $result = curl_exec($curl);
        curl_close($curl);

        $result = json_decode($result,true);
        if ($result != false) {
            if ($result['code']) {
                return '未知';
            }
            $data = $result['data'];
            if (isset($data['region']) && isset($data['city'])) {
                return $data['region'] . $data['city'];
            }
        }
        return '未知';
    }
}
