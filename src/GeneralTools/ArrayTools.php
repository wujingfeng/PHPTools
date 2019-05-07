<?php


namespace GeneralTools;


class ArrayTools
{
    /**
     * todo 暂时只能返回parent_id从0开始的数据
     * 将二维数组转换为树形结构(每一个子节点都带有child)
     * @param $rows                 array       待处理的数据集(二维数组)
     * @param string $id            string      节点id
     * @param string $pid           string      父节点id
     * @param boolean $hasChild     boolean     是否需要让每一个子节点都有child
     * @return array                array       返回处理后的树状结构
     */
    public static function arrayToTree($rows, $id='id', $pid='parent_id',$hasChild = true){
        echo 1;
        $array = array();
        foreach ($rows as $row) {
            $array[$row[$id]] = $row;
            $hasChild?$array[$row[$id]]['child'] = []:'';
        }
        foreach ($array as $item)  $array[$item[$pid]]['child'][$item[$id]] = &$array[$item[$id]];
        return isset($array[0]['child']) ? $array[0]['child'] : array();
    }
}
