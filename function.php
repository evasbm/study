<?php
function savefile($content,$filename){
  file_put_contents($filename, $content);
}

function customError($errno, $errstr, $errfile,$errline, $errcontext)
 { 
 $Time = date("Y-m-d H:i:s");	
 error_log(" Error: $Time 出现 $errstr [$errno]，错误存在于 $errfile 的第 $errline 行。 ",3,'error.log');
}
function directoryToArray($directory, $recursive) {
    $array_items = array();
    if ($handle = opendir($directory)) {
        while (false !== ($file = readdir($handle))) {
            if ($file != "." && $file != "..") {
                if (is_dir($directory. "/" . $file)) {
                    if($recursive) {
                        $array_items = array_merge($array_items, directoryToArray($directory. "/" . $file, $recursive));
                    }
                    $file = $directory . "/" . $file;
                    $array_items[] = preg_replace("/\/\//si", "/", $file);
                } else {
                    $file = $directory . "/" . $file;
                    $array_items[] = preg_replace("/\/\//si", "/", $file);
                }
            }
        }
        closedir($handle);
    }
    return $array_items;
}
?>
