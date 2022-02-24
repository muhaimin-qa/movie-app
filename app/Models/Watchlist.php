<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Watchlist extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'movie_id',
        'name',
        'is_watched',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

}
