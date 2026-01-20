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
        'barcode',
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

    public function getEffectivePriceAttribute()
    {
        if ($this->discount_price !== null && $this->discount_price < $this->price) {
            return $this->discount_price;
        }

        return $this->price;
    }

    //for sold out badge
    public function getIsSoldOutAttribute(){
        return $this->is_active == 0;
    }
}
