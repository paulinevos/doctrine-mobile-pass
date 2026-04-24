<?php

namespace Vos\DoctrineMobilePass\Enums;

enum TimeStyleType: string
{
    case None = 'PKDateStyleNone';
    case Short = 'PKDateStyleShort';
    case Medium = 'PKDateStyleMedium';
    case Long = 'PKDateStyleLong';
    case Full = 'PKDateStyleFull';
}
