<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('use_addresses', function (Blueprint $table) {
            $table->id();
            $table->string('type', 45);
            $table->string('address1', 45);
            $table->string('address2', 45)->nullable();
            $table->string('city', 45);
            $table->string('zipcode', 45);
            $table->string('country_code', 3);
            $table->string('province', 45);
            $table->string('country', 45);
            $table->string('ismain')->default(1);
            $table->foreignId('user_id')->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('use_addresses');
    }
};
