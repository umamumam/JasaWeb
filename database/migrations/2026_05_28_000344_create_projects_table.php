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
            $table->id();
            $table->unsignedBigInteger('github_id')->nullable()->unique();
            $table->string('name')->nullable();
            $table->string('title');
            $table->string('client')->nullable();
            $table->string('category')->nullable();
            $table->text('description')->nullable();
            $table->string('github_url')->nullable();
            $table->string('demo_url')->nullable();
            $table->string('image_path')->nullable();
            $table->json('tech')->nullable();
            $table->string('impact')->nullable();
            $table->text('wa_message')->nullable();
            $table->boolean('is_visible')->default(true);
            $table->integer('order_index')->default(0);
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
