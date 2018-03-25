<?php declare(strict_types=1);

//取得此使用者目錄容量
if ( !function_exists('dirsize')) {
    function dirsize($dirName)
    {
        if (is_dir($dirName)) {
            $dir = dir($dirName);
            $size = 0;
            while ($file = $dir->read()) {
                if ($file != '.' && $file != '..') {
                    if (is_dir("$dirName/$file"))
                        $size += dirsize($dirName . '/' . $file);
                    else
                        $size += filesize($dirName . '/' . $file);

                }
            }
            $dir->close();

            return $size;
        } else
            return 0;
    }
}

if ( !function_exists('splitFilename')) {
    function splitFilename($filename)
    {
        $pos = strrpos($filename, '.');     //basename($filename) 我拿掉asename了 by fox
        if ($pos === FALSE) {
            // dot is not found in the filename
            return array($filename, ''); // no extension
        } else {
            $basename = substr($filename, 0, $pos);
            $extension = substr($filename, $pos + 1);

            return array($basename, $extension);
        }
    }
}

if ( !function_exists('create_directory')) {
    function create_directory($dirLocation)
    {
        if ( !file_exists($dirLocation)) {
            mkdir($dirLocation);
        }
    }
}

if ( !function_exists('unlinkDir')) {
    function unlinkDir($str)
    {
        if ( !is_link($str) && is_dir($str)) {
            $str = escapeshellarg($str);
            system('rm -rf -- ' . $str);
        }
        /*if(is_file($str)){
            return @unlink($str);
        }
        elseif(is_dir($str)){
          $scan = glob(rtrim($str,'/').'/{,.}*', GLOB_BRACE);
          foreach($scan as $index => $path) {
              $name = basename($path);
              if($name != '.' && $name != '..') {
                    unlinkDir($path);
                }
          }
          return @rmdir($str);
        }*/
    }
}
if ( !function_exists('getffmpegPath')) {
    function getffmpegPath()
    {
        if (file_exists('/usr/bin/ffmpeg'))
            return '/usr/bin/ffmpeg';
    }
}
if ( !function_exists('getmencoderPath')) {
    function getmencoderPath()
    {
        if (file_exists('/usr/bin/mencoder'))
            return '/usr/bin/mencoder';
    }
}
if ( !function_exists('sbasename')) {
    function sbasename($filename)
    {
        return preg_replace('/^.+[\\\\\\/]/', '', $filename);
    }
}
if ( !function_exists('cut_content')) {
    function cut_content($content, $num)
    {
        $data = array();
        $data['sub_content'] = mb_substr(strip_tags($content), 0, $num, 'UTF-8');
        if (strlen(strip_tags($content)) > strlen($data['sub_content']))
            $data['type'] = 1;
        else
            $data['type'] = 0;

        return $data;
    }
}

/**
 * get basename
 *
 * TODO:support chinese basename
 *
 * @param $filename
 *
 * @return mixed
 */
if ( !function_exists('get_raw_filename')) {
    function get_raw_filename($filename)
    {
        $filename = rtrim($filename, '/');

        return preg_replace('/\\.[^.\\s]{1,4}$/', '', $filename);
    }
}