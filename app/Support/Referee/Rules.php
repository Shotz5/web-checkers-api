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
    private function pieceOnSpace(): ?RefereeEnums
    {
        // If there's a friendly piece on this spot
        if ($this->pieceOnSpace !== null) {
            return RefereeEnums::PIECE_ON_SPACE;
        }

        return null;
    }

    /**
     * If move is more than two horizontally, invalid
     *
     * @return ?RefereeEnums
     */
    private function isValidHorizontalMove(): ?RefereeEnums
    {
        $num_jumped = abs($this->piece->x - $this->newX);

        if ($num_jumped > 2 || $num_jumped == 0) {
            return RefereeEnums::INVALID_HORIZONTAL_MOVE;
        }

        return null;
    }

    /**
     * If move is more than two vertically, invalid
     *
     * @return ?RefereeEnums
     */
    private function isValidVerticalMove(): ?RefereeEnums
    {
        $num_jumped = $this->piece->y - $this->newY;

        if (abs($num_jumped) > 2 || $num_jumped == 0) {
            return RefereeEnums::INVALID_VERTICAL_MOVE;
        }

        // White must move up, which is a negative move
        if (!$this->piece->king &&
            (
                $this->piece->colour === 'white' && $num_jumped < 0 ||
                $this->piece->colour === 'black' && $num_jumped > 0
            )
        ) {
            return RefereeEnums::INVALID_VERTICAL_MODE_NOT_KINGED;
        }

        // King can move any direction
        if ($this->piece->king && abs($num_jumped) > 2) {
            return RefereeEnums::INVALID_VERTICAL_MOVE;
        }

        return null;
    }

    /**
     * Checks to make sure the vertical move count equals the horizontal move count
     *
     * @return ?RefereeEnums
     */
    private function verticalCountEqualsHorizontalCount(): ?RefereeEnums
    {
        $x_num_jumped = abs($this->piece->x - $this->newX);
        $y_num_jumped = abs($this->piece->y - $this->newY);

        if ($x_num_jumped != $y_num_jumped) {
            return RefereeEnums::INVALID_DIRECTION_COUNTS;
        }

        return null;
    }

    /**
     * Check to see if a piece was jumped
     *
     * @return ?RefereeEnums
     */
    private function isValidJump(): ?RefereeEnums
    {
        $x_num_jumped = $this->piece->x - $this->newX;
        $y_num_jumped = $this->piece->y - $this->newY;

        // Early return if not a jump attempt
        if (abs($x_num_jumped) == 1 && abs($y_num_jumped) == 1) {
            return null;
        }

        $jumped_piece = Piece::where('board_id', $this->piece->board_id)
            ->where('x', ($this->newX + ($x_num_jumped / 2)))
            ->where('y', ($this->newY + ($y_num_jumped / 2)))
            ->where('taken', false)
            ->first();

        if (!$jumped_piece) {
            return RefereeEnums::INVALID_JUMP;
        }

        if ($jumped_piece->colour === $this->piece->colour) {
            return RefereeEnums::INVALID_JUMP_OWN_PIECE;
        }

        $jumped_piece->taken = true;
        $jumped_piece->save();

        return null;
    }
}
