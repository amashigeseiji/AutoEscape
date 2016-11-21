<?php

require_once('ViewValueTestCase.php');

use \AutoEscape\ViewValue;
use \AutoEscape\ViewValue\StringViewValue;

class StringViewValueTest extends ViewValueTestCase
{

    public $className = '\AutoEscape\ViewValue\StringViewValue';

    /**
     * @test
     */
    public function expectString()
    {
        $this->outputShouldBeSame(
            'hoge',
            $this->create('hoge')
        );
    }

    /**
     * @test
     */
    public function stringShouldBeEscaped()
    {
        $this->outputShouldBeSame(
            $this->_h('<script>alert(0)</script>'),
            $this->create('<script>alert(0)</script>')
        );
    }

    /**
     * @test
     */
    public function stringViewValueHasRawMethod()
    {
        $this->assertTrue(method_exists($this->create('hoge'), 'raw'));
    }

    /**
     * @test
     */
    public function stringShouldBeSameToStringViewValue()
    {
        $string1 = $this->create('<script>alert(0)</script>');
        $this->assertEquals($this->_h('<script>alert(0)</script>'), $string1);
    }

    /**
     * @test
     */
    public function stringShouldBeSameToRawValue()
    {
        $string1 = $this->create('<script>alert(0)</script>');
        $this->assertEquals('<script>alert(0)</script>', $string1->raw());
    }
}
