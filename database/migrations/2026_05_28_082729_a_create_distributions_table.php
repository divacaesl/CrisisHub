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
        if (!Schema::hasTable('distributions')) {
            Schema::create('distributions', function (Blueprint $table) {
                $table->id();
                $table->foreignId('donation_id')->nullable()->constrained()->nullOnDelete();
                $table->foreignId('volunteer_id')->nullable()->constrained('users')->nullOnDelete();
                $table->foreignId('report_id')->constrained()->cascadeOnDelete();
                $table->enum('status', ['Diproses', 'Disiapkan', 'Dikirim', 'Di Lokasi', 'Diterima'])->default('Diproses');
                $table->text('qr_code')->nullable(); // JSON encoded with signature hash
                $table->timestamp('dispatched_at')->nullable();
                $table->timestamp('delivered_at')->nullable();
                $table->timestamp('received_at')->nullable();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('distributions');
    }
};
