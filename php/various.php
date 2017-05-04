<?php
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
?>
