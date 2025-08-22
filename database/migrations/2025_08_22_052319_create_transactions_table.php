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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('account_id')->constrained()->onDelete('cascade');
            $table->enum('type', ['deposit','withdrawal','transfer','swap','trade','investment']);
            $table->enum('method', ['crypto','paypal', 'bank',])->nullable();
            $table->decimal('amount', 32, 8);
            $table->string('currency');
            $table->enum('status', ['pending','completed','failed','cancelled'])->default('pending');
            $table->string('tx_hash')->nullable();     // blockchain hash
            $table->string('reference')->nullable();   // payment reference
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
