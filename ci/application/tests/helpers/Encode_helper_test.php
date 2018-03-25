<?php

class Encode_helper_test extends TestCase
{
    protected static $expected_str = '+abcd=ef12345/';

    public function setUp(){
        $this->resetInstance();
    }

    public function test_url_base64_encode()
    {
        $base64_str = url_base64_encode(self::$expected_str);
        $this->assertRegExp('/[^+=\/]/', $base64_str);

        return $base64_str;
    }

    /**
     * @depends test_url_base64_encode
     *
     * @param $base64_str
     */
    public function test_url_base64_decode($base64_str)
    {
        $decode_str = url_base64_decode($base64_str);
        $this->assertEquals(self::$expected_str, $decode_str);
    }
}
