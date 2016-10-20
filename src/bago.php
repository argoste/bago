<?php
/* Pluto language to graphviz preprocessor */


function bago_create_classes(string $input_text) {
    $pattern = '%@class\s+(?P<id>\w+)\s*(?:\{(?P<body>.+)\})?%';
    preg_match_all($pattern, $input_text, $matches, PREG_SET_ORDER);
    //echo '$matches:  '; print_r($matches); echo '= = = =';
    $nodes ='';
    
    foreach ($matches as $mat) {
        // FIXME The code gives a notice when mat['body'] is not defined
        $properties_and_methods = preg_split('%,%', $mat['body'] );
        $properties = preg_grep('%\w+\s*[^(]\z%', $properties_and_methods);
        $methods = preg_grep('%\w+\s*\(%', $properties_and_methods);
        // [shape=record label="{Person | name\naddress\nage | eat() }"]
        $nodes .= $mat['id']. '[shape=record label="{'.$mat['id']. '|';
        foreach($properties as $pro){
            $nodes .= $pro. '\n';
            }
        $nodes .= ' | ';
        foreach($methods as $met) {
            $nodes .= $met.'\n';
            }
        $nodes .= '}" ]'.PHP_EOL;
    }
    return $nodes;
}

function bago_create_relationships (string $input_text) {
    $edge_types = array(
        array('name'=>'generalization','keyword'=>'@extends','arrowhead'=>'onormal'),
        array('name'=>'aggregation','keyword'=>'@sharedby','arrowhead'=>'odiamond'),
        array('name'=>'composition','keyword'=>'@partof','arrowhead'=>'diamond'),
        array('name'=>'association','keyword'=>'@assoc','arrowhead'=>"none")
    );
    $edges = '';
    foreach ($edge_types as $typ) {
        //(graphviz jargon) an edge goes from a head node to a tail node
        //the delimiter is %, and the final m is PCRE modifier  `multiline`
        $pattern = '%(?P<head>\w+)\s+(\{(?P<hl>.*)\})?'.$typ['keyword'].'\s+(?P<tail>\w+)%';

        preg_match_all ($pattern, $input_text, $matches, PREG_SET_ORDER);
        echo $typ['keyword']; echo '; $matches: '; print_r($matches);
        /*foreach ($matches as $mat) {
            //$edges .= $mat['head_node'].' -> '.$mat['tail_node']
            //.'[arrowhead=' . $typ['arrowhead'] . ' label="'.$mat['assoc_label'].'"'."];\n";
            $edges .= "$mat[head_node] -> $mat[tail_node] "
            ."[label=\"$mat[rel_label]\" headlabel=$mat[head_label] taillabel=$mat[tail_label] arrowhead=$typ[arrowhead]]\n";
        }*/
    }
    return $edges;
}

function bago_create_actors(string $input_text) {
        // ELEMENT TYPE IS SMALL NODE aka a node with a very short label 
    $node_type = array (
        array('name'=>'actor','keyword'=>'@actor','style'=>'shape=none image="img/actor.png"')
        );
    foreach ($node_type as $typ) {
        $pattern = '%\s*'.$typ['keyword'].'\s(?P<id>\w+)+%';
        preg_match_all($pattern, $input_text, $matches);
        for ($x=0; $x< count($matches[0]); $x++) {
            $trasformed_text .= $matches['id'][$x].' ['.$small_node[$y]['style']. '];'."\n";
        }
    }
}

function bago_create_other_big_nodes(string $input_text) {
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

function bago_node(string $id, int $type) {
    $node = $id.'[]'. PHP_EOL;
    return $node;
}
function bago_create_digraph ($input_text) {
    $digraph = "digraph{\n";
    $digraph .= bago_create_classes ($input_text);
    $digraph .= bago_create_relationships($input_text);
    $digraph .= "\n}";
    return $digraph;
}  

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