<?php

require_once('ViewValueTestCase.php');

use \AutoEscape\ViewValue;
use \AutoEscape\ViewValue\ArrayViewValue;

class ArrayViewValueTest extends ViewValueTestCase
{

    protected $className = '\AutoEscape\ViewValue\ArrayViewValue';

    /**
     * @test
     */
    public function arrayViewValueHasRawMethod()
    {
        $array = ['string'];
        $this->assertTrue(method_exists($this->create($array), 'raw'));
    }

    /**
     * @test
     */
    public function rawValueIsArray()
    {
        $array = ['string'];
        $this->assertTrue(gettype($this->create($array)->raw()) === 'array');
    }

    /**
     * @test
     */
    public function arrayViewValueActAsArrayByOffsetGet()
    {
        $array = ['string', 1];
        $arrayInstance = $this->create($array);
        $this->assertEquals($arrayInstance[0], 'string');
        $this->assertEquals($arrayInstance[1], 1);
    }

    /**
     * @test
     */
    public function canIterate()
    {
        $array = ['hoge', '<script>alert(0)</script>', 0];
        $arrayInstance = $this->create($array);
        foreach ($arrayInstance as $key => $value) {
            if ($key === 0) {
                $this->assertEquals('hoge', $value);
            } elseif ($key === 1) {
                $this->assertEquals($this->_h('<script>alert(0)</script>'), $value);
            } elseif ($key === 0) {
                $this->assertEquals(0, $value);
            }
        }
    }

    /**
     * @test
     */
    public function canCount()
    {
        $array = ['hoge', '<script>alert(0)</script>', 0];
        $arrayInstance = $this->create($array);
        $this->assertEquals(3, count($arrayInstance));
    }

    /**
     * @test
     */
    public function stringInArrayViewValueIsStringViewValue()
    {
        $array = ['hoge'];
        $arrayInstance = $this->create($array);
        $this->assertInstanceOf('\AutoEscape\ViewValue\StringViewValue', $arrayInstance[0]);
    }

    /**
     * @test
     */
    public function nestedArrayIsArrayViewValue()
    {
        $array = [['hoge']];
        $arrayInstance = $this->create($array);
        $this->assertInstanceOf('\AutoEscape\ViewValue\ArrayViewValue', $arrayInstance[0]);
    }

    /**
     * @test
     */
    public function stringInArrayViewValueShouldBeEscaped()
    {
        $array = ['<script>alert(0)</script>'];
        $arrayInstance = $this->create($array);
        $this->outputShouldBeSame(
            $this->_h('<script>alert(0)</script>'),
            $arrayInstance[0]
        );
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
            [new stdClass],
        ];
    }
}
