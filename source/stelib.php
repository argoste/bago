<?php

// Multi-tools functions
//TODO create namespace multi-tools;
function read_file ($filename) {
    // TAKE THE INPUT FILE AS A STRING
    $handle = fopen( $filename, 'r');
    if ($handle == false) {
        echo "I cannot open the file\n";
        exit();
    }
    $content = fread($handle, filesize($filename));
    fclose($handle);
    return $content;
}

function create_file ($filename, $text){
    // CREATE NEW FILE AD WRITE THE STRING
    $handle = fopen($filename, 'w');
    fwrite($handle, $text);
    //handle is  file system pointer resource created using fopen(). 
    fclose($handle);
    return 1;
}

function dot_launcher ($filename) {
    // EXECUTE GRAPHVIZ DOT
    return shell_exec('/usr/bin/dot '. $filename);
}

?>