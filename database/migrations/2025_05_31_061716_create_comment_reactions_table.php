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
        Schema::create('comment_reactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('comment_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('reaction_id');
            $table->timestamps();

            $table->foreign('comment_id')->references('id')->on('comments');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('reaction_id')->references('id')->on('reactions');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comment_reactions');
    }
};
