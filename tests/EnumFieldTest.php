<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

use EnhancedReality\Enum\EnumField;
use Tests\Unit\Mock\{NameEnum,NamesField};

class EnumFieldTest extends TestCase
{
    public function test_it_can_toggle_options()
    {
        $names = new NamesField();
        $names->select(NameEnum::WIZARD(),NameEnum::HOBBIT(),NameEnum::DWARF());
        $this->assertEquals(['Gandalf','Frodo','Gimli'],$names->toArray());

        $names->deselect(NameEnum::HOBBIT());
        $this->assertEquals(['Gandalf','Gimli'],$names->toArray());
    }

    public function test_it_can_be_converted_to_array()
    {
        $names = new NamesField(NameEnum::RANGER(),NameEnum::HOBBIT());
        $this->assertEquals(['Frodo','Strider'],$names->toArray());
    }

    public function test_it_can_be_converted_to_string()
    {
        $names = new NamesField(NameEnum::RANGER(),NameEnum::HOBBIT());
        $this->assertEquals('Frodo,Strider',(string)$names);
    }
}
