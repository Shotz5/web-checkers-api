<?php

namespace App\Support\Referee\Enums;

enum RefereeEnums: string
{
    case FRIENDLY_PIECE_ON_SPACE = 'Friendly piece on space';
    case INVALID_HORIZONTAL_MOVE = 'Invalid horizontal move';
    case INVALID_VERTICAL_MOVE = 'Invalid vertical move';
}
