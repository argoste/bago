<?php
/* Pluto language to graphviz preprocessor */
function bago_create_digraph ($input_text) {
    $digraph = "digraph{\n";
    $digraph .= bago_create_classes ($input_text);
    $digraph .= bago_create_relationships($input_text);
    $digraph .= "\n}";
    return $digraph;
}
?>
