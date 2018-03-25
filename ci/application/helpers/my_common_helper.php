<?php declare(strict_types=1);

if ( !function_exists('is_null_or_empty_string')) {
    function is_null_or_empty_string($string)
    {
        return ( !isset($string) || trim($string) === '');
    }
}

if ( !function_exists('show_cli_message')) {
    function show_cli_message($message, $status)
    {
        $iscli = true;
        $color_start_str = "";
        switch ($status) {
            case "SUCCESS":
                $color_start_str = ($iscli) ? chr(27) . "[0;32m" : "<span style='color:green;'>"; //Green background
                break;
            case "FAILURE":
                $color_start_str = ($iscli) ? chr(27) . "[0;31m" : "<span style='color:red;'>"; //Red background
                break;
            case "WARNING":
                $color_start_str = ($iscli) ? chr(27) . "[1;33m" : "<span style='color:yellow;'>"; //Yellow background
                break;
            case "NOTE":
                $color_start_str = ($iscli) ? chr(27) . "[1;34m" : "<span style='color:blue;'>"; //Blue background
                break;
            default:
                throw new Exception("Invalid status: " . $status);
        }

        $color_end_str = ($iscli) ? chr(27) . "[0m" : "</span>";

        echo "[" . date('Y-m-d H:i:s') . "] " . $color_start_str . $message . $color_end_str . ($iscli ? "\n" : '<br>');
    }
}

/**
 * utf-8编码的自动换行
 * utf-8编码的wordwrap实现
 *
 * @param string $str
 * @param int    $length
 * @param string $break
 *
 * @return string
 */
if ( !function_exists('wordwarp_string')) {
    function wordwarp_string($string, $max = 25, $break = '<br />')
    {
        $strlen = mb_strwidth($string, 'UTF-8');
        $cutLen = 0;
        $retval = "";
        $temp = array();

        for ($i = 0; $i < $strlen; $i++) {
            $s = mb_substr($string, $i, 1, 'UTF-8');
            if (strlen($s) == 1) {
                $cutLen++;
            } else {
                $cutLen += 2;
            }
            $retval .= $s;
            if ($cutLen >= $max) {
                array_push($temp, $retval);
                $retval = '';
                $cutLen = 0;
            }
        }

        if (count($temp) == 0){
            array_push($temp, $retval);
        }

        return implode($break, $temp);
    }
}