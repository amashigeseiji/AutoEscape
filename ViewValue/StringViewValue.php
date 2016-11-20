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
        return $this->clean();
    }

    /**
     * clean
     *
     * sanitize given value
     *
     * @return string sanitized value
     */
    public function clean() {
        if (!$this->_clean) {
            $this->_clean = $this->_h($this->_value);
        }
        return $this->_clean;
    }
}
