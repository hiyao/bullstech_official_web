<?php

class CustomerModule extends MX_Controller
{
    protected $backend_name = 'home';
    protected $tplVar = array();
    protected $app_type;
    private $module_name;
    private $controller_name;

    public function __construct()
    {
        parent::__construct();
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
    }

    public function customer_url()
    {
        return base_url() . "customer/{$this->module_name}/" . (($this->controller_name !== $this->module_name)? "{$this->controller_name}/" : '');
    }
}
