<?php

namespace EnhancedReality\Enum;

use MyCLabs\Enum\Enum;

abstract class EnumField
{
    private $field = 0;

    function __construct(Enum ...$values)
    {
        $this->select(...$values);
    }

    public function field() : int
    {
        return $this->field;
    }

    protected function selectEnum(Enum ...$values) 
    {
        foreach ($values as $enum) {
            $this->field = $this->field | $enum->getValue();
        }
    }

    public function isNull() : bool
    {
        return empty($this->field);
    }

    protected function deselectEnum(Enum ...$values) 
    {
        foreach ($values as $enum) {
            $this->field = $this->field & ~$enum->getValue();
        }
    }

    public function hasAllTheseSelections(Enum ...$values) : bool
    {
        $enum = new BasementOptions(...$values);
        return ($this->field & $enum->field()) === $enum->field();
    }

    public function hasAnyOfTheseSelections(Enum ...$values) : bool
    {
        $enum = new BasementOptions(...$values);
        return $this->field & $enum->field();
    }

    // public function selectByName(string ...$values)
    // {
    //     $descriptions = $this->descriptions();
    //     foreach ($values as $value) {
    //         $key = array_search(strtolower($value),array_map('strtolower', $descriptions));
    //         if ($key !== false) {
    //             $this->select($key);
    //         }
    //     }
    // }

    public abstract function stringValues() : array;

    function __toString()
    {
        return implode(',',$this->toArray());
    }

    public function toArray() : array
    {
        $descriptionStrings = [];

        foreach ($this->stringValues() as $bit => $description) {
            if ($this->field & $bit) array_push($descriptionStrings,$description);
        }

        return $descriptionStrings;
    }
}