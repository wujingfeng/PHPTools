<?php


namespace GeneralTools;


class StringTools
{
    /**
     *  获取随机字符串，包含大写字母和数字
     * @param $length
     * @return string
     */
    public static function getRandStr($length = 6)
    {
        $hex = array('K', 'Y', 'S', '3', 'Q', 'J',
            '5', 'P', 'N', '9', 'A', 'G',
            '7', 'X', 'F', '8', '4', 'W',
            'T', '2', 'M', '1', 'I', 'C',
            'B', '6', '0', 'E', 'Z', 'L',
            'O', 'U', 'R', 'D', 'H', 'V'); //36位随机数
        $str = '';
        for ($i = 0; $i < $length; $i++) {
            $str .= $hex[mt_rand(0, 35)];
        }
        return $str;
    }

    /**
     *  获取随机字符串，包含小写字母和数字
     * @param $length
     * @return string
     */
    public static function getRandLowerStr($length = 6)
    {
        $hex = array('k', 'y', 's', '3', 'q', 'j',
            '5', 'p', 'n', '9', 'g', 'a',
            '7', 'x', 'w', '8', '4', 'f',
            't', '2', 'm', '1', 'i', 'c',
            'b', '6', '0', 'e', 'z', 'l',
            'o', 'u', 'r', 'd', 'h', 'v'); //36位随机数
        $str = '';
        for ($i = 0; $i < $length; $i++) {
            $str .= $hex[mt_rand(0, 35)];
        }
        return $str;
    }

    /**
     *  生成唯一guid编码:8CFE6723-132A-4A56-8150-671F527F936F
     * @return string
     */
    public static function GUID()
    {
        if (function_exists('com_create_guid') === true) {
            return trim(com_create_guid(), '{}');
        }
        return sprintf('%04X%04X-%04X-%04X-%04X-%04X%04X%04X', mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(16384, 20479), mt_rand(32768, 49151), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535));
    }


    /**
     * 根据PHP各种类型变量生成唯一标识号
     * @param mixed $mix 变量
     * @return string
     */
    public static function to_guid_string($mix)
    {
        if (is_object($mix)) {
            return spl_object_hash($mix);
        } elseif (is_resource($mix)) {
            $mix = get_resource_type($mix) . strval($mix);
        } else {
            $mix = serialize($mix);
        }
        return md5($mix);
    }
}
