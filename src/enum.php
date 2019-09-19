<?php

namespace divengine;

/**
 * [[]] Div PHP Enum Solution
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation.
 *
 * This program is distributed in the hope that it will be useful, but
 * WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY
 * or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License
 * for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program as the file LICENSE.txt; if not, please see
 * https://www.gnu.org/licenses/gpl-3.0.txt
 *
 * @package divengine/enum
 * @author  Rafa Rodriguez @rafageist [https://rafageist.github.io]
 * @version 1.0.1
 *
 * @link    https://divengine.com/enum
 * @link    https://github.com/divengine/enum
 * @link    https://github.com/divengine/enum/wiki
 */

abstract class enum
{
    /** @var string */
    static private $__version = '1.0.1';

    /** @var mixed */
    public $value;

    /**
     * Version
     *
     * @return string
     */
    public static function getVersion() {
        return self::$__version;
    }

    /**
     * Return new instance
     *
     * @return mixed
     */
    public static function instance() {
        $className = static::class;
        return new $className();
    }

    /**
     * Value of the instance
     *
     * @return string
     */
    public function getValue()
    {
        if ($this->value === null) {
            // by default, the is the class name value !!
            return static::class;
        }

        return $this->value;
    }

    /** Convert to string
     *
     * @return string
     */
    public function __toString()
    {
        return (string)$this->getValue();
    }
}