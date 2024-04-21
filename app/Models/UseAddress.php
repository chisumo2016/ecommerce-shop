<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UseAddress extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'address1',
        'address2',
        'type',
        'zipcode',
        'city',
        'province',
        'country_code',
        'country',
        'ismain'
    ];

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
