<?php

/**
 * User data model
 *
 */
class Sys_user_cookie_model extends CI_Model
{
    private $expire_time = '+14 days';
    private $cookie_token_name = 'ClouderToken';

    public function __construct()
    {
        parent::__construct();

        $this->load->helper('security');
        $this->load->library('system_library');
    }

    /**
     * get user remember me token
     *
     * @author hiyao
     *
     * @param integer $id
     *
     * @return boolean
     */
    public function delete_user_remember_me_token($id)
    {
        $this->db->from('user_tokens');
        $this->db->where('id', $id);
        $this->db->delete();

        return ($this->db->affected_rows() > 0);
    }

    /**
     * create user remember token
     *
     * @author hiyao
     *
     * @param integer $user_id
     *
     * @return string
     */
    public function create_user_remember_me_token($user_id)
    {
        $token_data = $this->get_user_remember_me_token($user_id);
        if ($token_data->id) {
            return $token_data->token;
        }

        $g_token = base64_encode($this->system_library->generate_token(24));
        $expires = new DateTime($this->expire_time);

        $this->db->set('token', $g_token);
        $this->db->set('user_id', $user_id);
        $this->db->set('expires', $expires->format('Y-m-d H:i:s'));
        $this->db->set('user_agent', $this->agent->agent_string());
        $this->db->insert('user_tokens');

        return $g_token;
    }

    /**
     * get user remember token
     *
     * @author hiyao
     *
     * @param integer $user_id
     *
     * @return Object
     */
    public function get_user_remember_me_token($user_id)
    {
        $this->db->from('user_tokens');
        $this->db->where('user_agent', $this->agent->agent_string());
        $this->db->where('user_id', $user_id);
        $res = $this->db->get();

        if ($res->num_rows() > 0) {
            return $res->row();
        }

        return (object)array('id' => null, 'user_id' => null, 'token' => null, 'expires' => null);
    }

    /**
     *  Get Remember me expire time
     *
     * @return string
     */
    public function get_expire_time()
    {
        return $this->expire_time;
    }

    /**
     *  Get Remember me Cookie token name
     *
     * @return string
     */
    public function get_cookie_token_name()
    {
        return $this->cookie_token_name;
    }
}