<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

(defined('EXT')) OR define('EXT', '.php');

global $CFG;

/* get module locations from config settings or use the default module location and offset */
is_array(Modules::$locations = $CFG->item('modules_locations')) OR Modules::$locations = array(
    APPPATH . 'modules/' => '../modules/',
);

/* PHP5 spl_autoload */
spl_autoload_register('Modules::autoload');

/**
 * Modular Extensions - HMVC
 *
 * Adapted from the CodeIgniter Core Classes
 *
 * @link         http://codeigniter.com
 *
 * Description:
 * This library provides functions to load and instantiate controllers
 * and module controllers allowing use of modules and the HMVC design pattern.
 *
 * Install this file as application/third_party/MX/Modules.php
 *
 * @copyright    Copyright (c) 2015 Wiredesignz
 * @version      5.5
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 **/
class Modules
{
    public static $routes, $registry, $locations;

    /**
     * Run a module controller method
     * Output from module is buffered and returned.
     **/
    public static function run($module)
    {
        $method = 'index';

        if (($pos = strrpos($module, '/')) != FALSE) {
            $method = substr($module, $pos + 1);
            $module = substr($module, 0, $pos);
        }

        if ($class = self::load($module)) {
            if (method_exists($class, $method)) {
                ob_start();
                $args = func_get_args();
                $param_args = array_slice($args, 1);
                // if (count($param_args) == 1 && is_array($param_args)) {
                // $param_args = $param_args[0];
                // }

                $output = call_user_func_array(array($class, $method), $param_args);
                $buffer = ob_get_clean();

                return ($output !== NULL) ? $output : $buffer;
            }
        }

        log_message('error', "Module controller failed to run: {$module}/{$method}");
        echo "Module controller failed to run: {$module}/{$method}";
    }

    /** Load a module controller **/
    public static function load($module)
    {
//        echo "<br>===============Modules.php load()===============<br>";
//        print_r($module);
//        echo "<br>";

        (is_array($module)) ? list($module, $params) = each($module) : $params = NULL;

        /* get the requested controller class name */
        $alias = strtolower(basename($module));
//        echo "alias:";
//        print_r($alias);
//        echo "<br>";
        /* create or return an existing controller from the registry */
        if ( !isset(self::$registry[$alias])) {
//            echo 'controller is not register.<br>';

            /* find the controller */
//            echo "<br>!!!!!!!!!!!!! find the controller !!!!!!!!!!<br>";
//            print_r(explode('/', $module));
//            echo "<Br>";
            list($class) = CI::$APP->router->locate(explode('/', $module));

//            echo "class:";
//            print_r($class);
//            echo "<br>";

            /* controller cannot be located */
            if (empty($class)) return;

            /* set the module directory */
            $path = APPPATH . 'controllers/' . CI::$APP->router->directory;

//            echo "path:";
//            print_r($path);
//            echo "<br>";

            /* load the controller class */
            $class = $class . CI::$APP->config->item('controller_suffix');

            /* check if main module has [module_name]_mod_control.php then include once */
//            echo "load the controller class :";
//            print_r($class);
//            echo "<br>";
            try {
                self::load_file(ucfirst($class), $path);

                /* create and register the new controller */
                $controller = ucfirst($class);

//            echo "controller:";
//            print_r($controller);
//            echo "<br>";
                self::$registry[$alias] = new $controller($params);

//            echo  "<br>";
//            echo "new class:";
//            var_dump(self::$registry);
            } catch (Exception $e) {
                print_r($e);
            }
        }

        return self::$registry[$alias];
    }

    /** Load a module file **/
    public static function load_file($file, $path, $type = 'other', $result = TRUE)
    {
        $file = str_replace(EXT, '', $file);
        $location = $path . $file . EXT;

        if ($type === 'other') {
            if (class_exists($file, FALSE)) {
                log_message('debug', "File already loaded: {$location}");

                return $result;
            }
            include_once $location;
        } else {
            /* load config or language array */
            include $location;

            if ( !isset($$type) OR !is_array($$type))
                show_error("{$location} does not contain a valid {$type} array");

            $result = $$type;
        }
        log_message('debug', "File loaded: {$location}");

        return $result;
    }

    /** Library base class autoload **/
    public static function autoload($class)
    {
        /* don't autoload CI_ prefixed classes or those using the config subclass_prefix */
        if (strstr($class, 'CI_') OR strstr($class, config_item('subclass_prefix'))) return;

        /* autoload Modular Extensions MX core classes */
        if (strstr($class, 'MX_')) {
            if (is_file($location = dirname(__FILE__) . '/' . substr($class, 3) . EXT)) {
                include_once $location;

                return;
            }
            show_error('Failed to load MX core class: ' . $class);
        }

        /* autoload core classes */
        if (is_file($location = APPPATH . 'core/' . ucfirst($class) . EXT)) {
            include_once $location;

            return;
        }

        /* autoload library classes */
        if (is_file($location = APPPATH . 'libraries/' . ucfirst($class) . EXT)) {
            include_once $location;

            return;
        }
    }

    /** Parse module routes **/
    public static function parse_routes($module, $uri)
    {
        try {
            /* load the route file */
            if ( !isset(self::$routes[$module])) {
                if (list($path) = self::find('routes', $module, 'config/')) {
                    $path && self::$routes[$module] = self::load_file('routes', $path, 'route');
                }
            }
        } catch (Exception $e) {
            print_r($e);
            exit;
        }

        if ( !isset(self::$routes[$module])) return;

        /* parse module routes */
        foreach (self::$routes[$module] as $key => $val) {
            $key = str_replace(array(':any', ':num'), array('.+', '[0-9]+'), $key);

            if (preg_match('#^' . $key . '$#', $uri)) {
                if (strpos($val, '$') !== FALSE AND strpos($key, '(') !== FALSE) {
                    $val = preg_replace('#^' . $key . '$#', $val, $uri);
                }

                return explode('/', $module . '/' . $val);
            }
        }
    }

    /**
     * Find a file
     * Scans for files located within modules directories.
     * Also scans application directories for models, plugins and views.
     * Generates fatal error if file not found.
     **/
    public static function find($file, $module, $base)
    {
//        echo "<Br>================Modules find()================<br>";
        $segments = explode('/', $file);

        if (count(explode('/', $file)) > 2)
            $file_ext = (pathinfo($file, PATHINFO_EXTENSION)) ? $file : $file . EXT;
        else {
            $file = array_pop($segments);
            $file_ext = (pathinfo($file, PATHINFO_EXTENSION)) ? $file : $file . EXT;
        }

        $path = ltrim(implode('/', $segments) . '/', '/');
        $module ? $modules[$module] = $path : $modules = array();

        if ( !empty($segments)) {
            $modules[array_shift($segments)] = ltrim(implode('/', $segments) . '/', '/');
        }

        foreach (array_reverse(Modules::$locations) as $location => $offset) {
            foreach ($modules as $module => $subpath) {
                $fullpath = $location . $module . '/' . $base . $subpath;
//                print_r('$fullpath:' . $fullpath . "<br>\n");
//                print_r('$subpath:' . $subpath . "<br>\n");
//                print_r('$location:' . $location . "<br>\n");
//                print_r('$base:' . $base . "<br>\n");
//                print_r('$file_ext:' . $file_ext . "<br>\n");
//                print_r('$module:' . $module . "<br>\n");
//                echo "<br><Br>\n\n";

//                print_r('<Br>path >>>>>> 1:' . $fullpath . $file_ext . "<br>");
                if (is_file($fullpath . ucfirst($file_ext))) return array($fullpath, ucfirst($file));

                if ($base == 'views/') {
                    /* 檢查在views時view目錄是否有第三層需要讀取的檔案 by hiyao */
//                    print_r( '<Br>path >>>>>> view-1:'.$location.$base.$subpath.$file_ext."<br>" );
//                    print_r( $location.$base.$subpath.$file."<br>" );
                    if (is_file($location . $base . $subpath . $file_ext)) return array($location . $base . $subpath, $file);
                }

                /* 檢查Modules::$locations包含第二層模組的位置是否有需要讀取的檔案 by hiyao */
//                print_r( '<Br>path >>>>>> 2:'.$location.$base.(($base != 'views/')? ucfirst($file_ext): $file_ext)."<br>" );
                if (is_file($location . $base . (($base != 'views/') ? ucfirst($file_ext) : $file_ext))) return array($location . $base, ($base != 'views/') ? ucfirst($file) : $file);

                /* 檢查在views時view目錄是否有第二層需要讀取的檔案 by hiyao */
                if ($base == 'views/') {
//                    print_r( '<Br>path >>>>>> 3:'.$location.$base.$module.'/'.$file_ext."<br>" );
                    if (is_file($location . $base . $module . '/' . $file_ext)) return array($location . $base . $module . '/', $file);
                }

                /* 檢查在models時model目錄是否有需要讀取其他模組的檔案 by hiyao */
                if ($base == 'models/') {
//                    echo "<br>\n";
//                    print_r('<Br>path >>>>>> model-1:' . $location . '../' . $module . '/' . $base . ucfirst($file_ext) . "<br>\n");
                    if (is_file($location . '../' . $module . '/' . $base . ucfirst($file_ext))) return array($location . '../' . $module . '/' . $base, ucfirst($file));

//                    echo "<br>\n";
//                    print_r( '$fullpath:'.$fullpath."<br>\n" );
//                    print_r( '$location:'.$location."<br>\n" );
//                    print_r( '$base:'.$base."<br>\n" );
//                    print_r( '$file_ext:'.$file_ext."<br>\n" );
//                    print_r( '$module:'.$module."<br>\n" );
//                    print_r( '$file:'.$file."<br>\n" );
                    $tmp = explode('/', $file_ext);
                    switch(count($tmp)){
                        case 3:
                            list($parent_module, $tmpmodule, $tmpfile) = array_pad($tmp, 3, NULL);
//                            print_r( '$parent_module:'.$parent_module."<br>\n" );
//                            print_r( '$module:'.$module."<br>\n" );
//                            print_r( '$tmpfile:'.$tmpfile."<br>\n" );
//                            print_r( '<Br>path >>>>>> model-2:'.$location.$parent_module.'/modules/'.$tmpmodule.'/'.$base.ucfirst($tmpfile)."<br>\n" );

                            if (is_file($location . $parent_module . '/modules/' . $tmpmodule . '/' . $base . ucfirst($tmpfile)))
                                return array($location . $parent_module . '/modules/' . $tmpmodule . '/' . $base, substr(ucfirst($tmpfile), 0, strrpos($tmpfile, '.')));

                            break;
                        case 4:
                            list($module, $category, $sub_module, $file) = array_pad($tmp, 4, NULL);
//                            print_r( '$module:'.$module."<br>\n" );
//                            print_r( '$category:'.$category."<br>\n" );
//                            print_r( '$sub_module:'.$sub_module."<br>\n" );
//                            print_r( '$file:'.$file."<br>\n" );
//                            print_r( '<Br>path >>>>>> model-3:'.$location . $module . '/modules/' . $category .'/modules/' .$sub_module. '/' . $base . ucfirst($file)."<br>\n" );

                            if (is_file($location . $module . '/modules/' . $category .'/modules/' .$sub_module. '/' . $base . ucfirst($file)))
                                return array($location . $module . '/modules/' . $category .'/modules/' .$sub_module. '/' . $base, substr(ucfirst($file), 0, strrpos($file, '.')));

                            break;
                        default:
                            if (ENVIRONMENT == 'testing'){
//                                echo "\$tmp count:".count($tmp)."\n";
//                                echo "\$tmp:";
//                                print_r($tmp);
//                                echo "\n";
//                                echo "\$location:".($location). "\n";
                                list($file) = array_pad($tmp, 1, NULL);
//                                echo "test 1: \$location/../models/ucfirst(\$file):". ((is_file($location."/../models/".ucfirst($file)))? "TRUE": "FALSE");
                                if (is_file($location."/../models/".ucfirst($file)))
                                    return array($location."/../models/", substr(ucfirst($file), 0, strrpos($file, '.')));
                            }
                    }

                }

                if ($base == 'libraries/' OR $base == 'models/') {
                    if (is_file($fullpath . ucfirst($file_ext))) return array($fullpath, ucfirst($file));
                } else
                    /* load non-class files */
                    if (is_file($fullpath . $file_ext)) return array($fullpath, $file);

//                echo "<br>----------foreach----------<br>";
            }
        }

        return array(FALSE, $file);
    }
}