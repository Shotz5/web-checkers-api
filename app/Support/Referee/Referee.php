<?php

namespace App\Support\Referee;

use App\Models\Piece;
use App\Support\Referee\Rules;

class Referee
{
    use Rules;

    private Piece $piece;
    private ?Piece $pieceOnSpace;
    private int $newX;
    private int $newY;

    private array $rules = [
        'friendlyPiecesOnSpace',
        'isValidHorizontalMove',
        'isValidVerticalMove',
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
     * Update the pieces coordinates to the new coords in the database
     *
     * @return bool
     */
    public function savePieceCordinates(): bool
    {
        $this->piece->x = $this->newX;
        $this->piece->y = $this->newY;

        return $this->piece->save();
    }

    /**
     * Take piece on the space
     *
     * @return bool
     */
    public function takePieceOnSpace(): bool
    {
        $this->pieceOnSpace->taken = true;
        return $this->pieceOnSpace->save();
    }
}
