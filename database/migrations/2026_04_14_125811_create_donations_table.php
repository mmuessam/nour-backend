<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('donations')) return;
        Schema::create('donations', function (Blueprint $table) {
            $table->id();
            $table->string('donation_number')->unique(); // DON-001
            $table->foreignId('case_id')->constrained('cases')->onDelete('cascade');
            $table->unsignedBigInteger('amount');
            $table->enum('source', ['organization', 'external', 'admin', 'volunteer'])->default('external');
            $table->string('source_name');
            $table->string('method')->default('تحويل بنكي');
            $table->date('date');
            $table->foreignId('added_by')->constrained('users')->onDelete('restrict');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('donations');
    }
};
