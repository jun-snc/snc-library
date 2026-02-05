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
        // genres テーブルに library_type を追加
        Schema::table('genres', function (Blueprint $table) {
            $table->enum('library_type', ['graphic', 'spatial'])->default('graphic')->after('id');
            $table->dropUnique(['name']);
            $table->unique(['library_type', 'name']);
            $table->index('library_type');
        });

        // tags テーブルに library_type を追加
        Schema::table('tags', function (Blueprint $table) {
            $table->enum('library_type', ['graphic', 'spatial'])->default('graphic')->after('id');
            $table->dropUnique(['name']);
            $table->unique(['library_type', 'name']);
            $table->index('library_type');
        });

        // images テーブルに library_type を追加
        Schema::table('images', function (Blueprint $table) {
            $table->enum('library_type', ['graphic', 'spatial'])->default('graphic')->after('id');
            $table->index('library_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('genres', function (Blueprint $table) {
            $table->dropIndex(['library_type']);
            $table->dropUnique(['library_type', 'name']);
            $table->unique('name');
            $table->dropColumn('library_type');
        });

        Schema::table('tags', function (Blueprint $table) {
            $table->dropIndex(['library_type']);
            $table->dropUnique(['library_type', 'name']);
            $table->unique('name');
            $table->dropColumn('library_type');
        });

        Schema::table('images', function (Blueprint $table) {
            $table->dropIndex(['library_type']);
            $table->dropColumn('library_type');
        });
    }
};
