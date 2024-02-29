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
        Schema::create('logs', function (Blueprint $table) {
            $table->id();
            $table->string('type');
            $table->text('message');
            $table->json('before')->nullable();
            $table->json('after')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->morphs('loggable');
            $table->timestamps();
            $table->foreign('created_by')->references('id')->on('users');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('logs');
    }
};
