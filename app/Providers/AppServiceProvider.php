<?php

namespace App\Providers;

use App\Http\Requests\UpdatePieceRequest;
use App\Models\Piece;
use Illuminate\Support\ServiceProvider;
use App\Support\Referee\Referee;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(Referee::class, function ($app) {
            $request = $app->make(UpdatePieceRequest::class);
            $piece = Piece::find($request->route('piece'));

            return new Referee($piece, $request->input('x'), $request->input('y'));
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
