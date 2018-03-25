<?php

class My_math_helper_test extends TestCase
{
    public function setUp()
    {
        $this->resetInstance();
        $this->CI->load->helper('my_math');
    }

    public function test_array_get_average()
    {
        $test_array = [1.23, 6.78];
        $excepted_result = 4;
        $excepted_result_pre2 = 4.01;

        $this->assertEquals($excepted_result, array_get_average($test_array, 0));
        $this->assertEquals($excepted_result_pre2, array_get_average($test_array));
    }

    public function test_array_get_average_2d()
    {
        $test_array = [[1.23, 6.78], [5.11, 9.12, 3.22]];
        $excepted_result = [4, 6];
        $excepted_result_pre2 = [4.01, 5.82];

        $this->assertEquals($excepted_result, array_get_average_2d($test_array, 0));
        $this->assertEquals($excepted_result_pre2, array_get_average_2d($test_array));
    }


    /**
     * @dataProvider majority_provider
     *
     * @param $inputArray
     * @param $excepted_str
     */
    public function test_array_get_majority($inputArray, $excepted_str)
    {
        $this->assertEquals($excepted_str, array_get_majority($inputArray));
    }

    public function majority_provider()
    {
        return [
            [[1, 1, 2, 2, 4, 5], 2],
            [[1, 1, 1, 2, 4, 5], 1],
            [[1, 1, 1, 2, 2, 2, 3, 3, 3], null],
            // 奇美要求有兩個眾數以上的話, 就直接取最大的
            [[1.1, 1.2, 1.1, 1.3, 1.4, 1.5], 1.1],
            [[], null]
        ];
    }

    public function test_array_get_majority_2d()
    {
        $testArray = [
            [1, 1, 2, 2, 4, 5],
            [1, 1, 1, 2, 4, 5],
            [1, 1, 1, 2, 2, 2, 3, 3, 3],
            [1.1, 1.2, 1.1, 1.3, 1.4, 1.5],
            []
        ];

        $excepted_array = [2, 1, null, 1.1, null];

        $this->assertEquals($excepted_array, array_get_majority_2d($testArray));
    }

    public function test_array_get_median_2d()
    {
        $testArray = [
            [0, 1, 2, 3],
            [0, 1, 2, 3, 4],
            []
        ];

        $excepted_array = [1.5, 2, null];

        $this->assertEquals($excepted_array, array_get_median_2d($testArray));
    }


    /**
     * @dataProvider median_provider
     *
     * @param $inputArray
     * @param $excepted_str
     */
    public function test_array_get_median($inputArray, $excepted_str)
    {
        $this->assertEquals($excepted_str, array_get_median($inputArray));
    }

    public function median_provider()
    {
        return [
            [[0, 1, 2, 3], 1.5],
            [[0, 1, 2, 3, 4], 2]
        ];
    }

    public function test_count_value()
    {
        $inputArray = [
            [0, 1, 2, 3],
            [1, 1, 2, 2],
            [3, 3, 3, 3]
        ];

        $excepted_array = [
            [
                0 => 1,
                1 => 1,
                2 => 1,
                3 => 1
            ],
            [
                1 => 2,
                2 => 2
            ],
            [
                3 => 4
            ]
        ];
        $this->assertEquals($excepted_array, count_value($inputArray));
    }
}
