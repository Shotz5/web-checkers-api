<?php

namespace App\Support\Referee\Enums;

enum RefereeEnums: string
{
    case FRIENDLY_PIECE_ON_SPACE = 'Friendly piece on space';
    case INVALID_HORIZONTAL_MOVE = 'Invalid horizontal move';
    case INVALID_VERTICAL_MOVE = 'Invalid vertical move';
    case INVALID_VERTICAL_MODE_NOT_KINGED = 'Invalid vertical move, piece is not kinged';
    case INVALID_DIRECTION_COUNTS = 'Invalid move, horizontal count does not equal vertical count';
    case INVALID_JUMP_DIRECTION = 'Invalid jump, did not move two in both directions';
    case INVALID_JUMP = 'Invalid jump, there is no piece to jump';
    case INVALID_JUMP_OWN_PIECE = 'Invalid jump, cannot jump your own piece';
}
