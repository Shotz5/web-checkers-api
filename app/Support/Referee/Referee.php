<?php

namespace App\Support\Referee;

use App\Models\Board;
use App\Models\Piece;
use App\Support\Referee\Rules;

class Referee
{
    use Rules;

    public Board $board;
    public Piece $piece;
    public ?Piece $takenPiece;
    public ?Piece $pieceOnSpace;
    private int $newX;
    private int $newY;
    private int $xNumJumped;
    private int $yNumJumped;

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

        $this->xNumJumped = $this->piece->x - $this->newX;
        $this->yNumJumped = $this->piece->y - $this->newY;

        $this->board = Board::find($this->piece->board_id);

        $this->takenPiece = Piece::where('board_id', $this->piece->board_id)
            ->where('x', ($this->newX + ($this->xNumJumped / 2)))
            ->where('y', ($this->newY + ($this->yNumJumped / 2)))
            ->where('taken', false)
            ->first();

        $this->pieceOnSpace = Piece::where('board_id', $this->piece->board_id)
            ->where('x', $this->newX)
            ->where('y', $this->newY)
            ->where('taken', false)
            ->first();
    }

    public function getViolations(): array
    {
        return $this->violations;
    }

    public function getPiece(): Piece
    {
        return $this->piece;
    }

    public function getBoard(): Board
    {
        return $this->board;
    }

    public function getPieceOnSpace(): ?Piece
    {
        return $this->pieceOnSpace;
    }

    public function getJumpedPiece(): ?Piece
    {
        return $this->jumpedPiece;
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
