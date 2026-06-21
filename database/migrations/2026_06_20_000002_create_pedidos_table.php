<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pedidos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('vendedor_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('codigo_pedido')->unique();
            $table->enum('estado', ['pendiente', 'en_proceso', 'enviado', 'entregado', 'cancelado'])->default('pendiente');
            $table->decimal('subtotal', 12, 2);
            $table->decimal('impuestos', 12, 2);
            $table->decimal('total', 12, 2);
            $table->string('direccion_envio');
            $table->string('telefono');
            $table->text('notas')->nullable();
            $table->timestamps();

            $table->index(['user_id', 'estado']);
            $table->index(['vendedor_id', 'estado']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pedidos');
    }
};
