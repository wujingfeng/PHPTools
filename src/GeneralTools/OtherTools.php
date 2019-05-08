<?php


namespace GeneralTools;

use GeneralTools\RequestTools;

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

    /**
     * 获取两个坐标点的骑行距离
     * @param $point1
     * @param $point2
     * @param $key
     * @return float
     */
    public static function getCyclingDistance($point1="22,154", $point2="22,88",$key='aa2e60a76c1f3b574114762da8b7645b')
    {
        $distance = 0.00;
        if (empty($point1) || empty($point2)) {
            return $distance;
        }
        if (!strpos($point1, ',') || !strpos($point2, ',')) {
            return $distance;
        }
        $params = [
            'key' => $key,
            'origin' => $point1,
            'destination' => $point2,
        ];
        $params = http_build_query($params);
        $url = "http://restapi.amap.com/v4/direction/bicycling?".$params;
        print_r($url);
        $data = RequestTools::http_get($url,10);
        print_r($data);
        if (isset($data) && $data['errcode'] == 0) {
            if (isset($data['data']['paths'][0]['distance']) && $data['data']['paths'][0]['distance'] > 0) {
                $distance = $data['data']['paths'][0]['distance'] <= 100
                    ? 0.01 :
                    round($data['data']['paths'][0]['distance'] / 1000, 2);
            }
        }
        if ($distance <= 0) {
            $distance = self::getLineDistance($point1, $point2);
        }
        return $distance;
    }
}
