<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CarritoItem extends Model
{
    protected $fillable = [
        'user_id',
        'producto_id',
        'cantidad',
        'precio_unitario',
    ];

    protected $casts = [
        'precio_unitario' => 'decimal:2',
        'cantidad' => 'integer',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function producto(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'producto_id');
    }

    public function getSubtotalAttribute(): float
    {
        return $this->cantidad * $this->precio_unitario;
    }
}
