<?php

namespace Dhii\Invocation\Exception\UnitTest;

use Dhii\Invocation\Exception\InvocationException;
use Exception;
use Xpmock\TestCase;
use Dhii\Invocation\Exception\InvocationException as TestSubject;

/**
 * Tests {@see TestSubject}.
 *
 * @since [*next-version*]
 */
class InvocationExceptionTest extends TestCase
{
    /**
     * Tests whether a valid instance of the test subject can be created.
     *
     * @since [*next-version*]
     */
    public function testCanBeCreated()
    {
        $subject = new InvocationException();

        $this->assertInstanceOf(
            'Exception',
            $subject,
            'A valid instance of the test subject could not be created.'
        );

        $this->assertInstanceOf(
            'Dhii\Invocation\Exception\InvocationExceptionInterface',
            $subject,
            'A valid instance of the test subject could not be created.'
        );
    }

    /**
     * Tests the constructor to assert whether the constructor arguments are correctly set and can be retrieved using
     * the subject's getter methods.
     *
     * @since [*next-version*]
     */
    public function testConstructor()
    {
        $message = uniqid('message-');
        $code = rand(0, 100);
        $prev = new Exception();
        $callable = 'strlen';
        $args = [
            uniqid('arg-'),
            uniqid('arg-'),
        ];

        $subject = new InvocationException($message, $code, $prev, $callable, $args);

        $this->assertEquals(
            $message,
            $subject->getMessage(),
            'Expected and retrieved message are not the same.'
        );
        $this->assertEquals(
            $code,
            $subject->getCode(),
            'Expected and retrieved code are not the same.'
        );
        $this->assertSame(
            $prev,
            $subject->getPrevious(),
            'Expected and retrieved previous exceptions are not the same.'
        );
        $this->assertSame(
            $callable,
            $subject->getCallable(),
            'Expected and retrieved callable are not the same.'
        );
        $this->assertEquals(
            $args,
            $subject->getArgs(),
            'Expected and retrieved args are not the same.'
        );
    }
}
