<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('content_generations', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('content_type')->index();
            $table->string('topic')->nullable()->index();
            $table->text('keywords')->nullable();
            $table->string('audience')->nullable();
            $table->string('tone')->index();
            $table->text('instructions')->nullable();

            $table->longText('generated_content');

            $table->unsignedInteger('word_count')->default(0);

            $table->timestamps();

            // Optional: composite index (buat filter cepat)
            $table->index(['user_id', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('content_generations');
    }
};