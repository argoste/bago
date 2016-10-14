<?php
/* Pluto language to graphviz preprocessor
*
* Simplest case: ID are only made of numbers, letters and underscore.
*
* This is a script to be executed from command line; it expects `dot`
* executable  to be available in $PATH, so you need to install it either with
* your package manager or from  http://graphviz.org
*
*  usage: `php pluto.php mydiagram.pluto`
*/
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


//Pluto-specific Functions
function transform_1($input_text) {
//PARSE THE RAW STRING
//TODO Fix the semantic bugs
    $Element_array =  ['class', 'object', 'use case', 'actor','note',
    'association','generalization','aggregation','composition'];
    //iterate over tags
    foreach ($Element_array as $Category) {
        switch ($Category) {
            case 'class':
                $Keyword='class';
                $Style="shape=record";
                break;
            case 'object': 
                $Keyword = 'object';
                $Style = 'shape=record';
                break;
            case 'use case': 
                $Keyword = 'usecase';
                $Style = "shape=ellipse";
                break;
            case 'actor': 
                $Keyword = 'actor';
                $Style = 'shape=none image="man.png"';
            break;
            case 'note': 
                $Keyword = 'note';
                $Style = "shape=note";
                break;
            case 'generalization':
                $Keyword = 'extends';
                $Style = 'arrowhead=onormal';
                break;
            case 'aggregation':
                $Keyword = 'sharedby';
                $Style = 'arrowhead=odiamond';
                break;
            case 'composition':
                $Keyword = 'partof';
                $Style = 'arrowhead=diamond';
                break;
            case 'association':
                $Keyword = 'assoc';
                $Style = 'arrowhead=none';
                break;
        }
        // Some recurrent strings to be used in REGEX
        $Space ='\040{1,}'; //space
        $X ='\040{0,}'; //optional space
        $Captured = '(\w{1,})';
        switch ($Category) {
            case 'generalization':
            case 'aggregation':
            case 'composition':
                // you can put spaces at the beginning of statement
                $Pattern = '~\A\s{0,}'.$Captured.'\s{1,}'.$Keyword.'\s{1,}'.$Captured.'~';
                break;
            case 'class':
            case 'object':
            case 'use case':
                // The node ID is needed to use that node in an edge statement
                //you can omit the body
                //var_dump($Space); var_dump($Captured);
                $Pattern = '~\A\s{0,}'.$Keyword.''.$Space.$Captured.'{0,1}'.$X.'(?:\{{1}([^\}\{]{0,})\}{1}){0,1}~';
                //var_dump($Pattern);
                break;
            case 'note':
                //you can omit the ID but then I have to create  a label 
                $Pattern = '~\A\s{0,}'.$Keyword.''.$Space.$Captured.'{0,1}'.$X.'\{{1}([^\}\{]{0,})\}{1}~';
                break;
            case 'actor':
                // The body is omitted because the label mus be short, to not cover the sticky man!
                $Pattern = '~\A\s{0,}'.$Keyword.''.$Space.$Captured.'{0,1}~';
                break;
            case 'association':
                // the most complex, has the form of a function 
                //associate{Author, Book, write, [1,n], [0,n]}
                $Multiplicity= '\[{1}([^\]]{1,})\]{1}';
                $Pattern= '~\a\s{1,}'.$Keyword.$X.'\{'.$X.$Captured.$X.'\,'.$X.$Captured.$X.'(?:\,'.$X.$Captured.$X.'(?:\,'.$X.$Multiplicity.$X.'(?:\,'.$X.$Multiplicity.$X.')'.')'.'){0,1}\}~';
                break;
        }
        $Content = '$'.$Keyword;
        preg_match_all($Pattern, $input_text, $Content);
        $Matches = count($Content[0]);
        $Num=0;
        $Out_text = "";
        while ($Num<$Matches) {
            switch ($Category) {
                case 'generalization':
                case 'aggregation':
                case 'composition':
                    $Out_text .= $Content[1][$Num].'->'.$Content[2][$Num].' ['.$Style.']'."\n;";
                    break;
                case 'association':
                    $Out_text .= "$Content[1][$Num] -> $Content[2][$Num] [$Style label=\"$Content[3][$Num]\" taillabel=\"$Content[4][$Num]\" headlabel=\"$Content[5][$Num]\" ]\n;";
                    break;
                case 'actor':
                    $Out_text .= $Content[1][$Num].' ['.$Style.' ];'."\n" ;
                    break;
                case 'use case':
                case 'note':
                    $Safe_content = preg_replace('~\"~', '\"', $Content[2][$Num]) ;
                    $Foo = $Content[1][$Num];
                    if ($Foo == "") {
                        $Foo = hash('md5', $Safe_content);
                    }
                    $Out_text .= $Foo . ' ['.$Style.' label="'.$Safe_content.'"'.'];'."\n";
                    break;
                case 'class':
                case 'object':
                    //the first captured group is the ID of the node
                    $Body_array = preg_split('~\,~', $Content[2][$Num]);
                    //5 [shape=record label="{Person | name\naddress\nage | eat() }"]
                    $Out_text .= $Content[1][$Num].'['.$Style.' label="{';
                    foreach ($Body_array as $Ba) {
                        $Out_text .= $Ba. '\n';
                    }
                    $Out_text .= '}"];'."\n";                
                    break;
            }
            $Num ++;
        }
        }
    return $Out_text;
}

function transform_2 ($elements) {
    // THIS STRING will contain the text TO BE OUTPUT 
    $Out_text = "digraph{\n";
    //$Out_text .= parse_input($input_text);
    $Out_text .= $elements;
    $Out_text .= "}\n";
    return $Out_text;
}


function dot_launcher ($filename) {
    // EXECUTE GRAPHVIZ DOT
    return shell_exec('/usr/bin/dot '. $filename);
}



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
