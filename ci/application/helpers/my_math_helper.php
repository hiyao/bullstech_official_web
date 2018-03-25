<?php declare(strict_types=1);

if (!function_exists('array_get_average')) {
    /**
     * 計算各數列中的平均數 (一維)
     *
     * @author cheyu
     *
     * @param  array $cal_array array(1,2,3)
     * @param  integer $precision 小數點第幾位
     *
     * @return integer
     */
    function array_get_average(array $cal_array = array(), $precision = 2)
    {
        return round(array_sum($cal_array) / count($cal_array), $precision);
    }
}

if (!function_exists('array_get_majority')) {
    /**
     * 計算各數列中的眾數 (一維)
     *
     * @author cheyu
     *
     * @param  array $cal_array array(1,1,2,2,4,5)
     *
     * @return int result '2'
     */
    function array_get_majority(array $cal_array = array())
    {
        $result_array = array();

        if (empty($cal_array)) {
            return null;
        }

        // 將浮點的數值, 小數點轉換成底線 ex 12.34 => 12_34
        foreach ($cal_array as $key => $value) {
            switch (gettype($value)) {
                case 'double':
                case 'float':
                    if (!is_string($value)) {
                        //保留浮點數將小數點改為底線
                        $cal_array[$key] = str_replace('.', '_', (string)$value);
                    }
            }
        }

        // 計算陣列中相同值的有幾個
        // ex: array(1,1,2,4,4,5)
        // result: array(
        //              [1] => 2,
        //              [2] => 1,
        //              [4] => 2,
        //              [5] => 1
        //          )
        $values = array_count_values($cal_array);

        // 取得出現次數最大值的值
        $max_value = max($values);

        // 取得出現次數最多的數值
        foreach ($values as $key => $value) {
            if ($value === $max_value) {
                $result_array[] = $key;
            }
        }

        // 檢查是否有眾數
        if (count($values) === count($result_array)) {
            return null;
        }

        // 奇美要求有兩個眾數以上的話, 就直接取最大的
        //return implode(", ", $result_array);
        return str_replace('_', '.', max($result_array));
    }
}

if (!function_exists('array_get_median')) {
    /**
     * 計算各數列中的中位數 (一維)
     *
     * @author cheyu
     *
     * @param  array $cal_array array(1,2,3)
     *
     * @return integer
     */
    function array_get_median(array $cal_array = array())
    {
        $midValue = null;
        sort($cal_array);

        $mid_index = floor(count($cal_array) / 2);

        if (count($cal_array) % 2 === 0) {
            // array(0,1,2,3)
            // 偶數 ex:4 $mid_index = 4/2 = 2, 取 (array[1] + array[2])/2 = (1+2)/2 = 1.5
            $midValue = ($cal_array[(int)$mid_index] + $cal_array[$mid_index - 1]) / 2;
        } else {
            // array(0,1,2,3,4)
            // 奇數 ex:5 $mid_index = 5/2 無條件捨去 = 2, 取 array[2] = 2
            $midValue = $cal_array[(int)$mid_index];
        }

        return $midValue;
    }
}

if (!function_exists('array_get_average_2d')) {
    /**
     * 計算各數列中的平均數 (二維)
     *
     * @author cheyu
     *
     * @param  array $cal_array array([0] => array(1,2,3), [1] => array(4,5,6))
     * @param integer $precision 取到小數點第幾位
     *
     * @return array  array([0] => 2, [1] => 5)
     */
    function array_get_average_2d(array $cal_array = array(), $precision = 2)
    {
        $average_array = array();
        foreach ($cal_array as $key => $numbers) {
            $average_array[$key] = (count($numbers) > 0) ? array_get_average($numbers, $precision) : null;
        }

        return $average_array;
    }
}

if (!function_exists('array_get_majority_2d')) {
    /**
     * 計算各數列中的眾數 (二維)
     *
     * @author cheyu
     *
     * @param  array $cal_array array([0] => array(1,2,2,3),
     *                                [1] => array(6,4,5,6),
     *                                [2] => array(1,1,2,2,4,5),
     *                                [3] => array(1,2,3,4,5,6))
     *
     * @return array  array([0] => '2', [1] => '6', [2] => '1,2', [3] => null)
     */
    function array_get_majority_2d(array $cal_array = array())
    {
        $majority_array = array();
        foreach ($cal_array as $key => $numbers) {
            $majority_array[$key] = (count($numbers) > 0) ? array_get_majority($numbers) : null;
        }

        return $majority_array;
    }
}

if (!function_exists('array_get_median_2d')) {
    /**
     * 計算各數列中的中位數 (二維)
     *
     * @author cheyu
     *
     * @param  array $cal_array array(array(1,2,3))
     *
     * @return array  array([0] => 2)
     */
    function array_get_median_2d(array $cal_array = array())
    {
        $median_array = array();
        foreach ($cal_array as $key => $numbers) {
            $median_array[$key] = (count($numbers) > 0) ? array_get_median($numbers) : null;
        }

        return $median_array;
    }
}

if (!function_exists('count_value')) {
    /**
     * 計算各數列中各個數字的次數
     *
     * @author cheyu
     *
     * @param  array $cal_array array([0] => array(1,2,2), [1] => array(4,4,5,5))
     *
     * @return array  array([0] => array(1 => 1, 2 => 2), [1] => array(4 => 2, 5 => 2))
     */
    function count_value(array $cal_array = array())
    {
        $count_array = array();
        foreach ($cal_array as $key => $numbers) {
            $count_array[$key] = array();
            if (count($numbers) > 0) {
                $count_array[$key] = array_count_values($numbers);
            }
        }

        return $count_array;
    }
}