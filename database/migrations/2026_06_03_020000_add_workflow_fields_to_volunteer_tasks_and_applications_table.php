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
        if (!Schema::hasColumn('volunteer_applications', 'availability_status')) {
            Schema::table('volunteer_applications', function (Blueprint $table) {
                $table->string('availability_status')->default('Siap Bertugas');
            });
        }

        Schema::table('volunteer_tasks', function (Blueprint $table) {
            if (!Schema::hasColumn('volunteer_tasks', 'task')) {
                $table->text('task')->nullable();
            }
            if (!Schema::hasColumn('volunteer_tasks', 'started_at')) {
                $table->timestamp('started_at')->nullable();
            }
            if (!Schema::hasColumn('volunteer_tasks', 'checkin_at')) {
                $table->timestamp('checkin_at')->nullable();
            }
            if (!Schema::hasColumn('volunteer_tasks', 'checkin_lat')) {
                $table->decimal('checkin_lat', 10, 8)->nullable();
            }
            if (!Schema::hasColumn('volunteer_tasks', 'checkin_lng')) {
                $table->decimal('checkin_lng', 11, 8)->nullable();
            }
            if (!Schema::hasColumn('volunteer_tasks', 'progress_percent')) {
                $table->integer('progress_percent')->default(0);
            }
            if (!Schema::hasColumn('volunteer_tasks', 'progress_notes')) {
                $table->text('progress_notes')->nullable();
            }
            if (!Schema::hasColumn('volunteer_tasks', 'aid_delivered_qty')) {
                $table->integer('aid_delivered_qty')->default(0);
            }
            if (!Schema::hasColumn('volunteer_tasks', 'victims_helped')) {
                $table->integer('victims_helped')->default(0);
            }
            if (!Schema::hasColumn('volunteer_tasks', 'verification_photo')) {
                $table->string('verification_photo')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('volunteer_applications', function (Blueprint $table) {
            if (Schema::hasColumn('volunteer_applications', 'availability_status')) {
                $table->dropColumn('availability_status');
            }
        });

        Schema::table('volunteer_tasks', function (Blueprint $table) {
            $table->dropColumn([
                'started_at', 'checkin_at', 'checkin_lat', 'checkin_lng',
                'progress_percent', 'progress_notes', 'aid_delivered_qty',
                'victims_helped', 'verification_photo'
            ]);
        });
    }
};
