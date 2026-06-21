<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pedido extends Model
{
    protected $fillable = [
        'user_id',
        'vendedor_id',
        'codigo_pedido',
        'estado',
        'subtotal',
        'impuestos',
        'total',
        'direccion_envio',
        'telefono',
        'notas',
    ];

    protected $casts = [
        'subtotal' => 'decimal:2',
        'impuestos' => 'decimal:2',
        'total' => 'decimal:2',
    ];

    public function cliente(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function vendedor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'vendedor_id');
    }

    public function detalles(): HasMany
    {
        return $this->hasMany(PedidoDetalle::class, 'pedido_id');
    }

    public static function generateCodigo(): string
    {
        $date = now()->format('Ymd');
        $last = self::where('codigo_pedido', 'like', "PED-{$date}-%")
            ->orderByDesc('codigo_pedido')
            ->first();

        $sequence = 1;
        if ($last) {
            $sequence = (int) substr($last->codigo_pedido, -3) + 1;
        }

        return sprintf('PED-%s-%03d', $date, $sequence);
    }

    public function getEstadoLabelAttribute(): string
    {
        return match ($this->estado) {
            'pendiente' => 'Pendiente',
            'en_proceso' => 'En Proceso',
            'enviado' => 'Enviado',
            'entregado' => 'Entregado',
            'cancelado' => 'Cancelado',
            default => $this->estado,
        };
    }

    public function getEstadoColorAttribute(): string
    {
        return match ($this->estado) {
            'pendiente' => 'amber',
            'en_proceso' => 'blue',
            'enviado' => 'purple',
            'entregado' => 'green',
            'cancelado' => 'red',
            default => 'gray',
        };
    }
}
