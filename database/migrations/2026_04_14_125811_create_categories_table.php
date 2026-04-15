<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('categories')) return;
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('name');
            $table->string('icon', 10)->default('🤲');
            $table->string('color', 20)->default('#4B5563');
            $table->string('bg', 20)->default('#F1F5F9');
            $table->unsignedInteger('cases_count')->default(0);
            $table->unsignedBigInteger('collected')->default(0);
            $table->unsignedBigInteger('target')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
