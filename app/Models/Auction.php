<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Auction extends Model
{
    protected $fillable = [
        'title',
        'description',
        'category_id',
        'buy_now',
        'buy_now_price',
        'auction_length',
        'image_path',
        'starting_price',
        'user_id',
        'tags_id',
    ];
    protected $casts = [
        'address' => 'json'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(Image::class);
    }
}
