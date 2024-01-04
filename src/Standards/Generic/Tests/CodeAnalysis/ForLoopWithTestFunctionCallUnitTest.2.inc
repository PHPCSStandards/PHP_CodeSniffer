<?php

// This test case file only deals with the alternative "for" loop syntax.

$a = array(1, 2, 3, 4);
for ($i = 0; $i < count($a); $i++):
    $a[$i] *= $i;
endfor;

for ($i = 0, $c = sizeof($a); $i < $c; ++$i):
    $a[$i] *= $i;
endfor;

$it = new ArrayIterator($a);
for ($it->rewind(); $it->valid(); $it->next()):
    echo $it->current();
endfor;

for ($i = 0; MyClass::staticMethod($i); $i++) :
    echo $i;
endfor;

for ($i = 0; $countFunction($i); $i++):
    echo $i;
endfor;
