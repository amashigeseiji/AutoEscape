<?php

use PHPUnit\Framework\TestCase;

class ViewValueTestCase extends TestCase
{
    protected $className = '';

    public function create($arg)
    {
        return new $this->className($arg);
    }

    protected function _h($val)
    {
        return htmlspecialchars($val, ENT_QUOTES, 'UTF-8');
    }

    public function outputShouldBeSame($string1, $string2)
    {
        $this->expectOutputString($string1);
        echo $string2;
    }

    protected function constructorThrowExceptionBy($arg)
    {
        $this->setExpectedException('\LogicException');
        $this->create($arg);
    }
}
