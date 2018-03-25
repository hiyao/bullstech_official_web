<?php

/**
 * Class Layout
 *
 * @version 0.1.0
 * @author  hiyao
 */
class Layout
{
    /**
     * @var array
     */
    protected $data = array();
    /**
     * @var \CI_Controller
     */
    protected $obj;
    /**
     * @var string
     */
    protected $layout;
    /**
     * @var \CI_Loader|object
     */
    protected $loader;

    /**
     * Layout constructor.
     *
     * @param string $layout
     */
    function __construct($layout = "template")
    {
        $this->obj =& get_instance();
        $this->layout = $layout;
        //選擇載入器 預設為CI實體
        $this->loader = $this->obj->load;
    }

    /**
     * push_var
     *
     * @public
     *
     * @param string $var
     */
    function push_var($var = '')
    {
        if ($var) {
            $this->data = array_merge($this->data, $var);
        }
    }

    /**
     * set_layout
     *
     * @public
     *
     * @param $layout
     */
    function set_layout($layout)
    {
        $this->layout = $layout;
    }

    /**
     * view
     *
     * @public
     *
     * @param      $view
     * @param null $data
     * @param bool $return
     *
     * @return object|string
     */
    function view($view, $data = null, $return = false)
    {

        //        echo "<br>========== layout view() =============<br>";
        //        print_r($this->loader);

        if (null != $data && is_array($data)) {
            $data = array_merge($this->data, $data);
        }

        if (is_array($view)) {
            $data['content'] = "";
            foreach ($view as $value) {
                $data['content'] .= $this->loader->view($value, $data, true);
            }
        } else {
            $data['content'] = $this->loader->view($view, $data, true);
        }

        if ($return) {
            $output = $this->loader->view($this->layout, $data, true);

            return $output;
        } else {
            $this->loader->view($this->layout, $data, false);
        }
    }

    //自行決定 view的內容
    /**
     * html
     *
     * @public
     * @author hiyao
     *
     * @param      $html
     * @param null $data
     * @param bool $return
     *
     * @return object|string
     */
    function html($html, $data = null, $return = false)
    {
        $data = array_merge($this->data, $data);
        $data['content'] = $html;
        if ($return) {
            $output = $this->loader->view($this->layout, $data, true);

            return $output;
        } else {
            $this->loader->view($this->layout, $data, false);
        }
    }
}