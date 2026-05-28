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
        Schema::create('donations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete(); // Nullable for anonymous
            $table->foreignId('campaign_id')->nullable()->constrained()->nullOnDelete();
            $table->enum('type', ['Uang', 'Barang']);
            $table->decimal('amount', 15, 2)->nullable();
            $table->text('items')->nullable(); // JSON or Text describing items
            $table->enum('status', ['Submitted', 'Verified', 'Processing', 'Shipped', 'Received'])->default('Submitted');
            $table->string('tracking_code')->unique();
            $table->timestamp('verified_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('donations');
    }
};
