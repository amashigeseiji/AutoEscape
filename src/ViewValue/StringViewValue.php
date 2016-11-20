<?php

namespace AutoEscape\ViewValue;

class StringViewValue extends ViewValue {

    protected $_type = 'string';

    protected $_clean = null;

    /**
     * __toString magic method
     *
     * StringViewValue class returns sanitized string value by default.
     *
     * @return string sanitized value
     */
    public function __toString() {
        if (!$this->_clean) {
            $this->_clean = call_user_func($this->callback, $this->_value);
        }
        return $this->_clean;
    }
}
