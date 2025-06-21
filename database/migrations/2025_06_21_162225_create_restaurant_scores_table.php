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
        Schema::create('restaurant_scores', function (Blueprint $table) {
            $table->id('restaurant_id');
            $table->float('score')->default(0.0);
            $table->integer('bans')->default(0);
            $table->boolean('outdated')->default(false);
            $table->timestamp('updated_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('restaurant_scores');
    }
};
