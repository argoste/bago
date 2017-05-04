<?php
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
        /* EBNF
        relationship = id, multiplicity, keyword, label, id, multiplicity .
        multiplicity = '{', string,'}'.
        keyword = '@extends' | '@sharedby' | '@partof' | '@assoc' .
        */
        $pattern = '%(?P<head>\w+)\s+(\{(?P<headlabel>[^\}]*)\})?\s+'.$typ['keyword']
        .'\s+\{(?P<label>.*)\}\s+(?P<tail>\w*)\s*(\{(?P<taillabel>[^\}]*)\})?%';

        preg_match_all ($pattern, $input_text, $matches, PREG_SET_ORDER);
        //echo $typ['keyword']; echo '; $matches: '; print_r($matches);
        foreach ($matches as $mat) {
            //$edges .= $mat['head_node'].' -> '.$mat['tail_node']
            //.'[arrowhead=' . $typ['arrowhead'] . ' label="'.$mat['assoc_label'].'"'."];\n";
            $edges .= "$mat[head] -> $mat[tail] "."[label=\"$mat[label]\" headlabel=\"$mat[headlabel]\" taillabel=\"$mat[taillabel]\" arrowhead=$typ[arrowhead]]\n";
        }
    }
    return $edges;
}
?>
