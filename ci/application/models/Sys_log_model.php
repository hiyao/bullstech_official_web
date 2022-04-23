<?php

/**
 * Class Sys_log_model
 *
 * @version 0.1.0
 * @author  hiyao
 */
class Sys_log_model extends CI_Model
{
    /**
     * @var string
     */
    protected $ip;

    /**
     * Sys_log_model constructor.
     */
    function __construct()
    {
        parent::__construct();

        $this->ip = $this->input->ip_address();
    }

    /**
     * get local ip
     *
     * @return mixed
     */
    public function get_local_ip()
    {
        return $this->ip;
    }

    /**
     * log login user
     *
     * @param $user_id
     */
    public function set_login_log($user_id)
    {
        $data = array(
            'user_id' => $user_id,
            'time' => date('Y-m-d  G:i:s'),
            'ip' => $this->ip,
            'REMOTE_PORT' => $_SERVER['REMOTE_PORT'],
            'HTTP_USER_AGENT' => $_SERVER['HTTP_USER_AGENT']
        );
        $this->db->insert('system_log_login', $data);
    }

    /**
     * set_login_information
     *
     * @public
     * @author hiyao
     * @return bool
     */
    public function set_login_information()
    {
        $data = array(
            'time' => date('Y-m-d  G:i:s'),
            'ip' => $this->ip,
            'REMOTE_PORT' => $_SERVER['REMOTE_PORT']
        );
        $this->db->insert('system_log_index_detail', $data);

        $this->db->set('count', 'count+1', FALSE);
        return $this->db->update('system_index_counter');
    }

    /**
     * set_logout_log
     *
     * @public
     * @author hiyao
     *
     * @param $user_id
     * @param $time
     */
    public function set_logout_log($user_id, $time)
    {
        $data = array(
            'user_id' => $user_id,
            'time' => date('Y-m-d  G:i:s'),
            'residencetime' => $time,
            'ip' => $this->ip,
            'REMOTE_PORT' => $_SERVER['REMOTE_PORT'],
            'HTTP_USER_AGENT' => $_SERVER['HTTP_USER_AGENT']
        );
        $this->db->insert('system_log_logout', $data);
    }

    /**
     * 取得使用者登入紀錄
     *
     * @author shen
     *
     * @param $user_id
     * @param $limit
     * @param $offset
     *
     * @return CI_DB_result
     */
    public function get_login_log($user_id, $limit = null, $offset = 0)
    {
        $this->db->from('system_log_login');
        $this->db->where('user_id', $user_id);
        $this->db->order_by('time', 'desc');
        isset($limit) && $this->db->limit($limit, $offset);

        return $this->db->get();
    }

    /**
     * 查詢使用者 最近登入時間
     *
     * @param $user_id
     *
     * @return CI_DB_result
     */
    public function get_last_login_log($user_id)
    {
        $this->db->select('time');
        $this->db->from('system_log_login');
        $this->db->where('user_id', $user_id);
        $this->db->order_by('time', 'DESC');

        return $this->db->get();
    }

    /**
     * 記錄user瀏覽的路徑
     *
     * @param int|null $mod_id
     * @param string|null $mod_name
     * @param int $state
     */
    public function set_path_log(?int $mod_id = null, ?string $mod_name = null, int $state = 0)
    {
        $data = array(
            'account' => $this->session->userdata('user_account'),
            'mod_id' => $mod_id ?? null,
            'mod_name' => $mod_name ?? null,
            'permission_state' => $state,
            'path' => $this->uri->uri_string(),
            'ip' => $this->ip,
            'port' => $_SERVER['REMOTE_PORT'],
        );
        $this->db->insert('system_log_path', $data);
    }

    /**
     * user event log
     * TODO: Use it when INSERT, UPDATE OR DELETE data in database.
     * 20160226 hiyao fix can't insert when not login, user_account and user_id is null
     *
     * @param int $event_id Constants like EVENT_INSERT. see constants.php
     * @param string $module_path ex: api/{module_name}/{controller_name}/{method_name},
     *                                api/{controller_name}/{method_name} when controller name is same with module name
     * @param string $sql
     */
    public function set_user_event_log($event_id, $module_path, $sql)
    {
        $is_login = $this->session->userdata('is_login');

        $user_id = (isset($is_login) ? $this->session->userdata('user_id') : 0);
        $user_account = (isset($is_login) ? $this->session->userdata('user_account') : 'nobody');

        $data = array(
            'user_account' => $user_account,
            'user_id' => $user_id,
            'path' => $module_path,
            'uri' => $this->uri->uri_string(),
            'event_type' => $event_id,
            'sql' => $sql
        );
        $this->db->insert('system_log_user_event', $data);
    }

    /**
     * Set error message log
     *
     * @author hiyao
     *
     * @param string $path
     * @param string $error_message
     * @param array $value_message
     */
    public function set_error_log($path, $error_message, $value_message = array())
    {
        $user_id = (($this->session->userdata('is_login') !== null) ? $this->session->userdata('user_id') : 0);

        $data = array(
            'user_id' => $user_id,
            'path' => $path,
            'error_message' => $error_message,
            'value_message' => (is_array($value_message)) ? json_encode($value_message) : ''
        );
        $this->db->insert('system_log_error', $data);
    }
}
