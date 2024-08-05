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
        Schema::create('projects', function (Blueprint $table) {
            $table->uuid('id');
            $table->string('title');
            $table->text('synopsis')->nullable();
            $table->integer('views')->default(0);
            $table->double('rating')->default(0.00);
            $table->integer('published_at')->nullable();
            $table->string('status');
            $table->foreignId('type_id')->constrained('types');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
