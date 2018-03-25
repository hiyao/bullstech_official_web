<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class GoogleAnalytics extends CI_Hooks{
    private $CI;
    
    function insert_ga_script($params) {
        /***NOTE: This hook replaces the _display
        * method in the Output Class. I have
        * not made provisions for caching nor compression!
        */
 
        $this->CI =& get_instance();
        if (isset($this->CI->layout->obj)){
            $this->CI =& $this->CI->layout->obj;
        }

        if (method_exists($this->CI->output, 'get_output'))
            $output = $this->CI->output->get_output();
        else 
            $output = '';

        //keep performance templates in...
        $elapsed = $this->CI->benchmark->elapsed_time('total_execution_time_start', 'total_execution_time_end');
        $output = str_replace('{elapsed_time}', $elapsed, $output);
 
        $memory	 = ( ! function_exists('memory_get_usage')) ? '0' : round(memory_get_usage()/1024/1024, 2).'MB';
        $output = str_replace('{memory_usage}', $memory, $output);
 

        // keep profiler working
        if (method_exists($this->CI->output, 'is_profiler_enabled')){
            if ($this->CI->output->is_profiler_enabled()) {
                $this->CI->load->library('profiler');
                // If the output data contains closing </body> and </html> tags
                // we will remove them and add them back after we insert the profile data
                if (preg_match("|</body>.*?</html>|is", $output)){
                    $output  = preg_replace("|</body>.*?</html>|is", '', $output);
                    $output .= $this->CI->profiler->run();
                    $output .= '</body></html>';
                } else  {
                    $output .= $this->CI->profiler->run();
                }
            }
        }
 
        // if no account information just return the output
        if ( empty ($params) ) {
            // keep _output methods working...
            if (method_exists($this->CI, '_output')) {
                $this->CI->_output($output);
            } else {
                echo $output;  // Send it to the browser!
            }
            return ;
        }
        ob_start();
        ?>
    <!--Begin Google Analytics Site Code-->
	<script>
	  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
	  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
	  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
	  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

	  ga('create', "<?=$params[0]?>", "<?=$params[1];?>");
	  ga('require', 'linkid', 'linkid.js');
      ga('require', 'displayfeatures');
	  ga('send', 'pageview');

	</script>
    <!--End Google Analytics Site Code-->
        <?php
        $script = ob_get_clean();
        //insert the script
        $output = str_replace('</body>',$script. "\n</body>", $output);
 
        // keep _output methods working...
        if (method_exists($this->CI, '_output')) {
            $this->CI->_output($output);
        } else {
            echo $output;  // Send it to the browser!
        }
    }
}