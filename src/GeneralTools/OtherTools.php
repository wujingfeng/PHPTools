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
        $url = "http://ip.taobao.com/service/getIpInfo.php?ip=" . $ip;

        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); // 跳过证书检查
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false); // 检查SSL加密算法是否存在
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_TIMEOUT, 10);
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 5);
        $result = curl_exec($curl);
        curl_close($curl);

        $result = json_decode($result, true);
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
    public static function getCyclingDistance($point1 = "22,154", $point2 = "22,88", $key = 'aa2e60a76c1f3b574114762da8b7645b')
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
        $url = "http://restapi.amap.com/v4/direction/bicycling?" . $params;
        $data = RequestTools::http_get($url);
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

    /**
     * 获取两个坐标点的驾车距离
     * @param $point1
     * @param $point2
     * @param $key
     * @return float
     */
    public static function getDrivingDistance($point1, $point2, $key)
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
            'strategy' => 2,       // 距离优先，不考虑路况，仅走距离最短的路线，但是可能存在穿越小路/小区的情况
            'extensions' => 'base',// base:返回基本信息；all：返回全部信息
        ];
        $params = http_build_query($params);
        $url = "http://restapi.amap.com/v4/direction/bicycling?" . $params;
        $data = RequestTools::http_get($url);
        if ($data && 1 == $data['status']) {
            if (isset($data['route']['paths'][0]['distance']) && $data['route']['paths'][0]['distance'] > 0) {
                $distance = $data['route']['paths'][0]['distance'] <= 100
                    ? 0.01 :
                    round($data['route']['paths'][0]['distance'] / 1000, 2);
            }
        }
        if ($distance <= 0) {
            $distance = self::getLineDistance($point1, $point2);
        }
        return $distance;
    }

    /**
     * 获取两点之前的步行距离
     * @param $point1
     * @param $point2
     * @param $key
     * @return float
     */
    public static function getWalkingDistance($point1, $point2, $key)
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
        $url = "http://restapi.amap.com/v4/direction/bicycling?" . $params;
        $data = RequestTools::http_get($url, 10);
        if ($data && 1 == $data['status']) {
            if (isset($data['route']['paths'][0]['distance']) && $data['route']['paths'][0]['distance'] > 0) {
                $distance = $data['route']['paths'][0]['distance'] <= 100
                    ? 0.01 :
                    round($data['route']['paths'][0]['distance'] / 1000, 2);
            }
        }
        if ($distance <= 0) {
            $distance = self::getLineDistance($point1, $point2);
        }
        return $distance;
    }

    public static function getDistanceByType($point1, $point2, $key,$type){
        switch ($type){
            case 1:self::getWalkingDistance($point1, $point2, $key);
            case 2:self::getCyclingDistance($point1, $point2, $key);
            case 3:self::getDrivingDistance($point1, $point2, $key);
            case 4:self::getDistanceByType($point1, $point2, $key);
        }
    }
}
