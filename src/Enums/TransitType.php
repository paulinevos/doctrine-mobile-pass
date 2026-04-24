<?php

namespace Vos\DoctrineMobilePass\Enums;

enum TransitType: string
{
    case Air = 'PKTransitTypeAir';
    case Boat = 'PKTransitTypeBoat';
    case Bus = 'PKTransitTypeBus';
    case Generic = 'PKTransitTypeGeneric';
    case Train = 'PKTransitTypeTrain';
}
