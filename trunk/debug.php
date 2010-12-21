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

function debugLog($message_list) {
    @$fp = fopen(__DIR__ . "/debug.txt", "a");
    @$date = strftime("%x %X");
     $message_array = func_get_args ();
    @fwrite($fp, "$date [" . getmypid() . "]" . implode(':', $message_array) . "\n");
    @fclose($fp);
}


?>