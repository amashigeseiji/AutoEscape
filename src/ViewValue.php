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

    protected $callback;

    /**
     * constructor
     *
     * @param mixed $value value
     * @throws LogicException
     */
    public function __construct($value, $callback)
    {
        if (gettype($value) !== $this->_type) {
            throw new \LogicException('type is not expected.');
        }
        $this->_value = $value;
        $this->callback = $callback;
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
     * create
     *
     * @param mixed $value
     * @return mixed
     */
    public static function factory($value, $escapeCallback = null)
    {
        if ($value instanceof ViewValue) {
            return $value;
        }

        $type = gettype($value);
        $file = __DIR__ . '/ViewValue/' . ucfirst($type) . 'ViewValue.php';
        if (!empty($value) && file_exists($file)) {
            $className = '\AutoEscape\ViewValue\\' . ucfirst($type) . 'ViewValue';
            $callback = is_callable($escapeCallback, true, $callable) ? $callable : [$className, '_h'];
            return new $className($value, $callback);
        }

        return $value;
    }
}
