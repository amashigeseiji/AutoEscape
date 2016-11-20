<?php

namespace AutoEscape;

use ViewValue\ArrayViewValue;
use ViewValue\StringViewValue;
use ViewValue\ObjectViewValue;

/**
 * ViewValueFactory
 */
abstract class ViewValue
{
    protected $_value = null;

    protected $_type;

    protected static $callback = [self, '_h'];

    /**
     * constructor
     *
     * @param mixed $value value
     * @throws LogicException
     */
    public function __construct($value)
    {
        if (gettype($value) !== $this->_type) {
            throw new \LogicException('type is not expected.');
        }
        $this->_value = $value;
    }

    /**
     * _h
     *
     * sanitize given value
     *
     * @param string $value this method allow only string value
     * @return string sanitized
     */
    public static function _h($value)
    {
        return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
    }

    /**
     * raw
     *
     * @return mixed raw value
     */
    public function raw()
    {
        return $this->_value;
    }

    /**
     * setCallback
     *
     * @param callable $callback
     */
    public static function setCallback($callback)
    {
        if (is_callable($callback, true, $callable)) {
            self::$callback = $callable;
        }
    }

    /**
     * create
     *
     * @param mixed $value
     * @return mixed
     */
    public static function factory($value)
    {
        if ($value instanceof ViewValue) {
            return $value;
        }

        $type = gettype($value);
        $file = __DIR__ . '/ViewValue/' . ucfirst($type) . 'ViewValue.php';
        if (!empty($value) && file_exists($file)) {
            $className = '\AutoEscape\ViewValue\\' . ucfirst($type) . 'ViewValue';
            return new $className($value);
        }

        return $value;
    }
}
