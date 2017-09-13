<?php
/**
 * Created by PhpStorm.
 * User: matr06017
 * Date: 9/12/2017
 * Time: 3:35 PM
 */

$command = CraftCommand(WEB_SERVER_HOST, WEB_SERVER_PORT, WEB_SERVER_DOCROOT);
$phandle = popen($command, "r");
$read = stream_get_contents($phandle); //Read the output
pclose($phandle);

$i = 0;
$pid = ExtractProcessIdFromWMIC($read);
echo sprintf(
        '%s - Web server started on %s:%d with PID %d',
        date('r'),
        WEB_SERVER_HOST,
        WEB_SERVER_PORT,
        $pid
    ) . PHP_EOL;

// Kill the web server when the process ends
register_shutdown_function(function() use ($pid) {
    sleep(120); // sleep for a few seconds before shutting down
    echo sprintf('%s - Killing process with ID %d', date('r'), $pid) . PHP_EOL;
    shell_exec("taskkill /F /PID $pid");
});
/***********************************************
 *
 *					FUNCTIONS
 *
 ***********************************************/
function CraftCommand($host, $port, $docroot)
{
    $php = PHP_BINARY;
    $fullroot = getcwd() . "/" . $docroot;
    $fullroot = str_replace("\\", "/", $fullroot);
    //PrintDirectory($fullroot);

    $command = "wmic process call create \"$php -S $host:$port -t $fullroot \"";
    return $command;
}
function ExtractProcessIdFromWMIC($read)
{
    $pid = false;
    $output = explode("\n",$read);
    foreach($output as $line) {
        if (stripos($line, "ProcessId") !== false) {
            $ex = explode("=", $line, 2);
            $pid = trim($ex[1]);
            $pid = substr($pid, 0, strlen($pid) - 1); // remove ;
            return $pid;
        }
    }

    return $pid;
}
function PrintDirectory($dir) {
    if ($handle = opendir($dir)) {
        while (false !== ($entry = readdir($handle))) {
            if ($entry != "." && $entry != "..") {
                echo "$entry\n";
            }
        }
        closedir($handle);
    }
}