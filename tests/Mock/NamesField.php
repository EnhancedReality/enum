<?php

namespace Tests\Unit\Mock;

use EnhancedReality\Enum\EnumField;

class NamesField extends EnumField
{
    function __construct(NameEnum ...$values)
    {
        $this->select(...$values);
    }
    
    public function select(NameEnum ...$values)
    {
        $this->selectEnum(...$values);
    }

    public function deselect(NameEnum ...$values)
    {
        $this->deselectEnum(...$values);
    }
    
    public function stringValues() : array
    {
        return [
            NameEnum::WIZARD => 'Gandalf',
            NameEnum::HOBBIT => 'Frodo',
            NameEnum::RANGER => 'Strider',
            NameEnum::DWARF => 'Gimli'
        ];
    }
}