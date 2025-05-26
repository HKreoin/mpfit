<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'cusromer_name',
        'product_id',
        'quantity',
        'total_price',
        'status',
        'comment',
    ];

    protected $casts = [
        'quantity' => 'integer',
        'total_price' => 'decimal:2',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function ($order) {
            $product = Product::find($order->product_id);
            $order->total_price = $product->price * $order->quantity;
        });

        static::updating(function ($order) {
            if ($order->isDirty(['product_id', 'quantity'])) {
                $product = Product::find($order->product_id);
                $order->total_price = $product->price * $order->quantity;
            }
        });
    }
}
