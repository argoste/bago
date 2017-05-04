<?php
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
?>
