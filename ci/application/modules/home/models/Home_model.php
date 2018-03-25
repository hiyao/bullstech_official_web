<?php

class Home_model extends CI_Model
{
    private $db_count_index = 'system_index_counter';
    private $db_log_detail = 'system_log_index_detail';

    public function __construct()
    {
        parent::__construct();

    }

    /**
     * get home index counter
     *
     * @author hiyao
     *
     * @return int
     */
    public function get_index_counter()
    {
        $this->db->from($this->db_count_index);

        $res = $this->db->get();

        if ($res->num_rows() === 0) {
            $this->db->set('count', 0);
            $this->db->insert($this->db_count_index);

            return 0;
        }
        return $res->row()->count;
    }

    /**
     * get home total index counter
     *
     * @author hiyao
     *
     * @return int
     */
    public function get_total_index_counter()
    {
        return $this->db->count_all($this->db_log_detail);
    }

    /**
     * get home today index counter
     *
     * @author hiyao
     *
     * @return int
     */
    public function get_today_index_counter()
    {
        $this->db->where('time >=', 'DATE_FORMAT(NOW(), "%Y-%m-%d 00:00:00")', false);
        $this->db->where('time <=', 'DATE_FORMAT(NOW(), "%Y-%m-%d 23:59:59")', false);
        $res = $this->db->count_all_results($this->db_log_detail);

        return $res;
    }
}