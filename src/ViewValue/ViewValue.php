<?php

namespace AutoEscape\ViewValue;

abstract class ViewValue {

    protected $_value = null;

    protected $_type;

    protected $callback;

    /**
     * constructor
     *
     * @param mixed $value value
     * @throws LogicException
     */
    public function __construct($value, $callback) {
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
    public static function _h($value) {
        return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
    }

    /**
     * raw
     *
     * @return mixed raw value
     */
    public function raw() {
        return $this->_value;
    }
}
