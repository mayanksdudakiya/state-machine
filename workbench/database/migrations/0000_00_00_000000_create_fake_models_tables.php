<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('fake_models', function (Blueprint $table) {
            $table->uuid('uuid')->unique();
            $table->string('order_status')->nullable();
            $table->float('delivery_fee')->nullable();
            $table->float('amount');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fake_models');
    }
};
