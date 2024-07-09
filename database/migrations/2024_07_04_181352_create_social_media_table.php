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
        Schema::create('social_media', function (Blueprint $table) {
            $table->id();
            $table->string('photo')->nullable();
            $table->decimal('price', 8, 2)->nullable();
            $table->string('price_description')->nullable();
            $table->text('description')->nullable();
            $table->string('status')->nullable();
            $table->integer('visites_minimum')->default(100);
            $table->text('url_description')->nullable();
            $table->text('speed_description')->nullable();
            $table->string('name');
            $table->string('photo_description')->nullable();
            $table->integer('minimum_order')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('social_media');
    }
};
