<?php
declare/* test */(ticks=1);
declare   (ticks=1);
declare(   ticks=1);
declare(TIcKs  =1);
declare(ticks=   1);
declare(ticks=1   );
declare(ticks=1);
declare(ticks=1   )    ;
declare(ticks=1) /* test */;
declare(/* test */ ticks=1    )    ;
declare(/* test */ ticks /* test */ =1);
declare(  ticks
=1   );

    declare(ticks=1) { $test = true; }

  declare(ticks=1)
{ $test = true; }

declare(ticks=1)
{

    }

declare(ticks=1) { }//end comment

declare(ticks=1) { }$x =1;

    declare(ticks=1) {
      $test = true;
    }

declare(  ticks // phpcs:ignore Standard.Category.SniffName -- fixing is undesirable
=1);

declare(ticks=1) {
}$x =1; // phpcs:ignore Standard.Category.SniffName -- fixing is undesirable

declare(ticks=1) { // test
}

declare(ticks=1) {$test = true;
}

        declare(ticks=1) { /* test */  /* test */      $test = true;
}

declare(ticks=1) {  $test = true;
}

// Ensure that we handle non-number values properly.
declare(encoding='ISO-8859-1');
declare ( encoding = 'ISO-8859-1' ) ;

// Multi-directive statements should be handled correctly too.
declare(strict_types=1,ticks=1);
// Note that PSR12 makes no mention of the formatting of the comma, so all of these should be valid.
declare(strict_types=1, ticks=1);
declare(strict_types=1,  ticks=1);
declare(strict_types=1,
ticks=1);
declare(strict_types=1,
        ticks=1);
declare(strict_types=1 , ticks=1);
declare(strict_types=1 ,ticks=1);
