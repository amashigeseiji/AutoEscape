<?php

require_once('ViewValueTestCase.php');

use \AutoEscape\ViewValue;
use \AutoEscape\ViewValue\ObjectViewValue;

class ObjectViewValueTest extends ViewValueTestCase
{

    protected $className = '\AutoEscape\ViewValue\ObjectViewValue';

    /**
     * @test
     */
    public function objectViewValueHasRawMethod()
    {
        $obj = new stdClass();
        $this->assertTrue(method_exists($this->create($obj), 'raw'));
    }

    /**
     * @test
     */
    public function rawValueIsObject()
    {
        $obj = new stdClass;
        $this->assertTrue(gettype($this->create($obj)->raw()) === 'object');
    }

    /**
     * @test
     */
    public function stringInObjectViewValueIsStringViewValue()
    {
        $obj = new stdClass;
        $obj->name = 'hoge';
        $objInstance = $this->create($obj);
        $this->assertInstanceOf('\AutoEscape\ViewValue\StringViewValue', $objInstance->name);
    }

    /**
     * @test
     */
    public function stringInObjectViewValueShouldBeEscaped()
    {
        $obj = new stdClass;
        $obj->val = '<script>alert(0)</script>';
        $objInstance = $this->create($obj);
        $this->outputShouldBeSame(
            $this->_h('<script>alert(0)</script>'),
            $objInstance->val
        );
    }

    /**
     * @test
     */
    public function arrayInObjectViewValueIsArrayViewValue()
    {
        $obj = new stdClass;
        $obj->array = ['hoge'];
        $objInstance = $this->create($obj);
        $this->assertInstanceOf('\AutoEscape\ViewValue\ArrayViewValue', $objInstance->array);
    }

    /**
     * @test
     * @dataProvider invalidTypes
     */
    public function notInitializeWhenInvalidTypeIsGiven($arg)
    {
        $this->constructorThrowExceptionBy($arg);
    }

    public function invalidTypes()
    {
        return [
            ['hoge'],
            [null],
            [true],
            [array()],
        ];
    }

    /**
     * @test
     */
    public function methodCallShouldBeEscaped()
    {
        $obj = new SampleObject();
        $obj->value = '<script>alert(0)</script>';
        $objInstance = $this->create($obj);
        $this->outputShouldBeSame(
            $this->_h('<script>alert(0)</script>'),
            $objInstance->callableMethod()
        );
    }

    /**
     * @test
     */
    public function throwBadMethodCallExceptionWhenUncallableMethodIsCalled()
    {
        $obj = new SampleObject();
        $objInstance = $this->create($obj);
        $this->setExpectedException('BadMethodCallException');
        $objInstance->unCallableMethod();
    }
}

class SampleObject
{

    public $value = '';

    public function callableMethod()
    {
        return $this->value;
    }

    protected function unCallableMethod()
    {
        return 'this is not callable method';
    }
}
