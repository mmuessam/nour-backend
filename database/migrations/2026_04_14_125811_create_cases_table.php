<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('cases')) return;
        Schema::create('cases', function (Blueprint $table) {
            $table->id();
            $table->string('case_number')->unique(); // NR-2024-0001
            $table->string('title');
            $table->foreignId('category_id')->constrained('categories')->onDelete('restrict');
            $table->text('description')->nullable();
            $table->string('beneficiary')->nullable();
            $table->unsignedBigInteger('target')->default(0);
            $table->unsignedBigInteger('collected')->default(0);
            $table->enum('status', ['active', 'urgent', 'completed', 'paused'])->default('active');
            $table->enum('priority', ['low', 'medium', 'high', 'critical'])->default('medium');
            $table->string('location')->nullable();
            $table->string('image', 10)->nullable();
            $table->foreignId('created_by')->constrained('users')->onDelete('restrict');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cases');
    }
};
