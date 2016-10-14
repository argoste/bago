<?php
/* This is a script to be executed from command line; it expects `dot`
* executable  to be available in $PATH, so you need to install it either with
* your package manager or from  http://graphviz.org
*
*  usage: `php pluto.php mydiagram.pluto`
*/
require('pluto.php');
require('stelib.php');
// $argv[1] is the first argument passed on command line
if  ($argv[1] == false) {
    echo "\nusage:\n php pluto.php mydiagram.pluto\n";
    exit();
}
create_file('out.dot', pluto_transform(read_file($argv[1])));