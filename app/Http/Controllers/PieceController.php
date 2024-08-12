<?php

namespace App\Http\Controllers;

use App\Events\BoardUpdatedEvent;
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

        $referee->updatePieceCordinates();
        $referee->kingPiece();

        if (!$referee->savePiece()) {
            return response('Error occurred while updating piece', 500);
        }

        if (!$referee->updateTurn()) {
            return response('Error occurred while changing board turn', 500);
        }

        broadcast(new BoardUpdatedEvent($referee->getBoard()));

        return response()->json($referee->getPiece()->toArray());
    }
}
