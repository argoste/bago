<?php
// Multipurpose functions
function bago_read_file (string $filename) {
    $handle = fopen( $filename, 'r');
    if ($handle == false) {
        echo "I cannot open the file\n";
        exit();
    }
    $content = fread($handle, filesize($filename));
    fclose($handle);
    return $content;
}

function bago_create_file (string $filename, string $text){
    // CREATE NEW FILE AD WRITE THE STRING
    $handle = fopen($filename, 'w');
    fwrite($handle, $text);
    //handle is  file system pointer resource created using fopen().
    fclose($handle);
    return 1;
}
?>
