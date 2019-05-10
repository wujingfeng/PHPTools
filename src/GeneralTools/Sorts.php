<?php

/**
 * 排序算法详解及实现
 * @plink:https://mp.weixin.qq.com/s/vn3KiV-ez79FmbZ36SX9lg
 */

namespace GeneralTools;


class Sorts
{
    /**
     * 冒泡排序
     * @param $data array 待排序数组
     * @param $sort string 排序方式 ASC|DESC
     * @return array 排序后的数组
     *
     * 算法步骤:
     *  ① 比较相邻的元素。如果第一个比第二个大，就交换他们两个。
     *  ② 对每一对相邻元素作同样的工作，从开始第一对到结尾的最后一对。这步做完后，最后的元素会是最大的数。
     *  ③ 针对所有的元素重复以上的步骤，除了最后一个。
     *  ④ 持续每次对越来越少的元素重复上面的步骤，直到没有任何一对数字需要比较。
     * 时间复杂度:O(n^2)
     * 空间复杂度:O(1)
     */
    public static function BubbleSort($data, $sort = 'ASC')
    {
        if (!is_array($data)) {
            return $data;
        }
        $sort = strtoupper($sort);
        if ($sort == 'ASC') {
            $e = 'return $data[$i] > $data[$j];';
        } else {
            $e = 'return $data[$i] < $data[$j];';
        }
        // 从数组开头循环到倒数第二位
        for ($i = 0; $i < count($data) - 1; $i++) {
            // 从数组第二位循环到数组结尾
            for ($j = $i + 1; $j < count($data); $j++) {
                // 比较两个相邻值的大小
                if (eval($e)) {
                    // 交换相邻位置的数据
                    $temp = $data[$i];
                    $data[$i] = $data[$j];
                    $data[$j] = $temp;
                }
            }
        }
        return $data;
    }


    /**
     * 选择排序
     * @param $data
     * @param string $sort
     * @return array
     *
     * 算法步骤
     *  ① 首先在未排序序列中找到最小（大）元素，存放到排序序列的起始位置
     *  ② 再从剩余未排序元素中继续寻找最小（大）元素，然后放到已排序序列的末尾。
     *  ③ 重复第二步，直到所有元素均排序完毕
     * 时间复杂度:O(n^2)
     * 空间复杂度:O(1)
     */
    public static function selectSort($data, $sort = "ASC")
    {
        if (!is_array($data)) {
            return $data;
        }
        $sort = strtoupper($sort);
        if ($sort == 'ASC') {
            $e = 'return $data[$minSub] > $data[$j];';
        } else {
            $e = 'return $data[$minSub] < $data[$j];';
        }

        for ($i = 0; $i < count($data) - 1; $i++) {
            # 最小值的下标
            $minSub = $i;
            // 每次循环 都在未排序的数据中找到最小(大)值,存放到本次循环的起始位置
            for ($j = $i + 1; $j < count($data); $j++) {
                // 寻找最值
                if (eval($e)) {
                    // 如果找到了,就交换起始最小值与真实最小值下标
                    $minSub = $j;
                }
            }
            //根据下标交换数据
            if ($i != $minSub) {
                $temp = $data[$i];
                $data[$i] = $data[$minSub];
                $data[$minSub] = $temp;
            }

        }
        return $data;
    }

    /**
     * 插入排序
     * @param $data
     * @param string $sort
     * @return array
     * 算法步骤
     *  ① 将第一待排序序列第一个元素看做一个有序序列，把第二个元素到最后一个元素当成是未排序序列。
     *  ②从头到尾依次扫描未排序序列，将扫描到的每个元素插入有序序列的适当位置。（如果待插入的元素与有序序列中的某个元素相等，则将待插入元素插入到相等元素的后面。）
     * 时间复杂度:O(n^2)
     * 空间复杂度:O(1)
     */
    public static function insertSort($data, $sort = "ASC")
    {
        if (!is_array($data)) {
            return $data;
        }
        $sort = strtoupper($sort);
        if ($sort == 'ASC') {
            $e = 'return $temp < $data[$j-1];';
        } else {
            $e = 'return $temp > $data[$j-1];';
        }

        // 因为下标为0的数据只有一个元素,所以默认是有序序列,所以从1开始比较
        for ($i = 1; $i < count($data); $i++) {
            # 记录本次要插入的数据
            $temp = $data[$i];
            $j = $i;
            # 依次将本次待排元素与前面的有序元素进行比较,如果待排元素较小(大),则将有序序列**逐个后移**
            while ($j > 0 && eval($e)) {
                $data[$j] = $data[$j - 1];// 将元素逐个后移,直到待排元素比有序序列中的某个元素大(小)
                $j--;
            }
            // 上面的循环结束之后,可以确定待排元素在有序序列中的具体位置
            if ($j != $i) {
                $data[$j] = $temp;
            }
        }
        return $data;
    }


}
