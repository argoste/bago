<?php
/* Pluto language to graphviz preprocessor */

function bago_show($variable){
    // Alternative to var_dump(); for debugging purposes.
    echo "\n.'+++++++++++++'.\n";
    print_r($variable);
}

function bago_create_classes($input_text) {
    // named captured subpattern (?<id>) 
    $pattern = '%@class\s+(?P<id>\w+)\s*(?:\{(?P<body>.+)\}){0,1}%';
    preg_match_all($pattern, $input_text, $matched_classes, PREG_SET_ORDER);
    // [shape=record label="{Person | name\naddress\nage | eat() }"]
    $nodes ='';
    echo '$matched_classes:  '; print_r($matched_classes);
    foreach ($matched_classes as $class) {
        $id = $class['id'];
        $properties_and_methods = preg_split('~[,;]+~', $class['body'] );
        
        $properties = preg_grep('~\w+\s*[^(]\z~', $properties_and_methods);
        echo '$properties:  '; print_r($properties);
        $methods = preg_grep('~\w+\s*\(~', $properties_and_methods);
        echo '$methods:  '; print_r($methods);
        
        $nodes .= $id.'[shape=record label="{'.$id.'| ';
        foreach($properties as $pro){ $nodes .= $pro.'\n';}
        $nodes .= '| ';
        foreach($methods as $met) {$nodes .= $met.'\n';}
        $nodes .= '}"]  '."\n";
    }
    return $nodes;
}

function bago_create_relationships ($input_text) {
        // ELEMENT TYPE IS SMALL EDGE aka an edge without label
    $relationship_edge = array(
        array('name'=>'generalization','keyword'=>'@extends','style'=>'arrowhead=onormal'),
        array('name'=>'aggregation','keyword'=>'@sharedby','style'=>'arrowhead=odiamond'),
        array('name'=>'composition','keyword'=>'@partof','style'=>'arrowhead=diamond'),
        array('name'=>'association','keyword'=>'@assoc','style'=>'arrowhead=none'),
    );
    for ($y=0; $y<count($relationship_edge); $y++) {
        $pattern = '~';
        $pattern .= '\A';
        $pattern .= '\s*';
        //Here the head, a node
        $pattern .= '(?<headnode>\w{1,})';
        $pattern .= '\s{1,}';
        $pattern .= $relationship_edge[$y]['keyword'];
        //some space is needed
        $pattern .= '\s{1,}';
        //Here the tail, a node
        $pattern .= '(?<tailnode>\w{1,})';
        $pattern .= '~';
        preg_match_all ($pattern, $input_text, $matches);
        for ($x=0; $x<count($matches[0]); $x++) {
            $trasformed_text .= $matches['headnode'][$x]
            .' -> '
            .$matches['tailnode'][$x]
            .' ['.$relationship_edge[$y]['style'] . ' ]'. "\n";
        }
    }
}
function bago_create_actors($input_text) {
        // ELEMENT TYPE IS SMALL NODE aka a node with a very short label 
    $small_node = array (
        array('name'=>'actor','keyword'=>'@actor','style'=>'shape=none image="img/actor.png"')
        );
    for ($y=0; $y<count($small_node); $y++) {
        $pattern = '~';
        $pattern .= $optional_space;
        $pattern .= $small_node[$y]['keyword'];
        $pattern .= '\s{1,}';
        // named captured subpattern (?P<name>) 
        $pattern .= '(?P<id>\w{1,})';
        $pattern .= '~';
        preg_match_all($pattern, $input_text, $matches);
        for ($x=0; $x< count($matches[0]); $x++) {
            $trasformed_text .= $matches['id'][$x].' ['.$small_node[$y]['style']. '];'."\n";
        }
    }
}

function bago_create_other_big_nodes($input_text) {
        // ELEMENT TYPE IS BIG NODE aka a node with a long, multiline label
    // like a class with properties and methods 
    $big_node = array(
        array('name'=>'class', 'keyword'=>'@class', 'style'=>'shape=record'),
        //array('name'=>'object','keyword'=>'@object','style'=>'shape=record'),
        //array('name'=>'use case','keyword'=>'@usecase','style'=>'shape=ellipse'),
        //array('name'=>'note','keyword'=>'@note','style'=>'shape=note'),
    );
    for ($y=0; $y<count($big_node); $y++) {
        bago_node();
    }
}

function bago_create_digraph ($input_text) {
    $digraph = "digraph{\n";
    $digraph .= bago_create_classes ($input_text);
    $digraph .= bago_create_relationships($input_text);
    $digraph .= "\n}";
    return $digraph;
}  

// Multipurpose functions
function bago_read_file ($filename) {
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

function bago_create_file ($filename, $text){
    // CREATE NEW FILE AD WRITE THE STRING
    $handle = fopen($filename, 'w');
    fwrite($handle, $text);
    //handle is  file system pointer resource created using fopen(). 
    fclose($handle);
    return 1;
}

function bago_launch_gv ($filename) {
    // EXECUTE GRAPHVIZ DOT
    return shell_exec('/usr/bin/dot '. $filename);
}

?>