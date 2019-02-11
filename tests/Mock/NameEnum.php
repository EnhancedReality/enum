<?php

namespace Tests\Unit\Mock;

use MyCLabs\Enum\Enum;

class NameEnum extends Enum
{
    const WIZARD = 0x1;
    const HOBBIT = 0x2;
    const RANGER = 0x4;
    const DWARF = 0x8;
    const ELF = 0x10;
}