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

    public function test_it_can_be_created_from_array()
    {
        $array = ['Frodo','Strider','Gimli','Saruman'];
        $names = NamesField::fromArray($array);

        // No Saruman because his name is not one of NameEnum values
        $this->assertEquals(['Frodo','Strider','Gimli'],$names->toArray());
    }

    public function test_it_can_check_for_all_given_selections()
    {
        $names = new NamesField(NameEnum::WIZARD(),NameEnum::RANGER(),NameEnum::HOBBIT());

        $this->assertTrue($names->hasAll(NameEnum::WIZARD(),NameEnum::HOBBIT()));
        $this->assertFalse($names->hasAll(NameEnum::DWARF(),NameEnum::HOBBIT(),NameEnum::WIZARD()));
    }

    public function test_it_can_check_for_any_given_selections()
    {
        $names = new NamesField(NameEnum::WIZARD(),NameEnum::RANGER(),NameEnum::HOBBIT());

        $this->assertTrue($names->hasAny(NameEnum::DWARF(),NameEnum::HOBBIT(),NameEnum::WIZARD()));
        $this->assertFalse($names->hasAny(NameEnum::DWARF(),NameEnum::ELF()));
    }

    public function test_it_can_check_if_it_is_empty()
    {
        $names = new NamesField();
        $this->assertTrue($names->isEmpty());
        $names->select(NameEnum::DWARF());
        $this->assertFalse($names->isEmpty());
    }

    public function test_it_can_be_converted_to_json()
    {
        $names = new NamesField(NameEnum::WIZARD(),NameEnum::RANGER(),NameEnum::HOBBIT());
        $this->assertEquals('["Gandalf","Frodo","Strider"]',json_encode($names));
    }
}
