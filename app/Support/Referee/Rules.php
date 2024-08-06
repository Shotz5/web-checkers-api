<?php

namespace App\Support\Referee;

use App\Models\Piece;
use App\Support\Referee\Enums\RefereeEnums;

trait Rules
{
    /**
     * Can't move onto a space already occupied by yourself
     *
     * @return ?RefereeEnums
     */
    private function friendlyPiecesOnSpace(): ?RefereeEnums
    {
        $friendlyPieces = Piece::where('board_id', $this->piece->boardId)
            ->where('colour', $this->piece->colour)
            ->where('x', $this->newX)
            ->where('y', $this->newY)
            ->count();

        // If there's a friendly piece on this spot
        if ($friendlyPieces !== 0)
        {
            return RefereeEnums::FRIENDLY_PIECE_ON_SPACE;
        }

        return null;
    }

    /**
     * If move is more than two horizontally, invalid
     *
     * @return ?RefereeEnums
     */
    public function isValidHorizontalMove(): ?RefereeEnums
    {
        if (abs($this->piece->x - $this->newX) != 1)
        {
            return RefereeEnums::INVALID_HORIZONTAL_MOVE;
        }

        return null;
    }

    /**
     * If move is more than two vertically, invalid
     *
     * @return ?RefereeEnums
     */
    public function isValidVerticalMove(): ?RefereeEnums
    {
        if (abs($this->piece->y - $this->newY) != 1)
        {
            return RefereeEnums::INVALID_VERTICAL_MOVE;
        }

        return null;
    }
}
