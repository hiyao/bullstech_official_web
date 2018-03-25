<?php

/**
 * @coversDefaultClass User_model_api
 *
 * @covers Layout::__construct
 * @covers Sys_log_model::__construct
 * @covers System_library::__construct
 * @covers Vars::__construct
 * @covers ::__construct
 *
 */
class User_model_api_test extends TestCase
{
    private $expected_user = array();
    /** @var  \CI_DB_query_builder */
    private $db;
    /** @var  \User_model_api */
    private $obj;

    public function setUp()
    {
        $this->obj = $this->newModel('api/system/user_api/User_model_api');
        $this->db = $this->CI->db;

        $this->expected_user = array(
            'user_id'           => 0,
            'account'           => 'TESTA508AR',
            'name'              => 'test user',
            'email'             => null,
            'is_auth'           => '1',
            'register_datetime' => '',
            'update_datetime'   => '',
            'special'           => '0'
        );
    }

    /**
     * @covers ::create_user
     * @covers System_library::get_password_encode_options
     * @covers Sys_log_model::set_user_event_log
     */
    public function test_create_user()
    {
        $this->_delete_if_exist_user();

        $before_create_count = $this->db->get('user')->num_rows();

        $user_id = $this->obj->create_user($this->expected_user['account'], $this->expected_user['name']);

        $this->assertGreaterThan(0, $user_id, 'no create user.');

        $after_create_count = $this->db->get('user')->num_rows();

        $this->assertGreaterThan($before_create_count, $after_create_count, 'no create user.');

        return $user_id;
    }

    /**
     * delete if exist test user account
     */
    private function _delete_if_exist_user()
    {
        $this->db->start_cache();
        $this->db->where('account', $this->expected_user['account']);
        $this->db->stop_cache();
        if ($this->db->get('user')->num_rows() > 0) {
            $this->db->delete('user');
        }
        $this->db->flush_cache();
    }

    /**
     * test get_user_info_by_id()
     * table column: user_id, account, name, email, is_auth, register_datetime, update_datetime, special
     *
     * @covers ::get_user_info_by_id
     *
     * @depends test_create_user
     *
     * @param $user_id
     *
     * @return void
     */
    public function test_get_user_info_by_id($user_id)
    {
        $this->expected_user['user_id'] = $user_id;

        $user_data = $this->obj->get_user_info_by_id($user_id);
        $this->execute_user_data_test($this->expected_user, $user_data);
    }

    /**
     * @codeCoverageIgnore
     *
     * @param $except_data
     * @param $user_data
     */
    private function execute_user_data_test($except_data, $user_data)
    {
        $this->assertCount(count($except_data), (array)$user_data);
        $this->assertEquals($except_data['user_id'], $user_data->user_id);
        $this->assertEquals($except_data['account'], $user_data->account);
        $this->assertEquals($except_data['name'], $user_data->name);
        $this->assertEquals($except_data['email'], $user_data->email);
        $this->assertEquals($except_data['is_auth'], $user_data->is_auth);
        $this->assertEquals($except_data['special'], $user_data->special);
        $this->assertRegExp('/[0-9]{4}-[0-9]{2}-[0-9]{2}\s[0-9]{2}:[0-9]{2}:[0-9]{2}/', $user_data->register_datetime);
        $this->assertRegExp('/[0-9]{4}-[0-9]{2}-[0-9]{2}\s[0-9]{2}:[0-9]{2}:[0-9]{2}/', $user_data->update_datetime);
    }

    /**
     * test get_user_info_by_account()
     * table column: user_id, account, name, email, is_auth, register_datetime, update_datetime, special
     *
     * @covers ::get_user_info_by_account
     *
     * @depends test_create_user
     *
     * @param $user_id
     */
    public function test_get_user_info_by_account($user_id)
    {
        $this->expected_user['user_id'] = $user_id;

        $user_data = $this->obj->get_user_info_by_account($this->expected_user['account']);
        $this->execute_user_data_test($this->expected_user, $user_data);
    }

    /**
     * test update_user_column_data()
     *
     * @covers ::update_user_column_data
     * @covers Sys_log_model::set_user_event_log
     */
    public function test_update_user_column_data()
    {
        $this->assertTrue($this->obj->update_user_column_data(3, 'name', '管理者test'));
        $this->assertTrue($this->obj->update_user_column_data(3, 'name', '管理者'));
        $this->assertFalse($this->obj->update_user_column_data(3, 'error', '管理者'));
        $this->assertEquals(EXIT_USER_INPUT, $this->obj->update_user_column_data(3, '', '管理者'));
        $this->assertEquals(EXIT_USER_INPUT, $this->obj->update_user_column_data('ff', '', '管理者'));
    }
}
