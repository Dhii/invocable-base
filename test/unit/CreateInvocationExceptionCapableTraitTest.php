<?php

namespace Dhii\Invocation\FuncTest;

use Dhii\Invocation\CreateInvocationExceptionCapableTrait as TestSubject;
use Exception;
use Exception as RootException;
use PHPUnit_Framework_MockObject_MockObject as MockObject;
use Xpmock\TestCase;

/**
 * Tests {@see TestSubject}.
 *
 * @since [*next-version*]
 */
class CreateInvocationExceptionCapableTraitTest extends TestCase
{
    /**
     * The class name of the test subject.
     *
     * @since [*next-version*]
     */
    const TEST_SUBJECT_CLASSNAME = 'Dhii\Invocation\CreateInvocationExceptionCapableTrait';

    /**
     * Creates a new instance of the test subject.
     *
     * @since [*next-version*]
     *
     * @param array $methods The methods to mock.
     *
     * @return TestSubject|MockObject The new instance.
     */
    public function createInstance($methods = [])
    {
        $methods = $this->mergeValues(
            $methods,
            [
            ]
        );

        $mock = $this->getMockBuilder(static::TEST_SUBJECT_CLASSNAME)
                     ->setMethods($methods)
                     ->getMockForTrait();

        $mock->method('__')
             ->will($this->returnArgument(0));

        return $mock;
    }

    /**
     * Merges the values of two arrays.
     *
     * The resulting product will be a numeric array where the values of both inputs are present, without duplicates.
     *
     * @since [*next-version*]
     *
     * @param array $destination The base array.
     * @param array $source      The array with more keys.
     *
     * @return array The array which contains unique values
     */
    public function mergeValues($destination, $source)
    {
        return array_keys(array_merge(array_flip($destination), array_flip($source)));
    }

    /**
     * Creates a mock that both extends a class and implements interfaces.
     *
     * This is particularly useful for cases where the mock is based on an
     * internal class, such as in the case with exceptions. Helps to avoid
     * writing hard-coded stubs.
     *
     * @since [*next-version*]
     *
     * @param string   $className      Name of the class for the mock to extend.
     * @param string[] $interfaceNames Names of the interfaces for the mock to implement.
     *
     * @return MockObject The object that extends and implements the specified class and interfaces.
     */
    public function mockClassAndInterfaces($className, $interfaceNames = [])
    {
        $paddingClassName = uniqid($className);
        $definition = vsprintf(
            'abstract class %1$s extends %2$s implements %3$s {}',
            [
                $paddingClassName,
                $className,
                implode(', ', $interfaceNames),
            ]
        );
        eval($definition);

        return $this->getMockForAbstractClass($paddingClassName);
    }

    /**
     * Creates a new exception.
     *
     * @since [*next-version*]
     *
     * @param string $message The exception message.
     *
     * @return RootException|MockObject The new exception.
     */
    public function createException($message = '')
    {
        $mock = $this->getMockBuilder('Exception')
                     ->setConstructorArgs([$message])
                     ->getMock();

        return $mock;
    }

    /**
     * Tests whether a valid instance of the test subject can be created.
     *
     * @since [*next-version*]
     */
    public function testCanBeCreated()
    {
        $subject = $this->createInstance();

        $this->assertInternalType(
            'object',
            $subject,
            'A valid instance of the test subject could not be created.'
        );
    }

    /**
     * Tests the invocation exception creation method to assert whether the created exception instance is of the
     * correct type and has all of the correct information.
     *
     * @since [*next-version*]
     */
    public function testCreateInvocationException()
    {
        $subject = $this->createInstance();
        $reflect = $this->reflect($subject);

        $m = uniqid('message-');
        $c = rand(0, 100);
        $p = new Exception();
        $x = function() {
        };
        $a = [uniqid('arg-'), uniqid('key') => uniqid('arg-')];

        $actual = $reflect->_createInvocationException($m, $c, $p, $x, $a);

        $this->assertInstanceOf(
            'Dhii\Invocation\Exception\InvocationExceptionInterface',
            $actual,
            'Created exception does not implement expected interface.'
        );

        $this->assertEquals($m, $actual->getMessage(), 'Exception message is incorrect.');
        $this->assertEquals($c, $actual->getCode(), 'Exception code is incorrect.');
        $this->assertSame($p, $actual->getPrevious(), 'Inner exception is incorrect.');
        $this->assertSame($x, $actual->getCallable(), 'Exception callable is incorrect.');
        $this->assertEquals($a, $actual->getArgs(), 'Exception callable args are incorrect.');
    }
}
