<?php

namespace App\Support\Referee;

use App\Models\Board;
use App\Models\Piece;
use App\Support\Referee\Rules;

class Referee
{
    use Rules;

    private Board $board;
    private Piece $piece;
    private ?Piece $pieceOnSpace;
    private int $newX;
    private int $newY;

    private array $rules = [
        'isTurn',
        'pieceOnSpace',
        'isValidHorizontalMove',
        'isValidVerticalMove',
        'verticalCountEqualsHorizontalCount',
        'isValidJump',
    ];

    private array $violations = [];

    public function __construct(Piece $piece, int $newX, int $newY)
    {
        $this->piece = $piece;
        $this->newX = $newX;
        $this->newY = $newY;

        $this->pieceOnSpace = Piece::where('board_id', $this->piece->board_id)
            ->where('x', $this->newX)
            ->where('y', $this->newY)
            ->where('taken', false)
            ->first();

        $this->board = Board::find($this->piece->board_id);
    }

    public function getViolations(): array
    {
        return $this->violations;
    }

    public function getPiece(): Piece
    {
        return $this->piece;
    }

    public function getPieceOnSpace(): ?Piece
    {
        return $this->pieceOnSpace;
    }

    /**
     * Determines if the checkers move is valid
     *
     * @param  Piece $piece
     * @param  int   $newX
     * @param  int   $newY
     * @return bool
     */
    public function isValidMove(): bool
    {
        foreach ($this->rules as $rule) {
            $ruleCheck = $this->$rule();
            if ($ruleCheck !== null) {
                $this->violations[] = $ruleCheck;
            }
        }

        return empty($this->violations);
    }

    /**
     * Update the pieces coordinates to the new coords
     *
     * @return void
     */
    public function updatePieceCordinates(): void
    {
        $this->piece->x = $this->newX;
        $this->piece->y = $this->newY;
    }

    /**
     * King the piece if they're eligible
     *
     * @return void
     */
    public function kingPiece(): void
    {
        if ($this->piece->colour === "white" && $this->newY === 1 ||
            $this->piece->colour === "black" && $this->newY === 8
        ) {
            $this->piece->king = true;
        }
    }

    /**
     * Save all updates to the piece
     *
     * @return bool
     */
    public function savePiece(): bool
    {
        return $this->piece->save();
    }

    /**
     * Update the turn in the board
     *
     * @return bool
     */
    public function updateTurn(): bool
    {
        if ($this->board->turn === "white") {
            $this->board->turn = "black";
        } else {
            $this->board->turn = "white";
        }

        return $this->board->save();
    }
}
