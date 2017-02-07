<?php
include_once('bago_relationships.php');
$diagram = '
Author {1,} @assoc {write} Opus {0,}
Author {surname, born_date}';
$edges = bago_create_relationships($diagram);
echo $edges;
?>
