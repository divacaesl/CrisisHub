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
        Schema::table('reports', function (Blueprint $table) {
            if (!Schema::hasColumn('reports', 'status')) {
                $table->string('status')->default('Pending')->after('id');
            }
            if (!Schema::hasColumn('reports', 'admin_notes')) {
                $table->text('admin_notes')->nullable()->after('status');
            }
            if (!Schema::hasColumn('reports', 'verified_by')) {
                $table->unsignedBigInteger('verified_by')->nullable()->after('admin_notes');
            }
        });
    }

    public function down(): void
    {
        Schema::table('reports', function (Blueprint $table) {
            $table->dropColumnIfExists(['status', 'admin_notes', 'verified_by']);
        });
    }
};
