<?php

namespace App\Http\Controllers;

use App\Models\Piece;
use App\Models\Board;
use App\Http\Requests\StoreBoardRequest;
use App\Http\Requests\UpdateBoardRequest;
use Illuminate\Database\Eloquent\Collection;

class BoardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Needs to be create board stuff
    }

    /**
     * Create a new board
     */
    public function create()
    {
        $board = new Board();
        $board->save();

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
        return response()->json($pieces);
    }

    // /**
    //  * Store a newly created resource in storage.
    //  */
    // public function store(StoreBoardRequest $request)
    // {
    //     //
    // }

    /**
     * Display the specified resource.
     */
    public function show(int $board)
    {
        return view('board', ['pieces' => Piece::where('board_id', $board)->get()]);
    }

    // /**
    //  * Update the specified resource in storage.
    //  */
    // public function update(UpdateBoardRequest $request/*, Board $board*/)
    // {
    //     return response()->json($request->toArray());
    //     // $board->fill($request->toArray());
    // }
}
