<?php
require_once 'CustomerModule.php';

/**
 * Class Home
 *
 * @property Layout $layout
 */
class Customer extends CustomerModule
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index(){
        $this->layout->view('main');
    }
}
