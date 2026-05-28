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
        Schema::create('victim_needs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('report_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete(); // The reporter
            $table->string('category'); // Pangan, Kesehatan, Sandang, dll
            $table->string('item_name');
            $table->integer('quantity');
            $table->tinyInteger('urgency_level')->default(2); // 1=Sangat Mendesak, 2=Mendesak, 3=Perlu, 4=Opsional
            $table->enum('status', ['Pending', 'Allocated', 'Delivered', 'Received'])->default('Pending');
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('victim_needs');
    }
};
