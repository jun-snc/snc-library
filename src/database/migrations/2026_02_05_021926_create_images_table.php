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
        Schema::create('images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('genre_id')->constrained('genres')->onUpdate('restrict')->onDelete('restrict');
            $table->text('memo')->nullable();
            $table->string('original_path');
            $table->string('display_path');
            $table->string('thumb_path');
            $table->string('original_name');
            $table->string('mime_type', 100);
            $table->unsignedInteger('width');
            $table->unsignedInteger('height');
            $table->timestamps();

            $table->index('genre_id');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('images');
    }
};
