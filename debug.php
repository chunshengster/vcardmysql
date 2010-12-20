<?php


global $debugstr;

function debug($str) {
    global $debugstr;
    $debugstr .= "$str\n";
}

function getDebugInfo() {
    global $debugstr;
    
    return $debugstr;
}

function debugLog($message) {
    @$fp = fopen(__DIR__ . "/debug.txt","a");
    @$date = strftime("%x %X");
    if (is_array($message)) {
        @fwrite($fp, "$date [" . getmypid() . "]" . implode(':', $message) . "\n");
    }  else {
        @fwrite($fp, "$date [" . getmypid() . "]" .$message);
    }
    @fclose($fp);
}


?>