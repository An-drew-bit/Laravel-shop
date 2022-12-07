<?php

use Domain\Order\Enums\OrderStatus;
use Domain\Order\Models\DeliveryType;
use Domain\Order\Models\PaymentMethod;
use Domain\User\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();

            $table->enum('status', array_column(OrderStatus::cases(), 'value'))
                ->default('new');

            $table->foreignIdFor(User::class)
                ->nullable()
                ->constrained()
                ->nullOnDelete()
                ->cascadeOnUpdate();

            $table->foreignIdFor(DeliveryType::class)
                ->constrained();

            $table->foreignIdFor(PaymentMethod::class)
                ->constrained();

            $table->unsignedInteger('amount')
                ->default(0);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        if (app()->isLocal()) {
            Schema::dropIfExists('orders');
        }
    }
};
