<?php
/* Pluto language to graphviz preprocessor
 * Pluto-specific Functions
* Simplest case: ID are only made of numbers, letters and underscore.
* TODO: object can have a part like that `object Pinta :: Boat`
*/

function pluto_transform ($input_text) {
    // THIS STRING will contain the text TO BE OUTPUT
    // WE OPEN THE DIGRAPH
    $trasformed_text = "digraph{\n";
    
    /*these patterns are for use with  PHP preg built-in library
    *for Perl compatible regular expressions*/
    // space is unicode U+0020 and in PCRE is \x20 (hex) or \040 (octal)
    // tab is \x09 or \011 or \t
    $optional_space = '(?:\t|\040){0,}';
    
    // ELEMENT TYPE IS SMALL NODE aka a node with a very short label 
    $small_node = array (
        array('name'=>'actor','keyword'=>'@actor','style'=>'shape=none image="actor.png"')
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
    
    // ELEMENT TYPE IS BIG NODE aka a node with a long, multiline label
    // like a class with properties and methods 
    $big_node = array(
        array('name'=>'class', 'keyword'=>'@class', 'style'=>'shape=record'),
        array('name'=>'object','keyword'=>'@object','style'=>'shape=record'),
        array('name'=>'use case','keyword'=>'@usecase','style'=>'shape=ellipse'),
        array('name'=>'note','keyword'=>'@note','style'=>'shape=note'),
    );
    for ($y=0; $y<count($big_node); $y++) {
        $pattern = '~';
        $pattern .= $optional_space;
        $pattern .= $big_node[$y]['keyword'];
        $pattern .= '\s{1,}';
        // named captured subpattern (?<id>) 
        $pattern .= '(?P<id>\w{1,})';
        $pattern .= $optional_space.'(?:';
        $pattern .= '\{{1}';
        $pattern .= '(?P<body>.{1,})';
        $pattern .= '\}{1}';
        $pattern .= '){0,1}';
        $pattern .= '~';
        preg_match_all($pattern, $input_text, $matches);
        
        $fromage = $big_node[$y];
        echo "matches for ". $fromage['name'] ."\n";
        var_dump($matches);
        
        for ($x=0; $x< count($matches[0]); $x++) {
            $trasformed_text .= $matches['id'][$x].' ['. $big_node[$y]['style']
            .' label="'.$matches['body'][$x].'"];'."\n";
        }
    }
    /*
     *                //the first captured group is the ID of the node
                $trasformed_text .= $matches['id'][$x].'['.$big_node[$y]['style'].' label="{';
                //5 [shape=record label="{Person | name\naddress\nage | eat() }"]
                $trasformed_text .= $matches['id'][$x] . '| ';
                //TODO please separate properties and methods with an horizontal line
                $Body_array = preg_split('~\,~', $matches['body'][$x]);
                foreach ($Body_array as $Ba) {
                    $trasformed_text .= $Ba. '\n';
                }
                $trasformed_text .= '}"];'."\n";  */
    
    // ELEMENT TYPE IS SMALL EDGE aka an edge without label
    $small_edge = array(
        array('name'=>'generalization','keyword'=>'@extends','style'=>'arrowhead=onormal'),
        array('name'=>'aggregation','keyword'=>'@sharedby','style'=>'arrowhead=odiamond'),
        array('name'=>'composition','keyword'=>'@partof','style'=>'arrowhead=diamond'),
        array('name'=>'association','keyword'=>'@assoc','style'=>'arrowhead=none'),
    );
    for ($y=0; $y<count($small_edge); $y++) {
        $pattern = '~';
        $pattern .= '\A';
        $pattern .= $optional_space;
        //Here the head, a node
        $pattern .= '(?<headnode>\w{1,})';
        $pattern .= '\s{1,}';
        $pattern .= $small_edge[$y]['keyword'];
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
            .' ['.$small_edge[$y]['style'] . ' ]'. "\n";
        }
    }
    
    // THEN WE CLOSE THE DIGRAPH
    $trasformed_text .= "}\n";
    return $trasformed_text;
}
