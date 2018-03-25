<?php
require_once 'HomeModule.php';

/**
 * Class Home
 *
 * @property Layout $layout
 */
class Home extends HomeModule
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index(){
        $this->layout->view('main');
    }
}
