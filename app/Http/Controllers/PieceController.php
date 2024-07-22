<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePieceRequest;
use App\Http\Requests\UpdatePieceRequest;
use App\Models\Piece;

class PieceController extends Controller
{
    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePieceRequest $request, Piece $piece)
    {
        $piece->fill($request->toArray());
        $piece->save();
        return response()->json($piece);
    }

    // /**
    //  * Store a newly created resource in storage.
    //  */
    // public function store(StorePieceRequest $request)
    // {
    //     //
    // }

    // /**
    //  * Display the specified resource.
    //  */
    // public function show(Piece $piece)
    // {
    //     //
    // }

    // /**
    //  * Show the form for editing the specified resource.
    //  */
    // public function edit(Piece $piece)
    // {
    //     //
    // }

    // /**
    //  * Remove the specified resource from storage.
    //  */
    // public function destroy(Piece $piece)
    // {
    //     //
    // }
}
