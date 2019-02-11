<?php

namespace EnhancedReality\Enum;

use MyCLabs\Enum\Enum;

abstract class EnumField
{
    private $field = 0;

    public function field() : int
    {
        return $this->field;
    }

    protected function selectEnum(Enum ...$values) 
    {
        foreach ($values as $enum) {
            $this->selectKey($enum->getValue());
        }
    }

    protected function deselectEnum(Enum ...$values) 
    {
        foreach ($values as $enum) {
            $this->deselectKey($enum->getValue());
        }
    }

    private function selectKey(int ...$values) 
    {
        foreach ($values as $value) {
            $this->field = $this->field | $value;
        }
    }

    private function deselectKey(int ...$values) 
    {
        foreach ($values as $value) {
            $this->field = $this->field & ~$value;
        }
    }

    public function isNull() : bool
    {
        return empty($this->field);
    }

    // Disable these for now
    // public function hasAllTheseSelections(Enum ...$values) : bool
    // {
    //     $enum = new BasementOptions(...$values);
    //     return ($this->field & $enum->field()) === $enum->field();
    // }

    // public function hasAnyOfTheseSelections(Enum ...$values) : bool
    // {
    //     $enum = new BasementOptions(...$values);
    //     return $this->field & $enum->field();
    // }

    public static function fromArray(array $values) : self
    {
        $instance = new static();
        $stringValues = $instance->stringValues();
        foreach ($values as $value) {
            $key = array_search(strtolower($value),array_map('strtolower', $stringValues));
            if ($key !== false) {
                $instance->selectKey($key);
            }
        }

        return $instance;
    }

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