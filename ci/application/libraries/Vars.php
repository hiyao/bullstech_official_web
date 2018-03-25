<?php

/**
 * 用於設定系統參數
 *
 * 使用者變數取得與設定 用於擴充模組時使用者資料的擴充 例如隱私權設定的擴充 EX:
 * $this->vars->uset('private_pro_score',TRUE);
 * $this->vars->uget('private_pro_score');
 *
 */
class Vars
{
    private $conf = array();
    private $CI;
    private $context = FALSE;
    private $db_table = 'system_variable';

    /**
     * Vars constructor.
     *
     */
    function __construct()
    {
        $this->CI =& get_instance();
        $this->CI->load->database();
        $vars = $this->CI->db->get($this->db_table)->result();
        foreach ($vars as $value) {
            $this->conf[$value->name] = unserialize($value->value);
        }
    }

    /**
     * @param      $name
     * @param null $default
     * @param null $account
     *
     * @return mixed|null
     */
//    function uget( $name, $default = NULL, $account = NULL ) {
//        $accountID = $this->CI->sys_model->getUserInfo( $account )->row()->a_id;
//        $this->CI->db->from( 'config_variable_usr' );
//        $this->CI->db->where( 'a_id', $accountID );
//        $this->CI->db->where( 'name', $name );
//        $var = $this->CI->db->get()->row();
//        if ( $var ) {
//            return unserialize( $var->value );
//        } else {
//            return $default;
//        }
//    }

    /**
     * @param      $name
     * @param      $value
     * @param null $account
     */
//    function uset( $name, $value, $account = NULL ) {
//        $accountID = $this->CI->sys_model->getUserInfo( $account )->row()->a_id;
//        $var       = $this->uget( $name );
//        $this->CI->db->set( 'value', serialize( $value ) );
//        if ( $var === NULL ) {
//            $this->CI->db->set( 'a_id', $accountID );
//            $this->CI->db->set( 'name', $name );
//            $this->CI->db->insert( 'config_variable_usr' );
//        } else {
//            $this->CI->db->where( 'a_id', $accountID );
//            $this->CI->db->where( 'name', $name );
//            $this->CI->db->update( 'config_variable_usr' );
//        }
//    }

    /**
     * @param      $name
     * @param null $default
     * @param null $account
     *
     * @return mixed|null
     */
//    function upget( $name, $default = NULL, $account = NULL ) {
//        $accountID = $this->CI->sys_model->getUserInfo( $account )->row()->a_id;
//        $this->CI->db->from( 'config_user_private' );
//        $this->CI->db->where( 'a_id', $accountID );
//        $this->CI->db->where( 'name', $name );
//        $var = $this->CI->db->get()->row();
//        if ( $var ) {
//            return unserialize( $var->value );
//        } else {
//            return $default;
//        }
//    }

    /**
     * @param      $name
     * @param      $value
     * @param null $account
     */
//    function upset( $name, $value, $account = NULL ) {
//        $accountID = $this->CI->sys_model->getUserInfo( $account )->row()->a_id;
//        $var       = $this->upget( $name, NULL, $account );
//        $this->CI->db->set( 'value', serialize( $value ) );
//        if ( $var === NULL ) {
//            $this->CI->db->set( 'a_id', $accountID );
//            $this->CI->db->set( 'name', $name );
//            $this->CI->db->insert( 'config_user_private' );
//        } else {
//            $this->CI->db->where( 'a_id', $accountID );
//            $this->CI->db->where( 'name', $name );
//            $this->CI->db->update( 'config_user_private' );
//        }
//    }

    /**
     * 切換內容區
     *
     * @param bool $context
     */
    function setContext($context = FALSE)
    {
        $this->context = $context;
    }

    /**
     * @param      $name
     * @param      $value
     * @param null $default
     */
    function set($name, $value, $default = NULL)
    {
        if ($default !== NULL && empty($value)) {
            $value = $default;
        }
        if ($this->context) {
            $this->context[$name] = $value;
        } else {
            $serialize = serialize($value);
            if ($this->get($name) !== NULL) {
                $this->CI->db->set('value', $serialize);
                $this->CI->db->where('name', $name);
                $this->CI->db->update($this->db_table);
            } else {
                $this->CI->db->set('name', $name);
                $this->CI->db->set('value', $serialize);
                $this->CI->db->insert($this->db_table);
            }
            $this->conf[$name] = $value;
        }
    }

    /**
     * @param      $name
     * @param null $default
     *
     * @return null
     */
    function get($name, $default = NULL)
    {
        if ($this->context && isset($this->context[$name])) {
            return $this->context[$name];
        } else if ( !$this->context && isset($this->conf[$name])) {
            return $this->conf[$name];
        }

        if ($default !== NULL) {
            return $default;
        } else {
            return NULL;
        }
    }

}