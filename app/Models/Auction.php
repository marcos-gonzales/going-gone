<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Auction extends Model
{
    protected $fillable = [
        'title',
        'description',
        'category_id',
        'buy_now',
        'auction_length',
        'image_path',
        'starting_price',
        'buy_now_price',
        'user_id',
        'tags_id',
    ];

    protected $casts = [
        'address' => 'json'
    ];
}
