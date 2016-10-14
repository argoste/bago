<?php
require('pluto.php');
$test_diagram = '
class Boat {weight, nation}
note 1 {Nel mezzo del cammin di nostra vita
mi ritrovai per una selva oscura,
ché la diritta via era smarrita}

 object Pinta
	object Titanic

';
echo pluto_transform($test_diagram);