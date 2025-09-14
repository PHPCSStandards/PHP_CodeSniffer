<?php
/**
 * Test case with helper methods for tests for the Ruleset class.
 *
 * @author    Juliette Reinders Folmer <phpcs_nospam@adviesenzo.nl>
 * @copyright 2024 PHPCSStandards and contributors
 * @license   https://github.com/PHPCSStandards/PHP_CodeSniffer/blob/HEAD/licence.txt BSD Licence
 */

namespace PHP_CodeSniffer\Tests\Core\Ruleset;

use PHP_CodeSniffer\Exceptions\RuntimeException;
use PHPUnit\Framework\TestCase;

abstract class AbstractRulesetTestCase extends TestCase
{


    /**
     * Asserts that an object has a specified property in a PHPUnit cross-version compatible manner.
     *
     * @param string $propertyName The name of the property.
     * @param object $object       The object on which to check whether the property exists.
     * @param string $message      Optional failure message to display.
     *
     * @return void
     */
    protected function assertXObjectHasProperty($propertyName, $object, $message = '')
    {
        if (method_exists($this, 'assertObjectHasProperty') === true) {
            $this->assertObjectHasProperty($propertyName, $object, $message);
        } else {
            // PHPUnit < 9.6.11.
            $this->assertObjectHasAttribute($propertyName, $object, $message);
        }
    }


    /**
     * Asserts that an object does not have a specified property
     * in a PHPUnit cross-version compatible manner.
     *
     * @param string $propertyName The name of the property.
     * @param object $object       The object on which to check whether the property exists.
     * @param string $message      Optional failure message to display.
     *
     * @return void
     */
    protected function assertXObjectNotHasProperty($propertyName, $object, $message = '')
    {
        if (method_exists($this, 'assertObjectNotHasProperty') === true) {
            $this->assertObjectNotHasProperty($propertyName, $object, $message);
        } else {
            // PHPUnit < 9.6.11.
            $this->assertObjectNotHasAttribute($propertyName, $object, $message);
        }
    }


    /**
     * Helper method to tell PHPUnit to expect a PHPCS RuntimeException with a certain message
     * in a PHPUnit cross-version compatible manner.
     *
     * @param string $message The expected exception message.
     *
     * @return void
     */
    protected function expectRuntimeExceptionMessage($message)
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage($message);
    }


    /**
     * Helper method to tell PHPUnit to expect a PHPCS RuntimeException which matches a regex pattern.
     *
     * @param string $regex The regex which should match.
     *
     * @return void
     */
    protected function expectRuntimeExceptionRegex($regex)
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessageMatches($regex);
    }
}
