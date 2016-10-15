 <?
//THE TASKS 
// $argv[1] is the first argument passed on command line
if  ($argv[1] == false) {
    echo "\nusage:\n php pluto.php mydiagram.pluto\n";
    exit();
}

create_file(
    'out.dot',
    transform_2(
        transform_1(
            read_file(
                $argv[1])
        )
    )
);
?>