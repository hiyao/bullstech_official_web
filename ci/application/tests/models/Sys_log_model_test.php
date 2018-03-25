<?php

/**
 * @coversDefaultClass Sys_log_model
 *
 * @covers ::__construct
 * @covers             Layout::__construct
 * @covers             System_library::__construct
 * @covers             Vars::__construct
 */
class Sys_log_model_test extends TestCase
{
    public function setUp()
    {
        $this->obj = $this->newModel('Sys_log_model');
        $this->db = $this->CI->db;
        $this->session = $this->CI->session;
        $this->uri = $this->CI->uri;
    }

    /**
     * @covers ::__construct
     * @covers ::get_local_ip
     */
    public function test_construct()
    {
        $this->obj->__construct();

        $this->assertRegExp('/^[0-9]{0,3}\.[0-9]{0,3}\.[0-9]{0,3}\.[0-9]{0,3}$/', $this->obj->get_local_ip());
        $this->assertRegExp('/^((?!192).)*\.((?!168).)\.[0-9]{0,3}\.[0-9]{0,3}$/', $this->obj->get_local_ip());
    }
    //
    //    public function test_event_constants(){
    //
    //    }
    //
    //    public function test_table_is_exists(){
    //
    //    }
    //
    /**
     * @covers ::set_user_event_log
     */
    public function test_set_user_event_log()
    {
        $expected_mod_name = 'test_set_user_event_log';
        $expected_sql = 'phpunit test 1234567890->()';
        $expected_uri = $this->uri->uri_string = 'phpunit uri testing';

        $expected_user_ids = array(
            'no_login' => 0,
            'is_login' => 3
        );
        $expected_user_accounts = array(
            'no_login' => 'nobody',
            'is_login' => 'superadmin'
        );

        foreach ($expected_user_ids as $key => $value) {
            $this->_check_user_event_log_data($expected_mod_name, $expected_sql, $expected_uri, $expected_user_ids[$key], $expected_user_accounts[$key]);
        }
    }

    /**
     * test_set_user_event_log
     *
     * @param $expected_mod_name
     * @param $expected_sql
     * @param $expected_uri
     * @param $expected_user_id
     * @param $expected_user_account
     */
    private function _check_user_event_log_data($expected_mod_name, $expected_sql, $expected_uri, $expected_user_id, $expected_user_account)
    {
        $test_table = 'system_log_user_event';

        // login setting
        if ($expected_user_id > 0) {
            $this->session->set_userdata('is_login', true);
            $this->session->set_userdata('user_account', $expected_user_account);
            $this->session->set_userdata('user_id', (int)$expected_user_id);
        }

        // insert test
        $before_create_count = $this->db->get_where($test_table, array('path' => $expected_mod_name))->num_rows();
        $this->obj->set_user_event_log(EVENT_INSERT, $expected_mod_name, $expected_sql);
        $this->db->order_by('id', 'DESC');
        $ret = $this->db->get_where($test_table, array('path' => $expected_mod_name));

        $after_create_count = $ret->num_rows();
        $this->assertGreaterThan($before_create_count, $after_create_count, 'Table ' . $test_table . ' is not insert data.');

        // get test
        $check_data = $ret->row();
        $this->assertTrue(isset($check_data), 'Table ' . $test_table . ' is not get any data.');

        // data test
        $this->assertEquals($expected_user_id, $check_data->user_id);
        $this->assertEquals($expected_user_account, $check_data->user_account);
        $this->assertEquals(EVENT_INSERT, $check_data->event_type);
        $this->assertEquals($expected_sql, $check_data->sql);
        $this->assertEquals($expected_uri, $check_data->uri);
    }
}
