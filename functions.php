<?php
if (get_magic_quotes_gpc()) {
    $process = array(&$_GET, &$_POST, &$_COOKIE, &$_REQUEST);
    while (list($key, $val) = each($process)) {
        foreach ($val as $k => $v) {
            unset($process[$key][$k]);
            if (is_array($v)) {
                $process[$key][stripslashes($k)] = $v;
                $process[] = &$process[$key][stripslashes($k)];
            } else {
                $process[$key][stripslashes($k)] = stripslashes($v);
            }
        }
    }
    unset($process);
}

function delTree($dir) { 
    $files = array_diff(scandir($dir), array('.','..')); 
     foreach ($files as $file) { 
       (is_dir("$dir/$file")) ? delTree("$dir/$file") : unlink("$dir/$file"); 
     } 
     return rmdir($dir); 
   }