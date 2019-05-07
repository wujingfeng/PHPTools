<?php


namespace General;


class RequestTools
{
    /**
     *  判断是否来自微信
     * @return string
     */
    public static function isFromWeixin()
    {
        return isset($_SERVER['HTTP_USER_AGENT']) && strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false ? true : false;
    }

    /**
     *  判断是否来自Iphone
     * @return string
     */
    public static function isIphone()
    {
        if (!isset($_SERVER['HTTP_USER_AGENT'])) {
            return false;
        }
        $agent = strtolower($_SERVER['HTTP_USER_AGENT']);
        if (strpos($agent, "iphone") || strpos($agent, "ipad")) {
            return true;
        }
        return false;
    }

    /**
     * 判断是否来自支付宝
     * @return string
     */
    public static function isAlipay()
    {
        return isset($_SERVER['HTTP_USER_AGENT']) && strpos($_SERVER['HTTP_USER_AGENT'], 'AlipayClient') !== false ? true : false;
    }

    /**
     *  发送post请求
     * @param $uri
     * @param $data
     * @param $timeout
     * @return mixed
     */
    public static function http_post($uri, $data, $timeout = 10)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
        curl_setopt($ch, CURLOPT_URL, $uri);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        $return = curl_exec($ch);
        curl_close($ch);
        return $return;
    }


    public static function http_get($url, $timeout = 10, $header = false)
    {
        $ch = curl_init($url);
        if ($header) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        }
        curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $resposne = curl_exec($ch);
        if (false === $resposne) {
            return false;
        } else {
            return $resposne;
        }
    }

    //设置请求头的请求
    public static function headerPost($url, $header, $data, $timeout = 10)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
        curl_setopt($ch, CURLOPT_HEADER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_ENCODING, '');
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        $resposne = curl_exec($ch);
        curl_close($ch);
        if (preg_match('/"errno":(.*?),/', $resposne, $status)) {
            if ($status[1] != 0) {
                //登陆失败
                return false;
            }
        }
        if (preg_match('/"ret":"([\d]*?)"/', $resposne, $state)) {
            if ($state[1] != 0) {
                //登陆失败
                return false;
            }
        }
        $preg_cookie = '/Set-Cookie: (.*?);/m';
        if (preg_match_all($preg_cookie, $resposne, $cookies)) {
            $cookies = implode(';', $cookies['1']);
        }
        return $cookies;
    }

    //ajax请求获取curl数据
    public static function headerPostGoods($url, $header, $cookie, $data, $timeout = 10)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_ENCODING, '');
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_COOKIE, $cookie);//$cookie格式 x=1;y=2
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        $resposne = curl_exec($ch);
        curl_close($ch);
        if ($resposne === false) {
            return false;
        }
        //处理json字符串
        $resposne = trim($resposne, chr(239) . chr(187) . chr(191));
        return json_decode($resposne, true);
    }

    //post请求携带cookie获取页面
    public static function getPageByPost($url, $cookie, $data = [], $timeout = 10)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_ENCODING, '');
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_COOKIE, $cookie);//$cookie格式 x=1;y=2
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        $resposne = curl_exec($ch);
        curl_close($ch);
        return $resposne;
    }
}
