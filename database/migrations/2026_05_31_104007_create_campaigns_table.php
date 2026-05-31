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
        if (!Schema::hasTable('campaigns')) {
            Schema::create('campaigns', function (Blueprint $table) {
                $table->id();
                $table->string('title');
                $table->string('emoji')->default('🆘');
                $table->string('location');
                $table->string('tag')->default('AKTIF');
                $table->string('tag_color')->default('blue');
                $table->text('description');
                $table->bigInteger('target_amount');
                $table->bigInteger('collected_amount')->default(0);
                $table->date('deadline');
                $table->boolean('is_active')->default(true);
                $table->timestamps();
            });
        } else {
            Schema::table('campaigns', function (Blueprint $table) {
                if (!Schema::hasColumn('campaigns', 'emoji')) $table->string('emoji')->default('🆘')->after('title');
                if (!Schema::hasColumn('campaigns', 'tag')) $table->string('tag')->default('AKTIF');
                if (!Schema::hasColumn('campaigns', 'tag_color')) $table->string('tag_color')->default('blue');
                if (!Schema::hasColumn('campaigns', 'is_active')) $table->boolean('is_active')->default(true);
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('campaigns');
    }
};
