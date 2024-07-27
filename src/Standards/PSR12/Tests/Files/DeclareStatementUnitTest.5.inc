<?php declare(strict_types=1); ?>
The line above is correct. The line below should complain that it's not the first line.
<?php declare(strict_types=1); ?>

This line should complain. It's included because the optional semicolon is missing here.
<?php declare(strict_types=1) ?>

This should complain that all three parts are not on the first line of the file.
<?php
declare(strict_types=1);
?>

This is fine because it's not strict_types.
<?php declare(ticks=1); ?>

These can be automatically fixed because there is an incorect number of spaces
between the end of the declare statement and the closing PHP tag.
<?php declare(ticks=1)?>
<?php declare(ticks=1)  ?>
<?php declare(ticks=1)/* test */?>

This is missing its closing PHP tag. It should be the last test in this file.
<?php declare(strict_types=1);
