#!/usr/bin/php
<?php
/* This is a script to be executed from command line; it expects `dot`
* executable  to be available in $PATH, so you need to install it either with
* your package manager or from  http://graphviz.org
*
*  usage: `./bago-cli.php mydiagram.txt`
*/
include_once('bago.php');
include_once('bago_io.php');
// $argv[1] is the first argument passed on command line
if  ($argv[1] == false) {
    echo "\nusage:\n php bago.php mydiagram.txt\n";
    exit();
}
$filename =$argv[1];
$content = bago_read_file($filename);
$digraph = bago_create_digraph($content);
$filename = $filename.'.gv';
bago_create_file($filename, $digraph);
echo shell_exec('/usr/bin/dot -Tsvg -O '.$filename.' &');
?>
