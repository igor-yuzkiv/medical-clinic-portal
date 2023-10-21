<?php

namespace App\Abstractions\DTO;

use Illuminate\Contracts\Support\Arrayable;

abstract class DataTransferObject implements Arrayable
{
    /**
     * @param array $data
     * @return static
     */
    public static function of(array $data): static
    {
        $static = new static();

        foreach ($data as $property => $value) {
            if (property_exists($static, $property)) {
                $static->$property = $value;
            }
        }

        return $static;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return get_object_vars($this);
    }
}
