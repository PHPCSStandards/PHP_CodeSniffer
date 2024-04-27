<?php
/**
 * A collection of PHP parse errors for testing
 *
 * With debugMode disabled, the PHPDoc type sniff should give no errors, except the type error near the end.
 *
 * @author    James Calder <jeg+accounts.github@cloudy.kiwi.nz>
 * @copyright 2024 Otago Polytechnic
 * @license   https://github.com/PHPCSStandards/PHP_CodeSniffer/blob/master/licence.txt BSD Licence
 *            CC BY-SA 4.0 or later
 */

namespace TrailingBackslash\;

// Malformed.
namespace @

use NoTrailingBackslash {Something
};

use TrailingBackslash\;

// No bracket closer.
use x\ { ;

// No content.
use x\ {};

// Malformed as clause.
use x as @;

// No terminator.
use x @

/**
 * Wrong place
 *
 * @var int
 */
public int $wrongPlace1;


/**
 * Wrong places
 *
 * @return void
 */
function wrongPlaces(): void
{
    namespace ns;
    use x;

    /**
     * Wrong place
     */
    class C
    {
    }//end class

    /**
     * Wrong place
     *
     * @var int
     */
    public int $wrongPlace2;

}//end wrongPlaces()


/**
 * No block
 */
class TypesInvalid

/**
 * No block close
 */
class C {

/**
 * Malformed class trait use
 */
class C {
    use T { @
}


/**
 * No parameters
 *
 * @return void
 */
function f: void {

}//end f()


/**
 * No parameters close
 *
 * @return void
 */
function f( : void {

}//end f()


/**
 * No block
 */
function f(): void

/**
 * No block close
 */
function f(): void {

/**
 * Malformed declaration.
 */
public @

/**
 * Unterminated variable
 *
 * @var int
 */
public int $v @


/**
 * Do we still reach here, and detect an error?
 *
 * @param string $p
 *
 * @return void
 */
function f(int $p): void
{

}//end f()


/** Unclosed Doc comment
