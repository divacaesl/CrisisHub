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
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('jenis_bencana');
            $table->enum('tingkat_kerusakan', ['Rendah', 'Sedang', 'Tinggi', 'Hancur Total']);
            $table->integer('jumlah_korban')->default(0);
            
            // Priority Calculation Metrics
            $table->integer('infants_count')->default(0);
            $table->integer('elderly_count')->default(0);
            $table->integer('disabled_count')->default(0);
            $table->integer('family_members')->default(0);
            $table->boolean('logistic_stock_critical')->default(false);
            $table->integer('priority_score')->default(0); // 0-100

            $table->text('deskripsi_kondisi');
            $table->text('kebutuhan_mendesak')->nullable();
            $table->string('foto_path')->nullable();
            
            // Geolocation
            $table->decimal('latitude', 10, 8);
            $table->decimal('longitude', 11, 8);
            $table->decimal('accuracy', 10, 2)->nullable();
            $table->string('alamat_lengkap')->nullable();
            
            // Status & Verification
            $table->enum('status', ['Pending', 'Verified', 'In Progress', 'Resolved', 'Rejected'])->default('Pending');
            $table->boolean('flag_duplicate')->default(false);
            $table->foreignId('verified_by')->nullable()->constrained('users')->nullOnDelete();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};
