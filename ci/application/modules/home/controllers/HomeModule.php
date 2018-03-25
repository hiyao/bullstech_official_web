<?php

class HomeModule extends MX_Controller
{
    protected $backend_name = 'home';
    protected $tplVar = array();
    protected $app_type;
    private $module_name;
    private $controller_name;

    public function __construct()
    {
        parent::__construct();
        $this->load->model('home_model', 'home_model');
        $this->load->model('sys_log_model', 'logModel');
        $this->controller_name = strtolower(get_class($this));
        $this->module_name = $this->uri->segment(2);
        $this->_initdata();
    }

    /**
     * 初始化資料
     */
    public function _initdata()
    {
        $this->layout->set_layout('template.php');

        $this->tplVar['headtitle'] = '';
        $this->tplVar['indexCount'] = $this->home_model->get_index_counter();
        $this->tplVar['total_counter'] = $this->home_model->get_total_index_counter();
        $this->tplVar['today_counter'] = $this->home_model->get_today_index_counter();
    }

    public function home_url()
    {
        return base_url() . "home/{$this->module_name}/" . (($this->controller_name !== $this->module_name)? "{$this->controller_name}/" : '');
    }

    /**
     * @param string $prefix
     * @param string $message
     */
    protected function set_message($prefix = 'global', $message)
    {
        $this->session->set_flashdata($prefix . '_message', $message);
    }

    /**
     * @param string $prefix
     *
     * @return mixed
     */
    protected function get_message($prefix = 'global')
    {
        return $this->session->flashdata($prefix . '_message');
    }
}
