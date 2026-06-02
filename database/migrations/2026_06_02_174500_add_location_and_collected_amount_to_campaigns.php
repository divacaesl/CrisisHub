<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('campaigns', function (Blueprint $table) {
            if (!Schema::hasColumn('campaigns', 'location')) {
                $table->string('location')->default('Indonesia');
            }
            if (!Schema::hasColumn('campaigns', 'collected_amount')) {
                $table->decimal('collected_amount', 15, 2)->default(0);
            }
            if (!Schema::hasColumn('campaigns', 'deadline')) {
                $table->date('deadline')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('campaigns', function (Blueprint $table) {
            if (Schema::hasColumn('campaigns', 'location')) {
                $table->dropColumn('location');
            }
            if (Schema::hasColumn('campaigns', 'collected_amount')) {
                $table->dropColumn('collected_amount');
            }
            if (Schema::hasColumn('campaigns', 'deadline')) {
                $table->dropColumn('deadline');
            }
        });
    }
};
