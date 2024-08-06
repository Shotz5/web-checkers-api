<?php

namespace App\Http\Controllers;

use App\Support\Referee\Referee;

class PieceController extends Controller
{
    /**
     * Update the specified resource in storage.
     */
    public function update(Referee $referee)
    {
        if (!$referee->isValidMove()) {
            return response()->json(array_map(function ($violation) {
                return $violation->value;
            }, $referee->getViolations()), 400);
        }

        if (!$referee->savePieceCordinates()) {
            return response('Error saving piece to database', 500);
        }

        // Can safely assume piece is of other colour if it exists at this point
        if ($referee->getPieceOnSpace() !== null && !$referee->takePieceOnSpace()) {
            return response('Error updated taken piece', 500);
        }

        return response()->json($referee->getPiece()->toArray());
    }
}
