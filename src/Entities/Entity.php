<?php

namespace Conkal\OwncloudProvisioningApi\Entities;

abstract class Entity
{
    public function toArray()
    {
        $array = [];
        foreach ($this as $key => $value) {
            // Skip if the key is not in the attributes array
            if (empty($value)) {
                continue;
            }
            $array[$key] = $value;
        }
        return $array;
    }

    public function fill($data)
    {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->{$key} = $value;
            }
        }
        return $this;
    }
}