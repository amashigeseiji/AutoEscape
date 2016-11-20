<?php

namespace AutoEscape\ViewValue;

abstract class ViewValue {

    protected $_value = null;

    protected $_type;

    /**
     * constructor
     *
     * @param mixed $value value
     * @throws LogicException
     */
    public function __construct($value) {
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
    protected static function _h($value) {
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
