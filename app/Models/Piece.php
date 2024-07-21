<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Piece extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'colour',
        'x',
        'y'
    ];

    public static $BOARD_WIDTH = 8;
    public static $BOARD_HEIGHT = 8;
    public static $PLAYER_HEIGHT = 3;
    public static $MIDDLE_SKIP = 2;
    public static $COLOURS = ['black', 'white'];
}
