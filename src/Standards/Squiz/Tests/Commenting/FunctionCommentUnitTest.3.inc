<?php

// phpcs:set Squiz.Commenting.FunctionComment useShortTypes false

/**
 * Type check for function with both long and short types.
 * 
 * @param bool    $a1 Comment here.
 * @param boolean $a2 Comment here.
 * @param int     $a3 Comment here.
 * @param integer $a4 Comment here.
 * 
 * @return void
 */
function mixedLongAndShortUseLong(bool $a1, bool $a2, int $a3, int $a4)
{
}//end mixedLongAndShortUseLong()

// phpcs:set Squiz.Commenting.FunctionComment useShortTypes true

/**
 * Type check for function with both long and short types.
 * 
 * @param bool    $a1 Comment here.
 * @param boolean $a2 Comment here.
 * @param int     $a3 Comment here.
 * @param integer $a4 Comment here.
 * 
 * @return void
 */
function mixedLongAndShortUseShort(bool $a1, bool $a2, int $a3, int $a4)
{   
}//end mixedLongAndShortUseShort()
