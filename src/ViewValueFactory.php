<?php

namespace AutoEscape;

use ViewValue\ArrayViewValue;
use ViewValue\StringViewValue;
use ViewValue\ObjectViewValue;

/**
 * ViewValueFactory
 */
class ViewValueFactory
{
    /**
     * create
     *
     * @param mixed $value
     * @return mixed
     */
    public static function create($value) {
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
