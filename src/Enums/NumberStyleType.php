<?php

namespace Vos\DoctrineMobilePass\Enums;

enum NumberStyleType: string
{
    case Decimal = 'PKNumberStyleDecimal';
    case Percent = 'PKNumberStylePercent';
    case Scientific = 'PKNumberStyleScientific';
    case SpellOut = 'PKNumberStyleSpellOut';
}
