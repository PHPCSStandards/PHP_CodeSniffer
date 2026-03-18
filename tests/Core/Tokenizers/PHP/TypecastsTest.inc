<?php

/*
 * Safeguard that all type casts past and present are tokenized correctly.
 *
 * This is also intended as an early warning system for when type cast tokens would be removed
 * for type casts which are no longer supported by PHP itself.
 *
 * Pertinent type cast changes in PHP:
 * - (unset) cast was introduced in PHP 5.0.
 * - (binary) cast was introduced in PHP 5.2.1.
 * - (unset) cast was deprecated in PHP 7.2 and removed in PHP 8.0.
 * - (real) cast was deprecated in PHP 7.4 and removed in PHP 8.0.
 * - (void) cast was introduced in PHP 8.5.
 * - (integer), (boolean), (double) and (binary) casts are deprecated since PHP 8.5 and will be removed in PHP 9.0.
 */

/* testNotATypeCast1 */
$a = (NOT_A_TYPECAST);

/* testBool */
$a = (bool) $b;

/* testSpacyUppercaseBool */
$a = ( BOOL) $b;

/* testBoolean */
$a = (boolean) $b;

/* testSpacyUppercaseBoolean */
$a = ( BOOLEAN ) $b;

/* testInt */
$a = (int) $b;

/* testSpacyUppercaseInt */
$a = ( INT ) $b;

/* testInteger */
$a = (integer) $b;

/* testSpacyUppercaseInteger */
$a = (   INTEGER ) $b;

/* testFloat */
$a = (float) $b;

/* testSpacyUppercaseFloat */
$a = ( FLOAT ) $b;

/* testReal */
$a = (real) $b;

/* testSpacyUppercaseReal */
$a = ( REAL ) $b;

/* testDouble */
$a = (double) $b;

/* testSpacyUppercaseDouble */
$a = ( DOUBLE   ) $b;

/* testString */
$a = (string) $b;

/* testSpacyUppercaseString */
$a = (STRING ) $b;

/* testBinary */
$a = (binary) $b;

/* testSpacyUppercaseBinary */
$a = ( BINARY ) $b;

/* testArray */
$a = (array) $b;

/* testSpacyUppercaseArray */
$a = (   ARRAY   ) $b;

/* testObject */
$a = (object) $b;

/* testSpacyUppercaseObject */
$a = ( OBJECT ) $b;

/* testUnset */
$a = (unset) $b;

/* testSpacyUppercaseUnset */
$a = ( UNSET ) $b;

/* testVoid */
(void) $b;

// This is a parse error, but the cast should still be tokenized correctly.
/* testVoidNested */
((void) $b);

/* testSpacyVoid */
(   void   ) $b;

/* testTabbyVoid */
(	void	) $b; // Tab whitespace.

/* testUppercaseVoid */
(VOID) $b;


/*
 * New lines and comments are not allowed in a type cast.
 */

/* testNotATypeCast2 */
(
void
) $b;

/* testNotATypeCast3 */
(

    void

) $b;

/* testNotATypeCast4 */
( /*comment*/ void /*comment */ ) $b;

// Parse error. This must be the last test in the file!
/* testNotATypeCast5 */
(void
