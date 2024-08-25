<?php

namespace App\Http\Controllers;

use App\Models\Piece;
use App\Models\Board;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class BoardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // View to create a new game
    }

    /**
     * Create a new board
     */
    public function create(Request $request)
    {
        $users = $request->validate([
            'opponent' => ['required']
        ]);

        $host = Auth::user();
        $opponent = User::find($users['opponent']);

        if (!$opponent || !$host) {
            return response(null, 400)->json([
                "message" => "User not logged in or opponent not found"
            ]);
        }

        $board = new Board([
            "host" => $host->id,
            "opponent" => $opponent->id,
        ]);

        if (!$board->save()) {
            return response(null, 500)->json([
                "message" => "Unable to save board, server error. Halt and catch fire"
            ]);
        }

        $pieces = new Collection();
        $colour = 'black';
        for ($y = 1; $y <= Piece::$BOARD_HEIGHT; $y++) {
            for ($x = 1; $x <= Piece::$BOARD_WIDTH; $x++) {

                if ($y > Piece::$PLAYER_HEIGHT && $y <= (Piece::$BOARD_HEIGHT - Piece::$PLAYER_HEIGHT)) {
                    $colour = 'white';
                    continue;
                }

                if (($x + $y) % 2 == 0) {
                    $piece = new Piece([
                        'board_id' => $board->id,
                        'colour' => $colour,
                        'x' => $x,
                        'y' => $y,
                    ]);
                    $piece->save();
                    $pieces[] = $piece;
                }
            }
        }
        return response()->json([
            "board" => $board->id
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $board)
    {
        return view('board', ['pieces' => Piece::where('board_id', $board)->get()]);
    }
}
