<?php

namespace App\Http\Controllers;

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
        return view('board');
    }

    /**
     * Create a new board
     */
    public function create()
    {
        $pieces = new Collection();
        $counter = 0;
        $colour = 'black';
        for ($y = 1; $y <= Board::$BOARD_HEIGHT; $y++) {
            for ($x = 1; $x <= Board::$BOARD_WIDTH; $x++) {

                if ($y > Board::$PLAYER_HEIGHT && $y <= (Board::$BOARD_HEIGHT - Board::$PLAYER_HEIGHT)) {
                    $colour = 'white';
                    continue;
                }

                if (($x + $y) % 2 == 0) {
                    $pieces[] = new Board([
                        'id' => $counter,
                        'colour' => $colour,
                        'x' => $x,
                        'y' => $y,
                    ]);
                    $counter += 1;
                }
            }
        }
        return response()->json($pieces);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBoardRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Board $board)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Board $board)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBoardRequest $request/*, Board $board*/)
    {
        return response()->json($request->toArray());
        // $board->fill($request->toArray());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Board $board)
    {
        //
    }
}
