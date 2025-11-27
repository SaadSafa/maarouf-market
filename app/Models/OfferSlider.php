<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OfferSlider extends Model
{
    use HasFactory;

    protected $fillable = [
        'image',
        'title',
        'description',
        'is_active',
    ];
}
