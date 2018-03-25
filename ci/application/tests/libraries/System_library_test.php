<?php

/**
 * @coversDefaultClass System_library
 *
 * @covers System_library::__construct
 *
 */
class System_library_test extends TestCase
{
    public function setUp()
    {
        $this->resetInstance();
        $this->obj = $this->newLibrary('system_library');
    }

    /**
     * @covers       Layout::__construct
     * @covers       Vars::__construct
     * @covers       System_library::result_array_push
     *
     * @dataProvider array_data_provider
     *
     * @param array $inputA
     * @param array $inputB
     * @param array $result
     */
    public function test_result_array_push(array $inputA, array $inputB, array $result)
    {
        $this->obj->result_array_push($inputA, $inputB);

        $this->assertEquals($result, $inputA);
    }

    /**
     * Provide array data to check
     */
    public function array_data_provider()
    {
        return [
            [[0, 1, 2], [3, 4, 5], [0, 1, 2, 3, 4, 5]],
            [[], [3, 4, 5], [3, 4, 5]],
            [[0, 1, 2], [], [0, 1, 2]],
            [[], [], []]
        ];
    }

    /**
     * @covers       Layout::__construct
     * @covers       Vars::__construct
     * @covers       System_library::get_chinese_number
     *
     * @dataProvider number_provider
     *
     * @param int $input
     * @param string $result
     */
    public function test_get_chinese_number(int $input, string $result)
    {
        $str = $this->obj->get_chinese_number($input);
        $unicode = mb_convert_encoding($str, 'UTF-8', 'HTML-ENTITIES');

        $this->assertEquals($result, $unicode);
    }

    /**
     * Provide number data to check
     */
    public function number_provider()
    {
        return [
            [2345, '二千三百四十五'],
            [678, '六百七十八'],
            [91, '九十一'],
            [0, '零']
        ];
    }

    /**
     * @covers System_library::execute_api_method
     * @covers Layout::__construct
     * @covers Vars::__construct
     */
    public function test_execute_api_method()
    {
        $call_method_result = $this->obj->execute_api_method('', '', []);
        $this->assertNull($call_method_result);
    }

    /**
     * @covers       System_library::datetime_format
     * @covers       Layout::__construct
     * @covers       Vars::__construct
     *
     * @dataProvider date_provider
     *
     * @param $input_date
     * @param $input_format
     * @param $result_date
     */
    public function test_datetime_format($input_date, $input_format, $result_date)
    {
        $test_date = $this->obj->datetime_format($input_date, $input_format);

        $this->assertEquals($result_date, $test_date);
    }

    public function date_provider()
    {
        return [
            ['0000-00-00 00:00:00', null, '-'],
            ['2018-02-01 12:55:44', null, '2018-02-01 12:55'],
            ['2018-02-01 12:55:44', 'Y-m-d', '2018-02-01'],
        ];
    }

    /**
     * @covers       System_library::get_big_one_from_two_values
     * @covers       Layout::__construct
     * @covers       Vars::__construct
     *
     * @dataProvider value_provider
     *
     * @param $inputA
     * @param $inputB
     * @param $result
     */
    public function test_get_big_one_from_two_values($inputA, $inputB, $result)
    {
        $test_result = $this->obj->get_big_one_from_two_values($inputA, $inputB);

        $this->assertEquals($result, $test_result);
    }

    public function value_provider()
    {
        return [
            [3, 1, 3],
            [2, 5, 5],
            [4, 4, 4]
        ];
    }

    /**
     * @covers       System_library::get_file_location
     * @covers       Layout::__construct
     * @covers       Vars::__construct
     */
    public function test_get_file_location()
    {
        $url = $this->CI->config->item('file_url_location');
        $linux_path = $this->CI->config->item('file_linux_location');

        $this->assertEquals($this->obj->get_file_location(), $url);
        $this->assertEquals($this->obj->get_file_location(false), $linux_path);
    }

    /**
     * @covers       System_library::get_system_application_type
     * @covers       Layout::__construct
     * @covers       Vars::__construct
     */
    public function test_get_system_application_type()
    {
        $expected = [
            1 => 'pgy',
            2 => 'ugy',
            3 => 'nurse',
            4 => 'health'
        ];
        $list = $this->obj->get_system_application_type();
        $this->assertLessThan($list->num_rows(), 0);
        foreach ($list->result() as $category) {
            $this->assertEquals($expected[$category->id], $category->name);
        }
    }
}
