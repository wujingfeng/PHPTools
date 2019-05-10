<?php


namespace Others;


class Sorts
{
    public function bubbleSort($arr)
    {
        for ($i = 0; $i < count($arr) - 1; $i++) {
            for ($j = $i + 1; $j < count($arr); $j++) {
                if ($arr[$i] > $arr[$j]) {
                    $temp = $arr[$i];
                    $arr[$i] = $arr[$j];
                    $arr[$j] = $temp;
                }
            }
        }
    }

    public function insertSort($arr)
    {
        for ($i = 1; $i < count($arr); $i++) {
            $temp = $arr[$i];

            $j = $i;
            while ($j > 0 && $temp < $arr[$j - 1]) {
                $arr[$j] = $arr[$j - 1];
                $j--;
            }
            if ($j != $i) {
                $arr[$j] = $temp;
            }
        }
    }

    public function selectSort($arr)
    {
        for ($i = 0; $i < count($arr) - 1; $i++) {
            $minsub = $i;
            for ($j = $i + 1; $j < count($arr); $j++) {
                if ($arr[$minsub] > $arr[$j]) {
                    $minsub = $j;
                }
            }
            if($minsub!=$i){
                $temp = $arr[$minsub];
                $arr[$minsub] = $arr[$i];
                $arr[$i] = $temp;
            }
        }

    }

}
