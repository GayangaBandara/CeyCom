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
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->foreignId('parent_id')->nullable()->constrained('categories')->nullOnDelete();

            //Nested Set columns
            $table->unsignedInteger('lft');
            $table->unsignedInteger('rgt');
            $table->unsignedInteger('depth')->default(0);

            $table->boolean('is_active')->default(true);
            $table->timestamps();

            //Composite index: nested set range queries
            $table->index(['lft', 'rgt']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
