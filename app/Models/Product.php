<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'name',
        'description',
        'price',
        'discount_price',
        'stock',
        'image',
        'is_active',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function cartItems()
    {
        return $this->hasMany(CartItem::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
    
    public static function monthlyChanged(){
        $lastMonth = Product::whereMonth('created_at', now()->subMonth()->month)->count();
        $thisMonth = Product::whereMonth('created_at', now()->month)->count();

        $change = $lastMonth > 0
        ? (($thisMonth - $lastMonth) / $lastMonth) * 100
        : 0;
        return $change;
    }
}
