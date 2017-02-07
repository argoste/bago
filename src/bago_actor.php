<?php
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
?>
