<?php

namespace UTMS\Object;

class BaseObject
{
    /**
     * @param string $name
     *
     * @return mixed
     */
    public function __get($name)
    {
        if (property_exists($this, $name)) {
            return $this->{$name};
        }

        user_error('Undefined property: ' . get_class($this) . '::$' . $name);
        return null;
    }

    /**
     * @param string $name
     *
     * @return bool
     */
    public function __isset($name)
    {
        return isset($this->{$name});
    }
}