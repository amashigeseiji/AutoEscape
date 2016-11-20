<?php

namespace AutoEscape\ViewValue;

use \AutoEscape\ViewValueFactory;

/**
 * ObjectViewValue
 *
 * @see ViewValue
 */
class ObjectViewValue extends ViewValue
{

    protected $_type = 'object';

    /**
     * __get magic method
     *
     * @param string $key object property
     * @return mixed
     */
    public function __get($key)
    {
        return ViewValueFactory::create($this->_value->$key);
    }

    /**
     * __call magic method
     *
     * @param string $name method name
     * @param array $args method arguments
     * @return mixed
     */
    public function __call($name, $args = null)
    {
        return ViewValueFactory::create(call_user_func_array([$this->_value, $name], $args));
    }
}
