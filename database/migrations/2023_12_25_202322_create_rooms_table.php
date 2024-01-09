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
        Schema::create('rooms', function (Blueprint $table) {
             $table->id();
            $table->string('images')->nullable();
            $table->unsignedbiginteger('adults');
            $table->unsignedbiginteger('children');
            $table->integer('is_booked')->default(0);
            $table->foreignId('hotel_id')->constrained();
             $table->double('price');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rooms');
    }
};
