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
        Schema::create('fees', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['deposit','withdrawal','trade','investment']);
            $table->decimal('percentage', 5, 2)->default(0); // e.g., 0.5%
            $table->decimal('fixed', 32, 8)->default(0);     // e.g., $1 fixed fee
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fees');
    }
};
