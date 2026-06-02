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
        Schema::table('volunteer_applications', function (Blueprint $table) {
            $table->string('category')->nullable();
            $table->string('certification')->nullable();
            $table->string('cv_path')->nullable();
            $table->text('motivation')->nullable();
            $table->string('availability')->nullable(); // Waktu
            $table->string('assignment_area')->nullable(); // Area
            $table->string('emergency_contact_name')->nullable();
            $table->string('emergency_contact_relation')->nullable();
            $table->string('emergency_contact_phone')->nullable();
            $table->string('preferred_team')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('volunteer_applications', function (Blueprint $table) {
            $table->dropColumn([
                'category', 'certification', 'cv_path', 'motivation',
                'availability', 'assignment_area', 'emergency_contact_name',
                'emergency_contact_relation', 'emergency_contact_phone', 'preferred_team'
            ]);
        });
    }
};
