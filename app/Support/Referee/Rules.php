<?php

namespace App\Support\Referee;

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
        // If there's a friendly piece on this spot
        if ($this->pieceOnSpace !== null && $this->pieceOnSpace->colour == $this->piece->colour) {
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
        if (abs($this->piece->x - $this->newX) !== 1) {
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
        if (!$this->piece->king) {
            if ($this->piece->colour === 'white' && ($this->piece->y - $this->newY) !== 1) {
                return RefereeEnums::INVALID_VERTICAL_MODE_NOT_KINGED;
            }

            if ($this->piece->colour === 'black' && ($this->newY - $this->piece->y) !== 1) {
                return RefereeEnums::INVALID_VERTICAL_MODE_NOT_KINGED;
            }
        }

        if ($this->piece->king && abs($this->newY - $this->piece->y) !== 1) {
            return RefereeEnums::INVALID_VERTICAL_MOVE;
        }

        return null;
    }
}
