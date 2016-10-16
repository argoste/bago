<?php
require('bago.php');
$test_diagram = '
@class color {hexvalue, apply_to_object()}
@class sedia {marca, prezzo()}
@class quadro {autore, tecnica, stupisci()} 
@class elica {ruota() ,verso, trita()}
';

bago_create_file('diagram.gv', bago_create_digraph($test_diagram));